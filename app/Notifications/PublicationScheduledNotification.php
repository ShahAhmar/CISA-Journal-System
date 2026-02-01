<?php

namespace App\Notifications;

use App\Models\Submission;
use App\Models\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublicationScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $submission;
    public $issue;
    public $scheduledDate;

    public function __construct($submission, $issue, $scheduledDate)
    {
        $this->submission = $submission;
        $this->issue = $issue;
        $this->scheduledDate = $scheduledDate;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $journal = $this->submission->journal;
        $date = \Carbon\Carbon::parse($this->scheduledDate)->format('F d, Y');
        
        return (new MailMessage)
            ->subject('Publication Scheduled - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line("Your submission has been scheduled for publication:")
            ->line("Title: {$this->submission->title}")
            ->line("Issue: {$this->issue->title}")
            ->line("Scheduled Date: {$date}")
            ->action('View Submission', route('author.submissions.show', $this->submission))
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
