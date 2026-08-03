@extends('admin.layouts.app')

@section('title', 'Servicios')
@section('page-title', 'Servicios')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. COMPACT PAGE HEADER
     ═══════════════════════════════════════════════════ --}}
<div class="svc-header">
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--primary-color);"></i>
                Servicios
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Total Servicios">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num">{{ $totalServices }}</span>
        </div>
        <div class="svc-header-stat-item" title="Servicios Activos">
            <span class="svc-header-stat-lbl">Activos:</span>
            <span class="svc-header-stat-num text-success">{{ $activeServices }}</span>
        </div>
        <div class="svc-header-stat-item" title="Servicios en Borrador">
            <span class="svc-header-stat-lbl">Borradores:</span>
            <span class="svc-header-stat-num text-warning">{{ $inactiveServices }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     2. TOOLBAR (SEARCH, FILTERS & ACTION)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-toolbar">
    <div style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap;">
        <div class="svc-filters">
            <button class="svc-filter-pill active" data-filter="all">
                <i class="fa-solid fa-border-all"></i>
                <span>Todos ({{ $totalServices }})</span>
            </button>
            <button class="svc-filter-pill" data-filter="active">
                <i class="fa-solid fa-circle-check"></i>
                <span>Activos ({{ $activeServices }})</span>
            </button>
            <button class="svc-filter-pill" data-filter="inactive">
                <i class="fa-solid fa-circle-pause"></i>
                <span>Inactivos ({{ $inactiveServices }})</span>
            </button>
        </div>

        <div class="svc-search-box">
            <input type="text" class="svc-search-input" id="servicesSearchInput" placeholder="Buscar por nombre o slug..." autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
            <kbd class="svc-search-shortcut">/</kbd>
        </div>
    </div>

    <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.65rem 1.25rem; font-size: 0.85rem; border-radius: 10px;">
        <i class="fa-solid fa-plus"></i>
        <span>Nuevo Servicio</span>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════
     4. SERVICES GRID
     ═══════════════════════════════════════════════════ --}}
