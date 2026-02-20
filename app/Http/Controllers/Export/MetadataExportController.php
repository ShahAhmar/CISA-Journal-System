<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\MetadataExportService;
use Illuminate\Http\Request;

class MetadataExportController extends Controller
{
    protected $exportService;

    public function __construct(MetadataExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function exportRIS(Submission $submission)
    {
        $content = $this->exportService->exportRIS($submission);
        
        return response($content)
            ->header('Content-Type', 'application/x-research-info-systems')
            ->header('Content-Disposition', 'attachment; filename="' . $submission->id . '.ris"');
    }

    public function exportBibTeX(Submission $submission)
    {
        $content = $this->exportService->exportBibTeX($submission);
        
        return response($content)
            ->header('Content-Type', 'application/x-bibtex')
            ->header('Content-Disposition', 'attachment; filename="' . $submission->id . '.bib"');
    }

    public function exportXML(Submission $submission)
    {
        $content = $this->exportService->exportXML($submission);
        
        return response($content)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="' . $submission->id . '.xml"');
    }
}

