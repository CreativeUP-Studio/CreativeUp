@extends('admin.layouts.app')

@section('title', 'Vacantes y Puestos de Trabajo')
@section('page-title', 'Vacantes / Trabajos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    /* Estilos de Insignias y Reflejos */
    .badge-job-meta {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.76rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-job-type {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }
    .badge-job-location {
        background: rgba(255, 0, 110, 0.1);
        color: #ff006e;
        border: 1px solid rgba(255, 0, 110, 0.25);
    }
    .badge-job-order {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    /* Modal Backdrop & Preview Box */
    .svc-modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .svc-modal {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        width: 100%;
        max-width: 600px;
        animation: modalSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .svc-modal-close {
        background: rgba(255,255,255,0.2);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .svc-modal-close:hover {
        background: rgba(255,255,255,0.4);
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. COMPACT PAGE HEADER & STATS
     ═══════════════════════════════════════════════════ --}}
<div class="svc-header">
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-briefcase" style="color: var(--primary-color);"></i>
                Vacantes y Puestos de Trabajo
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Total Vacantes">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num">{{ $totalJobs }}</span>
        </div>
        <div class="svc-header-stat-item" title="Vacantes Activas">
            <span class="svc-header-stat-lbl">Activas:</span>
            <span class="svc-header-stat-num text-success">{{ $activeJobs }}</span>
        </div>
        <div class="svc-header-stat-item" title="Vacantes en Borrador">
            <span class="svc-header-stat-lbl">Borradores:</span>
            <span class="svc-header-stat-num text-warning">{{ $inactiveJobs }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     3. TOOLBAR (FILTERS, SEARCH & ACTION)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-toolbar">
    <div style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap;">
        <div class="svc-filters">
            <button class="svc-filter-pill active" data-filter="all">
                <i class="fa-solid fa-border-all"></i>
                <span>Todas ({{ $totalJobs }})</span>
            </button>
            <button class="svc-filter-pill" data-filter="active">
                <i class="fa-solid fa-circle-check"></i>
                <span>Activas ({{ $activeJobs }})</span>
            </button>
            <button class="svc-filter-pill" data-filter="inactive">
                <i class="fa-solid fa-circle-pause"></i>
                <span>Borradores ({{ $inactiveJobs }})</span>
            </button>
        </div>

        <div class="svc-search-box">
            <input type="text" class="svc-search-input" id="jobsSearchInput" placeholder="Buscar por título, área o descripción..." autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
            <kbd class="svc-search-shortcut">/</kbd>
        </div>
    </div>

    <a href="{{ route('admin.job-offers.create') }}" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.65rem 1.25rem; font-size: 0.85rem; border-radius: 10px;">
        <i class="fa-solid fa-plus"></i>
        <span>Nueva Vacante</span>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════
     4. CARDS GRID SYSTEM (CON COLORES Y REFLEJOS DE LUZ)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-grid" id="jobsGrid">
    @forelse($jobOffers as $job)
    @php
        $areaConfig = [
            'Diseño'     => ['icon' => '🎨', 'color' => '#ff006e'],
            'Desarrollo' => ['icon' => '💻', 'color' => '#8338ec'],
            'Marketing'  => ['icon' => '📈', 'color' => '#3a0ca3'],
            'Gestión'    => ['icon' => '⚡', 'color' => '#10b981'],
            'Ventas'     => ['icon' => '💼', 'color' => '#f59e0b'],
            'Soporte'    => ['icon' => '🎧', 'color' => '#00b4d8'],
        ];

        $config    = $areaConfig[$job->area] ?? ['icon' => '💼', 'color' => '#8338ec'];
        $iconEmoji = $config['icon'];
        $cardColor = $config['color'];
    @endphp

    <div class="svc-card-item"
         style="--card-color: {{ $cardColor }}"
         data-id="{{ $job->id }}"
         data-status="{{ $job->is_active ? 'active' : 'inactive' }}"
         data-title="{{ e(strtolower($job->title)) }}"
         data-area="{{ e(strtolower($job->area)) }}"
         data-desc="{{ e(strtolower($job->description)) }}">

         {{-- Top Banner con Gradiente y Reflejos --}}
         <div class="svc-card-banner">
             <div class="svc-card-img" style="background: linear-gradient(135deg, {{ $cardColor }}44 0%, {{ $cardColor }}11 100%); display: flex; align-items: center; justify-content: center; height: 100%;">
                 <i class="fa-solid fa-briefcase" style="font-size: 3.2rem; color: {{ $cardColor }}; opacity: 0.3;"></i>
             </div>
             <div class="svc-card-overlay"></div>

             {{-- iOS Switch --}}
             <div class="svc-card-switch" onclick="event.stopPropagation();">
                 <span class="svc-switch-label" id="statusLabel-{{ $job->id }}">
                     {{ $job->is_active ? 'Activa' : 'Borrador' }}
                 </span>
                 <label class="svc-switch">
                     <input type="checkbox" class="toggle-job-active" data-id="{{ $job->id }}" {{ $job->is_active ? 'checked' : '' }}>
                     <span class="svc-slider"></span>
                 </label>
             </div>
         </div>

         {{-- Emoji Icon Badge --}}
         <div class="svc-card-emoji-wrap" style="background: {{ $cardColor }}; box-shadow: 0 6px 18px {{ $cardColor }}55;">
             <span style="font-size: 1.4rem;">{{ $iconEmoji }}</span>
         </div>

         {{-- Card Body --}}
         <div class="svc-card-body">
             <h3 class="svc-card-title">{{ $job->title }}</h3>
             <span class="svc-card-slug">/trabaja-con-nosotros#{{ $job->slug }}</span>

             <p class="svc-card-desc">{{ Str::limit($job->description, 95) }}</p>

             {{-- Metadata Badges con Color del Área --}}
             <div class="svc-card-metadata" style="gap: 0.4rem;">
                 <span class="badge-job-meta" style="background: {{ $cardColor }}15; color: {{ $cardColor }}; border: 1px solid {{ $cardColor }}35;">
                     <i class="fa-solid fa-layer-group" style="font-size:0.7rem;"></i> {{ $job->area }}
                 </span>
                 <span class="badge-job-meta badge-job-type">
                     <i class="fa-regular fa-clock" style="font-size:0.7rem;"></i> {{ $job->type }}
                 </span>
                 <span class="badge-job-meta badge-job-location">
                     <i class="fa-solid fa-wifi" style="font-size:0.7rem;"></i> {{ $job->location }}
                 </span>
                 <span class="badge-job-meta badge-job-order" title="Orden de aparición">
                     #{{ $job->order }}
                 </span>
             </div>

             {{-- Actions Grid --}}
             <div class="svc-card-actions" onclick="event.stopPropagation();">
                 <button type="button" class="svc-card-btn svc-card-btn--preview" onclick="openPreviewModal({{ $job->id }})" title="Ver Vista Previa">
                     <i class="fa-solid fa-eye"></i>
                     <span>Previa</span>
                 </button>
                 <a href="{{ route('admin.job-offers.edit', $job->id) }}" class="svc-card-btn svc-card-btn--edit" title="Editar Vacante">
                     <i class="fa-solid fa-pen-to-square"></i>
                     <span>Editar</span>
                 </a>
                 <form action="{{ route('admin.job-offers.destroy', $job->id) }}" method="POST" class="d-inline form-delete-job" style="flex: 1;">
                     @csrf
                     @method('DELETE')
                     <button type="button" class="svc-card-btn svc-card-btn--delete btn-delete-job" title="Eliminar Vacante" style="width: 100%;">
                         <i class="fa-solid fa-trash-can"></i>
                     </button>
                 </form>
             </div>
         </div>
    </div>
    @empty
    <div class="svc-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px; border: 1.5px solid #e2e8f0;">
        <i class="fa-solid fa-briefcase mb-3" style="font-size: 3rem; color: #cbd5e1;"></i>
        <h3 style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">No se encontraron vacantes</h3>
        <p style="color: #64748b; max-width: 420px; margin: 0 auto 1.5rem;">Haz clic en "Nueva Vacante" para publicar la primera oportunidad laboral.</p>
        <a href="{{ route('admin.job-offers.create') }}" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i> Nueva Vacante
        </a>
    </div>
    @endforelse
</div>

@if($jobOffers->hasPages())
<div class="mt-4 p-3 background-white border-top" style="background: white; border-radius: 16px;">
    {{ $jobOffers->links() }}
</div>
@endif

{{-- ═══════════════════════════════════════════════════
     5. MODAL VISTA PREVIA
     ═══════════════════════════════════════════════════ --}}
<div class="svc-modal-backdrop" id="previewModalBackdrop" style="display: none;" onclick="closePreviewModal()">
    <div class="svc-modal" onclick="event.stopPropagation();" style="max-width: 600px;">
        <div class="svc-modal-header" id="modalHeaderBg" style="background: linear-gradient(135deg, #ff006e 0%, #8338ec 100%); color: white; padding: 1.5rem 2rem; border-radius: 20px 20px 0 0;">
            <div>
                <span class="badge bg-white text-dark mb-1 font-weight-bold" id="modalAreaBadge">Área</span>
                <h2 id="modalJobTitle" style="color: white; margin: 0; font-size: 1.35rem; font-weight: 800;">Título</h2>
            </div>
            <button type="button" class="svc-modal-close" onclick="closePreviewModal()" style="color: white; opacity: 0.8;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="svc-modal-body" style="padding: 2rem;">
            <div class="d-flex gap-2 flex-wrap mb-4">
                <span class="badge-job-meta badge-job-type" id="modalTypeBadge">Jornada</span>
                <span class="badge-job-meta badge-job-location" id="modalLocationBadge">Ubicación</span>
                <span class="badge-job-meta badge-job-order" id="modalOrderBadge">Orden</span>
            </div>

            <div class="mb-4">
                <h5 style="font-weight: 700; color: #0f172a; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px;">Descripción del Puesto:</h5>
                <p id="modalDescription" style="color: #475569; line-height: 1.7; font-size: 0.95rem; margin: 0;"></p>
            </div>

            <div id="modalRequirementsBox" class="p-3 border-start border-4 rounded" style="background: #f8fafc; border-color: #8338ec !important; display: none;">
                <h6 style="font-weight: 700; color: #8338ec; margin-bottom: 0.4rem;"><i class="fa-solid fa-list-check me-1"></i> Requisitos:</h6>
                <p id="modalRequirements" style="color: #334155; font-size: 0.9rem; margin: 0; line-height: 1.6;"></p>
            </div>
        </div>

        <div class="svc-modal-footer" style="padding: 1rem 2rem 1.5rem; background: #f8fafc; border-radius: 0 0 20px 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="#" id="modalEditBtn" class="admin-btn admin-btn-primary" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;">
                <i class="fa-solid fa-pen-to-square"></i> Editar Vacante
            </a>
            <button type="button" class="btn btn-light border" onclick="closePreviewModal()" style="border-radius: 10px; font-weight: 600;">Cerrar</button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const jobsData = @json($jobOffers->items());

    document.addEventListener('DOMContentLoaded', function() {
        // Search Filter
        const searchInput = document.getElementById('jobsSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', filterJobs);
        }

        // Filter Pills
        document.querySelectorAll('.svc-filter-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.svc-filter-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                filterJobs();
            });
        });

        // Shortcut '/'
        document.addEventListener('keydown', function(e) {
            if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                e.preventDefault();
                searchInput?.focus();
            }
        });

        // Toggle Active AJAX
        document.querySelectorAll('.toggle-job-active').forEach(function(switchEl) {
            switchEl.addEventListener('change', function() {
                const jobId = this.dataset.id;
                const isChecked = this.checked;
                const label = document.getElementById(`statusLabel-${jobId}`);

                fetch(`/admin/job-offers/${jobId}/toggle-active`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const cardItem = this.closest('.svc-card-item');
                        if (cardItem) cardItem.dataset.status = data.is_active ? 'active' : 'inactive';
                        if (label) label.textContent = data.is_active ? 'Activa' : 'Borrador';

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.is_active ? 'Vacante activada en la web' : 'Vacante cambiada a borrador'
                        });
                    }
                })
                .catch(err => {
                    this.checked = !isChecked;
                    Swal.fire('Error', 'No se pudo cambiar el estado.', 'error');
                });
            });
        });

        // Delete Confirm
        document.querySelectorAll('.btn-delete-job').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const form = this.closest('.form-delete-job');
                Swal.fire({
                    title: '¿Eliminar vacante?',
                    text: 'Esta acción no se puede deshacer y el puesto se quitará de la web.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    function filterJobs() {
        const query = (document.getElementById('jobsSearchInput')?.value || '').toLowerCase().trim();
        const activeFilter = document.querySelector('.svc-filter-pill.active')?.dataset.filter || 'all';

        document.querySelectorAll('#jobsGrid .svc-card-item').forEach(card => {
            const title = card.dataset.title || '';
            const area = card.dataset.area || '';
            const desc = card.dataset.desc || '';
            const status = card.dataset.status || 'all';

            const matchesSearch = title.includes(query) || area.includes(query) || desc.includes(query);
            const matchesFilter = (activeFilter === 'all') || (activeFilter === status);

            if (matchesSearch && matchesFilter) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openPreviewModal(id) {
        const job = jobsData.find(j => j.id == id);
        if (!job) return;

        document.getElementById('modalJobTitle').textContent = job.title;
        document.getElementById('modalAreaBadge').textContent = job.area;
        document.getElementById('modalTypeBadge').innerHTML = `<i class="fa-regular fa-clock me-1"></i> ${job.type}`;
        document.getElementById('modalLocationBadge').innerHTML = `<i class="fa-solid fa-wifi me-1"></i> ${job.location}`;
        document.getElementById('modalOrderBadge').textContent = `#${job.order}`;
        document.getElementById('modalDescription').textContent = job.description;

        const reqBox = document.getElementById('modalRequirementsBox');
        if (job.requirements && job.requirements.trim() !== '') {
            document.getElementById('modalRequirements').textContent = job.requirements;
            reqBox.style.display = 'block';
        } else {
            reqBox.style.display = 'none';
        }

        document.getElementById('modalEditBtn').href = `/admin/job-offers/${job.id}/edit`;
        document.getElementById('previewModalBackdrop').style.display = 'flex';
    }

    function closePreviewModal() {
        document.getElementById('previewModalBackdrop').style.display = 'none';
    }
</script>
@endpush

@endsection
