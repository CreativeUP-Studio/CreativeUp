@extends('layouts.app')

@section('title', 'CreativeUP - El amanecer de una imagen profesional')
@section('description', 'CreativeUP: El amanecer de una imagen profesional. Agencia digital especializada en diseño web de alto impacto, desarrollo de software a medida, branding e innovación tecnológica.')
@section('keywords', 'diseño web, desarrollo web, agencia digital, branding corporativo, software a medida, UX/UI, CreativeUP')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/frontend/home.css') }}">
@endpush

@section('content')

{{-- ============================================
     ULTRA HERO SECTION - Neon Glassmorphism
     ============================================ --}}
<section class="cu-hero" id="hero">
    <div class="cu-hero-bg">
        <div class="cu-orb cu-orb-1"></div>
        <div class="cu-orb cu-orb-2"></div>
        <div class="cu-orb cu-orb-3"></div>
        <div class="cu-grid-pattern"></div>
    </div>

    <div class="container cu-hero-container">
        <div class="cu-hero-content">
            <div class="cu-badge" data-aos="fade-down" data-aos-duration="1000">
                @if($hero->badge_show_dot ?? true)
                    <span class="cu-badge-dot"></span>
                @endif
                <span class="cu-badge-text">{{ $hero->badge_text ?? 'Agencia Digital Innovadora' }}</span>
                @if($hero->badge_show_sparkle ?? true)
                    <span class="cu-badge-sparkle">✨</span>
                @endif
            </div>

            <h1 class="cu-hero-title" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
                {{ $hero->title_line_1 ?? 'Diseñamos el' }} <br>
                <span class="cu-text-gradient" data-text="{{ $hero->title_gradient_word ?? 'Futuro' }}">{{ $hero->title_gradient_word ?? 'Futuro' }}</span>
                <span class="cu-title-outline">{{ $hero->title_outline_word ?? 'Digital' }}</span>
            </h1>

            <p class="cu-hero-subtitle" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                {{ $hero->subtitle ?? 'Creamos experiencias web inmersivas y marcas memorables que conectan, inspiran y convierten. Elevamos tu visión al máximo nivel.' }}
            </p>

            <div class="cu-hero-actions" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1200">
                @if($hero->primary_button_active ?? true)
                    <a href="{{ $hero->primary_button_url ?? route('contact.index') }}" class="cu-btn cu-btn-primary">
                        <span class="cu-btn-bg"></span>
                        <span class="cu-btn-text">{{ $hero->primary_button_text ?? 'Iniciar Proyecto' }}</span>
                        <span class="cu-btn-icon">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>
                @endif
                
                @if($hero->secondary_button_active ?? true)
                    <a href="{{ $hero->secondary_button_url ?? '#portfolio' }}" class="cu-btn cu-btn-secondary">
                        <span class="cu-btn-icon-play"><i class="fas fa-play"></i></span>
                        <span class="cu-btn-text">{{ $hero->secondary_button_text ?? 'Ver Reel' }}</span>
                    </a>
                @endif
            </div>

            @if($hero->show_social_proof ?? true)
                <div class="cu-social-proof" data-aos="fade-in" data-aos-delay="800">
                    <div class="cu-avatars">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Client 1">
                        <img src="https://i.pravatar.cc/100?img=2" alt="Client 2">
                        <img src="https://i.pravatar.cc/100?img=3" alt="Client 3">
                        <img src="https://i.pravatar.cc/100?img=4" alt="Client 4">
                        <div class="cu-avatar-more">+{{ $hero->social_proof_count ?? 500 }}</div>
                    </div>
                    <div class="cu-proof-text">
                        <div class="cu-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>{{ $hero->social_proof_text ?? 'Clientes globales satisfechos' }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="cu-hero-visual" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1500">
            <div class="cu-glass-mockup">
                <div class="cu-mockup-header">
                    <div class="cu-mockup-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="cu-mockup-url">creativeup.com</div>
                </div>
                <div class="cu-mockup-body">
                    @php
                        $mockupImage = null;
                        
                        // Prioridad 1: Imagen personalizada del hero
                        if(isset($hero->mockup_image) && $hero->mockup_image) {
                            $mockupImage = Storage::url($hero->mockup_image);
                        }
                        // Prioridad 2: Proyecto destacado del hero
                        elseif(isset($hero->featured_project_id) && $hero->featuredProject && $hero->featuredProject->thumbnail) {
                            $mockupImage = Storage::url($hero->featuredProject->thumbnail);
                        }
                        // Prioridad 3: Proyecto destacado general
                        elseif(isset($featuredProject) && $featuredProject->thumbnail) {
                            $mockupImage = Storage::url($featuredProject->thumbnail);
                        }
                        // Fallback: Imagen por defecto
                        else {
                            $mockupImage = 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=600&h=400';
                        }
                    @endphp
                    
                    <img src="{{ $mockupImage }}" alt="Creative Web Design" class="cu-mockup-img">
                    <div class="cu-mockup-overlay">
                        <div class="cu-pulse-ring"></div>
                    </div>
                </div>
                
                {{-- Floating Elements --}}
                @if($hero->show_float_card_1 ?? true)
                    <div class="cu-float-card cu-float-1">
                        <div class="cu-float-icon">
                            <i class="fas {{ $hero->float_card_1_icon ?? 'fa-rocket' }}"></i>
                        </div>
                        <div class="cu-float-info">
                            <strong>{{ $hero->float_card_1_title ?? 'Performance' }}</strong>
                            <span>{{ $hero->float_card_1_value ?? '99.9% Score' }}</span>
                        </div>
                    </div>
                @endif
                
                @if($hero->show_float_card_2 ?? true)
                    <div class="cu-float-card cu-float-2">
                        <div class="cu-float-icon" style="background: linear-gradient(135deg, #00f5d4, #0b525b);">
                            <i class="fas {{ $hero->float_card_2_icon ?? 'fa-chart-line' }}"></i>
                        </div>
                        <div class="cu-float-info">
                            <strong>{{ $hero->float_card_2_title ?? 'Conversión' }}</strong>
                            <span>{{ $hero->float_card_2_value ?? '+150% ROI' }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($hero->show_scroll_indicator ?? true)
        <div class="cu-scroll-indicator">
            <div class="cu-mouse">
                <div class="cu-wheel"></div>
            </div>
            <span>Scroll</span>
        </div>
    @endif
</section>

{{-- ============================================
     MARQUEE SECTION - Rediseño Premium Light
     ============================================ --}}
<section class="cu-marquee-section">
    <div class="cu-marquee-container">
        <div class="cu-marquee-track">
            {{-- Grupo 1 --}}
            <div class="cu-marquee-item">Laravel 12</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">React Native</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">UI/UX Premium</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">SEO Avanzado</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">E-Commerce</div>
            <div class="cu-marquee-dot"></div>
            
            {{-- Grupo 2 (Duplicado para loop infinito fluido) --}}
            <div class="cu-marquee-item">Laravel 12</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">React Native</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">UI/UX Premium</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">SEO Avanzado</div>
            <div class="cu-marquee-dot"></div>
            <div class="cu-marquee-item">E-Commerce</div>
            <div class="cu-marquee-dot"></div>
        </div>
    </div>
</section>

{{-- ============================================
     EXPERTISE DIGITAL - Servicios con Imágenes Premium
     ============================================ --}}
<section class="cu-services" id="services">
    <div class="container">
        <div class="cu-section-header text-center" data-aos="fade-up">
            <h2 class="cu-section-title">
                Expertise <span class="cu-text-gradient">Digital</span>
            </h2>
            <p class="cu-section-desc">Estrategias integrales y desarrollo de vanguardia para dominar tu industria.</p>
        </div>

        <div class="cu-bento-grid">
            @forelse(isset($services) ? $services : [] as $index => $service)
                <div class="cu-bento-card" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 100 }}">
                    
                    {{-- Imagen de fondo del servicio --}}
                    <div class="cu-bento-image">
                        @if($service->image)
                            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}">
                        @else
                            {{-- Imagen placeholder según el índice --}}
                            @php
                                $placeholders = [
                                    'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=800',
                                    'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&q=80&w=800',
                                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800',
                                    'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&q=80&w=800',
                                    'https://images.unsplash.com/photo-1551650975-87deedd944c3?auto=format&fit=crop&q=80&w=800',
                                    'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&q=80&w=800',
                                ];
                            @endphp
                            <img src="{{ $placeholders[$index % count($placeholders)] }}" alt="{{ $service->title }}">
                        @endif
                    </div>

                    {{-- Contenido del card --}}
                    <div class="cu-bento-content">
                        {{-- Icono del servicio --}}
                        <div class="cu-bento-icon">
                            @if($service->icon)
                                @if(Str::contains($service->icon, '<i'))
                                    {!! $service->icon !!}
                                @elseif(Str::contains($service->icon, 'fa-'))
                                    <i class="{{ $service->icon }}"></i>
                                @else
                                    <span class="cu-bento-emoji">{{ $service->icon }}</span>
                                @endif
                            @else
                                <i class="fas fa-layer-group"></i>
                            @endif
                        </div>

                        {{-- Título del servicio --}}
                        <h3 class="cu-bento-title">{{ $service->title }}</h3>

                        {{-- Descripción corta --}}
                        <p class="cu-bento-desc">
                            {{ $service->short_description ?? Str::limit($service->description, 120) }}
                        </p>
                        
                        {{-- Botón ver más detalles --}}
                        <a href="{{ route('services.show', $service->slug) }}" class="cu-bento-link">
                            <span>Descubrir más</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                {{-- Fallback: Servicios de demostración --}}
                <div class="cu-bento-card" data-aos="fade-up">
                    <div class="cu-bento-image">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=800" alt="Desarrollo Web Profesional">
                    </div>
                    <div class="cu-bento-content">
                        <div class="cu-bento-icon"><i class="fas fa-laptop-code"></i></div>
                        <h3 class="cu-bento-title">Desarrollo Web & Apps</h3>
                        <p class="cu-bento-desc">Construimos plataformas digitales robustas y escalables. Llevamos tu visión a la realidad utilizando las últimas tecnologías del mercado global.</p>
                        <a href="#" class="cu-bento-link">
                            <span>Descubrir más</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cu-bento-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="cu-bento-image">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&q=80&w=800" alt="Diseño UI/UX y Experiencia de Usuario">
                    </div>
                    <div class="cu-bento-content">
                        <div class="cu-bento-icon"><i class="fas fa-paint-brush"></i></div>
                        <h3 class="cu-bento-title">Diseño Experiencia UI/UX</h3>
                        <p class="cu-bento-desc">Diseñamos interfaces intuitivas que enamoran. Optimizamos la usabilidad para conectar estratégicamente tu marca con las necesidades del usuario.</p>
                        <a href="#" class="cu-bento-link">
                            <span>Descubrir más</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cu-bento-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="cu-bento-image">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800" alt="Marketing Digital Estratégico">
                    </div>
                    <div class="cu-bento-content">
                        <div class="cu-bento-icon"><i class="fas fa-bullhorn"></i></div>
                        <h3 class="cu-bento-title">Marketing y Crecimiento</h3>
                        <p class="cu-bento-desc">Estrategias integrales y basadas en datos para maximizar el retorno de inversión y posicionar tu marca como líder en su segmento.</p>
                        <a href="#" class="cu-bento-link">
                            <span>Descubrir más</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================
     PORTFOLIO SHOWCASE - ULTRA PREMIUM CON FILTROS
     ============================================ --}}
