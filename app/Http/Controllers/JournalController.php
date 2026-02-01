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

        // If only one active journal exists, redirect directly to its page
        if ($journals->count() === 1) {
            return redirect()->route('journals.show', $journals->first());
        }

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

        return $this->renderVisualOrFallback($journal, 'home', 'journals.show', compact('latestIssue', 'recentArticles', 'announcements'));
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
        // Load journal relationship to ensure route generation works correctly
        $articles = $issue->submissions()
            ->where('status', 'published')
            ->where('journal_id', $journal->id) // Ensure articles belong to this journal
            ->with(['authors', 'journal', 'files']) // Load relationships for route generation
            ->get();

        return view('journals.issue', compact('journal', 'issue', 'articles'));
    }

    public function latestIssue(Journal $journal)
    {
        $latestIssue = $journal->issues()
            ->where('is_published', true)
            ->latest('published_date')
            ->first();

        if (!$latestIssue) {
            return redirect()->route('journals.issues', $journal);
        }

        return redirect()->route('journals.issue', ['journal' => $journal->slug, 'issue' => $latestIssue->id]);
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

    public function showArticle(Journal $journal, $submission)
    {
        // Handle submission parameter - route passes ID as string/numeric
        // Convert to integer and find submission
        $submissionId = is_numeric($submission) ? (int) $submission : $submission;
        $submission = Submission::find($submissionId);

        if (!$submission) {
            abort(404, 'Article not found.');
        }

        // Check if submission belongs to this journal
        // Use loose comparison to handle string/int mismatches
        if ((int) $submission->journal_id !== (int) $journal->id) {
            \Log::error('Article journal mismatch', [
                'submission_id' => $submission->id,
                'submission_journal_id' => $submission->journal_id,
                'submission_journal_id_type' => gettype($submission->journal_id),
                'journal_id' => $journal->id,
                'journal_id_type' => gettype($journal->id),
            ]);
            abort(404, 'Article not found in this journal.');
        }

        // Check if submission is published
        if ($submission->status !== 'published') {
            abort(404, 'This article is not yet published. Current status: ' . ucfirst(str_replace('_', ' ', $submission->status)));
        }

        $submission->load(['authors', 'issue', 'files', 'references', 'journal']);

        // Track article view
        try {
            \App\Models\ArticleAnalytic::trackView($submission, request());
        } catch (\Exception $e) {
            // Don't fail the page if analytics tracking fails
            \Log::error('Failed to track article view: ' . $e->getMessage());
        }

        return view('journals.article', compact('journal', 'submission'));
    }

    public function downloadArticle(Journal $journal, $submission, $fileType = 'pdf')
    {
        // Handle submission parameter - route passes ID as string/numeric
        $submissionId = is_numeric($submission) ? (int) $submission : $submission;
        $submission = Submission::find($submissionId);

        if (!$submission) {
            abort(404, 'Article not found.');
        }

        // Check if submission belongs to this journal (use loose comparison)
        if ((int) $submission->journal_id !== (int) $journal->id) {
            abort(404, 'Article not found in this journal.');
        }

        // Check if submission is published
        if ($submission->status !== 'published') {
            abort(404, 'This article is not yet published.');
        }

        // Track download
        \App\Models\ArticleAnalytic::trackDownload($submission, $fileType, request());

        // Get file - Prioritize proofread manuscript for public download
        $file = $submission->proofread_manuscript ?? $submission->manuscript;

        if (!$file) {
            abort(404, 'File not found');
        }

        // For published articles, allow public download without authentication
        // Get file path
        $filePath = storage_path('app/public/' . $file->file_path);

        if (!file_exists($filePath)) {
            // Try alternative path
            $filePath = public_path('uploads/' . $file->file_path);
            if (!file_exists($filePath)) {
                abort(404, 'File not found on server.');
            }
        }

        // Return file download
        return response()->download($filePath, $file->original_name ?? $file->file_name, [
            'Content-Type' => $file->mime_type ?? 'application/pdf',
        ]);
    }

    public function viewArticleFile(Journal $journal, $submission)
    {
        // Handle submission parameter - route passes ID as string/numeric
        $submissionId = is_numeric($submission) ? (int) $submission : $submission;
        $submission = Submission::find($submissionId);

        if (!$submission) {
            abort(404, 'Article not found.');
        }

        // Check journal mismatch
        if ((int) $submission->journal_id !== (int) $journal->id) {
            abort(404, 'Article not found in this journal.');
        }

        // Check if published
        if ($submission->status !== 'published') {
            abort(404, 'This article is not yet published.');
        }

        // Track view (different from download? maybe track as view or custom event)
        // \App\Models\ArticleAnalytic::trackView($submission, request()); // We already track main page view. Let's count this as a "file view" if strictly needed, but for now keep simple.

        // Get file - Prioritize proofread manuscript
        $file = $submission->proofread_manuscript ?? $submission->manuscript;

        if (!$file) {
            abort(404, 'File not found');
        }

        // Get path
        $filePath = storage_path('app/public/' . $file->file_path);
        if (!file_exists($filePath)) {
            $filePath = public_path('uploads/' . $file->file_path);
            if (!file_exists($filePath)) {
                abort(404, 'File not found on server.');
            }
        }

        // Return file inline
        return response()->file($filePath, [
            'Content-Type' => $file->mime_type ?? 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($file->original_name ?? $file->file_name) . '"'
        ]);
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


    public function publications(Journal $journal, Request $request)
    {
        $query = Submission::where('journal_id', $journal->id)
            ->where('status', 'published');

        // Search Logic
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%")
                    ->orWhere('keywords', 'like', "%{$search}%");
                // Add author search
                $q->orWhereHas('authors', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by Year
        if ($year = $request->input('year')) {
            $query->whereYear('published_at', $year);
        }

        // Filter by Discipline
        if ($discipline = $request->input('discipline')) {
            $query->where('discipline', $discipline);
        }

        $publications = $query->with(['authors', 'journal', 'issue'])
            ->latest('published_at')
            ->paginate(20);

        // Get years for filter
        $years = Submission::where('journal_id', $journal->id)
            ->where('status', 'published')
            ->selectRaw('YEAR(published_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Get disciplines for filter
        $disciplines = $journal->disciplines()->orderBy('display_order')->get();

        return view('journals.publications', compact('journal', 'publications', 'years', 'disciplines'));
    }

    public function callForPapers(Journal $journal)
    {
        return $this->renderVisualOrFallback($journal, 'call_for_papers', 'journals.call-for-papers');
    }

    public function apcSubmission(Journal $journal)
    {
        return $this->renderVisualOrFallback($journal, 'apc', 'journals.apc-submission');
    }

    public function editorialEthics(Journal $journal)
    {
        $editors = $journal->editors()->get();
        $sectionEditors = $journal->sectionEditors()->get();
        $reviewers = $journal->reviewers()->get();

        return $this->renderVisualOrFallback($journal, 'editorial', 'journals.editorial-ethics', compact('editors', 'sectionEditors', 'reviewers'));
    }

    public function partnerships(Journal $journal)
    {
        return $this->renderVisualOrFallback($journal, 'partnerships', 'journals.partnerships');
    }

    public function about(Journal $journal)
    {
        return $this->renderVisualOrFallback($journal, 'about', 'journals.about');
    }

    public function info(Journal $journal)
    {
        return $this->renderVisualOrFallback($journal, 'info', 'journals.info');
    }

    /**
     * Helper to render visual-builder content if exists, otherwise fallback to traditional view.
     */
    private function renderVisualOrFallback(Journal $journal, $pageKey, $fallbackView, $data = [])
    {
        $page = \App\Models\JournalPageSetting::where('journal_id', $journal->id)
            ->where('page_key', $pageKey)
            ->first();

        if ($page && !empty($page->content_html)) {
            return view('journals.visual-page', array_merge(['journal' => $journal, 'page' => $page], $data));
        }

        return view($fallbackView, array_merge(['journal' => $journal], $data));
    }
}

