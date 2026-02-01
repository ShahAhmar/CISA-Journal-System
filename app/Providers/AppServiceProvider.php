<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\EmailSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Force app name to EMANP
        Config::set('app.name', 'EMANP');

        // Force correct APP_URL (remove /public if present)
        $appUrl = config('app.url');
        if ($appUrl && strpos($appUrl, '/public') !== false) {
            $appUrl = str_replace('/public', '', $appUrl);
            $appUrl = rtrim($appUrl, '/');
            Config::set('app.url', $appUrl);
        }
        // Force URL root to match APP_URL (fixes route generation)
        if ($appUrl = config('app.url')) {
            URL::forceRootUrl($appUrl);
        }

        // Set locale from session
        if (Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
        }

        // Load email settings from database
        try {
            if (Schema::hasTable('email_settings')) {
                $emailSetting = EmailSetting::getActive();

                if ($emailSetting && !empty($emailSetting->mail_driver)) {
                    // Ensure mail.mailers.smtp.transport is set
                    Config::set('mail.mailers.smtp.transport', 'smtp');
                    Config::set('mail.mailers.smtp.host', $emailSetting->mail_host ?? '');
                    Config::set('mail.mailers.smtp.port', $emailSetting->mail_port ?? 587);
                    Config::set('mail.mailers.smtp.encryption', $emailSetting->mail_encryption ?? 'tls');
                    Config::set('mail.mailers.smtp.username', $emailSetting->mail_username ?? '');
                    Config::set('mail.mailers.smtp.password', $emailSetting->mail_password ?? '');
                    Config::set('mail.from.address', $emailSetting->mail_from_address ?? 'noreply@example.com');
                    // Force EMANP if database has old value
                    $fromName = $emailSetting->mail_from_name ?? 'EMANP';
                    if ($fromName === 'Multi-Journal System' || empty($fromName)) {
                        $fromName = 'EMANP';
                        // Update database too
                        try {
                            $emailSetting->mail_from_name = 'EMANP';
                            $emailSetting->save();
                        } catch (\Exception $e) {
                            // Ignore if can't update
                        }
                    }
                    Config::set('mail.from.name', $fromName);

                    // Validate mail_driver is a valid transport
                    $validDrivers = ['smtp', 'sendmail', 'mailgun', 'ses', 'postmark', 'log'];
                    $driver = in_array($emailSetting->mail_driver, $validDrivers)
                        ? $emailSetting->mail_driver
                        : 'log';
                    Config::set('mail.default', $driver);
                } else {
                    // Fallback to log driver if no settings configured
                    Config::set('mail.default', 'log');
                }
            } else {
                // Table doesn't exist, use log driver as fallback
                Config::set('mail.default', 'log');
            }
        } catch (\Exception $e) {
            // If table doesn't exist yet, use log driver
            // This prevents errors during migration
            Config::set('mail.default', 'log');
        }

        // Ensure mail.default is always set to a valid value
        if (empty(Config::get('mail.default'))) {
            Config::set('mail.default', 'log');
        }

        // Ensure uploads directory exists
        $uploadsPath = public_path('uploads');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0755, true);
        }

        // Create subdirectories
        $subdirs = ['journals/logos', 'journals/covers', 'journals/favicons', 'submissions', 'users/profiles'];
        foreach ($subdirs as $subdir) {
            $path = $uploadsPath . '/' . $subdir;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }

        // Share Website Settings globally
        try {
            if (Schema::hasTable('website_settings')) {
                $siteSettings = \App\Models\WebsiteSetting::first();
                if (!$siteSettings) {
                    // Create default settings if none exist
                    $siteSettings = \App\Models\WebsiteSetting::create([
                        'homepage_title' => 'CISA Interdisciplinary Journal',
                        'footer_text' => '© ' . date('Y') . ' CISA Interdisciplinary Journal. All rights reserved.',
                    ]);
                }
                \Illuminate\Support\Facades\View::share('siteSettings', $siteSettings);
            }
        } catch (\Exception $e) {
            // Prevent errors if table doesn't exist yet
        }
    }
}
