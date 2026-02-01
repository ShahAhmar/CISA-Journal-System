<?php

namespace App\Notifications;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscussionCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $submission;
    public $comment;
    public $commenter;

    public function __construct($submission, $comment, $commenter)
    {
        $this->submission = $submission;
        $this->comment = $comment;
        $this->commenter = $commenter;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $journal = $this->submission->journal;
        
        return (new MailMessage)
            ->subject('New Discussion Comment - ' . $journal->name)
            ->line("Dear {$notifiable->full_name},")
            ->line("A new comment has been added to the discussion thread for: {$this->submission->title}")
            ->line("Comment by: {$this->commenter->full_name}")
            ->line("Comment: " . substr($this->comment, 0, 200) . (strlen($this->comment) > 200 ? '...' : ''))
            ->action('View Discussion', route('author.submissions.show', $this->submission))
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
