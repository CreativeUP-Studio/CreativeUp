@extends('layouts.app')

@section('title', $project->title)
@section('body-class', 'page-project-show')

@section('content')

<div class="pshow-page">

{{-- Scroll Progress Bar --}}
<div class="pshow-progress-bar" id="pshowProgress"></div>

{{-- ══════════════════════════════════════════════════
     SECCIÓN 1 — HEADER FULLSCREEN
     Imagen del proyecto como fondo, título izquierda, descripción derecha
     ══════════════════════════════════════════════════ --}}
<section class="pshow-hero-full">
    <div class="pshow-hero-bg">
        <img src="{{ $project->thumbnail ? Storage::url($project->thumbnail) : ($project->images->first() ? Storage::url($project->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
             alt="{{ $project->title }}">
        <div class="pshow-hero-overlay"></div>
    </div>

    <div class="pshow-hero-split">
        <div class="pshow-hero-left anim-hidden" data-anim="fade-up">
            @if(!empty($project->type))
                <span class="pshow-hero-tag">{{ $project->type }}</span>
            @endif
            <h1 class="pshow-hero-title">{{ $project->title }}</h1>
            <div class="pshow-hero-meta">
                @if(!empty($project->client))
                    <span class="pshow-hero-detail">{{ $project->client }}</span>
                @endif
                @if(!empty($project->year))
                    <span class="pshow-hero-detail">{{ $project->year }}</span>
                @endif
            </div>
        </div>
        <div class="pshow-hero-right anim-hidden" data-anim="fade-up">
            <p class="pshow-hero-desc">{{ $project->description }}</p>
            @if(!empty($project->technologies) && is_array($project->technologies))
                <div class="pshow-hero-techs">
                    @foreach($project->technologies as $tech)
                        <span class="pshow-hero-tech">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif
            @if($project->url)
                <a href="{{ $project->url }}" target="_blank" rel="noopener" class="pshow-hero-btn">
                    Ver proyecto en vivo
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            @endif
        </div>
    </div>

    <div class="pshow-hero-scroll">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     SECCIONES DE PASOS — Fullscreen, alternando posición
     Impares: texto izquierda, collage derecha
     Pares: collage izquierda, texto derecha
     ══════════════════════════════════════════════════ --}}
@if($project->steps->count() > 0)
    @foreach($project->steps as $index => $step)
        @php $isEven = $index % 2 === 1; @endphp
        <section class="pshow-step {{ $isEven ? 'pshow-step--reverse' : '' }}">
            <div class="pshow-step-inner">
                {{-- Texto --}}
                <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                    <span class="pshow-step-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2 class="pshow-step-title">{{ $step->title }}</h2>
                    <p class="pshow-step-desc">{{ $step->description }}</p>
                </div>
                {{-- Collage de 3 imágenes --}}
                <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                    @if($step->image1)
                        <div class="pshow-collage-img pshow-collage-img--1">
                            <img src="{{ Storage::url($step->image1) }}" alt="{{ $step->title }}" loading="lazy">
                        </div>
                    @endif
                    @if($step->image2)
                        <div class="pshow-collage-img pshow-collage-img--2">
                            <img src="{{ Storage::url($step->image2) }}" alt="{{ $step->title }}" loading="lazy">
                        </div>
                    @endif
                    @if($step->image3)
                        <div class="pshow-collage-img pshow-collage-img--3">
                            <img src="{{ Storage::url($step->image3) }}" alt="{{ $step->title }}" loading="lazy">
                        </div>
                    @endif
                    {{-- Si no hay imágenes de paso, usar imágenes de galería --}}
                    @if(!$step->image1 && !$step->image2 && !$step->image3 && $project->images->count() > 0)
                        @foreach($project->images->slice($index * 3, 3) as $fallbackImg)
                            <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                                <img src="{{ Storage::url($fallbackImg->image_path) }}" alt="{{ $step->title }}" loading="lazy">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@else
    {{-- Fallback: si no hay pasos, mostrar info antigua como secciones --}}
    @if(!empty($project->challenge))
    <section class="pshow-step">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <span class="pshow-step-num">01</span>
                <h2 class="pshow-step-title">El Reto</h2>
                <p class="pshow-step-desc">{{ $project->challenge }}</p>
            </div>
            <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                @foreach($project->images->slice(0, 3) as $img)
                    <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!empty($project->solution))
    <section class="pshow-step pshow-step--reverse">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <span class="pshow-step-num">02</span>
                <h2 class="pshow-step-title">La Solución</h2>
                <p class="pshow-step-desc">{{ $project->solution }}</p>
            </div>
            <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                @foreach($project->images->slice(3, 3) as $img)
                    <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!empty($project->results))
    <section class="pshow-step">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <span class="pshow-step-num">03</span>
                <h2 class="pshow-step-title">Los Resultados</h2>
                <p class="pshow-step-desc">{{ $project->results }}</p>
            </div>
            <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                @foreach($project->images->slice(6, 3) as $img)
                    <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endif

