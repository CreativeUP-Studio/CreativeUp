@extends('admin.layouts.app')

@section('title', 'Editar Servicio')
@section('page-title', 'Editar: ' . $service->title)

@section('content')

<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" id="serviceForm">
    @csrf
    @method('PUT')

    {{-- Header --}}
    <div class="svc-header">
        <div class="svc-header-left">
            <a href="{{ route('admin.services.index') }}" class="svc-header-back" title="Volver a la lista">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="svc-header-info">
                <h1>
                    @if($service->icon)
                        <span class="svc-header-emoji" id="headerIconWrap">
                            @if(Str::contains($service->icon, 'fa-'))
                                <i class="{{ $service->icon }}"></i>
                            @else
                                {{ $service->icon }}
                            @endif
                        </span>
                    @else
                        <span class="svc-header-emoji" id="headerIconWrap" style="display: none;"></span>
                    @endif
                    <span id="headerTitleText">{{ $service->title }}</span>
                    <span class="svc-header-status {{ $service->is_active ? 'active' : 'inactive' }}">
                        {{ $service->is_active ? 'Activo' : 'Borrador' }}
                    </span>
                </h1>
            </div>
        </div>
        <div class="svc-header-actions">
            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-eye"></i>
                <span>Ver en Web</span>
            </a>
            <button type="submit" name="is_active" value="0" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-eye-slash"></i>
                <span>Guardar Borrador</span>
            </button>
            <button type="submit" name="is_active" value="1" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-check"></i>
                <span>Guardar Cambios</span>
            </button>
        </div>
    </div>

    {{-- Alertas de errores --}}
    @if($errors->any())
    <div class="svc-alert svc-alert--error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <div>
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

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
                    <input type="text" id="title" name="title" value="{{ old('title', $service->title) }}" required maxlength="150">
                    @error('title')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="slug">URL amigable</label>
                    <div class="svc-input-group">
                        <span class="svc-input-prefix">/servicios/</span>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $service->slug) }}">
                    </div>
                </div>

                <div class="svc-field">
                    <label for="short_description">Descripción corta</label>
                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $service->short_description) }}" maxlength="300" placeholder="Breve resumen para las tarjetas de servicios...">
                    <div class="svc-field-footer">
                        <small>Aparecerá en las cards de servicios</small>
                        <span class="svc-counter"><span id="shortDescCount">{{ strlen(old('short_description', $service->short_description) ?? '') }}</span>/300</span>
                    </div>
                </div>

                <div class="svc-field">
                    <label for="description">Descripción completa <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                    @error('description')<span class="svc-error">{{ $message }}</span>@enderror
                </div>

                <div class="svc-field">
                    <label for="cta_text">Texto de llamada a la acción</label>
                    <input type="text" id="cta_text" name="cta_text" value="{{ old('cta_text', $service->cta_text) }}" maxlength="255">
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
                    @php $feats = old('features', $service->features ?? []); @endphp
                    @forelse($feats as $feat)
                        @if(!empty(trim($feat ?? '')))
                        <div class="svc-dynamic-item">
                            <span class="svc-dynamic-icon"><i class="fa-solid fa-check"></i></span>
                            <input type="text" name="features[]" value="{{ $feat }}" placeholder="Característica...">
                            <button type="button" class="svc-dynamic-remove" onclick="removeItem(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endif
                    @empty
                        <p class="svc-empty-hint">No hay características añadidas. Haz clic en el botón para agregar.</p>
                    @endforelse
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
                    @php $bens = old('benefits', $service->benefits ?? []); @endphp
                    @forelse($bens as $i => $ben)
                        @if(!empty(trim($ben['title'] ?? '')))
                        <div class="svc-benefit-card" data-index="{{ $i }}">
                            <input type="text" name="benefits[{{ $i }}][icon]" value="{{ $ben['icon'] ?? '' }}" placeholder="🚀" class="svc-benefit-emoji">
                            <input type="text" name="benefits[{{ $i }}][title]" value="{{ $ben['title'] ?? '' }}" placeholder="Título del beneficio" class="svc-benefit-title">
                            <input type="text" name="benefits[{{ $i }}][desc]" value="{{ $ben['desc'] ?? '' }}" placeholder="Descripción breve" class="svc-benefit-desc">
                            <button type="button" class="svc-benefit-remove" onclick="removeItem(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endif
                    @empty
                        <p class="svc-empty-hint">No hay beneficios añadidos. Haz clic en el botón para agregar.</p>
                    @endforelse
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
                    @php $steps = old('process_steps', $service->process_steps ?? []); @endphp
                    @forelse($steps as $i => $step)
                        @if(!empty(trim($step['title'] ?? '')))
                        <div class="svc-step-card" data-index="{{ $i }}">
                            <span class="svc-step-number">{{ $loop->iteration }}</span>
                            <div class="svc-step-inputs">
                                <input type="text" name="process_steps[{{ $i }}][title]" value="{{ $step['title'] ?? '' }}" placeholder="Título del paso">
                                <input type="text" name="process_steps[{{ $i }}][desc]" value="{{ $step['desc'] ?? '' }}" placeholder="Descripción del paso">
                            </div>
                            <button type="button" class="svc-step-remove" onclick="removeStep(this)"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endif
                    @empty
                        <p class="svc-empty-hint">No hay pasos definidos. Haz clic en el botón para agregar.</p>
                    @endforelse
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
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}" maxlength="200">
                </div>

                <div class="svc-field">
                    <label for="meta_description">Meta descripción</label>
                    <textarea id="meta_description" name="meta_description" rows="2" maxlength="500">{{ old('meta_description', $service->meta_description) }}</textarea>
                </div>
            </section>
        </div>

        {{-- Sidebar --}}
        <aside class="svc-sidebar">
            {{-- Status Card --}}
            <div class="svc-sidebar-card svc-status-card">
                <div class="svc-status-indicator {{ $service->is_active ? 'active' : 'inactive' }}">
                    <i class="fa-solid fa-circle"></i>
                    <span>{{ $service->is_active ? 'Publicado' : 'Borrador' }}</span>
                </div>
                <div class="svc-field svc-field--compact" style="margin-top: 0.75rem; margin-bottom: 0.75rem;">
                    <label for="is_active" style="font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 0.35rem; display: block;">Estado:</label>
                    <select id="is_active" name="is_active" class="svc-input" style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid #cbd5e1; font-weight: 600;">
                        <option value="1" {{ old('is_active', $service->is_active) ? 'selected' : '' }}>✅ Publicado / Activo</option>
                        <option value="0" {{ !old('is_active', $service->is_active) ? 'selected' : '' }}>📝 Borrador / Inactivo</option>
                    </select>
                </div>
                <div class="svc-status-info">
                    <div class="svc-status-item">
                        <span>Creado:</span>
                        <strong>{{ $service->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="svc-status-item">
                        <span>Actualizado:</span>
                        <strong>{{ $service->updated_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            {{-- Image Upload --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-image"></i> Imagen principal</h3>

                @if($service->image)
                <div class="svc-current-image">
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}">
                    <label class="svc-remove-checkbox">
                        <input type="checkbox" name="remove_image" value="1">
                        <i class="fa-solid fa-trash"></i> Eliminar imagen actual
                    </label>
                </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*" hidden onchange="previewImage(event)">
                <div id="imagePreview" class="svc-image-upload" onclick="document.getElementById('image').click()">
                    <div class="svc-image-placeholder">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>{{ $service->image ? 'Cambiar imagen' : 'Click para subir' }}</span>
                        <small>JPG, PNG, WebP (Max 50MB)</small>
                    </div>
                </div>
                @error('image')<span class="svc-error">{{ $message }}</span>@enderror
            </div>

            {{-- Gallery --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-images"></i> Galería</h3>
                <p class="svc-sidebar-hint">Hasta 8 imágenes adicionales</p>

                @if($service->gallery && count($service->gallery) > 0)
                <div class="svc-current-gallery">
                    @foreach($service->gallery as $gImg)
                    <div class="svc-gallery-existing">
                        <img src="{{ Storage::url($gImg) }}" alt="Galería">
                        <label>
                            <input type="checkbox" name="remove_gallery[]" value="{{ $gImg }}">
                            <i class="fa-solid fa-trash"></i>
                        </label>
                    </div>
                    @endforeach
                </div>
                @endif

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
                        <input type="text" id="icon" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="🎨" class="svc-emoji-input" style="flex: 1;">
                        <div id="iconPreviewBox" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 1.25rem;">
                            @if(old('icon', $service->icon))
                                @if(Str::contains(old('icon', $service->icon), 'fa-'))
                                    <i class="{{ old('icon', $service->icon) }}"></i>
                                @else
                                    {{ old('icon', $service->icon) }}
                                @endif
                            @else
                                <i class="fa-solid fa-shapes" style="color: #94a3b8;"></i>
                            @endif
                        </div>
                    </div>
                    <small>Un emoji o clase de Font Awesome (Ej: fa-solid fa-magnifying-glass-chart)</small>
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="color">Color del servicio</label>
                    <div class="svc-color-picker">
                        <input type="color" id="color" name="color" value="{{ old('color', $service->color ?? '#7c3aed') }}">
                        <span id="colorValue">{{ old('color', $service->color ?? '#7c3aed') }}</span>
                    </div>
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="order">Orden de aparición</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $service->order ?? 0) }}" min="0" placeholder="0">
                    <small>Menor número = aparece primero</small>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="svc-sidebar-card svc-danger-zone">
                <h3><i class="fa-solid fa-triangle-exclamation"></i> Zona de peligro</h3>
                <p>Esta acción eliminará permanentemente el servicio y no se puede deshacer.</p>
                <button type="button" class="svc-delete-btn" onclick="confirmDelete()">
                    <i class="fa-solid fa-trash"></i>
                    Eliminar servicio
                </button>
            </div>
        </aside>
    </div>
</form>

{{-- Formulario de eliminación separado --}}
<form id="deleteForm" method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Short description counter
    const shortDesc = document.getElementById('short_description');
    const shortDescCount = document.getElementById('shortDescCount');
    if (shortDesc && shortDescCount) {
        shortDesc.addEventListener('input', function() {
            shortDescCount.textContent = this.value.length;
        });
    }

    // Color picker
    const colorInput = document.getElementById('color');
    const colorValue = document.getElementById('colorValue');
    if (colorInput && colorValue) {
        colorInput.addEventListener('input', function() {
            colorValue.textContent = this.value;
        });
    }

    // Live Icon Preview
    const iconInput = document.getElementById('icon');
    if (iconInput) {
        iconInput.addEventListener('input', function() {
            const val = this.value.trim();
            const box = document.getElementById('iconPreviewBox');
            const headerWrap = document.getElementById('headerIconWrap');
            
            // Actualizar la caja del formulario
            if (box) {
                if (val === '') {
                    box.innerHTML = '<i class="fa-solid fa-shapes" style="color: #94a3b8;"></i>';
                } else if (val.includes('fa-')) {
                    box.innerHTML = `<i class="${val}"></i>`;
                } else {
                    box.innerHTML = val;
                }
            }
            
            // Actualizar la cabecera
            if (headerWrap) {
                if (val === '') {
                    headerWrap.style.display = 'none';
                    headerWrap.innerHTML = '';
                } else {
                    headerWrap.style.display = '';
                    if (val.includes('fa-')) {
                        headerWrap.innerHTML = `<i class="${val}"></i>`;
                    } else {
                        headerWrap.innerHTML = val;
                    }
                }
            }
        });
    }
});

// Remove empty hint when adding items
function removeEmptyHint(container) {
    const hint = container.querySelector('.svc-empty-hint');
    if (hint) hint.remove();
}

// Remove item
function removeItem(button) {
    button.closest('.svc-dynamic-item, .svc-benefit-card').remove();
}

// Remove step and renumber
function removeStep(button) {
    button.closest('.svc-step-card').remove();
    renumberSteps();
}

// Features
function addFeature() {
    const container = document.getElementById('features-container');
    removeEmptyHint(container);
    
    const item = document.createElement('div');
    item.className = 'svc-dynamic-item';
    item.innerHTML = `
        <span class="svc-dynamic-icon"><i class="fa-solid fa-check"></i></span>
        <input type="text" name="features[]" placeholder="Nueva característica...">
        <button type="button" class="svc-dynamic-remove" onclick="removeItem(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    `;
    container.appendChild(item);
    item.querySelector('input').focus();
}

// Benefits
var benefitIdx = {{ count(old('benefits', $service->benefits ?? [])) }};
function addBenefit() {
    const container = document.getElementById('benefits-container');
    removeEmptyHint(container);
    
    const item = document.createElement('div');
    item.className = 'svc-benefit-card';
    item.innerHTML = `
        <input type="text" name="benefits[${benefitIdx}][icon]" placeholder="🚀" class="svc-benefit-emoji">
        <input type="text" name="benefits[${benefitIdx}][title]" placeholder="Título del beneficio" class="svc-benefit-title">
        <input type="text" name="benefits[${benefitIdx}][desc]" placeholder="Descripción breve" class="svc-benefit-desc">
        <button type="button" class="svc-benefit-remove" onclick="removeItem(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    `;
    container.appendChild(item);
    benefitIdx++;
    item.querySelector('.svc-benefit-title').focus();
}

// Steps
var stepIdx = {{ count(old('process_steps', $service->process_steps ?? [])) }};
function addStep() {
    const container = document.getElementById('steps-container');
    removeEmptyHint(container);
    
    const num = container.querySelectorAll('.svc-step-card').length + 1;
    const item = document.createElement('div');
    item.className = 'svc-step-card';
    item.innerHTML = `
        <span class="svc-step-number">${num}</span>
        <div class="svc-step-inputs">
            <input type="text" name="process_steps[${stepIdx}][title]" placeholder="Título del paso">
            <input type="text" name="process_steps[${stepIdx}][desc]" placeholder="Descripción del paso">
        </div>
        <button type="button" class="svc-step-remove" onclick="removeStep(this)">
            <i class="fa-solid fa-xmark"></i>
        </button>
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
                <button type="button" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            preview.insertBefore(div, addBtn);
        };
        reader.readAsDataURL(file);
    });
}

// Delete confirmation
function confirmDelete() {
    if (confirm('¿Estás seguro de que deseas eliminar este servicio?\n\nEsta acción no se puede deshacer.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
