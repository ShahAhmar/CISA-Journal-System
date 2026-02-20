<?php

namespace App\Listeners;

use App\Events\SubmissionSubmitted;
use App\Notifications\SubmissionReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubmissionConfirmation implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(SubmissionSubmitted $event)
    {
        try {
            $submission = $event->submission;
            
            // Send notification to author
            if ($submission->author) {
                try {
                    $submission->author->notify(new SubmissionReceivedNotification($submission));
                } catch (\Exception $e) {
                    \Log::error('Failed to send submission notification to author', [
                        'submission_id' => $submission->id,
                        'author_id' => $submission->author->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Send notification to editors
            $editors = $submission->journal->editors()->wherePivot('is_active', true)->get();
            foreach ($editors as $editor) {
                try {
                    $editor->notify(new SubmissionReceivedNotification($submission));
                } catch (\Exception $e) {
                    \Log::error('Failed to send submission notification to editor', [
                        'submission_id' => $submission->id,
                        'editor_id' => $editor->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to process submission confirmation', [
                'submission_id' => $event->submission->id ?? null,
                'error' => $e->getMessage()
            ]);
        }
    }
}

