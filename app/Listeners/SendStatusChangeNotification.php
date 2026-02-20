<?php

namespace App\Listeners;

use App\Events\SubmissionStatusChanged;
use App\Notifications\SubmissionStatusChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStatusChangeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(SubmissionStatusChanged $event)
    {
        $submission = $event->submission;
        
        // Send notification to author about status change
        $submission->author->notify(
            new SubmissionStatusChangedNotification($submission, $event->oldStatus, $event->newStatus)
        );
    }
}

