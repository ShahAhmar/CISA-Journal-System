<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Issue;
use App\Models\Submission;
use Illuminate\Http\Request;

class RSSFeedController extends Controller
{
    /**
     * Generate RSS feed for a journal
     */
    public function journal(Journal $journal)
    {
        $articles = Submission::where('journal_id', $journal->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        $xml = $this->generateRSS($journal->name, 
            route('journals.show', $journal->slug),
            $journal->description ?? '',
            $articles);

        return response($xml, 200)
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    /**
     * Generate RSS feed for an issue
     */
    public function issue(Journal $journal, Issue $issue)
    {
        $articles = $issue->submissions()
            ->where('status', 'published')
            ->orderBy('published_at', 'asc')
            ->get();

        $xml = $this->generateRSS(
            $journal->name . ' - ' . $issue->title,
            route('journals.issue', [$journal->slug, $issue->id]),
            $issue->description ?? '',
            $articles
        );

        return response($xml, 200)
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    /**
     * Generate RSS XML
     */
    protected function generateRSS(string $title, string $link, string $description, $items): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $xml .= '  <channel>' . "\n";
        $xml .= '    <title>' . htmlspecialchars($title) . '</title>' . "\n";
        $xml .= '    <link>' . htmlspecialchars($link) . '</link>' . "\n";
        $xml .= '    <description>' . htmlspecialchars($description) . '</description>' . "\n";
        $xml .= '    <language>en-us</language>' . "\n";
        $xml .= '    <lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";
        $xml .= '    <atom:link href="' . htmlspecialchars($link) . '" rel="self" type="application/rss+xml" />' . "\n";

        foreach ($items as $item) {
            $xml .= '    <item>' . "\n";
            $xml .= '      <title>' . htmlspecialchars($item->title) . '</title>' . "\n";
            $xml .= '      <link>' . htmlspecialchars(route('journals.article', [$item->journal->slug, $item->id])) . '</link>' . "\n";
            $xml .= '      <guid isPermaLink="true">' . htmlspecialchars(route('journals.article', [$item->journal->slug, $item->id])) . '</guid>' . "\n";
            
            if ($item->abstract) {
                $xml .= '      <description>' . htmlspecialchars(strip_tags($item->abstract)) . '</description>' . "\n";
            }
            
            if ($item->published_at) {
                $xml .= '      <pubDate>' . $item->formatPublishedAt('r') . '</pubDate>' . "\n";
            }
            
            // Authors
            if ($item->authors->count() > 0) {
                $authors = $item->authors->map(fn($a) => $a->full_name)->join(', ');
                $xml .= '      <author>' . htmlspecialchars($authors) . '</author>' . "\n";
            }
            
            // DOI
            if ($item->doi) {
                $xml .= '      <doi>' . htmlspecialchars($item->doi) . '</doi>' . "\n";
            }
            
            $xml .= '    </item>' . "\n";
        }

        $xml .= '  </channel>' . "\n";
        $xml .= '</rss>';

        return $xml;
    }
}
