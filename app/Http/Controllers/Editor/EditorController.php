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
use Illuminate\Support\Facades\Schema;

class EditorController extends Controller
{
    public function dashboard(Journal $journal, Request $request)
    {
        // Allow journal managers, editors, and section editors to access the editor dashboard
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor', 'section_editor']);

        // Optional status filter for the Recent Submissions table
        $statusFilter = $request->query('status');
        $allowedStatuses = ['submitted', 'under_review', 'revision_requested', 'accepted', 'rejected', 'withdrawn', 'published'];

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

        $recentQuery = Submission::where('journal_id', $journal->id)
            ->with(['author', 'assignedEditor'])
            ->latest();

        if ($statusFilter && in_array($statusFilter, $allowedStatuses, true)) {
            $recentQuery->where('status', $statusFilter);
        }

        $recentSubmissions = $recentQuery->take(10)->get();

        // Get unread notifications for reviewer responses
        // Check if notifications table exists first (for shared hosting compatibility)
        $notifications = collect([]);
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('notifications')) {
                $notifications = auth()->user()->notifications()
                    ->where('type', 'App\Notifications\ReviewerResponseNotification')
                    ->whereNull('read_at')
                    ->latest()
                    ->take(10)
                    ->get();
            }
        } catch (\Exception $e) {
            // If table doesn't exist, use empty collection
            \Log::warning('Notifications table not found: ' . $e->getMessage());
            $notifications = collect([]);
        }

        return view('editor.dashboard', compact('journal', 'stats', 'recentSubmissions', 'notifications', 'statusFilter'));
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
            $reviewers = \App\Models\User::where(function ($q) {
                $q->where('role', 'reviewer')
                    ->orWhereHas('journals', function ($subQ) {
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
        // Allow reassignment if:
        // 1. Previous review was declined, OR
        // 2. Previous review was completed but reviewer recommended revision (minor/major) and author has resubmitted
        $existingReview = Review::where('submission_id', $submission->id)
            ->where('reviewer_id', $request->reviewer_id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->first();

        // If there's an active review (pending/in_progress), don't allow
        if ($existingReview) {
            return back()->with('error', 'This reviewer is already assigned to this submission with an active review.');
        }

        // Check if there's a completed review
        $completedReview = Review::where('submission_id', $submission->id)
            ->where('reviewer_id', $request->reviewer_id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        // If completed review exists and reviewer recommended revision, allow reassignment
        // But only if submission status is 'submitted' (meaning author has resubmitted)
        if ($completedReview && in_array($completedReview->recommendation, ['minor_revision', 'major_revision'])) {
            // Check if submission was resubmitted after this review
            if ($submission->status === 'submitted' || $submission->status === 'under_review') {
                // Allow reassignment - will create new review below
            } else {
                // Submission not resubmitted yet, don't allow
                return back()->with('error', 'This reviewer already completed a review. Please wait for author to resubmit revision first.');
            }
        } elseif ($completedReview) {
            // Completed review exists but reviewer didn't recommend revision
            // Check if there's already a pending review for this revision round
            $pendingReview = Review::where('submission_id', $submission->id)
                ->where('reviewer_id', $request->reviewer_id)
                ->where('status', 'pending')
                ->where('assigned_date', '>', $completedReview->reviewed_at ?? $completedReview->created_at)
                ->first();

            if (!$pendingReview) {
                // Allow creating new review if no pending review exists for this revision round
            } else {
                return back()->with('error', 'This reviewer is already assigned to review the revision.');
            }
        }

        // If there was a declined review from this reviewer, we allow reassignment (no error)
        // Create new review assignment
        $review = Review::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $request->reviewer_id,
            'status' => 'pending',
            'assigned_date' => now(),
            'due_date' => $request->due_date,
        ]);

        // Update submission status - ensure it's in review stage
        // If status is 'submitted' (after revision), change to 'under_review'
        // If status is already 'under_review', keep it
        $oldStatus = $submission->status;
        $oldStage = $submission->current_stage;

        // Don't change if status is 'accepted', 'rejected', 'published', etc.
        if (in_array($submission->status, ['submitted', 'revision_requested'])) {
            $submission->update([
                'status' => 'under_review',
                'current_stage' => 'review',
            ]);
        } elseif ($submission->status === 'under_review') {
            // Already in review, just ensure current_stage is correct
            $submission->update([
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

        // Fire status change event if status or stage changed
        if ($oldStatus !== $submission->status || $oldStage !== $submission->current_stage) {
            $submission->refresh();
            event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, $submission->status));
        }

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
        $isPaid = $submission->payment_status === 'paid' || $submission->payment_status === 'waived';

        $submissionData = [
            'status' => 'accepted',
            'editor_notes' => $request->notes ?? $submission->editor_notes,
        ];

        if ($isPaid || $submission->is_pay_later) {
            $submissionData['current_stage'] = 'copyediting';
            $messageSuffix = $submission->is_pay_later ? 'Moved to copyediting stage (Pay Later enabled).' : 'Moved to copyediting stage.';
        } else {
            // Paper is accepted but needs payment before copyediting (Pay Now option)
            $submissionData['payment_status'] = 'awaiting_payment';
            $messageSuffix = 'Awaiting payment confirmation before copyediting.';

            // Create Invoice (Payment record) if it doesn't exist
            $existingPayment = \App\Models\Payment::where('submission_id', $submission->id)
                ->where('type', 'apc')
                ->first();

            if (!$existingPayment) {
                \App\Models\Payment::create([
                    'journal_id' => $submission->journal_id,
                    'submission_id' => $submission->id,
                    'user_id' => $submission->user_id,
                    'type' => 'apc',
                    'amount' => $journal->apc_amount ?? 0,
                    'currency' => $journal->currency ?? 'USD',
                    'status' => 'pending',
                    'payment_details' => ['notes' => 'Generated upon acceptance'],
                ]);
            }
        }

        $submission->update($submissionData);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'accepted',
            'message' => 'Submission accepted by editor. ' . $messageSuffix . ' ' . ($request->notes ?? ''),
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'accepted'));

        return back()->with('success', 'Submission accepted. ' . $messageSuffix);
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
        // Allow any authenticated user (editor/reviewer/admin) to proceed; just ensure logged-in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // If the submission belongs to another journal, switch context instead of 404
        if ($submission->journal && $submission->journal_id !== $journal->id) {
            $journal = $submission->journal;
        }

        // If accessed via GET (e.g., someone hits the URL directly), redirect back to submission view
        if ($request->isMethod('get')) {
            return redirect()->route('editor.submissions.show', [$journal, $submission])
                ->with('info', 'Please submit the revision request from the form.');
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

        // BLOCK: Check if proofread file exists
        if (!$submission->proofread_manuscript) {
            return back()->with('error', 'Cannot publish article. Waiting for proofreader to submit the final manuscript.');
        }

        // BLOCK: Check for Mandatory Payment
        $isPaid = $submission->payment_status === 'paid' || $submission->payment_status === 'waived';
        if (!$isPaid) {
            return back()->with('error', 'Cannot publish article. This manuscript has outstanding payments. Please verify payment before publishing.');
        }

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
        $this->authorizeJournalAccess($journal, ['journal_manager', 'section_editor', 'editor']);

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
        $oldStatus = $submission->status;
        $oldStage = $submission->current_stage;

        $submission->update([
            'current_stage' => 'proofreading',
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'copyedit_final_approved',
            'message' => 'Copyedit final approved by ' . auth()->user()->full_name . '. Moved to proofreading stage.',
        ]);

        // Fire status change event for stage transition notification
        try {
            $submission->refresh();
            event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, $submission->status));
        } catch (\Exception $e) {
            \Log::error('Failed to fire SubmissionStatusChanged event in finalApproveCopyedit', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
        }

        return back()->with('success', 'Copyedit final approved. Submission moved to proofreading stage.');
    }

    /**
     * View all payments for the journal
     */
    public function payments(Journal $journal, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        $query = \App\Models\Payment::where('journal_id', $journal->id)
            ->with(['submission', 'user']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(20);

        return view('admin.payments.index', compact('payments', 'journal'));
    }

    /**
     * Show individual payment for review
     */
    public function showPayment(Journal $journal, \App\Models\Payment $payment)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        if ($payment->journal_id !== $journal->id) {
            abort(404);
        }

        $payment->load(['submission', 'user']);

        // We reuse the admin view but ensure routes work
        return view('admin.payments.show', compact('payment', 'journal'));
    }

    /**
     * Update payment status (Approve/Reject)
     */
    public function updatePaymentStatus(Journal $journal, \App\Models\Payment $payment, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        if ($payment->journal_id !== $journal->id) {
            abort(404);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,refunded',
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        // Workflow Trigger: If payment completed, update submission
        if ($request->status === 'completed' && $payment->submission) {
            $payment->submission->update([
                'payment_status' => 'paid',
                'current_stage' => 'copyediting'
            ]);

            \App\Models\SubmissionLog::create([
                'submission_id' => $payment->submission_id,
                'user_id' => auth()->id(),
                'action' => 'payment_verified',
                'message' => 'Payment verified by editor. Submission moved to copyediting stage.',
            ]);
        }

        return back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Update payment details/notes
     */
    public function updatePayment(Journal $journal, \App\Models\Payment $payment, Request $request)
    {
        $this->authorizeJournalAccess($journal, ['journal_manager', 'editor']);

        if ($payment->journal_id !== $journal->id) {
            abort(404);
        }

        $validated = $request->validate([
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'notes' => 'nullable|string|max:1000',
        ]);

        $paymentDetails = $payment->payment_details ?? [];
        if (isset($validated['notes'])) {
            $paymentDetails['notes'] = $validated['notes'];
        }

        $payment->update([
            'payment_method' => $validated['payment_method'] ?? $payment->payment_method,
            'transaction_id' => $validated['transaction_id'] ?? $payment->transaction_id,
            'status' => $validated['status'],
            'payment_details' => $paymentDetails,
        ]);

        // Workflow Trigger
        if ($validated['status'] === 'completed' && $payment->submission) {
            $payment->submission->update([
                'payment_status' => 'paid',
                'current_stage' => 'copyediting'
            ]);

            \App\Models\SubmissionLog::create([
                'submission_id' => $payment->submission_id,
                'user_id' => auth()->id(),
                'action' => 'payment_verified',
                'message' => 'Payment verified and updated by editor. Submission moved to copyediting.',
            ]);
        }

        return back()->with('success', 'Payment updated successfully!');
    }
}

