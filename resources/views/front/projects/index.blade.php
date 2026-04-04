@extends('layouts.app')

@section('title', 'Proyectos | Portafolio CreativeUp')
@section('meta_description', 'Explora nuestro portafolio de proyectos creativos: branding, diseño web, marketing digital y más. Casos de éxito que hablan por sí solos.')
@section('body-class', 'page-projects-index')

@push('head')
<meta property="og:title" content="Proyectos | Portafolio CreativeUp">
<meta property="og:description" content="Descubre nuestros proyectos creativos y casos de éxito. Branding, diseño web, marketing digital y soluciones innovadoras.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<link rel="canonical" href="{{ route('projects.index') }}">
@endpush

@section('content')

{{-- ═══ HERO PROFESIONAL ═══ --}}
<section class="pidx-hero" aria-labelledby="pidx-hero-title">
    {{-- Elementos decorativos --}}
    <div class="pidx-hero-decor" aria-hidden="true">
        <div class="pidx-hero-line pidx-hero-line--1"></div>
        <div class="pidx-hero-line pidx-hero-line--2"></div>
        <div class="pidx-hero-orb pidx-hero-orb--1"></div>
        <div class="pidx-hero-orb pidx-hero-orb--2"></div>
    </div>

    <div class="pidx-hero-container">
        {{-- Lado izquierdo: Contenido principal --}}
        <div class="pidx-hero-main">
            <div class="pidx-hero-badge anim-hidden" data-anim="fade-up">
                <span class="pidx-hero-badge-icon" aria-hidden="true">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <span class="pidx-hero-badge-text">Portafolio</span>
                <span class="pidx-hero-badge-line" aria-hidden="true"></span>
            </div>

            <h1 id="pidx-hero-title" class="pidx-hero-title anim-hidden" data-anim="fade-up">
                <span class="pidx-hero-title-line">Proyectos que</span>
                <span class="pidx-hero-title-line">
                    <span class="pidx-hero-gradient">hablan por sí solos</span>
                </span>
            </h1>

            <p class="pidx-hero-sub anim-hidden" data-anim="fade-up">
                Cada proyecto es una historia de estrategia, creatividad
                y resultados reales para nuestros clientes.
            </p>

            {{-- Stats mini --}}
            <div class="pidx-hero-stats anim-hidden" data-anim="fade-up" role="list" aria-label="Estadísticas del portafolio">
                <div class="pidx-hero-stat" role="listitem">
                    <span class="pidx-hero-stat-num" data-count="{{ $projects->total() }}">{{ $projects->total() }}+</span>
                    <span class="pidx-hero-stat-label">Proyectos</span>
                </div>
                <div class="pidx-hero-stat-sep" aria-hidden="true"></div>
                <div class="pidx-hero-stat" role="listitem">
                    <span class="pidx-hero-stat-num">{{ $types->count() }}</span>
                    <span class="pidx-hero-stat-label">Categorías</span>
                </div>
                <div class="pidx-hero-stat-sep" aria-hidden="true"></div>
                <div class="pidx-hero-stat" role="listitem">
                    <span class="pidx-hero-stat-num">100%</span>
                    <span class="pidx-hero-stat-label">Dedicación</span>
                </div>
            </div>
        </div>

        {{-- Lado derecho: Visual decorativo --}}
        <div class="pidx-hero-visual anim-hidden" data-anim="fade-left" aria-hidden="true">
            <div class="pidx-hero-visual-grid">
                <div class="pidx-hero-visual-item pidx-hero-visual-item--1">
                    <span>01</span>
                </div>
                <div class="pidx-hero-visual-item pidx-hero-visual-item--2">
                    <i class="fa-solid fa-code"></i>
                </div>
                <div class="pidx-hero-visual-item pidx-hero-visual-item--3">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <div class="pidx-hero-visual-item pidx-hero-visual-item--4">
                    <span>✦</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros tipo tabs --}}
    @if($types->count() > 0)
    <nav class="pidx-filters anim-hidden" data-anim="fade-up" aria-label="Filtrar proyectos por categoría">
        <a href="{{ route('projects.index') }}"
           class="pidx-filter {{ !request('type') ? 'is-active' : '' }}"
           {{ !request('type') ? 'aria-current=page' : '' }}>
            <span>Todos</span>
        </a>
        @foreach($types as $type)
            <a href="{{ route('projects.index', ['type' => $type]) }}"
               class="pidx-filter {{ request('type') === $type ? 'is-active' : '' }}"
               {{ request('type') === $type ? 'aria-current=page' : '' }}>
                <span>{{ $type }}</span>
            </a>
        @endforeach
    </nav>
    @endif
