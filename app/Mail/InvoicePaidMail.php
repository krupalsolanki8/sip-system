<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaidMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $invoice;
    public $app_name;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $invoice)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->app_name = config('app.name', 'SIP System');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your SIP Payment Was Successful – ' . $this->app_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice_paid',
            with: [
                'user_name' => $this->user->name,
                'app_name' => $this->app_name,
                'invoice' => $this->invoice
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
        $pdfPath = storage_path('app/invoices/invoice_' . $this->invoice->id . '.pdf');
        if (file_exists($pdfPath)) {
            return [
                Attachment::fromPath($pdfPath)
                    ->as('Invoice_' . $this->invoice->id . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
} 