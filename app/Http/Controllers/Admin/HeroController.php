<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    /**
     * Mostrar formulario de edición del hero
     */
    public function edit()
    {
        $hero = HeroSetting::getActive();
        $projects = Project::orderBy('created_at', 'desc')->get();
        
        return view('admin.hero.edit', compact('hero', 'projects'));
    }

    /**
     * Actualizar configuración del hero
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Badge
            'badge_text' => 'required|string|max:255',
            
            // Título
            'title_line_1' => 'required|string|max:255',
            'title_gradient_word' => 'required|string|max:100',
            'title_outline_word' => 'required|string|max:100',
            'rotating_words' => 'nullable|string',
            
            // Subtítulo
            'subtitle' => 'nullable|string|max:500',
            
            // Botones
            'primary_button_text' => 'required|string|max:100',
            'primary_button_url' => 'required|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:255',
            
            // Imagen
            'mockup_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'featured_project_id' => 'nullable|exists:projects,id',
            
            // Social Proof
            'social_proof_text' => 'nullable|string|max:255',
            'social_proof_count' => 'nullable|integer|min:0',
            
            // Floating Cards
            'float_card_1_icon' => 'nullable|string|max:100',
            'float_card_1_title' => 'nullable|string|max:100',
            'float_card_1_value' => 'nullable|string|max:100',
            'float_card_2_icon' => 'nullable|string|max:100',
            'float_card_2_title' => 'nullable|string|max:100',
            'float_card_2_value' => 'nullable|string|max:100',
        ]);

        // Procesar palabras rotativas
        if ($request->filled('rotating_words')) {
            $words = array_map('trim', explode(',', $request->rotating_words));
            $validated['rotating_words'] = array_filter($words);
        } else {
            $validated['rotating_words'] = ['Futuro', 'Éxito', 'Diseño', 'Negocio'];
        }

        // Procesar checkboxes (si no están marcados, no vienen en el request)
        $validated['badge_show_dot'] = $request->has('badge_show_dot');
        $validated['badge_show_sparkle'] = $request->has('badge_show_sparkle');
        $validated['primary_button_active'] = $request->has('primary_button_active');
        $validated['secondary_button_active'] = $request->has('secondary_button_active');
        $validated['show_social_proof'] = $request->has('show_social_proof');
        $validated['show_float_card_1'] = $request->has('show_float_card_1');
        $validated['show_float_card_2'] = $request->has('show_float_card_2');
        $validated['show_scroll_indicator'] = $request->has('show_scroll_indicator');

        // Obtener o crear configuración
        $hero = HeroSetting::where('is_active', true)->first();
        
        if (!$hero) {
            $hero = new HeroSetting();
            $hero->is_active = true;
        }

        // Manejar imagen del mockup
        if ($request->hasFile('mockup_image')) {
            // Eliminar imagen anterior si existe
            if ($hero->mockup_image) {
                Storage::disk('public')->delete($hero->mockup_image);
            }
            
            $validated['mockup_image'] = $request->file('mockup_image')->store('hero', 'public');
        }

        // Actualizar
        $hero->fill($validated);
        $hero->save();

        // Limpiar caché del home para que los cambios se reflejen inmediatamente
        \Cache::forget('home_page_data');

        return redirect()->route('admin.hero.edit')
            ->with('success', '¡Configuración del Hero actualizada exitosamente!');
    }

    /**
     * Eliminar imagen del mockup
     */
    public function deleteImage()
    {
        $hero = HeroSetting::where('is_active', true)->first();
        
        if ($hero && $hero->mockup_image) {
            Storage::disk('public')->delete($hero->mockup_image);
            $hero->mockup_image = null;
            $hero->save();
            
            return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente']);
        }
        
        return response()->json(['success' => false, 'message' => 'No se encontró la imagen'], 404);
    }
}
