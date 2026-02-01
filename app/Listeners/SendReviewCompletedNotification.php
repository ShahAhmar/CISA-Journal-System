<?php

namespace App\Listeners;

use App\Events\ReviewCompleted;
use App\Notifications\ReviewCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReviewCompletedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ReviewCompleted $event)
    {
        try {
            // Ensure mail config is loaded
            $this->ensureMailConfig();
            
            $review = $event->review;
            $submission = $review->submission;
            
            // Notify editors and journal managers
            $journal = $submission->journal;
            $editors = $journal->users()
                ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
                ->wherePivot('is_active', true)
                ->get();
            
            foreach ($editors as $editor) {
                try {
                    $editor->notify(new ReviewCompletedNotification($review));
                    \Log::info('Review completed notification sent to editor', [
                        'review_id' => $review->id,
                        'editor_id' => $editor->id
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to send review completed notification to editor', [
                        'review_id' => $review->id,
                        'editor_id' => $editor->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to process review completed notification', [
                'review_id' => $event->review->id ?? null,
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
