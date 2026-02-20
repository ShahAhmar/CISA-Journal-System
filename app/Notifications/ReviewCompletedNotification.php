<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewCompletedNotification extends Notification implements ShouldQueue
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
        
        return (new MailMessage)
            ->subject('Review Completed - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line("A review has been completed for the submission: {$submission->title}")
            ->line("Reviewer: {$this->review->reviewer->full_name}")
            ->line("Recommendation: " . ucfirst(str_replace('_', ' ', $this->review->recommendation)))
            ->action('View Submission', route('editor.submissions.show', ['journal' => $journal->slug, 'submission' => $submission]))
            ->line('Thank you!');
    }
}
