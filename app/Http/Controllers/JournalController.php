<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Journal;
use App\Models\Issue;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_active', true)->latest()->get();

        $stats = [
            'total_journals' => Journal::where('is_active', true)->count(),
            'total_articles' => Submission::where('status', 'published')->count(),
            'active_reviewers' => \DB::table('journal_users')
                ->where('role', 'reviewer')
                ->where('is_active', true)
                ->distinct('user_id')
                ->count('user_id'),
            'avg_review_time' => '3-6',
        ];

        // Get all published announcements grouped by journal
        $allAnnouncements = Announcement::published()
            ->with('journal')
            ->latest('published_at')
            ->take(20)
            ->get();

        // Group announcements by journal (null for platform-wide)
        $announcementsByJournal = $allAnnouncements->groupBy(function ($announcement) {
            return $announcement->journal_id ?? 'platform-wide';
        });

        return view('journals.index', compact('journals', 'stats', 'announcementsByJournal'));
    }

    public function partnership()
    {
        return view('journals.partnership');
    }

    public function show(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        $latestIssue = $journal->issues()
            ->where('is_published', true)
            ->latest('published_date')
            ->first();

        $recentArticles = Submission::where('journal_id', $journal->id)
            ->where('status', 'published')
            ->with(['authors', 'issue'])
            ->latest('published_at')
            ->take(10)
            ->get();

        // Get published announcements for this journal (including platform-wide)
        $announcements = Announcement::published()
            ->forJournal($journal->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('journals.show', compact('journal', 'latestIssue', 'recentArticles', 'announcements'));
    }

    public function aimsScope(Journal $journal)
    {
        return view('journals.aims-scope', compact('journal'));
    }

    public function editorialBoard(Journal $journal)
    {
        $editors = $journal->editors()->get();
        $sectionEditors = $journal->sectionEditors()->get();
        $reviewers = $journal->reviewers()->get();

        return view('journals.editorial-board', compact('journal', 'editors', 'sectionEditors', 'reviewers'));
    }

    public function submissionGuidelines(Journal $journal)
    {
        return view('journals.submission-guidelines', compact('journal'));
    }

    public function peerReviewPolicy(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }
        return view('journals.peer-review-policy', compact('journal'));
    }

    public function openAccessPolicy(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }
        return view('journals.open-access-policy', compact('journal'));
    }

    public function copyrightNotice(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }
        return view('journals.copyright-notice', compact('journal'));
    }

    public function contact(Journal $journal)
    {
        return view('journals.contact', compact('journal'));
    }

    public function issues(Journal $journal)
    {
        $issues = $journal->issues()
            ->where('is_published', true)
            ->orderBy('year', 'desc')
            ->orderBy('volume', 'desc')
            ->orderBy('issue_number', 'desc')
            ->paginate(20);

        return view('journals.issues', compact('journal', 'issues'));
    }

    public function showIssue(Request $request, Journal $journal, $issue)
    {
        // Find issue by ID (route parameter is {issue})
        $issue = Issue::find($issue);

        // Check if issue exists
        if (!$issue) {
            abort(404, 'Issue not found');
        }

        // Verify issue belongs to journal
        if ($issue->journal_id != $journal->id) {
            abort(404, 'Issue does not belong to this journal');
        }

        // Verify issue is published
        if (!$issue->is_published) {
            abort(404, 'Issue is not published');
        }

        // Get published articles for this issue
        $articles = $issue->submissions()
            ->where('status', 'published')
            ->with(['authors'])
            ->get();

        return view('journals.issue', compact('journal', 'issue', 'articles'));
    }

    public function search(Journal $journal, Request $request)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        $query = $request->get('q', '');

        if (empty($query)) {
            return redirect()->route('journals.show', $journal);
        }

        // Search only articles from this journal
        $articles = Submission::where('journal_id', $journal->id)
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('abstract', 'like', "%{$query}%")
                    ->orWhere('keywords', 'like', "%{$query}%")
                    ->orWhere('doi', 'like', "%{$query}%");
            })
            ->with(['authors', 'issue'])
            ->latest('published_at')
            ->paginate(20);

        return view('journals.search', compact('journal', 'query', 'articles'));
    }

    public function archives(Journal $journal, Request $request)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        $view = $request->get('view', 'year'); // year, volume, issue

        $years = $journal->issues()
            ->where('is_published', true)
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $volumes = $journal->issues()
            ->where('is_published', true)
            ->select('volume')
            ->distinct()
            ->orderBy('volume', 'desc')
            ->pluck('volume');

        $issues = $journal->issues()
            ->where('is_published', true)
            ->orderBy('year', 'desc')
            ->orderBy('volume', 'desc')
            ->orderBy('issue_number', 'desc')
            ->get();

        // Group by year
        $issuesByYear = $issues->groupBy('year');

        // Group by volume
        $issuesByVolume = $issues->groupBy('volume');

        return view('journals.archives', compact('journal', 'years', 'volumes', 'issues', 'issuesByYear', 'issuesByVolume', 'view'));
    }

    public function showArticle(Journal $journal, Submission $submission)
    {
        if ($submission->journal_id !== $journal->id || $submission->status !== 'published') {
            abort(404);
        }

        $submission->load(['authors', 'issue', 'files', 'references', 'journal']);

        // Track article view
        \App\Models\ArticleAnalytic::trackView($submission, request());

        return view('journals.article', compact('journal', 'submission'));
    }

    public function downloadArticle(Journal $journal, Submission $submission, $fileType = 'pdf')
    {
        if ($submission->journal_id !== $journal->id || $submission->status !== 'published') {
            abort(404);
        }

        // Track download
        \App\Models\ArticleAnalytic::trackDownload($submission, $fileType, request());

        // Get file
        $file = $submission->files()->where('file_type', 'manuscript')->first();

        if (!$file) {
            abort(404, 'File not found');
        }

        $filePath = storage_path('app/public/' . $file->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $file->original_name ?? 'article.pdf');
    }

    public function authorGuidelines(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        return view('journals.author-guidelines', compact('journal'));
    }

    public function announcements(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        // Get all published announcements for this journal (including platform-wide)
        $announcements = Announcement::published()
            ->forJournal($journal->id)
            ->with('journal')
            ->latest('published_at')
            ->paginate(10);

        return view('journals.announcements', compact('journal', 'announcements'));
    }

    public function history(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        $totalIssues = $journal->issues()->where('is_published', true)->count();
        $totalArticles = $journal->submissions()->where('status', 'published')->count();
        $firstIssue = $journal->issues()->where('is_published', true)->orderBy('published_date')->first();
        $latestIssue = $journal->issues()->where('is_published', true)->latest('published_date')->first();

        return view('journals.history', compact('journal', 'totalIssues', 'totalArticles', 'firstIssue', 'latestIssue'));
    }

    public function editorialPolicies(Journal $journal)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        return view('journals.editorial-policies', compact('journal'));
    }

    public function customPage(Journal $journal, $page)
    {
        if (!$journal->is_active) {
            abort(404);
        }

        // Find custom page for this journal
        $customPage = \App\Models\CustomPage::where('journal_id', $journal->id)
            ->where('slug', $page)
            ->where('is_published', true)
            ->firstOrFail();

        return view('journals.custom-page', compact('journal', 'customPage'));
    }
}

