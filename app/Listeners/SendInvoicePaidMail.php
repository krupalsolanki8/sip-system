<?php

namespace App\Listeners;

use App\Events\InvoicePaid;
use App\Mail\InvoicePaidMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoicePaidMail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(InvoicePaid $event)
    {
        try {
            Mail::to($event->user->email)->queue(new InvoicePaidMail($event->user, $event->invoice));
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice paid mail: ' . $e->getMessage());
        }
    }
} 