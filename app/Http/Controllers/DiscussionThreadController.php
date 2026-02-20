<?php

namespace App\Http\Controllers;

use App\Events\DiscussionCommentAdded;
use App\Models\DiscussionComment;
use App\Models\DiscussionThread;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new discussion thread
     */
    public function store(Request $request, Submission $submission)
    {
        // Check if user has access to this submission
        $user = Auth::user();
        $hasAccess = false;

        // Author can access
        if ($submission->user_id === $user->id) {
            $hasAccess = true;
        }

        // Editors can access
        if (!$hasAccess && $user->hasJournalRole($submission->journal_id, ['editor', 'journal_manager', 'section_editor'])) {
            $hasAccess = true;
        }

        // Reviewers assigned to this submission can access
        if (!$hasAccess && $submission->reviews()->where('reviewer_id', $user->id)->exists()) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'You do not have permission to create discussion threads for this submission.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $thread = DiscussionThread::create([
            'submission_id' => $submission->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Discussion thread created successfully.');
    }

    /**
     * Add a comment to a thread
     */
    public function addComment(Request $request, DiscussionThread $thread)
    {
        // Check if user has access
        $user = Auth::user();
        $submission = $thread->submission;
        $hasAccess = false;

        // Author can access
        if ($submission->user_id === $user->id) {
            $hasAccess = true;
        }

        // Editors can access
        if (!$hasAccess && $user->hasJournalRole($submission->journal_id, ['editor', 'journal_manager', 'section_editor'])) {
            $hasAccess = true;
        }

        // Reviewers assigned to this submission can access
        if (!$hasAccess && $submission->reviews()->where('reviewer_id', $user->id)->exists()) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'You do not have permission to comment on this thread.');
        }

        if ($thread->is_locked) {
            return redirect()->back()->with('error', 'This discussion thread is locked.');
        }

        $request->validate([
            'comment' => 'required|string|max:5000',
            'is_internal' => 'nullable|boolean',
        ]);

        $comment = DiscussionComment::create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'comment' => $request->comment,
            'is_internal' => $request->is_internal ?? false,
        ]);

        // Fire event for email notification
        event(new DiscussionCommentAdded($submission, $request->comment, $user));

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    /**
     * Lock/Unlock a thread (editors only)
     */
    public function toggleLock(DiscussionThread $thread)
    {
        $user = Auth::user();
        $submission = $thread->submission;

        // Only editors can lock/unlock
        if (!$user->hasJournalRole($submission->journal_id, ['editor', 'journal_manager', 'section_editor'])) {
            abort(403, 'Only editors can lock/unlock discussion threads.');
        }

        $thread->update([
            'is_locked' => !$thread->is_locked,
        ]);

        $message = $thread->is_locked ? 'Thread locked.' : 'Thread unlocked.';
        return redirect()->back()->with('success', $message);
    }
}
