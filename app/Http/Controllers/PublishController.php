<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class PublishController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_active', true)->latest()->take(6)->get();
        
        $stats = [
            'total_journals' => Journal::where('is_active', true)->count(),
            'total_articles' => \App\Models\Submission::where('status', 'published')->count(),
        ];
        
        return view('publish.index', compact('journals', 'stats'));
    }
}

