@extends('admin.layouts.app')

@section('title', 'Leads')
@section('page-title', 'Leads / Contactos')

@section('content')
{{-- Stats Cards --}}
<div class="admin-stats">
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--purple">
            <i class="fa-solid fa-address-book"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Total</h3>
            <p>{{ $stats['total'] }}</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--emerald">
            <i class="fa-solid fa-sparkles"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Nuevos</h3>
            <p>{{ $stats['new'] }}</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--amber">
            <i class="fa-solid fa-phone-volume"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Contactados</h3>
            <p>{{ $stats['contacted'] }}</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--blue">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Cerrados</h3>
            <p>{{ $stats['closed'] }}</p>
        </div>
    </div>
</div>

{{-- Filtros --}}
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.leads.index') }}" class="admin-filter-bar">
        <input type="text" name="search" class="admin-form-control admin-search-input" placeholder="Buscar nombre, email, teléfono..."
               value="{{ request('search') }}">
        <select name="status" class="admin-form-control admin-filter-select">
            <option value="">Estado</option>
            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Nuevos</option>
            <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contactados</option>
            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Cerrados</option>
        </select>
        <select name="priority" class="admin-form-control admin-filter-select">
            <option value="">Prioridad</option>
            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Alta</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Media</option>
            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Baja</option>
        </select>
        <select name="source" class="admin-form-control admin-filter-select">
            <option value="">Origen</option>
            <option value="contact" {{ request('source') === 'contact' ? 'selected' : '' }}>Contacto</option>
            <option value="chat" {{ request('source') === 'chat' ? 'selected' : '' }}>Chat</option>
        </select>
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
            <i class="fa-solid fa-filter"></i> Filtrar
        </button>
        @if(request('search') || request('status') || request('priority') || request('source'))
            <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                <i class="fa-solid fa-xmark"></i> Limpiar
            </a>
        @endif
        <a href="{{ route('admin.leads.export', request()->query()) }}" class="admin-btn admin-btn-success admin-btn-sm" style="margin-left:auto">
            <i class="fa-solid fa-file-csv"></i> Exportar CSV
        </a>
    </form>
</div>

{{-- Bulk Actions + Table --}}
<form id="bulkForm" method="POST" action="{{ route('admin.leads.bulk') }}">
    @csrf
    {{-- Bulk action bar (hidden until selection) --}}
    <div class="admin-bulk-bar" id="bulkBar" style="display:none">
        <span class="admin-bulk-count"><span id="bulkCount">0</span> seleccionados</span>
        <select name="action" class="admin-form-control admin-filter-select" required>
            <option value="">Acción masiva...</option>
            <option value="mark_contacted">Marcar contactados</option>
            <option value="mark_closed">Marcar cerrados</option>
            <option value="delete">Eliminar seleccionados</option>
        </select>
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm" onclick="return confirm('¿Ejecutar acción masiva?')">
            <i class="fa-solid fa-bolt"></i> Aplicar
        </button>
    </div>

    <div class="admin-table-wrapper">
        <div class="admin-table-header">
            <h2>Leads ({{ $leads->total() }})</h2>
            @if($stats['unread'] > 0)
                <span class="admin-badge admin-badge-red"><i class="fa-solid fa-eye-slash"></i> {{ $stats['unread'] }} sin leer</span>
            @endif
        </div>
        <div class="admin-table-scroll">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px"><input type="checkbox" id="selectAll" class="admin-checkbox"></th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Servicio</th>
                    <th>Prioridad</th>
                    <th>Origen</th>
                    <th>Estado</th>
                    <th>Respuestas</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                <tr class="{{ !$lead->read_at ? 'admin-row-unread' : '' }}">
                    <td><input type="checkbox" name="lead_ids[]" value="{{ $lead->id }}" class="admin-checkbox lead-check"></td>
                    <td>
                        <div class="admin-lead-name">
                            @if(!$lead->read_at)
                                <span class="admin-unread-dot"></span>
                            @endif
                            <strong>{{ $lead->name }}</strong>
                        </div>
                    </td>
                    <td><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
                    <td>{{ $lead->service->title ?? '—' }}</td>
                    <td>
                        @if($lead->priority === 'high')
                            <span class="admin-badge admin-badge-red"><i class="fa-solid fa-arrow-up"></i> Alta</span>
                        @elseif($lead->priority === 'medium')
                            <span class="admin-badge admin-badge-yellow"><i class="fa-solid fa-minus"></i> Media</span>
                        @else
                            <span class="admin-badge admin-badge-gray"><i class="fa-solid fa-arrow-down"></i> Baja</span>
                        @endif
                    </td>
                    <td>
                        @if($lead->source === 'chat')
                            <span class="admin-badge admin-badge-purple"><i class="fa-solid fa-comment-dots"></i> Chat</span>
                        @else
                            <span class="admin-badge admin-badge-blue"><i class="fa-solid fa-envelope"></i> Contacto</span>
                        @endif
                    </td>
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
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                    <td>{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="admin-actions-group">
                            <a href="{{ route('admin.leads.show', $lead) }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('¿Eliminar este lead?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="empty-message">No hay leads registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        @if($leads->hasPages())
            <div class="admin-pagination">{{ $leads->appends(request()->query())->links() }}</div>
        @endif
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checks = document.querySelectorAll('.lead-check');
    const bulkBar = document.getElementById('bulkBar');
    const bulkCount = document.getElementById('bulkCount');

    function updateBulkBar() {
        const checked = document.querySelectorAll('.lead-check:checked').length;
        bulkCount.textContent = checked;
        bulkBar.style.display = checked > 0 ? 'flex' : 'none';
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checks.forEach(c => c.checked = this.checked);
            updateBulkBar();
        });
    }

    checks.forEach(c => c.addEventListener('change', updateBulkBar));
});
</script>
@endsection
