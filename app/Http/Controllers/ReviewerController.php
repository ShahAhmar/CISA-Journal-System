<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReviewerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Determine if current user can access given review.
     * Allows:
     * - Assigned reviewer
     * - Admin
     * - Users with journal-level roles (editor, section_editor, journal_manager, reviewer)
     */
    protected function canAccessReview(Review $review): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        // Directly assigned reviewer
        if ($review->reviewer_id === $user->id) {
            return true;
        }

        // Admins always allowed
        if (property_exists($user, 'is_admin') && $user->is_admin) {
            return true;
        }

        // If submission/journal exists, allow journal-level roles
        $submission = $review->submission;
        if ($submission && $submission->journal_id && method_exists($user, 'hasJournalRole')) {
            if ($user->hasJournalRole($submission->journal_id, ['editor', 'section_editor', 'journal_manager', 'reviewer'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Reviewer Dashboard - Shows only assigned reviews (double-blind)
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Get reviews assigned to this reviewer
        $allReviews = Review::where('reviewer_id', $user->id)
            ->with(['submission.journal', 'submission.files', 'previousReview'])
            ->orderBy('assigned_date', 'desc')
            ->get();
        
        // Compute stats from full collection
        $overdueReviews = $allReviews->filter(function($review) {
            // Only check overdue for pending or in_progress reviews
            if (!in_array($review->status, ['pending', 'in_progress'])) {
                return false;
            }
            
            if (!$review->due_date) {
                return false;
            }
            
            try {
                if ($review->due_date instanceof \Carbon\Carbon) {
                    $dueDate = $review->due_date;
                } elseif (is_string($review->due_date)) {
                    $dueDate = \Carbon\Carbon::parse($review->due_date);
                } else {
                    return false;
                }
                
                return $dueDate->isPast();
            } catch (\Exception $e) {
                Log::warning("Failed to parse due_date for review ID {$review->id}: " . $e->getMessage());
                return false;
            }
        });
        
        $stats = [
            'pending' => $allReviews->where('status', 'pending')->count(),
            'in_progress' => $allReviews->where('status', 'in_progress')->count(),
            'completed' => $allReviews->where('status', 'completed')->count(),
            'declined' => $allReviews->where('status', 'declined')->count(),
            'total' => $allReviews->count(),
            'overdue' => $overdueReviews->count(),
        ];

        // Apply filter for table based on status param
        $statusFilter = $request->get('status');
        $reviews = $allReviews;

        if ($statusFilter && $statusFilter !== 'all') {
            if ($statusFilter === 'overdue') {
                $reviews = $overdueReviews;
            } else {
                $reviews = $allReviews->where('status', $statusFilter);
            }
        }
        
        return view('reviewer.dashboard', [
            'reviews' => $reviews,
            'stats' => $stats,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Step 1: Initial Review - Accept/Decline
     */
    public function showInitialReview(Review $review)
    {
        // Ensure user is allowed to access this review
        if (!$this->canAccessReview($review)) {
            abort(403, 'You do not have permission to access this review.');
        }

        // Only show if status is pending
        if ($review->status !== 'pending') {
            return redirect()->route('reviewer.review.show', $review)
                ->with('info', 'You have already responded to this review request.');
        }

        $submission = $review->submission()->with(['journal', 'files', 'journalSection'])->first();
        
        // Double-blind: Hide author info
        $submission->load(['authors' => function($query) {
            // Don't load author details for reviewers
        }]);

        return view('reviewer.initial-review', compact('review', 'submission'));
    }

    /**
     * Accept Review Request
     */
    public function acceptReview(Review $review, Request $request)
    {
        if (!$this->canAccessReview($review)) {
            abort(403);
        }

        if ($review->status !== 'pending') {
            return back()->with('error', 'Review request already processed.');
        }

        $review->update([
            'status' => 'in_progress',
        ]);

        SubmissionLog::create([
            'submission_id' => $review->submission_id,
            'user_id' => Auth::id(),
            'action' => 'review_accepted',
            'message' => 'Reviewer accepted the review request.',
        ]);

        // Notify editors
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('notifications')) {
                $submission = $review->submission;
                $journal = $submission->journal;
                $editors = $journal->users()
                    ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
                    ->wherePivot('is_active', true)
                    ->get();
                
                foreach ($editors as $editor) {
                    $editor->notify(new \App\Notifications\ReviewerResponseNotification($review, 'accepted'));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to send notification (table may not exist): ' . $e->getMessage());
        }

        return redirect()->route('reviewer.review.show', $review)
            ->with('success', 'Review request accepted. You can now proceed with your review.');
    }

    /**
     * Decline Review Request
     */
    public function declineReview(Review $review, Request $request)
    {
        if (!$this->canAccessReview($review)) {
            abort(403);
        }

        $request->validate([
            'decline_reason' => 'required|string|max:1000',
        ]);

        if ($review->status !== 'pending') {
            return back()->with('error', 'Review request already processed.');
        }

        $review->update([
            'status' => 'declined',
            'decline_reason' => $request->decline_reason,
        ]);

        SubmissionLog::create([
            'submission_id' => $review->submission_id,
            'user_id' => Auth::id(),
            'action' => 'review_declined',
            'message' => 'Reviewer declined the review request: ' . $request->decline_reason,
        ]);

        // Notify editors
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('notifications')) {
                $submission = $review->submission;
                $journal = $submission->journal;
                $editors = $journal->users()
                    ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
                    ->wherePivot('is_active', true)
                    ->get();
                
                foreach ($editors as $editor) {
                    $editor->notify(new \App\Notifications\ReviewerResponseNotification($review, 'declined', $request->decline_reason));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to send notification (table may not exist): ' . $e->getMessage());
        }

        return redirect()->route('reviewer.dashboard')
            ->with('success', 'Review request declined.');
    }

    /**
     * Step 2: Perform Review
     */
    public function showReview(Review $review)
    {
        if (!$this->canAccessReview($review)) {
            abort(403);
        }

        if ($review->status === 'pending') {
            return redirect()->route('reviewer.initial-review.show', $review);
        }

        if ($review->status === 'completed') {
            return view('reviewer.review-completed', compact('review'));
        }

        $submission = $review->submission()->with([
            'journal',
            'files',
            'journalSection',
            'references'
        ])->first();

        // Double-blind: Ensure no author info is loaded
        $submission->makeHidden(['author', 'authors']);

        return view('reviewer.perform-review', compact('review', 'submission'));
    }

    /**
     * Submit Review
     */
    public function submitReview(Review $review, Request $request)
    {
        if (!$this->canAccessReview($review)) {
            abort(403);
        }

        if ($review->status === 'completed') {
            return back()->with('error', 'Review already submitted.');
        }

        $request->validate([
            'recommendation' => 'required|in:accept,minor_revision,major_revision,resubmit,resubmit_elsewhere,decline,see_comments',
            'comments_for_editor' => 'nullable|string|max:5000',
            'comments_for_author' => 'nullable|string|max:5000',
            'comments_for_editors' => 'nullable|string|max:5000',
            'comments_for_authors' => 'nullable|string|max:5000',
            'annotated_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        // Calculate review time - safely parse assigned_date
        $reviewTimeDays = 0;
        if ($review->assigned_date) {
            try {
                $assignedDate = $review->assigned_date instanceof \Carbon\Carbon
                    ? $review->assigned_date
                    : \Carbon\Carbon::parse($review->assigned_date);
                $reviewTimeDays = $assignedDate->diffInDays(now());
            } catch (\Exception $e) {
                Log::warning("Failed to parse assigned_date for review ID {$review->id}: " . $e->getMessage());
                $reviewTimeDays = 0;
            }
        }

        $reviewData = [
            'status' => 'completed',
            'recommendation' => $request->recommendation,
            'comments_for_editor' => $request->comments_for_editor,
            'comments_for_author' => $request->comments_for_author,
            'comments_for_editors' => $request->comments_for_editors,
            'comments_for_authors' => $request->comments_for_authors,
            'submitted_date' => now(),
            'reviewed_at' => now(),
            'review_time_days' => $reviewTimeDays,
        ];

        $review->update($reviewData);

        // Handle annotated file upload
        if ($request->hasFile('annotated_file')) {
            $file = $request->file('annotated_file');
            $filename = 'review_' . $review->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('reviews/annotated', $filename, 'public');
            
            \App\Models\ReviewFile::create([
                'review_id' => $review->id,
                'file_path' => $path,
                'file_name' => $filename,
                'file_type' => 'annotated',
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        // Log review submission
        SubmissionLog::create([
            'submission_id' => $review->submission_id,
            'user_id' => Auth::id(),
            'action' => 'review_submitted',
            'message' => 'Review submitted with recommendation: ' . ucfirst(str_replace('_', ' ', $request->recommendation)),
        ]);

        // Update submission status based on recommendation
        $submission = $review->submission;
        $oldStatus = $submission->status;
        $newStatus = null;

        // Auto-update submission status based on reviewer recommendation
        if (in_array($request->recommendation, ['minor_revision', 'major_revision'])) {
            $newStatus = 'revision_requested';
            
            // Prepare revision comments - prioritize comments_for_author, fallback to comments_for_editors
            $revisionComments = $request->comments_for_author 
                ?: $request->comments_for_authors 
                ?: $request->comments_for_editor 
                ?: $request->comments_for_editors 
                ?: 'Revision requested based on reviewer feedback.';
            
            // Append reviewer name and recommendation type
            $revisionType = ucfirst(str_replace('_', ' ', $request->recommendation));
            $reviewerName = $review->reviewer->full_name ?? 'Reviewer';
            $fullComments = "{$revisionType} requested by {$reviewerName}.\n\n{$revisionComments}";
            
            $oldStatus = $submission->status;
            $oldStage = $submission->current_stage;
            
            $submission->update([
                'status' => 'revision_requested',
                'current_stage' => 'revision',
                'editor_notes' => $fullComments,
            ]);

            // Log the status change
            SubmissionLog::create([
                'submission_id' => $submission->id,
                'user_id' => Auth::id(),
                'action' => 'status_changed',
                'message' => "Status automatically changed to 'revision_requested' based on reviewer recommendation: {$revisionType}",
            ]);

            // Fire SubmissionStatusChanged event to notify author
            $submission->refresh();
            event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'revision_requested'));
        } elseif ($request->recommendation === 'accept') {
            // If reviewer recommends accept, keep status as under_review (editor makes final decision)
            // Don't auto-update to accepted, let editor decide
        } elseif (in_array($request->recommendation, ['decline', 'resubmit_elsewhere'])) {
            // If reviewer recommends decline, keep status as under_review (editor makes final decision)
            // Don't auto-reject, let editor decide
        }

        // Fire ReviewCompleted event (notifies editors)
        event(new \App\Events\ReviewCompleted($review));

        return redirect()->route('reviewer.review.show', $review)
            ->with('success', 'Thank you! Your review has been submitted successfully.');
    }

    /**
     * Download submission file (anonymized for reviewers)
     */
    public function downloadFile(Review $review, SubmissionFile $file)
    {
        if (!$this->canAccessReview($review)) {
            abort(403);
        }

        // Ensure file belongs to this submission
        if ($file->submission_id !== $review->submission_id) {
            abort(404);
        }

        // Double-blind: Don't show author info in filename
        $path = Storage::disk('public')->path($file->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        // Return anonymized filename
        $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
        $anonymizedName = 'manuscript_' . $file->id . '.' . $extension;

        return response()->download($path, $anonymizedName);
    }

    /**
     * View submission details modal (non-author metadata only)
     */
    public function getSubmissionDetails(Review $review)
    {
        if (!$this->canAccessReview($review)) {
            abort(403);
        }

        $submission = $review->submission()->with([
            'journal',
            'files',
            'journalSection',
            'references'
        ])->first();

        // Double-blind: Return only non-author metadata
        return response()->json([
            'title' => $submission->title,
            'abstract' => $submission->abstract,
            'keywords' => $submission->keywords,
            'submission_date' => $submission->formatSubmittedAt('F d, Y') ?? 'N/A',
            'journal' => $submission->journal->name,
            'section' => $submission->journalSection->name ?? 'N/A',
            'files' => $submission->files->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => 'File ' . $file->id, // Anonymized
                    'type' => $file->file_type,
                    'size' => $file->file_size,
                ];
            }),
            'references' => $submission->references->pluck('citation'),
        ]);
    }
}
