<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselorRequest;
use App\Http\Requests\UpdateCounselorRequest;
use App\Models\Counselor;
use App\Models\User;
use App\Services\CounselorService;
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

}
