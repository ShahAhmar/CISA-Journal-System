<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\SubmissionContent;
use App\Models\PlagiarismReport;

class PlagiarismService
{
    private const SHINGLE_SIZE = 5;

    /**
     * Run the plagiarism check for a submission.
     */
    public function check(Submission $submission)
    {
        $report = PlagiarismReport::firstOrCreate(['submission_id' => $submission->id]);
        $report->update(['status' => 'processing', 'error_message' => null]);

        try {
            $content = $submission->submissionContent;
            if (!$content) {
                throw new \Exception('Submission content not found. Extract text first.');
            }

            $currentShingles = $this->getShingles($content->content);
            // Store shingles as associative array (md5 => text) to preserve keys for calculation
            $content->update(['processed_content' => json_encode($currentShingles)]);

            // 2. Find other submissions across the entire system (system-wide check)
            $others = Submission::where('id', '!=', $submission->id)
                ->whereHas('submissionContent')
                ->with(['submissionContent', 'journal'])
                ->get();

            $matches = [];
            $maxSimilarity = 0;
            $allHighlights = [];

            foreach ($others as $other) {
                $otherShingles = json_decode($other->submissionContent->processed_content, true) ?: $this->getShingles($other->submissionContent->content);

                $similarity = $this->calculateSimilarity($currentShingles, $otherShingles);

                if ($similarity > 0.03) { // 3% threshold for detailed logging
                    // Identify matching shingle text for evidence
                    $intersection = array_intersect_key($currentShingles, $otherShingles);
                    $evidence = array_slice(array_values($intersection), 0, 3); // Take top 3 matching snippets

                    $matches[] = [
                        'submission_id' => $other->id,
                        'title' => $other->title,
                        'journal_name' => $other->journal->title,
                        'percentage' => round($similarity * 100, 2),
                        'evidence' => $evidence
                    ];

                    if ($similarity > $maxSimilarity) {
                        $maxSimilarity = $similarity;
                    }

                    // Collect global highlights
                    foreach ($evidence as $snippet) {
                        $allHighlights[] = $snippet;
                    }
                }
            }

            // Sort matches by percentage descending
            usort($matches, fn($a, $b) => $b['percentage'] <=> $a['percentage']);

            $report->update([
                'similarity_percentage' => round($maxSimilarity * 100, 2),
                'matched_submissions' => $matches,
                'highlighted_matches' => array_unique(array_slice($allHighlights, 0, 10)),
                'status' => 'completed'
            ]);

            return $report;
        } catch (\Exception $e) {
            $report->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Convert text into a set of shingles (n-grams of words).
     */
    public function getShingles(string $text): array
    {
        // Preprocess: lowercase, remove punctuation, normalize spaces
        $clean = strtolower(preg_replace('/[^\p{L}\p{N}\s]/u', '', $text));
        $words = preg_split('/\s+/', $clean, -1, PREG_SPLIT_NO_EMPTY);

        $shingles = [];
        $count = count($words);

        for ($i = 0; $i <= $count - self::SHINGLE_SIZE; $i++) {
            $shingle = implode(' ', array_slice($words, $i, self::SHINGLE_SIZE));
            $shingles[md5($shingle)] = $shingle;
        }

        return $shingles;
    }

    /**
     * Calculate Jaccard Similarity between two sets of shingles.
     */
    private function calculateSimilarity(array $shinglesA, array $shinglesB): float
    {
        if (empty($shinglesA) || empty($shinglesB)) {
            return 0;
        }

        // Use array keys (MD5 hashes) for intersection/union as it's faster
        // Ensure both are associative (if coming from JSON they might be numeric if not careful)
        $keysA = array_keys($shinglesA);
        $keysB = array_keys($shinglesB);

        // If one is numeric (0,1,2...), compute hashes on the fly
        // This covers existing records that might be corrupted or in wrong format
        if (is_int($keysA[0] ?? null)) {
            $keysA = array_map('md5', array_values($shinglesA));
        }
        if (is_int($keysB[0] ?? null)) {
            $keysB = array_map('md5', array_values($shinglesB));
        }

        $intersection = count(array_intersect($keysA, $keysB));
        $union = count(array_unique(array_merge($keysA, $keysB)));

        return $union > 0 ? ($intersection / $union) : 0;
    }
}
