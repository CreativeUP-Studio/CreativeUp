<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Mostrar formulario de edición de configuraciones del sitio
     */
    public function edit()
    {
        $settings = SiteSetting::getSettings();
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Actualizar la configuración del sitio
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Información de Contacto
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:150',
            'address' => 'required|string|max:255',
            'maps_url' => 'required|url|max:500',
            'whatsapp_url' => 'required|url|max:500',
            'timezone' => 'required|string|max:100',
            
            // Redes Sociales
            'facebook_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'github_url' => 'nullable|string|max:255',
            
            // Branding & Textos Generales
            'logo_text' => 'required|string|max:50',
            'logo_gradient_text' => 'required|string|max:50',
            'footer_tagline' => 'required|string|max:500',
            'status_text' => 'required|string|max:50',
            
            // SEO General
            'meta_title' => 'required|string|max:200',
            'meta_description' => 'required|string|max:500',
        ]);

        // Procesar checkboxes
        $validated['show_chat_widget'] = $request->has('show_chat_widget');
        $validated['show_newsletter'] = $request->has('show_newsletter');

        // Obtener el primer registro o crear uno nuevo
        $settings = SiteSetting::first();
        if (!$settings) {
            $settings = new SiteSetting();
        }

        $settings->fill($validated);
        $settings->save();

        // Limpiar cualquier caché si se utiliza
        \Cache::forget('site_settings');

        return redirect()->route('admin.settings.edit')
            ->with('success', '¡Configuración del sitio actualizada exitosamente!');
    }
}
