@extends('admin.layouts.app')

@section('title', 'Leads')
@section('page-title', 'Gestión de Leads')

@section('content')
{{-- ═══════════════════════════════════════════════════════════════════════════
     HERO HEADER - PREMIUM DESIGN
     ═══════════════════════════════════════════════════════════════════════════ --}}
<div class="leads-hero">
    <div class="leads-hero-background">
        <div class="leads-hero-gradient"></div>
        <div class="leads-hero-pattern"></div>
    </div>
    
    <div class="leads-hero-content">
        <div class="leads-hero-text">
            <div class="leads-hero-badge">
                <i class="fa-solid fa-sparkles"></i>
                <span>Panel de Control</span>
            </div>
            <h1 class="leads-hero-title">
                Gestión de Leads
            </h1>
            <p class="leads-hero-subtitle">
                Administra, responde y convierte tus contactos en clientes potenciales
            </p>
        </div>
        
        <div class="leads-hero-actions">
            <a href="{{ route('admin.leads.export', request()->query()) }}" 
               class="leads-hero-btn leads-hero-btn--export">
                <i class="fa-solid fa-download"></i>
                <span>Exportar Datos</span>
            </a>
            <button class="leads-hero-btn leads-hero-btn--refresh" onclick="location.reload()">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span>Actualizar</span>
            </button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════════
     STATS DASHBOARD - PREMIUM CARDS
     ═══════════════════════════════════════════════════════════════════════════ --}}
<div class="leads-stats-dashboard">
    <div class="leads-stat-card leads-stat-card--purple" data-aos="fade-up" data-aos-delay="0">
        <div class="leads-stat-card-bg">
            <div class="leads-stat-card-circle leads-stat-card-circle-1"></div>
            <div class="leads-stat-card-circle leads-stat-card-circle-2"></div>
        </div>
        <div class="leads-stat-card-icon">
            <div class="leads-stat-card-icon-inner">
                <i class="fa-solid fa-address-book"></i>
            </div>
        </div>
        <div class="leads-stat-card-content">
            <span class="leads-stat-card-label">Total de Leads</span>
            <div class="leads-stat-card-value-wrapper">
                <span class="leads-stat-card-value" data-count="{{ $stats['total'] }}">0</span>
                <span class="leads-stat-card-change leads-stat-card-change--up">
                    <i class="fa-solid fa-arrow-up"></i>
                    <span>100%</span>
                </span>
            </div>
            <p class="leads-stat-card-description">Contactos totales registrados</p>
        </div>
        <div class="leads-stat-card-decoration">
            <svg viewBox="0 0 200 60" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 30 Q 50 10, 100 30 T 200 30" stroke="currentColor" stroke-width="2" fill="none" opacity="0.2"/>
            </svg>
        </div>
    </div>

    <div class="leads-stat-card leads-stat-card--green" data-aos="fade-up" data-aos-delay="100">
        <div class="leads-stat-card-bg">
            <div class="leads-stat-card-circle leads-stat-card-circle-1"></div>
            <div class="leads-stat-card-circle leads-stat-card-circle-2"></div>
        </div>
        <div class="leads-stat-card-icon">
            <div class="leads-stat-card-icon-inner">
                <i class="fa-solid fa-sparkles"></i>
            </div>
        </div>
        <div class="leads-stat-card-content">
            <span class="leads-stat-card-label">Leads Nuevos</span>
            <div class="leads-stat-card-value-wrapper">
                <span class="leads-stat-card-value" data-count="{{ $stats['new'] }}">0</span>
                @if($stats['unread'] > 0)
                    <span class="leads-stat-card-badge leads-stat-card-badge--pulse">
                        <span class="leads-stat-card-badge-dot"></span>
                        <span>{{ $stats['unread'] }} sin leer</span>
                    </span>
                @endif
            </div>
            <p class="leads-stat-card-description">Requieren tu atención inmediata</p>
        </div>
        <div class="leads-stat-card-decoration">
            <svg viewBox="0 0 200 60" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 30 Q 50 45, 100 30 T 200 30" stroke="currentColor" stroke-width="2" fill="none" opacity="0.2"/>
            </svg>
        </div>
    </div>

    <div class="leads-stat-card leads-stat-card--amber" data-aos="fade-up" data-aos-delay="200">
        <div class="leads-stat-card-bg">
            <div class="leads-stat-card-circle leads-stat-card-circle-1"></div>
            <div class="leads-stat-card-circle leads-stat-card-circle-2"></div>
        </div>
        <div class="leads-stat-card-icon">
            <div class="leads-stat-card-icon-inner">
                <i class="fa-solid fa-phone-volume"></i>
            </div>
        </div>
        <div class="leads-stat-card-content">
            <span class="leads-stat-card-label">En Proceso</span>
            <div class="leads-stat-card-value-wrapper">
                <span class="leads-stat-card-value" data-count="{{ $stats['contacted'] }}">0</span>
                @php
                    $contactedPercentage = $stats['total'] > 0 ? round(($stats['contacted'] / $stats['total']) * 100) : 0;
                @endphp
                <span class="leads-stat-card-percentage">{{ $contactedPercentage }}%</span>
            </div>
            <p class="leads-stat-card-description">Leads ya contactados</p>
        </div>
        <div class="leads-stat-card-decoration">
            <svg viewBox="0 0 200 60" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 30 Q 50 20, 100 30 T 200 30" stroke="currentColor" stroke-width="2" fill="none" opacity="0.2"/>
            </svg>
        </div>
    </div>

    <div class="leads-stat-card leads-stat-card--blue" data-aos="fade-up" data-aos-delay="300">
        <div class="leads-stat-card-bg">
            <div class="leads-stat-card-circle leads-stat-card-circle-1"></div>
            <div class="leads-stat-card-circle leads-stat-card-circle-2"></div>
        </div>
        <div class="leads-stat-card-icon">
            <div class="leads-stat-card-icon-inner">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
        <div class="leads-stat-card-content">
            <span class="leads-stat-card-label">Finalizados</span>
            <div class="leads-stat-card-value-wrapper">
                <span class="leads-stat-card-value" data-count="{{ $stats['closed'] }}">0</span>
                <span class="leads-stat-card-change leads-stat-card-change--neutral">
                    <i class="fa-solid fa-check"></i>
                    <span>Cerrados</span>
                </span>
            </div>
            <p class="leads-stat-card-description">Leads completados exitosamente</p>
            <div class="leads-stat-card-progress">
                <div class="leads-stat-card-progress-track">
                    <div class="leads-stat-card-progress-fill" 
                         style="width: {{ $stats['total'] > 0 ? round(($stats['closed'] / $stats['total']) * 100) : 0 }}%"></div>
                </div>
                <span class="leads-stat-card-progress-text">
                    {{ $stats['total'] > 0 ? round(($stats['closed'] / $stats['total']) * 100) : 0 }}% del total
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════════
     FILTERS & SEARCH - PREMIUM DESIGN
     ═══════════════════════════════════════════════════════════════════════════ --}}
