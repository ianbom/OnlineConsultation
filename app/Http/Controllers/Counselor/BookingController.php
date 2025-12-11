<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class BookingController extends Controller
{

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

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

   public function changeStatusReschedule(Request $request, $bookingId)
    {
        $request->validate([
            'statusReschedule' => 'required|in:approved,rejected',
            'reason' => 'nullable|string|max:255'
        ]);

        $booking = Booking::findOrFail($bookingId);

        if ($request->statusReschedule === 'approved') {
            $this->bookingService->approveReschedule($booking);

            return back()->with('success', 'Reschedule berhasil disetujui.');
        }

        if ($request->statusReschedule === 'rejected') {
            $this->bookingService->rejectReschedule($booking, $request->reason);

            return back()->with('success', 'Reschedule ditolak.');
        }

        return back()->with('error', 'Status tidak valid.');
    }
}
