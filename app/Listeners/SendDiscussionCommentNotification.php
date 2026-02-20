<?php

namespace App\Listeners;

use App\Events\DiscussionCommentAdded;
use App\Notifications\DiscussionCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDiscussionCommentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(DiscussionCommentAdded $event)
    {
        $submission = $event->submission;
        $commenter = $event->user;
        
        // Get all participants in the discussion (author, editors, reviewers assigned)
        $participants = collect();
        
        // Add author
        if ($submission->author && $submission->author->id !== $commenter->id) {
            $participants->push($submission->author);
        }
        
        // Add editors
        $journal = $submission->journal;
        $editors = $journal->users()
            ->wherePivotIn('role', ['editor', 'journal_manager', 'section_editor'])
            ->wherePivot('is_active', true)
            ->where('users.id', '!=', $commenter->id)
            ->get();
        
        $participants = $participants->merge($editors);
        
        // Notify all participants
        foreach ($participants as $participant) {
            $participant->notify(new DiscussionCommentNotification($submission, $event->comment, $commenter));
        }
    }
}