<section class="cu-portfolio" id="portfolio">
    <div class="container">
        <div class="cu-portfolio-header" data-aos="fade-up">
            <div class="cu-portfolio-title-wrap">
                <div class="cu-portfolio-eyebrow">
                    <span class="cu-portfolio-eyebrow-dot"></span>
                    <span>Nuestra Trayectoria</span>
                </div>
                <h2 class="cu-section-title">Trabajos <span class="cu-text-gradient">Destacados</span></h2>
                <p class="cu-portfolio-subtitle">Diseños premium y soluciones de software de alto impacto creadas a medida.</p>
            </div>
            <div class="cu-portfolio-nav-actions">
                <a href="{{ route('projects.index') }}" class="cu-btn-outline">
                    <span>Ver Todo</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <div class="cu-slider-controls">
                    <button class="cu-slider-btn prev" id="cuSliderPrev" aria-label="Anterior">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="cu-slider-btn next" id="cuSliderNext" aria-label="Siguiente">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Filtros de categoría --}}
        <div class="cu-portfolio-filters" data-aos="fade-up" data-aos-delay="100">
            <button class="cu-filter-btn active" data-filter="all">
                <span>Todos</span>
            </button>
            <button class="cu-filter-btn" data-filter="web">
                <span>Desarrollo Web</span>
            </button>
            <button class="cu-filter-btn" data-filter="design">
                <span>Diseño UI/UX</span>
            </button>
            <button class="cu-filter-btn" data-filter="ecommerce">
                <span>E-Commerce</span>
            </button>
            <button class="cu-filter-btn" data-filter="branding">
                <span>Branding</span>
            </button>
            <button class="cu-filter-btn" data-filter="marketing">
                <span>Marketing</span>
            </button>
        </div>

        <div class="cu-projects-slider-wrap" data-aos="fade-up" data-aos-delay="200">
            <div class="cu-projects-slider" id="cuProjectsSlider">
                @forelse(isset($projects) ? $projects->take(6) : [] as $index => $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="cu-project-slider-card" data-category="{{ strtolower($project->type ?? 'web') }}">
                        @php
                            $thumbDevice = $project->thumbnail_device ?? 'safari';
                            if (!request()->routeIs('projects.show')) {
                                $thumbDevice = 'none';
                            }
                            $displayUrl = 'localhost';
                            if ($project->url) {
                                $parsed = parse_url($project->url);
                                $displayUrl = ($parsed['host'] ?? '') . ($parsed['path'] ?? '');
                            }
                            $mainImage = $project->thumbnail ? Storage::url($project->thumbnail) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=800';
                        @endphp

                        <div class="cu-card-media device-{{ $thumbDevice }} {{ $thumbDevice === 'safari' ? 'browser-mockup' : '' }}">
                            @include('front.projects._device-mockup', [
                                'device' => $thumbDevice,
                                'image' => $mainImage,
                                'title' => $project->title,
                                'displayUrl' => $displayUrl
                            ])
                            <div class="cu-card-overlay"></div>
                            <span class="cu-card-badge">{{ $project->type ?? 'Digital' }}</span>
                            <div class="cu-card-tech">
                                <span class="cu-tech-icon" title="Laravel"><i class="fab fa-laravel"></i></span>
                                <span class="cu-tech-icon" title="React"><i class="fab fa-react"></i></span>
                                <span class="cu-tech-icon" title="Node.js"><i class="fab fa-node-js"></i></span>
                            </div>
                        </div>
                        <div class="cu-card-content">
                            <span class="cu-card-category-label">{{ $project->type ?? 'Digital' }}</span>
                            <h3 class="cu-card-title">{{ $project->title }}</h3>
                            @if($project->description)
                                <p class="cu-card-desc">{{ Str::limit(strip_tags($project->description), 100) }}</p>
                            @endif
                            <span class="cu-card-view-btn">
                                <span>Ver Proyecto</span>
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                @empty
                    {{-- Fallback Demos --}}
                    @php
                        $demoProjects = [
                            [
                                'title' => 'E-Commerce Premium',
                                'category' => 'Desarrollo Web',
                                'type' => 'web',
                                'desc' => 'Plataforma de comercio electrónico con pasarela de pagos integrada y panel de administración avanzado.',
                                'image' => 'photo-1498050108023-c5249f4df085',
                                'tech' => ['laravel', 'react', 'node-js']
                            ],
                            [
                                'title' => 'App Móvil Innovadora',
                                'category' => 'Diseño UI/UX',
                                'type' => 'design',
                                'desc' => 'Aplicación móvil con diseño intuitivo y experiencia de usuario excepcional para iOS y Android.',
                                'image' => 'photo-1460925895917-afdab827c52f',
                                'tech' => ['figma', 'sketch', 'adobe-xd']
                            ],
                            [
                                'title' => 'Plataforma SaaS',
                                'category' => 'E-Commerce',
                                'type' => 'ecommerce',
                                'desc' => 'Sistema de gestión empresarial en la nube con múltiples módulos y escalabilidad garantizada.',
                                'image' => 'photo-1551650975-87deedd944c3',
                                'tech' => ['aws', 'docker', 'kubernetes']
                            ],
                            [
                                'title' => 'Identidad Corporativa',
                                'category' => 'Branding',
                                'type' => 'branding',
                                'desc' => 'Desarrollo completo de identidad visual corporativa incluyendo logo, manual de marca y aplicaciones.',
                                'image' => 'photo-1557804506-669a67965ba0',
                                'tech' => ['illustrator', 'photoshop', 'indesign']
                            ]
                        ];
                    @endphp
                    
                    @foreach($demoProjects as $i => $demo)
                        <a href="#" class="cu-project-slider-card" data-category="{{ $demo['type'] }}">
                            <div class="cu-card-media device-none">
                                @include('front.projects._device-mockup', [
                                    'device' => 'none',
                                    'image' => 'https://images.unsplash.com/' . $demo['image'] . '?auto=format&fit=crop&q=80&w=800&h=1000',
                                    'title' => $demo['title'],
                                    'displayUrl' => 'creativeup.studio'
                                ])
                                <div class="cu-card-overlay"></div>
                                
                                <span class="cu-card-badge">{{ $demo['category'] }}</span>
                                
                                <div class="cu-card-tech">
                                    @foreach($demo['tech'] as $tech)
                                        <span class="cu-tech-icon" title="{{ ucfirst($tech) }}"><i class="fab fa-{{ $tech }}"></i></span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="cu-card-content">
                                <span class="cu-card-category-label">{{ $demo['category'] }}</span>
                                <h3 class="cu-card-title">{{ $demo['title'] }}</h3>
                                <p class="cu-card-desc">{{ $demo['desc'] }}</p>
                                <span class="cu-card-view-btn">
                                    <span>Ver Proyecto</span>
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                @endforelse
            </div>
            
            {{-- Barra de Progreso del Slider --}}
            <div class="cu-slider-progress-bar">
                <div class="cu-slider-progress-fill" id="cuSliderProgressFill"></div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     STATS PANEL - Glassmorphism Counters
     ============================================ --}}
