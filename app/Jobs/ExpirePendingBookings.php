<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExpirePendingBookings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public function handle(): void
    {
        DB::transaction(function () {

            $expiredPayments = Payment::where('status', 'pending')
                ->whereNotNull('expiry_time')
                ->where('expiry_time', '<', now())
                ->with('booking')
                ->lockForUpdate()
                ->get();

            foreach ($expiredPayments as $payment) {
                $booking = $payment->booking;

                if (!$booking) {
                    continue;
                }

                // Proteksi: hanya pending_payment
                if ($booking->status !== 'pending_payment') {
                    continue;
                }

                // 1️⃣ Update booking
                $booking->update([
                    'cancel_reason' => 'Pembayaran kadaluarsa',
                    'status'        => 'cancelled',
                    'is_expired'    => true,
                    'cancelled_by'  => 'system',
                    'cancelled_at'  => now(),

                ]);

                // 2️⃣ Update payment
                $payment->update([
                    'status'             => 'failed',
                    'transaction_status' => 'expire',
                    'failure_reason'     => 'Payment expired (system)',
                ]);

                // 3️⃣ Kembalikan schedule
                $this->releaseSchedule($booking);
            }
        });
    }

    private function releaseSchedule(Booking $booking): void
    {
        $scheduleIds = array_filter([
            $booking->schedule_id,
            $booking->second_schedule_id,
        ]);

        Schedule::whereIn('id', $scheduleIds)
            ->update(['is_available' => true]);
    }
}
