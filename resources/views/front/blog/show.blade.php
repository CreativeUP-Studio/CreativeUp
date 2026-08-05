@extends('layouts.app')

@section('title', $post->title . ' | Blog CreativeUP')
@section('description', Str::limit(strip_tags($post->content), 160))
@section('og_type', 'article')
@if($post->featured_image)
@section('og_image', asset('storage/' . $post->featured_image))
@endif

@push('styles')
<link rel="stylesheet" href="{{ asset('css/frontend/blog.css') }}?v={{ time() }}">
@endpush

@push('seo')
<meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
<meta property="article:author" content="{{ $post->user?->name ?? 'CreativeUP' }}">

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ e($post->title) }}",
    "description": "{{ e(Str::limit(strip_tags($post->content), 160)) }}",
    @if($post->featured_image)
    "image": "{{ asset('storage/' . $post->featured_image) }}",
    @endif
    "datePublished": "{{ $post->published_at?->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Person",
        "name": "{{ e($post->user?->name ?? 'CreativeUP Team') }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "CreativeUP",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo-icon.png') }}"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ route('blog.show', $post->slug) }}"
    }
}
</script>
@endpush

@section('content')
@php
    $postColor = '#ff006e';
    if(isset($post->category)) {
        $postColor = $post->category === 'branding' ? '#8b5cf6' : ($post->category === 'diseno' ? '#3b82f6' : ($post->category === 'seo' ? '#10b981' : '#f59e0b'));
    }
@endphp
{{-- fixed reading progress bar --}}
<div class="bshow-progress-bar" id="bshowProgressBar" style="--post-color: {{ $postColor ?? '#ff006e' }};"></div>

{{-- Hero Section with Split Layout --}}
<section class="bshow-hero" style="--post-color: {{ $postColor }};">
    @if($post->featured_image)
        <div class="bshow-hero-bg" aria-hidden="true">
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="">
        </div>
        <div class="bshow-hero-overlay" aria-hidden="true"></div>
    @endif
    
    <div class="bshow-hero-shapes" aria-hidden="true">
        <div class="bshow-hero-shape bshow-hero-shape--1"></div>
        <div class="bshow-hero-shape bshow-hero-shape--2"></div>
    </div>
    
    <div class="bshow-hero-content">
        <div class="bshow-hero-split">
            {{-- Columna izquierda: Información del Post --}}
            <div class="bshow-hero-info">
                {{-- Back Link --}}
                <a href="{{ route('blog.index') }}" class="bshow-back-link" data-aos="fade-right" data-aos-once="true">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Volver al blog</span>
                </a>

                {{-- Meta Info --}}
                <div class="bshow-hero-meta" data-aos="fade-up" data-aos-delay="50" data-aos-once="true">
                    <span class="bshow-hero-category cat-{{ strtolower(str_replace(' ', '', $post->category_label)) }}">
                        {{ $post->category_label }}
                    </span>
                    <span class="bshow-hero-separator">•</span>
                    <span class="bshow-hero-date">
                        <i class="fa-regular fa-calendar"></i>
                        <time datetime="{{ $post->published_at?->format('Y-m-d') }}">
                            {{ $post->published_at?->format('d M Y') ?? 'Sin fecha' }}
                        </time>
                    </span>
                    <span class="bshow-hero-separator">•</span>
                    <span class="bshow-hero-read-time">
                        <i class="fa-regular fa-clock"></i>
                        {{ $post->read_time }} min lectura
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="bshow-hero-title" itemprop="headline" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">{{ $post->title }}</h1>

                {{-- Author --}}
                @if($post->user)
                <div class="bshow-hero-author" data-aos="fade-up" data-aos-delay="150" data-aos-once="true">
                    <div class="bshow-hero-author-avatar">
                        @if($post->user->avatar)
                            <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}">
                        @else
                            <span class="bshow-avatar-initial">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="bshow-hero-author-info">
                        <span class="bshow-hero-author-label">Escrito por</span>
                        <strong class="bshow-hero-author-name">
                            @php
                                $nameParts = explode(' ', $post->user->name);
                                $shortName = $nameParts[0] . (isset($nameParts[1]) ? ' ' . $nameParts[1] : '');
                            @endphp
                            {{ $shortName }}
                            @if($post->user->position)
                                <span class="bshow-hero-author-position">| {{ $post->user->position }}</span>
                            @endif
                        </strong>
                    </div>
                </div>
                @endif
            </div>

            {{-- Columna derecha: Frame Visual Premium --}}
            <div class="bshow-hero-visual" data-aos="fade-left" data-aos-delay="200" data-aos-once="true">
                <div class="bshow-img-frame">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                    @else
                        <div class="bshow-img-placeholder">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                    @endif
                    {{-- Decoración esquina --}}
                    <div class="bshow-img-corner bshow-img-corner--tl" aria-hidden="true"></div>
                    <div class="bshow-img-corner bshow-img-corner--br" aria-hidden="true"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Article Content --}}
