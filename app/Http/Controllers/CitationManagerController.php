<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class CitationManagerController extends Controller
{
    /**
     * Export to Zotero format (RIS)
     */
    public function exportZotero(Submission $submission)
    {
        $metadataService = new \App\Services\MetadataExportService();
        $ris = $metadataService->exportRIS($submission);
        
        return response($ris, 200)
            ->header('Content-Type', 'application/x-research-info-systems')
            ->header('Content-Disposition', 'attachment; filename="' . $submission->id . '.ris"');
    }
    
    /**
     * Export to Mendeley format (RIS)
     */
    public function exportMendeley(Submission $submission)
    {
        // Mendeley uses RIS format
        return $this->exportZotero($submission);
    }
    
    /**
     * Export to EndNote format
     */
    public function exportEndNote(Submission $submission)
    {
        $metadataService = new \App\Services\MetadataExportService();
        $ris = $metadataService->exportRIS($submission);
        
        return response($ris, 200)
            ->header('Content-Type', 'application/x-endnote-refer')
            ->header('Content-Disposition', 'attachment; filename="' . $submission->id . '.enw"');
    }
    
    /**
     * Generate citation in various formats
     */
    public function citation(Submission $submission, Request $request)
    {
        $format = $request->get('format', 'apa'); // apa, mla, chicago, harvard
        
        $citation = $this->generateCitation($submission, $format);
        
        return response()->json([
            'format' => $format,
            'citation' => $citation,
        ]);
    }
    
    /**
     * Generate citation text
     */
    protected function generateCitation(Submission $submission, string $format): string
    {
        $authors = $submission->authors->map(fn($a) => $a->last_name . ', ' . $a->first_name)->join(', ');
        $year = $submission->formatPublishedAt('Y') ?? date('Y');
        $title = $submission->title;
        $journal = $submission->journal->name ?? '';
        $url = route('journals.article', [$submission->journal->slug, $submission->id]);
        
        switch ($format) {
            case 'apa':
                return "{$authors} ({$year}). {$title}. {$journal}. {$url}";
            case 'mla':
                return "{$authors}. \"{$title}.\" {$journal}, {$year}, {$url}";
            case 'chicago':
                return "{$authors}. \"{$title}.\" {$journal} ({$year}). {$url}";
            case 'harvard':
                return "{$authors} {$year}, '{$title}', {$journal}, viewed {$year}, {$url}";
            default:
                return "{$authors} ({$year}). {$title}. {$journal}";
        }
    }
}
