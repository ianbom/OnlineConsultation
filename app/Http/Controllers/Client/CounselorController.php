<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CounselorController extends Controller
{
    public function counselorList()
    {
        $counselors = Counselor::with('user')->where('status', 'active')->get();

     
        return Inertia::render('Counselor/CounselorsList', [
            'counselors' => $counselors,
        ]);
    }
}
