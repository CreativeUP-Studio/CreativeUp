@extends('layouts.app')

@section('title', 'Inicio')

@push('head')
    <link rel="preload" as="image" href="{{ asset('images/hero-1.jpg') }}">
    <link rel="preload" as="image" href="{{ asset('images/hero-2.jpg') }}">
@endpush

@section('content')

<section class="hero-section">

    <div class="hero-container">

        <div class="hero-text anim-hidden" data-anim="fade-right">

            <h1 class="hero-title">
                SOLUCIONES <br>
                <span class="gradient-text">DIGITALES</span> QUE <br>
                CRECEN <br>
                <span class="gradient-text">CONTIGO</span>
            </h1>

        </div>

        <div class="hero-images">
            <div class="hero-img-wrapper anim-hidden" data-anim="fade-up">
                <img src="{{ asset('images/hero-1.jpg') }}"
                     alt="CreativeUP Desarrollo"
                     width="320" height="400"
                     decoding="async"
                     fetchpriority="high">
            </div>

            <div class="hero-img-wrapper anim-hidden" data-anim="fade-up">
                <img src="{{ asset('images/hero-2.jpg') }}"
                     alt="CreativeUP Marketing"
                     width="320" height="400"
                     decoding="async"
                     fetchpriority="high">
            </div>

            <p class="hero-description anim-hidden" data-anim="flip-up">
                Potenciamos la experiencia digital de negocios en cualquier etapa
                y en cualquier parte del mundo.
            </p>
        </div>

    </div>

</section>

<section class="portfolio-section">
    @if($featuredProject)
    <div class="featured-project">
        <div class="featured-images">
            <div class="featured-img-main anim-scroll" data-anim="fade-up">
                <img src="{{ $featuredProject->thumbnail ? Storage::url($featuredProject->thumbnail) : ($featuredProject->images->first() ? Storage::url($featuredProject->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                     alt="{{ $featuredProject->title }}"
                     width="600" height="450"
                     loading="lazy"
                     decoding="async">
                <a href="{{ route('projects.show', $featuredProject->slug) }}" class="btn-ver"><span>Ver</span></a>
            </div>
            <div class="featured-img-side anim-scroll" data-anim="fade-left">
                <h3 class="featured-project-name">
                    {{ $featuredProject->title }}
                </h3>
                @if($featuredProject->images->count() > 0)
                <div class="featured-img-small">
                    <img src="{{ Storage::url($featuredProject->images->first()->image_path) }}"
                         alt="{{ $featuredProject->title }}"
                         width="400" height="250"
                         loading="lazy"
                         decoding="async">
                </div>
                @endif
            </div>
        </div>
        @if(!empty($featuredProject->type))
            <span class="featured-type-label anim-scroll" data-anim="fade-in">{{ $featuredProject->type }}</span>
        @endif
    </div>
    @endif
</section>

@if($projects->count() > 0)
<section class="projects-section">
    <div class="projects-grid">
        @foreach($projects as $index => $project)
            <div class="project-card {{ $index % 2 !== 0 ? 'project-card-offset' : '' }} anim-scroll" data-anim="fade-up">
                @if(!empty($project->type) && $index % 2 === 0)
                    <span class="project-card-label label-left">{{ $project->type }}</span>
                @endif
                @if($index % 2 !== 0)
                    <div class="project-card-info info-top-left">
                        <h3 class="project-card-name">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                        </h3>
                    </div>
                @endif
                <div class="project-card-images">
                    <div class="project-card-img-main">
                        <img src="{{ $project->thumbnail ? Storage::url($project->thumbnail) : ($project->images->first() ? Storage::url($project->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                             alt="{{ $project->title }}"
                             width="600" height="400"
                             loading="lazy"
                             decoding="async">
                        <a href="{{ route('projects.show', $project->slug) }}" class="btn-ver"><span>Ver</span></a>
                    </div>
                    @if($project->images->count() > 1)
                        <div class="project-card-img-circle {{ $index % 2 === 0 ? 'circle-bottom-left circle-pink' : 'circle-top-right circle-gray' }} anim-scroll" data-anim="{{ $index % 2 === 0 ? 'ball-roll-left' : 'ball-roll-right' }}">
                            <img src="{{ Storage::url($project->images[1]->image_path) }}"
                                 alt="{{ $project->title }}"
                                 width="200" height="200"
                                 loading="lazy"
                                 decoding="async">
                        </div>
                    @endif
                </div>
                @if($index % 2 === 0)
                    <div class="project-card-info info-bottom-right">
                        <h3 class="project-card-name">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                        </h3>
                    </div>
                @endif
                @if(!empty($project->type) && $index % 2 !== 0)
                    <span class="project-card-label label-right">{{ $project->type }}</span>
                @endif
            </div>
            @if($index % 2 !== 0 && !$loop->last)
                </div></section><section class="projects-section"><div class="projects-grid">
            @endif
        @endforeach
        <div class="w-full text-center mt-8">
            <a href="{{ route('projects.index') }}" class="btn-ver">Ver todos los proyectos</a>
        </div>
    </div>
