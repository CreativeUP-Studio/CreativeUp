@extends('layouts.app')

@use('Illuminate\Support\Str')

@section('title', 'Inicio - Soluciones Digitales que Crecen Contigo')

@push('head')
    {{-- Preload de imágenes críticas --}}
    <link rel="preload" as="image" href="{{ asset('images/hero-1.jpg') }}">
    <link rel="preload" as="image" href="{{ asset('images/hero-2.jpg') }}">
    
    {{-- Meta tags para SEO --}}
    <meta name="description" content="CreativeUp - Potenciamos la experiencia digital de negocios con soluciones profesionales en desarrollo web, diseño y marketing digital.">
    <meta name="keywords" content="desarrollo web, diseño web, marketing digital, branding, seo, desarrollo de software">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="CreativeUp - Soluciones Digitales que Crecen Contigo">
    <meta property="og:description" content="Potenciamos la experiencia digital de negocios en cualquier etapa y en cualquier parte del mundo.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    
    {{-- Schema.org markup --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "CreativeUp",
        "description": "Soluciones digitales profesionales",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}"
    }
    </script>
@endpush

@section('content')

{{-- Hero Section - Diseño Moderno --}}
<section class="home-hero">
    <div class="container-custom">
        <div class="hero-grid">
            <div class="hero-left">
                <div class="hero-badge anim-hidden" data-anim="fade-right">
                    <span>✦</span> Agencia Digital Creativa
                </div>
                
                <h1 class="hero-heading anim-hidden" data-anim="fade-right" style="animation-delay: 0.1s">
                    Transformamos
                    <span class="text-gradient">Ideas</span>
                    en Experiencias
                    <span class="text-gradient">Digitales</span>
                </h1>
                
                <p class="hero-lead anim-hidden" data-anim="fade-right" style="animation-delay: 0.2s">
                    Potenciamos negocios con soluciones digitales innovadoras. 
                    Desde el diseño hasta el desarrollo, creamos experiencias que conectan y convierten.
                </p>
                
                <div class="hero-actions anim-hidden" data-anim="fade-right" style="animation-delay: 0.3s">
                    <a href="{{ route('contact.index') }}" class="btn btn-primary">
                        Iniciar Proyecto
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline">
                        Ver Portafolio
                    </a>
                </div>
                
                <div class="hero-metrics anim-hidden" data-anim="fade-right" style="animation-delay: 0.4s">
                    <div class="metric-item">
                        <div class="metric-value">150+</div>
                        <div class="metric-label">Proyectos</div>
                    </div>
                    <div class="metric-divider"></div>
                    <div class="metric-item">
                        <div class="metric-value">95%</div>
                        <div class="metric-label">Satisfacción</div>
                    </div>
                    <div class="metric-divider"></div>
                    <div class="metric-item">
                        <div class="metric-value">10+</div>
                        <div class="metric-label">Años</div>
                    </div>
                </div>
            </div>
            
            <div class="hero-right">
                <div class="hero-visual anim-hidden" data-anim="fade-up" style="animation-delay: 0.2s">
                    <div class="visual-card visual-primary">
                        <img src="{{ asset('images/hero-1.jpg') }}" alt="CreativeUp Desarrollo Web" loading="eager">
                    </div>
                    <div class="visual-card visual-secondary">
                        <img src="{{ asset('images/hero-2.jpg') }}" alt="CreativeUp Marketing Digital" loading="eager">
                    </div>
                    <div class="visual-decoration"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Project Section --}}
