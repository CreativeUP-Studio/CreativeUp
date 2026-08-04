@extends('admin.layouts.app')

@section('title', 'Vacantes y Puestos de Trabajo')
@section('page-title', 'Vacantes / Trabajos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    /* Card Container */
    .job-table-card {
        background: var(--admin-card-bg, #ffffff);
        border: 1px solid var(--admin-border-color, #e2e8f0);
        border-radius: var(--radius-lg, 20px);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    /* Order Pill */
    .order-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 28px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 800;
        font-size: 0.82rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-family: 'Monaco', 'Consolas', monospace;
    }

    /* Badges */
    .job-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.8rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        white-space: nowrap;
    }
    .job-badge-area {
        background: rgba(131, 56, 236, 0.08);
        color: #8338ec;
        border: 1px solid rgba(131, 56, 236, 0.2);
    }
    .job-badge-type {
        background: rgba(16, 185, 129, 0.08);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .job-badge-location {
        background: rgba(255, 0, 110, 0.08);
        color: #ff006e;
        border: 1px solid rgba(255, 0, 110, 0.2);
    }

    /* iOS-Style Toggle Switch */
    .custom-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        margin: 0;
    }
    .custom-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .custom-switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s ease;
        border-radius: 50px;
    }
    .custom-switch-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s ease;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .custom-switch input:checked + .custom-switch-slider {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .custom-switch input:checked + .custom-switch-slider:before {
        transform: translateX(20px);
    }

    /* Action Buttons */
    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.88rem;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        transition: all 0.2s ease;
        text-decoration: none !important;
        cursor: pointer;
    }
    .btn-action-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    }
    .btn-action-edit:hover {
        background: linear-gradient(135deg, #8338ec, #3a0ca3);
        color: #ffffff;
        border-color: #8338ec;
    }
    .btn-action-delete:hover {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        border-color: #ef4444;
    }

    /* Responsive Modes */
    @media (max-width: 991.98px) {
        .desktop-table-view { display: none !important; }
        .mobile-cards-view { display: grid !important; grid-template-columns: 1fr; gap: 1rem; padding: 1rem; }
    }
    @media (min-width: 992px) {
        .desktop-table-view { display: block !important; }
        .mobile-cards-view { display: none !important; }
    }

    /* Mobile Job Card */
    .mobile-job-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .mobile-job-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    .mobile-job-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .mobile-job-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .mobile-job-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-bottom: 0.75rem;
    }
    .mobile-job-desc {
        font-size: 0.88rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .mobile-job-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px solid #f1f5f9;
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. COMPACT PAGE HEADER
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
        <div class="svc-header-stat-item" title="Vacantes Inactivas">
            <span class="svc-header-stat-lbl">Inactivas:</span>
            <span class="svc-header-stat-num text-warning">{{ $inactiveJobs }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     2. TOOLBAR (SEARCH, FILTERS & ACTION)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-toolbar">
    <form action="{{ route('admin.job-offers.index') }}" method="GET" style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap; margin: 0;">
        <div class="svc-search-box" style="flex: 1; min-width: 220px;">
            <input type="text" name="search" class="svc-search-input" placeholder="Buscar por título, área o descripción..." value="{{ request('search') }}" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
        </div>

        <div style="min-width: 150px;">
            <select name="status" class="form-select" onchange="this.form.submit()" style="border-radius: 10px; font-size: 0.85rem; padding: 0.6rem 0.9rem;">
                <option value="">Todos los estados</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivas</option>
            </select>
        </div>

        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.job-offers.index') }}" class="btn btn-light border" style="border-radius: 10px; padding: 0.6rem 0.9rem; font-size: 0.85rem;" title="Limpiar Filtros">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        @endif
    </form>

    <a href="{{ route('admin.job-offers.create') }}" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.65rem 1.25rem; font-size: 0.85rem; border-radius: 10px;">
        <i class="fa-solid fa-plus"></i>
        <span>Nueva Vacante</span>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════
     3. LISTING CONTAINER
     ═══════════════════════════════════════════════════ --}}
