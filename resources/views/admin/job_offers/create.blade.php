@extends('admin.layouts.app')

@section('title', 'Nueva Vacante')
@section('page-title', 'Nueva Vacante')

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
                <i class="fa-solid fa-briefcase" style="color: var(--primary-color);"></i>
                Crear Puesto de Trabajo / Vacante
            </h1>
        </div>
    </div>
</div>

<form action="{{ route('admin.job-offers.store') }}" method="POST">
    @csrf

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
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Ej. Diseñador UI/UX Senior" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label text-muted" style="font-size: 0.85rem;">Slug (URL amigable)</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Se genera automáticamente si se deja vacío">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label font-weight-bold">Descripción del Puesto <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Describe los objetivos del puesto, funciones principales y lo que esperan del candidato..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Requirements --}}
                <div class="mb-3">
                    <label for="requirements" class="form-label font-weight-bold">Requisitos & Habilidades (Opcional)</label>
                    <textarea name="requirements" id="requirements" rows="4" class="form-control @error('requirements') is-invalid @enderror" placeholder="Ej. 2+ años de experiencia en Laravel, Figma avanzado, nivel de inglés intermedio...">{{ old('requirements') }}</textarea>
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
                        <option value="Diseño" {{ old('area') === 'Diseño' ? 'selected' : '' }}>Diseño</option>
                        <option value="Desarrollo" {{ old('area') === 'Desarrollo' || !old('area') ? 'selected' : '' }}>Desarrollo</option>
                        <option value="Marketing" {{ old('area') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Gestión" {{ old('area') === 'Gestión' ? 'selected' : '' }}>Gestión / PM</option>
                        <option value="Ventas" {{ old('area') === 'Ventas' ? 'selected' : '' }}>Ventas / Comercial</option>
                        <option value="Soporte" {{ old('area') === 'Soporte' ? 'selected' : '' }}>Soporte Técnico</option>
                    </select>
                    @error('area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <label for="type" class="form-label font-weight-bold">Jornada / Tipo <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="Tiempo completo" {{ old('type') === 'Tiempo completo' || !old('type') ? 'selected' : '' }}>Tiempo completo</option>
                        <option value="Medio tiempo" {{ old('type') === 'Medio tiempo' ? 'selected' : '' }}>Medio tiempo</option>
                        <option value="Freelance" {{ old('type') === 'Freelance' ? 'selected' : '' }}>Freelance / Proyecto</option>
                        <option value="Prácticas" {{ old('type') === 'Prácticas' ? 'selected' : '' }}>Prácticas / Internship</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-3">
                    <label for="location" class="form-label font-weight-bold">Ubicación <span class="text-danger">*</span></label>
                    <select name="location" id="location" class="form-select @error('location') is-invalid @enderror" required>
                        <option value="Remoto" {{ old('location') === 'Remoto' || !old('location') ? 'selected' : '' }}>Remoto</option>
                        <option value="Presencial" {{ old('location') === 'Presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="Híbrido" {{ old('location') === 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Order --}}
                <div class="mb-3">
                    <label for="order" class="form-label font-weight-bold">Orden de Aparición</label>
                    <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                </div>

                {{-- Is Active --}}
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold" for="is_active">Publicar inmediatamente</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="admin-btn admin-btn-primary w-100 justify-content-center" style="padding: 0.8rem;">
                        <i class="fa-solid fa-save me-2"></i> Guardar Vacante
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
