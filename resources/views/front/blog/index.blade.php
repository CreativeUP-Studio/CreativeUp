@extends('layouts.app')

@section('title', 'Blog - Ideas y Estrategias Digitales')

@section('content')
<main class="bidx-page">

    {{-- ═══════════════════════════════════════════════════
         HERO SECTION
         ═══════════════════════════════════════════════════ --}}
    <section class="bidx-hero">
        {{-- Decoraciones de fondo --}}
        <div class="bidx-hero-decor">
            <div class="bidx-hero-orb bidx-hero-orb--1"></div>
            <div class="bidx-hero-orb bidx-hero-orb--2"></div>
            <div class="bidx-hero-line bidx-hero-line--1"></div>
            <div class="bidx-hero-line bidx-hero-line--2"></div>
        </div>

        <div class="bidx-hero-container">
            {{-- Contenido principal --}}
            <div class="bidx-hero-main">
                <div class="bidx-hero-badge anim-scroll" data-anim="fade-up">
                    <i class="fa-solid fa-feather-pointed"></i>
                    <span class="bidx-hero-badge-line"></span>
                    <span>Conocimiento creativo</span>
                </div>

                <h1 class="bidx-hero-title anim-scroll" data-anim="fade-up">
                    Ideas, <span class="bidx-hero-title-gradient">tendencias</span><br>
                    y estrategias
                </h1>

                <p class="bidx-hero-sub anim-scroll" data-anim="fade-up">
                    Exploramos el mundo del diseño, marketing digital y creatividad
                    para ayudarte a destacar en el entorno digital.
                </p>

                {{-- Stats --}}
                <div class="bidx-hero-stats anim-scroll" data-anim="fade-up">
                    <div class="bidx-hero-stat">
                        <span class="bidx-hero-stat-num">{{ $posts->total() }}+</span>
                        <span class="bidx-hero-stat-label">Artículos</span>
                    </div>
                    <span class="bidx-hero-stat-sep"></span>
                    <div class="bidx-hero-stat">
                        <span class="bidx-hero-stat-num">4</span>
                        <span class="bidx-hero-stat-label">Categorías</span>
                    </div>
                    <span class="bidx-hero-stat-sep">  </span>
                    <div class="bidx-hero-stat">
                        <span class="bidx-hero-stat-num">5min</span>
                        <span class="bidx-hero-stat-label">Lectura promedio</span>
                    </div>
                </div>
            </div>

            {{-- Visual decorativo --}}
            <div class="bidx-hero-visual anim-scroll" data-anim="fade-left">
                <div class="bidx-hero-visual-grid">
                    <div class="bidx-hero-visual-item">
                        <i class="fa-solid fa-lightbulb"></i>
                        <span>Ideas</span>
                    </div>
                    <div class="bidx-hero-visual-item">
                        <i class="fa-solid fa-rocket"></i>
                        <span>Estrategia</span>
                    </div>
                    <div class="bidx-hero-visual-item">
                        <i class="fa-solid fa-palette"></i>
                        <span>Diseño</span>
                    </div>
                    <div class="bidx-hero-visual-item">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Crecimiento</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtros de categoría --}}
        <nav class="bidx-filters anim-scroll" data-anim="fade-up">
            <a href="{{ route('blog.index') }}"
               class="bidx-filter {{ !request('category') ? 'is-active' : '' }}">
                Todos
            </a>
            <a href="{{ route('blog.index', ['category' => 'branding']) }}"
               class="bidx-filter {{ request('category') === 'branding' ? 'is-active' : '' }}">
                Branding
            </a>
            <a href="{{ route('blog.index', ['category' => 'diseno']) }}"
               class="bidx-filter {{ request('category') === 'diseno' ? 'is-active' : '' }}">
                Diseño Web
            </a>
            <a href="{{ route('blog.index', ['category' => 'seo']) }}"
               class="bidx-filter {{ request('category') === 'seo' ? 'is-active' : '' }}">
                SEO
            </a>
            <a href="{{ route('blog.index', ['category' => 'redes']) }}"
               class="bidx-filter {{ request('category') === 'redes' ? 'is-active' : '' }}">
                Social Media
            </a>
        </nav>
    </section>

    {{-- ═══════════════════════════════════════════════════
         POSTS SECTION
         ═══════════════════════════════════════════════════ --}}
    @if($posts->count() > 0)
    <section class="bidx-content">

        {{-- Post destacado (primer post) --}}
        @php $featuredPost = $posts->first(); @endphp
        <article class="bidx-featured anim-scroll" data-anim="fade-up">
            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="bidx-featured-link">
                <div class="bidx-featured-image">
                    @if($featuredPost->featured_image)
                        <img src="{{ asset('storage/' . $featuredPost->featured_image) }}"
                             alt="{{ $featuredPost->title }}"
                             loading="lazy"
                             decoding="async">
                    @else
                        <div class="bidx-featured-placeholder">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                    @endif
                    <span class="bidx-featured-tag">{{ $featuredPost->category_label }}</span>
                    <div class="bidx-featured-overlay">
                        <span class="bidx-featured-read">
                            <i class="fa-solid fa-book-open"></i>
                            <span>Leer artículo</span>
                        </span>
                    </div>
                </div>
                <div class="bidx-featured-body">
                    <div class="bidx-featured-meta">
                        <span class="bidx-featured-date">
                            <i class="fa-regular fa-calendar"></i>
                            {{ $featuredPost->published_at?->format('d M Y') ?? 'Sin fecha' }}
                        </span>
                        <span class="bidx-featured-time">
                            <i class="fa-regular fa-clock"></i>
                            {{ $featuredPost->read_time }} min lectura
                        </span>
                    </div>
                    <h2 class="bidx-featured-title">{{ $featuredPost->title }}</h2>
                    <p class="bidx-featured-excerpt">{{ Str::limit($featuredPost->excerpt, 200) }}</p>
                    <span class="bidx-featured-cta">
                        <span>Continuar leyendo</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </div>
            </a>
        </article>

        {{-- Grid de posts --}}
        @if($posts->count() > 1)
        <div class="bidx-grid">
            @foreach($posts->skip(1) as $post)
            <article class="bidx-card anim-scroll" data-anim="fade-up">
                <a href="{{ route('blog.show', $post->slug) }}" class="bidx-card-link">
                    <div class="bidx-card-image">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                 alt="{{ $post->title }}"
                                 loading="lazy"
                                 decoding="async">
                        @else
                            <div class="bidx-card-placeholder">
                                <i class="fa-solid fa-feather-pointed"></i>
                            </div>
                        @endif
                        <span class="bidx-card-tag">{{ $post->category_label }}</span>
                    </div>
                    <div class="bidx-card-body">
                        <div class="bidx-card-meta">
                            <span>{{ $post->published_at?->format('d M Y') ?? 'Sin fecha' }}</span>
                            <span class="bidx-card-meta-dot"></span>
                            <span>{{ $post->read_time }} min</span>
                        </div>
                        <h3 class="bidx-card-title">{{ $post->title }}</h3>
                        <p class="bidx-card-excerpt">{{ Str::limit($post->excerpt, 100) }}</p>
                        <span class="bidx-card-cta">
                            <span>Leer más</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
        @endif

        {{-- Paginación --}}
        @if($posts->hasPages())
        <div class="bidx-pagination">
            {{ $posts->links() }}
        </div>
        @endif

    </section>
    @else
    {{-- Estado vacío --}}
    <section class="bidx-empty">
        <div class="bidx-empty-icon">
            <i class="fa-solid fa-inbox fa-3x"></i>
        </div>
        <h3>No hay publicaciones disponibles</h3>
        <p>Estamos preparando contenido increíble para ti. ¡Vuelve pronto!</p>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════════
         NEWSLETTER CTA
         ═══════════════════════════════════════════════════ --}}
    <section class="bidx-newsletter anim-scroll" data-anim="fade-up">
        <div class="bidx-newsletter-inner">
            <div class="bidx-newsletter-content">
                <span class="bidx-newsletter-badge">
                    <i class="fa-solid fa-envelope"></i>
                    Newsletter
                </span>
                <h2 class="bidx-newsletter-title">Mantente actualizado</h2>
                <p class="bidx-newsletter-text">
                    Recibe las últimas tendencias, consejos y estrategias directamente en tu bandeja de entrada.
                </p>
            </div>
            <form class="bidx-newsletter-form" action="#" method="POST">
                @csrf
                <div class="bidx-newsletter-field">
                    <input type="email"
                           name="email"
                           placeholder="tu@email.com"
                           required
                           class="bidx-newsletter-input">
                    <button type="submit" class="bidx-newsletter-btn">
                        <span>Suscribirse</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
                <p class="bidx-newsletter-note">
                    <i class="fa-solid fa-shield-halved"></i>
                    Sin spam, solo contenido de valor. Cancela cuando quieras.
                </p>
            </form>
        </div>
    </section>

</main>
@endsection
