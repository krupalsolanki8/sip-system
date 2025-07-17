<?php

namespace App\Events;

use App\Models\User;
use App\Models\Sip;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SipCancelled
{
    use Dispatchable, SerializesModels;

    public $user;
    public $sip;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Sip $sip)
    {
        $this->user = $user;
        $this->sip = $sip;
    }
} 