</section>
@endif

{{-- Sección de transición / teaser servicios --}}
<section class="services-teaser">
    <div class="teaser-container">
        <p class="teaser-label anim-scroll" data-anim="fade-up">¿Qué hacemos?</p>
        <h2 class="teaser-title anim-scroll" data-anim="fade-up" style="animation-delay: 0.15s">
            Creamos experiencias<br>
            que <span class="teaser-highlight">conectan</span> y <span class="teaser-highlight">convierten</span>
        </h2>
        <p class="teaser-subtitle anim-scroll" data-anim="fade-up" style="animation-delay: 0.3s">
            Estrategia, diseño y tecnología al servicio de tu marca.
        </p>
        <div class="teaser-scroll-indicator anim-scroll" data-anim="fade-up" style="animation-delay: 0.5s">
            <span class="teaser-scroll-text">Descubre</span>
            <div class="teaser-scroll-line">
                <span class="teaser-scroll-dot"></span>
            </div>
        </div>
    </div>
</section>

<section class="services-section">

    <div class="services-container">

        {{-- SVG defs para clip-paths --}}
        <svg class="svg-defs" aria-hidden="true">
            <defs>
                {{-- Forma 0: curvas amplias asimétricas --}}
                <clipPath id="blob-0" clipPathUnits="objectBoundingBox">
                    <path d="M0.45,0.01 C0.7,-0.04,0.95,0.12,0.92,0.35 C0.89,0.52,0.98,0.62,0.88,0.82 C0.78,1.02,0.5,0.96,0.3,0.92 C0.1,0.88,0.0,0.7,0.04,0.5 C0.08,0.3,0.02,0.15,0.2,0.06 C0.32,0.0,0.45,0.01,0.45,0.01Z"/>
                </clipPath>
                {{-- Forma 1: ondulaciones suaves redondeadas --}}
                <clipPath id="blob-1" clipPathUnits="objectBoundingBox">
                    <path d="M0.52,0.0 C0.78,-0.02,0.98,0.15,0.96,0.38 C0.94,0.55,1.0,0.68,0.88,0.84 C0.74,1.02,0.48,0.98,0.28,0.94 C0.08,0.9,-0.04,0.72,0.02,0.52 C0.08,0.32,0.0,0.18,0.18,0.08 C0.3,0.02,0.52,0.0,0.52,0.0Z"/>
                </clipPath>
                {{-- Forma 2: orgánica alargada horizontal --}}
                <clipPath id="blob-2" clipPathUnits="objectBoundingBox">
                    <path d="M0.38,0.03 C0.62,-0.02,0.88,0.08,0.96,0.28 C1.04,0.48,0.94,0.7,0.82,0.86 C0.68,1.04,0.42,0.98,0.22,0.9 C0.02,0.82,-0.06,0.6,0.04,0.4 C0.14,0.2,0.18,0.08,0.38,0.03Z"/>
                </clipPath>
                {{-- Forma 3: fluida con entrantes pronunciados --}}
                <clipPath id="blob-3" clipPathUnits="objectBoundingBox">
                    <path d="M0.5,0.02 C0.75,0.0,0.94,0.1,0.98,0.32 C1.02,0.54,0.9,0.64,0.84,0.78 C0.76,0.96,0.56,1.02,0.35,0.96 C0.14,0.9,0.04,0.78,0.02,0.58 C0.0,0.38,0.08,0.22,0.22,0.12 C0.34,0.04,0.5,0.02,0.5,0.02Z"/>
                </clipPath>
            </defs>
        </svg>

        @foreach($services as $index => $service)
            @if($index % 2 === 0)
            {{-- Par de servicios --}}
            <div class="services-row">

                {{-- Card izquierda: imagen arriba, texto abajo --}}
                <div class="service-card card-left">
                    <div class="service-blob anim-scroll" data-anim="blob-reveal" style="clip-path: url(#blob-{{ $index }})">
                        <img src="{{ $service->image ? Storage::url($service->image) : asset('images/hero-1.jpg') }}"
                             alt="{{ $service->title }}"
                             loading="lazy"
                             decoding="async">
                    </div>
                    <div class="service-info anim-scroll" data-anim="slide-up-bounce" style="animation-delay: 0.3s">
                        <a href="{{ route('services.show', $service->slug) }}" class="service-name-link">
                            <h3 class="service-name">{{ strtoupper($service->title) }}</h3>
                            <span class="service-arrow">&longrightarrow;</span>
                        </a>
                        <div class="service-desc-wrapper desc-wrapper-left">
                            <span class="service-desc-line"></span>
                            <p class="service-desc">{{ $service->short_description ?? $service->description }}</p>
                        </div>
                    </div>
                </div>

                {{-- Línea separadora central --}}
                <div class="services-separator">
                    <svg viewBox="0 0 2 400" preserveAspectRatio="none" class="separator-line anim-scroll" data-anim="line-grow" style="transform-origin: top">
                        <line x1="1" y1="0" x2="1" y2="400" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                    <div class="separator-dot anim-scroll" data-anim="dot-glow" style="animation-delay: 0.4s"></div>
                </div>

                {{-- Card derecha: texto arriba, imagen abajo --}}
                @if(isset($services[$index + 1]))
                @php $nextService = $services[$index + 1]; @endphp
                <div class="service-card card-right">
                    <div class="service-info anim-scroll" data-anim="slide-down-bounce" style="animation-delay: 0.2s">
                        <div class="service-desc-wrapper">
                            <p class="service-desc">{{ $nextService->short_description ?? $nextService->description }}</p>
                            <span class="service-desc-line"></span>
                        </div>
                        <a href="{{ route('services.show', $nextService->slug) }}" class="service-name-link">
                            <h3 class="service-name">{{ strtoupper($nextService->title) }}</h3>
                            <span class="service-arrow">&longrightarrow;</span>
                        </a>
                    </div>
                    <div class="service-blob anim-scroll" data-anim="blob-reveal" style="clip-path: url(#blob-{{ $index + 1 }}); animation-delay: 0.15s">
                        <img src="{{ $nextService->image ? Storage::url($nextService->image) : asset('images/hero-2.jpg') }}"
                             alt="{{ $nextService->title }}"
                             loading="lazy"
                             decoding="async">
                    </div>
                </div>
                @endif

            </div>
            @endif
        @endforeach

    </div>

