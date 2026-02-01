<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CopyeditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Which tab was clicked (for UI + simple filtering)
        $statusFilter = $request->query('status'); // pending | in_progress | completed | null

        // Get journal IDs where user has copyeditor role
        $journalIds = $user->journals()
            ->wherePivot('role', 'copyeditor')
            ->wherePivot('is_active', true)
            ->pluck('journals.id');

        $query = Submission::where('current_stage', 'copyediting')
            ->where('status', 'accepted');

        // Rule: If user has global 'copyeditor' or 'admin' role, show all journals
        // Otherwise, filter by journal assignments
        if (!in_array($user->role, ['copyeditor', 'admin'])) {
            $query->whereIn('journal_id', $journalIds);
        }

        $allSubmissions = $query->with(['journal', 'author', 'files'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Simple derived statuses based on uploaded copyedited file:
        // - completed: has at least one file_type = copyedited_manuscript
        // - pending: no copyedited file yet (we treat "in progress" same as pending for now)
        $completedSubmissions = $allSubmissions->filter(function ($submission) {
            return $submission->files
                ->where('file_type', 'copyedited_manuscript')
                ->count() > 0;
        });
        $pendingSubmissions = $allSubmissions->diff($completedSubmissions);

        // Counts for cards
        $completedCount = $completedSubmissions->count();
        $pendingCount = $pendingSubmissions->count();
        $inProgressCount = 0; // No explicit tracking yet
        $totalCount = $allSubmissions->count();

        // Filter list for table based on clicked tab
        if ($statusFilter === 'completed') {
            $submissions = $completedSubmissions;
        } elseif ($statusFilter === 'pending' || $statusFilter === 'in_progress') {
            // Treat "in progress" same as pending until we have a dedicated field
            $submissions = $pendingSubmissions;
        } else {
            $submissions = $allSubmissions;
        }

        return view('copyeditor.dashboard', compact(
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
        // Check if user has copyeditor role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'copyeditor')) {
            abort(403, 'You do not have permission to view this submission.');
        }

        // IMPORTANT: Copyeditor can ONLY work on ACCEPTED articles
        if ($submission->status !== 'accepted') {
            abort(403, 'Copyediting is only available for accepted articles. This submission status is: ' . ucfirst(str_replace('_', ' ', $submission->status)));
        }

        // If submission has moved to proofreading stage, redirect to dashboard with message
        if ($submission->current_stage !== 'copyediting') {
            return redirect()->route('copyeditor.dashboard')
                ->with('info', 'This submission has been moved to ' . ucfirst(str_replace('_', ' ', $submission->current_stage)) . ' stage and is no longer available for copyediting.');
        }

        $submission->load(['journal', 'author', 'files', 'logs']);

        return view('copyeditor.submission', compact('submission'));
    }

    public function uploadCopyeditedFile(Request $request, Submission $submission)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $path = $file->store('submissions/copyedited', 'public');

        // Create file record
        $submission->files()->create([
            'file_type' => 'copyedited_manuscript',
            'file_path' => $path,
            'file_name' => basename($path),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        // Log action
        // Note: some production databases store `metadata` as TEXT, so we JSON-encode the array
        // to avoid "Array to string conversion" errors.
        $submission->logs()->create([
            'user_id' => Auth::id(),
            'action' => 'copyedited_file_uploaded',
            'message' => 'Copyedited manuscript uploaded. Waiting for author approval.',
            'metadata' => json_encode([
                'file' => $file->getClientOriginalName(),
                'notes' => $request->notes,
            ]),
        ]);

        // CORRECT WORKFLOW: Set approval status to 'pending' and wait for author approval
        // Step 1: Copyeditor uploads file → Status: pending (author needs to approve)
        // Step 2: Author approves → Status: approved (editor needs to final approve)
        // Step 3: Editor final approves → Stage: proofreading
        $submission->update([
            'copyedit_approval_status' => 'pending', // Changed from 'approved' to 'pending'
            'copyedit_approved_at' => null, // Clear approval timestamp
            'copyedit_approved_by' => null, // Clear approval user
            // Keep current_stage as 'copyediting' - don't move to proofreading yet
        ]);

        // Fire CopyeditFilesReady event to notify author and editors
        // This will send email notification to author that copyedited files are ready for review
        try {
            event(new \App\Events\CopyeditFilesReady($submission));
        } catch (\Exception $e) {
            // Log error but don't fail the upload
            \Log::error('CopyeditFilesReady event failed: ' . $e->getMessage());
        }

        // Redirect back to submission page (submission still in copyediting stage)
        return redirect()->back()->with('success', 'Copyedited file uploaded successfully! Author will be notified to review and approve the copyedited files.');
    }

    /**
     * Download submission file
     */
    public function downloadFile(Submission $submission, SubmissionFile $file)
    {
        // Check if user has copyeditor role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'copyeditor')) {
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

