<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSetting;

class HeroSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSetting::create([
            // Badge
            'badge_text' => 'Agencia Digital Innovadora',
            'badge_show_dot' => true,
            'badge_show_sparkle' => true,
            
            // Título
            'title_line_1' => 'Diseñamos el',
            'title_gradient_word' => 'Futuro',
            'title_outline_word' => 'Digital',
            'rotating_words' => ['Futuro', 'Éxito', 'Diseño', 'Negocio'],
            
            // Subtítulo
            'subtitle' => 'Creamos experiencias web inmersivas y marcas memorables que conectan, inspiran y convierten. Elevamos tu visión al máximo nivel.',
            
            // Botones CTA
            'primary_button_text' => 'Iniciar Proyecto',
            'primary_button_url' => '/contacto',
            'primary_button_active' => true,
            'secondary_button_text' => 'Ver Reel',
            'secondary_button_url' => '#portfolio',
            'secondary_button_active' => true,
            
            // Social Proof
            'show_social_proof' => true,
            'social_proof_text' => 'Clientes globales satisfechos',
            'social_proof_count' => 500,
            
            // Floating Cards
            'show_float_card_1' => true,
            'float_card_1_icon' => 'fa-rocket',
            'float_card_1_title' => 'Performance',
            'float_card_1_value' => '99.9% Score',
            'show_float_card_2' => true,
            'float_card_2_icon' => 'fa-chart-line',
            'float_card_2_title' => 'Conversión',
            'float_card_2_value' => '+150% ROI',
            
            // Scroll Indicator
            'show_scroll_indicator' => true,
            
            // Estado
            'is_active' => true,
        ]);
    }
}
