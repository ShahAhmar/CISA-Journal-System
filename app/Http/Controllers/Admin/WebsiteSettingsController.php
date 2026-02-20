<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::getSettings();
        return view('admin.website-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'favicon' => ['nullable', 'image', 'mimes:ico,png', 'max:1024'],
            'homepage_title' => ['nullable', 'string', 'max:255'],
            'homepage_description' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);

        $settings = WebsiteSetting::first();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings && $settings->logo) {
                $oldLogoPath = strpos($settings->logo, 'uploads/') === 0 
                    ? public_path($settings->logo)
                    : storage_path('app/public/' . $settings->logo);
                if (file_exists($oldLogoPath)) {
                    @unlink($oldLogoPath);
                }
            }
            // Store in public/uploads/website/logo for better compatibility
            $logoPath = public_path('uploads/website/logo');
            if (!file_exists($logoPath)) {
                mkdir($logoPath, 0755, true);
            }
            $logoName = time() . '_' . uniqid() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move($logoPath, $logoName);
            $validated['logo'] = 'uploads/website/logo/' . $logoName;
        } else {
            unset($validated['logo']);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings && $settings->favicon) {
                $oldFaviconPath = strpos($settings->favicon, 'uploads/') === 0 
                    ? public_path($settings->favicon)
                    : storage_path('app/public/' . $settings->favicon);
                if (file_exists($oldFaviconPath)) {
                    @unlink($oldFaviconPath);
                }
            }
            // Store in public/uploads/website/favicon
            $faviconPath = public_path('uploads/website/favicon');
            if (!file_exists($faviconPath)) {
                mkdir($faviconPath, 0755, true);
            }
            $faviconName = time() . '_' . uniqid() . '.' . $request->file('favicon')->getClientOriginalExtension();
            $request->file('favicon')->move($faviconPath, $faviconName);
            $validated['favicon'] = 'uploads/website/favicon/' . $faviconName;
        } else {
            unset($validated['favicon']);
        }

        if ($settings) {
            $settings->update($validated);
        } else {
            WebsiteSetting::create($validated);
        }

        return redirect()->route('admin.website-settings.index')
            ->with('success', 'Website settings updated successfully!');
    }
}

