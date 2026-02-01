<?php

namespace App\Notifications;

use App\Models\Submission;
use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class SubmissionReceivedNotification extends Notification
{
    use Queueable;

    public $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Ensure mail config is loaded from database
        $this->ensureMailConfig();
        
        $journal = $this->submission->journal;
        $template = $journal->email_templates['submission_received'] ?? null;
        
        if ($template) {
            // Use custom template
            $subject = $this->replacePlaceholders($template['subject'] ?? 'Submission Received', $notifiable);
            $body = $this->replacePlaceholders($template['body'] ?? 'Your submission has been received.', $notifiable);
        } else {
            // Use default template
            $subject = 'Submission Received - ' . $journal->name;
            $body = "Dear {$notifiable->full_name},\n\nYour submission '{$this->submission->title}' has been successfully received and is now under review.";
        }

        return (new MailMessage)
            ->subject($subject)
            ->line($body)
            ->action('View Submission', route('author.submissions.show', $this->submission))
            ->line('Thank you for your submission!');
    }

    private function replacePlaceholders($text, $notifiable)
    {
        $placeholders = [
            '{{author_name}}' => $notifiable->full_name,
            '{{submission_title}}' => $this->submission->title,
            '{{journal_name}}' => $this->submission->journal->name,
            '{{submission_id}}' => $this->submission->id,
            '{{submission_date}}' => $this->submission->formatSubmittedAt('F d, Y') ?? 'N/A',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $text);
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