<div class="leads-filters-container">
    <form method="GET" action="{{ route('admin.leads.index') }}" class="leads-filters-form" data-ajax-filter>
        {{-- Search Bar Premium --}}
        <div class="leads-search-bar">
            <div class="leads-search-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <input type="text" 
                   name="search" 
                   class="leads-search-input" 
                   placeholder="Buscar por nombre, email, teléfono o servicio..."
                   value="{{ request('search') }}" 
                   data-search-input>
            @if(request('search'))
                <button type="button" class="leads-search-clear" data-filter-clear>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            @endif
            <div class="leads-search-shortcut">
                <kbd>⌘</kbd><kbd>K</kbd>
            </div>
        </div>

        {{-- Advanced Filters --}}
        <div class="leads-filters-grid">
            <div class="leads-filter-item">
                <label class="leads-filter-label">
                    <i class="fa-solid fa-filter"></i>
                    <span>Estado</span>
                </label>
                <select name="status" class="leads-filter-select" data-filter-select>
                    <option value="">Todos los estados</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>
                        🟢 Nuevos
                    </option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>
                        🟡 Contactados
                    </option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>
                        ⚪ Cerrados
                    </option>
                </select>
            </div>

            <div class="leads-filter-item">
                <label class="leads-filter-label">
                    <i class="fa-solid fa-flag"></i>
                    <span>Prioridad</span>
                </label>
                <select name="priority" class="leads-filter-select" data-filter-select>
                    <option value="">Todas las prioridades</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>
                        🔴 Alta prioridad
                    </option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>
                        🟡 Prioridad media
                    </option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>
                        ⚪ Prioridad baja
                    </option>
                </select>
            </div>

            <div class="leads-filter-item">
                <label class="leads-filter-label">
                    <i class="fa-solid fa-location-arrow"></i>
                    <span>Origen</span>
                </label>
                <select name="source" class="leads-filter-select" data-filter-select>
                    <option value="">Todos los orígenes</option>
                    <option value="contact" {{ request('source') === 'contact' ? 'selected' : '' }}>
                        📧 Formulario web
                    </option>
                    <option value="chat" {{ request('source') === 'chat' ? 'selected' : '' }}>
                        💬 Chat en vivo
                    </option>
                </select>
            </div>

            @if(request('search') || request('status') || request('priority') || request('source'))
                <div class="leads-filter-item leads-filter-item--actions">
                    <button type="button" class="leads-filter-clear-all" data-filter-clear>
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Limpiar filtros</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- Active Filters Tags --}}
        @if(request('search') || request('status') || request('priority') || request('source'))
            <div class="leads-active-filters">
                <span class="leads-active-filters-label">Filtros activos:</span>
                <div class="leads-active-filters-tags">
                    @if(request('search'))
                        <span class="leads-filter-tag">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>{{ request('search') }}</span>
                            <button type="button" onclick="document.querySelector('[name=search]').value=''; this.closest('form').submit();">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </span>
                    @endif
                    @if(request('status'))
                        <span class="leads-filter-tag">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Estado: {{ ucfirst(request('status')) }}</span>
                            <button type="button" onclick="document.querySelector('[name=status]').value=''; this.closest('form').submit();">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </span>
                    @endif
                    @if(request('priority'))
                        <span class="leads-filter-tag">
                            <i class="fa-solid fa-flag"></i>
                            <span>Prioridad: {{ ucfirst(request('priority')) }}</span>
                            <button type="button" onclick="document.querySelector('[name=priority]').value=''; this.closest('form').submit();">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </span>
                    @endif
                    @if(request('source'))
                        <span class="leads-filter-tag">
                            <i class="fa-solid fa-location-arrow"></i>
                            <span>Origen: {{ ucfirst(request('source')) }}</span>
                            <button type="button" onclick="document.querySelector('[name=source]').value=''; this.closest('form').submit();">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </form>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════════
     BULK SELECTION BAR - PREMIUM
     ═══════════════════════════════════════════════════════════════════════════ --}}
