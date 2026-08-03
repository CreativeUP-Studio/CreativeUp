@extends('admin.layouts.app')

@section('title', 'Nuevo Servicio')
@section('page-title', 'Crear Servicio')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
@endpush

@section('content')

<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" id="serviceForm">
    @csrf

    {{-- Header --}}
    <div class="svc-header">
        <div class="svc-header-left">
            <a href="{{ route('admin.services.index') }}" class="svc-header-back" title="Volver a la lista">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="svc-header-info">
                <h1>Crear Servicio</h1>
            </div>
        </div>
        <div class="svc-header-actions">
            <button type="submit" name="is_active" value="0" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-eye-slash"></i>
                <span>Guardar como Borrador</span>
            </button>
            <button type="submit" name="is_active" value="1" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-rocket"></i>
                <span>Publicar Servicio</span>
            </button>
        </div>
    </div>

    <div class="svc-layout">
        {{-- Main Column --}}
        <div class="svc-main">

            {{-- Basic Info --}}
            <section class="svc-card">
                <header class="svc-card-header">
                    <span class="svc-card-icon svc-card-icon--purple"><i class="fa-solid fa-info"></i></span>
                    <div>
                        <h2>Información básica</h2>
                        <p>Datos principales del servicio</p>
                    </div>
                </header>

                <div class="svc-field">
                    <label for="title">Título del servicio <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ej: Diseño de Identidad Corporativa" required maxlength="150">
                    @error('title')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="slug">URL amigable</label>
                    <div class="svc-input-group">
                        <span class="svc-input-prefix">/servicios/</span>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="se-genera-automaticamente">
                    </div>
                    <small><i class="fa-solid fa-magic"></i> Se genera automáticamente</small>
                </div>

                <div class="svc-field">
                    <label for="short_description">Descripción corta</label>
                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description') }}" placeholder="Breve resumen para las tarjetas..." maxlength="300">
                    <div class="svc-field-footer">
                        <small>Aparecerá en las cards de servicios</small>
                        <span class="svc-counter"><span id="shortDescCount">0</span>/300</span>
                    </div>
                </div>

                <div class="svc-field">
                    <label for="description">Descripción completa <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="5" required placeholder="Descripción detallada que aparecerá en la página del servicio...">{{ old('description') }}</textarea>
                    @error('description')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="cta_text">Texto de llamada a la acción</label>
                    <input type="text" id="cta_text" name="cta_text" value="{{ old('cta_text') }}" placeholder="Ej: ¿Listo para transformar tu marca?" maxlength="255">
                </div>
            </section>

            {{-- Features --}}
            <section class="svc-card">
                <header class="svc-card-header">
                    <span class="svc-card-icon svc-card-icon--emerald"><i class="fa-solid fa-list-check"></i></span>
                    <div>
                        <h2>Características</h2>
                        <p>Lo que incluye este servicio</p>
                    </div>
                </header>

                <div id="features-container" class="svc-dynamic-list">
                    @if(old('features'))
                        @foreach(old('features') as $feat)
                        <div class="svc-dynamic-item">
                            <span class="svc-dynamic-icon"><i class="fa-solid fa-check"></i></span>
                            <input type="text" name="features[]" value="{{ $feat }}" placeholder="Característica...">
                            <button type="button" class="svc-dynamic-remove" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endforeach
                    @else
                        <div class="svc-dynamic-item">
                            <span class="svc-dynamic-icon"><i class="fa-solid fa-check"></i></span>
                            <input type="text" name="features[]" placeholder="Ej: Diseño responsive">
                            <button type="button" class="svc-dynamic-remove" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    @endif
                </div>
                <button type="button" class="svc-add-btn" onclick="addFeature()">
                    <i class="fa-solid fa-plus"></i> Agregar característica
                </button>
            </section>

            {{-- Benefits --}}
            <section class="svc-card">
                <header class="svc-card-header">
                    <span class="svc-card-icon svc-card-icon--amber"><i class="fa-solid fa-star"></i></span>
                    <div>
                        <h2>Beneficios</h2>
                        <p>Ventajas clave para el cliente</p>
                    </div>
                </header>

                <div id="benefits-container" class="svc-benefits-list">
                    @if(old('benefits'))
                        @foreach(old('benefits') as $i => $ben)
                        <div class="svc-benefit-card">
                            <input type="text" name="benefits[{{ $i }}][icon]" value="{{ $ben['icon'] ?? '' }}" placeholder="🚀" class="svc-benefit-emoji">
                            <input type="text" name="benefits[{{ $i }}][title]" value="{{ $ben['title'] ?? '' }}" placeholder="Título" class="svc-benefit-title">
                            <input type="text" name="benefits[{{ $i }}][desc]" value="{{ $ben['desc'] ?? '' }}" placeholder="Descripción breve" class="svc-benefit-desc">
                            <button type="button" class="svc-benefit-remove" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="svc-add-btn svc-add-btn--amber" onclick="addBenefit()">
                    <i class="fa-solid fa-plus"></i> Agregar beneficio
                </button>
            </section>

            {{-- Process Steps --}}
            <section class="svc-card">
                <header class="svc-card-header">
                    <span class="svc-card-icon svc-card-icon--blue"><i class="fa-solid fa-route"></i></span>
                    <div>
                        <h2>Proceso de trabajo</h2>
                        <p>Pasos para ejecutar el servicio</p>
                    </div>
                </header>

                <div id="steps-container" class="svc-steps-list">
                    @if(old('process_steps'))
                        @foreach(old('process_steps') as $i => $step)
                        <div class="svc-step-card">
                            <span class="svc-step-number">{{ $i + 1 }}</span>
                            <div class="svc-step-inputs">
                                <input type="text" name="process_steps[{{ $i }}][title]" value="{{ $step['title'] ?? '' }}" placeholder="Título del paso">
                                <input type="text" name="process_steps[{{ $i }}][desc]" value="{{ $step['desc'] ?? '' }}" placeholder="Descripción">
                            </div>
                            <button type="button" class="svc-step-remove" onclick="this.parentElement.remove(); renumberSteps()"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="svc-add-btn svc-add-btn--blue" onclick="addStep()">
                    <i class="fa-solid fa-plus"></i> Agregar paso
                </button>
            </section>

            {{-- SEO --}}
            <section class="svc-card">
                <header class="svc-card-header">
                    <span class="svc-card-icon svc-card-icon--cyan"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <div>
                        <h2>SEO</h2>
                        <p>Optimización para buscadores (opcional)</p>
                    </div>
                </header>

                <div class="svc-field">
                    <label for="meta_title">Meta título</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="Título para buscadores" maxlength="200">
                </div>

                <div class="svc-field">
                    <label for="meta_description">Meta descripción</label>
                    <textarea id="meta_description" name="meta_description" rows="2" placeholder="Descripción para buscadores..." maxlength="500">{{ old('meta_description') }}</textarea>
                </div>
            </section>
        </div>

        {{-- Sidebar --}}
        <aside class="svc-sidebar">
            {{-- Status Card --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-circle-dot"></i> Estado del servicio</h3>
                <div class="svc-field svc-field--compact" style="margin-top: 0.5rem;">
                    <select id="is_active" name="is_active" class="svc-input" style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 600;">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>✅ Publicado / Activo</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>📝 Borrador / Inactivo</option>
                    </select>
                </div>
            </div>

            {{-- Image Upload --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-image"></i> Imagen principal</h3>
                <input type="file" id="image" name="image" accept="image/*" hidden onchange="previewImage(event)">
                <div id="imagePreview" class="svc-image-upload" onclick="document.getElementById('image').click()">
                    <div class="svc-image-placeholder">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Click para subir</span>
                        <small>JPG, PNG, WebP (Max 50MB)</small>
                    </div>
                </div>
                @error('image')<span class="svc-error">{{ $message }}</span>@enderror
            </div>

            {{-- Gallery --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-images"></i> Galería</h3>
                <p class="svc-sidebar-hint">Hasta 8 imágenes adicionales</p>
                <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple hidden onchange="previewGallery(event)">
                <div id="galleryPreview" class="svc-gallery-grid">
                    <div class="svc-gallery-add" onclick="document.getElementById('gallery').click()">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>
            </div>

            {{-- Appearance --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-palette"></i> Apariencia</h3>

                <div class="svc-field svc-field--compact">
                    <label for="icon">Icono / Emoji</label>
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                        <input type="text" id="icon" name="icon" value="{{ old('icon') }}" placeholder="🎨" class="svc-emoji-input" style="flex: 1;">
                        <div id="iconPreviewBox" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1.25rem;">
                            @if(old('icon'))
                                @if(Str::contains(old('icon'), 'fa-'))
                                    <i class="{{ old('icon') }}"></i>
                                @else
                                    {{ old('icon') }}
                                @endif
                            @else
                                <i class="fa-solid fa-shapes" style="color: #94a3b8;"></i>
                            @endif
                        </div>
                    </div>
                    <small>Un emoji o clase de Font Awesome (Ej: fa-solid fa-magnifying-glass-chart)</small>
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="color">Color</label>
                    <div class="svc-color-picker">
                        <input type="color" id="color" name="color" value="{{ old('color', '#7c3aed') }}">
                        <span id="colorValue">{{ old('color', '#7c3aed') }}</span>
                    </div>
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="order">Orden</label>
                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0" placeholder="0">
                    <small>0 = aparece primero</small>
                </div>
            </div>

            {{-- Tips --}}
            <div class="svc-sidebar-card svc-tips">
                <h3><i class="fa-solid fa-lightbulb"></i> Tips</h3>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Usa un título claro y atractivo</li>
                    <li><i class="fa-solid fa-check"></i> Agrega al menos 3 características</li>
                    <li><i class="fa-solid fa-check"></i> Define los pasos de tu proceso</li>
                    <li><i class="fa-solid fa-check"></i> Usa imágenes de calidad</li>
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

// Short description counter
document.getElementById('short_description').addEventListener('input', function() {
    document.getElementById('shortDescCount').textContent = this.value.length;
});

// Color picker
document.getElementById('color').addEventListener('input', function() {
    document.getElementById('colorValue').textContent = this.value;
});

// Features
function addFeature() {
    const container = document.getElementById('features-container');
    const item = document.createElement('div');
    item.className = 'svc-dynamic-item';
    item.innerHTML = `
        <span class="svc-dynamic-icon"><i class="fa-solid fa-check"></i></span>
        <input type="text" name="features[]" placeholder="Nueva característica...">
        <button type="button" class="svc-dynamic-remove" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
    `;
    container.appendChild(item);
    item.querySelector('input').focus();
}

// Benefits
var benefitIdx = {{ old('benefits') ? count(old('benefits')) : 0 }};
function addBenefit() {
    const container = document.getElementById('benefits-container');
    const item = document.createElement('div');
    item.className = 'svc-benefit-card';
    item.innerHTML = `
        <input type="text" name="benefits[${benefitIdx}][icon]" placeholder="🚀" class="svc-benefit-emoji">
        <input type="text" name="benefits[${benefitIdx}][title]" placeholder="Título" class="svc-benefit-title">
        <input type="text" name="benefits[${benefitIdx}][desc]" placeholder="Descripción breve" class="svc-benefit-desc">
        <button type="button" class="svc-benefit-remove" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
    `;
    container.appendChild(item);
    benefitIdx++;
    item.querySelector('.svc-benefit-title').focus();
}

// Steps
var stepIdx = {{ old('process_steps') ? count(old('process_steps')) : 0 }};
function addStep() {
    const container = document.getElementById('steps-container');
    const num = container.children.length + 1;
    const item = document.createElement('div');
    item.className = 'svc-step-card';
    item.innerHTML = `
        <span class="svc-step-number">${num}</span>
        <div class="svc-step-inputs">
            <input type="text" name="process_steps[${stepIdx}][title]" placeholder="Título del paso">
            <input type="text" name="process_steps[${stepIdx}][desc]" placeholder="Descripción">
        </div>
        <button type="button" class="svc-step-remove" onclick="this.parentElement.remove(); renumberSteps()"><i class="fa-solid fa-xmark"></i></button>
    `;
    container.appendChild(item);
    stepIdx++;
    item.querySelector('input').focus();
}

function renumberSteps() {
    document.querySelectorAll('#steps-container .svc-step-number').forEach((el, i) => {
        el.textContent = i + 1;
    });
}

// Image preview
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    }
}

// Gallery preview
function previewGallery(event) {
    const files = Array.from(event.target.files);
    const preview = document.getElementById('galleryPreview');
    const addBtn = preview.querySelector('.svc-gallery-add');

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'svc-gallery-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Gallery">
                <button type="button" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button>
            `;
            preview.insertBefore(div, addBtn);
        };
        reader.readAsDataURL(file);
    });
}

// Live Icon Preview
document.getElementById('icon').addEventListener('input', function() {
    const val = this.value.trim();
    const box = document.getElementById('iconPreviewBox');
    if (val === '') {
        box.innerHTML = '<i class="fa-solid fa-shapes" style="color: #94a3b8;"></i>';
    } else if (val.includes('fa-')) {
        box.innerHTML = `<i class="${val}"></i>`;
    } else {
        box.innerHTML = val;
    }
});
</script>
@endpush
