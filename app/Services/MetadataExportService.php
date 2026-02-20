<?php

namespace App\Services;

use App\Models\Submission;
use Carbon\Carbon;

class MetadataExportService
{
    /**
     * Export submission as RIS format
     */
    public function exportRIS(Submission $submission): string
    {
        $ris = "TY  - JOUR\n";
        
        // Title
        $ris .= "TI  - " . $this->escapeRIS($submission->title) . "\n";
        
        // Authors
        foreach ($submission->authors as $author) {
            $ris .= "AU  - " . $this->escapeRIS($author->last_name . ", " . $author->first_name) . "\n";
        }
        
        // Abstract
        if ($submission->abstract) {
            $ris .= "AB  - " . $this->escapeRIS($submission->abstract) . "\n";
        }
        
        // Keywords
        if ($submission->keywords) {
            $keywords = is_array($submission->keywords) ? $submission->keywords : explode(',', $submission->keywords);
            foreach ($keywords as $keyword) {
                $ris .= "KW  - " . $this->escapeRIS(trim($keyword)) . "\n";
            }
        }
        
        // Journal
        if ($submission->journal) {
            $ris .= "T2  - " . $this->escapeRIS($submission->journal->name) . "\n";
            if ($submission->journal->issn) {
                $ris .= "SN  - " . $this->escapeRIS($submission->journal->issn) . "\n";
            }
        }
        
        // DOI
        if ($submission->doi) {
            $ris .= "DO  - " . $this->escapeRIS($submission->doi) . "\n";
        }
        
        // Publication Date
        if ($submission->published_at) {
            $ris .= "PY  - " . $submission->formatPublishedAt('Y') . "\n";
            $ris .= "DA  - " . $submission->formatPublishedAt('Y/m/d') . "\n";
        }
        
        // Issue/Volume
        if ($submission->issue) {
            if ($submission->issue->volume) {
                $ris .= "VL  - " . $this->escapeRIS($submission->issue->volume) . "\n";
            }
            if ($submission->issue->issue_number) {
                $ris .= "IS  - " . $this->escapeRIS($submission->issue->issue_number) . "\n";
            }
        }
        
        // Pages
        if ($submission->pages) {
            $ris .= "SP  - " . $this->escapeRIS($submission->pages) . "\n";
        }
        
        // URL
        if ($submission->journal) {
            $ris .= "UR  - " . route('journals.article', [$submission->journal->slug, $submission->id]) . "\n";
        }
        
        $ris .= "ER  - \n";
        
        return $ris;
    }

    /**
     * Export submission as BibTeX format
     */
    public function exportBibTeX(Submission $submission): string
    {
        $key = 'article_' . $submission->id;
        $bibtex = "@article{" . $key . ",\n";
        
        // Title
        $bibtex .= "  title = {" . $this->escapeBibTeX($submission->title) . "},\n";
        
        // Authors
        $authors = [];
        foreach ($submission->authors as $author) {
            $authors[] = $author->first_name . " " . $author->last_name;
        }
        $bibtex .= "  author = {" . implode(" and ", $authors) . "},\n";
        
        // Journal
        if ($submission->journal) {
            $bibtex .= "  journal = {" . $this->escapeBibTeX($submission->journal->name) . "},\n";
            if ($submission->journal->issn) {
                $bibtex .= "  issn = {" . $this->escapeBibTeX($submission->journal->issn) . "},\n";
            }
        }
        
        // Year
        if ($submission->published_at) {
            $bibtex .= "  year = {" . $submission->formatPublishedAt('Y') . "},\n";
        }
        
        // Volume/Issue
        if ($submission->issue) {
            if ($submission->issue->volume) {
                $bibtex .= "  volume = {" . $this->escapeBibTeX($submission->issue->volume) . "},\n";
            }
            if ($submission->issue->issue_number) {
                $bibtex .= "  number = {" . $this->escapeBibTeX($submission->issue->issue_number) . "},\n";
            }
        }
        
        // Pages
        if ($submission->pages) {
            $bibtex .= "  pages = {" . $this->escapeBibTeX($submission->pages) . "},\n";
        }
        
        // DOI
        if ($submission->doi) {
            $bibtex .= "  doi = {" . $this->escapeBibTeX($submission->doi) . "},\n";
        }
        
        // Abstract
        if ($submission->abstract) {
            $bibtex .= "  abstract = {" . $this->escapeBibTeX($submission->abstract) . "},\n";
        }
        
        // Keywords
        if ($submission->keywords) {
            $keywords = is_array($submission->keywords) ? $submission->keywords : explode(',', $submission->keywords);
            $bibtex .= "  keywords = {" . $this->escapeBibTeX(implode(", ", $keywords)) . "},\n";
        }
        
        // URL
        if ($submission->journal) {
            $bibtex .= "  url = {" . route('journals.article', [$submission->journal->slug, $submission->id]) . "},\n";
        }
        
        $bibtex .= "}";
        
        return $bibtex;
    }

