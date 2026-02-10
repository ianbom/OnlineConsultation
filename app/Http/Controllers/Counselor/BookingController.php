<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $user = Auth::user();

        $bookings = Booking::where('counselor_id', $user->counselor->id)
            ->with('client', 'schedule', 'secondSchedule', 'previousSchedule', 'previousSecondSchedule', 'payment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('counselor.booking.index', ['bookings' => $bookings]);
    }

    public function show($bookingId)
    {
        $user = Auth::user();

        $booking = Booking::where('counselor_id', $user->counselor->id)
            ->with('client', 'schedule', 'secondSchedule', 'previousSchedule', 'previousSecondSchedule', 'payment')
            ->findOrFail($bookingId);

        return view('counselor.booking.detail', ['booking' => $booking]);
    }

    public function changeStatusReschedule(Request $request, $bookingId)
    {
        $request->validate([
            'statusReschedule' => 'required|in:approved,rejected',
            'reason' => 'nullable|string|max:255'
        ]);

        $booking = Booking::findOrFail($bookingId);

        try {
            if ($request->statusReschedule === 'approved') {
                $this->bookingService->approveReschedule($booking);
                return back()->with('success', 'Reschedule berhasil disetujui.');
            }

            if ($request->statusReschedule === 'rejected') {
                $this->bookingService->rejectReschedule($booking, $request->reason);
                return back()->with('success', 'Reschedule ditolak.');
            }

            return back()->with('error', 'Status tidak valid.');
        } catch (\Throwable $th) {
            Log::error('Change reschedule status failed: ' . $th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }

    public function inputLinkandNotes(Request $request, $bookingId)
    {
        $request->validate([
            'meeting_link'    => 'nullable|string|max:500',
            'counselor_notes' => 'nullable|string',
            'link_status'     => 'nullable|in:pending,sent',
        ]);

        try {
            DB::transaction(function () use ($request, $bookingId) {
                $booking = Booking::findOrFail($bookingId);

                $booking->update([
                    'meeting_link'    => $request->meeting_link,
                    'link_status'     => $request->link_status ?? $booking->link_status,
                    'counselor_notes' => $request->counselor_notes,
                ]);
            });

            return redirect()->back()->with('success', 'Link meeting dan catatan berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Input link and notes failed: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function completeBooking($bookingId)
    {
        try {
            DB::transaction(function () use ($bookingId) {
                $counselorId = Auth::user()->counselor->id;

                $booking = Booking::where('counselor_id', $counselorId)
                    ->with('schedule')
                    ->findOrFail($bookingId);

                if ($booking->status === 'cancelled') {
                    throw new \Exception('Booking ini telah dibatalkan.');
                }

                if ($booking->status !== 'paid') {
                    throw new \Exception('Booking belum dapat diselesaikan karena belum dibayar.');
                }

                $booking->update([
                    'status' => 'completed',
                ]);
            });

            return back()->with('success', 'Booking berhasil diselesaikan.');
        } catch (\Throwable $th) {
            Log::error('Complete booking failed: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}