</section>

{{-- ═══ GRID DE PROYECTOS ═══ --}}
<section class="pidx-section" aria-labelledby="pidx-projects-heading">
    <h2 id="pidx-projects-heading" class="sr-only">Lista de proyectos</h2>
    
    @if($projects->count() > 0)

        <div class="pidx-list" role="list">
        @foreach($projects as $index => $project)
            @php
                $mainImage = $project->thumbnail
                    ? Storage::url($project->thumbnail)
                    : ($project->images->first()
                        ? Storage::url($project->images->first()->image_path)
                        : asset('images/hero-1.jpg'));
                $projectNum = str_pad($projects->firstItem() + $index, 2, '0', STR_PAD_LEFT);
            @endphp

            <article class="pidx-card anim-scroll" data-anim="fade-up" role="listitem">
                {{-- Número grande decorativo --}}
                <div class="pidx-card-number" aria-hidden="true">
                    <span>{{ $projectNum }}</span>
                </div>

                <a href="{{ route('projects.show', $project->slug) }}" 
                   class="pidx-card-link"
                   aria-label="Ver proyecto: {{ $project->title }}">
                    {{-- Imagen principal --}}
                    <div class="pidx-card-image">
                        <img src="{{ $mainImage }}"
                             alt="{{ $project->title }}"
                             loading="lazy"
                             decoding="async"
                             width="600"
                             height="375">
                        <div class="pidx-card-image-overlay" aria-hidden="true">
                            <span class="pidx-card-view">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                <span>Ver proyecto</span>
                            </span>
                        </div>
                        @if(!empty($project->type))
                        <span class="pidx-card-tag">{{ $project->type }}</span>
                        @endif
                    </div>

                    {{-- Contenido --}}
                    <div class="pidx-card-content">
                        {{-- Header con año --}}
                        <div class="pidx-card-header">
                            @if(!empty($project->year))
                            <span class="pidx-card-year">
                                <time datetime="{{ $project->year }}">{{ $project->year }}</time>
                            </span>
                            @endif
                            @if(!empty($project->client))
                            <span class="pidx-card-client">
                                <i class="fa-regular fa-building" aria-hidden="true"></i>
                                {{ $project->client }}
                            </span>
                            @endif
                        </div>

                        {{-- Título --}}
                        <h3 class="pidx-card-title">{{ $project->title }}</h3>

                        {{-- Descripción --}}
                        <p class="pidx-card-desc">{{ Str::limit($project->description, 140) }}</p>

                        {{-- Tecnologías como badges --}}
                        @if(!empty($project->technologies) && is_array($project->technologies))
                        <div class="pidx-card-techs" aria-label="Tecnologías utilizadas">
                            @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                <span class="pidx-card-tech">{{ $tech }}</span>
                            @endforeach
                            @if(count($project->technologies) > 4)
                                <span class="pidx-card-tech pidx-card-tech--more">+{{ count($project->technologies) - 4 }}</span>
                            @endif
                        </div>
                        @endif

                        {{-- Footer con CTA --}}
                        <div class="pidx-card-footer">
                            <span class="pidx-card-cta">
                                <span>Explorar proyecto</span>
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </article>
        @endforeach
        </div>

        {{-- Paginación --}}
        @if($projects->hasPages())
        <nav class="pidx-pagination" aria-label="Paginación de proyectos">
            {{ $projects->appends(request()->query())->links() }}
        </nav>
        @endif

    @else
        <div class="pidx-empty" role="status">
            <div class="pidx-empty-icon" aria-hidden="true">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </div>
            <h3>Pr&oacute;ximamente</h3>
            <p>Estamos preparando nuestros mejores proyectos para compartirlos contigo.</p>
        </div>
    @endif
</section>

{{-- ═══ CTA ═══ --}}
<section class="pidx-cta anim-scroll" data-anim="fade-up" aria-labelledby="pidx-cta-title">
    <div class="pidx-cta-inner">
        <h2 id="pidx-cta-title" class="pidx-cta-title">
            Hagamos algo <span class="pidx-hero-gradient">increíble</span> juntos
        </h2>
        <p class="pidx-cta-text">Platícanos tu idea y creamos un proyecto a la medida de tu marca.</p>
        <a href="{{ route('contact.index') }}" class="pidx-cta-btn">
            <span>Iniciar proyecto</span>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>

@endsection
