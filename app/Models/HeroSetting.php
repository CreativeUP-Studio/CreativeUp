<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        // Badge
        'badge_text',
        'badge_show_dot',
        'badge_show_sparkle',
        
        // Título
        'title_line_1',
        'title_gradient_word',
        'title_outline_word',
        'rotating_words',
        
        // Subtítulo
        'subtitle',
        
        // Botones CTA
        'primary_button_text',
        'primary_button_url',
        'primary_button_active',
        'secondary_button_text',
        'secondary_button_url',
        'secondary_button_active',
        
        // Imagen/Mockup
        'mockup_image',
        'featured_project_id',
        
        // Social Proof
        'show_social_proof',
        'social_proof_text',
        'social_proof_count',
        
        // Floating Cards
        'show_float_card_1',
        'float_card_1_icon',
        'float_card_1_title',
        'float_card_1_value',
        'show_float_card_2',
        'float_card_2_icon',
        'float_card_2_title',
        'float_card_2_value',
        
        // Scroll Indicator
        'show_scroll_indicator',
        
        // Estado
        'is_active',
    ];

    protected $casts = [
        'badge_show_dot' => 'boolean',
        'badge_show_sparkle' => 'boolean',
        'rotating_words' => 'array',
        'primary_button_active' => 'boolean',
        'secondary_button_active' => 'boolean',
        'show_social_proof' => 'boolean',
        'social_proof_count' => 'integer',
        'show_float_card_1' => 'boolean',
        'show_float_card_2' => 'boolean',
        'show_scroll_indicator' => 'boolean',
        'is_active' => 'boolean',
        'featured_project_id' => 'integer',
    ];

    /**
     * Obtener la configuración activa del hero
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first() ?? self::getDefault();
    }

    /**
     * Obtener configuración por defecto
     */
    public static function getDefault()
    {
        return new self([
            'badge_text' => 'Agencia Digital Innovadora',
            'badge_show_dot' => true,
            'badge_show_sparkle' => true,
            'title_line_1' => 'Diseñamos el',
            'title_gradient_word' => 'Futuro',
            'title_outline_word' => 'Digital',
            'rotating_words' => ['Futuro', 'Éxito', 'Diseño', 'Negocio'],
            'subtitle' => 'Creamos experiencias web inmersivas y marcas memorables que conectan, inspiran y convierten. Elevamos tu visión al máximo nivel.',
            'primary_button_text' => 'Iniciar Proyecto',
            'primary_button_url' => '/contacto',
            'primary_button_active' => true,
            'secondary_button_text' => 'Ver Reel',
            'secondary_button_url' => '#portfolio',
            'secondary_button_active' => true,
            'show_social_proof' => true,
            'social_proof_text' => 'Clientes globales satisfechos',
            'social_proof_count' => 500,
            'show_float_card_1' => true,
            'float_card_1_icon' => 'fa-rocket',
            'float_card_1_title' => 'Performance',
            'float_card_1_value' => '99.9% Score',
            'show_float_card_2' => true,
            'float_card_2_icon' => 'fa-chart-line',
            'float_card_2_title' => 'Conversión',
            'float_card_2_value' => '+150% ROI',
            'show_scroll_indicator' => true,
            'is_active' => true,
        ]);
    }

    /**
     * Relación con proyecto destacado
     */
    public function featuredProject()
    {
        return $this->belongsTo(Project::class, 'featured_project_id');
    }

    /**
     * Obtener palabras rotativas como array
     */
    public function getRotatingWordsArrayAttribute()
    {
        if (is_array($this->rotating_words)) {
            return $this->rotating_words;
        }
        
        return ['Futuro', 'Éxito', 'Diseño', 'Negocio'];
    }
}
