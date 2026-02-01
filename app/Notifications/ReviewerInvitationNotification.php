<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewerInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $submission = $this->review->submission;
        $journal = $submission->journal;
        
        $template = $journal->email_templates['reviewer_invitation'] ?? null;
        
        if ($template) {
            $subject = $this->replacePlaceholders($template['subject'] ?? 'Review Invitation', $notifiable);
            $body = $this->replacePlaceholders($template['body'] ?? 'You have been invited to review a submission.', $notifiable);
        } else {
            $subject = 'Review Invitation - ' . $journal->name;
            $body = "Dear {$notifiable->full_name},\n\nYou have been invited to review the submission '{$submission->title}'.\n\nDue Date: {$this->review->due_date->format('F d, Y')}";
        }

        return (new MailMessage)
            ->subject($subject)
            ->line($body)
            ->action('Accept/Decline Review', route('reviewer.reviews.show', $this->review))
            ->line('Thank you for your contribution!');
    }

    private function replacePlaceholders($text, $notifiable)
    {
        $placeholders = [
            '{{reviewer_name}}' => $notifiable->full_name,
            '{{submission_title}}' => $this->review->submission->title,
            '{{journal_name}}' => $this->review->submission->journal->name,
            '{{due_date}}' => $this->review->due_date->format('F d, Y'),
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $text);
    }
}

