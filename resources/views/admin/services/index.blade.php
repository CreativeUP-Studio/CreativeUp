@extends('admin.layouts.app')

@section('title', 'Servicios')
@section('page-title', 'Servicios')

@section('content')
<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h2>Todos los servicios ({{ $services->total() }})</h2>
        <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo servicio
        </a>
    </div>
    <div class="admin-table-scroll">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Descripción corta</th>
                <th>Contenido</th>
                <th>Estado</th>
                <th>Leads</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>
                    @if($service->image)
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="admin-thumb">
                    @else
                        <div class="admin-thumb-placeholder">
                            <i class="fa-solid fa-image" style="color:var(--admin-text-dim)"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $service->title }}</strong>
                    @if($service->icon)
                        <span style="margin-left:4px">{{ $service->icon }}</span>
                    @endif
                    <br><span class="text-muted">{{ $service->slug }}</span>
                    @if($service->order > 0)
                        <br><span class="admin-badge admin-badge-gray" style="font-size:10px">Orden: {{ $service->order }}</span>
                    @endif
                </td>
                <td style="max-width:200px">
                    <span class="text-muted">{{ Str::limit($service->short_description, 60) ?? '—' }}</span>
                </td>
                <td>
                    @if($service->features && count($service->features) > 0)
                        <span class="admin-badge admin-badge-purple">{{ count($service->features) }} feat.</span>
                    @endif
                    @if($service->gallery && count($service->gallery) > 0)
                        <span class="admin-badge admin-badge-blue">{{ count($service->gallery) }} img</span>
                    @endif
                    @if($service->benefits && count($service->benefits) > 0)
                        <span class="admin-badge admin-badge-green">{{ count($service->benefits) }} benef.</span>
                    @endif
                    @if($service->process_steps && count($service->process_steps) > 0)
                        <span class="admin-badge admin-badge-gray">{{ count($service->process_steps) }} pasos</span>
                    @endif
                    @if(!($service->features && count($service->features) > 0) && !($service->gallery && count($service->gallery) > 0))
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    @if($service->is_active)
                        <span class="admin-badge admin-badge-green">Activo</span>
                    @else
                        <span class="admin-badge admin-badge-gray">Inactivo</span>
                    @endif
                </td>
                <td>
                    @if($service->leads_count > 0)
                        <span class="admin-badge admin-badge-blue">{{ $service->leads_count }}</span>
                    @else
                        <span class="text-muted">0</span>
                    @endif
                </td>
                <td>
                    <div class="admin-actions-group">
                        <a href="{{ route('admin.services.edit', $service) }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('¿Eliminar este servicio?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="empty-message">No hay servicios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($services->hasPages())
        <div class="admin-pagination">{{ $services->links() }}</div>
    @endif
</div>
@endsection
