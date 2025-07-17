<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(Verified $event)
    {
        try {
            Mail::to($event->user->email)->queue(new WelcomeMail($event->user));
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome mail: ' . $e->getMessage());
        }
    }
} 