<div class="job-table-card">

    {{-- ── DESKTOP TABLE VIEW ───────────────────────── --}}
    <div class="desktop-table-view table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800; width: 70px;">Orden</th>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800;">Título / Puesto</th>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800;">Área</th>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800;">Jornada</th>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800;">Ubicación</th>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800; text-align: center; width: 100px;">Estado</th>
                    <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 800; text-align: right; width: 110px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobOffers as $job)
                <tr>
                    <td style="padding: 1rem;">
                        <span class="order-pill">#{{ $job->order }}</span>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="font-weight: 700; font-size: 0.95rem; color: #0f172a;">
                            {{ $job->title }}
                        </div>
                        <div style="font-size: 0.82rem; color: #64748b; margin-top: 0.2rem; max-width: 380px;">
                            {{ Str::limit($job->description, 85) }}
                        </div>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="job-badge job-badge-area">
                            <i class="fa-solid fa-layer-group" style="font-size:0.7rem;"></i>
                            {{ $job->area }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="job-badge job-badge-type">
                            <i class="fa-regular fa-clock" style="font-size:0.7rem;"></i>
                            {{ $job->type }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="job-badge job-badge-location">
                            <i class="fa-solid fa-wifi" style="font-size:0.7rem;"></i>
                            {{ $job->location }}
                        </span>
                    </td>
                    <td style="padding: 1rem; text-align: center;">
                        <label class="custom-switch" title="{{ $job->is_active ? 'Activa en la web' : 'Inactiva (Oculta)' }}">
                            <input type="checkbox" class="toggle-job-active" data-id="{{ $job->id }}" {{ $job->is_active ? 'checked' : '' }}>
                            <span class="custom-switch-slider"></span>
                        </label>
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('admin.job-offers.edit', $job->id) }}" class="btn-action-icon btn-action-edit" title="Editar vacante">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.job-offers.destroy', $job->id) }}" method="POST" class="d-inline form-delete-job">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-action-icon btn-action-delete btn-delete-job" title="Eliminar vacante">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-briefcase mb-3" style="font-size: 2.5rem; opacity: 0.3; color: #64748b;"></i>
                        <p class="mb-0 font-weight-bold" style="color: #0f172a;">No se encontraron puestos de trabajo.</p>
                        <small>Haz clic en "Nueva Vacante" para agregar la primera oportunidad laboral.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── MOBILE CARDS VIEW ────────────────────────── --}}
    <div class="mobile-cards-view">
        @forelse($jobOffers as $job)
        <div class="mobile-job-card">
            <div class="mobile-job-header">
                <span class="order-pill">#{{ $job->order }}</span>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size:0.75rem; font-weight:700; color: {{ $job->is_active ? '#10b981' : '#94a3b8' }};">
                        {{ $job->is_active ? 'Publicado' : 'Borrador' }}
                    </span>
                    <label class="custom-switch">
                        <input type="checkbox" class="toggle-job-active" data-id="{{ $job->id }}" {{ $job->is_active ? 'checked' : '' }}>
                        <span class="custom-switch-slider"></span>
                    </label>
                </div>
            </div>

            <div class="mobile-job-title">{{ $job->title }}</div>

            <div class="mobile-job-tags">
                <span class="job-badge job-badge-area">{{ $job->area }}</span>
                <span class="job-badge job-badge-type">{{ $job->type }}</span>
                <span class="job-badge job-badge-location"><i class="fa-solid fa-wifi me-1"></i>{{ $job->location }}</span>
            </div>

            <p class="mobile-job-desc">{{ Str::limit($job->description, 110) }}</p>

            <div class="mobile-job-footer">
                <span style="font-size:0.75rem; color:#94a3b8;">
                    {{ $job->created_at ? $job->created_at->format('d/m/Y') : '' }}
                </span>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.job-offers.edit', $job->id) }}" class="btn-action-icon btn-action-edit" title="Editar">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('admin.job-offers.destroy', $job->id) }}" method="POST" class="d-inline form-delete-job">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-action-icon btn-action-delete btn-delete-job" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-briefcase mb-3" style="font-size: 2.5rem; opacity: 0.3; color: #64748b;"></i>
            <p class="mb-0 font-weight-bold" style="color: #0f172a;">No se encontraron puestos de trabajo.</p>
        </div>
        @endforelse
    </div>

    @if($jobOffers->hasPages())
    <div class="p-3 border-top" style="background: #f8fafc;">
        {{ $jobOffers->links() }}
    </div>
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Active AJAX
        document.querySelectorAll('.toggle-job-active').forEach(function(switchEl) {
            switchEl.addEventListener('change', function() {
                const jobId = this.dataset.id;
                const isChecked = this.checked;

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
                        // Sincronizar todos los switches con el mismo ID (desktop y mobile)
                        document.querySelectorAll(`.toggle-job-active[data-id="${jobId}"]`).forEach(sw => sw.checked = data.is_active);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.is_active ? 'Vacante activada en la web' : 'Vacante desactivada (Oculta)'
                        });
                    }
                })
                .catch(err => {
                    this.checked = !isChecked;
                    Swal.fire('Error', 'No se pudo cambiar el estado de la vacante.', 'error');
                });
            });
        });

        // Delete Confirm
        document.querySelectorAll('.btn-delete-job').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const form = this.closest('.form-delete-job');
                Swal.fire({
                    title: '¿Eliminar vacante?',
                    text: 'Esta acción no se puede deshacer y la oferta desaparecerá de la web.',
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
</script>
@endpush

@endsection