</section>

{{-- Sección Clientes --}}
<section class="clients-section">
    <div class="clients-container">
        <p class="clients-label anim-scroll" data-anim="fade-up">Nuestros clientes</p>
        <h2 class="clients-title anim-scroll" data-anim="fade-up" style="animation-delay: 0.1s">
            Historias que hemos tenido la suerte de <span class="clients-highlight">acompañar</span>
        </h2>

        <div class="clients-grid anim-scroll" data-anim="fade-up" style="animation-delay: 0.25s">
            <div class="client-card">
                <img src="{{ asset('images/menu/servicios.jpg') }}" alt="Aurora">
            </div>
            <div class="client-card">
                <img src="{{ asset('images/menu/proyectos.jpg') }}" alt="Vertex">
            </div>
            <div class="client-card">
                <img src="{{ asset('images/menu/inicio.jpg') }}" alt="Nimbus">
            </div>
            <div class="client-card">
                <img src="{{ asset('images/menu/contacto.jpg') }}" alt="Solara">
            </div>
            <div class="client-card">
                <img src="{{ asset('images/menu/blog.jpg') }}" alt="Prism">
            </div>
            <div class="client-card">
                <img src="{{ asset('images/menu/inicio.jpg') }}" alt="Zenith">
            </div>
        </div>
    </div>
