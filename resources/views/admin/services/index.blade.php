@extends('admin.layouts.app')

@section('title', 'Servicios')
@section('page-title', 'Servicios')

@section('content')

{{-- ═══════════════════════════════════════════════════
     HEADER HERO
     ═══════════════════════════════════════════════════ --}}
<div class="services-hero">
    <div class="services-hero-content">
        <div class="services-hero-icon">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <div class="services-hero-text">
            <h1>Gestionar Servicios</h1>
            <p>Configura y administra los servicios que ofreces a tus clientes</p>
        </div>
    </div>
    <a href="{{ route('admin.services.create') }}" class="services-hero-btn">
        <i class="fa-solid fa-plus"></i>
        <span>Nuevo Servicio</span>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════
     STATS
     ═══════════════════════════════════════════════════ --}}
<div class="services-stats">
    <div class="services-stat services-stat--total">
        <div class="services-stat-icon">
            <i class="fa-solid fa-cubes"></i>
        </div>
        <div class="services-stat-content">
            <span class="services-stat-value">{{ $services->total() }}</span>
            <span class="services-stat-label">Total Servicios</span>
        </div>
    </div>
    <div class="services-stat services-stat--active">
        <div class="services-stat-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="services-stat-content">
            <span class="services-stat-value">{{ $services->where('is_active', true)->count() }}</span>
            <span class="services-stat-label">Activos</span>
        </div>
    </div>
    <div class="services-stat services-stat--inactive">
        <div class="services-stat-icon">
            <i class="fa-solid fa-circle-pause"></i>
        </div>
        <div class="services-stat-content">
            <span class="services-stat-value">{{ $services->where('is_active', false)->count() }}</span>
            <span class="services-stat-label">Inactivos</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     SERVICES LIST
     ═══════════════════════════════════════════════════ --}}
@if($services->count() > 0)
<div class="services-grid">
    @foreach($services as $service)
    <article class="service-card" style="--service-color: {{ $service->color ?? '#7c3aed' }}">
        {{-- Image Header --}}
        <div class="service-card-header">
            @if($service->image)
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="service-card-img">
            @else
                <div class="service-card-placeholder">
                    @if($service->icon)
                        @if(Str::startsWith($service->icon, 'fa-'))
                            <i class="{{ $service->icon }}"></i>
                        @else
                            <span class="service-card-emoji">{{ $service->icon }}</span>
                        @endif
                    @else
                        <i class="fa-solid fa-shapes"></i>
                    @endif
                </div>
            @endif

            {{-- Status Badge --}}
            <div class="service-card-status {{ $service->is_active ? 'active' : 'inactive' }}">
                <i class="fa-solid fa-circle"></i>
                {{ $service->is_active ? 'Activo' : 'Inactivo' }}
            </div>

            {{-- Order Badge --}}
            @if($service->order)
            <div class="service-card-order">#{{ $service->order }}</div>
            @endif

            {{-- Color Indicator --}}
            <div class="service-card-color"></div>
        </div>

        {{-- Content --}}
        <div class="service-card-body">
            {{-- Title with Icon --}}
            <div class="service-card-title-row">
                @if($service->icon)
                    @if(Str::startsWith($service->icon, 'fa-'))
                        <span class="service-card-icon"><i class="{{ $service->icon }}"></i></span>
                    @else
                        <span class="service-card-icon">{{ $service->icon }}</span>
                    @endif
                @endif
                <h3 class="service-card-title">{{ $service->title }}</h3>
            </div>

            {{-- Slug --}}
            <p class="service-card-slug">/servicios/{{ $service->slug }}</p>

            {{-- Description --}}
            @if($service->short_description)
            <p class="service-card-desc">{{ Str::limit($service->short_description, 90) }}</p>
            @endif

            {{-- Tags --}}
            <div class="service-card-tags">
                @if($service->features && count($service->features) > 0)
                <span class="service-tag service-tag--purple">
                    <i class="fa-solid fa-list-check"></i>
                    {{ count($service->features) }} características
                </span>
                @endif
                @if($service->benefits && count($service->benefits) > 0)
                <span class="service-tag service-tag--amber">
                    <i class="fa-solid fa-star"></i>
                    {{ count($service->benefits) }} beneficios
                </span>
                @endif
                @if($service->process_steps && count($service->process_steps) > 0)
                <span class="service-tag service-tag--blue">
                    <i class="fa-solid fa-route"></i>
                    {{ count($service->process_steps) }} pasos
                </span>
                @endif
            </div>
        </div>

        {{-- Actions Footer --}}
        <div class="service-card-footer">
            <a href="{{ route('admin.services.edit', $service) }}" class="service-action service-action--edit">
                <i class="fa-solid fa-pen-to-square"></i>
                Editar
            </a>
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                  onsubmit="return confirm('¿Eliminar el servicio {{ $service->title }}?')" class="service-action-form">
                @csrf @method('DELETE')
                <button type="submit" class="service-action service-action--delete">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
    </article>
    @endforeach
</div>

{{-- Pagination --}}
@if($services->hasPages())
<div class="admin-pagination">{{ $services->links() }}</div>
@endif

