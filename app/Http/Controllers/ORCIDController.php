<?php

namespace App\Http\Controllers;

use App\Services\ORCIDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ORCIDController extends Controller
{
    protected $orcidService;

    public function __construct(ORCIDService $orcidService)
    {
        $this->orcidService = $orcidService;
    }

    /**
     * Redirect to ORCID authorization
     */
    public function redirect()
    {
        $url = $this->orcidService->getAuthorizationUrl();
        return redirect($url);
    }

    /**
     * Handle ORCID callback
     */
    public function callback(Request $request)
    {
        $code = $request->get('code');
        
        if (!$code) {
            return redirect()->route('profile.show')
                ->with('error', 'ORCID authorization failed.');
        }

        $tokenData = $this->orcidService->getAccessToken($code);
        
        if (!$tokenData) {
            return redirect()->route('profile.show')
                ->with('error', 'Failed to get ORCID access token.');
        }

        $accessToken = $tokenData['access_token'] ?? null;
        $orcidId = $tokenData['orcid'] ?? null;

        if (!$accessToken || !$orcidId) {
            return redirect()->route('profile.show')
                ->with('error', 'Invalid ORCID response.');
        }

        // Get profile data
        $profile = $this->orcidService->getProfile($accessToken);

        // Link ORCID to user
        $user = Auth::user();
        $this->orcidService->linkORCID($user, $orcidId, $profile);

        // Store access token
        $user->orcid_access_token = encrypt($accessToken);
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'ORCID account linked successfully!');
    }

    /**
     * Unlink ORCID account
     */
    public function unlink()
    {
        $user = Auth::user();
        $user->orcid = null;
        $user->orcid_data = null;
        $user->orcid_access_token = null;
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'ORCID account unlinked successfully.');
    }
}
