{{-- Admin Posts Grid Partial - For AJAX Loading --}}
@forelse($posts as $post)
<article class="admin-post-card">
    {{-- Image --}}
    <div class="admin-post-card-image">
        @if($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
        @else
            <div class="admin-post-card-placeholder">
                <i class="fa-solid fa-image"></i>
            </div>
        @endif

        {{-- Status badge --}}
        <div class="admin-post-card-badges">
            @if($post->status === 'published')
                <span class="admin-badge admin-badge-green">
                    <i class="fa-solid fa-check"></i>
                    Publicado
                </span>
            @else
                <span class="admin-badge admin-badge-yellow">
                    <i class="fa-solid fa-pen"></i>
                    Borrador
                </span>
            @endif
        </div>
    </div>

    {{-- Content --}}
    <div class="admin-post-card-content">
        {{-- Meta info --}}
        <div class="admin-post-card-meta">
            <span class="admin-post-card-meta-item">
                <i class="fa-regular fa-calendar"></i>
                {{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}
            </span>
            <span class="admin-post-card-meta-item">
                <i class="fa-regular fa-user"></i>
                {{ $post->user->name ?? 'Admin' }}
            </span>
            <span class="admin-post-card-meta-item">
                <i class="fa-regular fa-clock"></i>
                {{ $post->read_time }} min
            </span>
        </div>

        {{-- Title --}}
        <h3 class="admin-post-card-title">{{ $post->title }}</h3>

        {{-- Excerpt --}}
        <p class="admin-post-card-excerpt">{{ Str::limit($post->excerpt, 100) }}</p>

        {{-- Stats --}}
        <div class="admin-post-card-stats">
            <span class="admin-post-card-stat">
                <i class="fa-solid fa-text-width"></i>
                {{ str_word_count(strip_tags($post->content)) }} palabras
            </span>
        </div>

        {{-- Actions --}}
        <div class="admin-post-card-actions">
            <a href="{{ route('blog.show', $post->slug) }}"
               target="_blank"
               class="admin-btn admin-btn-secondary admin-btn-sm"
               title="Ver en el sitio">
                <i class="fa-solid fa-eye"></i>
            </a>
            <a href="{{ route('admin.posts.edit', $post) }}"
               class="admin-btn admin-btn-secondary admin-btn-sm"
               title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
            <form method="POST"
                  action="{{ route('admin.posts.destroy', $post) }}"
                  onsubmit="return confirm('¿Estás seguro de eliminar este post?')"
                  style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="admin-btn admin-btn-danger admin-btn-sm"
                        title="Eliminar">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
</article>
@empty
<div class="ajax-no-results" style="grid-column: 1 / -1;">
    <div class="ajax-no-results-icon">
        <i class="fa-solid fa-newspaper"></i>
    </div>
    <h3 class="ajax-no-results-title">No se encontraron posts</h3>
    <p class="ajax-no-results-text">
        Intenta ajustar los filtros de búsqueda o crea un nuevo post.
    </p>
</div>
@endforelse
