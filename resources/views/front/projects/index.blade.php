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
    <nav class="pidx-filters anim-hidden" data-anim="fade-up" data-ajax-filter data-ajax-nav aria-label="Filtrar proyectos por categoría">
        <button type="button"
           class="pidx-filter {{ !request('type') ? 'is-active' : '' }}"
           data-filter-button
           data-filter-key="type"
           data-filter-value=""
           {{ !request('type') ? 'aria-current=page' : '' }}>
            <span>Todos</span>
        </button>
        @foreach($types as $type)
            <button type="button"
               class="pidx-filter {{ request('type') === $type ? 'is-active' : '' }}"
               data-filter-button
               data-filter-key="type"
               data-filter-value="{{ $type }}"
               {{ request('type') === $type ? 'aria-current=page' : '' }}>
                <span>{{ $type }}</span>
            </button>
        @endforeach
    </nav>
    @endif
</section>

{{-- ═══ GRID DE PROYECTOS ═══ --}}
<section class="pidx-section" aria-labelledby="pidx-projects-heading">
    <h2 id="pidx-projects-heading" class="sr-only">Lista de proyectos</h2>
    
    <div data-ajax-results>
        @include('front.projects._projects-grid', ['animate' => true])
    </div>

    {{-- Paginación --}}
    <div data-ajax-pagination>
        @if($projects->hasPages())
        <nav class="pidx-pagination" aria-label="Paginación de proyectos">
            {{ $projects->appends(request()->query())->links() }}
        </nav>
        @endif
    </div>
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
