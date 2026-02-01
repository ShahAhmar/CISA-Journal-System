<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvancedSearchController extends Controller
{
    /**
     * Advanced search with filters
     */
    public function search(Request $request)
    {
        $query = Submission::query()
            ->where('status', 'published')
            ->whereNotNull('published_at');

        // Search term
        if ($request->filled('q')) {
            $searchTerm = $request->get('q');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('abstract', 'like', "%{$searchTerm}%")
                  ->orWhere('keywords', 'like', "%{$searchTerm}%");
            });
        }

        // Journal filter
        if ($request->filled('journal_id')) {
            $query->where('journal_id', $request->get('journal_id'));
        }

        // Author filter
        if ($request->filled('author')) {
            $query->whereHas('authors', function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->get('author')}%")
                  ->orWhere('last_name', 'like', "%{$request->get('author')}%");
            });
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->get('date_to'));
        }

        // Keywords
        if ($request->filled('keywords')) {
            $keywords = explode(',', $request->get('keywords'));
            foreach ($keywords as $keyword) {
                $query->where('keywords', 'like', '%' . trim($keyword) . '%');
            }
        }

        // DOI search
        if ($request->filled('doi')) {
            $query->where('doi', 'like', "%{$request->get('doi')}%");
        }

        // Sort
        $sortBy = $request->get('sort_by', 'published_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $results = $query->paginate(20);

        return view('search.advanced', [
            'results' => $results,
            'journals' => Journal::where('is_active', true)->get(),
            'filters' => $request->all(),
        ]);
    }

    /**
     * Full-text search (if full-text indexing is available)
     */
    public function fullTextSearch(Request $request)
    {
        $searchTerm = $request->get('q');
        
        if (!$searchTerm) {
            return redirect()->route('search.advanced');
        }

        // Basic full-text search using MySQL FULLTEXT
        // Note: Requires FULLTEXT index on title, abstract, keywords columns
        $results = Submission::where('status', 'published')
            ->whereNotNull('published_at')
            ->whereRaw("MATCH(title, abstract, keywords) AGAINST(? IN BOOLEAN MODE)", [$searchTerm])
            ->orderByRaw("MATCH(title, abstract, keywords) AGAINST(? IN BOOLEAN MODE) DESC", [$searchTerm])
            ->paginate(20);

        return view('search.results', [
            'results' => $results,
            'searchTerm' => $searchTerm,
        ]);
    }
}
