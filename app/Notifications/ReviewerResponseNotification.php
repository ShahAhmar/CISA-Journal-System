<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewerResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $review;
    public $action; // 'accepted' or 'declined'
    public $declineReason;

    public function __construct(Review $review, $action, $declineReason = null)
    {
        $this->review = $review;
        $this->action = $action;
        $this->declineReason = $declineReason;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        $submission = $this->review->submission;
        $journal = $submission->journal;
        $reviewer = $this->review->reviewer;

        $message = $this->action === 'accepted' 
            ? "Reviewer {$reviewer->full_name} has accepted the review request for submission: {$submission->title}"
            : "Reviewer {$reviewer->full_name} has declined the review request for submission: {$submission->title}";

        if ($this->action === 'declined' && $this->declineReason) {
            $message .= "\n\nReason: {$this->declineReason}";
        }

        return [
            'type' => 'reviewer_response',
            'action' => $this->action,
            'review_id' => $this->review->id,
            'submission_id' => $submission->id,
            'submission_title' => $submission->title,
            'journal_id' => $journal->id,
            'journal_name' => $journal->name,
            'journal_slug' => $journal->slug,
            'reviewer_id' => $reviewer->id,
            'reviewer_name' => $reviewer->full_name,
            'decline_reason' => $this->declineReason,
            'message' => $message,
        ];
    }

    public function toMail($notifiable)
    {
        $submission = $this->review->submission;
        $journal = $submission->journal;
        $reviewer = $this->review->reviewer;

        $subject = $this->action === 'accepted' 
            ? "Review Accepted - {$journal->name}"
            : "Review Declined - {$journal->name}";

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->line("Dear {$notifiable->full_name},");

        if ($this->action === 'accepted') {
            $mailMessage->line("Reviewer {$reviewer->full_name} has accepted the review request for the submission: {$submission->title}");
        } else {
            $mailMessage->line("Reviewer {$reviewer->full_name} has declined the review request for the submission: {$submission->title}");
            
            if ($this->declineReason) {
                $mailMessage->line("Reason: {$this->declineReason}");
            }
        }

        $mailMessage->action('View Submission', route('editor.submissions.show', [
            'journal' => $journal->slug,
            'submission' => $submission
        ]))
        ->line('Thank you!');

        return $mailMessage;
    }
}

