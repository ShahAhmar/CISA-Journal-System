<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionReceivedNotification extends Notification implements ShouldQueue
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
}

