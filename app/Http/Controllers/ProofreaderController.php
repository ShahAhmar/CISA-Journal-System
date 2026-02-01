<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProofreaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Which tab was clicked (for UI + filtering)
        $statusFilter = $request->query('status'); // pending | in_progress | completed | null

        // Get journal IDs where user has proofreader role
        $journalIds = $user->journals()
            ->wherePivot('role', 'proofreader')
            ->wherePivot('is_active', true)
            ->pluck('journals.id');

        $query = Submission::where('current_stage', 'proofreading')
            ->where('status', 'accepted');

        // Rule: If user has global 'proofreader' or 'admin' role, include all journals
        if (!in_array($user->role, ['proofreader', 'admin'])) {
            // Only if NO journals assigned, return empty earlier
            if ($journalIds->isEmpty()) {
                return view('proofreader.dashboard', [
                    'submissions' => collect(),
                    'pendingCount' => 0,
                    'inProgressCount' => 0,
                    'completedCount' => 0,
                    'totalCount' => 0,
                    'statusFilter' => $statusFilter,
                ]);
            }
            $query->whereIn('journal_id', $journalIds);
        }

        // Proofreader works on accepted submissions in proofreading stage
        $allSubmissions = $query->with([
            'journal',
            'author',
            'files' => function ($query) {
                // Eager load files to ensure they're available
                $query->orderBy('created_at', 'desc');
            }
        ])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Debug: Log what we found
        \Log::info('Proofreader Dashboard Query (after journal filter)', [
            'journal_ids' => $journalIds->toArray(),
            'total_found' => $allSubmissions->count(),
            'submission_ids' => $allSubmissions->pluck('id')->toArray(),
            'submission_details' => $allSubmissions->map(function ($s) {
                return [
                    'id' => $s->id,
                    'title' => $s->title,
                    'journal_id' => $s->journal_id,
                ];
            })->toArray(),
        ]);

        // Derived statuses based on uploaded proofread file:
        // - completed: has at least one file_type = proofread_manuscript
        // - pending: no proofread file yet (we treat "in progress" same as pending for now)
        $completedSubmissions = collect();
        $pendingSubmissions = collect();

        foreach ($allSubmissions as $submission) {
            // Ensure files are loaded (use the collection, not query builder)
            if (!$submission->relationLoaded('files')) {
                $submission->load('files');
            }

            // Check if submission has proofread file using the collection
            $hasProofreadFile = $submission->files
                ->where('file_type', 'proofread_manuscript')
                ->isNotEmpty();

            if ($hasProofreadFile) {
                $completedSubmissions->push($submission);
            } else {
                $pendingSubmissions->push($submission);
            }

            // Debug logging for each submission
            \Log::debug('Proofreader: Submission status check', [
                'submission_id' => $submission->id,
                'title' => $submission->title,
                'has_proofread_file' => $hasProofreadFile,
                'file_types' => $submission->files->pluck('file_type')->toArray(),
                'file_count' => $submission->files->count(),
            ]);
        }

        // Debug logging
        \Log::info('Proofreader Dashboard Stats', [
            'total_submissions' => $allSubmissions->count(),
            'pending_count' => $pendingSubmissions->count(),
            'completed_count' => $completedSubmissions->count(),
            'journal_ids' => $journalIds->toArray(),
            'pending_ids' => $pendingSubmissions->pluck('id')->toArray(),
            'completed_ids' => $completedSubmissions->pluck('id')->toArray(),
        ]);

        // Counts for cards
        $completedCount = $completedSubmissions->count();
        $pendingCount = $pendingSubmissions->count();
        $inProgressCount = 0; // No explicit tracking yet
        $totalCount = $allSubmissions->count();

        // Filter list for table based on clicked tab
        if ($statusFilter === 'completed') {
            $submissions = $completedSubmissions;
        } elseif ($statusFilter === 'pending' || $statusFilter === 'in_progress') {
            $submissions = $pendingSubmissions;
        } else {
            $submissions = $allSubmissions;
        }

        return view('proofreader.dashboard', compact(
            'submissions',
            'pendingCount',
            'inProgressCount',
            'completedCount',
            'totalCount',
            'statusFilter',
        ));
    }

    public function show(Submission $submission)
    {
        // Check if user has proofreader role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'proofreader')) {
            abort(403, 'You do not have permission to view this submission.');
        }

        $submission->load(['journal', 'author', 'files', 'logs']);

        return view('proofreader.submission', compact('submission'));
    }

    public function uploadProofreadFile(Request $request, Submission $submission)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $path = $file->store('submissions/proofread', 'public');

        // Create file record
        $submission->files()->create([
            'file_type' => 'proofread_manuscript',
            'file_path' => $path,
            'file_name' => basename($path),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        // Log action
        // JSON-encode metadata to avoid "Array to string conversion" issues on some DB setups
        $submission->logs()->create([
            'user_id' => Auth::id(),
            'action' => 'proofread_file_uploaded',
            'message' => 'Proofread manuscript uploaded',
            'metadata' => json_encode([
                'file' => $file->getClientOriginalName(),
                'notes' => $request->notes,
            ]),
        ]);

        // Fire GalleyReadyForProduction event
        event(new \App\Events\GalleyReadyForProduction($submission));

        // Fire status change event for stage notification (if stage changed)
        try {
            $oldStatus = $submission->status;
            $submission->refresh();
            event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, $submission->status));
        } catch (\Exception $e) {
            \Log::error('Failed to fire SubmissionStatusChanged event in proofreader', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'Proofread file uploaded successfully!');
    }

    /**
     * Download submission file
     */
    public function downloadFile(Submission $submission, SubmissionFile $file)
    {
        // Check if user has proofreader role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'proofreader')) {
            abort(403, 'You do not have permission to download this file.');
        }

        // Ensure file belongs to this submission
        if ($file->submission_id !== $submission->id) {
            abort(404);
        }

        $path = storage_path('app/public/' . $file->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, $file->original_name ?? $file->file_name);
    }
}

