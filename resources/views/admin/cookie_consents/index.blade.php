@extends('admin.layouts.app')

@section('title', 'Auditoría IPs & Cookies')
@section('page-title', 'Auditoría IPs & Cookies')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    .audit-table-card {
        background: var(--admin-card-bg, #ffffff);
        border: 1px solid var(--admin-border-color, #e2e8f0);
        border-radius: var(--radius-lg, 20px);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    /* IP Badge - estilo terminal dark */
    .ip-badge-admin {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.86rem;
        font-weight: 700;
        background: #0f172a;
        color: #38bdf8;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .ip-copy-btn {
        background: transparent;
        border: none;
        color: #475569;
        cursor: pointer;
        padding: 0;
        font-size: 0.78rem;
        transition: color 0.2s ease;
    }
    .ip-copy-btn:hover { color: #38bdf8; }

    /* Fingerprint Badge */
    .fingerprint-badge {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.82rem;
        font-weight: 700;
        background: linear-gradient(135deg, rgba(131, 56, 236, 0.1), rgba(255, 0, 110, 0.08));
        color: #8338ec;
        border: 1px solid rgba(131, 56, 236, 0.25);
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        letter-spacing: 1px;
    }

    .consent-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid transparent;
    }
    .consent-badge--all {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.25);
    }
    .consent-badge--essential {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.25);
    }

    .device-info-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-main, #334155);
    }
    .browser-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(100, 116, 139, 0.08);
        color: var(--text-main, #334155);
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        font-size: 0.79rem;
        font-weight: 600;
        margin-top: 0.25rem;
    }
    .hw-meta-line {
        font-size: 0.77rem;
        color: var(--text-muted, #64748b);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.2rem;
    }
    .hw-chip {
        background: var(--light-gray, #f1f5f9);
        color: #64748b;
        padding: 0.15rem 0.45rem;
        border-radius: 5px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-excel-export {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        padding: 0.65rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none !important;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        transition: var(--transition);
    }
    .btn-excel-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. PAGE HEADER
     ═══════════════════════════════════════════════════ --}}
<div class="svc-header">
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-user-shield" style="color: var(--primary-color);"></i>
                Auditoría Forense de Accesos & Consentimientos
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Total Registros">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num">{{ $totalCount }}</span>
        </div>
        <div class="svc-header-stat-item" title="Aceptación Completa">
            <span class="svc-header-stat-lbl">Completos:</span>
            <span class="svc-header-stat-num text-success">{{ $allCount }}</span>
        </div>
        <div class="svc-header-stat-item" title="Solo Necesarias">
            <span class="svc-header-stat-lbl">Necesarias:</span>
            <span class="svc-header-stat-num text-info">{{ $essentialCount }}</span>
        </div>
        <div class="svc-header-stat-item" title="IPs Únicas">
            <span class="svc-header-stat-lbl">IPs Únicas:</span>
            <span class="svc-header-stat-num text-warning">{{ $uniqueIpsCount }}</span>
        </div>
        <div class="svc-header-stat-item" title="Dispositivos Únicos (Hardware Fingerprints)">
            <span class="svc-header-stat-lbl">Dispositivos:</span>
            <span class="svc-header-stat-num" style="color: #8338ec;">{{ $uniqueFingerprints }}</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     2. TOOLBAR
     ═══════════════════════════════════════════════════ --}}
