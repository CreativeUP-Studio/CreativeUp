@extends('layouts.app')

@section('title', 'Servicios')

@push('head')
<meta name="description" content="Servicios profesionales de diseño, desarrollo web, branding y marketing digital. Transformamos tu marca con estrategia y creatividad.">
<meta property="og:title" content="Servicios | CreativeUP">
<meta property="og:description" content="Servicios profesionales de diseño, desarrollo web, branding y marketing digital.">
<meta property="og:type" content="website">
@endpush

@section('content')

{{-- ═══ HERO INMERSIVO ═══ --}}
<section class="svc-hero" id="svcHero" aria-labelledby="svc-hero-title">
    {{-- Formas decorativas flotantes --}}
    <div class="svc-hero-shapes" aria-hidden="true">
        <div class="svc-shape svc-shape--1"></div>
        <div class="svc-shape svc-shape--2"></div>
        <div class="svc-shape svc-shape--3"></div>
        <div class="svc-shape svc-shape--4"></div>
    </div>
    
    {{-- Líneas grid decorativas --}}
    <div class="svc-hero-grid-lines" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="svc-hero-content">
        <div class="svc-hero-badge anim-hidden" data-anim="fade-up">
            <span class="svc-hero-badge-dot" aria-hidden="true"></span>
            Nuestros servicios
        </div>
        
        <h1 id="svc-hero-title" class="svc-hero-title anim-hidden" data-anim="fade-up">
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
                <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
            </a>
            <a href="{{ route('contact.index') }}" class="svc-hero-btn svc-hero-btn--ghost">
                <span>Hablemos</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    {{-- Stats flotantes --}}
    <div class="svc-hero-stats anim-hidden" data-anim="fade-up" role="list" aria-label="Estadísticas de la empresa">
        <div class="svc-stat" role="listitem">
            <span class="svc-stat-number" data-count="150">0</span><span class="svc-stat-suffix">+</span>
            <span class="svc-stat-label">Proyectos</span>
        </div>
        <div class="svc-stat-divider" aria-hidden="true"></div>
        <div class="svc-stat" role="listitem">
            <span class="svc-stat-number" data-count="98">0</span><span class="svc-stat-suffix">%</span>
            <span class="svc-stat-label">Satisfacción</span>
        </div>
        <div class="svc-stat-divider" aria-hidden="true"></div>
        <div class="svc-stat" role="listitem">
            <span class="svc-stat-number" data-count="8">0</span><span class="svc-stat-suffix">+</span>
            <span class="svc-stat-label">Años experiencia</span>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="svc-hero-scroll anim-hidden" data-anim="fade-up" aria-hidden="true">
        <div class="svc-hero-scroll-line">
            <span class="svc-hero-scroll-dot"></span>
        </div>
    </div>
</section>