@else
{{-- Empty State --}}
<div class="services-empty">
    <div class="services-empty-icon">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
    </div>
    <h3>No hay servicios todavía</h3>
    <p>Comienza creando tu primer servicio para mostrarlo en tu sitio web</p>
    <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary admin-btn-lg">
        <i class="fa-solid fa-plus"></i>
        Crear primer servicio
    </a>
</div>
@endif

<style>
/* ═══════════════════════════════════════════════════
   SERVICES MODULE - CUSTOM STYLES
   ═══════════════════════════════════════════════════ */

/* Hero Section */
.services-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    padding: 2.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px -10px rgba(102, 126, 234, 0.4);
    position: relative;
    overflow: hidden;
}

.services-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
    pointer-events: none;
}

.services-hero-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.services-hero-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.services-hero-text h1 {
    margin: 0 0 0.5rem 0;
    font-size: 2rem;
    font-weight: 800;
    color: white;
    letter-spacing: -0.02em;
}

.services-hero-text p {
    margin: 0;
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
}

.services-hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    padding: 1rem 1.75rem;
    background: white;
    color: #764ba2;
    font-size: 0.9375rem;
    font-weight: 700;
    text-decoration: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.services-hero-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

/* Stats Section */
.services-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.services-stat {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 16px;
    border: 1px solid #f3f4f6;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
}

.services-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.services-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.375rem;
}

.services-stat--total .services-stat-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.services-stat--active .services-stat-icon {
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
}

.services-stat--inactive .services-stat-icon {
    background: linear-gradient(135deg, #6b7280, #9ca3af);
    color: white;
}

.services-stat-content {
    display: flex;
    flex-direction: column;
}

.services-stat-value {
    font-size: 1.875rem;
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1;
}

.services-stat-label {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Services Grid */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 1.5rem;
}

/* Service Card */
.service-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #f3f4f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.service-card-header {
    position: relative;
    height: 180px;
    background: linear-gradient(135deg, color-mix(in srgb, var(--service-color) 15%, white), color-mix(in srgb, var(--service-color) 5%, white));
    overflow: hidden;
}

.service-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.service-card:hover .service-card-img {
    transform: scale(1.05);
}

.service-card-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-card-placeholder i {
    font-size: 3.5rem;
    color: var(--service-color);
    opacity: 0.3;
}

.service-card-emoji {
    font-size: 4rem;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
}

.service-card-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 700;
    backdrop-filter: blur(8px);
}

.service-card-status.active {
    background: rgba(16, 185, 129, 0.95);
    color: white;
}

.service-card-status.inactive {
    background: rgba(107, 114, 128, 0.95);
    color: white;
}

.service-card-status i {
    font-size: 0.5rem;
}

.service-card-order {
    position: absolute;
    top: 1rem;
    left: 1rem;
    width: 32px;
    height: 32px;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 800;
}

.service-card-color {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--service-color);
}

/* Card Body */
.service-card-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.service-card-title-row {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 0.375rem;
}

.service-card-icon {
    font-size: 1.5rem;
}

.service-card-icon i {
    color: var(--service-color);
}

.service-card-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.3;
}

.service-card-slug {
    margin: 0 0 0.75rem 0;
    font-size: 0.75rem;
    font-family: 'SF Mono', 'Fira Code', monospace;
    color: #9ca3af;
}

.service-card-desc {
    margin: 0 0 1rem 0;
    font-size: 0.875rem;
    line-height: 1.6;
    color: #6b7280;
    flex: 1;
}

/* Tags */
.service-card-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.service-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.6875rem;
    font-weight: 600;
}

.service-tag i {
    font-size: 0.625rem;
}

.service-tag--purple {
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(168, 85, 247, 0.05));
    color: #7c3aed;
}

.service-tag--amber {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.05));
    color: #d97706;
}

.service-tag--blue {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.05));
    color: #2563eb;
}

/* Card Footer */
.service-card-footer {
    display: flex;
    border-top: 1px solid #f3f4f6;
}

.service-action {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    background: transparent;
}

.service-action--edit {
    color: #7c3aed;
    border-right: 1px solid #f3f4f6;
}

.service-action--edit:hover {
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.05), rgba(168, 85, 247, 0.02));
    color: #5e17eb;
}

.service-action--delete {
    color: #ef4444;
    width: 56px;
}

.service-action--delete:hover {
    background: rgba(239, 68, 68, 0.05);
    color: #dc2626;
}

.service-action-form {
    margin: 0;
}

/* Empty State */
.services-empty {
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 20px;
    border: 2px dashed #e5e7eb;
}

.services-empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.services-empty-icon i {
    font-size: 2.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.services-empty h3 {
    margin: 0 0 0.75rem 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
}

.services-empty p {
    margin: 0 0 2rem 0;
    font-size: 1rem;
    color: #6b7280;
}

/* Responsive */
@media (max-width: 768px) {
    .services-hero {
        flex-direction: column;
        text-align: center;
        padding: 2rem;
    }

    .services-hero-content {
        flex-direction: column;
    }

    .services-stats {
        grid-template-columns: 1fr;
    }

    .services-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
