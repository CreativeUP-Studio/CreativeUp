@extends('layouts.app')

@section('title', $service->meta_title ?? $service->title)

@push('head')
<meta name="description" content="{{ $service->meta_description ?? Str::limit($service->description, 160) }}">
<meta property="og:title" content="{{ $service->meta_title ?? $service->title }} | CreativeUP">
<meta property="og:description" content="{{ $service->meta_description ?? Str::limit($service->description, 160) }}">
<meta property="og:type" content="website">
@if($service->image)
<meta property="og:image" content="{{ Storage::url($service->image) }}">
@endif
@endpush

@section('content')

{{-- ═══ HERO DEL SERVICIO — SPLIT LAYOUT ═══ --}}
<section class="svc-show-hero" aria-labelledby="svc-show-title">
    <div class="svc-show-hero-shapes" aria-hidden="true">
        <div class="svc-show-hero-shape svc-show-hero-shape--1"></div>
        <div class="svc-show-hero-shape svc-show-hero-shape--2"></div>
    </div>

    <div class="svc-show-hero-split">
        {{-- Columna texto --}}
        <div class="svc-show-hero-text">
            <a href="{{ route('services.index') }}" class="svc-show-back anim-hidden" data-anim="fade-left">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>Todos los servicios</span>
            </a>

            @if($service->icon)
                <div class="svc-show-icon-wrap anim-hidden" data-anim="zoom-in" aria-hidden="true">
                    <i class="{{ $service->icon }}"></i>
                </div>
            @endif
            
            <h1 id="svc-show-title" class="svc-show-title anim-hidden" data-anim="fade-up">{{ $service->title }}</h1>
            
            <p class="svc-show-subtitle anim-hidden" data-anim="fade-up">
                {{ $service->short_description ?? Str::limit($service->description, 180) }}
            </p>

            <div class="svc-show-hero-actions anim-hidden" data-anim="fade-up">
                <a href="{{ route('contact.index') }}" class="svc-hero-btn svc-hero-btn--primary">
                    <span>Solicitar cotización</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
                <a href="#svcShowContent" class="svc-hero-btn svc-hero-btn--ghost">
                    <span>Saber más</span>
                    <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        {{-- Columna imagen --}}
        <div class="svc-show-hero-visual anim-hidden" data-anim="fade-left">
            <div class="svc-show-hero-img-frame">
                @if($service->image)
                    <img 
                        src="{{ Storage::url($service->image) }}" 
                        alt="{{ $service->title }}"
                        width="600"
                        height="450"
                        fetchpriority="high"
                    >
                @else
                    <div class="svc-show-hero-placeholder" style="--svc-accent: {{ $service->color ?? '#5e17eb' }}">
                        <i class="{{ $service->icon ?? 'fa-solid fa-star' }}" aria-hidden="true"></i>
                    </div>
                @endif
                {{-- Decoración esquina --}}
                <div class="svc-show-hero-img-corner svc-show-hero-img-corner--tl" aria-hidden="true"></div>
                <div class="svc-show-hero-img-corner svc-show-hero-img-corner--br" aria-hidden="true"></div>
            </div>
            
            {{-- Badge flotante --}}
            @if($service->features && count($service->features) > 0)
            <div class="svc-show-hero-float-badge">
                <span class="svc-show-hero-float-number">{{ count($service->features) }}</span>
                <span class="svc-show-hero-float-label">Prestaciones</span>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══ GALERÍA VISUAL ═══ --}}
@if($service->gallery && count($service->gallery) > 0)
<section class="svc-show-gallery" id="svcGallery" aria-labelledby="svc-gallery-title">
    <div class="svc-show-gallery-inner">
        <div class="svc-show-gallery-header anim-scroll" data-anim="fade-up">
            <span class="svc-show-gallery-badge">
                <i class="fa-solid fa-camera" aria-hidden="true"></i>
                Nuestro trabajo
            </span>
            <h2 id="svc-gallery-title" class="svc-show-gallery-title">Galería del servicio</h2>
        </div>
        <div class="svc-show-gallery-grid" role="list">
            @foreach($service->gallery as $gi => $gImg)
            <div class="svc-show-gallery-item anim-scroll" data-anim="fade-up" style="animation-delay: {{ $gi * 0.1 }}s" role="listitem">
                <img 
                    src="{{ Storage::url($gImg) }}" 
                    alt="{{ $service->title }} - Imagen {{ $gi + 1 }}" 
                    loading="lazy" 
                    decoding="async" 
                    data-gallery-idx="{{ $gi }}"
                    width="400"
                    height="300"
                >
                <div class="svc-show-gallery-item-overlay" role="button" tabindex="0" aria-label="Ver imagen {{ $gi + 1 }} en pantalla completa">
                    <i class="fa-solid fa-expand" aria-hidden="true"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Lightbox --}}
