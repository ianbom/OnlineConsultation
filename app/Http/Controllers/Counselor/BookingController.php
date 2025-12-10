<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class BookingController extends Controller
{
    public function index(){
        $user = Auth::user();

        $bookings = Booking::where('counselor_id', $user->counselor->id)
        ->with('client', 'schedule', 'secondSchedule', 'previousSchedule', 'previousSecondSchedule', 'payment')->get();

        return view('counselor.booking.index', ['bookings' => $bookings]);
    }

    public function show($bookingId){
         $user = Auth::user();

        $booking = Booking::where('counselor_id', $user->counselor->id)
        ->with('client', 'schedule', 'secondSchedule', 'previousSchedule', 'previousSecondSchedule', 'payment')->findOrFail($bookingId);


        return view('counselor.booking.detail', ['booking' => $booking]);
    }
}
