<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleAnalytic extends Model
{
    use HasFactory;

    protected $table = 'article_analytics';

    protected $fillable = [
        'submission_id',
        'journal_id',
        'event_type',
        'ip_address',
        'user_agent',
        'referrer',
        'user_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Track article view
     */
    public static function trackView(Submission $submission, $request = null)
    {
        return self::create([
            'submission_id' => $submission->id,
            'journal_id' => $submission->journal_id,
            'event_type' => 'view',
            'ip_address' => $request ? $request->ip() : request()->ip(),
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
            'referrer' => $request ? $request->header('referer') : request()->header('referer'),
            'user_id' => auth()->id(),
            'metadata' => [
                'session_id' => session()->getId(),
            ],
        ]);
    }

    /**
     * Track article download
     */
    public static function trackDownload(Submission $submission, $fileType = 'pdf', $request = null)
    {
        return self::create([
            'submission_id' => $submission->id,
            'journal_id' => $submission->journal_id,
            'event_type' => 'download',
            'ip_address' => $request ? $request->ip() : request()->ip(),
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
            'referrer' => $request ? $request->header('referer') : request()->header('referer'),
            'user_id' => auth()->id(),
            'metadata' => [
                'file_type' => $fileType,
                'session_id' => session()->getId(),
            ],
        ]);
    }

    /**
     * Get statistics for a submission
     */
    public static function getStats(Submission $submission)
    {
        $views = self::where('submission_id', $submission->id)
            ->where('event_type', 'view')
            ->count();

        $downloads = self::where('submission_id', $submission->id)
            ->where('event_type', 'download')
            ->count();

        $uniqueViews = self::where('submission_id', $submission->id)
            ->where('event_type', 'view')
            ->distinct('ip_address')
            ->count('ip_address');

        $viewsLast30Days = self::where('submission_id', $submission->id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $downloadsLast30Days = self::where('submission_id', $submission->id)
            ->where('event_type', 'download')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        return [
            'total_views' => $views,
            'total_downloads' => $downloads,
            'unique_views' => $uniqueViews,
            'views_last_30_days' => $viewsLast30Days,
            'downloads_last_30_days' => $downloadsLast30Days,
        ];
    }

    /**
     * Get statistics for a journal
     */
    public static function getJournalStats(Journal $journal, $days = 30)
    {
        $views = self::where('journal_id', $journal->id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        $downloads = self::where('journal_id', $journal->id)
            ->where('event_type', 'download')
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        $topArticles = self::where('journal_id', $journal->id)
            ->where('event_type', 'view')
            ->where('created_at', '>=', now()->subDays($days))
            ->selectRaw('submission_id, COUNT(*) as views')
            ->groupBy('submission_id')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->with('submission')
            ->get();

        return [
            'total_views' => $views,
            'total_downloads' => $downloads,
            'top_articles' => $topArticles,
        ];
    }
}

