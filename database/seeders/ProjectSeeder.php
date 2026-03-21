<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectStep;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProjectStep::truncate();
        ProjectImage::truncate();
        Project::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ── Proyecto 1 — Branding ──
        $p1 = Project::create([
            'title'        => 'Rediseño de marca para TechFlow',
            'slug'         => 'rediseno-marca-techflow',
            'description'  => 'Renovamos la identidad visual de TechFlow, creando un sistema de marca moderno y coherente que refleja innovación tecnológica y profesionalismo.',
            'challenge'    => 'TechFlow tenía una imagen corporativa anticuada que no transmitía la innovación de sus productos. Necesitaban una identidad que conectara con un público joven y tecnológico sin perder la confianza de sus clientes actuales.',
            'solution'     => 'Desarrollamos un sistema de identidad visual completo: logotipo dinámico, paleta cromática vibrante, tipografía moderna y un manual de marca de 48 páginas. Incluimos aplicaciones en papelería, digital y merchandising.',
            'results'      => 'El reconocimiento de marca aumentó un 65% en 3 meses. Las interacciones en redes sociales se triplicaron y las solicitudes de información crecieron un 40%.',
            'type'         => 'Branding',
            'client'       => 'TechFlow Inc.',
            'year'         => '2025',
            'thumbnail'    => 'projects/thumb-techflow.jpg',
            'url'          => 'https://techflow.example.com',
            'status'       => 'published',
            'technologies' => ['Illustrator', 'Figma', 'After Effects', 'Photoshop', 'InDesign'],
            'published_at' => now()->subDays(3),
        ]);

        foreach (['projects/img-1.jpg', 'projects/img-2.jpg', 'projects/img-3.jpg', 'projects/img-4.jpg'] as $img) {
            ProjectImage::create(['project_id' => $p1->id, 'image_path' => $img]);
        }

        ProjectStep::create([
            'project_id'  => $p1->id,
            'title'       => 'Investigación y Estrategia',
            'description' => 'Realizamos un análisis profundo de la competencia, entrevistas con stakeholders y encuestas a usuarios finales para definir el posicionamiento y la personalidad de marca.',
            'order'       => 1,
            'image1'      => 'projects/steps/step-1a.jpg',
            'image2'      => 'projects/steps/step-1b.jpg',
            'image3'      => 'projects/steps/step-1c.jpg',
        ]);
        ProjectStep::create([
            'project_id'  => $p1->id,
            'title'       => 'Diseño de Identidad',
            'description' => 'Exploramos más de 30 conceptos de logotipo antes de refinar las 3 propuestas finalistas. El concepto elegido combina geometría limpia con un toque dinámico que simboliza flujo tecnológico.',
            'order'       => 2,
            'image1'      => 'projects/steps/step-2a.jpg',
            'image2'      => 'projects/steps/step-2b.jpg',
            'image3'      => 'projects/steps/step-2c.jpg',
        ]);
        ProjectStep::create([
            'project_id'  => $p1->id,
            'title'       => 'Implementación y Entrega',
            'description' => 'Produjimos el manual de marca completo, todas las piezas de aplicación y capacitamos al equipo interno de TechFlow para mantener la coherencia visual en todas las comunicaciones.',
            'order'       => 3,
            'image1'      => 'projects/steps/step-3a.jpg',
            'image2'      => 'projects/steps/step-3b.jpg',
            'image3'      => 'projects/steps/step-3c.jpg',
        ]);

        // ── Proyecto 2 — Web / E-commerce ──
        $p2 = Project::create([
            'title'        => 'E-commerce para Naturale Organic',
            'slug'         => 'ecommerce-naturale-organic',
            'description'  => 'Diseñamos y desarrollamos una tienda online con enfoque en experiencia de usuario, optimizada para conversión y con un diseño que transmite naturalidad y confianza.',
            'challenge'    => 'Naturale Organic vendía exclusivamente en tiendas físicas. Necesitaban un canal digital que reflejara sus valores de sostenibilidad y transparencia, con un proceso de compra sencillo para un público poco habituado al e-commerce.',
            'solution'     => 'Creamos un e-commerce con Laravel y pasarela Stripe, con fichas de producto inmersivas, filtros inteligentes, suscripciones recurrentes y un blog integrado sobre vida saludable. El diseño usa colores tierra y fotografía de producto en contexto natural.',
            'results'      => 'En el primer trimestre se registraron 2,400 pedidos online, el ticket medio fue un 28% mayor que en tienda física, y el 35% de los clientes activó la suscripción mensual.',
            'type'         => 'Desarrollo Web',
            'client'       => 'Naturale Organic',
            'year'         => '2025',
            'thumbnail'    => 'projects/thumb-naturale.jpg',
            'url'          => 'https://naturale.example.com',
            'status'       => 'published',
            'technologies' => ['Laravel', 'Tailwind CSS', 'Alpine.js', 'Stripe', 'MySQL', 'Redis'],
            'published_at' => now()->subDays(7),
        ]);

        foreach (['projects/img-5.jpg', 'projects/img-6.jpg', 'projects/img-1.jpg'] as $img) {
            ProjectImage::create(['project_id' => $p2->id, 'image_path' => $img]);
        }

        ProjectStep::create([
            'project_id'  => $p2->id,
            'title'       => 'UX Research & Wireframes',
            'description' => 'Mapeamos el customer journey completo, desde el descubrimiento hasta la recompra. Creamos wireframes de baja y alta fidelidad validados con test de usabilidad con 12 usuarios reales.',
            'order'       => 1,
            'image1'      => 'projects/steps/step-2a.jpg',
            'image2'      => 'projects/steps/step-2b.jpg',
            'image3'      => 'projects/steps/step-2c.jpg',
        ]);
        ProjectStep::create([
            'project_id'  => $p2->id,
            'title'       => 'Desarrollo Full-Stack',
            'description' => 'Implementamos el backend con Laravel, integración de pagos con Stripe, sistema de inventario en tiempo real y un panel de administración personalizado para gestión de productos, pedidos y suscripciones.',
            'order'       => 2,
            'image1'      => 'projects/steps/step-1a.jpg',
            'image2'      => 'projects/steps/step-1b.jpg',
            'image3'      => 'projects/steps/step-1c.jpg',
        ]);

        // ── Proyecto 3 — Marketing Digital ──
        $p3 = Project::create([
            'title'        => 'Campaña digital para StartUp Hub',
            'slug'         => 'campana-digital-startup-hub',
            'description'  => 'Estrategia integral de marketing digital que incluyó redes sociales, email marketing y landing pages, logrando un incremento del 300% en leads calificados.',
            'challenge'    => 'StartUp Hub lanzaba su programa de aceleración y necesitaba captar 200 startups en 45 días con un presupuesto limitado. Su marca era completamente nueva y sin comunidad previa.',
            'solution'     => 'Diseñamos una estrategia de funnel completo: campañas segmentadas en Meta y Google Ads, 5 landing pages A/B testeadas, secuencia de 8 emails automatizados y contenido orgánico diario en LinkedIn e Instagram con influencers del ecosistema emprendedor.',
            'results'      => 'Se recibieron 347 aplicaciones (173% del objetivo), el costo por lead fue de $4.20, la tasa de apertura de emails alcanzó 42% y la comunidad en redes creció de 0 a 8,500 seguidores en 6 semanas.',
            'type'         => 'Marketing Digital',
            'client'       => 'StartUp Hub',
            'year'         => '2026',
            'thumbnail'    => 'projects/thumb-startup.jpg',
            'status'       => 'published',
            'technologies' => ['Meta Ads', 'Google Ads', 'Mailchimp', 'Analytics', 'Hotjar', 'Canva'],
            'published_at' => now()->subDays(12),
        ]);

        foreach (['projects/img-3.jpg', 'projects/img-4.jpg', 'projects/img-5.jpg', 'projects/img-6.jpg'] as $img) {
            ProjectImage::create(['project_id' => $p3->id, 'image_path' => $img]);
        }

        ProjectStep::create([
            'project_id'  => $p3->id,
            'title'       => 'Estrategia y Planificación',
            'description' => 'Definimos buyer personas, mapeamos el embudo de conversión y establecimos KPIs claros para cada etapa: alcance, captación, nutrición y conversión.',
            'order'       => 1,
            'image1'      => 'projects/steps/step-3a.jpg',
            'image2'      => 'projects/steps/step-3b.jpg',
            'image3'      => 'projects/steps/step-3c.jpg',
        ]);
        ProjectStep::create([
            'project_id'  => $p3->id,
            'title'       => 'Ejecución Multicanal',
            'description' => 'Lanzamos campañas simultáneas en 4 plataformas, creamos 15 variantes de anuncios y optimizamos diariamente basándonos en datos. Las landing pages se iteraron 3 veces para maximizar conversión.',
            'order'       => 2,
            'image1'      => 'projects/steps/step-1a.jpg',
            'image2'      => 'projects/steps/step-1b.jpg',
            'image3'      => 'projects/steps/step-1c.jpg',
        ]);
        ProjectStep::create([
            'project_id'  => $p3->id,
            'title'       => 'Análisis y Resultados',
            'description' => 'Generamos reportes semanales con dashboards interactivos, identificamos los canales más rentables y entregamos un playbook de 25 páginas para que el equipo interno replicara la estrategia.',
            'order'       => 3,
            'image1'      => 'projects/steps/step-2a.jpg',
            'image2'      => 'projects/steps/step-2b.jpg',
            'image3'      => 'projects/steps/step-2c.jpg',
        ]);
    }
}
