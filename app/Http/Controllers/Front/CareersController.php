<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class CareersController extends Controller
{
    public function index()
    {
        return view('front.careers');
    }
}
