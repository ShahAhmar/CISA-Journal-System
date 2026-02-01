<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ORCIDService
{
    protected $apiUrl = 'https://orcid.org/oauth';
    protected $apiBaseUrl = 'https://api.orcid.org/v3.0';
    
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    
    public function __construct()
    {
        $this->clientId = config('services.orcid.client_id');
        $this->clientSecret = config('services.orcid.client_secret');
        $this->redirectUri = config('services.orcid.redirect_uri', route('orcid.callback'));
    }
    
    /**
     * Get ORCID authorization URL
     */
    public function getAuthorizationUrl(): string
    {
        $params = [
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'scope' => '/authenticate /read-public',
            'redirect_uri' => $this->redirectUri,
        ];
        
        return $this->apiUrl . '/authorize?' . http_build_query($params);
    }
    
    /**
     * Exchange authorization code for access token
     */
    public function getAccessToken(string $code): ?array
    {
        try {
            $response = Http::asForm()->post($this->apiUrl . '/token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error getting ORCID access token', ['error' => $e->getMessage()]);
            return null;
        }
    }
    
    /**
     * Get ORCID profile information
     */
    public function getProfile(string $accessToken): ?array
    {
        try {
            $response = Http::withToken($accessToken)
                ->get($this->apiBaseUrl . '/{orcid}/person');
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error getting ORCID profile', ['error' => $e->getMessage()]);
            return null;
        }
    }
    
    /**
     * Link ORCID to user account
     */
    public function linkORCID(User $user, string $orcidId, array $profileData = []): bool
    {
        try {
            $user->orcid = $orcidId;
            
            if (!empty($profileData)) {
                // Store additional profile data if needed
                $user->orcid_data = json_encode($profileData);
            }
            
            $user->save();
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error linking ORCID', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Verify ORCID ID format
     */
    public function isValidORCID(string $orcid): bool
    {
        // ORCID format: 0000-0000-0000-0000 (16 digits with hyphens)
        return preg_match('/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/', $orcid) === 1;
    }
    
    /**
     * Get ORCID public profile (no auth required)
     */
    public function getPublicProfile(string $orcid): ?array
    {
        try {
            $cacheKey = "orcid_profile_{$orcid}";
            
            return Cache::remember($cacheKey, 3600, function () use ($orcid) {
                $response = Http::get($this->apiBaseUrl . '/' . $orcid . '/person');
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            });
        } catch (\Exception $e) {
            return null;
        }
    }
}

