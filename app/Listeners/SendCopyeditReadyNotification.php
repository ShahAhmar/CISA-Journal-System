<?php

namespace App\Listeners;

use App\Events\CopyeditFilesReady;
use App\Notifications\CopyeditReadyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCopyeditReadyNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CopyeditFilesReady $event)
    {
        $submission = $event->submission;
        
        // Notify author
        if ($submission->author) {
            $submission->author->notify(new CopyeditReadyNotification($submission));
        }
        
        // Notify editors
        $journal = $submission->journal;
        $editors = $journal->users()
            ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
            ->wherePivot('is_active', true)
            ->get();
        
        foreach ($editors as $editor) {
            $editor->notify(new CopyeditReadyNotification($submission));
        }
    }
}
