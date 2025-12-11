<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Carbon\Carbon;
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

    public function inputLinkandNotes(Request $request, $bookingId){
    $request->validate([
        'meeting_link'   => 'nullable|string|max:500',
        'counselor_notes'=> 'nullable|string',
        'link_status'    => 'nullable|in:pending,sent',
    ]);

    try {
       $counselorId = Auth::user()->counselor->id;

    // pastikan booking milik counselor yang sedang login
    $booking = Booking::where('counselor_id', $counselorId)
        ->findOrFail($bookingId);

    $booking->update([
        'meeting_link'    => $request->meeting_link,
        'link_status'     => $request->link_status ?? $booking->link_status,
        'counselor_notes' => $request->counselor_notes,
    ]);

        return redirect()->back()->with('success', 'Link meeting dan catatan berhasil diperbarui.');
    } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Terjadi kesalahan.');
    }

}

    public function completeBooking($bookingId){

        try {
             $counselorId = Auth::user()->counselor->id;

            $booking = Booking::where('counselor_id', $counselorId)
                              ->with('schedule')
                              ->findOrFail($bookingId);

            if ($booking->status !== 'paid') {
                return back()->with('error', 'Booking belum dapat diselesaikan karena belum dibayar.');
            }

            if ($booking->status === 'cancelled') {
                return back()->with('error', 'Booking ini telah dibatalkan.');
            }

            // $sessionDateTime = Carbon::parse($booking->schedule->date . ' ' . $booking->schedule->start_time);
            // if ($sessionDateTime->isFuture()) {
            //     return back()->with('error', 'Sesi belum dimulai, tidak dapat diselesaikan.');
            // }

            $booking->update([
                'status' => 'completed',

            ]);

         return back()->with('success', 'Booking berhasil diselesaikan.');
        } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Terjadi kesalahan');
        }

}




}
