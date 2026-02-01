<?php

namespace App\Listeners;

use App\Events\PublicationScheduled;
use App\Notifications\PublicationScheduledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPublicationScheduledNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PublicationScheduled $event)
    {
        $submission = $event->submission;
        $issue = $event->issue;
        
        // Notify author
        if ($submission->author) {
            $submission->author->notify(new PublicationScheduledNotification($submission, $issue, $event->scheduledDate));
        }
        
        // Notify editors
        $journal = $submission->journal;
        $editors = $journal->users()
            ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
            ->wherePivot('is_active', true)
            ->get();
        
        foreach ($editors as $editor) {
            $editor->notify(new PublicationScheduledNotification($submission, $issue, $event->scheduledDate));
        }
    }
}
