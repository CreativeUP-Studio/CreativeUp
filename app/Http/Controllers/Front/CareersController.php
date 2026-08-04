<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;

class CareersController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.careers', compact('jobs'));
    }
}
