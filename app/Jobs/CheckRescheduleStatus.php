<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckRescheduleStatus implements ShouldQueue
{
    use Queueable;

    protected $bookingService;

    /**
     * Create a new job instance.
     *
     * This job automatically rejects reschedule requests that are
     * less than 2 hours before the session starts.
     */
    public function __construct()
    {
        $this->bookingService = new BookingService();
    }

    /**
     * Execute the job.
     *
     * Process:
     * 1. Get all bookings with pending reschedule status
     * 2. Calculate hours until session starts
     * 3. If less than 2 hours, reject reschedule and set status to 'paid'
     * 4. Log all actions for monitoring
     */
    public function handle(): void
    {
        Log::info('CheckRescheduleStatus job started');

        try {
            // Ambil semua booking dengan reschedule_status = 'pending'
            // yang jadwalnya akan dimulai dalam 2 jam
            $bookings = Booking::with(['previousSchedule']) // Load previous schedule untuk pengecekan
                ->where('reschedule_status', 'pending')
                ->whereIn('status', ['paid', 'rescheduled'])
                ->get();

            $rejectedCount = 0;

            foreach ($bookings as $booking) {
                if ($booking->previousSchedule) {
                    // Gabungkan tanggal dan waktu jadwal LAMA (previous)
                    $scheduleDateTime = Carbon::parse($booking->previousSchedule->date . ' ' . $booking->previousSchedule->start_time);
                    $now = Carbon::now();

                    // Hitung selisih dalam jam
                    $hoursUntilSession = $now->diffInHours($scheduleDateTime, false);

                    // Jika kurang dari 2 jam dari jadwal lama, tolak reschedule
                    if ($hoursUntilSession < 2 && $hoursUntilSession > 0) {
                        // Gunakan service untuk reject reschedule
                        $reason = 'Permintaan reschedule ditolak sistem karena tidak ada respon ';
                        $this->bookingService->rejectReschedule($booking, $reason);

                        $rejectedCount++;

                        Log::info("Booking #{$booking->id} reschedule rejected - schedule reverted to previous");
                    }
                }
            }

            Log::info("CheckRescheduleStatus job completed. Total rejected: {$rejectedCount}");

        } catch (\Exception $e) {
            Log::error('CheckRescheduleStatus job failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
