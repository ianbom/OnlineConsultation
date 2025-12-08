<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\CounselorsWorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkDayController extends Controller
{


    public function index()
    {
        $counselorId = Auth::user()->counselor->id;
        $counselorsWorkDays = CounselorsWorkDay::with('counselor.user')->where('counselor_id', $counselorId)->get();
        
        return view('counselor.workday.index', ['counselorsWorkDays' => $counselorsWorkDays]);
    }

}
