<?php

namespace App\Providers;

use App\Events\CopyeditFilesReady;
use App\Events\DiscussionCommentAdded;
use App\Events\GalleyReadyForProduction;
use App\Events\IssuePublished;
use App\Events\PublicationScheduled;
use App\Events\ReviewCompleted;
use App\Events\ReviewerInvited;
use App\Events\SubmissionStatusChanged;
use App\Events\SubmissionSubmitted;
use App\Listeners\SendCopyeditReadyNotification;
use App\Listeners\SendDiscussionCommentNotification;
use App\Listeners\SendGalleyReadyNotification;
use App\Listeners\SendPublicationScheduledNotification;
use App\Listeners\SendReviewCompletedNotification;
use App\Listeners\SendReviewerInvitation;
use App\Listeners\SendStatusChangeNotification;
use App\Listeners\SendSubmissionConfirmation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SubmissionSubmitted::class => [
            SendSubmissionConfirmation::class,
        ],
        ReviewerInvited::class => [
            SendReviewerInvitation::class,
        ],
        ReviewCompleted::class => [
            SendReviewCompletedNotification::class,
        ],
        SubmissionStatusChanged::class => [
            SendStatusChangeNotification::class,
        ],
        CopyeditFilesReady::class => [
            SendCopyeditReadyNotification::class,
        ],
        GalleyReadyForProduction::class => [
            SendGalleyReadyNotification::class,
        ],
        PublicationScheduled::class => [
            SendPublicationScheduledNotification::class,
        ],
        DiscussionCommentAdded::class => [
            SendDiscussionCommentNotification::class,
        ],
        IssuePublished::class => [
            // Issue published listeners can be added here
        ],
    ];

    public function boot(): void
    {
        //
    }
}

