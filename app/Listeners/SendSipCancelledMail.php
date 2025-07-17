<?php

namespace App\Listeners;

use App\Events\SipCancelled;
use App\Mail\SipCancelledMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSipCancelledMail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(SipCancelled $event)
    {
        try {
            Mail::to($event->user->email)->queue(new SipCancelledMail($event->user, $event->sip));
        } catch (\Exception $e) {
            \Log::error('Failed to send SIP cancelled mail: ' . $e->getMessage());
        }
    }
} 