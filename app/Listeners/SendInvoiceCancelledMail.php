<?php

namespace App\Listeners;

use App\Events\InvoiceCancelled;
use App\Mail\InvoiceCancelledMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceCancelledMail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(InvoiceCancelled $event)
    {
        try {
            Mail::to($event->user->email)->queue(new InvoiceCancelledMail($event->user, $event->invoice));
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice cancelled mail: ' . $e->getMessage());
        }
    }
} 