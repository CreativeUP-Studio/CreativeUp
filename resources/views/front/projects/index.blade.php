@extends('layouts.app')

@section('title', 'Proyectos')
@section('body-class', 'page-projects-index')

@section('content')

{{-- ═══ HERO PROFESIONAL ═══ --}}
<section class="pidx-hero">
    {{-- Elementos decorativos --}}
    <div class="pidx-hero-decor">
        <div class="pidx-hero-line pidx-hero-line--1"></div>
        <div class="pidx-hero-line pidx-hero-line--2"></div>
        <div class="pidx-hero-orb pidx-hero-orb--1"></div>
        <div class="pidx-hero-orb pidx-hero-orb--2"></div>
    </div>

    <div class="pidx-hero-container">
        {{-- Lado izquierdo: Contenido principal --}}
        <div class="pidx-hero-main">
            <div class="pidx-hero-badge anim-hidden" data-anim="fade-up">
                <span class="pidx-hero-badge-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <span class="pidx-hero-badge-text">Portafolio</span>
                <span class="pidx-hero-badge-line"></span>
            </div>

            <h1 class="pidx-hero-title anim-hidden" data-anim="fade-up">
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
            <div class="pidx-hero-stats anim-hidden" data-anim="fade-up">
                <div class="pidx-hero-stat">
                    <span class="pidx-hero-stat-num">{{ $projects->total() }}+</span>
                    <span class="pidx-hero-stat-label">Proyectos</span>
                </div>
                <div class="pidx-hero-stat-sep"></div>
                <div class="pidx-hero-stat">
                    <span class="pidx-hero-stat-num">{{ $types->count() }}</span>
                    <span class="pidx-hero-stat-label">Categorías</span>
                </div>
                <div class="pidx-hero-stat-sep"></div>
                <div class="pidx-hero-stat">
                    <span class="pidx-hero-stat-num">100%</span>
                    <span class="pidx-hero-stat-label">Dedicación</span>
                </div>
            </div>
        </div>

        {{-- Lado derecho: Visual decorativo --}}
        <div class="pidx-hero-visual anim-hidden" data-anim="fade-left">
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
    <nav class="pidx-filters anim-hidden" data-anim="fade-up">
        <a href="{{ route('projects.index') }}"
           class="pidx-filter {{ !request('type') ? 'is-active' : '' }}">
            <span>Todos</span>
        </a>
        @foreach($types as $type)
            <a href="{{ route('projects.index', ['type' => $type]) }}"
               class="pidx-filter {{ request('type') === $type ? 'is-active' : '' }}">
                <span>{{ $type }}</span>
            </a>
        @endforeach
    </nav>
    @endif
</section>

{{-- ═══ GRID DE PROYECTOS ═══ --}}
<section class="pidx-section">
    @if($projects->count() > 0)

        <div class="pidx-list">
        @foreach($projects as $index => $project)
            @php
                $mainImage = $project->thumbnail
                    ? Storage::url($project->thumbnail)
                    : ($project->images->first()
                        ? Storage::url($project->images->first()->image_path)
                        : asset('images/hero-1.jpg'));
                $projectNum = str_pad($projects->firstItem() + $index, 2, '0', STR_PAD_LEFT);
            @endphp

            <article class="pidx-card anim-scroll" data-anim="fade-up">
                {{-- Número grande decorativo --}}
                <div class="pidx-card-number">
                    <span>{{ $projectNum }}</span>
                </div>

                <a href="{{ route('projects.show', $project->slug) }}" class="pidx-card-link">
                    {{-- Imagen principal --}}
                    <div class="pidx-card-image">
                        <img src="{{ $mainImage }}"
                             alt="{{ $project->title }}"
                             loading="lazy"
                             decoding="async">
                        <div class="pidx-card-image-overlay">
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
                            <span class="pidx-card-year">{{ $project->year }}</span>
                            @endif
                            @if(!empty($project->client))
                            <span class="pidx-card-client">
                                <i class="fa-regular fa-building"></i>
                                {{ $project->client }}
                            </span>
                            @endif
                        </div>

                        {{-- Título --}}
                        <h2 class="pidx-card-title">{{ $project->title }}</h2>

                        {{-- Descripción --}}
                        <p class="pidx-card-desc">{{ Str::limit($project->description, 140) }}</p>

                        {{-- Tecnologías como badges --}}
                        @if(!empty($project->technologies) && is_array($project->technologies))
                        <div class="pidx-card-techs">
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
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </article>
        @endforeach
        </div>

        {{-- Paginación --}}
        @if($projects->hasPages())
        <div class="pidx-pagination">
            {{ $projects->appends(request()->query())->links() }}
        </div>
        @endif

    @else
        <div class="pidx-empty">
            <div class="pidx-empty-icon">
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
<section class="pidx-cta anim-scroll" data-anim="fade-up">
    <div class="pidx-cta-inner">
        <h2 class="pidx-cta-title">
            Hagamos algo <span class="pidx-hero-gradient">increíble</span> juntos
        </h2>
        <p class="pidx-cta-text">Platícanos tu idea y creamos un proyecto a la medida de tu marca.</p>
        <a href="{{ route('contact.index') }}" class="pidx-cta-btn">
            <span>Iniciar proyecto</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>

@endsection
