<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselorRequest;
use App\Http\Requests\UpdateCounselorRequest;
use App\Models\Booking;
use App\Models\Counselor;
use App\Models\Payment;
use App\Models\User;
use App\Services\CounselorService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CounselorController extends Controller
{

    protected $counselorService;

    public function __construct(CounselorService $counselorService)
    {
        $this->counselorService = $counselorService;
    }

    public function index()
    {
        $counselors = Counselor::with('user')->get();
        return view('admin.counselor.index', [
            'counselors' => $counselors
        ]);
    }

    public function create()
    {
        return view('admin.counselor.create');
    }

    public function store(StoreCounselorRequest $request)
    {
        try {
            $counselor = $this->counselorService->create($request->validated());
        return redirect()
            ->route('admin.counselor.index')
            ->with('success', 'Counselor created successfully!');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create counselor: ' . $th->getMessage());
        }

    }

    public function edit(Counselor $counselor){
        return view('admin.counselor.edit', ['counselor' => $counselor]);
    }

    public function update(UpdateCounselorRequest $request, Counselor $counselor){
        try {
            $this->counselorService->update($counselor, $request->validated());

            return redirect()
                ->route('admin.counselor.index')
                ->with('success', 'Counselor berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data counselor: ' . $e->getMessage());
        }
    }

    public function show($counselorId)
{
    // ============================
    // GET COUNSELOR DETAIL
    // ============================
    $counselor = Counselor::with('user')->findOrFail($counselorId);

    $today      = Carbon::today();
    $weekStart  = Carbon::now()->startOfWeek();
    $monthStart = Carbon::now()->startOfMonth();

    // ============================
    // BOOKING STATISTICS
    // ============================

    $todayBookings = Booking::where('counselor_id', $counselor->id)
        ->whereDate('created_at', $today)
        ->count();

    $weeklyBookings = Booking::where('counselor_id', $counselor->id)
        ->whereBetween('created_at', [$weekStart, now()])
        ->count();

    $monthlyBookings = Booking::where('counselor_id', $counselor->id)
        ->whereBetween('created_at', [$monthStart, now()])
        ->count();

    $completedBookings = Booking::where('counselor_id', $counselor->id)
        ->where('status', 'completed')
        ->count();

    // ============================
    // TOTAL INCOME (SUCCESS ONLY)
    // ============================

    $totalIncome = Payment::where('status', 'success')
        ->whereHas('booking', function ($query) use ($counselor) {
            $query->where('counselor_id', $counselor->id);
        })
        ->sum('amount');

    // ============================
    // RECENT BOOKINGS
    // ============================

    $recentBookings = Booking::with(['client', 'payment'])
        ->where('counselor_id', $counselor->id)
        ->latest()
        ->limit(5)
        ->get();

    // ============================
    // INCOME CHART (PER MONTH)
    // ============================

    $incomeByMonth = Payment::where('status', 'success')
        ->whereHas('booking', function ($query) use ($counselor) {
            $query->where('counselor_id', $counselor->id);
        })
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    $chartIncome = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartIncome[] = $incomeByMonth[$i] ?? 0;
    }

    // ============================
    // RETURN VIEW
    // ============================

    return view('admin.counselor.detail', [
        'counselor'           => $counselor,
        'todayBookings'       => $todayBookings,
        'weeklyBookings'      => $weeklyBookings,
        'monthlyBookings'     => $monthlyBookings,
        'completedBookings'   => $completedBookings,
        'totalIncome'         => $totalIncome,
        'recentBookings'      => $recentBookings,
        'chartIncome'         => $chartIncome,
    ]);
}


}
