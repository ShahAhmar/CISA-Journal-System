<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Submission;
use App\Models\ArticleAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function article(Submission $submission)
    {
        $stats = ArticleAnalytic::getStats($submission);
        
        // Daily views for last 30 days
        $dailyViews = ArticleAnalytic::where('submission_id', $submission->id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Daily downloads for last 30 days
        $dailyDownloads = ArticleAnalytic::where('submission_id', $submission->id)
            ->where('event_type', 'download')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Referrers
        $referrers = ArticleAnalytic::where('submission_id', $submission->id)
            ->where('event_type', 'view')
            ->whereNotNull('referrer')
            ->selectRaw('referrer, COUNT(*) as count')
            ->groupBy('referrer')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.analytics.article', compact('submission', 'stats', 'dailyViews', 'dailyDownloads', 'referrers'));
    }

    public function journal(Journal $journal)
    {
        $stats = ArticleAnalytic::getJournalStats($journal, 30);
        
        // Overall stats
        $overallStats = [
            'total_articles' => $journal->submissions()->where('status', 'published')->count(),
            'total_views_all_time' => ArticleAnalytic::where('journal_id', $journal->id)
                ->where('event_type', 'view')
                ->count(),
            'total_downloads_all_time' => ArticleAnalytic::where('journal_id', $journal->id)
                ->where('event_type', 'download')
                ->count(),
        ];

        // Monthly trends
        $monthlyTrends = ArticleAnalytic::where('journal_id', $journal->id)
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, event_type, COUNT(*) as count')
            ->groupBy('month', 'event_type')
            ->orderBy('month')
            ->get();

        return view('admin.analytics.journal', compact('journal', 'stats', 'overallStats', 'monthlyTrends'));
    }

    public function dashboard()
    {
        // Global analytics
        $globalStats = [
            'total_views' => ArticleAnalytic::where('event_type', 'view')->count(),
            'total_downloads' => ArticleAnalytic::where('event_type', 'download')->count(),
            'views_today' => ArticleAnalytic::where('event_type', 'view')
                ->whereDate('created_at', today())
                ->count(),
            'downloads_today' => ArticleAnalytic::where('event_type', 'download')
                ->whereDate('created_at', today())
                ->count(),
        ];

        // Top articles
        $topArticles = ArticleAnalytic::where('event_type', 'view')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('submission_id, COUNT(*) as views')
            ->groupBy('submission_id')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->with(['submission.journal', 'submission.authors'])
            ->get();

        // Top journals
        $topJournals = ArticleAnalytic::where('event_type', 'view')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('journal_id, COUNT(*) as views')
            ->groupBy('journal_id')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->with('journal')
            ->get();

        return view('admin.analytics.dashboard', compact('globalStats', 'topArticles', 'topJournals'));
    }

    public function advancedStats(Journal $journal = null)
    {
        $query = \App\Models\Submission::query();
        
        if ($journal) {
            $query->where('journal_id', $journal->id);
        }

        // Review Statistics
        $reviewStats = [
            'average_review_time' => \App\Models\Review::whereHas('submission', function($q) use ($journal) {
                if ($journal) $q->where('journal_id', $journal->id);
            })
            ->whereNotNull('reviewed_at')
            ->whereNotNull('assigned_date')
            ->selectRaw('AVG(DATEDIFF(reviewed_at, assigned_date)) as avg_days')
            ->value('avg_days'),
            
            'total_reviews' => \App\Models\Review::whereHas('submission', function($q) use ($journal) {
                if ($journal) $q->where('journal_id', $journal->id);
            })->count(),
            
            'completed_reviews' => \App\Models\Review::whereHas('submission', function($q) use ($journal) {
                if ($journal) $q->where('journal_id', $journal->id);
            })->where('status', 'submitted')->count(),
            
            'pending_reviews' => \App\Models\Review::whereHas('submission', function($q) use ($journal) {
                if ($journal) $q->where('journal_id', $journal->id);
            })->where('status', 'pending')->count(),
        ];

        // Acceptance Rate
        $totalSubmissions = $query->count();
        $publishedSubmissions = (clone $query)->where('status', 'published')->count();
        $rejectedSubmissions = (clone $query)->where('status', 'rejected')->count();
        
        $acceptanceRate = $totalSubmissions > 0 
            ? round(($publishedSubmissions / $totalSubmissions) * 100, 2) 
            : 0;

        // Reviewer Performance
        $reviewerPerformance = \App\Models\Review::whereHas('submission', function($q) use ($journal) {
            if ($journal) $q->where('journal_id', $journal->id);
        })
        ->where('status', 'submitted')
        ->selectRaw('reviewer_id, COUNT(*) as total_reviews, AVG(reviewer_rating) as avg_rating, AVG(review_time_days) as avg_time')
        ->groupBy('reviewer_id')
        ->with('reviewer')
        ->orderBy('total_reviews', 'desc')
        ->limit(20)
        ->get();

        // Submission Status Breakdown
        $statusBreakdown = $query->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Monthly Submission Trends
        $monthlySubmissions = $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.analytics.advanced', compact(
            'journal',
            'reviewStats',
            'acceptanceRate',
            'totalSubmissions',
            'publishedSubmissions',
            'rejectedSubmissions',
            'reviewerPerformance',
            'statusBreakdown',
            'monthlySubmissions'
        ));
    }
}

