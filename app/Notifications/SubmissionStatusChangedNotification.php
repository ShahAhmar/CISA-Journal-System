<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionStatusChangedNotification extends Notification implements ShouldQueue
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
        ];

        $message = $statusMessages[$this->newStatus] ?? "Your submission status has been changed to: {$this->newStatus}";

        return (new MailMessage)
            ->subject('Submission Status Update - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line($message)
            ->line("Submission: {$this->submission->title}")
            ->action('View Submission', route('author.submissions.show', $this->submission))
            ->line('Thank you!');
    }
    
    private function getTemplateKey()
    {
        $map = [
            'accepted' => 'acceptance_letter',
            'rejected' => 'rejection_letter',
            'revision_requested' => 'revision_requested',
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
}

