<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CookieConsent;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CookieConsentController extends Controller
{
    /**
     * Muestra el listado de auditoría de IPs y consentimientos de cookies.
     */
    public function index(Request $request)
    {
        $query = CookieConsent::query();

        // Búsqueda por IP, User Agent, Navegador, OS o Dispositivo
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('user_agent', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%")
                  ->orWhere('device_type', 'like', "%{$search}%")
                  ->orWhere('hardware_fingerprint', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo de consentimiento
        if ($request->filled('consent_type')) {
            $query->where('consent_type', $request->input('consent_type'));
        }

        // Filtro por fecha desde
        if ($request->filled('date_from')) {
            $query->whereDate('accepted_at', '>=', $request->input('date_from'));
        }

        // Filtro por fecha hasta
        if ($request->filled('date_to')) {
            $query->whereDate('accepted_at', '<=', $request->input('date_to'));
        }

        // Estadísticas generales
        $totalCount         = CookieConsent::count();
        $allCount           = CookieConsent::where('consent_type', 'all')->count();
        $essentialCount     = CookieConsent::where('consent_type', 'essential')->count();
        $uniqueIpsCount     = CookieConsent::distinct('ip_address')->count('ip_address');
        $uniqueFingerprints = CookieConsent::whereNotNull('hardware_fingerprint')
                                           ->distinct('hardware_fingerprint')
                                           ->count('hardware_fingerprint');

        $consents = $query->orderBy('accepted_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.cookie_consents.index', compact(
            'consents',
            'totalCount',
            'allCount',
            'essentialCount',
            'uniqueIpsCount',
            'uniqueFingerprints'
        ));
    }

    /**
     * Exporta el registro de auditoría completo a Excel / CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = CookieConsent::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('user_agent', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('hardware_fingerprint', 'like', "%{$search}%");
            });
        }

        if ($request->filled('consent_type')) {
            $query->where('consent_type', $request->input('consent_type'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('accepted_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('accepted_at', '<=', $request->input('date_to'));
        }

        $filename = 'Auditoria_Forense_Consentimientos_' . date('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($query) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 para Microsoft Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Encabezados del reporte forense
            fputcsv($file, [
                'ID',
                'Dirección IP',
                'Huella Digital de Hardware (Fingerprint)',
                'Tipo de Consentimiento',
                'Dispositivo',
                'Navegador',
                'Sistema Operativo',
                'Núcleos CPU',
                'Memoria RAM',
                'Tipo de Conexión',
                'Puntos Táctiles',
                'Resolución Pantalla',
                'Idioma',
                'Zona Horaria',
                'Página donde Aceptó',
                'User Agent Completo',
                'Fecha y Hora Aceptación (Perú)',
            ]);

            $query->orderBy('accepted_at', 'desc')->chunk(500, function($rows) use ($file) {
                foreach ($rows as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->ip_address,
                        $row->hardware_fingerprint ?: 'N/A',
                        $row->consent_type === 'all' ? 'Aceptación Completa' : 'Solo Necesarias',
                        $row->device_type ?: 'Desktop',
                        $row->browser ?: 'Otros',
                        $row->os ?: 'Desconocido',
                        $row->cpu_cores ?: 'N/A',
                        $row->device_memory ?: 'N/A',
                        $row->connection_type ?: 'N/A',
                        $row->touch_points ?: 'N/A',
                        $row->screen_resolution ?: 'N/A',
                        $row->language ?: 'N/A',
                        $row->timezone ?: 'N/A',
                        $row->page_url ?: 'N/A',
                        $row->user_agent ?: 'N/A',
                        $row->accepted_at ? $row->accepted_at->format('d/m/Y H:i:s') : ($row->created_at ? $row->created_at->format('d/m/Y H:i:s') : ''),
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Elimina un registro específico del historial de auditoría.
     */
    public function destroy(string $id)
    {
        $consent = CookieConsent::findOrFail($id);
        $consent->delete();

        return redirect()->back()->with('success', 'Registro de auditoría eliminado exitosamente.');
    }
}
