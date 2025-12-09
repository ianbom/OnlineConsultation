<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
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

        return response()->json([
            'booking' => $booking,
            'payment' => $payment,
            'snapToken' => $payment->snap_token,
        ]);

        // return Inertia::render('Payment/ProcessPayment', [
        //     'booking' => $booking->load('counselor.user'),
        //     'payment' => $payment,
        //     'snapToken' => $payment->snap_token,
        // ]);
    }
}
