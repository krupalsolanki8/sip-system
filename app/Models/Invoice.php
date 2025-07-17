<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'sip_id',
        'user_id',
        'amount',
        'status',
        'scheduled_date',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    public function sip()
    {
        return $this->belongsTo(Sip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
