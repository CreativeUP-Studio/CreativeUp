@extends('admin.layouts.app')

@section('title', 'Leads')
@section('page-title', 'Leads / Contactos')

@section('content')
{{-- Filtros --}}
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.leads.index') }}" class="admin-filter-bar">
        <input type="text" name="search" class="admin-form-control admin-search-input" placeholder="Buscar por nombre, email o teléfono..."
               value="{{ request('search') }}">
        <select name="status" class="admin-form-control admin-filter-select">
            <option value="">Todos los estados</option>
            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Nuevos</option>
            <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contactados</option>
            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Cerrados</option>
        </select>
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Filtrar</button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Limpiar</a>
        @endif
    </form>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h2>Leads ({{ $leads->total() }})</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Servicio</th>
                <th>Estado</th>
                <th>Respuestas</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
            <tr>
                <td><strong>{{ $lead->name }}</strong></td>
                <td>
                    <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>
                </td>
                <td>{{ $lead->phone ?? '—' }}</td>
                <td>{{ $lead->service->title ?? '—' }}</td>
                <td>
                    @if($lead->status === 'new')
                        <span class="admin-badge admin-badge-green">Nuevo</span>
                    @elseif($lead->status === 'contacted')
                        <span class="admin-badge admin-badge-yellow">Contactado</span>
                    @else
                        <span class="admin-badge admin-badge-gray">Cerrado</span>
                    @endif
                </td>
                <td>
                    @if($lead->replies_count > 0)
                        <span class="admin-badge admin-badge-purple">{{ $lead->replies_count }}</span>
                    @else
                        <span style="color: rgba(255,255,255,0.3);">—</span>
                    @endif
                </td>
                <td>{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="admin-actions-group">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Ver</a>
                        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('¿Eliminar este lead?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="empty-message">No hay leads registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($leads->hasPages())
        <div class="admin-pagination">{{ $leads->links() }}</div>
    @endif
</div>
@endsection
