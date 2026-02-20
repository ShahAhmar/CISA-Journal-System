<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Journal;
use App\Models\Submission;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with('journal')
            ->latest('published_date')
            ->paginate(20);
        
        $journals = Journal::where('is_active', true)->get();
        
        return view('admin.issues.index', compact('issues', 'journals'));
    }
    
    public function create()
    {
        $journals = Journal::where('is_active', true)->get();
        return view('admin.issues.create', compact('journals'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'journal_id' => ['required', 'exists:journals,id'],
            'volume' => ['required', 'integer'],
            'issue_number' => ['required', 'integer'],
            'year' => ['required', 'integer'],
            'display_title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'published_date' => ['nullable', 'date'],
            'is_published' => ['boolean'],
        ]);
        
        Issue::create($validated);
        
        return redirect()->route('admin.issues.index')->with('success', 'Issue created successfully.');
    }
    
    public function edit(Issue $issue)
    {
        $journals = Journal::where('is_active', true)->get();
        $articles = Submission::where('journal_id', $issue->journal_id)
            ->where('status', 'published')
            ->whereNull('issue_id')
            ->get();
        
        return view('admin.issues.edit', compact('issue', 'journals', 'articles'));
    }
    
    public function update(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'volume' => ['required', 'integer'],
            'issue_number' => ['required', 'integer'],
            'year' => ['required', 'integer'],
            'display_title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'published_date' => ['nullable', 'date'],
            'is_published' => ['boolean'],
        ]);
        
        $issue->update($validated);
        
        return redirect()->route('admin.issues.index')->with('success', 'Issue updated successfully.');
    }

    public function show(Issue $issue)
    {
        $issue->load(['journal', 'submissions']);
        return view('admin.issues.show', compact('issue'));
    }

    public function destroy(Issue $issue)
    {
        // Check if issue has published articles
        if ($issue->submissions()->where('status', 'published')->count() > 0) {
            return redirect()->route('admin.issues.index')
                ->with('error', 'Cannot delete issue with published articles. Unpublish articles first.');
        }

        $issue->delete();
        
        return redirect()->route('admin.issues.index')->with('success', 'Issue deleted successfully.');
    }

    /**
     * Unpublish an issue
     */
    public function unpublish(Issue $issue)
    {
        $issue->update([
            'is_published' => false,
        ]);

        return redirect()->route('admin.issues.index')
            ->with('success', 'Issue unpublished successfully.');
    }

    /**
     * Republish an issue
     */
    public function republish(Issue $issue)
    {
        $issue->update([
            'is_published' => true,
            'published_date' => $issue->published_date ?? now(),
        ]);

        return redirect()->route('admin.issues.index')
            ->with('success', 'Issue republished successfully.');
    }
}

