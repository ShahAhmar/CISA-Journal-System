<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Reviewer Dashboard - Shows only assigned reviews (double-blind)
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get reviews assigned to this reviewer
        $reviews = Review::where('reviewer_id', $user->id)
            ->with(['submission.journal', 'submission.files'])
            ->orderBy('assigned_date', 'desc')
            ->get();
        
        $stats = [
            'pending' => $reviews->where('status', 'pending')->count(),
            'in_progress' => $reviews->where('status', 'in_progress')->count(),
            'completed' => $reviews->where('status', 'completed')->count(),
            'declined' => $reviews->where('status', 'declined')->count(),
            'total' => $reviews->count(),
            'overdue' => $reviews->filter(function($review) {
                return in_array($review->status, ['pending', 'in_progress']) && 
                       $review->due_date && 
                       $review->due_date->isPast();
            })->count(),
        ];
        
        return view('reviewer.dashboard', compact('reviews', 'stats'));
    }

    /**
     * Step 1: Initial Review - Accept/Decline
     */
    public function showInitialReview(Review $review)
    {
        // Ensure reviewer owns this review
        if ($review->reviewer_id !== Auth::id()) {
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
        if ($review->reviewer_id !== Auth::id()) {
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

        return redirect()->route('reviewer.review.show', $review)
            ->with('success', 'Review request accepted. You can now proceed with your review.');
    }

    /**
     * Decline Review Request
     */
    public function declineReview(Review $review, Request $request)
    {
        if ($review->reviewer_id !== Auth::id()) {
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

        return redirect()->route('reviewer.dashboard')
            ->with('success', 'Review request declined.');
    }

    /**
     * Step 2: Perform Review
     */
    public function showReview(Review $review)
    {
        if ($review->reviewer_id !== Auth::id()) {
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
        if ($review->reviewer_id !== Auth::id()) {
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

        // Calculate review time
        $reviewTimeDays = $review->assigned_date->diffInDays(now());

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

        // Fire ReviewCompleted event
        event(new \App\Events\ReviewCompleted($review));

        return redirect()->route('reviewer.review.show', $review)
            ->with('success', 'Thank you! Your review has been submitted successfully.');
    }

    /**
     * Download submission file (anonymized for reviewers)
     */
    public function downloadFile(Review $review, SubmissionFile $file)
    {
        if ($review->reviewer_id !== Auth::id()) {
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
        if ($review->reviewer_id !== Auth::id()) {
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
