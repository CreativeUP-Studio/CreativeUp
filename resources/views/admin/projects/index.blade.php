@extends('admin.layouts.app')

@section('title', 'Proyectos')
@section('page-title', 'Proyectos')

@section('content')

{{-- ═══════════════════════════════════════════════════
     HEADER & STATS
     ═══════════════════════════════════════════════════ --}}
<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Gestión de Proyectos</h1>
        <p class="admin-page-subtitle">Administra tu portafolio de trabajos y casos de éxito</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            <span>Nuevo Proyecto</span>
        </a>
    </div>
</header>

{{-- Stats rápidas --}}
<div class="admin-posts-stats" role="list" aria-label="Estadísticas de proyectos">
    <div class="admin-posts-stat" role="listitem">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05)); color: var(--admin-success);">
            <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Publicados</span>
            <span class="admin-posts-stat-value">{{ $projects->where('status', 'published')->count() }}</span>
        </div>
    </div>
    <div class="admin-posts-stat" role="listitem">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)); color: var(--admin-warning);">
            <i class="fa-solid fa-file-pen" aria-hidden="true"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Borradores</span>
            <span class="admin-posts-stat-value">{{ $projects->where('status', 'draft')->count() }}</span>
        </div>
    </div>
    <div class="admin-posts-stat" role="listitem">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(124, 58, 237, 0.05)); color: var(--admin-primary);">
            <i class="fa-solid fa-diagram-project" aria-hidden="true"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Total Proyectos</span>
            <span class="admin-posts-stat-value">{{ $projects->total() }}</span>
        </div>
    </div>
    <div class="admin-posts-stat" role="listitem">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05)); color: var(--admin-info);">
            <i class="fa-solid fa-images" aria-hidden="true"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Total Imágenes</span>
            <span class="admin-posts-stat-value">{{ $projects->sum(fn($p) => $p->images->count()) }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     FILTERS & SEARCH
     ═══════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('admin.projects.index') }}" class="admin-posts-filters" role="search" data-ajax-filter>
    <div class="admin-filter-group">
        <label for="search-input" class="admin-filter-label">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            Buscar
        </label>
        <input type="text"
               id="search-input"
               name="search"
               value="{{ request('search') }}"
               placeholder="Buscar por título, cliente o descripción..."
               class="admin-form-input"
               data-search-input>
    </div>

    <div class="admin-filter-group">
        <label for="status-filter" class="admin-filter-label">
            <i class="fa-solid fa-filter" aria-hidden="true"></i>
            Estado
        </label>
        <select id="status-filter" name="status" class="admin-form-select" data-filter-select>
            <option value="">Todos los estados</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicados</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Borradores</option>
        </select>
    </div>

    <div class="admin-filter-group">
        <label for="type-filter" class="admin-filter-label">
            <i class="fa-solid fa-tag" aria-hidden="true"></i>
            Tipo
        </label>
        <select id="type-filter" name="type" class="admin-form-select" data-filter-select>
            <option value="">Todos los tipos</option>
            @if(isset($types))
                @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            @else
            <option value="branding" {{ request('type') === 'branding' ? 'selected' : '' }}>Branding</option>
            <option value="web" {{ request('type') === 'web' ? 'selected' : '' }}>Diseño Web</option>
            <option value="marketing" {{ request('type') === 'marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="app" {{ request('type') === 'app' ? 'selected' : '' }}>App Design</option>
            @endif
        </select>
    </div>

    <div class="admin-filter-group">
        <label for="sort-filter" class="admin-filter-label">
            <i class="fa-solid fa-calendar" aria-hidden="true"></i>
            Ordenar por
        </label>
        <select id="sort-filter" name="sort" class="admin-form-select" data-filter-select>
            <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>Más recientes</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguos</option>
            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Título A-Z</option>
        </select>
    </div>

    <div class="admin-filter-actions">
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
            <i class="fa-solid fa-search" aria-hidden="true"></i>
            Filtrar
        </button>
        @if(request()->hasAny(['search', 'status', 'type', 'sort']))
        <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" data-filter-clear>
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            Limpiar
        </button>
        @endif
    </div>
</form>

{{-- ═══════════════════════════════════════════════════
     PROJECTS GRID
     ═══════════════════════════════════════════════════ --}}
<div data-ajax-results>
@if($projects->count() > 0)
<div class="admin-posts-grid" role="list">
    @foreach($projects as $project)
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
    @endforeach
</div>

{{-- Pagination --}}
@if($projects->hasPages())
<nav class="admin-pagination" aria-label="Paginación de proyectos" data-ajax-pagination>
    {{ $projects->appends(request()->query())->links() }}
</nav>
@endif

@else
{{-- Empty state --}}
<div class="admin-empty-state" role="status">
    <div class="admin-empty-icon" aria-hidden="true">
        <i class="fa-solid fa-diagram-project"></i>
    </div>
    <h2 class="admin-empty-title">
        @if(request()->hasAny(['search', 'status', 'type']))
            No se encontraron proyectos
        @else
            No hay proyectos aún
        @endif
    </h2>
    <p class="admin-empty-text">
        @if(request()->hasAny(['search', 'status', 'type']))
            Intenta ajustar tus filtros de búsqueda
        @else
            Comienza creando tu primer proyecto para mostrar en el portafolio
        @endif
    </p>
    @if(!request()->hasAny(['search', 'status', 'type']))
    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">
        <i class="fa-solid fa-plus" aria-hidden="true"></i>
        Crear primer proyecto
    </a>
    @endif
</div>
@endif
</div>{{-- End data-ajax-results --}}

@endsection