{{-- ══════════════════════════════════════════════════
     BANNER CTA — Llamativo fullscreen
     ══════════════════════════════════════════════════ --}}
<section class="pshow-banner">
    <div class="pshow-banner-bg"></div>
    <div class="pshow-banner-content anim-scroll" data-anim="fade-up">
        <h2 class="pshow-banner-title">¿Listo para crear algo increíble?</h2>
        <p class="pshow-banner-text">Llevamos tu idea al siguiente nivel con diseño y estrategia.</p>
        <a href="{{ route('contact.index') }}" class="pshow-banner-btn">
            Empecemos tu proyecto
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     SIGUIENTE PROYECTO — Grande y llamativo
     ══════════════════════════════════════════════════ --}}
@if($nextProject)
<section class="pshow-next">
    <a href="{{ route('projects.show', $nextProject->slug) }}" class="pshow-next-link">
        <div class="pshow-next-label anim-scroll" data-anim="fade-up">
            <span class="pshow-next-small">Siguiente proyecto</span>
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </div>
        <h2 class="pshow-next-title anim-scroll" data-anim="fade-up">{{ $nextProject->title }}</h2>
        <div class="pshow-next-img anim-scroll" data-anim="fade-up">
            <img src="{{ $nextProject->thumbnail ? Storage::url($nextProject->thumbnail) : ($nextProject->images->first() ? Storage::url($nextProject->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                 alt="{{ $nextProject->title }}">
        </div>
    </a>
</section>
@elseif($previousProject)
<section class="pshow-next">
    <a href="{{ route('projects.show', $previousProject->slug) }}" class="pshow-next-link">
        <div class="pshow-next-label anim-scroll" data-anim="fade-up">
            <span class="pshow-next-small">Ver otro proyecto</span>
        </div>
        <h2 class="pshow-next-title anim-scroll" data-anim="fade-up">{{ $previousProject->title }}</h2>
        <div class="pshow-next-img anim-scroll" data-anim="fade-up">
            <img src="{{ $previousProject->thumbnail ? Storage::url($previousProject->thumbnail) : ($previousProject->images->first() ? Storage::url($previousProject->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                 alt="{{ $previousProject->title }}">
        </div>
    </a>
</section>
@endif

</div> {{-- /.pshow-page --}}

@push('scripts')
<script>
window.addEventListener('scroll', function() {
    // Scroll Progress Bar
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    const bar = document.getElementById('pshowProgress');
    if (bar) bar.style.width = scrolled + '%';

    // Detectar si pasamos el hero oscuro para restaurar color de dots
    const hero = document.querySelector('.pshow-hero-full');
    if (hero) {
        const heroBottom = hero.offsetTop + hero.offsetHeight;
        if (window.scrollY > heroBottom - 80) {
            document.body.classList.add('past-hero');
        } else {
            document.body.classList.remove('past-hero');
        }
    }
}, { passive: true });
</script>
@endpush

@endsection
