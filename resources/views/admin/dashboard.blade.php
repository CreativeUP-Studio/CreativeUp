@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ═══════════════════════════════════════════════════
     BIENVENIDA Y RESUMEN
     ═══════════════════════════════════════════════════ --}}
<div class="dashboard-welcome">
    <div class="welcome-content">
        <h2>¡Hola de nuevo! 👋</h2>
        <p>Aquí tienes un resumen de tu actividad. Todo está funcionando correctamente.</p>
    </div>
    <div class="welcome-date">
        <i class="fa-regular fa-calendar"></i>
        <span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM') }}</span>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     STATS CARDS MEJORADAS
     ═══════════════════════════════════════════════════ --}}
<div class="dashboard-stats">
    {{-- Servicios --}}
    <div class="stat-card stat-card--purple">
        <div class="stat-card-bg"></div>
        <div class="stat-card-content">
            <div class="stat-icon">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['services'] }}</span>
                <span class="stat-label">Servicios</span>
            </div>
        </div>
        <a href="{{ route('admin.services.index') }}" class="stat-link">
            <span>Ver todos</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    {{-- Proyectos --}}
    <div class="stat-card stat-card--blue">
        <div class="stat-card-bg"></div>
        <div class="stat-card-content">
            <div class="stat-icon">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['projects'] }}</span>
                <span class="stat-label">Proyectos</span>
            </div>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="stat-link">
            <span>Ver todos</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    {{-- Posts --}}
    <div class="stat-card stat-card--amber">
        <div class="stat-card-bg"></div>
        <div class="stat-card-content">
            <div class="stat-icon">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['posts'] }}</span>
                <span class="stat-label">Posts</span>
            </div>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="stat-link">
            <span>Ver todos</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    {{-- Leads --}}
    <div class="stat-card stat-card--emerald">
        <div class="stat-card-bg"></div>
        <div class="stat-card-content">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['leads'] }}</span>
                <span class="stat-label">Leads</span>
            </div>
        </div>
        <a href="{{ route('admin.leads.index') }}" class="stat-link">
            <span>Ver todos</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     ACCIONES RÁPIDAS
     ═══════════════════════════════════════════════════ --}}
<div class="dashboard-quick-actions">
    <h3 class="section-title">
        <i class="fa-solid fa-bolt"></i>
        Acciones rápidas
    </h3>
    <div class="quick-actions-grid">
        <a href="{{ route('admin.services.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--purple">
                <i class="fa-solid fa-plus"></i>
            </div>
            <span>Nuevo Servicio</span>
        </a>
        <a href="{{ route('admin.projects.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--blue">
                <i class="fa-solid fa-plus"></i>
            </div>
            <span>Nuevo Proyecto</span>
        </a>
        <a href="{{ route('admin.posts.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--amber">
                <i class="fa-solid fa-plus"></i>
            </div>
            <span>Nuevo Post</span>
        </a>
        <a href="{{ route('admin.leads.index') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--emerald">
                <i class="fa-solid fa-inbox"></i>
            </div>
            <span>Ver Leads</span>
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     TABLAS DE DATOS RECIENTES
     ═══════════════════════════════════════════════════ --}}
