<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
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

        // Set app name to CISA Interdisciplinary Journal
        Config::set('app.name', 'CISA Interdisciplinary Journal');
        
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
                    // Set default from name to CISA Interdisciplinary Journal
                    $fromName = $emailSetting->mail_from_name ?? 'CISA Interdisciplinary Journal';
                    if ($fromName === 'Multi-Journal System' || $fromName === 'EMANP' || empty($fromName)) {
                        $fromName = 'CISA Interdisciplinary Journal';
                        // Update database too
                        try {
                            $emailSetting->mail_from_name = 'CISA Interdisciplinary Journal';
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
    }
}