<div class="svc-lightbox" id="svcLightbox" role="dialog" aria-modal="true" aria-label="Visor de imágenes">
    <button class="svc-lightbox-close" id="svcLightboxClose" aria-label="Cerrar visor">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
    <button class="svc-lightbox-prev" id="svcLightboxPrev" aria-label="Imagen anterior">
        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
    </button>
    <button class="svc-lightbox-next" id="svcLightboxNext" aria-label="Imagen siguiente">
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
    </button>
    <div class="svc-lightbox-content">
        <img src="" alt="" id="svcLightboxImg">
    </div>
    <div class="svc-lightbox-counter" id="svcLightboxCounter" aria-live="polite"></div>
</div>
@endif

{{-- ═══ CONTENIDO PRINCIPAL ═══ --}}
<section class="svc-show-content" id="svcShowContent">
    <div class="svc-show-layout">

        {{-- Columna principal --}}
        <div class="svc-show-main">
            {{-- Descripción --}}
            <article class="svc-show-block anim-scroll" data-anim="fade-up">
                <div class="svc-show-block-header">
                    <span class="svc-show-block-icon" aria-hidden="true"><i class="fa-solid fa-layer-group"></i></span>
                    <h2 class="svc-show-section-title">Sobre este servicio</h2>
                </div>
                <div class="svc-show-desc">
                    {!! nl2br(e($service->description)) !!}
                </div>
            </article>

            {{-- Imagen destacada inline --}}
            @if($service->image)
            <figure class="svc-show-featured-img anim-scroll" data-anim="fade-up">
                <img 
                    src="{{ Storage::url($service->image) }}" 
                    alt="{{ $service->title }}" 
                    loading="lazy" 
                    decoding="async"
                    width="800"
                    height="500"
                >
                <figcaption class="svc-show-featured-img-caption">
                    <i class="{{ $service->icon ?? 'fa-solid fa-star' }}" aria-hidden="true"></i>
                    <span>{{ $service->title }}</span>
                </figcaption>
            </figure>
            @endif

            {{-- Features como grid de cards --}}
            @if($service->features && count($service->features) > 0)
            <article class="svc-show-block anim-scroll" data-anim="fade-up">
                <div class="svc-show-block-header">
                    <span class="svc-show-block-icon" aria-hidden="true"><i class="fa-solid fa-check-double"></i></span>
                    <h2 class="svc-show-section-title">Lo que incluye</h2>
                </div>
                <div class="svc-show-features-grid" role="list">
                    @foreach($service->features as $i => $feat)
                    <div class="svc-show-feature-card" style="animation-delay: {{ $i * 0.08 }}s" role="listitem">
                        <div class="svc-show-feature-number" aria-hidden="true">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <p class="svc-show-feature-text">{{ $feat }}</p>
                        <div class="svc-show-feature-glow" aria-hidden="true"></div>
                    </div>
                    @endforeach
                </div>
            </article>
            @endif

            {{-- Beneficios --}}
            @if($service->benefits && count($service->benefits) > 0)
            <article class="svc-show-block anim-scroll" data-anim="fade-up">
                <div class="svc-show-block-header">
                    <span class="svc-show-block-icon" aria-hidden="true"><i class="fa-solid fa-gem"></i></span>
                    <h2 class="svc-show-section-title">Beneficios</h2>
                </div>
                <div class="svc-show-benefits-grid">
                    @foreach($service->benefits as $bi => $benefit)
                    <div class="svc-show-benefit-card anim-scroll" data-anim="fade-up" style="animation-delay: {{ $bi * 0.1 }}s">
                        <div class="svc-show-benefit-icon" aria-hidden="true">
                            <i class="{{ $benefit['icon'] ?? 'fa-solid fa-star' }}"></i>
                        </div>
                        <h3 class="svc-show-benefit-title">{{ $benefit['title'] }}</h3>
                        <p class="svc-show-benefit-desc">{{ $benefit['desc'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </article>
            @endif

            {{-- Proceso del servicio --}}
            @if($service->process_steps && count($service->process_steps) > 0)
            <article class="svc-show-block anim-scroll" data-anim="fade-up">
                <div class="svc-show-block-header">
                    <span class="svc-show-block-icon" aria-hidden="true"><i class="fa-solid fa-shoe-prints"></i></span>
                    <h2 class="svc-show-section-title">Proceso de trabajo</h2>
                </div>
                <div class="svc-show-process-list" role="list">
                    @foreach($service->process_steps as $si => $step)
                    <div class="svc-show-process-item anim-scroll" data-anim="fade-left" style="animation-delay: {{ $si * 0.12 }}s" role="listitem">
                        <div class="svc-show-process-number" aria-hidden="true">{{ str_pad($si + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="svc-show-process-line-v" aria-hidden="true"></div>
                        <div class="svc-show-process-content">
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['desc'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </article>
            @endif
        </div>

        {{-- Sidebar sticky --}}
        <aside class="svc-show-sidebar">
            <div class="svc-show-sidebar-card anim-scroll" data-anim="fade-up">
                <div class="svc-show-sidebar-header">
                    <h3>¿Interesado?</h3>
                    <p>Contáctanos para una propuesta personalizada.</p>
                </div>

                <div class="svc-show-sidebar-info">
                    @if($service->icon)
                    <div class="svc-show-sidebar-row">
                        <span class="svc-show-sidebar-label">Servicio</span>
                        <span class="svc-show-sidebar-value">
                            <i class="{{ $service->icon }}" aria-hidden="true"></i> {{ $service->title }}
                        </span>
                    </div>
                    @endif
                    @if($service->features)
                    <div class="svc-show-sidebar-row">
                        <span class="svc-show-sidebar-label">Incluye</span>
                        <span class="svc-show-sidebar-value">{{ count($service->features) }} prestaciones</span>
                    </div>
                    @endif
                    @if($service->gallery)
                    <div class="svc-show-sidebar-row">
                        <span class="svc-show-sidebar-label">Galería</span>
                        <span class="svc-show-sidebar-value">{{ count($service->gallery) }} imágenes</span>
                    </div>
                    @endif
                    <div class="svc-show-sidebar-row">
                        <span class="svc-show-sidebar-label">Respuesta</span>
                        <span class="svc-show-sidebar-value">En 24-48h</span>
                    </div>
                </div>

                <a href="{{ route('contact.index') }}" class="svc-show-sidebar-btn">
                    <span>Solicitar cotización</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>

                <div class="svc-show-sidebar-trust">
                    <div class="svc-show-sidebar-trust-item">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        <span>Propuesta sin compromiso</span>
                    </div>
                    <div class="svc-show-sidebar-trust-item">
                        <i class="fa-solid fa-clock" aria-hidden="true"></i>
                        <span>Respuesta rápida</span>
                    </div>
                    <div class="svc-show-sidebar-trust-item">
                        <i class="fa-solid fa-handshake" aria-hidden="true"></i>
                        <span>Soporte continuo</span>
                    </div>
                </div>
            </div>

            {{-- Mini galería en sidebar --}}
            @if($service->gallery && count($service->gallery) >= 2)
            <div class="svc-show-sidebar-gallery anim-scroll" data-anim="fade-up">
                @foreach(array_slice($service->gallery, 0, 3) as $sgImg)
                <img 
                    src="{{ Storage::url($sgImg) }}" 
                    alt="{{ $service->title }}" 
                    loading="lazy" 
                    decoding="async"
                    width="100"
                    height="100"
                >
                @endforeach
                @if(count($service->gallery) > 3)
                <a href="#svcGallery" class="svc-show-sidebar-gallery-more" aria-label="Ver las {{ count($service->gallery) - 3 }} imágenes restantes">
                    +{{ count($service->gallery) - 3 }}
                </a>
                @endif
            </div>
            @endif
        </aside>
    </div>
</section>

{{-- ═══ CTA ═══ --}}
<section class="svc-cta" aria-labelledby="svc-show-cta-title">
    <div class="svc-cta-shapes" aria-hidden="true">
        <div class="svc-cta-shape svc-cta-shape--1"></div>
        <div class="svc-cta-shape svc-cta-shape--2"></div>
    </div>
    <div class="svc-cta-content anim-scroll" data-anim="fade-up">
        <div class="svc-cta-badge">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            ¿Listo para empezar?
        </div>
        <h2 id="svc-show-cta-title" class="svc-cta-title">
            {{ $service->cta_text ?? '¿Te interesa ' . $service->title . '?' }}
        </h2>
        <p class="svc-cta-text">Platícanos tu proyecto y creamos una propuesta a tu medida.</p>
        <div class="svc-cta-actions">
            <a href="{{ route('contact.index') }}" class="svc-cta-btn svc-cta-btn--primary">
                <span>Iniciar proyecto</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
            <a href="{{ route('services.index') }}" class="svc-cta-btn svc-cta-btn--outline">
                <span>Ver todos los servicios</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

@endsection
