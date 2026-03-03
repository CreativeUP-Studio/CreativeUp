<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::truncate();

        Service::insert([
            [
                'title' => 'Social Media',
                'slug' => 'social-media',
                'description' => 'Impulsamos tu presencia en redes con contenido estratégico, creativo y alineado a tus objetivos.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Branding',
                'slug' => 'branding',
                'description' => 'Construimos identidades que trascienden lo visual. Definimos la esencia, impacto y propósito de tu marca.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Desarrollo Web',
                'slug' => 'desarrollo-web',
                'description' => 'Diseñamos sitios modernos, rápidos y centrados en la experiencia del usuario, alineados a tu marca y optimizados para convertir.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'SEO Profesional',
                'slug' => 'seo-profesional',
                'description' => 'Optimizamos tu visibilidad en buscadores con estrategias orgánicas y campañas pagadas que atraen tráfico de calidad y generan resultados medibles.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
