<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = [
            'en' => ['name' => 'English', 'native' => 'English', 'flag' => '🇬🇧'],
            'fr' => ['name' => 'French', 'native' => 'Français', 'flag' => '🇫🇷'],
            'es' => ['name' => 'Spanish', 'native' => 'Español', 'flag' => '🇪🇸'],
            'pt' => ['name' => 'Portuguese', 'native' => 'Português', 'flag' => '🇵🇹'],
            'sw' => ['name' => 'Swahili', 'native' => 'Kiswahili', 'flag' => '🇹🇿'],
        ];
        
        $currentLocale = app()->getLocale();
        $langPath = resource_path('lang');
        
        $langStats = [];
        foreach ($languages as $code => $info) {
            $langDir = $langPath . '/' . $code;
            $fileCount = File::exists($langDir) ? count(File::files($langDir)) : 0;
            $langStats[$code] = [
                'info' => $info,
                'files' => $fileCount,
                'is_active' => $code === $currentLocale,
            ];
        }
        
        return view('admin.languages.index', [
            'languages' => $langStats,
            'currentLocale' => $currentLocale,
        ]);
    }

    public function setDefault(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:en,fr,es,pt,sw',
        ]);

        // Update config or database setting
        Config::set('app.locale', $request->locale);
        
        return redirect()->route('admin.languages.index')
            ->with('success', 'Default language updated successfully!');
    }
}
