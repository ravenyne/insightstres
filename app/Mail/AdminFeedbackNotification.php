<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminFeedbackNotification extends Mailable
{
    public $feedback;

    public function __construct(\App\Models\Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Feedback Baru: ' . $this->feedback->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.feedback',
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