@if($featuredProject)
<section class="section-featured">
    <div class="container-custom">
        <div class="section-header-center anim-scroll" data-anim="fade-up">
            <span class="section-label">Proyecto Destacado</span>
            <h2 class="section-heading">Nuestro Trabajo Habla por Sí Solo</h2>
        </div>
        
        <div class="featured-wrapper anim-scroll" data-anim="fade-up" style="animation-delay: 0.1s">
            <div class="featured-main">
                <div class="featured-image">
                    <img src="{{ $featuredProject->thumbnail ? Storage::url($featuredProject->thumbnail) : ($featuredProject->images->first() ? Storage::url($featuredProject->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                         alt="{{ $featuredProject->title }}" loading="lazy">
                    <div class="featured-overlay">
                        <a href="{{ route('projects.show', $featuredProject->slug) }}" class="btn btn-white">
                            Ver Proyecto
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="featured-info">
                @if(!empty($featuredProject->type))
                    <span class="project-badge">{{ $featuredProject->type }}</span>
                @endif
                <h3 class="featured-title">{{ $featuredProject->title }}</h3>
                @if($featuredProject->description)
                    <p class="featured-desc">{{ Str::limit($featuredProject->description, 180) }}</p>
                @endif
                @if($featuredProject->images->count() > 0)
                    <div class="featured-thumb">
                        <img src="{{ Storage::url($featuredProject->images->first()->image_path) }}"
                             alt="{{ $featuredProject->title }}" loading="lazy">
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Projects Grid --}}
@if($projects->count() > 0)
<section class="section-projects">
    <div class="container-custom">
        <div class="section-header-center anim-scroll" data-anim="fade-up">
            <span class="section-label">Portafolio</span>
            <h2 class="section-heading">Proyectos que <span class="text-gradient">Inspiran</span></h2>
            <p class="section-desc">Cada proyecto es una historia de éxito, creatividad y resultados medibles</p>
        </div>
        
        <div class="projects-masonry">
            @foreach($projects as $index => $project)
                <article class="project-item anim-scroll" data-anim="fade-up" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="project-thumbnail">
                        <img src="{{ $project->thumbnail ? Storage::url($project->thumbnail) : ($project->images->first() ? Storage::url($project->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                             alt="{{ $project->title }}" loading="lazy">
                        <div class="project-hover">
                            <a href="{{ route('projects.show', $project->slug) }}" class="project-link">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                        @if(!empty($project->type))
                            <span class="project-tag">{{ $project->type }}</span>
                        @endif
                    </div>
                    <div class="project-details">
                        <h3 class="project-name">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                        </h3>
                        @if($project->description)
                            <p class="project-summary">{{ Str::limit($project->description, 90) }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="section-cta anim-scroll" data-anim="fade-up">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-large">
                Ver Todos los Proyectos
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@elseif(!$featuredProject)
    @include('partials.empty-state', [
        'icon' => 'fas fa-folder-open',
        'title' => 'Próximamente',
        'message' => 'Estamos trabajando en nuestros proyectos. ¡Vuelve pronto!',
        'class' => 'section-projects'
    ])
@endif

{{-- Services Section --}}
<section class="section-services">
    <div class="container-custom">
        <div class="section-header-center anim-scroll" data-anim="fade-up">
            <span class="section-label">Servicios</span>
            <h2 class="section-heading">Soluciones <span class="text-gradient">360°</span> para tu Negocio</h2>
            <p class="section-desc">Desde la estrategia hasta la ejecución, te acompañamos en cada paso</p>
        </div>
        
        @if($services->count() > 0)
            <div class="services-grid">
                @foreach($services as $index => $service)
                <article class="service-box anim-scroll" data-anim="fade-up" style="animation-delay: {{ $index * 0.1 }}s">
                    @if($service->image)
                    <div class="service-media">
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" loading="lazy">
                        <div class="service-gradient"></div>
                    </div>
                    @endif
                    
                    <div class="service-body">
                        <div class="service-icon-box">
                            @if($service->icon)
                                <i class="{{ $service->icon }}"></i>
                            @else
                                <span class="service-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </div>
                        
                        <h3 class="service-heading">
                            <a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a>
                        </h3>
                        
                        <p class="service-text">
                            {{ $service->short_description ?? Str::limit($service->description ?? '', 120) }}
                        </p>
                        
                        <a href="{{ route('services.show', $service->slug) }}" class="service-more">
                            Descubrir más
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3 8h10m0 0l-5-5m5 5l-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        @else
            @include('partials.empty-state', [
                'icon' => 'fas fa-cogs',
                'title' => 'Próximamente',
                'message' => 'Estamos preparando nuestros servicios para ti.',
                'class' => 'py-12'
            ])
        @endif
    </div>
</section>

{{-- Clients Section --}}
<section class="section-clients">
    <div class="container-custom">
        <div class="section-header-center anim-scroll" data-anim="fade-up">
            <span class="section-label">Clientes</span>
            <h2 class="section-heading">Marcas que Confían en Nosotros</h2>
        </div>

        <div class="clients-showcase anim-scroll" data-anim="fade-up" style="animation-delay: 0.1s">
            <div class="client-logo">
                <img src="{{ asset('images/menu/servicios.jpg') }}" alt="Cliente" loading="lazy">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/menu/proyectos.jpg') }}" alt="Cliente" loading="lazy">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/menu/inicio.jpg') }}" alt="Cliente" loading="lazy">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/menu/contacto.jpg') }}" alt="Cliente" loading="lazy">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/menu/blog.jpg') }}" alt="Cliente" loading="lazy">
            </div>
            <div class="client-logo">
                <img src="{{ asset('images/menu/inicio.jpg') }}" alt="Cliente" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- Blog Section --}}
