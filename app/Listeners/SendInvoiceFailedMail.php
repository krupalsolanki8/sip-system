<?php

namespace App\Listeners;

use App\Events\InvoiceFailed;
use App\Mail\InvoiceFailedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceFailedMail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(InvoiceFailed $event)
    {
        try {
            Mail::to($event->user->email)->queue(new InvoiceFailedMail($event->user, $event->invoice));
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice failed mail: ' . $e->getMessage());
        }
    }
} 