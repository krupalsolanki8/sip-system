<?php

namespace App\Listeners;

use App\Events\SipCreated;
use App\Mail\SipCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSipCreatedMail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(SipCreated $event)
    {
        try {
            Mail::to($event->user->email)->queue(new SipCreatedMail($event->user, $event->sip));
        } catch (\Exception $e) {
            \Log::error('Failed to send SIP creation mail: ' . $e->getMessage());
        }
    }
} 