<section class="cu-stats-section">
    <div class="cu-stats-bg"></div>
    <div class="container">
        <div class="cu-stats-wrapper" data-aos="zoom-in" data-aos-duration="1000">
            <div class="cu-stat-box">
                <div class="cu-stat-number" data-count="250">0</div>
                <div class="cu-stat-label">Proyectos Lanzados</div>
            </div>
            <div class="cu-stat-divider"></div>
            <div class="cu-stat-box">
                <div class="cu-stat-number" data-count="99">0</div><span class="cu-stat-suffix">%</span>
                <div class="cu-stat-label">Clientes Satisfechos</div>
            </div>
            <div class="cu-stat-divider"></div>
            <div class="cu-stat-box">
                <div class="cu-stat-number" data-count="15">0</div><span class="cu-stat-suffix">+</span>
                <div class="cu-stat-label">Premios de Diseño</div>
            </div>
            <div class="cu-stat-divider"></div>
            <div class="cu-stat-box">
                <div class="cu-stat-number" data-count="10">0</div><span class="cu-stat-suffix">Años</span>
                <div class="cu-stat-label">De Experiencia</div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     CLIENTES & ALIANZAS SECTION (CARRUSEL INFINITO DE LOGOS)
     ============================================ --}}
@if(isset($clients) && $clients->count() > 0)
<section class="cu-clients-section" id="clientes">
    <div class="container">
        <div class="cu-section-header text-center" data-aos="fade-up">
            <div class="cu-badge" style="margin: 0 auto 1rem auto; display: inline-flex;">
                <span class="cu-badge-dot"></span>
                <span class="cu-badge-text">Nuestros Aliados & Clientes</span>
                <span class="cu-badge-sparkle">🤝</span>
            </div>
            <h2 class="cu-section-title">
                Empresas que confían en <span class="cu-text-gradient">Nuestro Trabajo</span>
            </h2>
            <p class="cu-section-desc">Impulsamos el crecimiento y transformación digital de líderes en diversas industrias.</p>
        </div>
    </div>

    {{-- Contenedor del Carrusel Infinito (SOLO LOGOS FLOTANTES - SIN TARJETAS) --}}
    <div class="cu-clients-marquee-wrapper" data-aos="fade-up" data-aos-delay="100">
        <div class="cu-clients-marquee-track">
            {{-- Grupo 1 --}}
            @foreach($clients as $client)
                @if($client->logo_url)
                    <div class="cu-client-logo-pure" title="{{ $client->name }}">
                        <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
                    </div>
                @endif
            @endforeach

            {{-- Grupo 2 (Duplicado para lograr un loop infinito continuo y fluido) --}}
            @foreach($clients as $client)
                @if($client->logo_url)
                    <div class="cu-client-logo-pure" title="{{ $client->name }}" aria-hidden="true">
                        <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================
     INSIGHTS SECTION - Editorial Magazine Layout
     ============================================ --}}
