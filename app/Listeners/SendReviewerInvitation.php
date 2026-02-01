<?php

namespace App\Listeners;

use App\Events\ReviewerInvited;
use App\Notifications\ReviewerInvitationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReviewerInvitation implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ReviewerInvited $event)
    {
        try {
            // Ensure mail config is loaded
            $this->ensureMailConfig();
            
            $review = $event->review;
            
            // Send invitation to reviewer
            if ($review->reviewer) {
                $review->reviewer->notify(new ReviewerInvitationNotification($review));
                \Log::info('Reviewer invitation sent', [
                    'review_id' => $review->id,
                    'reviewer_id' => $review->reviewer->id
                ]);
            } else {
                \Log::error('Reviewer not found for review invitation', [
                    'review_id' => $review->id
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send reviewer invitation', [
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

