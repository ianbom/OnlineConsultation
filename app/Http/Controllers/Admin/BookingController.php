<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(){

        $bookings = Booking::orderBy('created_at', 'desc')->get();

        return view('admin.booking.index', ['bookings' => $bookings]);
    }

    public function show($bookingId){
        $booking = Booking::with('client', 'schedule', 'secondSchedule', 'previousSchedule',
         'previousSecondSchedule', 'payment', 'counselor.user')->findOrFail($bookingId);

        return view('admin.booking.show', ['booking' => $booking]);
    }
}
