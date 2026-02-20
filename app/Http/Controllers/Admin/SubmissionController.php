<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Journal;
use App\Models\SubmissionLog;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::with(['journal', 'author', 'authors']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by journal
        if ($request->has('journal_id') && $request->journal_id) {
            $query->where('journal_id', $request->journal_id);
        }

        $submissions = $query->latest()->paginate(20);
        $journals = Journal::where('is_active', true)->get();

        $stats = [
            'total' => Submission::count(),
            'submitted' => Submission::where('status', 'submitted')->count(),
            'under_review' => Submission::where('status', 'under_review')->count(),
            'revision_required' => Submission::where('status', 'revision_required')->count(),
            'accepted' => Submission::where('status', 'accepted')->count(),
            'published' => Submission::where('status', 'published')->count(),
            'rejected' => Submission::where('status', 'rejected')->count(),
        ];

        return view('admin.submissions.index', compact('submissions', 'journals', 'stats'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['journal', 'author', 'authors', 'files', 'reviews.reviewer', 'issue', 'logs.user']);
        return view('admin.submissions.show', compact('submission'));
    }

    /**
     * Site Administrator can make editorial decisions
     */
    public function approve(Submission $submission, Request $request)
    {
        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'accepted',
            'current_stage' => 'copyediting',
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'accepted',
            'message' => 'Submission approved by Site Administrator',
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'accepted'));

        return back()->with('success', 'Submission approved successfully.');
    }

    public function reject(Submission $submission, Request $request)
    {
        $request->validate(['reason' => ['required', 'string']]);

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
            'message' => 'Submission rejected by Site Administrator. Reason: ' . $request->reason,
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'rejected'));

        return back()->with('success', 'Submission rejected.');
    }

    public function assignReviewer(Submission $submission, Request $request)
    {
        $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
            'due_date' => ['required', 'date', 'after:today'],
        ]);

        $review = Review::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $request->reviewer_id,
            'status' => 'pending',
            'assigned_date' => now(),
            'due_date' => $request->due_date,
        ]);

        $submission->update(['status' => 'under_review', 'current_stage' => 'review']);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'reviewer_assigned',
            'message' => 'Reviewer assigned by Site Administrator: ' . User::find($request->reviewer_id)->full_name,
        ]);

        return back()->with('success', 'Reviewer assigned successfully.');
    }

    public function updateStatus(Submission $submission, Request $request)
    {
        $request->validate([
            'status' => ['required', 'string'],
            'stage' => ['required', 'string'],
        ]);

        $oldStatus = $submission->status;
        $submission->update([
            'status' => $request->status,
            'current_stage' => $request->stage,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'status_updated',
            'message' => 'Submission status force-updated by Site Administrator to ' . $request->status,
        ]);

        return back()->with('success', 'Submission status updated to ' . $request->status);
    }
}

