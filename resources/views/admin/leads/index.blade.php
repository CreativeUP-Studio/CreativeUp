@extends('admin.layouts.app')

@section('title', 'Leads')
@section('page-title', 'Gestión de Leads')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    /* Estilos personalizados para los avatares e indicadores de prioridad en Leads */
    .lead-card-priority-bar--high {
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
    }
    .lead-card-priority-bar--medium {
        background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
    }
    .lead-card-priority-bar--low {
        background: linear-gradient(90deg, #6366f1 0%, #8338ec 100%);
    }
    /* Insignias de estado y origen */
    .lead-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 30px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid transparent;
    }
    .lead-badge--new {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    .lead-badge--contacted {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.2);
    }
    .lead-badge--closed {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
        border-color: rgba(100, 116, 139, 0.2);
    }
    .lead-badge--web {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }
    .lead-badge--chat {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.2);
    }
    .lead-badge--newsletter {
        background: rgba(236, 72, 153, 0.1);
        color: #ec4899;
        border-color: rgba(236, 72, 153, 0.2);
    }
    /* Estilos del checkbox premium */
    .lead-checkbox-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .lead-checkbox-label {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: 2px solid rgba(255, 255, 255, 0.4);
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .lead-checkbox-label:hover {
        border-color: white;
        background: rgba(0, 0, 0, 0.4);
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    .lead-checkbox-input:checked + .lead-checkbox-label {
        background: white;
        border-color: white;
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(255, 255, 255, 0.4);
    }
    .lead-checkbox-icon {
        width: 16px;
        height: 16px;
        color: #ff006e;
        opacity: 0;
        transform: scale(0) rotate(-45deg);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .lead-checkbox-input:checked + .lead-checkbox-label .lead-checkbox-icon {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
    
    /* Efecto de selección en la tarjeta */
    .svc-card-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .lead-checkbox-input:checked ~ .svc-card-item,
    .svc-card-item:has(.lead-checkbox-input:checked) {
        box-shadow: 0 8px 32px rgba(255, 0, 110, 0.25);
        transform: translateY(-2px);
    }
    /* Animación de carga */
    .ajax-loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        font-size: 1.5rem;
        color: var(--primary-color);
        border-radius: 20px;
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. COMPACT PAGE HEADER
     ═══════════════════════════════════════════════════ --}}
<div class="svc-header" data-ajax-stats>
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-users" style="color: var(--primary-color);"></i>
                Leads CRM
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Leads Nuevos">
            <span class="svc-header-stat-lbl">Nuevos:</span>
            <span class="svc-header-stat-num text-success" data-stat="new">{{ $stats['new'] }}</span>
        </div>
        <div class="svc-header-stat-item" title="Leads en Proceso">
            <span class="svc-header-stat-lbl">En Proceso:</span>
            <span class="svc-header-stat-num text-warning" data-stat="contacted">{{ $stats['contacted'] }}</span>
        </div>
        <div class="svc-header-stat-item" title="Leads Cerrados">
            <span class="svc-header-stat-lbl">Cerrados:</span>
            <span class="svc-header-stat-num text-info" data-stat="closed">{{ $stats['closed'] }}</span>
        </div>
        <div class="svc-header-stat-item" title="Total Leads">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num" data-stat="total">{{ $stats['total'] }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     2. TOOLBAR (SEARCH, FILTERS & ACTION)
     ═══════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('admin.leads.index') }}" class="svc-toolbar" role="search" data-ajax-filter id="leadsFilterForm">
    <div style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap;">
        <input type="hidden" name="status" id="statusFilterHidden" data-filter-select value="{{ request('status') }}">
        
        <div class="svc-filters">
            <button type="button" class="svc-filter-pill {{ request('status') === '' || !request('status') ? 'active' : '' }}" onclick="setStatusFilter(this, '')">
                <i class="fa-solid fa-border-all"></i>
                <span>Todos</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'new' ? 'active' : '' }}" onclick="setStatusFilter(this, 'new')">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Nuevos</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'contacted' ? 'active' : '' }}" onclick="setStatusFilter(this, 'contacted')">
                <i class="fa-solid fa-circle-play"></i>
                <span>En Proceso</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'closed' ? 'active' : '' }}" onclick="setStatusFilter(this, 'closed')">
                <i class="fa-solid fa-circle-check"></i>
                <span>Cerrados</span>
            </button>
        </div>

        <div class="svc-search-box">
            <input type="text" class="svc-search-input" id="search-input" name="search" data-search-input value="{{ request('search') }}" placeholder="Buscar por nombre, email, teléfono..." autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
            <kbd class="svc-search-shortcut">/</kbd>
        </div>

        <div style="position: relative;">
            <select id="priority-filter" name="priority" class="admin-form-select" data-filter-select style="min-width: 150px; height: 38px; border-radius: 10px; border: 1px solid var(--admin-border); padding: 0 1rem; font-size: 0.825rem; font-weight: 600; background-color: #f1f5f9; color: var(--admin-text-secondary); cursor: pointer;">
                <option value="">Todas las prioridades</option>
                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>🔴 Alta</option>
                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>🟡 Media</option>
                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>⚪ Baja</option>
            </select>
        </div>

        <div style="position: relative;">
            <select id="source-filter" name="source" class="admin-form-select" data-filter-select style="min-width: 160px; height: 38px; border-radius: 10px; border: 1px solid var(--admin-border); padding: 0 1rem; font-size: 0.825rem; font-weight: 600; background-color: #f1f5f9; color: var(--admin-text-secondary); cursor: pointer;">
                <option value="">Todos los orígenes</option>
                <option value="contact" {{ request('source') === 'contact' ? 'selected' : '' }}>📧 Formulario web</option>
                <option value="chat" {{ request('source') === 'chat' ? 'selected' : '' }}>💬 Chat en vivo</option>
                <option value="newsletter" {{ request('source') === 'newsletter' ? 'selected' : '' }}>📰 Boletín / Suscripción</option>
            </select>
        </div>
    </div>

    <a href="{{ route('admin.leads.export', request()->query()) }}" class="admin-btn admin-btn-secondary" style="margin: 0; padding: 0.65rem 1.25rem; font-size: 0.85rem; border-radius: 10px; height: 38px; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-download"></i>
        <span>Exportar CSV</span>
    </a>
