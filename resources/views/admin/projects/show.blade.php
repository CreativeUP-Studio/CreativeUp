@extends('admin.layouts.app')

@section('title', 'Proyecto: ' . $project->title)
@section('page-title', 'Detalle del Proyecto')

@section('content')

{{-- Header con acciones rápidas --}}
<div class="ap-show-header">
    <div class="ap-show-header-left">
        <a href="{{ route('admin.projects.index') }}" class="ap-show-back">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver
        </a>
        <div class="ap-show-title-group">
            <h1 class="ap-show-title">{{ $project->title }}</h1>
            <div class="ap-show-title-meta">
                @if($project->status === 'published')
                    <span class="admin-badge admin-badge-green">Publicado</span>
                @else
                    <span class="admin-badge admin-badge-yellow">Borrador</span>
                @endif
                @if(!empty($project->type))
                    <span class="ap-show-type-badge">{{ $project->type }}</span>
                @endif
                <span class="ap-show-date">Creado {{ $project->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    <div class="ap-show-header-actions">
        @if($project->status === 'published')
            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Ver en sitio
            </a>
        @endif
        <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-primary admin-btn-sm">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('¿Eliminar este proyecto y todas sus imágenes?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Eliminar
            </button>
        </form>
    </div>
</div>

{{-- Stats Cards --}}
<div class="ap-show-stats">
    <div class="ap-show-stat-card">
        <div class="ap-show-stat-icon ap-show-stat-icon--purple">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="ap-show-stat-info">
            <span class="ap-show-stat-value">{{ $project->images->count() }}</span>
            <span class="ap-show-stat-label">Imágenes</span>
        </div>
    </div>
    <div class="ap-show-stat-card">
        <div class="ap-show-stat-icon ap-show-stat-icon--blue">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
        </div>
        <div class="ap-show-stat-info">
            <span class="ap-show-stat-value">{{ !empty($project->technologies) && is_array($project->technologies) ? count($project->technologies) : 0 }}</span>
            <span class="ap-show-stat-label">Tecnologías</span>
        </div>
    </div>
    <div class="ap-show-stat-card">
        <div class="ap-show-stat-icon ap-show-stat-icon--green">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="ap-show-stat-info">
            <span class="ap-show-stat-value">{{ collect([$project->challenge, $project->solution, $project->results])->filter()->count() }}/3</span>
            <span class="ap-show-stat-label">Caso de estudio</span>
        </div>
    </div>
    <div class="ap-show-stat-card">
        <div class="ap-show-stat-icon ap-show-stat-icon--orange">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="ap-show-stat-info">
            <span class="ap-show-stat-value">{{ $project->published_at ? $project->published_at->format('d/m/Y') : 'Sin fecha' }}</span>
            <span class="ap-show-stat-label">Publicación</span>
        </div>
    </div>
</div>

{{-- Grid de contenido --}}
<div class="ap-show-grid">

    {{-- Columna principal --}}
    <div class="ap-show-main">

        {{-- Preview de imagen principal --}}
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Imagen principal
                </h3>
            </div>
            <div class="ap-show-card-body">
                @if($project->thumbnail)
                    <div class="ap-show-main-img">
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}">
                    </div>
                @else
                    <div class="ap-show-empty-img">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p>Sin imagen principal</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Descripción --}}
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Descripción general
                </h3>
            </div>
            <div class="ap-show-card-body">
                <p class="ap-show-description">{{ $project->description }}</p>
            </div>
        </div>

        {{-- Caso de Estudio --}}
        @if(!empty($project->challenge) || !empty($project->solution) || !empty($project->results))
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Caso de estudio
                </h3>
            </div>
            <div class="ap-show-card-body">
                <div class="ap-show-casestudy">
                    @if(!empty($project->challenge))
                        <div class="ap-show-case-item">
                            <div class="ap-show-case-step">
                                <span class="ap-show-case-num">01</span>
                                <div class="ap-show-case-line"></div>
                            </div>
                            <div class="ap-show-case-content">
                                <h4 class="ap-show-case-label">El desafío</h4>
                                <p>{{ $project->challenge }}</p>
                            </div>
                        </div>
                    @endif
                    @if(!empty($project->solution))
                        <div class="ap-show-case-item">
                            <div class="ap-show-case-step">
                                <span class="ap-show-case-num">02</span>
                                <div class="ap-show-case-line"></div>
                            </div>
                            <div class="ap-show-case-content">
                                <h4 class="ap-show-case-label">La solución</h4>
                                <p>{{ $project->solution }}</p>
                            </div>
                        </div>
                    @endif
                    @if(!empty($project->results))
                        <div class="ap-show-case-item">
                            <div class="ap-show-case-step">
                                <span class="ap-show-case-num">03</span>
                            </div>
                            <div class="ap-show-case-content">
                                <h4 class="ap-show-case-label">Los resultados</h4>
                                <p>{{ $project->results }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Galería de imágenes --}}
        @if($project->images->count() > 0)
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Galería ({{ $project->images->count() }} imágenes)
                </h3>
            </div>
            <div class="ap-show-card-body">
                <div class="ap-show-gallery">
                    @foreach($project->images as $image)
                        <div class="ap-show-gallery-item">
                            <img src="{{ Storage::url($image->image_path) }}" alt="Imagen del proyecto">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- Sidebar --}}
    <div class="ap-show-sidebar">

        {{-- Información del proyecto --}}
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Información
                </h3>
            </div>
            <div class="ap-show-card-body">
                <div class="ap-show-info-list">
                    <div class="ap-show-info-item">
                        <span class="ap-show-info-label">Slug</span>
                        <span class="ap-show-info-value ap-show-info-mono">{{ $project->slug }}</span>
                    </div>
                    @if(!empty($project->client))
                        <div class="ap-show-info-item">
                            <span class="ap-show-info-label">Cliente</span>
                            <span class="ap-show-info-value">{{ $project->client }}</span>
                        </div>
                    @endif
                    @if(!empty($project->year))
                        <div class="ap-show-info-item">
                            <span class="ap-show-info-label">Año</span>
                            <span class="ap-show-info-value">{{ $project->year }}</span>
                        </div>
                    @endif
                    @if(!empty($project->type))
                        <div class="ap-show-info-item">
                            <span class="ap-show-info-label">Tipo</span>
                            <span class="ap-show-info-value">{{ $project->type }}</span>
                        </div>
                    @endif
                    <div class="ap-show-info-item">
                        <span class="ap-show-info-label">Estado</span>
                        <span class="ap-show-info-value">
                            @if($project->status === 'published')
                                <span class="admin-badge admin-badge-green">Publicado</span>
                            @else
                                <span class="admin-badge admin-badge-yellow">Borrador</span>
                            @endif
                        </span>
                    </div>
                    <div class="ap-show-info-item">
                        <span class="ap-show-info-label">Creado</span>
                        <span class="ap-show-info-value">{{ $project->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="ap-show-info-item">
                        <span class="ap-show-info-label">Actualizado</span>
                        <span class="ap-show-info-value">{{ $project->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($project->published_at)
                        <div class="ap-show-info-item">
                            <span class="ap-show-info-label">Publicado</span>
                            <span class="ap-show-info-value">{{ $project->published_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- URL del proyecto --}}
        @if($project->url)
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    Enlace externo
                </h3>
            </div>
            <div class="ap-show-card-body">
                <a href="{{ $project->url }}" target="_blank" rel="noopener" class="ap-show-url-link">
                    <span>{{ $project->url }}</span>
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
        @endif

        {{-- Tecnologías --}}
        @if(!empty($project->technologies) && is_array($project->technologies))
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    Tecnologías
                </h3>
            </div>
            <div class="ap-show-card-body">
                <div class="ap-show-tech-tags">
                    @foreach($project->technologies as $tech)
                        <span class="ap-show-tech-tag">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Completitud del proyecto --}}
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Completitud
                </h3>
            </div>
            <div class="ap-show-card-body">
                @php
                    $fields = [
                        'Título' => !empty($project->title),
                        'Descripción' => !empty($project->description),
                        'Imagen principal' => !empty($project->thumbnail),
                        'Cliente' => !empty($project->client),
                        'Año' => !empty($project->year),
                        'Tipo' => !empty($project->type),
                        'Desafío' => !empty($project->challenge),
                        'Solución' => !empty($project->solution),
                        'Resultados' => !empty($project->results),
                        'Tecnologías' => !empty($project->technologies),
                        'URL' => !empty($project->url),
                        'Galería' => $project->images->count() > 0,
                    ];
                    $completed = collect($fields)->filter()->count();
                    $total = count($fields);
                    $percent = round(($completed / $total) * 100);
                @endphp
                <div class="ap-show-progress-wrapper">
                    <div class="ap-show-progress-header">
                        <span>{{ $completed }}/{{ $total }} campos</span>
                        <span class="ap-show-progress-percent">{{ $percent }}%</span>
                    </div>
                    <div class="ap-show-progress-bar">
                        <div class="ap-show-progress-fill" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                <div class="ap-show-checklist">
                    @foreach($fields as $name => $filled)
                        <div class="ap-show-check-item {{ $filled ? 'ap-show-check-done' : '' }}">
                            @if($filled)
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                            @endif
                            <span>{{ $name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Acciones rápidas --}}
        <div class="ap-show-card">
            <div class="ap-show-card-header">
                <h3 class="ap-show-card-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Acciones rápidas
                </h3>
            </div>
            <div class="ap-show-card-body">
                <div class="ap-show-quick-actions">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="ap-show-action-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Editar proyecto
                    </a>
                    @if($project->status === 'published')
                        <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="ap-show-action-btn">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Vista pública
                        </a>
                    @endif
                    <a href="{{ route('admin.projects.create') }}" class="ap-show-action-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nuevo proyecto
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
