<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GalleyReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
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
            ->subject('Galley Ready for Production - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line("Galleys are ready for production review for the submission: {$this->submission->title}")
            ->line("Please review the galleys and approve for publication.")
            ->action('Review Galleys', route('author.submissions.show', $this->submission))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