<section class="cu-insights" id="blog">
    <div class="container">

        {{-- ── Header ── --}}
        <div class="cu-insights-header" data-aos="fade-up" data-aos-duration="800">
            <div class="cu-insights-eyebrow">
                <span class="cu-ins-eyebrow-dot"></span>
                <span>Blog &amp; Conocimiento</span>
            </div>
            <div class="cu-insights-headline">
                <h2 class="cu-section-title">Nuestros <span class="cu-text-gradient">Insights</span></h2>
                <p class="cu-insights-sub">Ideas, tendencias y noticias del mundo tecnológico que marcarán el futuro.</p>
            </div>
            <a href="{{ route('blog.index') }}" class="cu-ins-viewall">
                <span>Ver todos</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- ── Preparar colección: posts reales o demos ── --}}
        @php
            $avatarNums = [5, 12, 25];
            $unsplashIds = [
                'photo-1499951360447-b19be8fe80f5',
                'photo-1488590528505-98d2b5aba04b',
                'photo-1519389950473-47ba0277781c',
            ];

            // Si hay posts reales publicados, normalizarlos
            if (isset($posts) && $posts->count() > 0) {
                $insightItems = $posts->take(3)->values()->map(function ($post, $i) use ($avatarNums, $unsplashIds) {
                    return [
                        'title'     => $post->title,
                        'excerpt'   => $post->excerpt,          // accessor del modelo
                        'category'  => $post->category_label,   // accessor del modelo
                        'gradient'  => $post->category_gradient,// accessor del modelo
                        'author'    => $post->user->name ?? 'Admin',
                        'author_position' => $post->user->position ?? null,
                        'author_avatar' => $post->user->avatar ?? null,
                        'read_time' => $post->read_time . ' min',// accessor del modelo
                        'url'       => route('blog.show', $post->slug),
                        'img_src'   => $post->featured_image
                                        ? Storage::url($post->featured_image)
                                        : 'https://images.unsplash.com/' . $unsplashIds[$i % 3] . '?auto=format&fit=crop&q=80',
                        'avatar'    => $avatarNums[$i % 3],
                        'num'       => str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                    ];
                })->toArray();
            } else {
                // Demo posts hardcoded
                $insightItems = [
                    [
                        'title'     => 'El Futuro del Diseño Web con Inteligencia Artificial en 2026',
                        'excerpt'   => 'Descubre cómo la IA está revolucionando la forma en que construimos interfaces digitales y experiencias de usuario verdaderamente inmersivas.',
                        'category'  => 'Diseño & IA',
                        'gradient'  => 'linear-gradient(135deg,#ff006e 0%,#8338ec 100%)',
                        'author'    => 'Equipo UI/UX',
                        'read_time' => '6 min',
                        'url'       => '#',
                        'img_src'   => 'https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?auto=format&fit=crop&q=80&w=1200',
                        'avatar'    => 5,
                        'num'       => '01',
                    ],
                    [
                        'title'     => 'Performance Web: Carga en Menos de 1 Segundo',
                        'excerpt'   => 'Técnicas avanzadas para lograr tiempos de carga ultrarrápidos y una experiencia de usuario excepcional en todos tus proyectos.',
                        'category'  => 'Desarrollo',
                        'gradient'  => 'linear-gradient(135deg,#00b4d8 0%,#0077b6 100%)',
                        'author'    => 'Dev Team',
                        'read_time' => '4 min',
                        'url'       => '#',
                        'img_src'   => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?auto=format&fit=crop&q=80&w=700',
                        'avatar'    => 12,
                        'num'       => '02',
                    ],
                    [
                        'title'     => 'Branding Digital: Tu Marca en el Ecosistema 2026',
                        'excerpt'   => 'Construye una identidad sólida y memorable con estrategias probadas y casos de éxito que transformarán tu presencia digital.',
                        'category'  => 'Marketing',
                        'gradient'  => 'linear-gradient(135deg,#f59e0b 0%,#ef4444 100%)',
                        'author'    => 'Creative Team',
                        'read_time' => '5 min',
                        'url'       => '#',
                        'img_src'   => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=700',
                        'avatar'    => 25,
                        'num'       => '03',
                    ],
                ];
            }

            $featured  = $insightItems[0] ?? null;
            $compacts  = array_slice($insightItems, 1, 2);
        @endphp

        @if($featured)
        <div class="cu-ins-grid">

            {{-- ── FEATURED (tarjeta grande izquierda) ── --}}
            <article class="cu-ins-featured" data-aos="fade-right" data-aos-delay="100" data-aos-duration="900">
                <a href="{{ $featured['url'] }}" class="cu-ins-featured-link">

                    <div class="cu-ins-featured-visual">
                        <img src="{{ $featured['img_src'] }}" alt="{{ $featured['title'] }}" class="cu-ins-featured-img">
                        <div class="cu-ins-featured-veil"></div>
                        <span class="cu-ins-index">{{ $featured['num'] }}</span>
                        <span class="cu-ins-pill" style="background:{{ $featured['gradient'] }}">{{ $featured['category'] }}</span>
                    </div>

                    <div class="cu-ins-featured-body">
                        <div class="cu-ins-byline">
                            @if(isset($featured['author_avatar']) && $featured['author_avatar'])
                                <img src="{{ asset('storage/' . $featured['author_avatar']) }}" alt="{{ $featured['author'] }}" class="cu-ins-avatar">
                            @else
                                <div class="cu-ins-avatar cu-ins-avatar-placeholder">
                                    {{ strtoupper(substr($featured['author'], 0, 1)) }}
                                </div>
                            @endif
                            <div class="cu-ins-author-info">
                                <span class="cu-ins-author-name">
                                    @php
                                        $nameParts = explode(' ', $featured['author']);
                                        $shortName = $nameParts[0] . (isset($nameParts[1]) ? ' ' . $nameParts[1] : '');
                                    @endphp
                                    {{ $shortName }}
                                    @if(isset($featured['author_position']) && $featured['author_position'])
                                        | {{ $featured['author_position'] }}
                                    @endif
                                </span>
                            </div>
                            <span class="cu-ins-sep">·</span>
                            <span><i class="far fa-clock"></i> {{ $featured['read_time'] }} lectura</span>
                        </div>
                        <h3 class="cu-ins-featured-title">{{ $featured['title'] }}</h3>
                        <p class="cu-ins-featured-excerpt">{{ $featured['excerpt'] }}</p>
                        <div class="cu-ins-featured-cta">
                            <span>Leer artículo</span>
                            <div class="cu-ins-arrow-circle" style="background:{{ $featured['gradient'] }}">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>

                </a>
            </article>

            {{-- ── STACK (2 tarjetas compactas derecha) ── --}}
            <div class="cu-ins-stack">
                @foreach($compacts as $ci => $cp)
                <article class="cu-ins-compact" data-aos="fade-left" data-aos-delay="{{ ($ci + 1) * 180 }}" data-aos-duration="900">
                    <a href="{{ $cp['url'] }}" class="cu-ins-compact-link">

                        <div class="cu-ins-compact-visual">
                            <img src="{{ $cp['img_src'] }}" alt="{{ $cp['title'] }}" class="cu-ins-compact-img">
                            <div class="cu-ins-compact-veil"></div>
                            <span class="cu-ins-index cu-ins-index-sm">{{ $cp['num'] }}</span>
                        </div>

                        <div class="cu-ins-compact-body">
                            <span class="cu-ins-pill cu-ins-pill-sm" style="background:{{ $cp['gradient'] }}">{{ $cp['category'] }}</span>
                            <h4 class="cu-ins-compact-title">{{ $cp['title'] }}</h4>
                            <div class="cu-ins-compact-footer">
                                <span class="cu-ins-time"><i class="far fa-clock"></i> {{ $cp['read_time'] }}</span>
                                <div class="cu-ins-compact-arrow" style="background:{{ $cp['gradient'] }}">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>

                    </a>
                </article>
                @endforeach
            </div>

        </div>
        @endif

    </div>
