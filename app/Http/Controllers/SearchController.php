<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('journals.index');
        }

        $results = [
            'journals' => collect(),
            'articles' => collect(),
            'authors' => collect(),
        ];

        if (!empty($query)) {
            // Search Journals
            $results['journals'] = Journal::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('issn', 'like', "%{$query}%");
                })
                ->latest()
                ->get();

            // Search Articles
            $results['articles'] = Submission::where('status', 'published')
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('abstract', 'like', "%{$query}%")
                      ->orWhere('keywords', 'like', "%{$query}%")
                      ->orWhere('doi', 'like', "%{$query}%");
                })
                ->with(['journal', 'authors'])
                ->latest('published_at')
                ->get();

            // Search Authors
            $results['authors'] = User::where(function($q) use ($query) {
                    $q->where('first_name', 'like', "%{$query}%")
                      ->orWhere('last_name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%");
                })
                ->where('is_active', true)
                ->latest()
                ->get();
        }

        return view('search.results', [
            'query' => $query,
            'results' => $results,
            'totalResults' => $results['journals']->count() + $results['articles']->count() + $results['authors']->count(),
        ]);
    }
}

