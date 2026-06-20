@extends('layouts.app')

@section('title', 'Blog - Ideas y Estrategias Digitales | CreativeUP')
@section('description', 'Descubre las últimas tendencias en diseño, marketing digital, branding y estrategias de crecimiento. Artículos escritos por expertos en creatividad digital.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/frontend/blog.css') }}?v={{ time() }}">
@endpush

@push('meta')
{{-- Open Graph --}}
<meta property="og:title" content="Blog - Ideas y Estrategias Digitales | CreativeUP">
<meta property="og:description" content="Descubre las últimas tendencias en diseño, marketing digital, branding y estrategias de crecimiento.">
<meta property="og:type" content="blog">
<meta property="og:url" content="{{ route('blog.index') }}">
<meta property="og:site_name" content="CreativeUP">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Blog - Ideas y Estrategias Digitales">
<meta name="twitter:description" content="Descubre las últimas tendencias en diseño, marketing digital y creatividad.">

{{-- Schema.org Blog --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Blog",
    "name": "CreativeUP Blog",
    "description": "Ideas, tendencias y estrategias de diseño y marketing digital",
    "url": "{{ route('blog.index') }}",
    "publisher": {
        "@@type": "Organization",
        "name": "CreativeUP",
        "url": "{{ url('/') }}"
    }
}
</script>
@endpush

@section('content')
<main class="bidx-page">

    <section class="bidx-hero" aria-labelledby="blog-hero-title">
        <div class="bidx-hero-shapes" aria-hidden="true">
            <div class="bidx-hero-shape bidx-hero-shape--1"></div>
            <div class="bidx-hero-shape bidx-hero-shape--2"></div>
            <div class="bidx-hero-shape bidx-hero-shape--3"></div>
        </div>
        <div class="bidx-hero-container">
            {{-- Hero Content --}}
            <div class="bidx-hero-content">
                <span class="bidx-hero-badge">
                    <i class="fa-solid fa-feather-pointed" aria-hidden="true"></i>
                    Conocimiento Creativo
                </span>

                <h1 id="blog-hero-title" class="bidx-hero-title">
                    Ideas, <span class="text-gradient">tendencias</span><br>
                    y estrategias
                </h1>

                <p class="bidx-hero-subtitle">
                    Exploramos el mundo del diseño, marketing digital y creatividad
                    para ayudarte a destacar en el entorno digital.
                </p>

                {{-- Stats --}}
                <div class="bidx-hero-stats">
                    <div class="bidx-hero-stat">
                        <div class="bidx-hero-stat-icon">
                            <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                        </div>
                        <div class="bidx-hero-stat-info">
                            <strong>{{ $posts->total() }}+</strong>
                            <span>Artículos</span>
                        </div>
                    </div>
                    <div class="bidx-hero-stat">
                        <div class="bidx-hero-stat-icon">
                            <i class="fa-solid fa-tags" aria-hidden="true"></i>
                        </div>
                        <div class="bidx-hero-stat-info">
                            <strong>4</strong>
                            <span>Categorías</span>
                        </div>
                    </div>
                    <div class="bidx-hero-stat">
                        <div class="bidx-hero-stat-icon">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                        </div>
                        <div class="bidx-hero-stat-info">
                            <strong>5 min</strong>
                            <span>Lectura promedio</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hero Visual --}}
            <div class="bidx-hero-visual" aria-hidden="true">
                <div class="bidx-hero-visual-grid">
                    <div class="bidx-hero-visual-card">
                        <i class="fa-solid fa-lightbulb"></i>
                        <span>Ideas</span>
                    </div>
                    <div class="bidx-hero-visual-card">
                        <i class="fa-solid fa-rocket"></i>
                        <span>Estrategia</span>
                    </div>
                    <div class="bidx-hero-visual-card">
                        <i class="fa-solid fa-palette"></i>
                        <span>Diseño</span>
                    </div>
                    <div class="bidx-hero-visual-card">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Growth</span>
                    </div>
                    <div class="bidx-hero-visual-card">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Marketing</span>
                    </div>
                    <div class="bidx-hero-visual-card">
                        <i class="fa-solid fa-code"></i>
                        <span>Web</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         CATEGORY FILTERS
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <nav class="bidx-filters" aria-label="Filtrar por categoría" data-ajax-filter data-ajax-nav>
        <div class="bidx-filters-container">
            <div class="bidx-filters-wrapper">
                <div class="bidx-filters-list" role="tablist">
                    <button type="button"
                       class="bidx-filter-btn {{ !request('category') ? 'active' : '' }}"
                       data-filter-button
                       data-filter-key="category"
                       data-filter-value=""
                       role="tab"
                       aria-selected="{{ !request('category') ? 'true' : 'false' }}">
                        <i class="fa-solid fa-border-all" aria-hidden="true"></i>
                        <span>Todos</span>
                    </button>
                    <button type="button"
                       class="bidx-filter-btn {{ request('category') === 'branding' ? 'active' : '' }}"
                       data-filter-button
                       data-filter-key="category"
                       data-filter-value="branding"
                       role="tab">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                        <span>Branding</span>
                    </button>
                    <button type="button"
                       class="bidx-filter-btn {{ request('category') === 'diseno' ? 'active' : '' }}"
                       data-filter-button
                       data-filter-key="category"
                       data-filter-value="diseno"
                       role="tab">
                        <i class="fa-solid fa-paintbrush" aria-hidden="true"></i>
                        <span>Diseño Web</span>
                    </button>
                    <button type="button"
                       class="bidx-filter-btn {{ request('category') === 'seo' ? 'active' : '' }}"
                       data-filter-button
                       data-filter-key="category"
                       data-filter-value="seo"
                       role="tab">
                        <i class="fa-solid fa-magnifying-glass-chart" aria-hidden="true"></i>
                        <span>SEO</span>
                    </button>
                    <button type="button"
                       class="bidx-filter-btn {{ request('category') === 'redes' ? 'active' : '' }}"
                       data-filter-button
                       data-filter-key="category"
                       data-filter-value="redes"
                       role="tab">
                        <i class="fa-solid fa-hashtag" aria-hidden="true"></i>
                        <span>Social Media</span>
                    </button>
                </div>

                <div class="bidx-search">
                    <i class="fa-solid fa-magnifying-glass bidx-search-icon" aria-hidden="true"></i>
                    <input type="search" 
                           name="search"
                           class="bidx-search-input" 
                           data-search-input
                           value="{{ request('search') }}"
                           placeholder="Buscar artículos..."
                           aria-label="Buscar artículos">
                </div>
            </div>
        </div>
    </nav>

    {{-- Results Container --}}
    {{-- Results Container --}}
    <div data-ajax-results class="bidx-results-container">
        @include('front.blog._posts-grid', ['animate' => true])
    </div>

    {{-- Pagination Premium --}}
    <div data-ajax-pagination>
        @if($posts->hasPages())
        <nav class="bidx-pagination-premium" aria-label="Paginación de artículos">
            {{ $posts->links() }}
        </nav>
        @endif
    </div>{{-- End data-ajax-results --}}

    {{-- ═══════════════════════════════════════════════════════════════════════════
         NEWSLETTER CTA
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="bidx-newsletter" aria-labelledby="newsletter-title">
        <div class="bidx-newsletter-container">
            <div class="bidx-newsletter-icon" aria-hidden="true">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>

            <h2 id="newsletter-title" class="bidx-newsletter-title">
                Mantente actualizado
            </h2>

            <p class="bidx-newsletter-text">
                Recibe las últimas tendencias, consejos y estrategias directamente en tu bandeja de entrada.
            </p>

            <form class="bidx-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                @csrf
                <input type="email"
                       name="email"
                       class="bidx-newsletter-input"
                       placeholder="tu@email.com"
                       required
                       aria-label="Tu correo electrónico">
                <button type="submit" class="bidx-newsletter-btn">
                    Suscribirse
                </button>
            </form>

            <p class="bidx-newsletter-privacy">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                Sin spam, solo contenido de valor. Cancela cuando quieras.
            </p>
        </div>
    </section>

</main>
@endsection
