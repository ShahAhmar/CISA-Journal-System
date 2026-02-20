<?php

namespace App\Mail;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EditorToAuthorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $mailSubject;
    public $body;
    public $editor;

    /**
     * Create a new message instance.
     */
    public function __construct(Submission $submission, string $subject, string $body, User $editor)
    {
        $this->submission = $submission;
        $this->mailSubject = $subject;
        $this->body = $body;
        $this->editor = $editor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject . ' - ' . $this->submission->journal->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.editor-to-author',
            with: [
                'submission' => $this->submission,
                'body' => $this->body,
                'editor' => $this->editor,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
