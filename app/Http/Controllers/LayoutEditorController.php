<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayoutEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Layout Editor Dashboard
     * Shows only accepted articles that have passed copyediting and proofreading
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get journal IDs where user has layout_editor role
        $journalIds = $user->journals()
            ->wherePivot('role', 'layout_editor')
            ->wherePivot('is_active', true)
            ->pluck('journals.id');
        
        // Layout Editor works on articles that are:
        // - Accepted
        // - Have passed copyediting (copyedit_approval_status = approved)
        // - Are in proofreading or layout stage
        $submissions = Submission::whereIn('journal_id', $journalIds)
            ->where('status', 'accepted')
            ->where('copyedit_approval_status', 'approved')
            ->whereIn('current_stage', ['proofreading', 'layout'])
            ->with(['journal', 'author', 'galleys'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $stats = [
            'pending' => $submissions->where('current_stage', 'proofreading')->count(),
            'in_layout' => $submissions->where('current_stage', 'layout')->count(),
            'total' => $submissions->count(),
        ];

        return view('layout-editor.dashboard', compact('submissions', 'stats'));
    }

    /**
     * Show submission for layout editing
     */
    public function show(Submission $submission)
    {
        // Check if user has layout_editor role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'layout_editor')) {
            abort(403, 'You do not have permission to view this submission.');
        }

        // Only work on accepted articles that have passed copyediting
        if ($submission->status !== 'accepted' || $submission->copyedit_approval_status !== 'approved') {
            abort(403, 'Layout editing is only available for accepted articles that have passed copyediting.');
        }

        $submission->load(['journal', 'author', 'files', 'galleys', 'logs']);

        return view('layout-editor.submission', compact('submission'));
    }

    /**
     * Upload layout files (PDF, HTML, XML)
     */
    public function uploadLayout(Request $request, Submission $submission)
    {
        $user = Auth::user();
        
        // Check permissions
        if (!$user->hasJournalRole($submission->journal_id, 'layout_editor')) {
            abort(403, 'You do not have permission to upload layout files.');
        }

        // Only accepted articles with approved copyediting
        if ($submission->status !== 'accepted' || $submission->copyedit_approval_status !== 'approved') {
            abort(403, 'Layout files can only be uploaded for accepted articles that have passed copyediting.');
        }

        $request->validate([
            'type' => 'required|in:pdf,html,xml',
            'label' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf,html,xml|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('galleys', 'public');

        $galley = \App\Models\Galley::create([
            'submission_id' => $submission->id,
            'type' => $request->type,
            'label' => $request->label ?? strtoupper($request->type),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => $user->id,
        ]);

        // Update submission stage to layout if not already
        if ($submission->current_stage !== 'layout') {
            $submission->update([
                'current_stage' => 'layout',
            ]);
        }

        // Log action
        \App\Models\SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => $user->id,
            'action' => 'layout_file_uploaded',
            'message' => 'Layout file uploaded: ' . ($request->label ?? strtoupper($request->type)),
        ]);

        return redirect()->back()->with('success', 'Layout file uploaded successfully!');
    }

    /**
     * Mark layout as complete
     */
    public function completeLayout(Request $request, Submission $submission)
    {
        $user = Auth::user();
        
        if (!$user->hasJournalRole($submission->journal_id, 'layout_editor')) {
            abort(403, 'You do not have permission to complete layout.');
        }

        // Check if at least one galley exists
        if ($submission->galleys()->count() === 0) {
            return back()->with('error', 'Please upload at least one layout file before marking as complete.');
        }

        // Update stage to ready for final publishing
        $submission->update([
            'current_stage' => 'production',
        ]);

        // Log action
        \App\Models\SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => $user->id,
            'action' => 'layout_completed',
            'message' => 'Layout editing completed. Ready for final publishing.',
        ]);

        // Fire event
        event(new \App\Events\GalleyReadyForProduction($submission));

        return redirect()->back()->with('success', 'Layout editing completed successfully!');
    }
}

