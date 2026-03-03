<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::truncate();

        $projects = [
            [
                'title' => 'Rediseño de marca para TechFlow',
                'slug' => 'rediseno-marca-techflow',
                'description' => 'Renovamos la identidad visual de TechFlow, creando un sistema de marca moderno y coherente que refleja innovación tecnológica y profesionalismo.',
                'status' => 'published',
                'technologies' => json_encode(['Illustrator', 'Figma', 'After Effects']),
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'E-commerce para Naturale Organic',
                'slug' => 'ecommerce-naturale-organic',
                'description' => 'Diseñamos y desarrollamos una tienda online con enfoque en experiencia de usuario, optimizada para conversión y con un diseño que transmite naturalidad y confianza.',
                'status' => 'published',
                'technologies' => json_encode(['Laravel', 'Tailwind CSS', 'Alpine.js', 'Stripe']),
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Campaña digital para StartUp Hub',
                'slug' => 'campana-digital-startup-hub',
                'description' => 'Estrategia integral de marketing digital que incluyó redes sociales, email marketing y landing pages, logrando un incremento del 300% en leads calificados.',
                'status' => 'published',
                'technologies' => json_encode(['Meta Ads', 'Google Ads', 'Mailchimp', 'Analytics']),
                'published_at' => now()->subDays(12),
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
