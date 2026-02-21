<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyReportNotification extends Mailable
{
    public $stats;

    public function __construct($stats)
    {
        $this->stats = $stats;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Mingguan Insight Stress',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.weekly-report',
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
