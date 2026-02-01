<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'journals' => Journal::count(),
            'active_journals' => Journal::where('is_active', true)->count(),
            'users' => User::count(),
            'submissions' => Submission::count(),
            'pending_submissions' => Submission::where('status', 'submitted')->count(),
            'published_articles' => Submission::where('status', 'published')->count(),
        ];

        // Pending tasks stats
        $pendingTasks = [
            'review_requests' => \App\Models\Review::where('status', 'pending')->count(),
            'revision_submissions' => Submission::where('status', 'revision_required')->count(),
            'decisions_required' => Submission::whereIn('status', ['submitted', 'under_review'])
                ->whereDoesntHave('reviews', function($q) {
                    $q->where('status', 'completed');
                })
                ->count(),
        ];

        $recentJournals = Journal::latest()->take(5)->get();
        $recentSubmissions = Submission::with(['journal', 'author'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentJournals', 'recentSubmissions', 'pendingTasks'));
    }
}

