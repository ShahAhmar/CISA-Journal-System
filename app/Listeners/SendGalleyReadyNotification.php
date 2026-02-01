<?php

namespace App\Listeners;

use App\Events\GalleyReadyForProduction;
use App\Notifications\GalleyReadyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendGalleyReadyNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(GalleyReadyForProduction $event)
    {
        $submission = $event->submission;
        
        // Notify author
        if ($submission->author) {
            $submission->author->notify(new GalleyReadyNotification($submission));
        }
        
        // Notify editors
        $journal = $submission->journal;
        $editors = $journal->users()
            ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
            ->wherePivot('is_active', true)
            ->get();
        
        foreach ($editors as $editor) {
            $editor->notify(new GalleyReadyNotification($submission));
        }
    }
}
