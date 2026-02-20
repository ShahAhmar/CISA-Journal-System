<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CopyeditApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Author approves copyedited files
     */
    public function approve(Request $request, Submission $submission)
    {
        // Only author can approve
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Only the author can approve copyedited files.');
        }

        // Only accepted submissions in copyediting stage
        if ($submission->status !== 'accepted' || $submission->current_stage !== 'copyediting') {
            abort(403, 'Copyedit approval is only available for accepted submissions in copyediting stage.');
        }

        $submission->update([
            'copyedit_approval_status' => 'approved',
            'copyedit_approved_at' => now(),
            'copyedit_approved_by' => Auth::id(),
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'action' => 'copyedit_approved',
            'message' => 'Author approved copyedited files',
        ]);

        return redirect()->back()->with('success', 'Copyedited files approved successfully.');
    }

    /**
     * Author requests changes to copyedited files
     */
    public function requestChanges(Request $request, Submission $submission)
    {
        // Only author can request changes
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Only the author can request changes to copyedited files.');
        }

        // Only accepted submissions in copyediting stage
        if ($submission->status !== 'accepted' || $submission->current_stage !== 'copyediting') {
            abort(403, 'Copyedit approval is only available for accepted submissions in copyediting stage.');
        }

        $request->validate([
            'comments' => 'required|string|max:2000',
        ]);

        $submission->update([
            'copyedit_approval_status' => 'changes_requested',
            'copyedit_author_comments' => $request->comments,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'action' => 'copyedit_changes_requested',
            'message' => 'Author requested changes to copyedited files: ' . substr($request->comments, 0, 100),
        ]);

        return redirect()->back()->with('success', 'Change request submitted. The copyeditor will review your comments.');
    }
}
