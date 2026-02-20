<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class SettingsApiController extends Controller
{
    /**
     * Get website settings
     */
    public function index(Request $request)
    {
        $settings = WebsiteSetting::getSettings();
        $locale = $request->get('locale', app()->getLocale());

        return response()->json([
            'success' => true,
            'data' => [
                'logo' => $settings->logo ? asset($settings->logo) : null,
                'favicon' => $settings->favicon ? asset($settings->favicon) : null,
                'homepage_title' => $settings->homepage_title ?? 'CISA Interdisciplinary Journal (CIJ)',
                'homepage_description' => $settings->homepage_description ?? 'A Platform for Interdisciplinary Research Excellence',
                'contact_email' => $settings->contact_email,
                'contact_phone' => $settings->contact_phone,
                'whatsapp_number' => '+27734030207',
                'locale' => $locale,
                'supported_languages' => ['en', 'fr', 'es', 'pt', 'sw'],
            ],
        ]);
    }
}


