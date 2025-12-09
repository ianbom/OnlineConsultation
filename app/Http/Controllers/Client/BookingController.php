<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
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


    public function bookingSchedule(BookingRequest $request, $counselorId)
    {
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

        $booking = Booking::with('counselor.user', 'client', 'schedule', 'secondSchedule', 'payment')->findOrFail($bookingId);

        return Inertia::render('Booking/BookingDetail', [
            'booking' => $booking,
        ]);
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
}
