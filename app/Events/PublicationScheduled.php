<?php

namespace App\Events;

use App\Models\Submission;
use App\Models\Issue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicationScheduled
{
    use Dispatchable, SerializesModels;

    public $submission;
    public $issue;
    public $scheduledDate;

    public function __construct(Submission $submission, Issue $issue, $scheduledDate)
    {
        $this->submission = $submission;
        $this->issue = $issue;
        $this->scheduledDate = $scheduledDate;
    }
}
