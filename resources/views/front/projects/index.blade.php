@extends('layouts.app')

@section('title', 'Proyectos')
@section('body-class', 'page-projects-index')

@section('content')

{{-- ══════════════════════════════════════════════════
     FILTROS — Barra flotante
     ══════════════════════════════════════════════════ --}}
@if($types->count() > 0)
<nav class="pidx-filters-float">
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
</nav>
@endif

{{-- ══════════════════════════════════════════════════
     LISTADO DE PROYECTOS — Galeria Multi-Foto
     ══════════════════════════════════════════════════ --}}
<section class="pidx-grid">
    @if($projects->count() > 0)

        @foreach($projects as $index => $project)
            @php
                // Recopilar hasta 4 imagenes: thumbnail + images collection
                $allImages = collect();
                if ($project->thumbnail) {
                    $allImages->push(Storage::url($project->thumbnail));
                }
                foreach ($project->images as $img) {
                    if ($allImages->count() < 4) {
                        $allImages->push(Storage::url($img->image_path));
                    }
                }
                // Si no hay imagenes, placeholder
                if ($allImages->isEmpty()) {
                    $allImages->push(asset('images/hero-1.jpg'));
                }
                $imgCount = $allImages->count();
                // Alternar layout: par = normal, impar = invertido
                $reversed = $index % 2 !== 0;
            @endphp

            <a href="{{ route('projects.show', $project->slug) }}"
               class="pidx-project {{ $reversed ? 'pidx-project--rev' : '' }} anim-scroll"
               data-anim="fade-up">

                {{-- Mosaico de imagenes --}}
                <div class="pidx-project-mosaic pidx-mosaic--{{ $imgCount }}">
                    @foreach($allImages as $i => $imgUrl)
                        <div class="pidx-mosaic-cell pidx-mosaic-cell--{{ $i }}">
                            <img src="{{ $imgUrl }}" alt="{{ $project->title }}" loading="lazy" decoding="async">
                            <div class="pidx-mosaic-gradient"></div>
                        </div>
                    @endforeach
                </div>

                {{-- Info del proyecto --}}
                <div class="pidx-project-info">
                    <div class="pidx-project-num">
                        {{ str_pad($projects->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="pidx-project-meta">
                        @if(!empty($project->type))
                            <span class="pidx-project-type">{{ $project->type }}</span>
                        @endif
                        @if(!empty($project->year))
                            <span class="pidx-project-year">{{ $project->year }}</span>
                        @endif
                    </div>
                    <h2 class="pidx-project-title">{{ $project->title }}</h2>
                    <p class="pidx-project-desc">{{ Str::limit($project->description, 140) }}</p>
                    <div class="pidx-project-cta-row">
                        @if(!empty($project->client))
                            <span class="pidx-project-client">{{ $project->client }}</span>
                        @endif
                        <span class="pidx-project-arrow">
                            Ver proyecto
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M7 17L17 7M17 7H7M17 7v10"/>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Gradient decorativo de fondo --}}
                <div class="pidx-project-glow"></div>
            </a>
        @endforeach

        {{-- Paginacion --}}
        @if($projects->hasPages())
        <div class="pidx-pagination">
            {{ $projects->appends(request()->query())->links() }}
        </div>
        @endif

    @else
        <div class="pidx-empty">
            <div class="pidx-empty-icon">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <p>Proximamente compartiremos nuestros proyectos.</p>
        </div>
    @endif
</section>

{{-- ══════════════════════════════════════════════════
     CTA — Con gradiente
     ══════════════════════════════════════════════════ --}}
<section class="pidx-cta anim-scroll" data-anim="fade-up">
    <div class="pidx-cta-glow"></div>
    <div class="pidx-cta-inner">
        <span class="pidx-cta-label">Listo para comenzar?</span>
        <h2 class="pidx-cta-title">Hagamos algo<br><em>increible</em></h2>
        <a href="{{ route('contact.index') }}" class="pidx-cta-btn">
            <span>Iniciar conversacion</span>
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>

@endsection