<div class="svc-grid" id="servicesGrid">
    @forelse($services as $service)
    <div class="svc-card-item" 
         style="--card-color: {{ $service->color ?? '#6366f1' }}"
         data-id="{{ $service->id }}"
         data-status="{{ $service->is_active ? 'active' : 'inactive' }}"
         data-title="{{ e(strtolower($service->title)) }}"
         data-slug="{{ e(strtolower($service->slug)) }}"
         data-desc="{{ e($service->short_description ?? '') }}"
         data-icon="{{ e($service->icon ?? 'fa-solid fa-shapes') }}"
         data-image="{{ $service->image ? Storage::url($service->image) : '' }}"
         data-features-list="{{ e($service->features ? json_encode(array_slice($service->features, 0, 4)) : '[]') }}"
         data-benefits-list="{{ e($service->benefits ? json_encode(array_slice($service->benefits, 0, 4)) : '[]') }}">
         
         {{-- Card Top Banner --}}
         <div class="svc-card-banner">
             @if($service->image)
                 <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="svc-card-img">
             @else
                 <div class="svc-card-img" style="background: linear-gradient(135deg, {{ ($service->color ?? '#6366f1') }}22 0%, {{ ($service->color ?? '#6366f1') }}08 100%); display: flex; align-items: center; justify-content: center; height: 100%;">
                     <i class="{{ Str::contains($service->icon ?? '', 'fa-') ? $service->icon : 'fa-solid fa-shapes' }}" style="font-size: 3rem; color: {{ $service->color ?? '#6366f1' }}; opacity: 0.25;"></i>
                 </div>
             @endif
             
             <div class="svc-card-overlay"></div>
             
             {{-- Status Switch (iOS style) --}}
             <div class="svc-card-switch" onclick="event.stopPropagation();">
                 <span class="svc-switch-label" id="statusLabel-{{ $service->id }}">
                     {{ $service->is_active ? 'Activo' : 'Borrador' }}
                 </span>
                 <label class="svc-switch">
                     <input type="checkbox" class="svc-active-toggle" data-id="{{ $service->id }}" {{ $service->is_active ? 'checked' : '' }}>
                     <span class="svc-slider"></span>
                 </label>
             </div>
         </div>

         {{-- Emoji / Icon Badge --}}
         <div class="svc-card-emoji-wrap">
             @if($service->icon)
                 @if(Str::contains($service->icon, 'fa-'))
                     <i class="{{ $service->icon }}"></i>
                 @else
                     <span style="font-family: inherit;">{{ $service->icon }}</span>
                 @endif
             @else
                 <i class="fa-solid fa-shapes"></i>
             @endif
         </div>

         {{-- Card Body --}}
         <div class="svc-card-body">
             <h3 class="svc-card-title">{{ $service->title }}</h3>
             <span class="svc-card-slug">/servicios/{{ $service->slug }}</span>
             
             <p class="svc-card-desc">{{ $service->short_description ?? 'Sin descripción corta.' }}</p>

             {{-- Metadata Badges --}}
             <div class="svc-card-metadata">
                 @if($service->features && count($service->features) > 0)
                 <span class="svc-card-badge" title="Características">
                     <i class="fa-solid fa-list-check"></i>
                     <span>{{ count($service->features) }} características</span>
                 </span>
                 @endif

                 @if($service->benefits && count($service->benefits) > 0)
                 <span class="svc-card-badge" title="Beneficios">
                     <i class="fa-solid fa-star"></i>
                     <span>{{ count($service->benefits) }} ventajas</span>
                 </span>
                 @endif

                 @if($service->leads_count > 0)
                 <span class="svc-card-badge svc-card-badge--leads" title="Leads">
                     <i class="fa-solid fa-users"></i>
                     <span>{{ $service->leads_count }} leads</span>
                 </span>
                 @endif
             </div>

             {{-- Actions Grid --}}
             <div class="svc-card-actions" onclick="event.stopPropagation();">
                 <button type="button" class="svc-card-btn svc-card-btn--preview" onclick="openPreview({{ $service->id }})" title="Ver Vista Previa">
                     <i class="fa-solid fa-eye"></i>
                     <span>Vista Previa</span>
                 </button>
                 <a href="{{ route('admin.services.edit', $service) }}" class="svc-card-btn svc-card-btn--edit" title="Editar">
                     <i class="fa-solid fa-pen-to-square"></i>
                     <span>Editar</span>
                 </a>
                  <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                        onsubmit="return confirm('¿Seguro que deseas eliminar el servicio {{ $service->title }}?')" style="display: contents;">
                      @csrf @method('DELETE')
                      <button type="submit" class="svc-card-btn svc-card-btn--delete" title="Eliminar">
                          <i class="fa-solid fa-trash-can"></i>
                          <span>Eliminar</span>
                      </button>
                  </form>
             </div>
         </div>
    </div>
    @empty
    <div class="svc-empty-state">
        <i class="fa-solid fa-box-open svc-empty-icon"></i>
        <h3>No hay servicios registrados</h3>
        <p>Comienza agregando un nuevo servicio utilizando el botón en la cabecera.</p>
    </div>
    @endforelse
</div>

{{-- Paginación --}}
@if($services->hasPages())
<div class="admin-pagination" id="servicesPagination">
    {{ $services->links() }}
</div>
@endif

{{-- ═══════════════════════════════════════════════════
     5. SLIDE-OVER DRAWER (PREVIEW PANEL)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-drawer" id="svcDrawer">
    <div class="svc-drawer-backdrop" onclick="closeDrawer()"></div>
    <div class="svc-drawer-content">
        <div class="svc-drawer-header">
            <h3><i class="fa-solid fa-mobile-screen-button"></i> Vista Previa del Sitio</h3>
            <button type="button" class="svc-drawer-close" onclick="closeDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="svc-drawer-body" id="drawerBody">
            {{-- Cargado dinámicamente --}}
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     6. JAVASCRIPT LOGIC
     ═══════════════════════════════════════════════════ --}}
