<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $emailSettings = EmailSetting::getActive();
        return view('admin.system-settings.index', compact('emailSettings'));
    }

    public function updateSmtp(Request $request)
    {
        $validated = $request->validate([
            'mail_driver' => ['required', 'string', 'in:smtp,sendmail,mailgun,ses,postmark,log'],
            'mail_host' => ['required', 'string', 'max:255'],
            'mail_port' => ['required', 'string', 'max:10'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['required', 'string', 'in:tls,ssl'],
            'mail_from_address' => ['required', 'email', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
        ]);

        $emailSetting = EmailSetting::first();
        
        if (!$emailSetting) {
            $emailSetting = new EmailSetting();
        }

        // Only update password if provided
        if (empty($validated['mail_password'])) {
            unset($validated['mail_password']);
        }

        $emailSetting->fill($validated);
        $emailSetting->is_active = true;
        $emailSetting->save();

        // Update config cache
        $this->updateMailConfig($emailSetting);

        return redirect()->route('admin.system-settings.index')
            ->with('success', 'SMTP settings saved successfully!');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => ['required', 'email'],
        ]);

        try {
            $emailSetting = EmailSetting::getActive();
            if (!$emailSetting) {
                return back()->with('error', 'Please configure SMTP settings first.');
            }

            // Validate required fields
            if (empty($emailSetting->mail_driver)) {
                return back()->with('error', 'Mail driver is not configured. Please save SMTP settings first.');
            }

            if (empty($emailSetting->mail_host)) {
                return back()->with('error', 'SMTP host is not configured.');
            }

            $this->updateMailConfig($emailSetting);

            // Refresh mail manager to apply new config
            app()->make('mail.manager');

            // Use Mail facade - it will use the default mailer we just set
            \Illuminate\Support\Facades\Mail::raw('This is a test email from EMANP. If you receive this, your SMTP configuration is working correctly!', function ($message) use ($request, $emailSetting) {
                $message->to($request->test_email)
                        ->subject('EMANP - Test Email')
                        ->from($emailSetting->mail_from_address, $emailSetting->mail_from_name);
            });

            return back()->with('success', 'Test email sent successfully to ' . $request->test_email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    private function updateMailConfig(EmailSetting $emailSetting)
    {
        // Set default mailer - must be 'smtp' for SMTP transport
        Config::set('mail.default', 'smtp');
        
        // Set SMTP mailer configuration
        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.host', $emailSetting->mail_host ?? '');
        Config::set('mail.mailers.smtp.port', (int)($emailSetting->mail_port ?? 587));
        Config::set('mail.mailers.smtp.encryption', $emailSetting->mail_encryption ?? 'tls');
        Config::set('mail.mailers.smtp.username', $emailSetting->mail_username ?? '');
        Config::set('mail.mailers.smtp.password', $emailSetting->mail_password ?? '');
        Config::set('mail.mailers.smtp.timeout', null);
        Config::set('mail.mailers.smtp.auth_mode', null);
        
        // Set from address and name
        Config::set('mail.from.address', $emailSetting->mail_from_address ?? '');
        Config::set('mail.from.name', $emailSetting->mail_from_name ?? 'EMANP');
    }
}