<form id="bulkForm" method="POST" action="{{ route('admin.leads.bulk') }}">
    @csrf
    
    <div class="leads-bulk-bar" id="bulkBar" style="display:none">
        <div class="leads-bulk-bar-inner">
            <div class="leads-bulk-bar-left">
                <div class="leads-bulk-checkbox-wrapper">
                    <input type="checkbox" id="selectAll" class="leads-checkbox-input">
                    <label for="selectAll" class="leads-checkbox-label">
                        <svg class="leads-checkbox-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </label>
                </div>
                <div class="leads-bulk-info">
                    <span class="leads-bulk-count-text">
                        <strong id="bulkCount">0</strong> leads seleccionados
                    </span>
                    <span class="leads-bulk-hint">Selecciona todos o algunos para acciones masivas</span>
                </div>
            </div>
            
            <div class="leads-bulk-bar-actions">
                <div class="leads-bulk-select-wrapper">
                    <select name="action" class="leads-bulk-select" required>
                        <option value="">Selecciona una acción...</option>
                        <option value="mark_contacted">✓ Marcar como contactados</option>
                        <option value="mark_closed">✓✓ Marcar como cerrados</option>
                        <option value="delete">🗑️ Eliminar seleccionados</option>
                    </select>
                </div>
                <button type="submit" 
                        class="leads-bulk-btn leads-bulk-btn--apply" 
                        onclick="return confirm('¿Estás seguro de aplicar esta acción a los leads seleccionados?')">
                    <i class="fa-solid fa-bolt"></i>
                    <span>Aplicar</span>
                </button>
                <button type="button" 
                        class="leads-bulk-btn leads-bulk-btn--cancel"
                        onclick="document.querySelectorAll('.lead-check').forEach(c => c.checked = false); updateBulkBar();">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         LEADS GRID CONTAINER - PREMIUM
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="leads-grid-container">
        {{-- Header with Title and View Toggle --}}
        <div class="leads-grid-header">
            <div class="leads-grid-header-left">
                <h2 class="leads-grid-title">
                    <i class="fa-solid fa-users"></i>
                    <span>Todos los Leads</span>
                    <span class="leads-grid-count" data-ajax-stats>
                        (<span data-stat="total">{{ $leads->total() }}</span>)
                    </span>
                </h2>
                @if($stats['unread'] > 0)
                    <span class="leads-grid-unread-badge">
                        <span class="leads-grid-unread-dot"></span>
                        <span><span data-stat="unread">{{ $stats['unread'] }}</span> sin leer</span>
                    </span>
                @endif
            </div>
            
            <div class="leads-grid-header-actions">
                <div class="leads-view-toggle-group">
                    <button type="button" 
                            class="leads-view-toggle" 
                            data-view="list" 
                            onclick="toggleView(this)"
                            title="Vista de lista">
                        <i class="fa-solid fa-list"></i>
                    </button>
                    <button type="button" 
                            class="leads-view-toggle active" 
                            data-view="cards" 
                            onclick="toggleView(this)"
                            title="Vista de tarjetas">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Leads Grid Content --}}
        <div class="leads-grid-content" data-ajax-results>
            @include('admin.leads._leads-table')
        </div>

        {{-- Pagination --}}
        @if($leads->hasPages())
            <div class="leads-grid-pagination" data-ajax-pagination>
                {{ $leads->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</form>

<script>
// ═══════════════════════════════════════════════════════════════════════════
// LEADS INDEX - PREMIUM INTERACTIONS
// ═══════════════════════════════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', function() {
    initLeadsIndex();
});

