<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SipCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $sip;
    public $app_name;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $sip)
    {
        $this->user = $user;
        $this->sip = $sip;
        $this->app_name = config('app.name', 'SIP System');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your SIP Has Been Successfully Created – ' . $this->app_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sip_created',
            with: [
                'user_name' => $this->user->name,
                'app_name' => $this->app_name,
                'sip' => $this->sip
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
