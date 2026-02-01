<?php

namespace App\Listeners;

use App\Events\SubmissionStatusChanged;
use App\Notifications\SubmissionStatusChangedNotification;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SendStatusChangeNotification
{

    public function handle(SubmissionStatusChanged $event)
    {
        try {
            // Ensure mail config is loaded
            $this->ensureMailConfig();
            
            $submission = $event->submission;
            
            // Send notification to author about status change
            if ($submission->author) {
                $submission->author->notify(
                    new SubmissionStatusChangedNotification($submission, $event->oldStatus, $event->newStatus)
                );
                Log::info('Status change notification sent to author', [
                    'submission_id' => $submission->id,
                    'author_id' => $submission->author->id,
                    'old_status' => $event->oldStatus,
                    'new_status' => $event->newStatus
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send status change notification', [
                'submission_id' => $event->submission->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to retry if queue is configured
        }
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
            Log::warning('Failed to load email config in listener: ' . $e->getMessage());
        }
    }
}

