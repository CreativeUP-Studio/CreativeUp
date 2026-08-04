@extends('admin.layouts.app')

@section('title', 'Vacantes y Puestos de Trabajo')
@section('page-title', 'Vacantes / Trabajos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    .job-table-card {
        background: var(--admin-card-bg, #ffffff);
        border: 1px solid var(--admin-border-color, #e2e8f0);
        border-radius: var(--radius-lg, 20px);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }
    .badge-area {
        background: rgba(131, 56, 236, 0.1);
        color: #8338ec;
        border: 1px solid rgba(131, 56, 236, 0.2);
        padding: 0.3rem 0.65rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .badge-type {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 0.3rem 0.65rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .badge-location {
        background: rgba(255, 0, 110, 0.08);
        color: #ff006e;
        border: 1px solid rgba(255, 0, 110, 0.2);
        padding: 0.3rem 0.65rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
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
        <div class="svc-search-box" style="flex: 1; min-width: 240px;">
            <input type="text" name="search" class="svc-search-input" placeholder="Buscar por título, área o descripción..." value="{{ request('search') }}" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
        </div>

        <div style="min-width: 160px;">
            <select name="status" class="form-select" onchange="this.form.submit()" style="border-radius: 10px; font-size: 0.85rem; padding: 0.6rem 0.9rem;">
                <option value="">Todos los estados</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivas</option>
            </select>
        </div>

        @if(request()->hasAny(['search', 'status', 'area']))
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
     3. TABLE OF JOBS
     ═══════════════════════════════════════════════════ --}}
<div class="job-table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: var(--light-gray, #f8fafc); border-bottom: 2px solid var(--border-color, #e2e8f0);">
                <tr>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; width: 60px;">Orden</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Título / Puesto</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Área</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Jornada</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Ubicación</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; text-align: center;">Estado</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; text-align: right; width: 120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobOffers as $job)
                <tr>
                    <td style="padding: 0.9rem 1rem; font-weight: 700; color: #94a3b8; font-size: 0.85rem;">#{{ $job->order }}</td>
                    <td style="padding: 0.9rem 1rem;">
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-main, #0f172a);">
                            {{ $job->title }}
                        </div>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.15rem;">
                            {{ Str::limit($job->description, 80) }}
                        </div>
                    </td>
                    <td style="padding: 0.9rem 1rem;">
                        <span class="badge-area">{{ $job->area }}</span>
                    </td>
                    <td style="padding: 0.9rem 1rem;">
                        <span class="badge-type">{{ $job->type }}</span>
                    </td>
                    <td style="padding: 0.9rem 1rem;">
                        <span class="badge-location"><i class="fa-solid fa-wifi me-1"></i> {{ $job->location }}</span>
                    </td>
                    <td style="padding: 0.9rem 1rem; text-align: center;">
                        <div class="form-check form-switch d-inline-block">
                            <input class="form-check-input toggle-job-active" type="checkbox" role="switch"
                                   data-id="{{ $job->id }}" {{ $job->is_active ? 'checked' : '' }}
                                   style="cursor: pointer; width: 2.2em; height: 1.1em;">
                        </div>
                    </td>
                    <td style="padding: 0.9rem 1rem; text-align: right;">
                        <div class="d-flex align-items-center justify-content-end gap-1">
                            <a href="{{ route('admin.job-offers.edit', $job->id) }}" class="btn btn-sm btn-light border text-primary" title="Editar vacante" style="border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.job-offers.destroy', $job->id) }}" method="POST" class="d-inline form-delete-job">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border text-danger btn-delete-job" title="Eliminar vacante" style="border-radius: 8px; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-briefcase mb-3 text-secondary" style="font-size: 2.5rem; opacity: 0.4;"></i>
                        <p class="mb-0 font-weight-bold">No se encontraron puestos de trabajo.</p>
                        <small>Haz clic en "Nueva Vacante" para agregar la primera oportunidad laboral.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jobOffers->hasPages())
    <div class="p-3 border-top" style="background: var(--light-gray, #f8fafc);">
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
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.is_active ? 'Vacante activada' : 'Vacante desactivada'
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
