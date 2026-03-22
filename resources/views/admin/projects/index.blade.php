@extends('admin.layouts.app')

@section('title', 'Proyectos')
@section('page-title', 'Proyectos')

@section('content')

{{-- ═══════════════════════════════════════════════════
     HEADER & STATS
     ═══════════════════════════════════════════════════ --}}
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Gestión de Proyectos</h1>
        <p class="admin-page-subtitle">Administra tu portafolio de trabajos y casos de éxito</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Nuevo Proyecto</span>
        </a>
    </div>
</div>

{{-- Stats rápidas --}}
<div class="admin-posts-stats">
    <div class="admin-posts-stat">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05)); color: var(--admin-success);">
            <i class="fa-solid fa-check-circle"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Publicados</span>
            <span class="admin-posts-stat-value">{{ $projects->where('status', 'published')->count() }}</span>
        </div>
    </div>
    <div class="admin-posts-stat">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)); color: var(--admin-warning);">
            <i class="fa-solid fa-file-pen"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Borradores</span>
            <span class="admin-posts-stat-value">{{ $projects->where('status', 'draft')->count() }}</span>
        </div>
    </div>
    <div class="admin-posts-stat">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(124, 58, 237, 0.05)); color: var(--admin-primary);">
            <i class="fa-solid fa-diagram-project"></i>
        </div>
        <div class="admin-posts-stat-info">
            <span class="admin-posts-stat-label">Total Proyectos</span>
            <span class="admin-posts-stat-value">{{ $projects->total() }}</span>
        </div>
    </div>
    <div class="admin-posts-stat">
        <div class="admin-posts-stat-icon" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05)); color: var(--admin-info);">
            <i class="fa-solid fa-images"></i>
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
<form method="GET" action="{{ route('admin.projects.index') }}" class="admin-posts-filters">
    <div class="admin-filter-group">
        <label class="admin-filter-label">
            <i class="fa-solid fa-magnifying-glass"></i>
            Buscar
        </label>
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Buscar por título, cliente o descripción..."
               class="admin-form-input">
    </div>

    <div class="admin-filter-group">
        <label class="admin-filter-label">
            <i class="fa-solid fa-filter"></i>
            Estado
        </label>
        <select name="status" class="admin-form-select">
            <option value="">Todos los estados</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicados</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Borradores</option>
        </select>
    </div>

    <div class="admin-filter-group">
        <label class="admin-filter-label">
            <i class="fa-solid fa-tag"></i>
            Tipo
        </label>
        <select name="type" class="admin-form-select">
            <option value="">Todos los tipos</option>
            <option value="branding" {{ request('type') === 'branding' ? 'selected' : '' }}>Branding</option>
            <option value="web" {{ request('type') === 'web' ? 'selected' : '' }}>Diseño Web</option>
            <option value="marketing" {{ request('type') === 'marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="app" {{ request('type') === 'app' ? 'selected' : '' }}>App Design</option>
        </select>
    </div>

    <div class="admin-filter-group">
        <label class="admin-filter-label">
            <i class="fa-solid fa-calendar"></i>
            Ordenar por
        </label>
        <select name="sort" class="admin-form-select">
            <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>Más recientes</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguos</option>
            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Título A-Z</option>
        </select>
    </div>

    <div class="admin-filter-actions">
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
            <i class="fa-solid fa-search"></i>
            Filtrar
        </button>
        @if(request()->hasAny(['search', 'status', 'type', 'sort']))
        <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
            <i class="fa-solid fa-xmark"></i>
            Limpiar
        </a>
        @endif
    </div>
</form>

{{-- ═══════════════════════════════════════════════════
     PROJECTS GRID
     ═══════════════════════════════════════════════════ --}}
@if($projects->count() > 0)
<div class="admin-posts-grid">
    @foreach($projects as $project)
    <article class="admin-post-card">
        {{-- Image --}}
        <div class="admin-post-card-image">
            @if($project->thumbnail)
                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}">
            @else
                <div class="admin-post-card-placeholder">
                    <i class="fa-solid fa-image"></i>
                </div>
            @endif

            {{-- Status & Type badges --}}
            <div class="admin-post-card-badges">
                @if($project->status === 'published')
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
                @if($project->type)
                    <span class="admin-badge admin-badge-blue">
                        <i class="fa-solid fa-tag"></i>
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
                    <i class="fa-regular fa-calendar"></i>
                    {{ $project->published_at?->format('d M Y') ?? $project->created_at->format('d M Y') }}
                </span>
                @if($project->client)
                <span class="admin-post-card-meta-item">
                    <i class="fa-regular fa-building"></i>
                    {{ $project->client }}
                </span>
                @endif
                @if($project->year)
                <span class="admin-post-card-meta-item">
                    <i class="fa-regular fa-calendar-days"></i>
                    {{ $project->year }}
                </span>
                @endif
            </div>

            {{-- Title --}}
            <h3 class="admin-post-card-title">{{ $project->title }}</h3>

            {{-- Excerpt --}}
            <p class="admin-post-card-excerpt">{{ Str::limit($project->description, 100) }}</p>

            {{-- Technologies --}}
            @if($project->technologies && is_array($project->technologies) && count($project->technologies) > 0)
            <div class="admin-project-techs">
                @foreach(array_slice($project->technologies, 0, 3) as $tech)
                    <span class="admin-project-tech">{{ $tech }}</span>
                @endforeach
                @if(count($project->technologies) > 3)
                    <span class="admin-project-tech-more">+{{ count($project->technologies) - 3 }}</span>
                @endif
            </div>
            @endif

            {{-- Stats --}}
            <div class="admin-post-card-stats">
                <span class="admin-post-card-stat">
                    <i class="fa-solid fa-images"></i>
                    {{ $project->images->count() }} imágenes
                </span>
                @if($project->url)
                <span class="admin-post-card-stat">
                    <i class="fa-solid fa-link"></i>
                    URL disponible
                </span>
                @endif
            </div>

            {{-- Actions --}}
            <div class="admin-post-card-actions">
                <a href="{{ route('admin.projects.show', $project) }}"
                   class="admin-btn admin-btn-secondary admin-btn-sm"
                   title="Ver detalles">
                    <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('projects.show', $project->slug) }}"
                   target="_blank"
                   class="admin-btn admin-btn-secondary admin-btn-sm"
                   title="Vista previa">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
                <a href="{{ route('admin.projects.edit', $project) }}"
                   class="admin-btn admin-btn-secondary admin-btn-sm"
                   title="Editar">
                    <i class="fa-solid fa-pen"></i>
                </a>
                <form method="POST"
                      action="{{ route('admin.projects.destroy', $project) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar este proyecto y todas sus imágenes?')"
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
    @endforeach
</div>

{{-- Pagination --}}
@if($projects->hasPages())
<div class="admin-pagination">
    {{ $projects->appends(request()->query())->links() }}
</div>
@endif

@else
{{-- Empty state --}}
<div class="admin-empty-state">
    <div class="admin-empty-icon">
        <i class="fa-solid fa-diagram-project"></i>
    </div>
    <h3 class="admin-empty-title">
        @if(request()->hasAny(['search', 'status', 'type']))
            No se encontraron proyectos
        @else
            No hay proyectos aún
        @endif
    </h3>
    <p class="admin-empty-text">
        @if(request()->hasAny(['search', 'status', 'type']))
            Intenta ajustar tus filtros de búsqueda
        @else
            Comienza creando tu primer proyecto para mostrar en el portafolio
        @endif
    </p>
    @if(!request()->hasAny(['search', 'status', 'type']))
    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">
        <i class="fa-solid fa-plus"></i>
        Crear primer proyecto
    </a>
    @endif
</div>
@endif

@endsection
