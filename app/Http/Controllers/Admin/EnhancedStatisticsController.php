<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Journal;
use App\Models\ArticleAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnhancedStatisticsController extends Controller
{
    /**
     * Enhanced statistics dashboard
     */
    public function index(Request $request)
    {
        $journalId = $request->get('journal_id');
        $dateFrom = $request->get('date_from', now()->subYear()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        
        $query = Submission::where('status', 'published')
            ->whereBetween('published_at', [$dateFrom, $dateTo]);
            
        if ($journalId) {
            $query->where('journal_id', $journalId);
        }
        
        $stats = [
            'total_articles' => (clone $query)->count(),
            'total_views' => ArticleAnalytic::where('event_type', 'view')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->when($journalId, fn($q) => $q->where('journal_id', $journalId))
                ->count(),
            'total_downloads' => ArticleAnalytic::where('event_type', 'download')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->when($journalId, fn($q) => $q->where('journal_id', $journalId))
                ->count(),
            'articles_by_month' => $this->getArticlesByMonth($dateFrom, $dateTo, $journalId),
            'top_articles' => $this->getTopArticles($dateFrom, $dateTo, $journalId),
            'articles_by_journal' => $this->getArticlesByJournal($dateFrom, $dateTo),
        ];
        
        return view('admin.statistics.enhanced', [
            'stats' => $stats,
            'journals' => Journal::all(),
            'selectedJournal' => $journalId,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }
    
    /**
     * Export statistics to PDF
     */
    public function exportPDF(Request $request)
    {
        // Implementation for PDF export
        // Requires dompdf or similar package
        return response()->json(['message' => 'PDF export feature - requires dompdf package']);
    }
    
    /**
     * Export statistics to Excel
     */
    public function exportExcel(Request $request)
    {
        // Implementation for Excel export
        // Requires maatwebsite/excel package
        return response()->json(['message' => 'Excel export feature - requires maatwebsite/excel package']);
    }
    
    /**
     * Get articles by month
     */
    protected function getArticlesByMonth($dateFrom, $dateTo, $journalId = null)
    {
        $query = Submission::where('status', 'published')
            ->whereBetween('published_at', [$dateFrom, $dateTo])
            ->select(
                DB::raw('DATE_FORMAT(published_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month');
            
        if ($journalId) {
            $query->where('journal_id', $journalId);
        }
        
        return $query->get();
    }
    
    /**
     * Get top articles
     */
    protected function getTopArticles($dateFrom, $dateTo, $journalId = null, $limit = 10)
    {
        $query = Submission::where('status', 'published')
            ->whereBetween('published_at', [$dateFrom, $dateTo]);
            
        if ($journalId) {
            $query->where('journal_id', $journalId);
        }
        
        // Get top articles by view count
        $topArticles = ArticleAnalytic::where('event_type', 'view')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($journalId, fn($q) => $q->where('journal_id', $journalId))
            ->selectRaw('submission_id, COUNT(*) as view_count')
            ->groupBy('submission_id')
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->with('submission')
            ->get();
        
        return $topArticles;
    }
    
    /**
     * Get articles by journal
     */
    protected function getArticlesByJournal($dateFrom, $dateTo)
    {
        return Submission::where('status', 'published')
            ->whereBetween('published_at', [$dateFrom, $dateTo])
            ->select('journal_id', DB::raw('COUNT(*) as count'))
            ->with('journal:id,name')
            ->groupBy('journal_id')
            ->get();
    }
}
