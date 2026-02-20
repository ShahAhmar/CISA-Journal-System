<?php

namespace App\Listeners;

use App\Events\ReviewCompleted;
use App\Notifications\ReviewCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReviewCompletedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ReviewCompleted $event)
    {
        $review = $event->review;
        $submission = $review->submission;
        
        // Notify editors and journal managers
        $journal = $submission->journal;
        $editors = $journal->users()
            ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
            ->wherePivot('is_active', true)
            ->get();
        
        foreach ($editors as $editor) {
            $editor->notify(new ReviewCompletedNotification($review));
        }
    }
}
