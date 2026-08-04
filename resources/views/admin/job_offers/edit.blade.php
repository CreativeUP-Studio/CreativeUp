@extends('admin.layouts.app')

@section('title', 'Editar Vacante: ' . $jobOffer->title)
@section('page-title', 'Editar: ' . $jobOffer->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
@endpush

@section('content')

<form method="POST" action="{{ route('admin.job-offers.update', $jobOffer->id) }}" id="jobOfferForm">
    @csrf
    @method('PUT')

    {{-- Header --}}
    <div class="svc-header">
        <div class="svc-header-left">
            <a href="{{ route('admin.job-offers.index') }}" class="svc-header-back" title="Volver a la lista">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="svc-header-info">
                <h1>
                    <span>{{ $jobOffer->title }}</span>
                    <span class="svc-header-status {{ $jobOffer->is_active ? 'active' : 'inactive' }}">
                        {{ $jobOffer->is_active ? 'Activa' : 'Borrador' }}
                    </span>
                </h1>
            </div>
        </div>
        <div class="svc-header-actions">
            <a href="{{ route('careers') }}#vacantes" target="_blank" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-eye"></i>
                <span>Ver en Web</span>
            </a>
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-save"></i>
                <span>Guardar Cambios</span>
            </button>
        </div>
    </div>

    <div class="svc-layout">
        {{-- Main Column --}}
        <div class="svc-main">

            {{-- Informacion del Puesto --}}
            <section class="svc-card">
                <header class="svc-card-header">
                    <span class="svc-card-icon svc-card-icon--purple"><i class="fa-solid fa-pen-to-square"></i></span>
                    <div>
                        <h2>Información del puesto</h2>
                        <p>Modifica los detalles de la vacante laboral</p>
                    </div>
                </header>

                <div class="svc-field">
                    <label for="title">Título del puesto <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $jobOffer->title) }}" placeholder="Ej: Diseñador UI/UX Senior" required maxlength="255">
                    @error('title')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="slug">URL amigable</label>
                    <div class="svc-input-group">
                        <span class="svc-input-prefix">/trabaja-con-nosotros#</span>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $jobOffer->slug) }}" placeholder="disenador-ui-ux-senior">
                    </div>
                    <small><i class="fa-solid fa-magic"></i> Se genera automáticamente si lo dejas vacío.</small>
                    @error('slug')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="description">Descripción del puesto <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="6" required placeholder="Describe los objetivos principales del puesto, responsabilidades diarias y la visión del equipo...">{{ old('description', $jobOffer->description) }}</textarea>
                    @error('description')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="requirements">Requisitos & Habilidades (Opcional)</label>
                    <textarea id="requirements" name="requirements" rows="4" placeholder="Ej: 2+ años de experiencia en Figma / Laravel, buenas prácticas, trabajo en equipo y proactividad...">{{ old('requirements', $jobOffer->requirements) }}</textarea>
                    <small><i class="fa-solid fa-circle-info"></i> Requisitos técnicos, nivel de experiencia o competencias requeridas.</small>
                    @error('requirements')<span class="svc-error">{{ $message }}</span>@enderror
                </div>
            </section>
        </div>

        {{-- Sidebar --}}
        <aside class="svc-sidebar">
            {{-- Status Card --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-circle-dot"></i> Estado de publicación</h3>
                <div class="svc-field svc-field--compact" style="margin-top: 0.5rem;">
                    <select id="is_active" name="is_active" class="svc-input" style="width: 100%; padding: 0.65rem 0.8rem; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 600; background: white;">
                        <option value="1" {{ old('is_active', $jobOffer->is_active) ? 'selected' : '' }}>✅ Publicada / Activa</option>
                        <option value="0" {{ !old('is_active', $jobOffer->is_active) ? 'selected' : '' }}>📝 Borrador / Inactiva</option>
                    </select>
                </div>
            </div>

            {{-- Clasificacion --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-sliders"></i> Clasificación</h3>

                @php $currentArea = old('area', $jobOffer->area); @endphp
                <div class="svc-field svc-field--compact">
                    <label for="area">Área / Departamento <span class="required">*</span></label>
                    <select id="area" name="area" class="svc-input" required style="width: 100%; padding: 0.65rem 0.8rem; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 600; background: white;">
                        <option value="Diseño" {{ $currentArea === 'Diseño' ? 'selected' : '' }}>🎨 Diseño</option>
                        <option value="Desarrollo" {{ $currentArea === 'Desarrollo' ? 'selected' : '' }}>💻 Desarrollo</option>
                        <option value="Marketing" {{ $currentArea === 'Marketing' ? 'selected' : '' }}>📈 Marketing</option>
                        <option value="Gestión" {{ $currentArea === 'Gestión' ? 'selected' : '' }}>⚡ Gestión / PM</option>
                        <option value="Ventas" {{ $currentArea === 'Ventas' ? 'selected' : '' }}>💼 Ventas / Comercial</option>
                        <option value="Soporte" {{ $currentArea === 'Soporte' ? 'selected' : '' }}>🎧 Soporte Técnico</option>
                    </select>
                    @error('area')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                @php $currentType = old('type', $jobOffer->type); @endphp
                <div class="svc-field svc-field--compact">
                    <label for="type">Jornada / Tipo <span class="required">*</span></label>
                    <select id="type" name="type" class="svc-input" required style="width: 100%; padding: 0.65rem 0.8rem; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 600; background: white;">
                        <option value="Tiempo completo" {{ $currentType === 'Tiempo completo' ? 'selected' : '' }}>⏱️ Tiempo completo</option>
                        <option value="Medio tiempo" {{ $currentType === 'Medio tiempo' ? 'selected' : '' }}>⌛ Medio tiempo</option>
                        <option value="Freelance" {{ $currentType === 'Freelance' ? 'selected' : '' }}>🚀 Freelance / Proyecto</option>
                        <option value="Prácticas" {{ $currentType === 'Prácticas' ? 'selected' : '' }}>🎓 Prácticas / Internship</option>
                    </select>
                    @error('type')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                @php $currentLoc = old('location', $jobOffer->location); @endphp
                <div class="svc-field svc-field--compact">
                    <label for="location">Ubicación <span class="required">*</span></label>
                    <select id="location" name="location" class="svc-input" required style="width: 100%; padding: 0.65rem 0.8rem; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 600; background: white;">
                        <option value="Remoto" {{ $currentLoc === 'Remoto' ? 'selected' : '' }}>🌐 Remoto</option>
                        <option value="Presencial" {{ $currentLoc === 'Presencial' ? 'selected' : '' }}>🏢 Presencial</option>
                        <option value="Híbrido" {{ $currentLoc === 'Híbrido' ? 'selected' : '' }}>🔄 Híbrido</option>
                    </select>
                    @error('location')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="order">Orden de aparición</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $jobOffer->order) }}" min="0" placeholder="0">
                    <small>0 = aparece primero</small>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="svc-sidebar-card svc-tips">
                <h3><i class="fa-solid fa-lightbulb"></i> Recomendaciones</h3>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Mantén actualizada la información de la oferta</li>
                    <li><i class="fa-solid fa-check"></i> Si la vacante se cubrió, cámbiala a Borrador</li>
                </ul>
            </div>
        </aside>
    </div>
</form>

@endsection

@push('scripts')
<script>
// Slug auto-generation
document.getElementById('title').addEventListener('input', function() {
    const slug = document.getElementById('slug');
    if (!slug.dataset.manual) {
        slug.value = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.manual = 'true';
});
</script>
@endpush
