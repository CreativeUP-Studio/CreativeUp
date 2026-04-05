{{-- Blog Posts Grid Partial - For AJAX Loading --}}
@forelse($posts as $index => $post)
    @if($index === 0 && !request('page'))
    {{-- Featured Post (only on first page without page param) --}}
    <article class="bidx-featured-card">
        <a href="{{ route('blog.show', $post->slug) }}" class="bidx-featured-image" aria-hidden="true">
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}"
                     alt="{{ $post->title }}"
                     loading="eager"
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
                <span class="bidx-post-category cat-{{ strtolower(str_replace(' ', '', $post->category_label)) }}">
                    {{ $post->category_label }}
                </span>
                <span class="bidx-post-date">
                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                    <time datetime="{{ $post->published_at?->format('Y-m-d') }}">
                        {{ $post->published_at?->format('d M Y') ?? 'Sin fecha' }}
                    </time>
                </span>
                <span class="bidx-post-read-time">
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                    {{ $post->read_time }} min lectura
                </span>
            </div>

            <h3 class="bidx-featured-title">
                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
            </h3>

            <p class="bidx-featured-excerpt">
                {{ Str::limit(strip_tags($post->content), 200) }}
            </p>

            @if($post->user)
            <div class="bidx-featured-author">
                <div class="bidx-author-avatar">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <div class="bidx-author-info">
                    <strong>{{ $post->user->name }}</strong>
                    <span>Autor</span>
                </div>
            </div>
            @endif

            <a href="{{ route('blog.show', $post->slug) }}" class="bidx-featured-link">
                Leer artículo completo
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </article>
    @else
    {{-- Regular Post Card --}}
    <article class="bidx-post-card">
        <a href="{{ route('blog.show', $post->slug) }}" class="bidx-post-image">
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}"
                     alt="{{ $post->title }}"
                     loading="lazy"
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
    @endif
@empty
    <div class="ajax-no-results">
        <div class="ajax-no-results-icon">
            <i class="fa-solid fa-search"></i>
        </div>
        <h3 class="ajax-no-results-title">No se encontraron artículos</h3>
        <p class="ajax-no-results-text">
            Intenta con otros términos de búsqueda o explora todas las categorías.
        </p>
    </div>
@endforelse