@push('scripts')
<script>
function initServicesModule() {
    const searchInput = document.getElementById('servicesSearchInput');
    const filterPills = document.querySelectorAll('.svc-filter-pill');
    const serviceCards = document.querySelectorAll('.svc-card-item');
    const pagination = document.getElementById('servicesPagination');
    const activeToggles = document.querySelectorAll('.svc-active-toggle');

    let currentSearch = '';
    let currentFilter = 'all';

    // A. Filtrado dinámico (Buscador y Pills)
    function applyFilters() {
        serviceCards.forEach(card => {
            const status = card.getAttribute('data-status');
            const title = card.getAttribute('data-title');
            const slug = card.getAttribute('data-slug');

            const matchesSearch = title.includes(currentSearch) || slug.includes(currentSearch);
            const matchesFilter = currentFilter === 'all' || status === currentFilter;

            if (matchesSearch && matchesFilter) {
                card.classList.remove('card-filtered-out');
            } else {
                card.classList.add('card-filtered-out');
            }
        });

        // Ocultar paginación si hay algún filtro de búsqueda o de pill activo
        if (pagination) {
            if (currentSearch !== '' || currentFilter !== 'all') {
                pagination.style.display = 'none';
            } else {
                pagination.style.display = '';
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value.toLowerCase().trim();
            applyFilters();
        });
    }

    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // B. Conmutadores de Estado AJAX (Switches)
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('svc-active-toggle')) {
            const toggle = e.target;
            const serviceId = toggle.getAttribute('data-id');
            const isActive = toggle.checked ? 1 : 0;
            const label = document.getElementById(`statusLabel-${serviceId}`);
            const card = toggle.closest('.svc-card-item');

            // Actualizar etiqueta e info local inmediatamente
            if (label) label.textContent = isActive ? 'Activo' : 'Borrador';
            if (card) card.setAttribute('data-status', isActive ? 'active' : 'inactive');

            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const token = csrfMeta ? csrfMeta.getAttribute('content') : '';

            fetch(`/admin/services/${serviceId}/toggle-active`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Error al actualizar estado');
                return res.json();
            })
            .then(data => {
                if (window.Toast) {
                    window.Toast.fire({
                        icon: 'success',
                        title: data.is_active ? 'Servicio publicado' : 'Servicio en borrador'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                // Revertir en caso de fallo
                toggle.checked = !toggle.checked;
                if (label) label.textContent = toggle.checked ? 'Activo' : 'Borrador';
                if (card) card.setAttribute('data-status', toggle.checked ? 'active' : 'inactive');
                alert('Ocurrió un error al actualizar el estado del servicio.');
            });
        }
    });

    // C. Atajo de Teclado (tecla / para buscar)
    if (!window.svcShortcutInitialized) {
        window.svcShortcutInitialized = true;
        document.addEventListener('keydown', function(e) {
            const input = document.getElementById('servicesSearchInput');
            if (input && e.key === '/' && document.activeElement !== input && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                e.preventDefault();
                input.focus();
                input.select();
            }
        });
    }

    // D. Drawer Open / Close Functions (Expuestas globalmente para poder llamarse desde HTML onclick)
    window.openPreview = function(id) {
        const card = document.querySelector(`.svc-card-item[data-id="${id}"]`);
        const drawer = document.getElementById('svcDrawer');
        const drawerBody = document.getElementById('drawerBody');
        
        if (!card || !drawer || !drawerBody) {
            console.error("Preview error: Elements missing", { card, drawer, drawerBody });
            return;
        }

        const title = card.querySelector('.svc-card-title')?.textContent || '';
        const slug = card.getAttribute('data-slug') || '';
        const desc = card.getAttribute('data-desc') || '';
        const icon = card.getAttribute('data-icon') || '';
        const color = card.style.getPropertyValue('--card-color') || '#6366f1';
        const image = card.getAttribute('data-image') || '';
        
        let features = [];
        try {
            features = JSON.parse(card.getAttribute('data-features-list') || '[]');
        } catch (e) {
            console.error("Error parsing features list", e);
        }

        let benefits = [];
        try {
            benefits = JSON.parse(card.getAttribute('data-benefits-list') || '[]');
        } catch (e) {
            console.error("Error parsing benefits list", e);
        }

        const status = card.getAttribute('data-status') === 'active' ? 'Publicado' : 'Borrador';

        let iconHtml = '';
        if (icon.startsWith('fa-')) {
            iconHtml = `<i class="${icon}"></i>`;
        } else {
            iconHtml = `<span style="font-family: inherit;">${icon}</span>`;
        }

        const imageHtml = image 
            ? `<img src="${image}" alt="${title}" style="width:100%; height:180px; object-fit:cover; border-radius:14px; margin-bottom:1.5rem; border: 1px solid rgba(255,255,255,0.08);">`
            : `<div style="width:100%; height:180px; background:linear-gradient(135deg, ${color}33 0%, ${color}08 100%); display:flex; align-items:center; justify-content:center; border-radius:14px; margin-bottom:1.5rem; border:1px solid rgba(255,255,255,0.08);">
                 <i class="${icon.startsWith('fa-') ? icon : 'fa-solid fa-shapes'}" style="font-size:3.5rem; color:${color}; opacity:0.4;"></i>
               </div>`;

        let featuresHtml = '';
        if (Array.isArray(features) && features.length > 0) {
            featuresHtml = `
                <h4 style="color:white; font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin: 1.5rem 0 0.75rem 0;">Características</h4>
                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    ${features.map(f => `
                        <div style="display:flex; align-items:center; gap:0.6rem; color:#cbd5e1; font-size:0.8rem;">
                            <i class="fa-solid fa-circle-check" style="color:#10b981; font-size:0.75rem;"></i>
                            <span>${f}</span>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        let benefitsHtml = '';
        if (Array.isArray(benefits) && benefits.length > 0) {
            benefitsHtml = `
                <h4 style="color:white; font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin: 1.5rem 0 0.75rem 0;">Ventajas del Cliente</h4>
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    ${benefits.map(b => {
                        const bIcon = b.icon || '🚀';
                        const bTitle = b.title || 'Ventaja';
                        const bDesc = b.desc || '';
                        return `
                            <div style="display:flex; gap:0.75rem; background:rgba(255,255,255,0.03); padding:0.75rem 1rem; border-radius:10px; border:1px solid rgba(255,255,255,0.05);">
                                <span style="font-size:1.15rem; line-height:1.2;">${bIcon}</span>
                                <div>
                                    <h5 style="color:white; margin:0 0 0.15rem 0; font-size:0.825rem; font-weight:700;">${bTitle}</h5>
                                    <p style="color:#94a3b8; margin:0; font-size:0.75rem; line-height:1.4;">${bDesc}</p>
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
        }

        drawerBody.innerHTML = `
            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                ${imageHtml}
                
                <div>
                    <span style="display:inline-flex; padding:0.25rem 0.75rem; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); color:#cbd5e1; font-size:0.68rem; font-weight:700; border-radius:30px; text-transform:uppercase; margin-bottom:0.75rem;">
                        ${status}
                    </span>
                    <h2 style="color:white; font-size:1.45rem; font-weight:800; margin:0; line-height:1.25; display:flex; align-items:center; gap:0.75rem;">
                        <span style="display:inline-flex; width:38px; height:38px; background:${color}; border-radius:8px; align-items:center; justify-content:center; font-size:1.15rem; box-shadow:0 4px 10px rgba(0,0,0,0.15);">${iconHtml}</span>
                        ${title}
                    </h2>
                    <p style="color:#94a3b8; font-size:0.75rem; font-family:monospace; margin:0.35rem 0 0 0;">/servicios/${slug}</p>
                </div>

                <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:1.25rem;">
                    <p style="color:#cbd5e1; font-size:0.825rem; line-height:1.55; margin:0;">
                        ${desc || 'Este servicio aún no tiene una descripción corta de resumen configurada.'}
                    </p>
                </div>

                ${featuresHtml}
                ${benefitsHtml}
                
                <div style="margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid rgba(255,255,255,0.08); display:flex; gap:0.75rem;">
                    <a href="/admin/services/${id}/edit" style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:var(--primary-color); border:none; border-radius:10px; color:white; font-size:0.8rem; font-weight:700; text-transform:uppercase; text-decoration:none; text-align:center; transition:0.2s;" onmouseover="this.style.background='var(--primary-hover)'" onmouseout="this.style.background='var(--primary-color)'">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Editar Completo</span>
                    </a>
                </div>
            </div>
        `;

        drawer.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closeDrawer = function() {
        const drawer = document.getElementById('svcDrawer');
        if (drawer) {
            drawer.classList.remove('open');
            document.body.style.overflow = '';
        }
    };
}

// Cargar de forma ultra robusta tanto para MPA como Turbo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initServicesModule);
} else {
    initServicesModule();
}
document.addEventListener('turbo:load', initServicesModule);
</script>
@endpush

@endsection