</form>

{{-- ═══════════════════════════════════════════════════
     3. BULK SELECTION BAR (Modern Sticky)
     ═══════════════════════════════════════════════════ --}}
<div class="leads-bulk-bar" id="bulkBar" style="display:none; position: sticky; top: 20px; z-index: 100; margin-bottom: 2rem; animation: bulkBarSlide 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
    <div style="background: linear-gradient(135deg, #ff006e 0%, #8338ec 100%); border-radius: 15px; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; box-shadow: 0 10px 30px rgba(255, 0, 110, 0.3); flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 1rem; color: white;">
            <input type="checkbox" id="selectAll" class="lead-checkbox-input">
            <label for="selectAll" class="lead-checkbox-label">
                <svg class="lead-checkbox-icon" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </label>
            <div>
                <span style="font-weight: 700; font-size: 1.05rem;"><strong id="bulkCount">0</strong> leads seleccionados</span>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <select id="bulkActionSelect" style="height: 38px; border-radius: 8px; border: none; padding: 0 1rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; outline: none; background: white; color: #1e293b;">
                <option value="">Selecciona una acción...</option>
                <option value="mark_contacted">✓ Marcar como contactados</option>
                <option value="mark_closed">✓✓ Marcar como cerrados</option>
                <option value="delete">🗑️ Eliminar seleccionados</option>
            </select>
            <button type="button" onclick="submitBulkAction()" class="admin-btn admin-btn-primary" id="bulkSubmitBtn" style="margin: 0; padding: 0 1.25rem; font-size: 0.85rem; height: 38px; border-radius: 8px; background: white; color: #ff006e; border: none; font-weight: 700;">
                <i class="fa-solid fa-check"></i>
                <span>Aplicar</span>
            </button>
            <button type="button" class="admin-btn admin-btn-secondary" style="margin: 0; width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: white;" onclick="document.querySelectorAll('.lead-check').forEach(c => c.checked = false); updateBulkBar();" title="Deseleccionar todos">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     4. LEADS GRID WITH AJAX
     ═══════════════════════════════════════════════════ --}}
<div data-ajax-results style="position: relative;">
    @include('admin.leads._leads-table')
</div>

{{-- Paginación --}}
<div style="margin-top: 2rem;" data-ajax-pagination>
    @if($leads->hasPages())
    <div class="admin-pagination">
        {{ $leads->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initLeadsModule();
});

