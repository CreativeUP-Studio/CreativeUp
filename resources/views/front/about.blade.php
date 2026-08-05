@extends('layouts.app')

@section('title', 'Sobre Nosotros | CreativeUP - El amanecer de una imagen profesional')
@section('description', 'Conoce a CreativeUP: el amanecer de una imagen profesional. Somos un equipo apasionado de creativos y desarrolladores dedicados a transformar negocios con tecnología y diseño premium.')

@push('styles')
<style>
    /* ── Service Cards con imagen ──────────────── */
    .svc-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .svc-card-item {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .svc-card-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(131,56,236,0.14);
        border-color: rgba(131,56,236,0.35);
    }

    /* Imagen */
    .svc-card-img-wrap {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #f8fafc;
        flex-shrink: 0;
    }
    .svc-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .svc-card-item:hover .svc-card-img {
        transform: scale(1.06);
    }

    /* Fallback sin imagen */
    .svc-card-img-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Overlay oscuro en hover */
    .svc-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(15,23,42,0.55) 100%);
        opacity: 0;
        transition: opacity 0.35s ease;
    }
    .svc-card-item:hover .svc-card-overlay {
        opacity: 1;
    }

    /* Cuerpo de texto */
    .svc-card-body {
        padding: 1.4rem 1.5rem 1.6rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .svc-card-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.5rem;
        line-height: 1.3;
    }
    .svc-card-desc {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.65;
        margin: 0 0 auto;
        padding-bottom: 1rem;
    }
    .svc-card-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ff006e, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: 0.25rem;
        transition: gap 0.2s ease;
    }
    .svc-card-item:hover .svc-card-link {
        gap: 0.65rem;
    }
    .svc-card-link i {
        background: linear-gradient(135deg, #ff006e, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ── Hero ─────────────────────────────── */
    .about-hero {
        padding: clamp(5rem, 10vw, 9rem) 1rem 4rem;
        background: linear-gradient(135deg, rgba(255, 0, 110, 0.05) 0%, rgba(131, 56, 236, 0.05) 100%);
        border-bottom: 1px solid var(--border-light, #e2e8f0);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 360px; height: 360px;
        background: radial-gradient(circle, rgba(131,56,236,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .about-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: -80px;
        width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(255,0,110,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .about-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1.1rem;
        background: rgba(131, 56, 236, 0.1);
        color: #8338ec;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(131, 56, 236, 0.2);
        letter-spacing: 0.3px;
    }
    .about-hero-title {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2.4rem, 5.5vw, 4rem);
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 1.25rem;
        letter-spacing: -1.5px;
    }
    .about-hero-title .gradient-word {
        background: linear-gradient(135deg, #ff006e, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .about-hero-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        max-width: 620px;
        margin: 0 auto 2rem;
        line-height: 1.7;
    }

    /* ── Stats Row ─────────────────────────── */
    .about-stats {
        display: flex;
        justify-content: center;
        gap: 2.5rem;
        flex-wrap: wrap;
        padding: 3rem 1rem;
    }
    .stat-item {
        text-align: center;
    }
    .stat-number {
        font-family: 'Poppins', sans-serif;
        font-size: 2.6rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ff006e, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.35rem;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    /* ── Section common ─────────────────────── */
    .about-section {
        padding: clamp(3rem, 6vw, 5rem) 1rem;
    }
    .about-section.bg-soft {
        background: linear-gradient(135deg, rgba(255,0,110,0.02), rgba(131,56,236,0.02));
    }
    .section-tag {
        display: inline-block;
        padding: 0.35rem 1rem;
        background: rgba(255,0,110,0.08);
        color: #ff006e;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
        border: 1px solid rgba(255,0,110,0.18);
    }
    .section-heading {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(1.8rem, 3.5vw, 2.6rem);
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.15;
        margin-bottom: 1rem;
    }
    .section-body {
        font-size: 1.05rem;
        color: #64748b;
        line-height: 1.75;
        max-width: 560px;
    }

    /* ── Mission / Vision cards ─────────────── */
    .mv-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 640px) { .mv-grid { grid-template-columns: 1fr; } }
    .mv-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .mv-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    }
    .mv-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ff006e, #8338ec);
    }
    .mv-card-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, rgba(255,0,110,0.1), rgba(131,56,236,0.1));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }
    .mv-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.75rem;
    }
    .mv-card p {
        font-size: 0.97rem;
        color: #64748b;
        line-height: 1.7;
        margin: 0;
    }

    /* ── Values ─────────────────────────────── */
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
    }
    .value-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.75rem 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .value-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 35px rgba(0,0,0,0.07);
        border-color: rgba(131,56,236,0.3);
    }
    .value-icon {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        display: block;
    }
    .value-card h4 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .value-card p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.65;
        margin: 0;
    }

    /* ── Team ───────────────────────────────── */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    .team-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.09);
    }
    .team-avatar {
        width: 72px; height: 72px;
        background: linear-gradient(135deg, #ff006e, #8338ec);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 800;
        color: #fff;
        margin: 0 auto 1rem;
        font-family: 'Poppins', sans-serif;
    }
    .team-name {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.2rem;
    }
    .team-role {
        font-size: 0.85rem;
        color: #8338ec;
        font-weight: 600;
    }

    /* ── CTA bottom ─────────────────────────── */
    .about-cta-block {
        background: linear-gradient(135deg, #ff006e, #8338ec);
        border-radius: 24px;
        padding: 3.5rem 2rem;
        text-align: center;
        color: #fff;
        margin: 0 1rem 4rem;
        position: relative;
        overflow: hidden;
    }
    .about-cta-block::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
        pointer-events: none;
    }
    .about-cta-block h3 {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 800;
        margin-bottom: 0.75rem;
    }
    .about-cta-block p {
        font-size: 1rem;
        opacity: 0.88;
        margin-bottom: 2rem;
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
    }
    .about-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fff;
        color: #8338ec;
        font-weight: 700;
        font-size: 1rem;
        padding: 0.85rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .about-cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        color: #ff006e;
    }
