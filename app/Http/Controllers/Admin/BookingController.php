<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request){

        $query = Booking::with(['client', 'counselor.user', 'schedule']);

        // Search by client name, counselor name, or booking id
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('client', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('counselor.user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by consultation type
        if ($type = $request->input('type')) {
            $query->where('consultation_type', $type);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $allowedSorts = ['created_at', 'price', 'duration_hours', 'status'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'desc';
        $query->orderBy($sortBy, $sortDir);

        // Per page
        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $bookings = $query->get();
        } else {
            $perPage = in_array((int)$perPage, [5, 10, 50, 100]) ? (int)$perPage : 10;
            $bookings = $query->paginate($perPage)->withQueryString();
        }

        return view('admin.booking.index', ['bookings' => $bookings]);
    }

    public function show($bookingId){
        $booking = Booking::with('client', 'schedule', 'secondSchedule', 'previousSchedule',
         'previousSecondSchedule', 'payment', 'counselor.user', 'rating')->findOrFail($bookingId);
        return view('tes', ['booking' => $booking]);
    }
}
