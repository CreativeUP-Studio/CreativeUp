@extends('layouts.app')

@section('title', $post->title . ' | Blog CreativeUP')
@section('description', Str::limit(strip_tags($post->content), 160))

@push('meta')
{{-- Open Graph --}}
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('blog.show', $post->slug) }}">
@if($post->featured_image)
<meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
@endif
<meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
<meta property="article:author" content="{{ $post->user?->name ?? 'CreativeUP' }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
@if($post->featured_image)
<meta name="twitter:image" content="{{ asset('storage/' . $post->featured_image) }}">
@endif

{{-- Schema.org Article --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BlogPosting",
    "headline": "{{ $post->title }}",
    "description": "{{ Str::limit(strip_tags($post->content), 160) }}",
    @if($post->featured_image)
    "image": "{{ asset('storage/' . $post->featured_image) }}",
    @endif
    "datePublished": "{{ $post->published_at?->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "author": {
        "@@type": "Person",
        "name": "{{ $post->user?->name ?? 'CreativeUP' }}"
    },
    "publisher": {
        "@@type": "Organization",
        "name": "CreativeUP",
        "url": "{{ url('/') }}"
    },
    "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ route('blog.show', $post->slug) }}"
    }
}
</script>
@endpush

@section('content')
<article class="bshow-article" itemscope itemtype="https://schema.org/BlogPosting">
    <div class="bshow-container">
        {{-- Back Link --}}
        <a href="{{ route('blog.index') }}" class="bshow-back">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            Volver al blog
        </a>

        {{-- Header --}}
        <header class="bshow-header">
            <div class="bshow-meta">
                <span class="bshow-category cat-{{ strtolower(str_replace(' ', '', $post->category_label)) }}">
                    <i class="fa-solid fa-folder" aria-hidden="true"></i>
                    {{ $post->category_label }}
                </span>
                <span class="bshow-date">
                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                    <time datetime="{{ $post->published_at?->format('Y-m-d') }}" itemprop="datePublished">
                        {{ $post->published_at?->format('d M Y') ?? 'Sin fecha' }}
                    </time>
                </span>
                <span class="bshow-read-time">
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                    {{ $post->read_time }} min lectura
                </span>
            </div>

            <h1 class="bshow-title" itemprop="headline">{{ $post->title }}</h1>

            @if($post->user)
            <div class="bshow-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                <div class="bshow-author-avatar">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <div class="bshow-author-info">
                    <strong itemprop="name">{{ $post->user->name }}</strong>
                    <span>Autor</span>
                </div>
            </div>
            @endif
        </header>

        {{-- Featured Image --}}
        @if($post->featured_image)
        <figure class="bshow-image">
            <img src="{{ asset('storage/' . $post->featured_image) }}"
                 alt="{{ $post->title }}"
                 loading="eager"
                 decoding="async"
                 itemprop="image">
        </figure>
        @endif

        {{-- Content --}}
        <div class="bshow-content" itemprop="articleBody">
            {!! nl2br(e($post->content)) !!}
        </div>

        {{-- Footer with Share --}}
        <footer class="bshow-footer">
            <div class="bshow-share">
                <span class="bshow-share-label">Compartir artículo:</span>
                <div class="bshow-share-btns">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-btn"
                       aria-label="Compartir en Twitter">
                        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-btn"
                       aria-label="Compartir en Facebook">
                        <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-btn"
                       aria-label="Compartir en LinkedIn">
                        <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . route('blog.show', $post->slug)) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bshow-share-btn"
                       aria-label="Compartir en WhatsApp">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    </a>
                    <button type="button" 
                            class="bshow-share-btn" 
                            onclick="navigator.clipboard.writeText('{{ route('blog.show', $post->slug) }}'); alert('¡Enlace copiado!');"
                            aria-label="Copiar enlace">
                        <i class="fa-solid fa-link" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </footer>
    </div>
</article>

{{-- Related Posts --}}
@php
    $relatedPosts = \App\Models\Post::where('status', 'published')
        ->where('id', '!=', $post->id)
        ->latest('published_at')
        ->take(3)
        ->get();
@endphp

@if($relatedPosts->count() > 0)
<section class="bshow-related" aria-labelledby="related-title">
    <div class="bshow-related-container">
        <h2 id="related-title" class="bshow-related-title">
            También te puede interesar
        </h2>
        <div class="bshow-related-grid">
            @foreach($relatedPosts as $relatedPost)
            <article class="bidx-post-card">
                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="bidx-post-image">
                    @if($relatedPost->featured_image)
                        <img src="{{ asset('storage/' . $relatedPost->featured_image) }}"
                             alt="{{ $relatedPost->title }}"
                             loading="lazy"
                             decoding="async">
                    @else
                        <div class="bidx-post-image-placeholder">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                    @endif
                    <span class="bidx-post-category-badge cat-{{ strtolower(str_replace(' ', '', $relatedPost->category_label)) }}">
                        {{ $relatedPost->category_label }}
                    </span>
                </a>
                <div class="bidx-post-content">
                    <div class="bidx-post-meta">
                        <span>{{ $relatedPost->published_at?->format('d M Y') }}</span>
                        <span>{{ $relatedPost->read_time }} min</span>
                    </div>
                    <h3 class="bidx-post-title">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                    </h3>
                    <footer class="bidx-post-footer">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="bidx-post-link">
                            Leer más
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </footer>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