</style>
@endpush

@section('content')

{{-- ── HERO ──────────────────────────────────────────── --}}
<section class="about-hero">
    <div class="container">
        <div class="about-badge">
            <i class="fa-solid fa-sparkles"></i> Nuestro Equipo
        </div>
        <h1 class="about-hero-title">
            Somos <span class="gradient-word">CreativeUP</span><br>Studio
        </h1>
        <p class="about-hero-subtitle">
            Un equipo apasionado de creativos, desarrolladores y estrategas comprometidos con construir experiencias digitales que transforman negocios y conectan marcas con personas.
        </p>
        <a href="{{ route('contact.index') }}" class="btn btn-primary btn-rounded" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg,#ff006e,#8338ec); color:#fff; padding:0.85rem 2rem; border-radius:50px; font-weight:700; text-decoration:none; font-size:1rem; border:none;">
            <i class="fa-solid fa-rocket"></i> Trabajemos juntos
        </a>
    </div>
</section>

{{-- ── ESTADÍSTICAS ──────────────────────────────────── --}}
<div class="container">
    <div class="about-stats">
        <div class="stat-item" data-aos="fade-up" data-aos-delay="0" data-aos-once="true">
            <div class="stat-number">+{{ $projectsCount ?? 50 }}</div>
            <div class="stat-label">Proyectos Entregados</div>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
            <div class="stat-number">+30</div>
            <div class="stat-label">Clientes Satisfechos</div>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
            <div class="stat-number">5+</div>
            <div class="stat-label">Años de Experiencia</div>
        </div>
        <div class="stat-item" data-aos="fade-up" data-aos-delay="300" data-aos-once="true">
            <div class="stat-number">{{ $services->count() }}+</div>
            <div class="stat-label">Servicios Especializados</div>
        </div>
    </div>
</div>

{{-- ── NUESTRA HISTORIA ──────────────────────────────── --}}
<section class="about-section bg-soft">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center;" class="responsive-grid-2">
            <div data-aos="fade-right" data-aos-once="true">
                <span class="section-tag">Nuestra Historia</span>
                <h2 class="section-heading">Nacimos con el propósito de <em>crear</em></h2>
                <p class="section-body">
                    CreativeUP Studio nació de la visión de que cada negocio merece una presencia digital extraordinaria. Desde nuestros primeros proyectos, establecimos un estándar: no solo construimos páginas web o aplicaciones, construimos experiencias que conectan, convierten y perduran.
                </p>
                <p class="section-body" style="margin-top: 1rem;">
                    Hoy somos un equipo multidisciplinario que combina diseño UI/UX de clase mundial, desarrollo de software robusto, y estrategias de marketing digital orientadas a resultados reales.
                </p>
            </div>
            <div data-aos="fade-left" data-aos-once="true">
                <div class="mv-grid">
                    <div class="mv-card">
                        <div class="mv-card-icon">🎯</div>
                        <h3>Misión</h3>
                        <p>Impulsar el crecimiento de nuestros clientes a través de soluciones digitales innovadoras, funcionales y memorables.</p>
                    </div>
                    <div class="mv-card">
                        <div class="mv-card-icon">🌟</div>
                        <h3>Visión</h3>
                        <p>Ser el estudio digital de referencia en Latinoamérica, reconocido por la calidad, creatividad e impacto de cada proyecto.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── VALORES ───────────────────────────────────────── --}}