{{-- ═══ SHOWCASE DE SERVICIOS ═══ --}}
<section class="svc-showcase" id="svcShowcase" aria-labelledby="svc-showcase-title">
    <h2 id="svc-showcase-title" class="sr-only">Nuestros Servicios</h2>
    
    @forelse($services as $index => $service)
    <article class="svc-showcase-item {{ $index % 2 !== 0 ? 'svc-showcase-item--reverse' : '' }}">
        {{-- Número decorativo --}}
        <span class="svc-showcase-number anim-scroll" data-anim="fade-in" aria-hidden="true">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

        {{-- Visual --}}
        <div class="svc-showcase-visual anim-scroll" data-anim="{{ $index % 2 === 0 ? 'fade-right' : 'fade-left' }}">
            <div class="svc-showcase-img-wrap">
                @if($service->image)
                    <img 
                        src="{{ Storage::url($service->image) }}" 
                        alt="{{ $service->title }}" 
                        loading="{{ $index < 2 ? 'eager' : 'lazy' }}" 
                        decoding="async"
                        width="600"
                        height="450"
                    >
                @else
                    <div class="svc-showcase-placeholder" style="--svc-color: {{ $service->color ?? '#5e17eb' }}">
                        <span class="svc-showcase-placeholder-icon">
                            <i class="{{ $service->icon ?? 'fa-solid fa-star' }}" aria-hidden="true"></i>
                        </span>
                    </div>
                @endif
                <div class="svc-showcase-img-overlay" aria-hidden="true"></div>
                {{-- Forma decorativa sobre la imagen --}}
                <div class="svc-showcase-blob svc-showcase-blob--{{ $index % 4 }}" aria-hidden="true"></div>
            </div>
            
            {{-- Badge de icono flotante --}}
            @if($service->icon)
            <div class="svc-showcase-icon-badge" aria-hidden="true">
                <span><i class="{{ $service->icon }}"></i></span>
            </div>
            @endif
            
            {{-- Mini galería thumb --}}
            @if($service->gallery && count($service->gallery) > 0)
            <div class="svc-showcase-gallery-thumbs" aria-label="Vista previa de galería">
                @foreach(array_slice($service->gallery, 0, 3) as $thumb)
                <div class="svc-showcase-thumb">
                    <img src="{{ Storage::url($thumb) }}" alt="" loading="lazy" decoding="async" width="50" height="50">
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
                    <span class="svc-showcase-tag-line" aria-hidden="true"></span>
                    Servicio {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>
                
                <h3 class="svc-showcase-title">{{ $service->title }}</h3>
                
                <p class="svc-showcase-desc">{{ $service->short_description ?? Str::limit($service->description, 200) }}</p>

                @if($service->features && count($service->features) > 0)
                <ul class="svc-showcase-features" aria-label="Características incluidas">
                    @foreach(array_slice($service->features, 0, 4) as $feat)
                    <li class="svc-showcase-feature">
                        <span class="svc-showcase-feature-icon" aria-hidden="true">
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
                        <i class="fa-solid fa-gem" aria-hidden="true"></i>
                        {{ count($service->benefits) }} beneficios
                    </span>
                    @endif
                    @if($service->process_steps && count($service->process_steps) > 0)
                    <span class="svc-showcase-meta-badge">
                        <i class="fa-solid fa-shoe-prints" aria-hidden="true"></i>
                        {{ count($service->process_steps) }} pasos
                    </span>
                    @endif
                    @if($service->gallery && count($service->gallery) > 0)
                    <span class="svc-showcase-meta-badge">
                        <i class="fa-solid fa-images" aria-hidden="true"></i>
                        {{ count($service->gallery) }} fotos
                    </span>
                    @endif
                </div>

                <a href="{{ route('services.show', $service->slug) }}" class="svc-showcase-link" aria-label="Conocer más sobre {{ $service->title }}">
                    <span>Conocer más</span>
                    <span class="svc-showcase-link-arrow" aria-hidden="true">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </article>
    @empty
    <div class="svc-empty" role="status">
        <div class="svc-empty-icon" aria-hidden="true"><i class="fa-solid fa-layer-group"></i></div>
        <p>No hay servicios disponibles por el momento.</p>
    </div>
    @endforelse
</section>

{{-- ═══ PROCESO DE TRABAJO ═══ --}}
<section class="svc-process" aria-labelledby="svc-process-title">
    <div class="svc-process-header">
        <div class="svc-process-badge anim-scroll" data-anim="fade-up">Cómo trabajamos</div>
        <h2 id="svc-process-title" class="svc-process-title anim-scroll" data-anim="fade-up">
            Un proceso pensado para
            <span class="svc-hero-title-gradient">resultados</span>
        </h2>
        <p class="svc-process-sub anim-scroll" data-anim="fade-up">
            Cada proyecto sigue una metodología probada que asegura calidad y eficiencia.
        </p>
    </div>

    <div class="svc-process-timeline" role="list" aria-label="Pasos del proceso de trabajo">
        <div class="svc-process-line" aria-hidden="true">
            <div class="svc-process-line-fill" id="svcProcessLineFill"></div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up" role="listitem">
            <div class="svc-process-step-dot" aria-hidden="true">
                <span>01</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></div>
                <h3>Descubrimiento</h3>
                <p>Analizamos tu marca, mercado y objetivos para entender el contexto completo.</p>
            </div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up" role="listitem">
            <div class="svc-process-step-dot" aria-hidden="true">
                <span>02</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon" aria-hidden="true"><i class="fa-solid fa-compass-drafting"></i></div>
                <h3>Estrategia</h3>
                <p>Diseñamos un plan de acción con metas claras, KPIs y cronograma definido.</p>
            </div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up" role="listitem">
            <div class="svc-process-step-dot" aria-hidden="true">
                <span>03</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon" aria-hidden="true"><i class="fa-solid fa-pen-nib"></i></div>
                <h3>Creación</h3>
                <p>Nuestro equipo da vida a la visión con diseño, código y contenido de primer nivel.</p>
            </div>
        </div>

        <div class="svc-process-step anim-scroll" data-anim="fade-up" role="listitem">
            <div class="svc-process-step-dot" aria-hidden="true">
                <span>04</span>
            </div>
            <div class="svc-process-step-content">
                <div class="svc-process-step-icon" aria-hidden="true"><i class="fa-solid fa-rocket"></i></div>
                <h3>Lanzamiento</h3>
                <p>Implementamos, optimizamos y medimos para asegurar un impacto real y medible.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ MARQUEE DE TECNOLOGÍAS ═══ --}}
<section class="svc-marquee-section" aria-label="Áreas de especialización">
    <div class="svc-marquee">
        <div class="svc-marquee-track">
            @for($i = 0; $i < 2; $i++)
            <span class="svc-marquee-item">Branding</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">Estrategia digital</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">Desarrollo web</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">Social Media</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">SEO &amp; SEM</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">UI/UX Design</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">E-commerce</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            <span class="svc-marquee-item">Contenido</span>
            <span class="svc-marquee-dot" aria-hidden="true">✦</span>
            @endfor
        </div>
    </div>
</section>

{{-- ═══ CTA FINAL ═══ --}}
<section class="svc-cta" aria-labelledby="svc-cta-title">
    <div class="svc-cta-shapes" aria-hidden="true">
        <div class="svc-cta-shape svc-cta-shape--1"></div>
        <div class="svc-cta-shape svc-cta-shape--2"></div>
    </div>
    <div class="svc-cta-content anim-scroll" data-anim="fade-up">
        <div class="svc-cta-badge">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            ¿Listo para el siguiente paso?
        </div>
        <h2 id="svc-cta-title" class="svc-cta-title">
            Transformemos tu marca<br>
            <span class="svc-hero-title-gradient">juntos</span>
        </h2>
        <p class="svc-cta-text">
            Cuéntanos tu idea y diseñamos la estrategia perfecta para llevar tu negocio al siguiente nivel.
        </p>
        <div class="svc-cta-actions">
            <a href="{{ route('contact.index') }}" class="svc-cta-btn svc-cta-btn--primary">
                <span>Iniciar proyecto</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
            <a href="{{ route('projects.index') }}" class="svc-cta-btn svc-cta-btn--outline">
                <span>Ver portafolio</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

@endsection
