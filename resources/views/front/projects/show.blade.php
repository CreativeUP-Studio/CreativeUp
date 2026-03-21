@extends('layouts.app')

@section('title', $project->title)
@section('body-class', 'page-project-show')

@section('content')

<div class="pshow-page">

{{-- Scroll Progress Bar --}}
<div class="pshow-progress-bar" id="pshowProgress"></div>

{{-- ═══ HERO — Split layout con imagen prominente ═══ --}}
<section class="pshow-hero">
    <div class="pshow-hero-shapes">
        <div class="pshow-hero-shape pshow-hero-shape--1"></div>
        <div class="pshow-hero-shape pshow-hero-shape--2"></div>
    </div>

    <div class="pshow-hero-split">
        {{-- Columna texto --}}
        <div class="pshow-hero-text anim-hidden" data-anim="fade-up">
            <a href="{{ route('projects.index') }}" class="pshow-back">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Todos los proyectos</span>
            </a>

            @if(!empty($project->type))
                <span class="pshow-hero-tag">
                    <i class="fa-solid fa-folder"></i>
                    {{ $project->type }}
                </span>
            @endif

            <h1 class="pshow-hero-title">{{ $project->title }}</h1>

            <div class="pshow-hero-meta">
                @if(!empty($project->client))
                    <div class="pshow-hero-meta-item">
                        <i class="fa-solid fa-building"></i>
                        <span>{{ $project->client }}</span>
                    </div>
                @endif
                @if(!empty($project->year))
                    <div class="pshow-hero-meta-item">
                        <i class="fa-regular fa-calendar"></i>
                        <span>{{ $project->year }}</span>
                    </div>
                @endif
                @if(!empty($project->technologies) && is_array($project->technologies))
                    <div class="pshow-hero-meta-item">
                        <i class="fa-solid fa-code"></i>
                        <span>{{ count($project->technologies) }} tecnologías</span>
                    </div>
                @endif
            </div>

            <p class="pshow-hero-desc">{{ $project->description }}</p>

            @if(!empty($project->technologies) && is_array($project->technologies))
                <div class="pshow-hero-techs">
                    @foreach($project->technologies as $tech)
                        <span class="pshow-hero-tech">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif

            <div class="pshow-hero-actions">
                @if($project->url)
                    <a href="{{ $project->url }}" target="_blank" rel="noopener" class="pshow-hero-btn pshow-hero-btn--primary">
                        <span>Ver en vivo</span>
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                @endif
                <a href="{{ route('contact.index') }}" class="pshow-hero-btn pshow-hero-btn--ghost">
                    <span>Proyecto similar</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Columna imagen --}}
        <div class="pshow-hero-visual anim-hidden" data-anim="fade-left">
            <div class="pshow-hero-img-frame">
                <img src="{{ $project->thumbnail ? Storage::url($project->thumbnail) : ($project->images->first() ? Storage::url($project->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                     alt="{{ $project->title }}">
                {{-- Esquinas decorativas --}}
                <div class="pshow-hero-corner pshow-hero-corner--tl"></div>
                <div class="pshow-hero-corner pshow-hero-corner--br"></div>
            </div>

            {{-- Badges flotantes --}}
            @if($project->images->count() > 0)
            <div class="pshow-hero-float pshow-hero-float--imgs">
                <span class="pshow-hero-float-num">{{ $project->images->count() }}</span>
                <span class="pshow-hero-float-label">Imágenes</span>
            </div>
            @endif
            @if($project->steps->count() > 0)
            <div class="pshow-hero-float pshow-hero-float--steps">
                <span class="pshow-hero-float-num">{{ $project->steps->count() }}</span>
                <span class="pshow-hero-float-label">Fases</span>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══ SECCIONES DE PASOS ═══ --}}
@if($project->steps->count() > 0)
    @foreach($project->steps as $index => $step)
        @php $isEven = $index % 2 === 1; @endphp
        <section class="pshow-step {{ $isEven ? 'pshow-step--reverse' : '' }}">
            <div class="pshow-step-inner">
                {{-- Texto --}}
                <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                    <div class="pshow-step-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <h2 class="pshow-step-title">{{ $step->title }}</h2>
                    <p class="pshow-step-desc">{{ $step->description }}</p>
                </div>
                {{-- Collage de imágenes --}}
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
    {{-- Fallback: challenge/solution/results --}}
    @if(!empty($project->challenge))
    <section class="pshow-step">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <div class="pshow-step-num">01</div>
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
                <div class="pshow-step-num">02</div>
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
                <div class="pshow-step-num">03</div>
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

{{-- ═══ GALERÍA DE IMÁGENES ═══ --}}
@if($project->images->count() > 0)
<section class="pshow-gallery">
    <div class="pshow-gallery-inner">
        <div class="pshow-gallery-header anim-scroll" data-anim="fade-up">
            <span class="pshow-gallery-badge">
                <i class="fa-solid fa-images"></i>
                Galería del proyecto
            </span>
            <h2 class="pshow-gallery-title">Imágenes del proyecto</h2>
        </div>
        <div class="pshow-gallery-grid">
            @foreach($project->images as $gi => $gImg)
            <div class="pshow-gallery-item anim-scroll" data-anim="fade-up" style="animation-delay: {{ $gi * 0.08 }}s">
                <img src="{{ Storage::url($gImg->image_path) }}" alt="{{ $project->title }} - Imagen {{ $gi + 1 }}" loading="lazy" decoding="async">
                <div class="pshow-gallery-item-overlay">
                    <i class="fa-solid fa-expand"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ BANNER CTA ═══ --}}
<section class="pshow-banner">
    <div class="pshow-banner-shapes">
        <div class="pshow-banner-shape pshow-banner-shape--1"></div>
        <div class="pshow-banner-shape pshow-banner-shape--2"></div>
    </div>
    <div class="pshow-banner-content anim-scroll" data-anim="fade-up">
        <div class="pshow-banner-badge">
            <i class="fa-solid fa-paper-plane"></i>
            ¿Te gustó lo que viste?
        </div>
        <h2 class="pshow-banner-title">¿Listo para crear algo increíble?</h2>
        <p class="pshow-banner-text">Llevamos tu idea al siguiente nivel con diseño y estrategia.</p>
        <a href="{{ route('contact.index') }}" class="pshow-banner-btn">
            <span>Empecemos tu proyecto</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>

{{-- ═══ SIGUIENTE PROYECTO ═══ --}}
@if($nextProject)
<section class="pshow-next">
    <a href="{{ route('projects.show', $nextProject->slug) }}" class="pshow-next-link">
        <div class="pshow-next-label anim-scroll" data-anim="fade-up">
            <span class="pshow-next-small">Siguiente proyecto</span>
            <i class="fa-solid fa-arrow-right"></i>
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

</div>

@push('scripts')
<script>
window.addEventListener('scroll', function() {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    const bar = document.getElementById('pshowProgress');
    if (bar) bar.style.width = scrolled + '%';
}, { passive: true });
</script>
@endpush

@endsection
