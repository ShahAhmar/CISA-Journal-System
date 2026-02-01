<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class AnnouncementNotification extends Notification
{
    use Queueable;

    public function __construct(public Announcement $announcement)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $journalName = $this->announcement->journal ? $this->announcement->journal->name : 'EMANP';
        $announcementUrl = $this->announcement->journal 
            ? route('journals.announcements', $this->announcement->journal)
            : route('journals.index');

        $mailMessage = (new MailMessage)
            ->subject($this->announcement->title . ' - ' . $journalName)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new announcement has been published:')
            ->line('**' . $this->announcement->title . '**')
            ->line('')
            ->line(Str::limit(strip_tags($this->announcement->content), 300))
            ->action('Read Full Announcement', $announcementUrl)
            ->line('')
            ->line('Journal: ' . $journalName)
            ->salutation('Regards, EMANP');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'announcement_id' => $this->announcement->id,
            'title' => $this->announcement->title,
        ];
    }
}
