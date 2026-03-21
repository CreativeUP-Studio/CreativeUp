@extends('admin.layouts.app')

@section('title', 'Proyectos')
@section('page-title', 'Proyectos')

@section('content')
<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h2>Todos los proyectos ({{ $projects->total() }})</h2>
        <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo proyecto
        </a>
    </div>
    <div class="admin-table-scroll">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Slug</th>
                <th>Estado</th>
                <th>Imágenes</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>
                    @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="admin-thumb">
                    @else
                        <div class="admin-thumb-placeholder">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </td>
                <td><strong>{{ $project->title }}</strong></td>
                <td class="text-muted">{{ $project->slug }}</td>
                <td>
                    @if($project->status === 'published')
                        <span class="admin-badge admin-badge-green">Publicado</span>
                    @else
                        <span class="admin-badge admin-badge-yellow">Borrador</span>
                    @endif
                </td>
                <td>{{ $project->images->count() }}</td>
                <td>{{ $project->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="admin-actions-group">
                        <a href="{{ route('admin.projects.show', $project) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Ver</a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Editar</a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('¿Eliminar este proyecto y todas sus imágenes?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="empty-message">No hay proyectos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($projects->hasPages())
        <div class="admin-pagination">{{ $projects->links() }}</div>
    @endif
</div>
@endsection