<section class="about-section">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <span class="section-tag">Lo que nos define</span>
            <h2 class="section-heading" style="max-width:500px; margin:0 auto;">Nuestros Valores</h2>
        </div>
        <div class="values-grid">
            @php
            $values = [
                ['icon'=>'🚀','title'=>'Innovación','desc'=>'Siempre buscamos soluciones que rompan con lo convencional y marquen tendencia en la industria.'],
                ['icon'=>'✨','title'=>'Excelencia','desc'=>'Cada píxel, cada línea de código y cada estrategia es ejecutada con los más altos estándares de calidad.'],
                ['icon'=>'🤝','title'=>'Compromiso','desc'=>'Nos involucramos en el éxito de cada cliente como si fuera nuestro propio negocio.'],
                ['icon'=>'🔍','title'=>'Transparencia','desc'=>'Comunicación honesta y directa en cada etapa del proyecto, sin sorpresas.'],
                ['icon'=>'⚡','title'=>'Eficiencia','desc'=>'Procesos ágiles que garantizan resultados de calidad en los tiempos acordados.'],
                ['icon'=>'🌍','title'=>'Impacto Real','desc'=>'Medimos nuestro éxito por el crecimiento y resultados concretos que logramos para nuestros clientes.'],
            ];
            @endphp
            @foreach($values as $i => $v)
            <div class="value-card" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}" data-aos-once="true">
                <span class="value-icon">{{ $v['icon'] }}</span>
                <h4>{{ $v['title'] }}</h4>
                <p>{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── SERVICIOS ─────────────────────────────────────── --}}
@if($services->isNotEmpty())
<section class="about-section bg-soft">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <span class="section-tag">¿En qué te ayudamos?</span>
            <h2 class="section-heading" style="max-width:500px; margin:0 auto;">Nuestras especialidades</h2>
        </div>
        <div class="svc-cards-grid">
            @foreach($services as $i => $service)
            <a href="{{ route('services.show', $service->slug) }}" class="svc-card-item" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}" data-aos-once="true">

                {{-- ── Imagen principal del servicio ── --}}
                <div class="svc-card-img-wrap">
                    @if($service->image)
                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->title }}"
                            class="svc-card-img"
                            loading="lazy"
                        >
                    @else
                        {{-- Fallback: gradiente con icono --}}
                        <div class="svc-card-img-fallback" style="background: linear-gradient(135deg, {{ $service->color ?? '#ff006e' }}22, {{ $service->color ?? '#8338ec' }}44);">
                            @if($service->icon && (str_contains($service->icon, 'fa-') || str_contains($service->icon, 'fas ') || str_contains($service->icon, 'fab ')))
                                <i class="{{ $service->icon }}" style="font-size: 3rem; background: linear-gradient(135deg, {{ $service->color ?? '#ff006e' }}, #8338ec); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>
                            @elseif($service->icon)
                                <span style="font-size: 3rem;">{{ $service->icon }}</span>
                            @else
                                <i class="fa-solid fa-star" style="font-size: 3rem; color: {{ $service->color ?? '#8338ec' }};"></i>
                            @endif
                        </div>
                    @endif
                    {{-- Overlay gradient al hacer hover --}}
                    <div class="svc-card-overlay"></div>
                </div>

                {{-- ── Info del servicio ── --}}
                <div class="svc-card-body">
                    <h3 class="svc-card-title">{{ $service->title }}</h3>
                    <p class="svc-card-desc">{{ Str::limit($service->short_description ?? strip_tags($service->description), 90) }}</p>
                    <span class="svc-card-link">
                        Ver servicio <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                    </span>
                </div>

            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CTA FINAL ─────────────────────────────────────── --}}
<div class="container" style="padding-bottom:4rem;">
    <div class="about-cta-block" data-aos="fade-up" data-aos-once="true">
        <h3>¿Listo para comenzar tu proyecto?</h3>
        <p>Cuéntanos tu idea y nuestro equipo te responderá en menos de 24 horas con una propuesta personalizada.</p>
        <a href="{{ route('contact.index') }}" class="about-cta-btn">
            <i class="fa-solid fa-paper-plane"></i> Iniciar Proyecto
        </a>
    </div>
</div>

@endsection
