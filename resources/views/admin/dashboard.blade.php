@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="admin-stats">
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--purple">
            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
        </div>
        <div class="admin-stat-info">
            <h3>Servicios</h3>
            <p>{{ $stats['services'] }}</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--blue">
            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="admin-stat-info">
            <h3>Proyectos</h3>
            <p>{{ $stats['projects'] }}</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--amber">
            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        <div class="admin-stat-info">
            <h3>Posts</h3>
            <p>{{ $stats['posts'] }}</p>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon admin-stat-icon--emerald">
            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div class="admin-stat-info">
            <h3>Leads</h3>
            <p>{{ $stats['leads'] }}</p>
        </div>
    </div>
</div>

<div class="admin-dashboard-grid">
    {{-- Leads recientes --}}
    <div class="admin-table-wrapper">
        <div class="admin-table-header">
            <h2>Leads recientes</h2>
            <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Ver todos</a>
        </div>
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
                        <strong>{{ $lead->name }}</strong><br>
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
                <tr><td colspan="4" class="empty-message">No hay leads aún</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Posts recientes --}}
    <div class="admin-table-wrapper">
        <div class="admin-table-header">
            <h2>Posts recientes</h2>
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Ver todos</a>
        </div>
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
                    <td>{{ Str::limit($post->title, 40) }}</td>
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
                <tr><td colspan="3" class="empty-message">No hay posts aún</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