@if($posts->count() > 0)
<section class="section-blog">
    <div class="container-custom">
        <div class="section-header-split anim-scroll" data-anim="fade-up">
            <div>
                <span class="section-label">Blog</span>
                <h2 class="section-heading">Inspiración y <span class="text-gradient">Conocimiento</span></h2>
                <p class="section-desc">Tendencias, consejos y casos de éxito para hacer crecer tu negocio</p>
            </div>
            <div class="section-action">
                <a href="{{ route('blog.index') }}" class="btn btn-outline">
                    Ver Todo
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="blog-cards">
            @foreach($posts as $index => $post)
            <article class="blog-item anim-scroll" data-anim="fade-up" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="blog-cover">
                    <img src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('images/hero-2.jpg') }}"
                         alt="{{ $post->title }}" loading="lazy">
                    @if($post->category_label)
                        <span class="blog-category">{{ $post->category_label }}</span>
                    @endif
                </div>
                
                <div class="blog-content">
                    <div class="blog-info">
                        <time datetime="{{ $post->published_at?->toDateString() }}" class="blog-date">
                            {{ $post->published_at?->translatedFormat('d M, Y') }}
                        </time>
                        <span class="blog-dot">•</span>
                        <span class="blog-time">{{ $post->read_time }} min</span>
                    </div>
                    
                    <h3 class="blog-heading">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    
                    @if($post->excerpt)
                        <p class="blog-excerpt">{{ $post->excerpt }}</p>
                    @endif
                    
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-link">
                        Leer más
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8h10m0 0l-5-5m5 5l-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Newsletter --}}
        <div class="newsletter-box anim-scroll" data-anim="fade-up">
            <div class="newsletter-visual">
                <div class="newsletter-icon-wrap">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="24" fill="url(#paint0_linear)"/>
                        <path d="M14 18l10 8 10-8M14 30h20V18H14v12z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                            <linearGradient id="paint0_linear" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#5e17eb"/>
                                <stop offset="1" stop-color="#e870c2"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div>
                    <h3 class="newsletter-title">Suscríbete al Newsletter</h3>
                    <p class="newsletter-subtitle">Recibe contenido exclusivo cada semana</p>
                </div>
            </div>
            
            <form class="newsletter-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service" value="newsletter">
                <div class="newsletter-field">
                    <input type="email" 
                           id="newsletter-email"
                           name="email" 
                           class="newsletter-input" 
                           placeholder="tu@email.com" 
                           required
                           autocomplete="email">
                    <button type="submit" class="btn btn-primary">
                        Suscribirme
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endif

@endsection