<div class="svc-toolbar">
    <form action="{{ route('admin.cookie-consents.index') }}" method="GET" style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap; margin: 0;">
        <div class="svc-search-box" style="flex: 1; min-width: 240px;">
            <input type="text" name="search" class="svc-search-input" placeholder="Buscar por IP, fingerprint, navegador, OS..." value="{{ request('search') }}" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
        </div>

        <div style="min-width: 170px;">
            <select name="consent_type" class="form-select" onchange="this.form.submit()" style="border-radius: 10px; font-size: 0.85rem; padding: 0.6rem 0.9rem;">
                <option value="">Todos los tipos</option>
                <option value="all" {{ request('consent_type') === 'all' ? 'selected' : '' }}>Aceptación Completa</option>
                <option value="essential" {{ request('consent_type') === 'essential' ? 'selected' : '' }}>Solo Necesarias</option>
            </select>
        </div>

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" onchange="this.form.submit()" title="Desde fecha" style="border-radius: 10px; font-size: 0.85rem; width: 140px;">
            <span style="color: var(--text-muted); font-weight: 600;">—</span>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" onchange="this.form.submit()" title="Hasta fecha" style="border-radius: 10px; font-size: 0.85rem; width: 140px;">
        </div>

        @if(request()->hasAny(['search', 'consent_type', 'date_from', 'date_to']))
            <a href="{{ route('admin.cookie-consents.index') }}" class="btn btn-light border" style="border-radius: 10px; padding: 0.6rem 0.9rem; font-size: 0.85rem;" title="Limpiar Filtros">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        @endif
    </form>

    <a href="{{ route('admin.cookie-consents.export', request()->all()) }}" class="btn-excel-export">
        <i class="fa-solid fa-file-excel"></i>
        <span>Exportar Reporte Forense (.csv)</span>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════
     3. AUDIT TABLE
     ═══════════════════════════════════════════════════ --}}