</section>

{{-- Sección Blog --}}
<section class="blog-section">
    <div class="blog-container">

        {{-- Header del blog --}}
        <div class="blog-header">
            <div class="blog-header-left anim-scroll" data-anim="fade-up">
                <p class="blog-label">Blog</p>
                <h2 class="blog-title">
                    Ideas, inspiración y <span class="blog-highlight">conocimiento</span>
                </h2>
            </div>
            <div class="blog-header-right anim-scroll" data-anim="fade-up" style="animation-delay: 0.15s">
                <p class="blog-subtitle">Compartimos lo que aprendemos: tendencias, estrategias y casos reales para que tu marca crezca con propósito.</p>
                <a href="#" class="blog-view-all">
                    Ver todos los artículos <span class="blog-view-arrow">&rarr;</span>
                </a>
            </div>
        </div>

        {{-- Post destacado (el más reciente) --}}
        @if($posts->count() > 0)
        @php $featured = $posts->first(); @endphp
        <div class="blog-featured anim-scroll" data-anim="fade-up" style="animation-delay: 0.2s">
            <div class="blog-featured-image">
                <img src="{{ $featured->featured_image ? asset('storage/' . $featured->featured_image) : asset('images/hero-1.jpg') }}"
                     alt="{{ $featured->title }}"
                     loading="lazy">
                <span class="blog-category">{{ $featured->category_label }}</span>
            </div>
            <div class="blog-featured-content">
                <div class="blog-meta">
                    <span class="blog-date">{{ $featured->published_at->translatedFormat('d M, Y') }}</span>
                    <span class="blog-meta-dot">&bull;</span>
                    <span class="blog-read-time">{{ $featured->read_time }} min de lectura</span>
                </div>
                <h3 class="blog-featured-title">{{ $featured->title }}</h3>
                <p class="blog-featured-excerpt">{{ $featured->excerpt }}</p>
                <a href="#" class="blog-read-more">
                    Leer artículo
                    <span class="blog-read-arrow">&longrightarrow;</span>
                </a>
            </div>
        </div>
        @endif

        {{-- Grid de posts secundarios --}}
        @if($posts->count() > 1)
        <div class="blog-grid">
            @foreach($posts->skip(1) as $index => $post)
            <article class="blog-card anim-scroll" data-anim="fade-up" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                <div class="blog-card-image">
                    <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/hero-2.jpg') }}"
                         alt="{{ $post->title }}"
                         loading="lazy">
                    <span class="blog-category">{{ $post->category_label }}</span>
                </div>
                <div class="blog-card-body">
                    <div class="blog-meta">
                        <span class="blog-date">{{ $post->published_at->translatedFormat('d M, Y') }}</span>
                        <span class="blog-meta-dot">&bull;</span>
                        <span class="blog-read-time">{{ $post->read_time }} min</span>
                    </div>
                    <h4 class="blog-card-title">{{ $post->title }}</h4>
                    <p class="blog-card-excerpt">{{ $post->excerpt }}</p>
                </div>
                <a href="#" class="blog-card-link" aria-label="Leer: {{ $post->title }}"></a>
            </article>
            @endforeach
        </div>
        @endif

        {{-- Newsletter mini --}}
        <div class="blog-newsletter anim-scroll" data-anim="fade-up" style="animation-delay: 0.2s">
            <div class="newsletter-content">
                <h3 class="newsletter-title">¿Quieres recibir nuestras ideas?</h3>
                <p class="newsletter-desc">Suscríbete y recibe artículos, recursos y tips directamente en tu bandeja.</p>
            </div>
            <form class="newsletter-form" action="#" method="POST">
                @csrf
                <div class="newsletter-input-wrapper">
                    <input type="email" class="newsletter-input" placeholder="tu@email.com" required>
                    <button type="submit" class="newsletter-btn">Suscribirme</button>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection