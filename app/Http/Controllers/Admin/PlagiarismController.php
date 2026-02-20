<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionContent;
use App\Models\PlagiarismReport;
use App\Services\TextExtractionService;
use App\Services\PlagiarismService;
use Illuminate\Http\Request;

class PlagiarismController extends Controller
{
    protected $textExtractionService;
    protected $plagiarismService;

    public function __construct(TextExtractionService $textExtractionService, PlagiarismService $plagiarismService)
    {
        $this->textExtractionService = $textExtractionService;
        $this->plagiarismService = $plagiarismService;
    }

    /**
     * Run the plagiarism check for a submission.
     */
    public function runCheck(Submission $submission)
    {
        \Log::info('Plagiarism check initiated for submission: ' . $submission->id);
        try {
            // 1. Ensure text is extracted
            $content = $submission->submissionContent;
            if (!$content) {
                $manuscript = $submission->manuscript;
                if (!$manuscript) {
                    return back()->with('error', 'No manuscript file found to check.');
                }

                $text = $this->textExtractionService->extractText($manuscript);
                if (empty(trim($text))) {
                    return back()->with('error', 'The manuscript appears to be empty or unreadable.');
                }

                $content = SubmissionContent::create([
                    'submission_id' => $submission->id,
                    'content' => $text
                ]);

                // Clear relationship cache so PlagiarismService sees the new content
                $submission->unsetRelation('submissionContent');
            }

            // 2. Run similarity check
            $this->plagiarismService->check($submission);

            return back()->with('success', 'Plagiarism check completed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Plagiarism check failed: ' . $e->getMessage());
        }
    }

    /**
     * View the plagiarism report.
     */
    public function showReport(Submission $submission)
    {
        $report = $submission->plagiarismReport;

        if (!$report) {
            return redirect()->route('admin.submissions.show', $submission)
                ->with('error', 'Plagiarism report not found. Run a check first.');
        }

        return view('admin.submissions.plagiarism-report', compact('submission', 'report'));
    }
}
