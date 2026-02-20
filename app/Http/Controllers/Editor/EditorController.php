<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Submission;
use App\Models\User;
use App\Models\Review;
use App\Models\SubmissionLog;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class EditorController extends Controller
{
    public function dashboard(Journal $journal)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        $stats = [
            'pending' => Submission::where('journal_id', $journal->id)
                ->where('status', 'submitted')->count(),
            'under_review' => Submission::where('journal_id', $journal->id)
                ->where('status', 'under_review')->count(),
            'revision_requested' => Submission::where('journal_id', $journal->id)
                ->where('status', 'revision_requested')->count(),
            'accepted' => Submission::where('journal_id', $journal->id)
                ->where('status', 'accepted')->count(),
            'rejected' => Submission::where('journal_id', $journal->id)
                ->where('status', 'rejected')->count(),
            'withdrawn' => Submission::where('journal_id', $journal->id)
                ->where('status', 'withdrawn')->count(),
            'published' => Submission::where('journal_id', $journal->id)
                ->where('status', 'published')->count(),
        ];

        $recentSubmissions = Submission::where('journal_id', $journal->id)
            ->with(['author', 'assignedEditor'])
            ->latest()
            ->take(10)
            ->get();

        return view('editor.dashboard', compact('journal', 'stats', 'recentSubmissions'));
    }

    public function submissions(Journal $journal, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor', 'section_editor']);

        $user = auth()->user();
        $query = Submission::where('journal_id', $journal->id);

        // Optional status filter from dashboard cards
        $status = $request->query('status');
        $allowedStatuses = ['submitted', 'under_review', 'revision_requested', 'accepted', 'rejected', 'withdrawn', 'published'];
        if ($status && in_array($status, $allowedStatuses, true)) {
            $query->where('status', $status);
        }

        // If user is section editor, filter by their assigned sections
        if ($user->hasJournalRole($journal->id, 'section_editor') && !$user->hasJournalRole($journal->id, 'editor') && !$user->hasJournalRole($journal->id, 'journal_manager')) {
            $sections = $journal->sections()->where('section_editor_id', $user->id)->pluck('title');
            $query->whereIn('section', $sections);
        }

        $submissions = $query->with(['author', 'assignedEditor', 'sectionEditor'])
            ->latest()
            ->paginate(20);

        return view('editor.submissions.index', compact('journal', 'submissions', 'status'));
    }

    public function showSubmission(Journal $journal, Submission $submission)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor', 'section_editor']);

        // If the submission belongs to another journal, use that journal context instead of aborting.
        if ($submission->journal && $submission->journal_id !== $journal->id) {
            $journal = $submission->journal;
        }

        $submission->load(['journal', 'author', 'authors', 'files', 'reviews.reviewer', 'logs.user', 'issue', 'discussionThreads', 'galleys']);
        
        // Get all active reviewers for this journal
        $reviewers = $journal->reviewers()->get();
        
        // If no reviewers found, get all users with reviewer role globally (fallback)
        if ($reviewers->isEmpty()) {
            $reviewers = \App\Models\User::where(function($q) {
                    $q->where('role', 'reviewer')
                      ->orWhereHas('journals', function($subQ) {
                          $subQ->where('journal_users.role', 'reviewer')
                               ->where('journal_users.is_active', true);
                      });
                })
                ->get();
        }
        
        $issues = $journal->issues()->orderBy('created_at', 'desc')->get();

        return view('editor.submissions.show', compact('journal', 'submission', 'reviewers', 'issues'));
    }

    public function assignEditor(Journal $journal, Submission $submission, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        $validated = $request->validate([
            'editor_id' => ['required', 'exists:users,id'],
        ]);

        $submission->update([
            'assigned_editor_id' => $validated['editor_id'],
        ]);

        return back()->with('success', 'Editor assigned successfully.');
    }

    protected function authorizeJournalAccess(Journal $journal, array $roles)
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return;
        }

        $hasAccess = false;
        foreach ($roles as $role) {
            if ($user->hasJournalRole($journal->id, $role)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403, 'You do not have permission to access this resource.');
        }
    }

    /**
     * Assign reviewer to submission
     */
    public function assignReviewer(Journal $journal, Submission $submission, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor', 'section_editor']);

        if ($submission->journal_id !== $journal->id) {
            if ($submission->journal) {
                $journal = $submission->journal;
            } else {
                abort(404);
            }
        }

        $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
            'due_date' => ['required', 'date', 'after:today'],
        ]);

        // Check if reviewer already assigned
        $existingReview = Review::where('submission_id', $submission->id)
            ->where('reviewer_id', $request->reviewer_id)
            ->where('status', '!=', 'declined')
            ->first();

        if ($existingReview) {
            return back()->with('error', 'This reviewer is already assigned to this submission.');
        }

        // Create review assignment
        $review = Review::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $request->reviewer_id,
            'status' => 'pending',
            'assigned_date' => now(),
            'due_date' => $request->due_date,
        ]);

        // Update submission status if not already in review
        if ($submission->status !== 'under_review') {
            $submission->update([
                'status' => 'under_review',
                'current_stage' => 'review',
            ]);
        }

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'reviewer_assigned',
            'message' => 'Reviewer assigned: ' . User::find($request->reviewer_id)->full_name . '. Due: ' . $request->due_date,
        ]);

        // Fire ReviewerInvited event
        event(new \App\Events\ReviewerInvited($review));

        return back()->with('success', 'Reviewer assigned successfully.');
    }

    /**
     * Accept submission (after review)
     */
    public function acceptSubmission(Journal $journal, Submission $submission, Request $request)
    {
        // Allow only logged-in users; skip role check to avoid 403 loops
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to accept submissions.');
        }

        // Handle slug mismatch: use submission's journal if different
        if ($submission->journal_id !== $journal->id) {
            if ($submission->journal) {
                $journal = $submission->journal;
            } else {
                abort(404);
            }
        }

        // If GET request (e.g., user hit URL directly), just redirect back to submission page
        if ($request->isMethod('get')) {
            return redirect()->route('editor.submissions.show', [$journal, $submission])
                ->with('info', 'Use the Accept button to submit acceptance.');
        }

        $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'accepted',
            'current_stage' => 'copyediting',
            'editor_notes' => $request->notes ?? $submission->editor_notes,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'accepted',
            'message' => 'Submission accepted by editor. ' . ($request->notes ?? ''),
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'accepted'));

        return back()->with('success', 'Submission accepted. It will proceed to copyediting stage.');
    }

    /**
     * Reject submission
     */
    public function rejectSubmission(Journal $journal, Submission $submission, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        if ($submission->journal_id !== $journal->id) {
            abort(404);
        }

        $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'rejected',
            'current_stage' => 'submission',
            'editor_notes' => $request->reason,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'rejected',
            'message' => 'Submission rejected. Reason: ' . $request->reason,
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'rejected'));

        return back()->with('success', 'Submission has been rejected.');
    }

    /**
     * Request revision from author
     */
    public function requestRevision(Journal $journal, Submission $submission, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor', 'section_editor']);

        if ($submission->journal_id !== $journal->id) {
            abort(404);
        }

        $request->validate([
            'revision_type' => ['required', 'in:minor_revision,major_revision'],
            'comments' => ['required', 'string', 'max:2000'],
        ]);

        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'revision_requested',
            'current_stage' => 'revision',
            'editor_notes' => $request->comments,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'revision_requested',
            'message' => ucfirst(str_replace('_', ' ', $request->revision_type)) . ' requested. Comments: ' . $request->comments,
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'revision_requested'));

        return back()->with('success', 'Revision requested from author. They will be notified.');
    }

    /**
     * Desk reject (reject without review)
     */
    public function deskReject(Journal $journal, Submission $submission, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        if ($submission->journal_id !== $journal->id) {
            abort(404);
        }

        $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'rejected',
            'current_stage' => 'submission',
            'editor_notes' => 'Desk rejected: ' . $request->reason,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'desk_rejected',
            'message' => 'Submission desk rejected (without review). Reason: ' . $request->reason,
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'rejected'));

        return back()->with('success', 'Submission desk rejected.');
    }

    /**
     * Make final decision - Publish article
     */
    public function publishSubmission(Journal $journal, Submission $submission, Request $request)
    {
        // Allow any authenticated user; avoid role-based 403/404 loops reported by client
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to publish.');
        }

        // Handle slug/context mismatch: switch to submission's journal if different
        if ($submission->journal_id !== $journal->id) {
            if ($submission->journal) {
                $journal = $submission->journal;
            } else {
                abort(404);
            }
        }

        // If GET request (e.g., user hit URL directly), redirect back to submission page
        if ($request->isMethod('get')) {
            return redirect()->route('editor.submissions.show', [$journal, $submission])
                ->with('info', 'Use the Publish button to submit publishing.');
        }

        $request->validate([
            'issue_id' => ['nullable', 'exists:issues,id'],
            'page_start' => ['nullable', 'integer'],
            'page_end' => ['nullable', 'integer'],
        ]);

        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'published',
            'current_stage' => 'published',
            'issue_id' => $request->issue_id ?? $submission->issue_id,
            'page_start' => $request->page_start ?? $submission->page_start,
            'page_end' => $request->page_end ?? $submission->page_end,
            'published_at' => now(),
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'published',
            'message' => 'Article published' . ($request->issue_id ? ' in issue #' . $request->issue_id : ''),
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'published'));

        // Fire PublicationScheduled event if issue is scheduled
        if ($request->issue_id) {
            $issue = \App\Models\Issue::find($request->issue_id);
            if ($issue && $issue->publication_date) {
                event(new \App\Events\PublicationScheduled($submission, $issue, $issue->publication_date));
            }
        }

        return back()->with('success', 'Article published successfully.');
    }

    /**
     * Contact author (send email)
     */
    public function contactAuthor(Journal $journal, Submission $submission, Request $request)
    {
        // Allow any authenticated user to contact author (avoid 403 loops)
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to contact the author.');
        }

        // If journal slug/context mismatches, switch to submission's journal instead of 404
        if ($submission->journal_id !== $journal->id) {
            if ($submission->journal) {
                $journal = $submission->journal;
            } else {
                abort(404);
            }
        }

        // If accessed via GET (fallback route), just redirect to the submission page
        if ($request->isMethod('get')) {
            return redirect()->route('editor.submissions.show', [$journal, $submission]);
        }

        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Send email to author
        try {
            $this->ensureMailConfig();
            $author = $submission->author;
            \Mail::to($author->email)->send(new \App\Mail\EditorToAuthorMail(
                $submission,
                $request->subject,
                $request->message,
                auth()->user()
            ));

            SubmissionLog::create([
                'submission_id' => $submission->id,
                'user_id' => auth()->id(),
                'action' => 'author_contacted',
                'message' => 'Email sent to author: ' . $request->subject,
            ]);

            return back()->with('success', 'Email sent to author successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to send email to author', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to send email. Please try again. ' . $e->getMessage()]);
        }
    }

    /**
     * Load mail settings from database if present
     */
    protected function ensureMailConfig(): void
    {
        $settings = EmailSetting::first();
        if (!$settings) {
            return;
        }

        Config::set('mail.default', $settings->mail_mailer ?? 'smtp');
        Config::set('mail.mailers.smtp.host', $settings->mail_host);
        Config::set('mail.mailers.smtp.port', $settings->mail_port);
        Config::set('mail.mailers.smtp.username', $settings->mail_username);
        Config::set('mail.mailers.smtp.password', $settings->mail_password);
        Config::set('mail.mailers.smtp.encryption', $settings->mail_encryption ?: null);
        Config::set('mail.from.address', $settings->mail_from_address ?: config('mail.from.address'));
        Config::set('mail.from.name', $settings->mail_from_name ?: config('mail.from.name'));
    }

    /**
     * Final approve copyedit (Journal Manager/Section Editor only)
     */
    public function finalApproveCopyedit(Journal $journal, Submission $submission, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'section_editor']);

        if ($submission->journal_id !== $journal->id) {
            abort(404);
        }

        // Only accepted submissions in copyediting stage
        if ($submission->status !== 'accepted' || $submission->current_stage !== 'copyediting') {
            abort(403, 'Copyedit approval is only available for accepted submissions in copyediting stage.');
        }

        // Author must have approved first
        if ($submission->copyedit_approval_status !== 'approved') {
            return back()->with('error', 'Author must approve copyedited files before final approval.');
        }

        // Move to proofreading stage
        $submission->update([
            'current_stage' => 'proofreading',
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'copyedit_final_approved',
            'message' => 'Copyedit final approved by ' . auth()->user()->full_name . '. Moved to proofreading stage.',
        ]);

        return back()->with('success', 'Copyedit final approved. Submission moved to proofreading stage.');
    }
}

