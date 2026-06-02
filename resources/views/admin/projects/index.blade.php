@extends('admin.layouts.app')

@section('title', 'Proyectos')
@section('page-title', 'Proyectos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. COMPACT PAGE HEADER
     ═══════════════════════════════════════════════════ --}}
<div class="svc-header" data-ajax-stats>
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-diagram-project" style="color: var(--primary-color);"></i>
                Proyectos
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Proyectos Publicados">
            <span class="svc-header-stat-lbl">Publicados:</span>
            <span class="svc-header-stat-num text-success" data-stat="published">{{ \App\Models\Project::where('status', 'published')->count() }}</span>
        </div>
        <div class="svc-header-stat-item" title="Proyectos en Borrador">
            <span class="svc-header-stat-lbl">Borradores:</span>
            <span class="svc-header-stat-num text-warning" data-stat="draft">{{ \App\Models\Project::where('status', 'draft')->count() }}</span>
        </div>
        <div class="svc-header-stat-item" title="Total Proyectos">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num" data-stat="total">{{ \App\Models\Project::count() }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     2. TOOLBAR (SEARCH, FILTERS & ACTION)
     ═══════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('admin.projects.index') }}" class="svc-toolbar" role="search" data-ajax-filter id="projectsFilterForm">
    <div style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap;">
        <input type="hidden" name="status" id="statusFilterHidden" class="admin-form-select" data-filter-select value="{{ request('status') }}">
        
        <div class="svc-filters">
            <button type="button" class="svc-filter-pill {{ request('status') === '' || !request('status') ? 'active' : '' }}" onclick="setStatusFilter(this, '')">
                <i class="fa-solid fa-border-all"></i>
                <span>Todos</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'published' ? 'active' : '' }}" onclick="setStatusFilter(this, 'published')">
                <i class="fa-solid fa-circle-check"></i>
                <span>Publicados</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'draft' ? 'active' : '' }}" onclick="setStatusFilter(this, 'draft')">
                <i class="fa-solid fa-circle-pause"></i>
                <span>Borradores</span>
            </button>
        </div>

        <div class="svc-search-box">
            <input type="text" class="svc-search-input" id="search-input" name="search" data-search-input value="{{ request('search') }}" placeholder="Buscar por título o cliente..." autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
            <kbd class="svc-search-shortcut">/</kbd>
        </div>

        <div style="position: relative;">
            <select id="type-filter" name="type" class="admin-form-select" data-filter-select style="min-width: 150px; height: 38px; border-radius: 10px; border: 1px solid var(--admin-border); padding: 0 1rem; font-size: 0.825rem; font-weight: 600; background-color: #f1f5f9; color: var(--admin-text-secondary); cursor: pointer;">
                <option value="">Todos los tipos</option>
                @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div style="position: relative;">
            <select id="sort-filter" name="sort" class="admin-form-select" data-filter-select style="min-width: 150px; height: 38px; border-radius: 10px; border: 1px solid var(--admin-border); padding: 0 1rem; font-size: 0.825rem; font-weight: 600; background-color: #f1f5f9; color: var(--admin-text-secondary); cursor: pointer;">
                <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>Más recientes</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Título A-Z</option>
            </select>
        </div>
    </div>

    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.65rem 1.25rem; font-size: 0.85rem; border-radius: 10px;">
        <i class="fa-solid fa-plus"></i>
        <span>Nuevo Proyecto</span>
    </a>
</form>

{{-- ═══════════════════════════════════════════════════
     3. PROJECTS GRID WITH AJAX
     ═══════════════════════════════════════════════════ --}}
