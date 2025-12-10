<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(){

        $bookings = Booking::all();

        return view('admin.booking.index', ['bookings' => $bookings]);
    }

    public function show($id){
        $booking = Booking::with('client', 'counselor.user', 'payment',
        'schedule', 'secondSchedule', 'previousSchedule', 'previousSecondSchedule')->findOrFail($id);

        return view('admin.booking.show', ['booking' => $booking]);
    }
}
