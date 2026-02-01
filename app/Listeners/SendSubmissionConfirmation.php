<?php

namespace App\Listeners;

use App\Events\SubmissionSubmitted;
use App\Notifications\SubmissionReceivedNotification;

class SendSubmissionConfirmation
{

    public function handle(SubmissionSubmitted $event)
    {
        try {
            // Ensure mail config is loaded
            $this->ensureMailConfig();
            
            $submission = $event->submission;
            
            // Send notification to author
            if ($submission->author) {
                try {
                    $submission->author->notify(new SubmissionReceivedNotification($submission));
                    \Log::info('Submission notification sent to author', [
                        'submission_id' => $submission->id,
                        'author_id' => $submission->author->id
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to send submission notification to author', [
                        'submission_id' => $submission->id,
                        'author_id' => $submission->author->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
            
            // Send notification to editors
            $editors = $submission->journal->editors()->wherePivot('is_active', true)->get();
            foreach ($editors as $editor) {
                try {
                    $editor->notify(new SubmissionReceivedNotification($submission));
                    \Log::info('Submission notification sent to editor', [
                        'submission_id' => $submission->id,
                        'editor_id' => $editor->id
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to send submission notification to editor', [
                        'submission_id' => $submission->id,
                        'editor_id' => $editor->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to process submission confirmation', [
                'submission_id' => $event->submission->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function ensureMailConfig()
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('email_settings')) {
                $emailSetting = \App\Models\EmailSetting::getActive();
                
                if ($emailSetting && !empty($emailSetting->mail_driver)) {
                    \Illuminate\Support\Facades\Config::set('mail.default', 'smtp');
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.transport', 'smtp');
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.host', $emailSetting->mail_host ?? '');
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.port', (int)($emailSetting->mail_port ?? 587));
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.encryption', $emailSetting->mail_encryption ?? 'tls');
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.username', $emailSetting->mail_username ?? '');
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.password', $emailSetting->mail_password ?? '');
                    \Illuminate\Support\Facades\Config::set('mail.from.address', $emailSetting->mail_from_address ?? 'contact@emanp.org');
                    \Illuminate\Support\Facades\Config::set('mail.from.name', $emailSetting->mail_from_name ?? 'EMANP');
                    
                    app()->forgetInstance('mail.manager');
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to load email config in listener: ' . $e->getMessage());
        }
    }
}