<div data-ajax-results>
    @if($projects->count() > 0)
    <div class="svc-grid" id="projectsGrid">
        @include('admin.projects._projects-grid')
    </div>

    {{-- Paginación --}}
    @if($projects->hasPages())
    <div class="admin-pagination" id="projectsPagination" data-ajax-pagination>
        {{ $projects->appends(request()->query())->links() }}
    </div>
    @endif
    
    @else
    <div class="svc-empty-state">
        <i class="fa-solid fa-folder-open svc-empty-icon"></i>
        <h3>No se encontraron proyectos</h3>
        <p>Intenta ajustar los filtros de búsqueda o crea un nuevo proyecto.</p>
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════
     4. SLIDE-OVER DRAWER (PREVIEW PANEL)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-drawer" id="svcDrawer">
    <div class="svc-drawer-backdrop" onclick="closeProjectDrawer()"></div>
    <div class="svc-drawer-content">
        <div class="svc-drawer-header">
            <h3><i class="fa-solid fa-mobile-screen-button"></i> Vista Previa del Proyecto</h3>
            <button type="button" class="svc-drawer-close" onclick="closeProjectDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="svc-drawer-body" id="drawerBody">
            {{-- Cargado dinámicamente --}}
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     5. JAVASCRIPT LOGIC
     ═══════════════════════════════════════════════════ --}}