function initLeadsModule() {
    initBulkSelection();
    initSearchShortcut();
    initBulkFormValidation();
    
    // A. status pill filters
    window.setStatusFilter = function(button, statusValue) {
        const pills = button.closest('.svc-filters').querySelectorAll('.svc-filter-pill');
        pills.forEach(p => p.classList.remove('active'));
        button.classList.add('active');
        
        const hiddenInput = document.getElementById('statusFilterHidden');
        if (hiddenInput) {
            hiddenInput.value = statusValue;
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    };
}

// ═══════════════════════════════════════════════════════════════════════════
// SEARCH KEYBOARD SHORTCUT (/)
// ═══════════════════════════════════════════════════════════════════════════
function initSearchShortcut() {
    const searchInput = document.querySelector('.svc-search-input');
    if (searchInput) {
        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement !== searchInput) {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// BULK FORM VALIDATION & CONFIRMATION
// ═══════════════════════════════════════════════════════════════════════════
function submitBulkAction() {
    const action = document.getElementById('bulkActionSelect').value;
    const checkedBoxes = document.querySelectorAll('.lead-check:checked');
    const checkedCount = checkedBoxes.length;
    
    if (!action) {
        alert('Por favor selecciona una acción a realizar.');
        return false;
    }
    
    if (checkedCount === 0) {
        alert('Por favor selecciona al menos un lead.');
        return false;
    }
    
    let confirmMessage = '';
    
    switch(action) {
        case 'mark_contacted':
            confirmMessage = `¿Marcar ${checkedCount} lead(s) como contactados?`;
            break;
        case 'mark_closed':
            confirmMessage = `¿Marcar ${checkedCount} lead(s) como cerrados?`;
            break;
        case 'delete':
            confirmMessage = `⚠️ ¿ELIMINAR PERMANENTEMENTE ${checkedCount} lead(s)?\n\nEsta acción no se puede deshacer.`;
            break;
    }
    
    if (confirm(confirmMessage)) {
        // Crear formulario dinámicamente
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/leads/bulk';
        
        // CSRF Token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfInput);
        
        // Acción
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'bulk_action';
        actionInput.value = action;
        form.appendChild(actionInput);
        
        // IDs de leads
        checkedBoxes.forEach(checkbox => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'lead_ids[]';
            idInput.value = checkbox.value;
            form.appendChild(idInput);
        });
        
        // Mostrar loading
        const submitBtn = document.getElementById('bulkSubmitBtn');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Procesando...</span>';
            submitBtn.disabled = true;
        }
        
        // Enviar formulario
        document.body.appendChild(form);
        form.submit();
    }
}

function initBulkFormValidation() {
    // Ya no necesitamos esto porque usamos submitBulkAction()
}

// ═══════════════════════════════════════════════════════════════════════════
// BULK SELECTION
// ═══════════════════════════════════════════════════════════════════════════
function initBulkSelection() {
    const selectAll = document.getElementById('selectAll');
    const bulkBar = document.getElementById('bulkBar');
    const bulkCount = document.getElementById('bulkCount');

    window.updateBulkBar = function() {
        const checked = document.querySelectorAll('.lead-check:checked').length;
        const total = document.querySelectorAll('.lead-check').length;
        
        if (bulkCount) bulkCount.textContent = checked;
        if (bulkBar) {
            if (checked > 0) {
                bulkBar.style.display = 'block';
                // Animación de entrada
                setTimeout(() => {
                    bulkBar.style.opacity = '1';
                    bulkBar.style.transform = 'translateY(0)';
                }, 10);
            } else {
                bulkBar.style.opacity = '0';
                bulkBar.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    bulkBar.style.display = 'none';
                }, 300);
            }
        }
        
        if (selectAll) {
            selectAll.checked = checked > 0 && checked === total;
            selectAll.indeterminate = checked > 0 && checked < total;
        }
    };

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.lead-check').forEach(c => c.checked = this.checked);
            window.updateBulkBar();
        });
    }

    // Bind checks
    document.querySelectorAll('.lead-check').forEach(c => {
        c.addEventListener('change', window.updateBulkBar);
    });
    
    // Re-bind after AJAX updates
    document.addEventListener('ajaxFilterUpdated', function() {
        setTimeout(() => {
            initBulkSelection();
        }, 100);
    });
}
</script>

<style>
@keyframes bulkBarSlide {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.leads-bulk-bar {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
</style>
@endpush
@endsection
