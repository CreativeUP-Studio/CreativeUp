@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ═══════════════════════════════════════════════════
     STATS CARDS
     ═══════════════════════════════════════════════════ --}}
<div class="admin-stats">
    {{-- Servicios --}}
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--purple">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Servicios</h3>
            <p>{{ $stats['services'] }}</p>
        </div>
    </div>

    {{-- Proyectos --}}
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--blue">
            <i class="fa-solid fa-diagram-project"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Proyectos</h3>
            <p>{{ $stats['projects'] }}</p>
        </div>
    </div>

    {{-- Posts --}}
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--amber">
            <i class="fa-solid fa-newspaper"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Posts</h3>
            <p>{{ $stats['posts'] }}</p>
        </div>
    </div>

    {{-- Leads --}}
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--emerald">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="admin-stat-info">
            <h3>Leads</h3>
            <p>{{ $stats['leads'] }}</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     RECENT DATA TABLES
     ═══════════════════════════════════════════════════ --}}
<div class="admin-dashboard-grid">
    {{-- Leads recientes --}}
    <div class="admin-table-wrapper">
        <div class="admin-table-header">
            <h2>
                <i class="fa-solid fa-users" style="margin-right: 8px; color: var(--admin-success);"></i>
                Leads recientes
            </h2>
            <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                <span>Ver todos</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="admin-table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLeads as $lead)
                    <tr>
                        <td>
                            <strong>{{ $lead->name }}</strong>
                            <span class="text-muted">{{ $lead->email }}</span>
                        </td>
                        <td>{{ $lead->service->title ?? '—' }}</td>
                        <td>
                            @if($lead->status === 'new')
                                <span class="admin-badge admin-badge-green">Nuevo</span>
                            @elseif($lead->status === 'contacted')
                                <span class="admin-badge admin-badge-yellow">Contactado</span>
                            @else
                                <span class="admin-badge admin-badge-gray">Cerrado</span>
                            @endif
                        </td>
                        <td>{{ $lead->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-message">
                            <i class="fa-regular fa-folder-open" style="font-size: 2rem; color: var(--admin-text-muted); margin-bottom: 8px; display: block;"></i>
                            No hay leads aún
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Posts recientes --}}
    <div class="admin-table-wrapper">
        <div class="admin-table-header">
            <h2>
                <i class="fa-solid fa-newspaper" style="margin-right: 8px; color: var(--admin-warning);"></i>
                Posts recientes
            </h2>
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                <span>Ver todos</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="admin-table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPosts as $post)
                    <tr>
                        <td>
                            <strong>{{ Str::limit($post->title, 50) }}</strong>
                        </td>
                        <td>
                            @if($post->status === 'published')
                                <span class="admin-badge admin-badge-green">Publicado</span>
                            @else
                                <span class="admin-badge admin-badge-yellow">Borrador</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="empty-message">
                            <i class="fa-regular fa-folder-open" style="font-size: 2rem; color: var(--admin-text-muted); margin-bottom: 8px; display: block;"></i>
                            No hay posts aún
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
