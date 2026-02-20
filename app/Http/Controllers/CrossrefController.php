<?php

namespace App\Http\Controllers;

use App\Services\CrossrefService;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrossrefController extends Controller
{
    protected $crossrefService;

    public function __construct(CrossrefService $crossrefService)
    {
        $this->crossrefService = $crossrefService;
    }

    /**
     * Register DOI for a submission
     */
    public function registerDOI(Submission $submission)
    {
        // Check authorization
        if (!Auth::user()->can('access-admin') && 
            !Auth::user()->hasJournalRole($submission->journal_id, ['journal_manager', 'editor'])) {
            abort(403);
        }

        $result = $this->crossrefService->registerDOI($submission);

        if ($result) {
            return back()->with('success', 'DOI registered with Crossref successfully!');
        }

        return back()->with('error', 'Failed to register DOI with Crossref. Please check your credentials.');
    }

    /**
     * Generate DOI for a submission
     */
    public function generateDOI(Submission $submission)
    {
        if (!Auth::user()->can('access-admin') && 
            !Auth::user()->hasJournalRole($submission->journal_id, ['journal_manager', 'editor'])) {
            abort(403);
        }

        $doi = $this->crossrefService->generateDOI($submission);
        
        if ($doi) {
            $submission->doi = $doi;
            $submission->save();
            
            return back()->with('success', 'DOI generated successfully: ' . $doi);
        }

        return back()->with('error', 'Failed to generate DOI. Please ensure DOI prefix is configured for this journal.');
    }

    /**
     * Check DOI status
     */
    public function checkDOI(Submission $submission)
    {
        if (!$submission->doi) {
            return response()->json(['exists' => false, 'message' => 'No DOI assigned']);
        }

        $exists = $this->crossrefService->checkDOI($submission->doi);
        $citationCount = $this->crossrefService->getCitationCount($submission->doi);

        return response()->json([
            'exists' => $exists,
            'citation_count' => $citationCount,
            'doi' => $submission->doi
        ]);
    }
}
