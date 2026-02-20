<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switch(Request $request)
    {
        $locale = $request->get('locale', 'en');
        
        // Validate locale
        $supportedLocales = ['en', 'fr', 'es', 'pt', 'sw'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }
        
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return redirect()->back();
    }
    
    /**
     * Get current language
     */
    public function current()
    {
        return response()->json([
            'locale' => App::getLocale(),
            'supported' => ['en', 'fr', 'es', 'pt', 'sw']
        ]);
    }
}
