<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Counselor;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function updateRescheduleBooking($bookingId, $data){
        $booking = Booking::findOrFail($bookingId);

    if ($booking->status === 'cancelled') {
        return back()->with('error', 'Booking yang dibatalkan tidak dapat dijadwalkan ulang.');
    }

    if ($booking->is_expired) {
        return back()->with('error', 'Booking kedaluwarsa tidak bisa dijadwalkan ulang.');
    }

    $newSchedule = $data['schedule_id'];
    $newSecondSchedule = $data['second_schedule_id'] ?? null;

    $booking->previous_schedule_id = $booking->schedule_id;
    $booking->previous_second_schedule_id = $booking->second_schedule_id;

    $booking->schedule_id = $newSchedule;
    $booking->second_schedule_id = $newSecondSchedule;

    $booking->status = 'rescheduled';

    $booking->meeting_link = null;

    $booking->save();
    }

    public function cancelBooking(Booking $booking, array $data)
{
    return DB::transaction(function () use ($booking, $data) {

        $user = Auth::user();
        $role = $user->role;

        $cancelledBy = $data['cancelled_by'] ?? $role;

        // Restriksi: client tidak boleh cancel booking completed
        if ($role === 'client' && $booking->status === 'completed') {
            throw new \Exception("Anda tidak dapat membatalkan booking yang sudah selesai.");
        }

        // Sudah cancelled
        if ($booking->status === 'cancelled' || $booking->is_expired) {
            throw new \Exception("Booking ini sudah dibatalkan sebelumnya.");
        }

        // Release jadwal
        $this->releaseSchedules($booking);

        // Backup payment sebelum update
        $payment = $booking->payment;

        // Tentukan logika pembayaran
        if ($payment) {
            if ($booking->status === 'paid' || $booking->status === 'rescheduled') {
                // CASE: Sudah dibayar → harus refund
                $payment->refund_amount = $payment->amount;
                $payment->refund_reason = $data['reason'] ?? 'Booking cancelled';
                $payment->refund_time = Carbon::now();
                $payment->status = 'refund';
                $payment->transaction_status = 'refund';
                $payment->save();
            } else {
                // CASE: Belum bayar / pending → anggap failed/cancelled
                $payment->status = 'failed';
                $payment->transaction_status = 'cancelled';
                $payment->failure_reason = $data['reason'] ?? 'Booking cancelled';
                $payment->save();
            }
        }

        // Tandai refund untuk booking
        if ($booking->status === 'paid' || $booking->status === 'rescheduled') {
            $booking->refund_status = 'requested';
            $booking->refund_processed_at = Carbon::now();
        }

        // Update booking
        $booking->status = 'cancelled';
        $booking->cancelled_by = $cancelledBy;
        $booking->cancel_reason = $data['reason'] ?? null;
        $booking->cancelled_at = Carbon::now();

        $booking->save();

        return $booking;
    });
}


    public function releaseSchedules(Booking $booking)
    {

        Log::info("Jadwal di service balik");

        if ($booking->schedule) {
            $booking->schedule->update(['is_available' => true]);
        }

        if ($booking->second_schedule) {
            $booking->second_schedule->update(['is_available' => true]);
        }
    }
}
