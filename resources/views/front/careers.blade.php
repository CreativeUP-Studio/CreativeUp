@extends('layouts.app')

@section('title', 'Trabaja con Nosotros | Oportunidades Laborales CreativeUP')
@section('description', 'Únete al equipo de CreativeUP: el amanecer de una imagen profesional. Descubre vacantes abiertas para diseñadores, desarrolladores y especialistas en marketing digital.')

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Oportunidades Laborales en CreativeUP",
    "description": "Vacantes de empleo y carreras profesionales en CreativeUP Studio",
    "numberOfItems": {{ count($jobOffers) }},
    "itemListElement": [
        @foreach($jobOffers as $index => $job)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "item": {
                "@type": "JobPosting",
                "title": "{{ e($job->title) }}",
                "description": "{{ e(Str::limit(strip_tags($job->description), 200)) }}",
                "datePosted": "{{ $job->created_at ? $job->created_at->toIso8601String() : now()->toIso8601String() }}",
                "employmentType": "{{ e($job->type) }}",
                "hiringOrganization": {
                    "@type": "Organization",
                    "name": "CreativeUP",
                    "sameAs": "{{ url('/') }}",
                    "logo": "{{ asset('images/logo-icon.png') }}"
                },
                "jobLocation": {
                    "@type": "Place",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "{{ e($job->location) }}",
                        "addressCountry": "PE"
                    }
                }
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush

@push('styles')
<style>
    /* ── Hero ─────────────────────────────── */
    .careers-hero {
        padding: clamp(5rem, 10vw, 9rem) 1rem 4rem;
        background: linear-gradient(135deg, rgba(255, 0, 110, 0.05) 0%, rgba(131, 56, 236, 0.05) 100%);
        border-bottom: 1px solid var(--border-light, #e2e8f0);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .careers-hero::before {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(131,56,236,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .careers-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1.1rem;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .careers-hero-title {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2.4rem, 5.5vw, 4rem);
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 1.25rem;
        letter-spacing: -1.5px;
    }
    .careers-hero-title .gradient-word {
        background: linear-gradient(135deg, #ff006e, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .careers-hero-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        max-width: 620px;
        margin: 0 auto 2rem;
        line-height: 1.7;
    }

    /* ── Section ─────────────────────────── */
    .careers-section {
        padding: clamp(3rem, 6vw, 5rem) 1rem;
    }
    .careers-section.bg-soft {
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

    /* ── Benefits Grid ─────────────────────── */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
    }
    .benefit-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.75rem 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .benefit-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 35px rgba(0,0,0,0.07);
        border-color: rgba(131,56,236,0.3);
    }
    .benefit-icon {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        display: block;
    }
    .benefit-card h4 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .benefit-card p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.65;
        margin: 0;
    }

    /* ── Job Posts ─────────────────────────── */
    .job-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-top: 4px solid var(--job-color, #8338ec);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        flex-wrap: wrap;
    }
    .job-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px color-mix(in srgb, var(--job-color, #8338ec) 30%, transparent), 0 0 25px -5px color-mix(in srgb, var(--job-color, #8338ec) 20%, transparent);
        border-color: color-mix(in srgb, var(--job-color, #8338ec) 40%, transparent);
    }
    .job-card-left { flex: 1; }
    .job-tags { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.75rem; }
    .job-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .tag-area {
        background: color-mix(in srgb, var(--job-color, #8338ec) 10%, transparent);
        color: var(--job-color, #8338ec);
        border: 1px solid color-mix(in srgb, var(--job-color, #8338ec) 25%, transparent);
    }
    .tag-type { background:rgba(16,185,129,0.1); color:#10b981; border:1px solid rgba(16,185,129,0.25); }
    .tag-remote { background:rgba(255,0,110,0.1); color:#ff006e; border:1px solid rgba(255,0,110,0.25); }
    .job-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }
    .job-desc {
        font-size: 0.92rem;
        color: #64748b;
        margin: 0;
        line-height: 1.55;
    }
    .job-apply-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #ff006e, #8338ec);
        color: #fff;
        font-size: 0.9rem;
        font-weight: 700;
        padding: 0.7rem 1.4rem;
        border-radius: 50px;
        text-decoration: none;
        white-space: nowrap;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .job-apply-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(131,56,236,0.3);
        color: #fff;
    }

    /* ── Open Application ──────────────────── */
    .open-app-block {
        background: linear-gradient(135deg, #0f172a, #1e1b4b);
        border-radius: 24px;
        padding: 3.5rem 2rem;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: 2rem;
    }
    .open-app-block::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(131,56,236,0.2) 0%, transparent 70%);
        border-radius: 50%;
    }
    .open-app-block h3 {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 800;
        margin-bottom: 0.75rem;
    }
    .open-app-block p {
        font-size: 1rem;
        opacity: 0.75;
        margin-bottom: 2rem;
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .job-card { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')

{{-- ── HERO ──────────────────────────────────────────── --}}
<section class="careers-hero">
    <div class="container">
        <div class="careers-badge">
            <i class="fa-solid fa-circle" style="font-size:0.5rem; animation: pulse 2s infinite;"></i>
            Estamos contratando
        </div>
        <h1 class="careers-hero-title">
            Únete al equipo de<br><span class="gradient-word">CreativeUP Studio</span>
        </h1>
        <p class="careers-hero-subtitle">
            Buscamos talentos que compartan nuestra pasión por crear experiencias digitales extraordinarias. Si amas el diseño, el código o las estrategias que generan impacto real, tienes un lugar aquí.
        </p>
        <a href="#vacantes" class="btn" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg,#ff006e,#8338ec); color:#fff; padding:0.85rem 2rem; border-radius:50px; font-weight:700; text-decoration:none; font-size:1rem; border:none;">
            <i class="fa-solid fa-search"></i> Ver vacantes disponibles
        </a>
    </div>
</section>

{{-- ── BENEFICIOS ────────────────────────────────────── --}}
<section class="careers-section">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <span class="section-tag">¿Por qué CreativeUP?</span>
            <h2 class="section-heading" style="max-width:500px; margin:0 auto;">Lo que ofrecemos a nuestro equipo</h2>
        </div>
        <div class="benefits-grid">
            @php
            $benefits = [
                ['icon'=>'🏠','title'=>'Trabajo Remoto 100%','desc'=>'Trabaja desde donde te sientas más cómodo. Creemos en la flexibilidad y la autonomía como pilares del rendimiento.'],
                ['icon'=>'📈','title'=>'Crecimiento Acelerado','desc'=>'Acceso a proyectos de alto impacto que expandirán tu portafolio y habilidades de forma rápida y constante.'],
                ['icon'=>'🎓','title'=>'Aprendizaje Continuo','desc'=>'Presupuesto para cursos, conferencias y certificaciones. Invertimos en tu desarrollo profesional.'],
                ['icon'=>'🤝','title'=>'Ambiente Colaborativo','desc'=>'Trabajarás con personas talentosas y apasionadas en un entorno de respeto, diversidad e inclusión.'],
                ['icon'=>'💰','title'=>'Compensación Competitiva','desc'=>'Ofrecemos remuneraciones según el mercado, ajustadas regularmente y con bonificaciones por resultados.'],
                ['icon'=>'⚡','title'=>'Proyectos Emocionantes','desc'=>'Cada proyecto es único: desde startups innovadoras hasta grandes marcas regionales y multinacionales.'],
            ];
            @endphp
            @foreach($benefits as $i => $b)
            <div class="benefit-card" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}" data-aos-once="true">
                <span class="benefit-icon">{{ $b['icon'] }}</span>
                <h4>{{ $b['title'] }}</h4>
                <p>{{ $b['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── VACANTES ──────────────────────────────────────── --}}
<section class="careers-section bg-soft" id="vacantes">
    <div class="container">
        <div style="text-align:center; margin-bottom:3rem;">
            <span class="section-tag">Posiciones abiertas</span>
            <h2 class="section-heading" style="max-width:500px; margin:0 auto;">Vacantes disponibles</h2>
            <p style="color:#64748b; font-size:1rem; max-width:480px; margin:0 auto;">
                Todas las posiciones son remotas y abiertas para cualquier país de América Latina.
            </p>
        </div>

        @forelse($jobs as $i => $job)
        @php
            $areaConfig = [
                'Diseño'     => ['icon' => '🎨', 'color' => '#ff006e'],
                'Desarrollo' => ['icon' => '💻', 'color' => '#8338ec'],
                'Marketing'  => ['icon' => '📈', 'color' => '#3a0ca3'],
                'Gestión'    => ['icon' => '⚡', 'color' => '#10b981'],
                'Ventas'     => ['icon' => '💼', 'color' => '#f59e0b'],
                'Soporte'    => ['icon' => '🎧', 'color' => '#00b4d8'],
            ];
            $config    = $areaConfig[$job->area] ?? ['icon' => '💼', 'color' => '#8338ec'];
            $iconEmoji = $config['icon'];
            $jobColor  = $config['color'];
        @endphp
        <div class="job-card" style="--job-color: {{ $jobColor }};" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}" data-aos-once="true">
            <div class="job-card-left">
                <div class="job-tags">
                    <span class="job-tag tag-area">{{ $iconEmoji }} {{ $job->area }}</span>
                    <span class="job-tag tag-type"><i class="fa-regular fa-clock" style="font-size:0.7rem;"></i> {{ $job->type }}</span>
                    <span class="job-tag tag-remote"><i class="fa-solid fa-wifi" style="font-size:0.7rem;"></i> {{ $job->location }}</span>
                </div>
                <div class="job-title">{{ $job->title }}</div>
                <p class="job-desc">{{ $job->description }}</p>
                @if($job->requirements)
                <div style="font-size:0.85rem; color:#64748b; margin-top:0.6rem; padding: 0.6rem 0.9rem; background: rgba(0,0,0,0.02); border-left: 3px solid {{ $jobColor }}; border-radius: 0 8px 8px 0;">
                    <strong style="color: #0f172a;">Requisitos:</strong> {{ $job->requirements }}
                </div>
                @endif
            </div>
            <a href="{{ route('contact.index') }}?asunto=Postulacion+{{ urlencode($job->title) }}" class="job-apply-btn" style="background: linear-gradient(135deg, {{ $jobColor }}, #8338ec);">
                Aplicar <i class="fa-solid fa-arrow-right" style="font-size:0.8rem;"></i>
            </a>
        </div>
        @empty
        <div class="text-center py-5" style="background:#fff; border-radius:20px; border:1.5px solid #e2e8f0; padding:3rem 1.5rem;">
            <i class="fa-solid fa-briefcase mb-3" style="font-size: 2.5rem; color: #94a3b8;"></i>
            <h4 style="font-family: 'Poppins', sans-serif; font-weight:700; color:#0f172a;">No hay vacantes activas en este momento</h4>
            <p style="color:#64748b; max-width:450px; margin:0.5rem auto 0;">Pero siempre nos interesa conocer gente talentosa. Puedes enviarnos una postulación abierta a continuación.</p>
        </div>
        @endforelse

        {{-- Open application --}}
        <div class="open-app-block" data-aos="fade-up" data-aos-once="true">
            <h3>¿No ves tu perfil aquí?</h3>
            <p>Siempre estamos buscando talento excepcional. Envíanos tu CV y portafolio y te tendremos en cuenta para futuras posiciones.</p>
            <a href="{{ route('contact.index') }}" class="job-apply-btn" style="font-size:1rem; padding:0.85rem 2rem;">
                <i class="fa-solid fa-paper-plane"></i> Enviar postulación abierta
            </a>
        </div>
    </div>
</section>

@endsection