<article class="bshow-article" style="--post-color: {{ $postColor }};" itemscope itemtype="https://schema.org/BlogPosting">
    <div class="bshow-article-container">
        {{-- Main Content --}}
        <div class="bshow-article-content" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
            <div class="bshow-content-wrapper bshow-content" itemprop="articleBody">
                @if(Str::contains($post->content, ['<p>', '<h2>', '<h3>', '<div>', '<br>', '<img', '<iframe', '<video']))
                    {!! $post->content !!}
                @else
                    {!! nl2br(e($post->content)) !!}
                @endif
            </div>

            {{-- Share Section --}}
            <div class="bshow-share-section">
                <div class="bshow-share-header">
                    <h3 class="bshow-share-title">¿Te gustó este artículo?</h3>
                    <p class="bshow-share-subtitle">Compártelo con tu comunidad</p>
                </div>
                <div class="bshow-share-buttons">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-button bshow-share-twitter"
                       aria-label="Compartir en Twitter">
                        <i class="fa-brands fa-x-twitter"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-button bshow-share-facebook"
                       aria-label="Compartir en Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-button bshow-share-linkedin"
                       aria-label="Compartir en LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                        <span>LinkedIn</span>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . route('blog.show', $post->slug)) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-button bshow-share-whatsapp"
                       aria-label="Compartir en WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <button type="button" 
                            class="bshow-share-button bshow-share-copy" 
                            onclick="navigator.clipboard.writeText('{{ route('blog.show', $post->slug) }}'); this.innerHTML = '<i class=\'fa-solid fa-check\'></i><span>¡Copiado!</span>'; setTimeout(() => { this.innerHTML = '<i class=\'fa-solid fa-link\'></i><span>Copiar enlace</span>'; }, 2000);"
                            aria-label="Copiar enlace">
                        <i class="fa-solid fa-link"></i>
                        <span>Copiar enlace</span>
                    </button>
                </div>
            </div>

            {{-- Author Card --}}
            @if($post->user)
            <div class="bshow-author-card">
                <div class="bshow-author-card-avatar">
                    @if($post->user->avatar)
                        <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}">
                    @else
                        <span class="bshow-avatar-initial-large">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="bshow-author-card-content">
                    <span class="bshow-author-card-label">Sobre el autor</span>
                    <h4 class="bshow-author-card-name">
                        {{ $shortName }}
                        @if($post->user->position)
                            <span class="bshow-author-card-position">{{ $post->user->position }}</span>
                        @endif
                    </h4>
                    @if($post->user->bio)
                        <p class="bshow-author-card-bio">{{ $post->user->bio }}</p>
                    @else
                        <p class="bshow-author-card-bio">Experto en diseño y desarrollo digital, apasionado por crear experiencias únicas.</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="bshow-sidebar" data-aos="fade-left" data-aos-delay="200" data-aos-once="true">
            {{-- Table of Contents (Optional) --}}
            <div class="bshow-sidebar-card bshow-toc-card">
                <h3 class="bshow-sidebar-title">
                    <i class="fa-solid fa-list"></i>
                    En este artículo
                </h3>
                <div class="bshow-toc-content">
                    <p class="bshow-toc-placeholder">Generando índice...</p>
                </div>
            </div>

            {{-- Subscribe Card --}}
            <div class="bshow-sidebar-card bshow-subscribe-card">
                <h3 class="bshow-sidebar-title">
                    <i class="fa-solid fa-paper-plane"></i>
                    Boletín Semanal
                </h3>
                <p class="bshow-subscribe-text">Recibe las últimas novedades directamente en tu bandeja.</p>
                <form class="bshow-subscribe-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="tu@email.com" required aria-label="Tu email">
                    <button type="submit" class="bshow-subscribe-btn" style="--btn-color: {{ $postColor ?? '#ff006e' }};">
                        <span>Suscribirse</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            {{-- Share Sticky --}}
            <div class="bshow-sidebar-card bshow-share-sticky">
                <h3 class="bshow-sidebar-title">
                    <i class="fa-solid fa-share-nodes"></i>
                    Compartir
                </h3>
                <div class="bshow-share-sticky-buttons">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                       target="_blank"
                       class="bshow-share-sticky-btn bshow-share-twitter"
                       title="Compartir en Twitter">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                       target="_blank"
                       class="bshow-share-sticky-btn bshow-share-facebook"
                       title="Compartir en Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                       target="_blank"
                       class="bshow-share-sticky-btn bshow-share-linkedin"
                       title="Compartir en LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . route('blog.show', $post->slug)) }}"
                       target="_blank"
                       class="bshow-share-sticky-btn bshow-share-whatsapp"
                       title="Compartir en WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</article>

