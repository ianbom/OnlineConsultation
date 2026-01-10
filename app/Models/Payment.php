<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'integer',
        'refund_amount' => 'integer',
        'settlement_time' => 'datetime',
        'paid_at' => 'datetime',
        'refund_time' => 'datetime',
        'expiry_time' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
