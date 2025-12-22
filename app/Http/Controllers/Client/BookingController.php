<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Counselor;
use App\Models\Schedule;
use App\Services\BookingService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookingController extends Controller
{

    protected $bookingService;
    protected $paymentService;

    public function __construct(BookingService $bookingService, PaymentService $paymentService) {
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
    }


    public function bookingSchedule(BookingRequest $request, $counselorId){
        $booking = $this->bookingService->createBooking(
            Auth::user(),
            $counselorId,
            $request->schedule_id,
            $request->second_schedule_id,
            $request->notes,
            $request->consultation_type
        );

        // create payment + snap token
        $payment = $this->paymentService->createPayment($booking);

        return redirect()->route('client.booking.detail', ['bookingId' => $booking->id])
            ->with('success', 'Booking berhasil dibuat. Silakan lanjutkan ke pembayaran.');
    }

    public function bookingDetail($bookingId){
    $booking = Booking::with('counselor.user', 'client', 'previousSchedule',
    'previousSecondSchedule', 'schedule', 'secondSchedule', 'payment', 'sessionLog')
        ->findOrFail($bookingId);

    return Inertia::render('Booking/BookingDetail', [
        'booking' => $booking,

    ]);
}

    public function pickRescheduleBooking($bookingId){

    $booking = Booking::with('counselor.user', 'client', 'schedule', 'secondSchedule', 'payment')
        ->findOrFail($bookingId);

    $counselor = Counselor::with('user')->findOrFail($booking->counselor_id);

    $today = now();
    $endDate = now()->addDays(30);

    $availableSchedules = Schedule::where('counselor_id', $counselor->id)
        ->where('is_available', 1)
        ->whereBetween('date', [$today, $endDate])
        ->orderBy('date')
        ->orderBy('start_time')
        ->get();

    $schedulesByDate = $availableSchedules->groupBy('date')->map(function($schedules) {
        return $schedules->map(function($schedule) {
            return [
                'id' => $schedule->id,
                'date' => $schedule->date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'is_available' => $schedule->is_available,
            ];
        })->values();
    });

    return Inertia::render('Booking/BookingReschedule', [
        'booking' => $booking,
        'counselor' => $counselor,
        'schedulesByDate' => $schedulesByDate]);

    }


    public function bookingHistory(){
        $client = Auth::user();

        $bookings = Booking::with('counselor.user', 'schedule', 'secondSchedule', 'payment')
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Booking/BookingHistory', [
            'bookings' => $bookings,
        ]);
    }

    public function rescheduleBooking($bookingId, Request $request){
       $data = $request->validate([
           'schedule_id' => 'required',
           'second_schedule_id' => 'nullable',
       ]);

       try {
           $this->bookingService->updateRescheduleBooking($bookingId, $data);
           return redirect()->route('client.booking.detail', ['bookingId' => $bookingId])->with('success', 'Booking berhasil dijadwalkan ulang.');
       } catch (\Throwable $th) {
           return redirect()->back()->with('error', 'Terjadi kesalahan');
       }
   }

    public function cancelBooking(Request $request, $bookingId)
    {
        $data = $request->validate([
            'reason' => 'nullable|string',
            'cancelled_by' => 'nullable|in:client,counselor,admin',
        ]);

        $booking = Booking::with(['schedule', 'secondSchedule'])->findOrFail($bookingId);

        try {
            $this->bookingService->cancelBooking($booking, $data);

            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
