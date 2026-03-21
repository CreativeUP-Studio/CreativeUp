@extends('admin.layouts.app')

@section('title', 'Nuevo Servicio')
@section('page-title', 'Crear Servicio')

@section('content')
<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" style="max-width:820px">
    @csrf

    {{-- Info principal --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-info-circle" style="color:var(--admin-purple)"></i>
            Información principal
        </h3>
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="title">Título *</label>
                <input type="text" id="title" name="title" class="admin-form-control"
                       value="{{ old('title') }}" required placeholder="Ej: Diseño Web">
                @error('title')<p class="admin-error-text">{{ $message }}</p>@enderror
            </div>
            <div class="admin-form-group">
                <label for="slug">Slug (auto si vacío)</label>
                <input type="text" id="slug" name="slug" class="admin-form-control"
                       value="{{ old('slug') }}" placeholder="diseno-web">
            </div>
        </div>
        <div class="admin-form-group">
            <label for="short_description">Descripción corta (máx. 300 caracteres)</label>
            <input type="text" id="short_description" name="short_description" class="admin-form-control"
                   value="{{ old('short_description') }}" placeholder="Resumen breve del servicio para tarjetas..." maxlength="300">
        </div>
        <div class="admin-form-group">
            <label for="description">Descripción completa *</label>
            <textarea id="description" name="description" class="admin-form-control"
                      required placeholder="Descripción detallada del servicio..." rows="5">{{ old('description') }}</textarea>
            @error('description')<p class="admin-error-text">{{ $message }}</p>@enderror
        </div>
        <div class="admin-form-group">
            <label for="cta_text">Texto CTA personalizado</label>
            <input type="text" id="cta_text" name="cta_text" class="admin-form-control"
                   value="{{ old('cta_text') }}" placeholder="Ej: ¿Listo para transformar tu marca?" maxlength="255">
        </div>
    </div>

    {{-- Imagen principal y galería --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-images" style="color:var(--admin-purple)"></i>
            Imágenes
        </h3>
        <div class="admin-form-group">
            <label for="image">Imagen principal (portada)</label>
            <input type="file" id="image" name="image" class="admin-form-control" accept="image/*">
            <p class="admin-form-hint">JPG, PNG o WebP. Máx 2MB. Se muestra en el hero y tarjetas.</p>
            @error('image')<p class="admin-error-text">{{ $message }}</p>@enderror
        </div>
        <div class="admin-form-group">
            <label for="gallery">Galería de imágenes (máx. 8)</label>
            <input type="file" id="gallery" name="gallery[]" class="admin-form-control" accept="image/*" multiple>
            <p class="admin-form-hint">Selecciona múltiples imágenes. Se muestran en la página de detalle del servicio.</p>
            @error('gallery')<p class="admin-error-text">{{ $message }}</p>@enderror
            @error('gallery.*')<p class="admin-error-text">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Apariencia --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-palette" style="color:var(--admin-purple)"></i>
            Apariencia
        </h3>
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="icon">Icono / Emoji</label>
                <input type="text" id="icon" name="icon" class="admin-form-control"
                       value="{{ old('icon') }}" placeholder="Ej: 🎨 o fa-paint-brush">
            </div>
            <div class="admin-form-group">
                <label for="color">Color representativo</label>
                <input type="color" id="color" name="color" class="admin-form-control"
                       value="{{ old('color', '#5e17eb') }}" style="height:42px;padding:4px">
            </div>
            <div class="admin-form-group">
                <label for="order">Orden de aparición</label>
                <input type="number" id="order" name="order" class="admin-form-control"
                       value="{{ old('order', 0) }}" min="0" placeholder="0 = primero">
            </div>
        </div>
    </div>

    {{-- Features --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-list-check" style="color:var(--admin-purple)"></i>
            Features / Características
        </h3>
        <p class="admin-form-hint admin-mb-sm">Lo que incluye el servicio.</p>
        <div id="features-container">
            @if(old('features'))
                @foreach(old('features') as $i => $feat)
                    <div class="admin-feature-row">
                        <input type="text" name="features[]" class="admin-form-control" value="{{ $feat }}" placeholder="Ej: Diseño responsive">
                        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endforeach
            @else
                <div class="admin-feature-row">
                    <input type="text" name="features[]" class="admin-form-control" placeholder="Ej: Diseño responsive">
                    <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>
        <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" style="margin-top:0.75rem" onclick="addFeature()">
            <i class="fa-solid fa-plus"></i> Agregar feature
        </button>
    </div>

    {{-- Beneficios --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-star" style="color:var(--admin-purple)"></i>
            Beneficios
        </h3>
        <p class="admin-form-hint admin-mb-sm">Beneficios clave con título, descripción e icono (emoji).</p>
        <div id="benefits-container">
            @if(old('benefits'))
                @foreach(old('benefits') as $i => $ben)
                    <div class="admin-benefit-row admin-form-card" style="padding:1rem;margin-bottom:0.75rem">
                        <div class="admin-form-grid" style="grid-template-columns:60px 1fr 1fr">
                            <input type="text" name="benefits[{{ $i }}][icon]" class="admin-form-control" value="{{ $ben['icon'] ?? '' }}" placeholder="🚀" style="text-align:center">
                            <input type="text" name="benefits[{{ $i }}][title]" class="admin-form-control" value="{{ $ben['title'] ?? '' }}" placeholder="Título del beneficio">
                            <div style="display:flex;gap:8px">
                                <input type="text" name="benefits[{{ $i }}][desc]" class="admin-form-control" value="{{ $ben['desc'] ?? '' }}" placeholder="Descripción breve" style="flex:1">
                                <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.admin-benefit-row').remove()">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" style="margin-top:0.75rem" onclick="addBenefit()">
            <i class="fa-solid fa-plus"></i> Agregar beneficio
        </button>
    </div>

    {{-- Pasos del proceso --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-shoe-prints" style="color:var(--admin-purple)"></i>
            Pasos del proceso
        </h3>
        <p class="admin-form-hint admin-mb-sm">Pasos personalizados de cómo se ejecuta este servicio.</p>
        <div id="steps-container">
            @if(old('process_steps'))
                @foreach(old('process_steps') as $i => $step)
                    <div class="admin-step-row admin-form-card" style="padding:1rem;margin-bottom:0.75rem">
                        <div style="display:flex;gap:8px;align-items:start">
                            <span class="admin-step-num" style="min-width:32px;height:32px;border-radius:50%;background:var(--admin-purple);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px">{{ $i + 1 }}</span>
                            <div style="flex:1;display:flex;flex-direction:column;gap:6px">
                                <input type="text" name="process_steps[{{ $i }}][title]" class="admin-form-control" value="{{ $step['title'] ?? '' }}" placeholder="Título del paso">
                                <input type="text" name="process_steps[{{ $i }}][desc]" class="admin-form-control" value="{{ $step['desc'] ?? '' }}" placeholder="Descripción del paso">
                            </div>
                            <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.admin-step-row').remove();renumberSteps()">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" style="margin-top:0.75rem" onclick="addStep()">
            <i class="fa-solid fa-plus"></i> Agregar paso
        </button>
    </div>

    {{-- SEO --}}
    <div class="admin-form-card admin-mb-md">
        <h3 class="admin-section-title">
            <i class="fa-solid fa-magnifying-glass" style="color:var(--admin-purple)"></i>
            SEO (opcional)
        </h3>
        <div class="admin-form-group">
            <label for="meta_title">Meta título</label>
            <input type="text" id="meta_title" name="meta_title" class="admin-form-control"
                   value="{{ old('meta_title') }}" placeholder="Título para buscadores" maxlength="200">
        </div>
        <div class="admin-form-group">
            <label for="meta_description">Meta descripción</label>
            <textarea id="meta_description" name="meta_description" class="admin-form-control"
                      placeholder="Descripción para buscadores..." rows="2" maxlength="500">{{ old('meta_description') }}</textarea>
        </div>
    </div>

    {{-- Estado --}}
    <div class="admin-form-card admin-mb-md">
        <div class="admin-form-group admin-mb-0">
            <label class="admin-checkbox-label">
                <input type="checkbox" name="is_active" value="1" class="admin-checkbox" {{ old('is_active', true) ? 'checked' : '' }}>
                <span><i class="fa-solid fa-eye"></i> Servicio activo (visible en el sitio)</span>
            </label>
        </div>
    </div>

    <div class="admin-form-actions" style="border:none;padding-top:0;margin-top:0">
        <button type="submit" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-save"></i> Guardar servicio
        </button>
        <a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-secondary">Cancelar</a>
    </div>
</form>

<script>
function addFeature() {
    const container = document.getElementById('features-container');
    const row = document.createElement('div');
    row.className = 'admin-feature-row';
    row.innerHTML = '<input type="text" name="features[]" class="admin-form-control" placeholder="Ej: Optimización SEO">' +
        '<button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>';
    container.appendChild(row);
    row.querySelector('input').focus();
}

let benefitIdx = {{ old('benefits') ? count(old('benefits')) : 0 }};
function addBenefit() {
    const container = document.getElementById('benefits-container');
    const row = document.createElement('div');
    row.className = 'admin-benefit-row admin-form-card';
    row.style.cssText = 'padding:1rem;margin-bottom:0.75rem';
    row.innerHTML = `<div class="admin-form-grid" style="grid-template-columns:60px 1fr 1fr"><input type="text" name="benefits[${benefitIdx}][icon]" class="admin-form-control" placeholder="🚀" style="text-align:center"><input type="text" name="benefits[${benefitIdx}][title]" class="admin-form-control" placeholder="Título del beneficio"><div style="display:flex;gap:8px"><input type="text" name="benefits[${benefitIdx}][desc]" class="admin-form-control" placeholder="Descripción breve" style="flex:1"><button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.admin-benefit-row').remove()"><i class="fa-solid fa-xmark"></i></button></div></div>`;
    container.appendChild(row);
    benefitIdx++;
    row.querySelector('input:nth-child(2)').focus();
}

let stepIdx = {{ old('process_steps') ? count(old('process_steps')) : 0 }};
function addStep() {
    const container = document.getElementById('steps-container');
    const row = document.createElement('div');
    row.className = 'admin-step-row admin-form-card';
    row.style.cssText = 'padding:1rem;margin-bottom:0.75rem';
    const num = container.children.length + 1;
    row.innerHTML = `<div style="display:flex;gap:8px;align-items:start"><span class="admin-step-num" style="min-width:32px;height:32px;border-radius:50%;background:var(--admin-purple);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px">${num}</span><div style="flex:1;display:flex;flex-direction:column;gap:6px"><input type="text" name="process_steps[${stepIdx}][title]" class="admin-form-control" placeholder="Título del paso"><input type="text" name="process_steps[${stepIdx}][desc]" class="admin-form-control" placeholder="Descripción del paso"></div><button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="this.closest('.admin-step-row').remove();renumberSteps()"><i class="fa-solid fa-xmark"></i></button></div>`;
    container.appendChild(row);
    stepIdx++;
    row.querySelector('input').focus();
}

function renumberSteps() {
    document.querySelectorAll('#steps-container .admin-step-num').forEach((el, i) => {
        el.textContent = i + 1;
    });
}
</script>
@endsection
