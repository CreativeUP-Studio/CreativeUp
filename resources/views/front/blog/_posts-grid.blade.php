{{-- Blog Posts Grid Partial - For AJAX Loading --}}
@if($posts->count() > 0)
<section class="bidx-posts-premium" aria-labelledby="posts-section-title" style="width: 100%;">
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
            <article class="bidx-card-premium" @if($animate ?? false) data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" @endif>
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
    </div>
</section>
@else
<section class="bidx-empty" aria-labelledby="empty-title" style="width: 100%;">
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
