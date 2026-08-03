<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Muestra la Política de Privacidad.
     */
    public function privacy()
    {
        return view('front.legal.privacy');
    }

    /**
     * Muestra los Términos y Condiciones de Uso.
     */
    public function terms()
    {
        return view('front.legal.terms');
    }

    /**
     * Muestra la Política de Cookies.
     */
    public function cookies()
    {
        return view('front.legal.cookies');
    }
}
