<?php

namespace App\Http\Controllers\Production;

use App\Events\GalleyReadyForProduction;
use App\Http\Controllers\Controller;
use App\Models\Galley;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Upload galley files (PDF, HTML, XML)
     * Only Journal Manager, Editor, Section Editor, or Production Editor can upload
     */
    public function upload(Request $request, Submission $submission)
    {
        $user = Auth::user();

        // Check permissions
        $hasPermission = false;
        if ($user->hasJournalRole($submission->journal_id, ['journal_manager', 'editor', 'section_editor'])) {
            $hasPermission = true;
        }
        // Check for production editor role (if exists in journal_users pivot)
        if (!$hasPermission && $user->hasJournalRole($submission->journal_id, 'production_editor')) {
            $hasPermission = true;
        }

        if (!$hasPermission) {
            abort(403, 'You do not have permission to upload galleys.');
        }

        // Only accepted submissions can have galleys
        if ($submission->status !== 'accepted') {
            abort(403, 'Galleys can only be uploaded for accepted submissions.');
        }

        $request->validate([
            'type' => 'required|in:pdf,html,xml',
            'label' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf,html,xml|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('galleys', 'public');

        $galley = Galley::create([
            'submission_id' => $submission->id,
            'type' => $request->type,
            'label' => $request->label ?? strtoupper($request->type),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => $user->id,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => $user->id,
            'action' => 'galley_uploaded',
            'message' => 'Galley uploaded: ' . ($request->label ?? strtoupper($request->type)),
        ]);

        // Fire event for email notification
        event(new GalleyReadyForProduction($submission));

        return redirect()->back()->with('success', 'Galley uploaded successfully.');
    }

    /**
     * Author approves galley
     */
    public function approve(Request $request, Galley $galley)
    {
        $submission = $galley->submission;

        // Only author can approve
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Only the author can approve galleys.');
        }

        $galley->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'action' => 'galley_approved',
            'message' => 'Author approved galley: ' . $galley->label,
        ]);

        return redirect()->back()->with('success', 'Galley approved successfully.');
    }

    /**
     * Author requests changes to galley
     */
    public function requestChanges(Request $request, Galley $galley)
    {
        $submission = $galley->submission;

        // Only author can request changes
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Only the author can request changes to galleys.');
        }

        $request->validate([
            'comments' => 'required|string|max:2000',
        ]);

        $galley->update([
            'approval_status' => 'changes_requested',
            'author_comments' => $request->comments,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => Auth::id(),
            'action' => 'galley_changes_requested',
            'message' => 'Author requested changes to galley: ' . $galley->label,
        ]);

        return redirect()->back()->with('success', 'Change request submitted.');
    }

    /**
     * Final publish (only Journal Manager/Section Editor)
     */
    public function finalPublish(Request $request, Submission $submission)
    {
        $user = Auth::user();

        // Only Journal Manager or Section Editor can final publish
        if (!$user->hasJournalRole($submission->journal_id, ['journal_manager', 'section_editor'])) {
            abort(403, 'Only Journal Managers and Section Editors can final publish articles.');
        }

        // Check if all galleys are approved
        $unapprovedGalleys = $submission->galleys()->where('approval_status', '!=', 'approved')->count();
        if ($unapprovedGalleys > 0) {
            return redirect()->back()->with('error', 'All galleys must be approved before publishing.');
        }

        // Check if copyedit is approved
        if ($submission->copyedit_approval_status !== 'approved') {
            return redirect()->back()->with('error', 'Copyedited files must be approved before publishing.');
        }

        // BLOCK: Check if proofread file exists
        if (!$submission->proofread_manuscript) {
            return redirect()->back()->with('error', 'Cannot publish article. Waiting for proofreader to submit the final manuscript.');
        }

        $request->validate([
            'issue_id' => 'nullable|exists:issues,id',
            'page_start' => 'nullable|integer',
            'page_end' => 'nullable|integer',
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
            'user_id' => $user->id,
            'action' => 'published',
            'message' => 'Article published' . ($request->issue_id ? ' in issue #' . $request->issue_id : ''),
        ]);

        // Fire PublicationScheduled event if issue is scheduled
        if ($request->issue_id) {
            $issue = \App\Models\Issue::find($request->issue_id);
            if ($issue && $issue->publication_date) {
                event(new \App\Events\PublicationScheduled($submission, $issue, $issue->publication_date));
            }
        }

        // Fire status change event for published notification
        try {
            $submission->refresh();
            event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'published'));
        } catch (\Exception $e) {
            \Log::error('Failed to fire SubmissionStatusChanged event in production', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'Article published successfully.');
    }
}
