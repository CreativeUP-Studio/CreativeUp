{{-- Admin Projects Grid Partial - For AJAX Loading --}}
@forelse($projects as $project)
<article class="admin-post-card" role="listitem">
    {{-- Image --}}
    <div class="admin-post-card-image">
        @if($project->thumbnail)
            <img src="{{ asset('storage/' . $project->thumbnail) }}" 
                 alt="{{ $project->title }}"
                 loading="lazy">
        @else
            <div class="admin-post-card-placeholder" aria-label="Sin imagen">
                <i class="fa-solid fa-image" aria-hidden="true"></i>
            </div>
        @endif

        {{-- Status & Type badges --}}
        <div class="admin-post-card-badges">
            @if($project->status === 'published')
                <span class="admin-badge admin-badge-green">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    Publicado
                </span>
            @else
                <span class="admin-badge admin-badge-yellow">
                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                    Borrador
                </span>
            @endif
            @if($project->type)
                <span class="admin-badge admin-badge-blue">
                    <i class="fa-solid fa-tag" aria-hidden="true"></i>
                    {{ $project->type }}
                </span>
            @endif
        </div>
    </div>

    {{-- Content --}}
    <div class="admin-post-card-content">
        {{-- Meta info --}}
        <div class="admin-post-card-meta">
            <span class="admin-post-card-meta-item">
                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                <time datetime="{{ $project->published_at?->toIso8601String() ?? $project->created_at->toIso8601String() }}">
                    {{ $project->published_at?->format('d M Y') ?? $project->created_at->format('d M Y') }}
                </time>
            </span>
            @if($project->client)
            <span class="admin-post-card-meta-item">
                <i class="fa-regular fa-building" aria-hidden="true"></i>
                {{ $project->client }}
            </span>
            @endif
            @if($project->year)
            <span class="admin-post-card-meta-item">
                <i class="fa-regular fa-calendar-days" aria-hidden="true"></i>
                {{ $project->year }}
            </span>
            @endif
        </div>

        {{-- Title --}}
        <h2 class="admin-post-card-title">{{ $project->title }}</h2>

        {{-- Excerpt --}}
        <p class="admin-post-card-excerpt">{{ Str::limit($project->description, 100) }}</p>

        {{-- Technologies --}}
        @if($project->technologies && is_array($project->technologies) && count($project->technologies) > 0)
        <div class="admin-project-techs" role="list" aria-label="Tecnologías">
            @foreach(array_slice($project->technologies, 0, 3) as $tech)
                <span class="admin-project-tech" role="listitem">{{ $tech }}</span>
            @endforeach
            @if(count($project->technologies) > 3)
                <span class="admin-project-tech-more">+{{ count($project->technologies) - 3 }}</span>
            @endif
        </div>
        @endif

        {{-- Stats --}}
        <div class="admin-post-card-stats">
            <span class="admin-post-card-stat">
                <i class="fa-solid fa-images" aria-hidden="true"></i>
                {{ $project->images->count() }} imágenes
            </span>
            @if($project->url)
            <span class="admin-post-card-stat">
                <i class="fa-solid fa-link" aria-hidden="true"></i>
                URL disponible
            </span>
            @endif
        </div>

        {{-- Actions --}}
        <div class="admin-post-card-actions">
            <a href="{{ route('admin.projects.show', $project) }}"
               class="admin-btn admin-btn-secondary admin-btn-sm"
               title="Ver detalles"
               aria-label="Ver detalles de {{ $project->title }}">
                <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </a>
            <a href="{{ route('projects.show', $project->slug) }}"
               target="_blank"
               rel="noopener"
               class="admin-btn admin-btn-secondary admin-btn-sm"
               title="Vista previa"
               aria-label="Ver {{ $project->title }} en el sitio">
                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
            </a>
            <a href="{{ route('admin.projects.edit', $project) }}"
               class="admin-btn admin-btn-secondary admin-btn-sm"
               title="Editar"
               aria-label="Editar {{ $project->title }}">
                <i class="fa-solid fa-pen" aria-hidden="true"></i>
            </a>
            <form method="POST"
                  action="{{ route('admin.projects.destroy', $project) }}"
                  onsubmit="return confirm('¿Estás seguro de eliminar este proyecto y todas sus imágenes?')"
                  style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="admin-btn admin-btn-danger admin-btn-sm"
                        title="Eliminar"
                        aria-label="Eliminar {{ $project->title }}">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    </div>
</article>
@empty
<div class="ajax-no-results" style="grid-column: 1 / -1;">
    <div class="ajax-no-results-icon">
        <i class="fa-solid fa-folder-open"></i>
    </div>
    <h3 class="ajax-no-results-title">No se encontraron proyectos</h3>
    <p class="ajax-no-results-text">
        Intenta ajustar los filtros de búsqueda o crea un nuevo proyecto.
    </p>
</div>
@endforelse