@push('scripts')
<script>
function initProjectsModule() {
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

    // B. Conmutadores de Estado AJAX (Switches)
    // Usamos delegación de eventos en el grid para que funcione después de actualizaciones por AJAX
    const grid = document.getElementById('projectsGrid');
    if (grid && !grid.dataset.listenerBound) {
        grid.dataset.listenerBound = 'true';
        grid.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('proj-active-toggle')) {
                const toggle = e.target;
                const projectId = toggle.getAttribute('data-id');
                const isChecked = toggle.checked;
                const label = document.getElementById(`statusLabel-${projectId}`);
                const card = toggle.closest('.svc-card-item');

                // Actualizar localmente inmediatamente
                if (label) label.textContent = isChecked ? 'Publicado' : 'Borrador';
                if (card) card.setAttribute('data-status', isChecked ? 'published' : 'draft');

                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const token = csrfMeta ? csrfMeta.getAttribute('content') : '';

                fetch(`/admin/projects/${projectId}/toggle-status`, {
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
                            title: data.status === 'published' ? 'Proyecto publicado' : 'Proyecto en borrador'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    // Revertir en caso de fallo
                    toggle.checked = !toggle.checked;
                    if (label) label.textContent = toggle.checked ? 'Publicado' : 'Borrador';
                    if (card) card.setAttribute('data-status', toggle.checked ? 'published' : 'draft');
                    alert('Ocurrió un error al actualizar el estado del proyecto.');
                });
            }
        });
    }

    // C. Drawer Open / Close Functions (Expuestas globalmente)
    window.openProjectPreview = function(id) {
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
        const client = card.getAttribute('data-client') || '';
        const year = card.getAttribute('data-year') || '';
        const url = card.getAttribute('data-url') || '';
        const thumbnail = card.getAttribute('data-thumbnail') || '';
        
        let images = [];
        try {
            images = JSON.parse(card.getAttribute('data-images-list') || '[]');
        } catch (e) {
            console.error("Error parsing images list", e);
        }

        let techs = [];
        try {
            techs = JSON.parse(card.getAttribute('data-technologies-list') || '[]');
        } catch (e) {
            console.error("Error parsing technologies list", e);
        }

        const status = card.getAttribute('data-status') === 'published' ? 'Publicado' : 'Borrador';

        const imageHtml = thumbnail 
            ? `<img src="${thumbnail}" alt="${title}" style="width:100%; height:200px; object-fit:cover; border-radius:14px; margin-bottom:1.5rem; border: 1px solid rgba(255,255,255,0.08);">`
            : `<div style="width:100%; height:200px; background:linear-gradient(135deg, rgba(255, 0, 110, 0.15) 0%, rgba(131, 56, 236, 0.05) 100%); display:flex; align-items:center; justify-content:center; border-radius:14px; margin-bottom:1.5rem; border:1px solid rgba(255,255,255,0.08);">
                 <i class="fa-solid fa-diagram-project" style="font-size:3.5rem; color:var(--admin-primary); opacity:0.4;"></i>
               </div>`;

        let techsHtml = '';
        if (techs.length > 0) {
            techsHtml = `
                <div style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:0.5rem;">
                    ${techs.map(t => `<span style="font-size: 0.72rem; font-weight:700; color:#c084fc; background:rgba(124,58,237,0.15); padding:0.2rem 0.6rem; border-radius:6px; border:1px solid rgba(124,58,237,0.2);">${t}</span>`).join('')}
                </div>
            `;
        }

        let galleryHtml = '';
        if (images.length > 0) {
            galleryHtml = `
                <h4 style="color:white; font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin: 1.5rem 0 0.75rem 0;">Galería del Proyecto</h4>
                <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:0.5rem;">
                    ${images.map(img => `
                        <div style="aspect-ratio:1.2; border-radius:8px; overflow:hidden; border:1px solid rgba(255,255,255,0.05);">
                            <img src="${img}" alt="Screenshot" style="width:100%; height:100%; object-fit:cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </div>
                    `).join('')}
                </div>
            `;
        }

        let detailsHtml = `
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; background:rgba(255,255,255,0.03); padding:1rem; border-radius:12px; border:1px solid rgba(255,255,255,0.05);">
                ${client ? `<div>
                    <span style="display:block; font-size:0.68rem; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Cliente</span>
                    <strong style="color:white; font-size:0.85rem;">${client}</strong>
                </div>` : ''}
                ${year ? `<div>
                    <span style="display:block; font-size:0.68rem; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px;">Año</span>
                    <strong style="color:white; font-size:0.85rem;">${year}</strong>
                </div>` : ''}
            </div>
        `;

        drawerBody.innerHTML = `
            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                ${imageHtml}
                
                <div>
                    <span style="display:inline-flex; padding:0.25rem 0.75rem; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); color:#cbd5e1; font-size:0.68rem; font-weight:700; border-radius:30px; text-transform:uppercase; margin-bottom:0.75rem;">
                        ${status}
                    </span>
                    <h2 style="color:white; font-size:1.45rem; font-weight:800; margin:0; line-height:1.25;">
                        ${title}
                    </h2>
                    <p style="color:#94a3b8; font-size:0.75rem; font-family:monospace; margin:0.35rem 0 0 0;">/proyectos/${slug}</p>
                    ${techsHtml}
                </div>

                ${detailsHtml}

                <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:1.25rem;">
                    <h4 style="color:white; font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin: 0 0 0.5rem 0;">Descripción</h4>
                    <p style="color:#cbd5e1; font-size:0.825rem; line-height:1.55; margin:0;">
                        ${desc || 'Sin descripción.'}
                    </p>
                </div>

                ${galleryHtml}
                
                <div style="margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid rgba(255,255,255,0.08); display:flex; gap:0.75rem;">
                    ${url ? `<a href="${url}" target="_blank" style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:10px; color:white; font-size:0.8rem; font-weight:700; text-transform:uppercase; text-decoration:none; text-align:center; transition:0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                        <i class="fa-solid fa-link"></i>
                        <span>Visitar Sitio</span>
                    </a>` : ''}
                    <a href="/admin/projects/${id}/edit" style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:var(--admin-primary); border:none; border-radius:10px; color:white; font-size:0.8rem; font-weight:700; text-transform:uppercase; text-decoration:none; text-align:center; transition:0.2s;" onmouseover="this.style.background='var(--admin-secondary)'" onmouseout="this.style.background='var(--admin-primary)'">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Editar Completo</span>
                    </a>
                </div>
            </div>
        `;

        drawer.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closeProjectDrawer = function() {
        const drawer = document.getElementById('svcDrawer');
        if (drawer) {
            drawer.classList.remove('open');
            document.body.style.overflow = '';
        }
    };
}

// Cargar tanto para MPA como Turbo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProjectsModule);
} else {
    initProjectsModule();
}
document.addEventListener('turbo:load', initProjectsModule);
</script>
@endpush

@endsection
