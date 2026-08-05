<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\Lead;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    /**
     * Mostrar la página de Trabaja con Nosotros.
     */
    public function index()
    {
        $jobOffers = JobOffer::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $jobs = $jobOffers;

        return view('front.careers', compact('jobs', 'jobOffers'));
    }

    /**
     * Procesar postulación laboral.
     */
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:50',
            'position'  => 'required|string|max:255',
            'portfolio' => 'nullable|string|max:500',
            'message'   => 'nullable|string|max:2000',
        ]);

        Lead::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'service' => 'Postulación: ' . $validated['position'],
            'message' => "Posición a la que postula: " . $validated['position'] . "\nPortafolio / LinkedIn / CV: " . ($validated['portfolio'] ?? 'No especificado') . "\n\nMensaje:\n" . ($validated['message'] ?? 'Sin mensaje adicional'),
            'source'  => 'trabaja-con-nosotros',
            'status'  => 'new',
        ]);

        return back()->with('success', '¡Postulación enviada con éxito! Nuestro equipo de selección revisará tu perfil.');
    }
}