function initLeadsIndex() {
    initBulkSelection();
    initCountUpAnimation();
    initSearchShortcut();
}

// ═══════════════════════════════════════════════════════════════════════════
// COUNT UP ANIMATION FOR STATS
// ═══════════════════════════════════════════════════════════════════════════
function initCountUpAnimation() {
    const counters = document.querySelectorAll('[data-count]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Start animation when element is in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// SEARCH KEYBOARD SHORTCUT (⌘K or Ctrl+K)
// ═══════════════════════════════════════════════════════════════════════════
function initSearchShortcut() {
    const searchInput = document.querySelector('.leads-search-input');
    
    if (searchInput) {
        document.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// BULK SELECTION
// ═══════════════════════════════════════════════════════════════════════════
function initBulkSelection() {
    const selectAll = document.getElementById('selectAll');
    const checks = document.querySelectorAll('.lead-check');
    const bulkBar = document.getElementById('bulkBar');
    const bulkCount = document.getElementById('bulkCount');

    function updateBulkBar() {
        const checked = document.querySelectorAll('.lead-check:checked').length;
        const total = document.querySelectorAll('.lead-check').length;
        
        bulkCount.textContent = checked;
        bulkBar.style.display = checked > 0 ? 'flex' : 'none';
        
        if (selectAll) {
            selectAll.checked = checked > 0 && checked === total;
            selectAll.indeterminate = checked > 0 && checked < total;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.lead-check').forEach(c => c.checked = this.checked);
            updateBulkBar();
        });
    }

    checks.forEach(c => c.addEventListener('change', updateBulkBar));
    
    // Re-bind after AJAX updates
    document.addEventListener('ajaxFilterUpdated', function() {
        setTimeout(initBulkSelection, 100);
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// VIEW TOGGLE
// ═══════════════════════════════════════════════════════════════════════════
function toggleView(button) {
    const view = button.dataset.view;
    const container = document.querySelector('.admin-leads-content');
    const toggles = document.querySelectorAll('.admin-view-toggle');
    
    toggles.forEach(t => t.classList.remove('active'));
    button.classList.add('active');
    
    if (view === 'grid') {
        container.classList.add('admin-leads-content--list');
    } else {
        container.classList.remove('admin-leads-content--list');
    }
    
    // Save preference
    localStorage.setItem('leadsViewPreference', view);
}

// Load saved view preference
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('leadsViewPreference');
    if (savedView) {
        const button = document.querySelector(`[data-view="${savedView}"]`);
        if (button && !button.classList.contains('active')) {
            toggleView(button);
        }
    }
});

// Make updateBulkBar global for inline onclick
window.updateBulkBar = function() {
    const checked = document.querySelectorAll('.lead-check:checked').length;
    document.getElementById('bulkCount').textContent = checked;
    document.getElementById('bulkBar').style.display = checked > 0 ? 'flex' : 'none';
};

// Make toggleView global
window.toggleView = toggleView;
</script>
@endsection
