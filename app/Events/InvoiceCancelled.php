<?php

namespace App\Events;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCancelled
{
    use Dispatchable, SerializesModels;

    public $user;
    public $invoice;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Invoice $invoice)
    {
        $this->user = $user;
        $this->invoice = $invoice;
    }
} 