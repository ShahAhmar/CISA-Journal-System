<?php

namespace App\Listeners;

use App\Events\ReviewerInvited;
use App\Notifications\ReviewerInvitationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReviewerInvitation implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ReviewerInvited $event)
    {
        try {
            $review = $event->review;
            
            // Send invitation to reviewer
            if ($review->reviewer) {
                $review->reviewer->notify(new ReviewerInvitationNotification($review));
            } else {
                \Log::error('Reviewer not found for review invitation', [
                    'review_id' => $review->id
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send reviewer invitation', [
                'review_id' => $event->review->id ?? null,
                'error' => $e->getMessage()
            ]);
        }
    }
}

