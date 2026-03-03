@extends('admin.layouts.app')

@section('title', 'Servicios')
@section('page-title', 'Servicios')

@section('content')
<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h2>Todos los servicios ({{ $services->total() }})</h2>
        <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo servicio
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Slug</th>
                <th>Icono</th>
                <th>Estado</th>
                <th>Leads</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td><strong>{{ $service->title }}</strong></td>
                <td class="text-muted">{{ $service->slug }}</td>
                <td>{{ $service->icon ?? '—' }}</td>
                <td>
                    @if($service->is_active)
                        <span class="admin-badge admin-badge-green">Activo</span>
                    @else
                        <span class="admin-badge admin-badge-gray">Inactivo</span>
                    @endif
                </td>
                <td>{{ $service->leads_count ?? $service->leads()->count() }}</td>
                <td>
                    <div class="admin-actions-group">
                        <a href="{{ route('admin.services.edit', $service) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Editar</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('¿Eliminar este servicio?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty-message">No hay servicios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($services->hasPages())
        <div class="admin-pagination">{{ $services->links() }}</div>
    @endif
</div>
@endsection
