<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselorWorkDayRequest;
use App\Http\Requests\UpdateCounselorsWorkDayRequest;
use App\Models\Counselor;
use App\Models\CounselorsWorkDay;
use App\Services\CounselorWorkDayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CounselorWorkDayController extends Controller
{
    protected $counselorWorkDayService;

    public function __construct(CounselorWorkDayService $counselorWorkDayService)
    {
        $this->counselorWorkDayService = $counselorWorkDayService;
    }

    public function index()
    {
        $counselorsWorkDays = CounselorsWorkDay::with([
            'counselor.user',
            'schedules' => function ($query) {
                $query->orderBy('date')->orderBy('start_time');
            }
        ])->get();

        return view('admin.workday.index', ['counselorsWorkDays' => $counselorsWorkDays]);
    }

    public function create()
    {
        $counselors = Counselor::with('user')->where('status', 'active')->get();
        return view('admin.workday.create', ['counselors' => $counselors]);
    }

    public function store(StoreCounselorWorkDayRequest $request)
    {
        try {
            $this->counselorWorkDayService->store($request->validated());
            return redirect()->route('admin.workday.index')
                ->with('success', 'Workday berhasil dibuat dan jadwal 7 hari ke depan telah digenerate.');
        } catch (\Throwable $th) {
            Log::error('Create workday failed: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat workday: ' . $th->getMessage());
        }
    }

    public function edit(CounselorsWorkDay $workday)
    {
        $counselors = Counselor::with('user')->where('status', 'active')->get();
        return view('admin.workday.edit', ['workday' => $workday, 'counselors' => $counselors]);
    }

    public function update(UpdateCounselorsWorkDayRequest $request, CounselorsWorkDay $workday)
    {
        try {
            $this->counselorWorkDayService->update($workday, $request->validated());
            return redirect()->route('admin.workday.index')
                ->with('success', 'Jadwal konselor berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Update workday failed: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui jadwal: ' . $th->getMessage());
        }
    }

    public function destroy(CounselorsWorkDay $workday)
    {
        try {
            DB::transaction(function () use ($workday) {
                $workday->schedules()->delete();
                $workday->delete();
            });

            return redirect()->route('admin.workday.index')
                ->with('success', 'Jadwal konselor berhasil dihapus.');
        } catch (\Throwable $th) {
            Log::error('Delete workday failed: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus jadwal: ' . $th->getMessage());
        }
    }
}

