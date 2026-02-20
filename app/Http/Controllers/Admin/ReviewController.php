<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Journal;
use App\Models\Submission;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['submission.journal', 'reviewer']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'submitted') {
                // Include both 'submitted' and 'completed' statuses
                $query->whereIn('status', ['submitted', 'completed']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter by journal
        if ($request->has('journal_id') && $request->journal_id) {
            $query->whereHas('submission', function($q) use ($request) {
                $q->where('journal_id', $request->journal_id);
            });
        }

        // Filter by reviewer
        if ($request->has('reviewer_id') && $request->reviewer_id) {
            $query->where('reviewer_id', $request->reviewer_id);
        }

        // Filter by submission
        if ($request->has('submission_id') && $request->submission_id) {
            $query->where('submission_id', $request->submission_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('assigned_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('assigned_date', '<=', $request->date_to);
        }

        $reviews = $query->latest('assigned_date')->paginate(20);
        $journals = Journal::where('is_active', true)->orderBy('name')->get();
        
        // Get all reviewers for filter dropdown
        $reviewers = \App\Models\User::whereHas('journals', function($q) {
                $q->where('journal_users.role', 'reviewer')
                  ->where('journal_users.is_active', true);
            })
            ->orWhere('role', 'reviewer')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        // Statistics
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'submitted' => Review::where('status', 'completed')->orWhere('status', 'submitted')->count(),
            'declined' => Review::where('status', 'declined')->count(),
            'average_time' => Review::whereIn('status', ['completed', 'submitted'])
                ->whereNotNull('review_time_days')
                ->avg('review_time_days'),
        ];

        return view('admin.reviews.index', compact('reviews', 'journals', 'stats', 'reviewers'));
    }

    public function show(Review $review)
    {
        $review->load(['submission.journal', 'submission.authors', 'reviewer', 'files']);
        return view('admin.reviews.show', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,submitted,declined',
            'recommendation' => 'nullable|in:accept,minor_revision,major_revision,reject',
            'comments_for_editor' => 'nullable|string',
            'comments_for_author' => 'nullable|string',
            'comments_for_editors' => 'nullable|string',
            'comments_for_authors' => 'nullable|string',
            'reviewer_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }
}