<div class="dashboard-tables">
    {{-- Leads recientes --}}
    <div class="dashboard-table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <div class="table-card-icon table-card-icon--emerald">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <h3>Leads recientes</h3>
                    <p>Últimas solicitudes de contacto</p>
                </div>
            </div>
            <a href="{{ route('admin.leads.index') }}" class="table-card-action">
                Ver todos
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-card-body">
            @forelse($recentLeads as $lead)
            <div class="table-item">
                <div class="table-item-avatar">
                    {{ strtoupper(substr($lead->name, 0, 1)) }}
                </div>
                <div class="table-item-info">
                    <strong>{{ $lead->name }}</strong>
                    <span>{{ $lead->email }}</span>
                </div>
                <div class="table-item-meta">
                    <span class="table-item-service">{{ $lead->service->title ?? '—' }}</span>
                    @if($lead->status === 'new')
                        <span class="status-badge status-badge--green">Nuevo</span>
                    @elseif($lead->status === 'contacted')
                        <span class="status-badge status-badge--yellow">Contactado</span>
                    @else
                        <span class="status-badge status-badge--gray">Cerrado</span>
                    @endif
                </div>
                <div class="table-item-date">
                    {{ $lead->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="table-empty">
                <div class="table-empty-icon">
                    <i class="fa-regular fa-inbox"></i>
                </div>
                <p>No hay leads aún</p>
                <span>Los nuevos leads aparecerán aquí</span>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Posts recientes --}}
    <div class="dashboard-table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <div class="table-card-icon table-card-icon--amber">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <div>
                    <h3>Posts recientes</h3>
                    <p>Últimas publicaciones del blog</p>
                </div>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="table-card-action">
                Ver todos
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-card-body">
            @forelse($recentPosts as $post)
            <div class="table-item">
                <div class="table-item-thumb">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="">
                    @else
                        <i class="fa-solid fa-image"></i>
                    @endif
                </div>
                <div class="table-item-info table-item-info--wide">
                    <strong>{{ Str::limit($post->title, 45) }}</strong>
                    <span>{{ $post->category->name ?? 'Sin categoría' }}</span>
                </div>
                <div class="table-item-meta">
                    @if($post->status === 'published')
                        <span class="status-badge status-badge--green">Publicado</span>
                    @else
                        <span class="status-badge status-badge--yellow">Borrador</span>
                    @endif
                </div>
                <div class="table-item-date">
                    {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="table-empty">
                <div class="table-empty-icon">
                    <i class="fa-regular fa-newspaper"></i>
                </div>
                <p>No hay posts aún</p>
                <span>Crea tu primer post del blog</span>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════════════
   DASHBOARD - ESTILOS MEJORADOS
   ═══════════════════════════════════════════════════ */

/* Bienvenida */
.dashboard-welcome {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}

.dashboard-welcome::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.dashboard-welcome::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: 20%;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}

.welcome-content {
    position: relative;
    z-index: 1;
}

.welcome-content h2 {
    margin: 0 0 6px 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.welcome-content p {
    margin: 0;
    font-size: 0.95rem;
    color: rgba(255,255,255,0.85);
}

.welcome-date {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    padding: 12px 20px;
    border-radius: 12px;
    color: white;
    font-size: 0.9rem;
    font-weight: 500;
    position: relative;
    z-index: 1;
}

.welcome-date i {
    font-size: 1.1rem;
}

/* Stats Cards Mejoradas */
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}

.stat-card {
    position: relative;
    background: white;
    border-radius: 16px;
    padding: 24px;
    overflow: hidden;
    border: 1px solid var(--admin-border);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}