</section>

{{-- ============================================
     ULTIMATE CTA
     ============================================ --}}
<section class="cu-final-cta">
    <div class="cu-cta-bg">
        <div class="cu-cta-orb"></div>
    </div>
    <div class="container">
        <div class="cu-cta-content" data-aos="zoom-in" data-aos-duration="1000">
            <h2>¿Tienes una idea en mente?</h2>
            <p>Hagamos que suceda. Nuestro equipo está listo para transformar tu visión en una realidad digital deslumbrante.</p>
            <a href="{{ route('contact.index') }}" class="cu-btn-massive">
                Comenzar Ahora <i class="fas fa-rocket"></i>
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function() {
    // Typing Effect for Hero - Palabras desde la base de datos
    const words = {!! json_encode($hero->rotating_words_array ?? ['Futuro', 'Éxito', 'Diseño', 'Negocio']) !!};
    let i = 0;
    const gradientText = document.querySelector('.cu-text-gradient');
    
    if (window.typingInterval) clearInterval(window.typingInterval);
    if(gradientText) {
        window.typingInterval = setInterval(() => {
            gradientText.style.opacity = 0;
            setTimeout(() => {
                i = (i + 1) % words.length;
                gradientText.textContent = words[i];
                gradientText.setAttribute('data-text', words[i]);
                gradientText.style.opacity = 1;
            }, 500);
        }, 3000);
    }

    // Number Counter Animation
    const counters = document.querySelectorAll('.cu-stat-number');
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    };

    // Intersection Observer for Stats
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const statsWrapper = document.querySelector('.cu-stats-wrapper');
    if(statsWrapper) {
        observer.observe(statsWrapper);
    }

    // 3D Tilt Effect on Mockup Card
    if (!window.homeTiltRegistered) {
        window.homeTiltRegistered = true;
        document.addEventListener('mousemove', (e) => {
            const mockupCard = document.querySelector('.cu-glass-mockup');
            if(mockupCard) {
                const xAxis = (window.innerWidth / 2 - e.pageX) / 50;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 50;
                mockupCard.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            }
        });
    }
})();
</script>
@endpush
