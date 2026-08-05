@extends('admin.layouts.app')

@section('title', 'Logos de Clientes | CreativeUP Admin')
@section('page-title', 'Logos de Clientes')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    .client-logo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    .client-logo-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
        position: relative;
    }
    .client-logo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .client-logo-preview-box {
        width: 100%;
        height: 110px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        overflow: hidden;
    }
    .client-logo-preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .client-logo-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }
    .client-logo-footer {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px dashed #e2e8f0;
    }
    .client-btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
    }
    .client-btn-icon:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }
    .client-btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }
    .toggle-switch-sm {
        position: relative;
        display: inline-block;
        width: 36px;
        height: 20px;
    }
    .toggle-switch-sm input { opacity: 0; width: 0; height: 0; }
    .slider-sm {
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1; transition: .3s; border-radius: 20px;
    }
    .slider-sm:before {
        position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px;
        background-color: white; transition: .3s; border-radius: 50%;
    }
    input:checked + .slider-sm { background-color: #10b981; }
    input:checked + .slider-sm:before { transform: translateX(16px); }
</style>
@endpush

@section('content')

{{-- 1. COMPACT PAGE HEADER --}}
<div class="svc-header">
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-image" style="color: var(--primary-color);"></i>
                Logos de Clientes
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Total Logos">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num">{{ $totalClients }}</span>
        </div>
        <div class="svc-header-stat-item" title="Logos Activos">
            <span class="svc-header-stat-lbl">Activos:</span>
            <span class="svc-header-stat-num text-success">{{ $activeClients }}</span>
        </div>
        <div class="svc-header-stat-item" title="Logos Inactivos">
            <span class="svc-header-stat-lbl">Inactivos:</span>
            <span class="svc-header-stat-num text-danger">{{ $inactiveClients }}</span>
        </div>
    </div>
</div>

{{-- 2. TOOLBAR --}}
<div class="svc-toolbar">
    <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
        <div class="svc-filters">
            <a href="{{ route('admin.clients.index') }}" class="svc-filter-pill {{ !request('status') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Todos ({{ $totalClients }})</span>
            </a>
            <a href="{{ route('admin.clients.index', ['status' => 'active']) }}" class="svc-filter-pill {{ request('status') === 'active' ? 'active' : '' }}">
                <i class="fa-solid fa-circle-check"></i>
                <span>Activos ({{ $activeClients }})</span>
            </a>
            <a href="{{ route('admin.clients.index', ['status' => 'inactive']) }}" class="svc-filter-pill {{ request('status') === 'inactive' ? 'active' : '' }}">
                <i class="fa-solid fa-circle-pause"></i>
                <span>Inactivos ({{ $inactiveClients }})</span>
            </a>
        </div>
    </div>

    <a href="{{ route('admin.clients.create') }}" class="admin-btn admin-btn-primary">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <span>Subir Logo</span>
    </a>
</div>

{{-- Flash Feedback Messages --}}
@if(session('success'))
    <div class="svc-alert svc-alert-success" style="margin-top: 1rem;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- 3. LOGOS GRID --}}
@if($clients->count() > 0)
    <div class="client-logo-grid">
        @foreach($clients as $client)
            <div class="client-logo-card">
                <div class="client-logo-preview-box">
                    @if($client->logo_url)
                        <img src="{{ $client->logo_url }}" alt="{{ $client->name }}">
                    @else
                        <span style="font-weight: 800; font-size: 1.5rem; color: #ff006e;">{{ $client->initials }}</span>
                    @endif
                </div>

                <h4 class="client-logo-title" title="{{ $client->name }}">{{ $client->name }}</h4>

                <div class="client-logo-footer">
                    <form action="{{ route('admin.clients.toggle-active', $client->id) }}" method="POST" style="margin: 0; display: inline-flex; align-items: center;" title="Activar/Desactivar">
                        @csrf
                        @method('PATCH')
                        <label class="toggle-switch-sm">
                            <input type="checkbox" onchange="this.form.submit()" {{ $client->is_active ? 'checked' : '' }}>
                            <span class="slider-sm"></span>
                        </label>
                    </form>

                    <div style="display: flex; align-items: center; gap: 0.35rem;">
                        <a href="{{ route('admin.clients.edit', $client->id) }}" class="client-btn-icon" title="Editar logo">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('¿Estás seguro de eliminar este logo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="client-btn-icon client-btn-delete" title="Eliminar logo">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 2rem;">
        {{ $clients->links() }}
    </div>
@else
    <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px; margin-top: 1.5rem; border: 1px dashed #cbd5e1;">
        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
        <h3 style="color: #1e293b; font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">No hay logos subidos</h3>
        <p style="color: #64748b; margin-bottom: 1.5rem;">Sube las imágenes o logos de los clientes con los que trabajas.</p>
        <a href="{{ route('admin.clients.create') }}" class="admin-btn admin-btn-primary" style="display: inline-flex;">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span>Subir primer logo</span>
        </a>
    </div>
@endif

@endsection
