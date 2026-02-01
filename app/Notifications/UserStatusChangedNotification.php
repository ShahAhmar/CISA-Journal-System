<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetting;

class UserStatusChangedNotification extends Notification
{
    use Queueable;

    public $action;
    public $reason;

    public function __construct($action, $reason = null)
    {
        $this->action = $action; // disabled, suspended, terminated, deleted, enabled, reactivated
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Ensure mail config is loaded from database
        $this->ensureMailConfig();
        
        $messages = [
            'disabled' => [
                'subject' => 'Account Disabled - EMANP',
                'message' => 'Your account has been disabled by the administrator. You will not be able to access your account until it is re-enabled.',
            ],
            'suspended' => [
                'subject' => 'Account Suspended - EMANP',
                'message' => 'Your account has been suspended by the administrator. Your account access has been temporarily restricted.',
            ],
            'terminated' => [
                'subject' => 'Account Terminated - EMANP',
                'message' => 'Your account has been terminated by the administrator. Your account access has been permanently revoked.',
            ],
            'deleted' => [
                'subject' => 'Account Deleted - EMANP',
                'message' => 'Your account has been deleted by the administrator. All your account data has been removed from the system.',
            ],
            'enabled' => [
                'subject' => 'Account Enabled - EMANP',
                'message' => 'Your account has been enabled by the administrator. You can now access your account normally.',
            ],
            'reactivated' => [
                'subject' => 'Account Reactivated - EMANP',
                'message' => 'Your account has been reactivated by the administrator. You can now access your account normally.',
            ],
        ];

        $config = $messages[$this->action] ?? [
            'subject' => 'Account Status Changed - EMANP',
            'message' => 'Your account status has been changed by the administrator.',
        ];

        $mail = (new MailMessage)
            ->subject($config['subject'])
            ->line("Dear {$notifiable->full_name},")
            ->line($config['message']);

        if ($this->reason) {
            $mail->line('Reason: ' . $this->reason);
        }

        if (in_array($this->action, ['enabled', 'reactivated'])) {
            $mail->action('Login to Your Account', route('login'))
                ->line('If you have any questions, please contact the administrator.');
        } else {
            $mail->line('If you believe this is an error or have any questions, please contact the administrator immediately.');
        }

        return $mail->line('Thank you for your understanding.');
    }
    
    protected function ensureMailConfig()
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('email_settings')) {
                $emailSetting = EmailSetting::getActive();
                
                if ($emailSetting && !empty($emailSetting->mail_driver)) {
                    Config::set('mail.default', 'smtp');
                    Config::set('mail.mailers.smtp.transport', 'smtp');
                    Config::set('mail.mailers.smtp.host', $emailSetting->mail_host ?? '');
                    Config::set('mail.mailers.smtp.port', (int)($emailSetting->mail_port ?? 587));
                    Config::set('mail.mailers.smtp.encryption', $emailSetting->mail_encryption ?? 'tls');
                    Config::set('mail.mailers.smtp.username', $emailSetting->mail_username ?? '');
                    Config::set('mail.mailers.smtp.password', $emailSetting->mail_password ?? '');
                    Config::set('mail.from.address', $emailSetting->mail_from_address ?? 'contact@emanp.org');
                    Config::set('mail.from.name', $emailSetting->mail_from_name ?? 'EMANP');
                    
                    app()->forgetInstance('mail.manager');
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to load email config in notification: ' . $e->getMessage());
        }
    }
}

