<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $greeting;
    public $lines;
    public $actionUrl;
    public $actionText;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $greeting, $lines, $actionUrl = null, $actionText = null)
    {
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->lines = is_array($lines) ? $lines : [$lines];
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.client-notification',
            with: [
                'greeting' => $this->greeting,
                'lines' => $this->lines,
                'actionUrl' => $this->actionUrl,
                'actionText' => $this->actionText,
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

