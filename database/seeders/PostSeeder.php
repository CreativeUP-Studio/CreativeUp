<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::truncate();

        $userId = User::first()?->id ?? 1;

        $posts = [
            [
                'user_id' => $userId,
                'title' => '5 tendencias de branding que dominarán el 2026',
                'slug' => '5-tendencias-branding-2026',
                'content' => 'El branding evoluciona constantemente. Desde identidades minimalistas hasta experiencias de marca inmersivas, te contamos las tendencias que marcarán este año y cómo aplicarlas a tu negocio para destacar en un mercado competitivo.',
                'featured_image' => null,
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'user_id' => $userId,
                'title' => 'Cómo el diseño web impacta en tus conversiones',
                'slug' => 'diseno-web-impacta-conversiones',
                'content' => 'Un buen diseño no solo es bonito: vende. Analizamos cómo elementos como la velocidad de carga, la jerarquía visual y los call-to-action estratégicos pueden multiplicar tus resultados online de forma medible.',
                'featured_image' => null,
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'user_id' => $userId,
                'title' => 'Estrategias de redes sociales para marcas creativas',
                'slug' => 'estrategias-redes-sociales-marcas-creativas',
                'content' => 'Las redes sociales son el escaparate de tu marca. Descubre cómo crear contenido auténtico, construir comunidad y generar engagement real sin perder la esencia de tu identidad visual.',
                'featured_image' => null,
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'user_id' => $userId,
                'title' => 'SEO en 2026: más allá de las palabras clave',
                'slug' => 'seo-2026-mas-alla-palabras-clave',
                'content' => 'El SEO ha cambiado. Ya no basta con keywords: la intención de búsqueda, la experiencia de usuario y la autoridad temática son los pilares que Google premia. Te explicamos cómo adaptar tu estrategia.',
                'featured_image' => null,
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
