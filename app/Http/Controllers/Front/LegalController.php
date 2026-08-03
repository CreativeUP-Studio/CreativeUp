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

    /**
     * Registra el consentimiento de cookies e IP con fines de auditoría y seguridad.
     */
    public function storeConsent(Request $request)
    {
        $validated = $request->validate([
            'consent_type'         => 'required|string|in:all,essential',
            'hardware_fingerprint' => 'nullable|string|max:100',
            'device_type'          => 'nullable|string|max:50',
            'browser'              => 'nullable|string|max:100',
            'os'                   => 'nullable|string|max:100',
            'cpu_cores'            => 'nullable|string|max:50',
            'device_memory'        => 'nullable|string|max:50',
            'connection_type'      => 'nullable|string|max:50',
            'touch_points'         => 'nullable|string|max:50',
            'screen_resolution'    => 'nullable|string|max:50',
            'language'             => 'nullable|string|max:50',
            'page_url'             => 'nullable|string|max:255',
            'timezone'             => 'nullable|string|max:100',
        ]);

        $consent = \App\Models\CookieConsent::create([
            'ip_address'           => $request->ip(),
            'hardware_fingerprint' => $validated['hardware_fingerprint'] ?? null,
            'consent_type'         => $validated['consent_type'],
            'device_type'          => $validated['device_type'] ?? null,
            'browser'              => $validated['browser'] ?? null,
            'os'                   => $validated['os'] ?? null,
            'cpu_cores'            => $validated['cpu_cores'] ?? null,
            'device_memory'        => $validated['device_memory'] ?? null,
            'connection_type'      => $validated['connection_type'] ?? null,
            'touch_points'         => $validated['touch_points'] ?? null,
            'screen_resolution'    => $validated['screen_resolution'] ?? null,
            'language'             => $validated['language'] ?? null,
            'page_url'             => $validated['page_url'] ?? null,
            'timezone'             => $validated['timezone'] ?? null,
            'user_agent'           => substr($request->userAgent() ?? '', 0, 500),
            'accepted_at'          => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consentimiento registrado correctamente.',
            'data'    => $consent,
        ]);
    }

    /**
     * Verifica si la IP del visitante tiene un consentimiento vigente en la BD.
     * El frontend usa esto para saber si debe mostrar el banner aunque localStorage diga "ya acepté".
     */
    public function checkConsent(Request $request)
    {
        $exists = \App\Models\CookieConsent::where('ip_address', $request->ip())
                    ->exists();

        return response()->json([
            'consented' => $exists,
        ]);
    }
}
