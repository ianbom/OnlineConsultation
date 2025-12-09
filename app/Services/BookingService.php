<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Counselor;
use App\Models\Schedule;

class BookingService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function createBooking($client, $counselorId, $scheduleId, $secondId, $notes, $type)
    {
        $counselor = Counselor::findOrFail($counselorId);

        $duration = $secondId ? 2 : 1;
        $price = $duration * $counselor->price_per_session;

        $booking = Booking::create([
            'client_id' => $client->id,
            'counselor_id' => $counselorId,
            'schedule_id' => $scheduleId,
            'second_schedule_id' => $secondId,
            'price' => $price,
            'duration_hours' => $duration,
            'consultation_type' => $type,
            'notes' => $notes,
            'status' => 'pending_payment'
        ]);

        $this->changeScheduleStatus($scheduleId, $secondId);

        return $booking;
    }

    public function changeScheduleStatus($scheduleId, $secondId = null){
        Schedule::where('id', $scheduleId)->update([
            'is_available' => 0
        ]);

        if ($secondId) {
            Schedule::where('id', $secondId)->update([
                'is_available' => 0
            ]);
        }
    }
}
