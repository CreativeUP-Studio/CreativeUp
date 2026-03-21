<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Service::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $services = [
            [
                'title' => 'Social Media',
                'slug' => 'social-media',
                'description' => "Impulsamos tu presencia en redes con contenido estratégico, creativo y alineado a tus objetivos de negocio.\n\nNuestro equipo crea calendarios de contenido, diseña piezas gráficas impactantes y gestiona comunidades para que tu marca conecte de forma auténtica con tu audiencia.\n\nDesde Instagram y Facebook hasta TikTok y LinkedIn, cubrimos todas las plataformas relevantes para maximizar tu alcance y engagement.",
                'short_description' => 'Estrategia, contenido y gestión de redes sociales que conectan tu marca con tu audiencia ideal.',
                'icon' => 'fa-solid fa-share-nodes',
                'color' => '#e91e63',
                'features' => ['Estrategia de contenidos', 'Diseño de piezas gráficas', 'Gestión de comunidades', 'Reportes mensuales de métricas', 'Campañas de pauta digital', 'Calendario editorial mensual', 'Análisis de competencia'],
                'benefits' => [
                    ['icon' => 'fa-solid fa-chart-line', 'title' => 'Más alcance', 'desc' => 'Incrementa la visibilidad de tu marca en las redes que importan.'],
                    ['icon' => 'fa-solid fa-bullseye', 'title' => 'Audiencia precisa', 'desc' => 'Conecta con tu público objetivo con contenido segmentado.'],
                    ['icon' => 'fa-solid fa-comments', 'title' => 'Engagement real', 'desc' => 'Genera interacción genuina que construye relaciones duraderas.'],
                    ['icon' => 'fa-solid fa-chart-pie', 'title' => 'Datos accionables', 'desc' => 'Reportes claros para tomar decisiones basadas en métricas reales.'],
                ],
                'process_steps' => [
                    ['title' => 'Auditoría de redes', 'desc' => 'Analizamos tu presencia actual, competencia y oportunidades de mejora.'],
                    ['title' => 'Estrategia de contenido', 'desc' => 'Definimos pilares de contenido, tono de voz y calendario editorial.'],
                    ['title' => 'Creación y publicación', 'desc' => 'Diseñamos, redactamos y publicamos contenido optimizado para cada plataforma.'],
                    ['title' => 'Monitoreo y optimización', 'desc' => 'Medimos resultados y ajustamos la estrategia para maximizar el impacto.'],
                ],
                'cta_text' => '¿Quieres crecer en redes sociales? Hablemos de tu estrategia.',
                'meta_title' => 'Social Media - Gestión de Redes Sociales | CreativeUP',
                'meta_description' => 'Servicio profesional de gestión de redes sociales: estrategia, contenido, diseño y reportes para hacer crecer tu marca.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Branding',
                'slug' => 'branding',
                'description' => "Construimos identidades que trascienden lo visual. Definimos la esencia, impacto y propósito de tu marca.\n\nDesde la conceptualización del logotipo hasta el manual de marca completo, cada elemento está diseñado para comunicar los valores de tu empresa y diferenciarte en el mercado.\n\nUna marca sólida genera confianza, lealtad y reconocimiento. Nosotros te ayudamos a construirla desde los cimientos.",
                'short_description' => 'Identidad de marca que comunica tu esencia y te diferencia en el mercado.',
                'icon' => 'fa-solid fa-palette',
                'color' => '#9c27b0',
                'features' => ['Diseño de logotipo', 'Manual de marca', 'Paleta de colores', 'Tipografía corporativa', 'Papelería corporativa', 'Diseño de packaging', 'Brandbook digital'],
                'benefits' => [
                    ['icon' => 'fa-solid fa-fingerprint', 'title' => 'Identidad única', 'desc' => 'Una marca que se distingue y se queda en la mente de tu audiencia.'],
                    ['icon' => 'fa-solid fa-award', 'title' => 'Credibilidad', 'desc' => 'Una imagen profesional que genera confianza desde el primer contacto.'],
                    ['icon' => 'fa-solid fa-puzzle-piece', 'title' => 'Coherencia visual', 'desc' => 'Todos tus materiales hablan el mismo idioma visual.'],
                    ['icon' => 'fa-solid fa-heart-pulse', 'title' => 'Conexión emocional', 'desc' => 'Tu marca transmite valores que resuenan con tu público.'],
                ],
                'process_steps' => [
                    ['title' => 'Descubrimiento', 'desc' => 'Entrevistas y research para entender tu negocio, valores y audiencia.'],
                    ['title' => 'Conceptualización', 'desc' => 'Exploramos direcciones creativas y definimos el concepto de marca.'],
                    ['title' => 'Diseño de identidad', 'desc' => 'Creamos logo, paleta, tipografía y todos los elementos visuales.'],
                    ['title' => 'Entrega del brandbook', 'desc' => 'Manual completo con guías de uso para mantener la coherencia.'],
                ],
                'cta_text' => '¿Tu marca necesita una nueva identidad? Construyámosla juntos.',
                'meta_title' => 'Branding - Diseño de Identidad de Marca | CreativeUP',
                'meta_description' => 'Servicio de branding profesional: logotipo, manual de marca, identidad visual completa para empresas que quieren destacar.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Desarrollo Web',
                'slug' => 'desarrollo-web',
                'description' => "Diseñamos y desarrollamos sitios web modernos, rápidos y centrados en la experiencia del usuario.\n\nDesde landing pages hasta plataformas complejas con e-commerce, cada proyecto está optimizado para rendimiento, SEO y conversión.\n\nTrabajamos con las últimas tecnologías para garantizar un producto escalable, seguro y que represente tu marca de la mejor forma posible.",
                'short_description' => 'Sitios web a medida, rápidos y optimizados para convertir visitantes en clientes.',
                'icon' => 'fa-solid fa-code',
                'color' => '#2196f3',
                'features' => ['Diseño UI/UX personalizado', 'Desarrollo responsive', 'Optimización SEO on-page', 'Panel de administración', 'Integración con APIs', 'Certificado SSL', 'Hosting y dominio', 'Soporte post-lanzamiento'],
                'benefits' => [
                    ['icon' => 'fa-solid fa-bolt', 'title' => 'Ultra rápido', 'desc' => 'Sitios optimizados que cargan en menos de 2 segundos.'],
                    ['icon' => 'fa-solid fa-mobile-screen', 'title' => '100% responsive', 'desc' => 'Se ve perfecto en cualquier dispositivo y navegador.'],
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Seguro', 'desc' => 'Protección SSL, backups y mejores prácticas de seguridad.'],
                    ['icon' => 'fa-solid fa-rocket', 'title' => 'Optimizado para SEO', 'desc' => 'Estructura técnica preparada para posicionar en Google.'],
                    ['icon' => 'fa-solid fa-sliders', 'title' => 'Administrable', 'desc' => 'Panel intuitivo para que gestiones tu contenido sin depender de nadie.'],
                ],
                'process_steps' => [
                    ['title' => 'Análisis y wireframes', 'desc' => 'Definimos la arquitectura de información y wireframes del sitio.'],
                    ['title' => 'Diseño visual', 'desc' => 'Creamos mockups pixel-perfect alineados a tu identidad de marca.'],
                    ['title' => 'Desarrollo frontend y backend', 'desc' => 'Programamos con código limpio, escalable y bien documentado.'],
                    ['title' => 'Testing y lanzamiento', 'desc' => 'Pruebas exhaustivas en todos los dispositivos antes de salir a producción.'],
                    ['title' => 'Soporte continuo', 'desc' => 'Mantenimiento, actualizaciones y soporte técnico post-lanzamiento.'],
                ],
                'cta_text' => '¿Necesitas un sitio web que convierta? Empecemos tu proyecto.',
                'meta_title' => 'Desarrollo Web Profesional - Sitios a Medida | CreativeUP',
                'meta_description' => 'Desarrollo web profesional: sitios responsive, rápidos, seguros y optimizados para SEO. Diseño a medida para empresas.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'SEO Profesional',
                'slug' => 'seo-profesional',
                'description' => "Optimizamos tu visibilidad en buscadores con estrategias orgánicas que atraen tráfico de calidad y generan resultados medibles.\n\nNuestro enfoque combina auditoría técnica, optimización on-page, estrategia de contenidos y link building para posicionar tu sitio en los primeros resultados de Google.\n\nNo hacemos promesas vacías — trabajamos con datos, métricas claras y reportes transparentes para que veas el crecimiento real de tu presencia digital.",
                'short_description' => 'Posiciona tu sitio en Google con estrategias SEO que generan tráfico real y conversiones.',
                'icon' => 'fa-solid fa-magnifying-glass-chart',
                'color' => '#4caf50',
                'features' => ['Auditoría SEO técnica', 'Keyword research', 'Optimización on-page', 'Link building estratégico', 'Contenido optimizado', 'Reportes mensuales', 'Análisis de competencia', 'SEO local'],
                'benefits' => [
                    ['icon' => 'fa-solid fa-medal', 'title' => 'Top en Google', 'desc' => 'Tu sitio en las primeras posiciones para keywords relevantes.'],
                    ['icon' => 'fa-solid fa-user-group', 'title' => 'Tráfico cualificado', 'desc' => 'Visitantes que realmente buscan lo que tú ofreces.'],
                    ['icon' => 'fa-solid fa-coins', 'title' => 'ROI comprobable', 'desc' => 'Cada peso invertido se refleja en métricas de crecimiento.'],
                    ['icon' => 'fa-solid fa-arrow-trend-up', 'title' => 'Crecimiento sostenido', 'desc' => 'Resultados que se mantienen y mejoran con el tiempo.'],
                ],
                'process_steps' => [
                    ['title' => 'Auditoría completa', 'desc' => 'Análisis técnico, de contenido y de backlinks de tu sitio actual.'],
                    ['title' => 'Investigación de keywords', 'desc' => 'Identificamos las palabras clave con mayor potencial para tu negocio.'],
                    ['title' => 'Optimización on-page', 'desc' => 'Mejoramos títulos, meta descripciones, estructura y contenido.'],
                    ['title' => 'Link building y autoridad', 'desc' => 'Construimos enlaces de calidad para aumentar la autoridad de tu dominio.'],
                    ['title' => 'Monitoreo y reporting', 'desc' => 'Seguimiento continuo de posiciones, tráfico y conversiones con reportes claros.'],
                ],
                'cta_text' => '¿Quieres aparecer en Google? Analicemos tu sitio gratis.',
                'meta_title' => 'SEO Profesional - Posicionamiento en Google | CreativeUP',
                'meta_description' => 'Servicio SEO profesional: auditoría técnica, keyword research, optimización on-page y link building para posicionar tu web en Google.',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($services as $data) {
            Service::create($data);
        }
    }
}
