<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sip extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'frequency',
        'sip_day',
        'start_date',
        'end_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Accessor to determine if the SIP is currently active.
     */
    public function getIsActiveAttribute()
    {
        $today = now()->toDateString();
        return $this->status === 'active'
            && $today >= $this->start_date
            && $today <= $this->end_date;
    }

    /**
     * Sync the status field based on current date.
     * Call this method to update the status column for this SIP.
     */
    public function syncStatus()
    {
        $today = now()->toDateString();
        $newStatus = ($this->status === 'inactive' || $today < $this->start_date || $today > $this->end_date)
            ? 'inactive' : 'active';
        if ($this->status !== $newStatus) {
            $this->status = $newStatus;
            $this->save();
        }
    }
}
