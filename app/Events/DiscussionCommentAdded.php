<?php

namespace App\Events;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscussionCommentAdded
{
    use Dispatchable, SerializesModels;

    public $submission;
    public $comment;
    public $user;

    public function __construct(Submission $submission, $comment, User $user)
    {
        $this->submission = $submission;
        $this->comment = $comment;
        $this->user = $user;
    }
}
