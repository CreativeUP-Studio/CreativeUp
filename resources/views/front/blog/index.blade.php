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
    <div data-ajax-results class="bidx-results-container">
    @if($posts->count() > 0)
        {{-- ═══════════════════════════════════════════════════════════════════════════
             POSTS GRID - ULTRA PREMIUM REDESIGN
             ═══════════════════════════════════════════════════════════════════════════ --}}
        @if($posts->count() > 0)
        <section class="bidx-posts-premium" aria-labelledby="posts-section-title">
            <div class="bidx-posts-container">
                <header class="bidx-section-header-premium">
                    <div class="bidx-header-content">
                        <span class="bidx-header-badge">
                            <span class="bidx-badge-dot"></span>
                            Contenido Destacado
                        </span>
                        <h2 id="posts-section-title" class="bidx-section-title-premium">
                            Explora Nuestros <span class="text-gradient">Artículos</span>
                        </h2>
                        <p class="bidx-section-subtitle">
                            Conocimiento experto en diseño, desarrollo y estrategia digital
                        </p>
                    </div>
                    <div class="bidx-header-stats">
                        <div class="bidx-stat-item">
                            <span class="bidx-stat-number">{{ $posts->total() }}</span>
                            <span class="bidx-stat-label">Artículos</span>
                        </div>
                        <div class="bidx-stat-divider"></div>
                        <div class="bidx-stat-item">
                            <span class="bidx-stat-number">{{ $posts->count() }}</span>
                            <span class="bidx-stat-label">Mostrando</span>
                        </div>
                    </div>
                </header>

                <div class="bidx-grid-premium">
                    @foreach($posts as $index => $post)
                    <article class="bidx-card-premium" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <a href="{{ route('blog.show', $post->slug) }}" class="bidx-card-link">
                            {{-- Image Container --}}
                            <div class="bidx-card-image-wrapper">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                                         alt="{{ $post->title }}"
                                         loading="lazy"
                                         decoding="async"
                                         class="bidx-card-image">
                                @else
                                    <div class="bidx-card-image-placeholder">
                                        <i class="fa-solid fa-feather-pointed"></i>
                                    </div>
                                @endif
                                
                                {{-- Gradient Overlay --}}
                                <div class="bidx-card-overlay"></div>
                                
                                {{-- Category Badge --}}
                                <span class="bidx-card-category cat-{{ strtolower(str_replace(' ', '', $post->category_label)) }}">
                                    {{ $post->category_label }}
                                </span>
                                
                                {{-- Hover Icon --}}
                                <div class="bidx-card-hover-icon">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>

                            {{-- Content Container --}}
                            <div class="bidx-card-body">
                                {{-- Meta Info --}}
                                <div class="bidx-card-meta">
                                    <span class="bidx-meta-item">
                                        <i class="fa-regular fa-calendar"></i>
                                        <time datetime="{{ $post->published_at?->format('Y-m-d') }}">
                                            {{ $post->published_at?->format('d M Y') ?? 'Sin fecha' }}
                                        </time>
                                    </span>
                                    <span class="bidx-meta-separator">•</span>
                                    <span class="bidx-meta-item">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $post->read_time }} min
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h3 class="bidx-card-title">
                                    {{ $post->title }}
                                </h3>

                                {{-- Excerpt --}}
                                <p class="bidx-card-excerpt">
                                    {{ Str::limit(strip_tags($post->content), 140) }}
                                </p>

                                {{-- Footer with Author --}}
                                <footer class="bidx-card-footer">
                                    @if($post->user)
                                    <div class="bidx-card-author">
                                        <div class="bidx-author-avatar-premium">
                                            @if($post->user->avatar)
                                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}">
                                            @else
                                                <span class="bidx-avatar-initial">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div class="bidx-author-details">
                                            <span class="bidx-author-name">
                                                @php
                                                    $nameParts = explode(' ', $post->user->name);
                                                    $shortName = $nameParts[0] . (isset($nameParts[1]) ? ' ' . $nameParts[1] : '');
                                                @endphp
                                                {{ $shortName }}
                                                @if($post->user->position)
                                                    | {{ $post->user->position }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="bidx-card-cta">
                                        <span class="bidx-cta-text">Leer más</span>
                                        <i class="fa-solid fa-arrow-right bidx-cta-arrow"></i>
                                    </div>
                                </footer>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination Premium --}}
                @if($posts->hasPages())
                <nav class="bidx-pagination-premium" aria-label="Paginación de artículos" data-ajax-pagination>
                    {{ $posts->links() }}
                </nav>
                @endif
            </div>
        </section>
        @endif

    @else
        {{-- ═══════════════════════════════════════════════════════════════════════════
             EMPTY STATE (No posts available)
             ═══════════════════════════════════════════════════════════════════════════ --}}
        <section class="bidx-empty" aria-labelledby="empty-title">
            <div class="bidx-empty-container">
                <div class="bidx-empty-icon">
                    <i class="fa-solid fa-inbox" aria-hidden="true"></i>
                </div>
                <h2 id="empty-title" class="bidx-empty-title">No hay publicaciones disponibles</h2>
                <p class="bidx-empty-text">
                    Estamos preparando contenido increíble para ti. ¡Vuelve pronto!
                </p>
            </div>
        </section>
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
