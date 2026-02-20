<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CopyeditReadyNotification extends Notification implements ShouldQueue
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
        
        return (new MailMessage)
            ->subject('Copyedited Files Ready for Review - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line("Copyedited files are ready for your review for the submission: {$this->submission->title}")
            ->line("Please review the copyedited manuscript and approve or request changes.")
            ->action('Review Copyedited Files', route('author.submissions.show', $this->submission))
            ->line('Thank you!');
    }
}