{{-- Related Posts --}}
@php
    $relatedPosts = \App\Models\Post::where('status', 'published')
        ->where('id', '!=', $post->id)
        ->with(['user:id,name,email,avatar,position'])
        ->latest('published_at')
        ->take(3)
        ->get();
@endphp

@if($relatedPosts->count() > 0)
<section class="bshow-related">
    <div class="bshow-related-container">
        <div class="bshow-related-header" data-aos="fade-up" data-aos-once="true">
            <h2 class="bshow-related-title">
                Artículos <span class="text-gradient">Relacionados</span>
            </h2>
            <p class="bshow-related-subtitle">Continúa explorando contenido relevante</p>
        </div>
        
        <div class="bshow-related-grid">
            @foreach($relatedPosts as $relatedPost)
            <article class="bshow-related-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" data-aos-once="true">
                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="bshow-related-link">
                    <div class="bshow-related-image">
                        @if($relatedPost->featured_image)
                            <img src="{{ asset('storage/' . $relatedPost->featured_image) }}"
                                 alt="{{ $relatedPost->title }}"
                                 loading="lazy">
                        @else
                            <div class="bshow-related-placeholder">
                                <i class="fa-solid fa-feather-pointed"></i>
                            </div>
                        @endif
                        <span class="bshow-related-category cat-{{ strtolower(str_replace(' ', '', $relatedPost->category_label)) }}">
                            {{ $relatedPost->category_label }}
                        </span>
                    </div>
                    <div class="bshow-related-content">
                        <div class="bshow-related-meta">
                            <span>{{ $relatedPost->published_at?->format('d M Y') }}</span>
                            <span>•</span>
                            <span>{{ $relatedPost->read_time }} min</span>
                        </div>
                        <h3 class="bshow-related-title-text">{{ $relatedPost->title }}</h3>
                        <div class="bshow-related-footer">
                            @if($relatedPost->user)
                            <div class="bshow-related-author">
                                <div class="bshow-related-avatar">
                                    @if($relatedPost->user->avatar)
                                        <img src="{{ asset('storage/' . $relatedPost->user->avatar) }}" alt="{{ $relatedPost->user->name }}">
                                    @else
                                        <span>{{ strtoupper(substr($relatedPost->user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <span class="bshow-related-author-name">
                                    @php
                                        $relatedNameParts = explode(' ', $relatedPost->user->name);
                                        $relatedShortName = $relatedNameParts[0] . (isset($relatedNameParts[1]) ? ' ' . $relatedNameParts[1] : '');
                                    @endphp
                                    {{ $relatedShortName }}
                                </span>
                            </div>
                            @endif
                            <span class="bshow-related-arrow">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Reading Progress Bar
    const progressBar = document.getElementById('bshowProgressBar');
    const article = document.querySelector('.bshow-article-content');
    
    if (progressBar && article) {
        window.addEventListener('scroll', () => {
            const articleRect = article.getBoundingClientRect();
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            
            let progress = 0;
            // Si el artículo ha entrado en la zona de scroll y no ha terminado
            if (articleRect.top < 0) {
                progress = (-articleRect.top / (articleHeight - windowHeight + 100)) * 100;
            }
            progress = Math.min(Math.max(progress, 0), 100);
            progressBar.style.width = `${progress}%`;
        });
    }

    // 2. Auto-Generate Table of Contents (TOC)
    const tocContent = document.querySelector('.bshow-toc-content');
    const contentBody = document.querySelector('.bshow-content-wrapper');
    
    if (tocContent && contentBody) {
        const headings = contentBody.querySelectorAll('h2, h3');
        
        if (headings.length > 0) {
            tocContent.innerHTML = '';
            const ul = document.createElement('ul');
            ul.className = 'bshow-toc-list';
            
            headings.forEach((heading, idx) => {
                if (!heading.id) {
                    heading.id = `heading-${idx}`;
                }
                
                const li = document.createElement('li');
                // Nivel indentación
                li.className = heading.tagName.toLowerCase() === 'h3' ? 'bshow-toc-item bshow-toc-item--h3' : 'bshow-toc-item';
                
                const a = document.createElement('a');
                a.href = `#${heading.id}`;
                a.className = 'bshow-toc-link';
                a.textContent = heading.textContent;
                
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetEl = document.getElementById(heading.id);
                    if (targetEl) {
                        const offset = 100;
                        const bodyRect = document.body.getBoundingClientRect().top;
                        const elementRect = targetEl.getBoundingClientRect().top;
                        const elementPosition = elementRect - bodyRect;
                        const offsetPosition = elementPosition - offset;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
                
                li.appendChild(a);
                ul.appendChild(li);
            });
            
            tocContent.appendChild(ul);
            
            // 3. ScrollSpy para TOC active highlights
            const tocLinks = ul.querySelectorAll('.bshow-toc-link');
            
            function updateActiveLink() {
                let currentActiveId = '';
                
                headings.forEach(heading => {
                    const rect = heading.getBoundingClientRect();
                    if (rect.top <= 140) {
                        currentActiveId = heading.id;
                    }
                });
                
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentActiveId}`) {
                        link.classList.add('active');
                    }
                });
            }
            
            window.addEventListener('scroll', updateActiveLink);
            updateActiveLink();
            
        } else {
            const tocCard = document.querySelector('.bshow-toc-card');
            if (tocCard) tocCard.style.display = 'none';
        }
    }

    // 4. Inject AOS animations into dynamically rendered editorial content blocks
    const contentElements = document.querySelectorAll('.bshow-content > p, .bshow-content > h2, .bshow-content > h3, .bshow-content > h4, .bshow-content > blockquote, .bshow-content > img, .bshow-content > iframe, .bshow-content > video, .bshow-content > table, .bshow-content > ul, .bshow-content > ol');
    contentElements.forEach((el, index) => {
        el.setAttribute('data-aos', 'fade-up');
        el.setAttribute('data-aos-delay', (index % 4) * 50); // staggered delay
        el.setAttribute('data-aos-once', 'true');
    });

    if (typeof AOS !== 'undefined') {
        AOS.init();
    }
});
</script>
@endpush
