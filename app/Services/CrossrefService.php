<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\Journal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrossrefService
{
    protected $apiUrl = 'https://api.crossref.org/works';
    protected $depositUrl = 'https://doi.crossref.org/servlet/deposit';
    
    /**
     * Generate DOI for a submission
     */
    public function generateDOI(Submission $submission): ?string
    {
        $journal = $submission->journal;
        
        if (!$journal->doi_prefix || !$journal->doi_enabled) {
            return null;
        }
        
        // Generate DOI: prefix/journal-slug/submission-id
        $doi = $journal->doi_prefix . '/' . $journal->slug . '.' . $submission->id;
        
        return $doi;
    }
    
    /**
     * Register DOI with Crossref
     */
    public function registerDOI(Submission $submission): bool
    {
        try {
            $journal = $submission->journal;
            
            if (!$journal->doi_prefix || !$journal->doi_enabled) {
                return false;
            }
            
            // Generate DOI if not exists
            if (!$submission->doi) {
                $doi = $this->generateDOI($submission);
                $submission->doi = $doi;
                $submission->save();
            }
            
            // Get Crossref credentials from config
            $username = config('services.crossref.username');
            $password = config('services.crossref.password');
            
            if (!$username || !$password) {
                Log::warning('Crossref credentials not configured');
                return false;
            }
            
            // Generate XML metadata
            $xml = $this->generateDepositXML($submission);
            
            // Deposit to Crossref
            $response = Http::withBasicAuth($username, $password)
                ->withHeaders([
                    'Content-Type' => 'application/vnd.crossref.deposit+xml',
                ])
                ->post($this->depositUrl, $xml);
            
            if ($response->successful()) {
                Log::info('DOI registered with Crossref', [
                    'submission_id' => $submission->id,
                    'doi' => $submission->doi
                ]);
                return true;
            } else {
                Log::error('Failed to register DOI with Crossref', [
                    'submission_id' => $submission->id,
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error registering DOI with Crossref', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Generate Crossref deposit XML
     */
    protected function generateDepositXML(Submission $submission): string
    {
        $journal = $submission->journal;
        $metadataService = new MetadataExportService();
        
        // Use existing XML export but format for deposit
        $xml = $metadataService->exportXML($submission);
        
        return $xml;
    }
    
    /**
     * Check if DOI exists in Crossref
     */
    public function checkDOI(string $doi): bool
    {
        try {
            $response = Http::get($this->apiUrl . '/' . urlencode($doi));
            
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Get citation count from Crossref
     */
    public function getCitationCount(string $doi): int
    {
        try {
            $response = Http::get($this->apiUrl . '/' . urlencode($doi));
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['message']['is-referenced-by-count'] ?? 0;
            }
            
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}

