@extends('layouts.app')

@section('title', 'Proyectos')
@section('body-class', 'page-projects-index')

@section('content')

{{-- ═══ HERO ═══ --}}
<section class="pidx-hero">
    <div class="pidx-hero-shapes">
        <div class="pidx-hero-shape pidx-hero-shape--1"></div>
        <div class="pidx-hero-shape pidx-hero-shape--2"></div>
    </div>
    <div class="pidx-hero-content">
        <div class="pidx-hero-badge anim-hidden" data-anim="fade-up">
            <span class="pidx-hero-badge-dot"></span>
            Nuestro portafolio
        </div>
        <h1 class="pidx-hero-title anim-hidden" data-anim="fade-up">
            Proyectos que
            <span class="pidx-hero-gradient">hablan por sí solos</span>
        </h1>
        <p class="pidx-hero-sub anim-hidden" data-anim="fade-up">
            Cada proyecto es una historia de estrategia, creatividad y resultados reales para nuestros clientes.
        </p>
    </div>

    {{-- Filtros integrados --}}
    @if($types->count() > 0)
    <div class="pidx-hero-filters anim-hidden" data-anim="fade-up">
        <a href="{{ route('projects.index') }}"
           class="pidx-filter {{ !request('type') ? 'is-active' : '' }}">
            Todos
        </a>
        @foreach($types as $type)
            <a href="{{ route('projects.index', ['type' => $type]) }}"
               class="pidx-filter {{ request('type') === $type ? 'is-active' : '' }}">
                {{ $type }}
            </a>
        @endforeach
    </div>
    @endif
</section>

{{-- ═══ GRID DE PROYECTOS ═══ --}}
<section class="pidx-grid">
    @if($projects->count() > 0)

        <div class="pidx-projects-wrap">
        @foreach($projects as $index => $project)
            @php
                $allImages = collect();
                if ($project->thumbnail) {
                    $allImages->push(Storage::url($project->thumbnail));
                }
                foreach ($project->images as $img) {
                    if ($allImages->count() < 4) {
                        $allImages->push(Storage::url($img->image_path));
                    }
                }
                if ($allImages->isEmpty()) {
                    $allImages->push(asset('images/hero-1.jpg'));
                }
                $imgCount = $allImages->count();
                $reversed = $index % 2 !== 0;
            @endphp

            <a href="{{ route('projects.show', $project->slug) }}"
               class="pidx-project {{ $reversed ? 'pidx-project--rev' : '' }} anim-scroll"
               data-anim="fade-up">

                {{-- Mosaico de imágenes --}}
                <div class="pidx-project-mosaic pidx-mosaic--{{ $imgCount }}">
                    @foreach($allImages as $i => $imgUrl)
                        <div class="pidx-mosaic-cell pidx-mosaic-cell--{{ $i }}">
                            <img src="{{ $imgUrl }}" alt="{{ $project->title }}" loading="lazy" decoding="async">
                        </div>
                    @endforeach
                    <div class="pidx-mosaic-overlay">
                        <span class="pidx-mosaic-view">
                            <i class="fa-solid fa-eye"></i>
                            Ver proyecto
                        </span>
                    </div>
                </div>

                {{-- Info del proyecto --}}
                <div class="pidx-project-info">
                    <div class="pidx-project-num">
                        {{ str_pad($projects->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="pidx-project-meta">
                        @if(!empty($project->type))
                            <span class="pidx-project-type">
                                <i class="fa-solid fa-folder"></i>
                                {{ $project->type }}
                            </span>
                        @endif
                        @if(!empty($project->year))
                            <span class="pidx-project-year">{{ $project->year }}</span>
                        @endif
                    </div>

                    <h2 class="pidx-project-title">{{ $project->title }}</h2>
                    <p class="pidx-project-desc">{{ Str::limit($project->description, 140) }}</p>

                    {{-- Tecnologías --}}
                    @if(!empty($project->technologies) && is_array($project->technologies))
                    <div class="pidx-project-techs">
                        @foreach(array_slice($project->technologies, 0, 4) as $tech)
                            <span class="pidx-project-tech">{{ $tech }}</span>
                        @endforeach
                        @if(count($project->technologies) > 4)
                            <span class="pidx-project-tech pidx-project-tech--more">+{{ count($project->technologies) - 4 }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="pidx-project-cta-row">
                        @if(!empty($project->client))
                            <span class="pidx-project-client">
                                <i class="fa-solid fa-building"></i>
                                {{ $project->client }}
                            </span>
                        @endif
                        <span class="pidx-project-arrow">
                            <span>Ver proyecto</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </div>

                <div class="pidx-project-glow"></div>
            </a>
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
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h3>Próximamente</h3>
            <p>Estamos preparando nuestros mejores proyectos para compartirlos contigo.</p>
        </div>
    @endif
</section>

{{-- ═══ CTA FINAL ═══ --}}
<section class="pidx-cta anim-scroll" data-anim="fade-up">
    <div class="pidx-cta-shapes">
        <div class="pidx-cta-shape pidx-cta-shape--1"></div>
        <div class="pidx-cta-shape pidx-cta-shape--2"></div>
    </div>
    <div class="pidx-cta-content">
        <div class="pidx-cta-badge">
            <i class="fa-solid fa-paper-plane"></i>
            ¿Listo para comenzar?
        </div>
        <h2 class="pidx-cta-title">
            Hagamos algo
            <span class="pidx-hero-gradient">increíble juntos</span>
        </h2>
        <p class="pidx-cta-text">Platícanos tu idea y creamos un proyecto a la medida de tu marca.</p>
        <div class="pidx-cta-actions">
            <a href="{{ route('contact.index') }}" class="pidx-cta-btn pidx-cta-btn--primary">
                <span>Iniciar proyecto</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{ route('services.index') }}" class="pidx-cta-btn pidx-cta-btn--outline">
                <span>Ver servicios</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

@endsection
