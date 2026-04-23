<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\BookingService;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {
    }

    public function index(Request $request)
    {
        $query = $this->buildIndexQuery($request);

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

    public function export(Request $request)
    {
        $validated = $request->validate([
            'export' => 'required|in:all,range',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        if ($validated['export'] === 'range') {
            $request->validate([
                'date_from' => 'required|date',
                'date_to' => 'required|date|after_or_equal:date_from',
            ]);
        }

        $bookings = $this->buildExportQuery($request)->get();

        $fileName = $validated['export'] === 'all'
            ? 'bookings-semua.xlsx'
            : 'bookings-' . $validated['date_from'] . '-sampai-' . $validated['date_to'] . '.xlsx';

        return Excel::download(new BookingsExport($bookings), $fileName);
    }

    public function show($bookingId){
        $booking = Booking::with('client', 'schedule', 'secondSchedule', 'previousSchedule',
         'previousSecondSchedule', 'payment', 'counselor.user', 'rating', 'settledByAdmin')->findOrFail($bookingId);
        return view('tes', ['booking' => $booking]);
    }

    public function markSettled($bookingId)
    {
        $booking = Booking::with('payment')->findOrFail($bookingId);

        try {
            $this->bookingService->settleOfflineDpBooking($booking, Auth::id());

            return back()->with('success', 'Pelunasan booking berhasil ditandai lunas.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    private function buildIndexQuery(Request $request)
    {
        $query = Booking::with(['client', 'counselor.user', 'schedule', 'payment']);

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

        return $query;
    }

    private function buildExportQuery(Request $request)
    {
        $query = Booking::with([
            'client',
            'counselor.user',
            'schedule',
            'secondSchedule',
        ])->whereHas('schedule');

        if ($request->input('export') === 'range') {
            $query->whereHas('schedule', function ($scheduleQuery) use ($request) {
                $scheduleQuery->whereBetween('date', [
                    $request->input('date_from'),
                    $request->input('date_to'),
                ]);
            });
        }

        return $query->orderBy('created_at', 'desc');
    }
}
