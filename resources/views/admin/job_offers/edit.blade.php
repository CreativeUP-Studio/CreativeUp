@extends('admin.layouts.app')

@section('title', 'Editar Vacante: ' . $jobOffer->title)
@section('page-title', 'Editar Vacante')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    .form-card {
        background: #ffffff;
        border: 1px solid var(--admin-border-color, #e2e8f0);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="svc-header mb-4">
    <div class="svc-header-left">
        <a href="{{ route('admin.job-offers.index') }}" class="btn btn-light border me-3" style="border-radius: 10px;" title="Volver al listado">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-pen-to-square" style="color: var(--primary-color);"></i>
                Editar Vacante: {{ $jobOffer->title }}
            </h1>
        </div>
    </div>
</div>

<form action="{{ route('admin.job-offers.update', $jobOffer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- Principal Col --}}
        <div class="col-lg-8">
            <div class="form-card">
                <h4 style="font-weight: 700; font-size: 1.1rem; color: #0f172a; margin-bottom: 1.5rem;">
                    Información de la Vacante
                </h4>

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label font-weight-bold">Título del Puesto <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $jobOffer->title) }}" placeholder="Ej. Diseñador UI/UX Senior" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label text-muted" style="font-size: 0.85rem;">Slug (URL amigable)</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $jobOffer->slug) }}" placeholder="Se genera automáticamente si se deja vacío">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label font-weight-bold">Descripción del Puesto <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Describe los objetivos del puesto, funciones principales y lo que esperan del candidato..." required>{{ old('description', $jobOffer->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Requirements --}}
                <div class="mb-3">
                    <label for="requirements" class="form-label font-weight-bold">Requisitos & Habilidades (Opcional)</label>
                    <textarea name="requirements" id="requirements" rows="4" class="form-control @error('requirements') is-invalid @enderror" placeholder="Ej. 2+ años de experiencia en Laravel, Figma avanzado, nivel de inglés intermedio...">{{ old('requirements', $jobOffer->requirements) }}</textarea>
                    @error('requirements')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Sidebar Col --}}
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <h4 style="font-weight: 700; font-size: 1.1rem; color: #0f172a; margin-bottom: 1.5rem;">
                    Configuración
                </h4>

                {{-- Area --}}
                <div class="mb-3">
                    <label for="area" class="form-label font-weight-bold">Área / Departamento <span class="text-danger">*</span></label>
                    <select name="area" id="area" class="form-select @error('area') is-invalid @enderror" required>
                        @php $currentArea = old('area', $jobOffer->area); @endphp
                        <option value="Diseño" {{ $currentArea === 'Diseño' ? 'selected' : '' }}>Diseño</option>
                        <option value="Desarrollo" {{ $currentArea === 'Desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                        <option value="Marketing" {{ $currentArea === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Gestión" {{ $currentArea === 'Gestión' ? 'selected' : '' }}>Gestión / PM</option>
                        <option value="Ventas" {{ $currentArea === 'Ventas' ? 'selected' : '' }}>Ventas / Comercial</option>
                        <option value="Soporte" {{ $currentArea === 'Soporte' ? 'selected' : '' }}>Soporte Técnico</option>
                    </select>
                    @error('area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <label for="type" class="form-label font-weight-bold">Jornada / Tipo <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                        @php $currentType = old('type', $jobOffer->type); @endphp
                        <option value="Tiempo completo" {{ $currentType === 'Tiempo completo' ? 'selected' : '' }}>Tiempo completo</option>
                        <option value="Medio tiempo" {{ $currentType === 'Medio tiempo' ? 'selected' : '' }}>Medio tiempo</option>
                        <option value="Freelance" {{ $currentType === 'Freelance' ? 'selected' : '' }}>Freelance / Proyecto</option>
                        <option value="Prácticas" {{ $currentType === 'Prácticas' ? 'selected' : '' }}>Prácticas / Internship</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-3">
                    <label for="location" class="form-label font-weight-bold">Ubicación <span class="text-danger">*</span></label>
                    <select name="location" id="location" class="form-select @error('location') is-invalid @enderror" required>
                        @php $currentLoc = old('location', $jobOffer->location); @endphp
                        <option value="Remoto" {{ $currentLoc === 'Remoto' ? 'selected' : '' }}>Remoto</option>
                        <option value="Presencial" {{ $currentLoc === 'Presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="Híbrido" {{ $currentLoc === 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Order --}}
                <div class="mb-3">
                    <label for="order" class="form-label font-weight-bold">Orden de Aparición</label>
                    <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $jobOffer->order) }}" min="0">
                </div>

                {{-- Is Active --}}
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $jobOffer->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold" for="is_active">Publicado en la web</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="admin-btn admin-btn-primary w-100 justify-content-center" style="padding: 0.8rem;">
                        <i class="fa-solid fa-rotate me-2"></i> Actualizar Vacante
                    </button>
                    <a href="{{ route('admin.job-offers.index') }}" class="btn btn-light border text-secondary w-100" style="border-radius: 10px; padding: 0.65rem;">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
