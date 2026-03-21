@extends('layouts.app')

@section('title', 'Servicios')

@section('content')

{{-- ═══ HERO INMERSIVO ═══ --}}
<section class="svc-hero" id="svcHero">
    {{-- Formas decorativas flotantes --}}
    <div class="svc-hero-shapes">
        <div class="svc-shape svc-shape--1"></div>
        <div class="svc-shape svc-shape--2"></div>
        <div class="svc-shape svc-shape--3"></div>
        <div class="svc-shape svc-shape--4"></div>
    </div>
    {{-- Líneas grid decorativas --}}
    <div class="svc-hero-grid-lines">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="svc-hero-content">
        <div class="svc-hero-badge anim-hidden" data-anim="fade-up">
            <span class="svc-hero-badge-dot"></span>
            Nuestros servicios
        </div>
        <h1 class="svc-hero-title anim-hidden" data-anim="fade-up">
            Impulsamos marcas con
            <span class="svc-hero-title-gradient">estrategia y creatividad</span>
        </h1>
        <p class="svc-hero-sub anim-hidden" data-anim="fade-up">
            Combinamos diseño, tecnología y visión estratégica para crear
            experiencias digitales que generan resultados reales.
        </p>
        <div class="svc-hero-actions anim-hidden" data-anim="fade-up">
            <a href="#svcShowcase" class="svc-hero-btn svc-hero-btn--primary">
                <span>Explorar servicios</span>
                <i class="fa-solid fa-arrow-down"></i>
            </a>
            <a href="{{ route('contact.index') }}" class="svc-hero-btn svc-hero-btn--ghost">
                <span>Hablemos</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Stats flotantes --}}
    <div class="svc-hero-stats anim-hidden" data-anim="fade-up">
        <div class="svc-stat">
            <span class="svc-stat-number" data-count="150">0</span><span class="svc-stat-suffix">+</span>
            <span class="svc-stat-label">Proyectos</span>
        </div>
        <div class="svc-stat-divider"></div>
        <div class="svc-stat">
            <span class="svc-stat-number" data-count="98">0</span><span class="svc-stat-suffix">%</span>
            <span class="svc-stat-label">Satisfacción</span>
        </div>
        <div class="svc-stat-divider"></div>
        <div class="svc-stat">
            <span class="svc-stat-number" data-count="8">0</span><span class="svc-stat-suffix">+</span>
            <span class="svc-stat-label">Años experiencia</span>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="svc-hero-scroll anim-hidden" data-anim="fade-up">
        <div class="svc-hero-scroll-line">
            <span class="svc-hero-scroll-dot"></span>
        </div>
    </div>
</section>

