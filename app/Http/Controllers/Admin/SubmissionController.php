<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Journal;
use App\Models\SubmissionLog;
use App\Models\Review;
use App\Models\User;
use App\Events\SubmissionStatusChanged;
use App\Notifications\SubmissionStatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'disabled' => Submission::where('status', 'disabled')->count(),
        ];
        
        return view('admin.submissions.index', compact('submissions', 'journals', 'stats'));
    }
    
    public function show(Submission $submission)
    {
        $submission->load(['journal', 'author', 'authors', 'files', 'reviews.reviewer', 'issue', 'logs.user']);
        return view('admin.submissions.show', compact('submission'));
    }
    
    /**
     * Site Administrator can view submissions but NOT make editorial decisions
     * Editorial decisions are made by Journal Managers, Editors, and Section Editors only
     */
    public function approve(Submission $submission, Request $request)
    {
        // Site Admin restriction: Cannot make editorial decisions
        abort(403, 'Site Administrators cannot make editorial decisions. Please contact the Journal Manager or Editor for this journal.');
    }
    
    public function reject(Submission $submission, Request $request)
    {
        // Site Admin restriction: Cannot make editorial decisions
        abort(403, 'Site Administrators cannot make editorial decisions. Please contact the Journal Manager or Editor for this journal.');
    }

    /**
     * Site Administrator cannot assign reviewers
     * Reviewer assignment is done by Journal Managers, Editors, and Section Editors
     */
    public function assignReviewer(Submission $submission, Request $request)
    {
        // Site Admin restriction: Cannot assign reviewers
        abort(403, 'Site Administrators cannot assign reviewers. Please contact the Journal Manager or Editor for this journal.');
    }

    /**
     * Disable a submission
     */
    public function disable(Submission $submission)
    {
        $oldStatus = $submission->status;
        
        // Change status to disabled
        $submission->update([
            'status' => 'disabled',
            'editor_notes' => ($submission->editor_notes ?? '') . "\n\n[Disabled by Admin on " . now()->format('Y-m-d H:i:s') . "]",
        ]);

        // Reload submission to get fresh data
        $submission->refresh();

        // Log the action
        $submission->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'disabled_by_admin',
            'message' => 'Submission disabled by admin',
            'metadata' => json_encode([
                'old_status' => $oldStatus,
                'new_status' => 'disabled',
            ]),
        ]);

        // Fire event to send email notification
        event(new SubmissionStatusChanged($submission, $oldStatus, 'disabled'));

        return redirect()->back()->with('success', 'Submission has been disabled successfully. Author has been notified via email.');
    }

    /**
     * Enable a disabled submission
     */
    public function enable(Submission $submission)
    {
        // Only enable if currently disabled
        if ($submission->status !== 'disabled') {
            return redirect()->back()->with('error', 'This submission is not disabled.');
        }

        // Try to restore previous status from logs
        $newStatus = 'accepted'; // Default status
        
        // Check if submission was published (has published_at date)
        if ($submission->published_at) {
            $newStatus = 'published';
        } else {
            // Try to get previous status from disable log
            $disableLog = $submission->logs()
                ->where('action', 'disabled_by_admin')
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($disableLog && $disableLog->metadata) {
                $metadata = is_string($disableLog->metadata) 
                    ? json_decode($disableLog->metadata, true) 
                    : $disableLog->metadata;
                
                if (isset($metadata['old_status'])) {
                    $newStatus = $metadata['old_status'];
                }
            }
        }
        
        $oldStatus = $submission->status;
        
        $submission->update([
            'status' => $newStatus,
            'editor_notes' => ($submission->editor_notes ?? '') . "\n\n[Enabled by Admin on " . now()->format('Y-m-d H:i:s') . "]",
        ]);

        // Reload submission to get fresh data
        $submission->refresh();
        
        // Log the action
        $submission->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'enabled_by_admin',
            'message' => 'Submission enabled by admin',
            'metadata' => json_encode([
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]),
        ]);

        // Fire event to send email notification
        event(new SubmissionStatusChanged($submission, $oldStatus, $newStatus));

        return redirect()->back()->with('success', 'Submission has been enabled successfully. Author has been notified via email.');
    }

    /**
     * Delete a submission
     */
    public function destroy(Submission $submission)
    {
        // Store data before deletion for email
        $author = $submission->author;
        $oldStatus = $submission->status;

        // Log the action before deletion
        $submission->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'deleted_by_admin',
            'message' => 'Submission deleted by admin',
            'metadata' => json_encode([
                'submission_id' => $submission->id,
                'title' => $submission->title,
                'status' => $submission->status,
            ]),
        ]);

        // Send email notification before deletion
        if ($author) {
            try {
                // Send notification directly before deletion
                $author->notify(
                    new SubmissionStatusChangedNotification($submission, $oldStatus, 'deleted')
                );
            } catch (\Exception $e) {
                \Log::error('Failed to send deletion notification', [
                    'submission_id' => $submission->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Delete associated files from storage
        foreach ($submission->files as $file) {
            if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        }

        // Delete the submission
        $submission->delete();

        return redirect()->route('admin.submissions.index')->with('success', 'Submission has been deleted successfully. Author has been notified via email.');
    }
}