<div class="audit-table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: var(--light-gray, #f8fafc); border-bottom: 2px solid var(--border-color, #e2e8f0);">
                <tr>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; width: 60px;">#</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Dirección IP</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Fingerprint Hw.</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Estado</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Dispositivo & Sistema</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Hardware & Red</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Pantalla & Origen</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Fecha & Hora (Perú)</th>
                    <th style="padding: 0.9rem 1rem; font-size: 0.78rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; text-align: right; width: 60px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($consents as $item)
                @php
                    $ua = strtolower($item->user_agent ?? '');
                    $browserName = $item->browser ?: 'Navegador';
                    $browserIcon = 'fa-globe';
                    if (str_contains($ua, 'chrome') && !str_contains($ua, 'edg')) $browserIcon = 'fa-chrome';
                    elseif (str_contains($ua, 'firefox')) $browserIcon = 'fa-firefox-browser';
                    elseif (str_contains($ua, 'safari') && !str_contains($ua, 'chrome')) $browserIcon = 'fa-safari';
                    elseif (str_contains($ua, 'edg')) $browserIcon = 'fa-edge';

                    $deviceType = $item->device_type ?: 'Desktop';
                    $deviceIcon = 'fa-desktop';
                    if ($deviceType === 'Mobile') $deviceIcon = 'fa-mobile-screen';
                    elseif ($deviceType === 'Tablet') $deviceIcon = 'fa-tablet-screen-button';
                @endphp
                <tr>
                    {{-- ID --}}
                    <td style="padding: 0.9rem 1rem; font-weight: 700; color: #94a3b8; font-size: 0.82rem;">#{{ $item->id }}</td>

                    {{-- IP --}}
                    <td style="padding: 0.9rem 1rem;">
                        <div class="ip-badge-admin">
                            <i class="fa-solid fa-terminal" style="font-size: 0.72rem;"></i>
                            <span>{{ $item->ip_address }}</span>
                            <button type="button" class="ip-copy-btn" onclick="copyText('{{ $item->ip_address }}', this)" title="Copiar IP">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>
                    </td>

                    {{-- Hardware Fingerprint --}}
                    <td style="padding: 0.9rem 1rem;">
                        @if($item->hardware_fingerprint)
                            <div class="fingerprint-badge">
                                <i class="fa-solid fa-fingerprint" style="font-size: 0.8rem;"></i>
                                <span>{{ $item->hardware_fingerprint }}</span>
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 0.8rem;">—</span>
                        @endif
                    </td>

                    {{-- Consent Type --}}
                    <td style="padding: 0.9rem 1rem;">
                        @if($item->consent_type === 'all')
                            <span class="consent-badge consent-badge--all">
                                <i class="fa-solid fa-check-circle"></i> Completa
                            </span>
                        @else
                            <span class="consent-badge consent-badge--essential">
                                <i class="fa-solid fa-cookie"></i> Necesarias
                            </span>
                        @endif
                    </td>

                    {{-- Device & OS --}}
                    <td style="padding: 0.9rem 1rem;">
                        <div class="device-info-tag">
                            <i class="fa-solid {{ $deviceIcon }}" style="color: var(--primary-color);"></i>
                            <span>{{ $deviceType }}</span>
                        </div>
                        <div class="hw-meta-line">
                            <i class="fa-brands {{ $browserIcon }}" style="color: #64748b;"></i>
                            <span>{{ $browserName }}</span>
                            <span style="color: #cbd5e1;">•</span>
                            <span>{{ $item->os ?: 'N/A' }}</span>
                        </div>
                    </td>

                    {{-- Hardware & Network --}}
                    <td style="padding: 0.9rem 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.3rem;">
                            @if($item->cpu_cores)
                                <span class="hw-chip"><i class="fa-solid fa-microchip me-1"></i>{{ $item->cpu_cores }}</span>
                            @endif
                            @if($item->device_memory)
                                <span class="hw-chip"><i class="fa-solid fa-memory me-1"></i>{{ $item->device_memory }}</span>
                            @endif
                            @if($item->connection_type)
                                <span class="hw-chip"><i class="fa-solid fa-wifi me-1"></i>{{ $item->connection_type }}</span>
                            @endif
                            @if($item->touch_points)
                                <span class="hw-chip"><i class="fa-regular fa-hand-pointer me-1"></i>{{ $item->touch_points }}</span>
                            @endif
                            @if(!$item->cpu_cores && !$item->device_memory && !$item->connection_type)
                                <span class="text-muted" style="font-size: 0.8rem;">Sin datos de hw.</span>
                            @endif
                        </div>
                    </td>

                    {{-- Screen, Lang & Page --}}
                    <td style="padding: 0.9rem 1rem;">
                        <div style="font-weight: 600; font-size: 0.83rem; color: var(--text-main);">
                            <i class="fa-solid fa-display text-muted me-1"></i>
                            {{ $item->screen_resolution ?: 'N/A' }}
                        </div>
                        <div class="hw-meta-line">
                            <i class="fa-solid fa-language" style="color: #64748b;"></i>
                            <span>{{ $item->language ?: 'N/A' }}</span>
                            <span style="color: #cbd5e1;">•</span>
                            <i class="fa-solid fa-globe" style="color: #64748b;"></i>
                            <span>{{ $item->timezone ?: 'N/A' }}</span>
                        </div>
                        @if($item->page_url)
                        <div style="font-size: 0.76rem; color: #64748b; margin-top: 0.2rem; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->page_url }}">
                            <i class="fa-solid fa-link me-1"></i>{{ parse_url($item->page_url, PHP_URL_PATH) ?: '/' }}
                        </div>
                        @endif
                    </td>

                    {{-- Timestamp --}}
                    <td style="padding: 0.9rem 1rem;">
                        <div style="font-weight: 600; font-size: 0.83rem; color: var(--text-main); white-space: nowrap;">
                            <i class="fa-regular fa-clock me-1 text-muted"></i>
                            {{ ($item->accepted_at ?? $item->created_at)->format('d/m/Y H:i:s') }}
                        </div>
                        <small style="font-size: 0.76rem; color: var(--text-muted);">
                            {{ ($item->accepted_at ?? $item->created_at)->diffForHumans() }}
                        </small>
                    </td>

                    {{-- Delete --}}
                    <td style="padding: 0.9rem 1rem; text-align: right;">
                        <form action="{{ route('admin.cookie-consents.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle text-danger" title="Eliminar registro" style="width: 32px; height: 32px; padding: 0;">
                                <i class="fa-solid fa-trash-can" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-user-shield mb-3 text-secondary" style="font-size: 2.5rem; opacity: 0.4;"></i>
                        <p class="mb-0 font-weight-bold">Sin registros de auditoría forense.</p>
                        <small>Los datos se registrarán automáticamente cuando los visitantes acepten el aviso de cookies.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($consents->hasPages())
    <div class="p-3 border-top" style="background: var(--light-gray, #f8fafc);">
        {{ $consents->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(function() {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check" style="color:#10b981;"></i>';
            setTimeout(() => btn.innerHTML = orig, 1500);
        });
    }
</script>
@endpush

@endsection
