<?php

namespace App\Notifications;

use App\Models\Submission;
use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class SubmissionStatusChangedNotification extends Notification
{
    use Queueable;

    public $submission;
    public $oldStatus;
    public $newStatus;

    public function __construct(Submission $submission, $oldStatus, $newStatus)
    {
        $this->submission = $submission;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
        
        // Try to use custom email template
        $templateKey = $this->getTemplateKey();
        $template = $journal->email_templates[$templateKey] ?? null;
        
        if ($template && isset($template['subject']) && isset($template['body'])) {
            // Use custom template
            $subject = $this->replacePlaceholders($template['subject'], $notifiable);
            $body = $this->replacePlaceholders($template['body'], $notifiable);
            
            $mail = (new MailMessage)
                ->subject($subject);
            
            // Split body into lines for proper formatting
            $lines = explode("\n", $body);
            foreach ($lines as $line) {
                if (trim($line)) {
                    $mail->line(trim($line));
                }
            }
            
            return $mail->action('View Submission', route('author.submissions.show', $this->submission));
        }
        
        // Default template
        $statusMessages = [
            'accepted' => 'Congratulations! Your submission has been accepted for publication.',
            'rejected' => 'We regret to inform you that your submission has been rejected.',
            'revision_requested' => 'Your submission requires revisions. Please check the editor comments.',
            'disabled' => 'We regret to inform you that your submission has been disabled by the administrator. Please contact the journal administration for more information.',
            'deleted' => 'We regret to inform you that your submission has been deleted by the administrator. Please contact the journal administration for more information.',
        ];

        $message = $statusMessages[$this->newStatus] ?? "Your submission status has been changed to: {$this->newStatus}";
        
        // Add current stage information
        $stageMessages = [
            'submission' => 'Your submission is in the initial submission stage.',
            'review' => 'Your submission is currently under review by our editorial team.',
            'revision' => 'Your submission requires revisions. Please submit the revised version.',
            'copyediting' => 'Your submission is in the copyediting stage.',
            'proofreading' => 'Your submission is in the proofreading stage.',
            'layout' => 'Your submission is in the layout stage.',
            'production' => 'Your submission is in the production stage, ready for final publishing.',
            'published' => 'Your submission has been published.',
        ];
        
        $stageMessage = $stageMessages[$this->submission->current_stage] ?? '';
        $currentStage = ucfirst(str_replace('_', ' ', $this->submission->current_stage));

        $mail = (new MailMessage)
            ->subject('Submission Status Update - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line($message)
            ->line("Submission: {$this->submission->title}");
        
        // Add stage information if available
        if ($stageMessage) {
            $mail->line('')
                 ->line("Current Stage: {$currentStage}")
                 ->line($stageMessage);
        }
        
        // Only add action button if submission is not deleted
        if ($this->newStatus !== 'deleted') {
            $mail->action('View Submission', route('author.submissions.show', $this->submission));
        }
        
        return $mail->line('Thank you!');
    }
    
    private function getTemplateKey()
    {
        $map = [
            'accepted' => 'acceptance_letter',
            'rejected' => 'rejection_letter',
            'revision_requested' => 'revision_requested',
            'disabled' => 'rejection_letter', // Use rejection template for disabled
            'deleted' => 'rejection_letter', // Use rejection template for deleted
        ];
        
        return $map[$this->newStatus] ?? 'submission_received';
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