    /**
     * Export submission as XML (CrossRef format)
     */
    public function exportXML(Submission $submission): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<doi_batch xmlns="http://www.crossref.org/schema/4.4.2" version="4.4.2">' . "\n";
        $xml .= '  <head>' . "\n";
        $xml .= '    <doi_batch_id>' . $submission->id . '</doi_batch_id>' . "\n";
        $xml .= '    <timestamp>' . now()->timestamp . '</timestamp>' . "\n";
        $xml .= '  </head>' . "\n";
        $xml .= '  <body>' . "\n";
        $xml .= '    <journal>' . "\n";
        
        if ($submission->journal) {
            $xml .= '      <journal_metadata>' . "\n";
            $xml .= '        <full_title>' . htmlspecialchars($submission->journal->name) . '</full_title>' . "\n";
            if ($submission->journal->issn) {
                $xml .= '        <issn>' . htmlspecialchars($submission->journal->issn) . '</issn>' . "\n";
            }
            $xml .= '      </journal_metadata>' . "\n";
        }
        
        $xml .= '      <journal_article publication_type="full_text">' . "\n";
        $xml .= '        <titles>' . "\n";
        $xml .= '          <title>' . htmlspecialchars($submission->title) . '</title>' . "\n";
        $xml .= '        </titles>' . "\n";
        
        // Authors
        $xml .= '        <contributors>' . "\n";
        foreach ($submission->authors as $index => $author) {
            $sequence = $index === 0 ? 'first' : 'additional';
            $xml .= '          <person_name sequence="' . $sequence . '" contributor_role="author">' . "\n";
            $xml .= '            <given_name>' . htmlspecialchars($author->first_name) . '</given_name>' . "\n";
            $xml .= '            <surname>' . htmlspecialchars($author->last_name) . '</surname>' . "\n";
            if ($author->orcid) {
                $xml .= '            <ORCID>' . htmlspecialchars($author->orcid) . '</ORCID>' . "\n";
            }
            $xml .= '          </person_name>' . "\n";
        }
        $xml .= '        </contributors>' . "\n";
        
        // Abstract
        if ($submission->abstract) {
            $xml .= '        <jats:abstract xmlns:jats="http://www.ncbi.nlm.nih.gov/JATS1">' . "\n";
            $xml .= '          <jats:p>' . htmlspecialchars($submission->abstract) . '</jats:p>' . "\n";
            $xml .= '        </jats:abstract>' . "\n";
        }
        
        // Publication Date
        if ($submission->published_at) {
            $xml .= '        <publication_date>' . "\n";
            $xml .= '          <year>' . $submission->formatPublishedAt('Y') . '</year>' . "\n";
            $xml .= '          <month>' . $submission->formatPublishedAt('m') . '</month>' . "\n";
            $xml .= '          <day>' . $submission->formatPublishedAt('d') . '</day>' . "\n";
            $xml .= '        </publication_date>' . "\n";
        }
        
        // DOI
        if ($submission->doi) {
            $xml .= '        <doi_data>' . "\n";
            $xml .= '          <doi>' . htmlspecialchars($submission->doi) . '</doi>' . "\n";
            $xml .= '          <resource>' . route('journals.article', [$submission->journal->slug, $submission->id]) . '</resource>' . "\n";
            $xml .= '        </doi_data>' . "\n";
        }
        
        $xml .= '      </journal_article>' . "\n";
        $xml .= '    </journal>' . "\n";
        $xml .= '  </body>' . "\n";
        $xml .= '</doi_batch>';
        
        return $xml;
    }

    private function escapeRIS(string $text): string
    {
        return str_replace(["\n", "\r"], [' ', ' '], $text);
    }

    private function escapeBibTeX(string $text): string
    {
        $text = str_replace('\\', '\\textbackslash{}', $text);
        $text = str_replace(['{', '}'], ['\\{', '\\}'], $text);
        $text = str_replace('&', '\\&', $text);
        $text = str_replace('%', '\\%', $text);
        $text = str_replace('$', '\\$', $text);
        $text = str_replace('#', '\\#', $text);
        $text = str_replace('^', '\\textasciicircum{}', $text);
        $text = str_replace('_', '\\_', $text);
        return $text;
    }
}