.stat-card-bg {
    position: absolute;
    top: 0;
    right: 0;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    transform: translate(30%, -30%);
    opacity: 0.1;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-card-bg {
    transform: translate(25%, -25%) scale(1.1);
    opacity: 0.15;
}

.stat-card--purple .stat-card-bg { background: linear-gradient(135deg, #7c3aed, #a855f7); }
.stat-card--blue .stat-card-bg { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.stat-card--amber .stat-card-bg { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
.stat-card--emerald .stat-card-bg { background: linear-gradient(135deg, #10b981, #34d399); }

.stat-card-content {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
}

.stat-card--purple .stat-icon { background: linear-gradient(135deg, #7c3aed, #a855f7); color: white; }
.stat-card--blue .stat-icon { background: linear-gradient(135deg, #3b82f6, #60a5fa); color: white; }
.stat-card--amber .stat-icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; }
.stat-card--emerald .stat-icon { background: linear-gradient(135deg, #10b981, #34d399); color: white; }

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--admin-text);
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--admin-text-secondary);
    font-weight: 500;
    margin-top: 4px;
}

.stat-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px;
    background: var(--admin-surface-hover);
    border-radius: 10px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--admin-text-secondary);
    transition: all 0.2s ease;
    position: relative;
    z-index: 1;
}

.stat-link:hover {
    background: var(--admin-gradient-subtle);
    color: var(--admin-primary);
}

.stat-link i {
    font-size: 0.75rem;
    transition: transform 0.2s ease;
}

.stat-link:hover i {
    transform: translateX(3px);
}

/* Acciones Rápidas */
.dashboard-quick-actions {
    margin-bottom: 28px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: var(--admin-text);
    margin: 0 0 16px 0;
}

.section-title i {
    color: var(--admin-primary);
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.quick-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 24px 16px;
    background: white;
    border: 1px solid var(--admin-border);
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.quick-action-card:hover {
    border-color: var(--admin-primary);
    box-shadow: 0 8px 20px rgba(124, 58, 237, 0.12);
    transform: translateY(-2px);
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.quick-action-icon--purple { background: rgba(124, 58, 237, 0.1); color: #7c3aed; }
.quick-action-icon--blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.quick-action-icon--amber { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
.quick-action-icon--emerald { background: rgba(16, 185, 129, 0.1); color: #10b981; }

.quick-action-card:hover .quick-action-icon--purple { background: linear-gradient(135deg, #7c3aed, #a855f7); color: white; }
.quick-action-card:hover .quick-action-icon--blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); color: white; }
.quick-action-card:hover .quick-action-icon--amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; }
.quick-action-card:hover .quick-action-icon--emerald { background: linear-gradient(135deg, #10b981, #34d399); color: white; }

.quick-action-card span {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--admin-text);
}

/* Tablas Dashboard */
.dashboard-tables {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.dashboard-table-card {
    background: white;
    border: 1px solid var(--admin-border);
    border-radius: 16px;
    overflow: hidden;
}

.table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--admin-border-light);
}

.table-card-title {
    display: flex;
    align-items: center;
    gap: 14px;
}

.table-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.table-card-icon--emerald { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.table-card-icon--amber { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

.table-card-title h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 700;
    color: var(--admin-text);
}

.table-card-title p {
    margin: 2px 0 0 0;
    font-size: 0.8rem;
    color: var(--admin-text-muted);
}

.table-card-action {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--admin-primary);
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.table-card-action:hover {
    background: var(--admin-gradient-subtle);
}

.table-card-action i {
    font-size: 0.7rem;
    transition: transform 0.2s ease;
}

.table-card-action:hover i {
    transform: translateX(3px);
}

.table-card-body {
    padding: 8px;
}

.table-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 10px;
    transition: background 0.2s ease;
}

.table-item:hover {
    background: var(--admin-surface-hover);
}

.table-item-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    flex-shrink: 0;
}

.table-item-thumb {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: var(--admin-surface-hover);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.table-item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.table-item-thumb i {
    color: var(--admin-text-muted);
    font-size: 1rem;
}

.table-item-info {
    flex: 1;
    min-width: 0;
}

.table-item-info--wide {
    flex: 2;
}

.table-item-info strong {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--admin-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table-item-info span {
    display: block;
    font-size: 0.75rem;
    color: var(--admin-text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table-item-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.table-item-service {
    font-size: 0.75rem;
    color: var(--admin-text-secondary);
}

.table-item-date {
    font-size: 0.75rem;
    color: var(--admin-text-muted);
    white-space: nowrap;
}

.status-badge {
    display: inline-flex;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.status-badge--green {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-badge--yellow {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-badge--gray {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.table-empty {
    padding: 48px 24px;
    text-align: center;
}

.table-empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: var(--admin-surface-hover);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.table-empty-icon i {
    font-size: 1.5rem;
    color: var(--admin-text-muted);
}

.table-empty p {
    margin: 0 0 4px 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--admin-text);
}

.table-empty span {
    font-size: 0.85rem;
    color: var(--admin-text-muted);
}

/* Responsive */
@media (max-width: 1200px) {
    .dashboard-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .dashboard-tables {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-welcome {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .dashboard-stats {
        grid-template-columns: 1fr;
    }
    
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .table-item {
        flex-wrap: wrap;
    }
    
    .table-item-meta {
        order: 3;
        width: 100%;
        flex-direction: row;
        justify-content: space-between;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid var(--admin-border-light);
    }
}
</style>
@endpush
