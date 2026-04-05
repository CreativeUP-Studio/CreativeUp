@extends('layouts.app')

@section('title', 'Blog - Ideas y Estrategias Digitales | CreativeUP')
@section('description', 'Descubre las últimas tendencias en diseño, marketing digital, branding y estrategias de crecimiento. Artículos escritos por expertos en creatividad digital.')

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

    {{-- ═══════════════════════════════════════════════════════════════════════════
         HERO SECTION
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="bidx-hero" aria-labelledby="blog-hero-title">
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
             FEATURED POST
             ═══════════════════════════════════════════════════════════════════════════ --}}
        @php $featuredPost = $posts->first(); @endphp
        <section class="bidx-featured" aria-labelledby="featured-post-title">
            <div class="bidx-featured-container">
                <header class="bidx-section-header">
                    <h2 class="bidx-section-title">
                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                        Artículo Destacado
                    </h2>
                </header>

                <article class="bidx-featured-card">
                    <a href="{{ route('blog.show', $featuredPost->slug) }}" class="bidx-featured-image" aria-hidden="true">
                        @if($featuredPost->featured_image)
                            <img src="{{ asset('storage/' . $featuredPost->featured_image) }}"
                                 alt="{{ $featuredPost->title }}"
                                 loading="eager"
                                 decoding="async"
                                 width="700"
                                 height="420">
                        @else
                            <div class="bidx-featured-image-placeholder">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                        @endif
                        <span class="bidx-featured-badge">
                            <i class="fa-solid fa-fire" aria-hidden="true"></i>
                            Destacado
                        </span>
                    </a>

                    <div class="bidx-featured-content">
                        <div class="bidx-featured-meta">
                            <span class="bidx-post-category cat-{{ strtolower(str_replace(' ', '', $featuredPost->category_label)) }}">
                                {{ $featuredPost->category_label }}
                            </span>
                            <span class="bidx-post-date">
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                <time datetime="{{ $featuredPost->published_at?->format('Y-m-d') }}">
                                    {{ $featuredPost->published_at?->format('d M Y') ?? 'Sin fecha' }}
                                </time>
                            </span>
                            <span class="bidx-post-read-time">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                {{ $featuredPost->read_time }} min lectura
                            </span>
                        </div>

                        <h3 id="featured-post-title" class="bidx-featured-title">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}">{{ $featuredPost->title }}</a>
                        </h3>

                        <p class="bidx-featured-excerpt">
                            {{ Str::limit(strip_tags($featuredPost->content), 200) }}
                        </p>

                        @if($featuredPost->user)
                        <div class="bidx-featured-author">
                            <div class="bidx-author-avatar">
                                {{ strtoupper(substr($featuredPost->user->name, 0, 1)) }}
                            </div>
                            <div class="bidx-author-info">
                                <strong>{{ $featuredPost->user->name }}</strong>
                                <span>Autor</span>
                            </div>
                        </div>
                        @endif

                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="bidx-featured-link">
                            Leer artículo completo
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════════════════
             POSTS GRID
             ═══════════════════════════════════════════════════════════════════════════ --}}
        @if($posts->count() > 1)
        <section class="bidx-posts" aria-labelledby="posts-section-title">
            <div class="bidx-posts-container">
                <header class="bidx-section-header">
                    <h2 id="posts-section-title" class="bidx-section-title">
                        <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                        Últimos Artículos
                    </h2>
                </header>

                <div class="bidx-grid">
                    @foreach($posts->skip(1) as $post)
                    <article class="bidx-post-card">
                        <a href="{{ route('blog.show', $post->slug) }}" class="bidx-post-image">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}"
                                     alt="{{ $post->title }}"
                                     loading="lazy"
                                     decoding="async"
                                     width="400"
                                     height="250">
                            @else
                                <div class="bidx-post-image-placeholder">
                                    <i class="fa-solid fa-feather-pointed"></i>
                                </div>
                            @endif
                            <span class="bidx-post-category-badge cat-{{ strtolower(str_replace(' ', '', $post->category_label)) }}">
                                {{ $post->category_label }}
                            </span>
                            <div class="bidx-post-image-overlay"></div>
                        </a>

                        <div class="bidx-post-content">
                            <div class="bidx-post-meta">
                                <span>
                                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                    <time datetime="{{ $post->published_at?->format('Y-m-d') }}">
                                        {{ $post->published_at?->format('d M Y') ?? 'Sin fecha' }}
                                    </time>
                                </span>
                                <span>
                                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    {{ $post->read_time }} min
                                </span>
                            </div>

                            <h3 class="bidx-post-title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>

                            <p class="bidx-post-excerpt">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <footer class="bidx-post-footer">
                                @if($post->user)
                                <div class="bidx-post-author-small">
                                    <div class="bidx-post-author-avatar">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                    <span class="bidx-post-author-name">{{ $post->user->name }}</span>
                                </div>
                                @endif
                                <a href="{{ route('blog.show', $post->slug) }}" class="bidx-post-link">
                                    Leer más
                                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </footer>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($posts->hasPages())
                <nav class="bidx-pagination" aria-label="Paginación de artículos" data-ajax-pagination>
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

            <form class="bidx-newsletter-form" action="#" method="POST">
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
