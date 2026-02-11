<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingCounselor extends Model
{
    use HasFactory;

    protected $table = 'rating_counselors';
    protected $guarded = ['id'];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
