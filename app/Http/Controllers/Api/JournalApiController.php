<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Submission;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JournalApiController extends Controller
{
    /**
     * Get homepage data
     */
    public function homepage(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        app()->setLocale($locale);

        // Get statistics
        $stats = [
            'total_articles' => Submission::where('status', 'published')->count(),
            'total_journals' => Journal::where('is_active', true)->count(),
        ];

        // Get featured journals
        $journals = Journal::where('is_active', true)
            ->with(['coverImage'])
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get()
            ->map(function ($journal) {
                return [
                    'id' => $journal->id,
                    'name' => $journal->name,
                    'slug' => $journal->slug,
                    'description' => $journal->description,
                    'issn' => $journal->issn,
                    'cover_image' => $journal->cover_image ? asset($journal->cover_image) : null,
                    'created_at' => $journal->created_at->format('Y-m-d'),
                ];
            });

        // Get announcements
        $announcements = Announcement::where('is_published', true)
            ->where('published_at', '<=', now())
            ->with('journal:id,name,slug')
            ->orderBy('published_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'type' => $announcement->type,
                    'published_at' => $announcement->published_at?->format('Y-m-d'),
                    'journal' => $announcement->journal ? [
                        'id' => $announcement->journal->id,
                        'name' => $announcement->journal->name,
                        'slug' => $announcement->journal->slug,
                    ] : null,
                ];
            });

        // Get featured articles
        $featuredArticles = Submission::where('status', 'published')
            ->with(['journal:id,name,slug', 'authors'])
            ->latest('published_at')
            ->take(5)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'doi' => $article->doi,
                    'published_at' => $article->published_at?->format('Y-m-d'),
                    'journal' => [
                        'id' => $article->journal->id,
                        'name' => $article->journal->name,
                        'slug' => $article->journal->slug,
                    ],
                    'authors' => $article->authors->pluck('full_name')->toArray(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'journals' => $journals,
                'announcements' => $announcements,
                'featured_articles' => $featuredArticles,
            ],
        ]);
    }

    /**
     * Get single journal details
     */
    public function show($slug, Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        app()->setLocale($locale);

        $journal = Journal::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $journal->id,
                'name' => $journal->name,
                'slug' => $journal->slug,
                'description' => $journal->description,
                'issn' => $journal->issn,
                'cover_image' => $journal->cover_image ? asset($journal->cover_image) : null,
                'aims_scope' => $journal->aims_scope,
                'editorial_board' => $journal->editorial_board,
            ],
        ]);
    }

    /**
     * Get journal articles
     */
    public function articles($slug, Request $request)
    {
        $journal = Journal::where('slug', $slug)->firstOrFail();
        
        $articles = Submission::where('journal_id', $journal->id)
            ->where('status', 'published')
            ->with(['authors'])
            ->latest('published_at')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $articles->items(),
            'pagination' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        ]);
    }

    /**
     * Search journals and articles
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $locale = $request->get('locale', app()->getLocale());
        app()->setLocale($locale);

        $results = [
            'journals' => [],
            'articles' => [],
        ];

        if ($query) {
            // Search journals
            $journals = Journal::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->take(10)
                ->get()
                ->map(function ($journal) {
                    return [
                        'id' => $journal->id,
                        'name' => $journal->name,
                        'slug' => $journal->slug,
                        'description' => Str::limit($journal->description, 150),
                    ];
                });

            // Search articles
            $articles = Submission::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('abstract', 'like', "%{$query}%")
                      ->orWhere('doi', 'like', "%{$query}%");
                })
                ->with(['journal:id,name,slug'])
                ->take(20)
                ->get()
                ->map(function ($article) {
                    return [
                        'id' => $article->id,
                        'title' => $article->title,
                        'doi' => $article->doi,
                        'journal' => [
                            'name' => $article->journal->name,
                            'slug' => $article->journal->slug,
                        ],
                    ];
                });

            $results['journals'] = $journals;
            $results['articles'] = $articles;
        }

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}