{{-- ═══ SHOWCASE DE SERVICIOS ═══ --}}
<section class="svc-showcase" id="svcShowcase">
    @forelse($services as $index => $service)
    <div class="svc-showcase-item {{ $index % 2 !== 0 ? 'svc-showcase-item--reverse' : '' }}">
        {{-- Número decorativo --}}
        <span class="svc-showcase-number anim-scroll" data-anim="fade-in">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

        {{-- Visual --}}
        <div class="svc-showcase-visual anim-scroll" data-anim="{{ $index % 2 === 0 ? 'fade-right' : 'fade-left' }}">
            <div class="svc-showcase-img-wrap">
                @if($service->image)
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" loading="lazy" decoding="async">
                @else
                    <div class="svc-showcase-placeholder" style="--svc-color: {{ $service->color ?? '#5e17eb' }}">
                        <span class="svc-showcase-placeholder-icon"><i class="{{ $service->icon ?? 'fa-solid fa-star' }}"></i></span>
                    </div>
                @endif
                <div class="svc-showcase-img-overlay"></div>
                {{-- Forma decorativa sobre la imagen --}}
                <div class="svc-showcase-blob svc-showcase-blob--{{ $index % 4 }}"></div>
            </div>
            {{-- Badge de icono flotante --}}
            @if($service->icon)
            <div class="svc-showcase-icon-badge">
                <span><i class="{{ $service->icon }}"></i></span>
            </div>
            @endif
            {{-- Mini galería thumb --}}
            @if($service->gallery && count($service->gallery) > 0)
            <div class="svc-showcase-gallery-thumbs">
                @foreach(array_slice($service->gallery, 0, 3) as $thumb)
                <div class="svc-showcase-thumb">
                    <img src="{{ Storage::url($thumb) }}" alt="" loading="lazy" decoding="async">
                </div>
                @endforeach
                @if(count($service->gallery) > 3)
                <div class="svc-showcase-thumb svc-showcase-thumb--more">
                    +{{ count($service->gallery) - 3 }}
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- Contenido --}}
        <div class="svc-showcase-content anim-scroll" data-anim="{{ $index % 2 === 0 ? 'fade-left' : 'fade-right' }}">
            <div class="svc-showcase-content-inner">
                <div class="svc-showcase-tag">
                    <span class="svc-showcase-tag-line"></span>
                    Servicio {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>
                <h2 class="svc-showcase-title">{{ $service->title }}</h2>
                <p class="svc-showcase-desc">{{ $service->short_description ?? Str::limit($service->description, 200) }}</p>

                @if($service->features && count($service->features) > 0)
                <ul class="svc-showcase-features">
                    @foreach(array_slice($service->features, 0, 4) as $feat)
                    <li class="svc-showcase-feature">
                        <span class="svc-showcase-feature-icon">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span>{{ $feat }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                {{-- Mini info badges --}}
                <div class="svc-showcase-meta">
                    @if($service->benefits && count($service->benefits) > 0)
                    <span class="svc-showcase-meta-badge">
                        <i class="fa-solid fa-gem"></i>
                        {{ count($service->benefits) }} beneficios
                    </span>
                    @endif
                    @if($service->process_steps && count($service->process_steps) > 0)
                    <span class="svc-showcase-meta-badge">
                        <i class="fa-solid fa-shoe-prints"></i>
                        {{ count($service->process_steps) }} pasos
                    </span>
                    @endif
                    @if($service->gallery && count($service->gallery) > 0)
                    <span class="svc-showcase-meta-badge">
                        <i class="fa-solid fa-images"></i>
                        {{ count($service->gallery) }} fotos
                    </span>
                    @endif
                </div>

                <a href="{{ route('services.show', $service->slug) }}" class="svc-showcase-link">
                    <span>Conocer más</span>
                    <span class="svc-showcase-link-arrow">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="svc-empty">
        <div class="svc-empty-icon"><i class="fa-solid fa-layer-group"></i></div>
        <p>No hay servicios disponibles por el momento.</p>
    </div>
    @endforelse
</section>

{{-- ═══ PROCESO DE TRABAJO ═══ --}}
<section class="svc-process">
    <div class="svc-process-header">
        <div class="svc-process-badge anim-scroll" data-anim="fade-up">Cómo trabajamos</div>
        <h2 class="svc-process-title anim-scroll" data-anim="fade-up">
            Un proceso pensado para
            <span class="svc-hero-title-gradient">resultados</span>
        </h2>
        <p class="svc-process-sub anim-scroll" data-anim="fade-up">
            Cada proyecto sigue una metodología probada que asegura calidad y eficiencia.
        </p>
    </div>

    <div class="svc-process-timeline">
        <div class="svc-process-line">
            <div class="svc-process-line-fill" id="svcProcessLineFill"></div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up">
            <div class="svc-process-step-dot">
                <span>01</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <h3>Descubrimiento</h3>
                <p>Analizamos tu marca, mercado y objetivos para entender el contexto completo.</p>
            </div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up">
            <div class="svc-process-step-dot">
                <span>02</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon"><i class="fa-solid fa-compass-drafting"></i></div>
                <h3>Estrategia</h3>
                <p>Diseñamos un plan de acción con metas claras, KPIs y cronograma definido.</p>
            </div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up">
            <div class="svc-process-step-dot">
                <span>03</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon"><i class="fa-solid fa-pen-nib"></i></div>
                <h3>Creación</h3>
                <p>Nuestro equipo da vida a la visión con diseño, código y contenido de primer nivel.</p>
            </div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up">
            <div class="svc-process-step-dot">
                <span>04</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon"><i class="fa-solid fa-rocket"></i></div>
                <h3>Lanzamiento</h3>
                <p>Implementamos, optimizamos y medimos para asegurar un impacto real y medible.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ MARQUEE DE TECNOLOGÍAS ═══ --}}
<section class="svc-marquee-section">
    <div class="svc-marquee">
        <div class="svc-marquee-track">
            @for($i = 0; $i < 2; $i++)
            <span class="svc-marquee-item">Branding</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">Estrategia digital</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">Desarrollo web</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">Social Media</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">SEO &amp; SEM</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">UI/UX Design</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">E-commerce</span>
            <span class="svc-marquee-dot">✦</span>
            <span class="svc-marquee-item">Contenido</span>
            <span class="svc-marquee-dot">✦</span>
            @endfor
        </div>
    </div>
</section>

{{-- ═══ CTA FINAL ═══ --}}
<section class="svc-cta">
    <div class="svc-cta-shapes">
        <div class="svc-cta-shape svc-cta-shape--1"></div>
        <div class="svc-cta-shape svc-cta-shape--2"></div>
    </div>
    <div class="svc-cta-content anim-scroll" data-anim="fade-up">
        <div class="svc-cta-badge">
            <i class="fa-solid fa-paper-plane"></i>
            ¿Listo para el siguiente paso?
        </div>
        <h2 class="svc-cta-title">
            Transformemos tu marca<br>
            <span class="svc-hero-title-gradient">juntos</span>
        </h2>
        <p class="svc-cta-text">
            Cuéntanos tu idea y diseñamos la estrategia perfecta para llevar tu negocio al siguiente nivel.
        </p>
        <div class="svc-cta-actions">
            <a href="{{ route('contact.index') }}" class="svc-cta-btn svc-cta-btn--primary">
                <span>Iniciar proyecto</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{ route('projects.index') }}" class="svc-cta-btn svc-cta-btn--outline">
                <span>Ver portafolio</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

@endsection
