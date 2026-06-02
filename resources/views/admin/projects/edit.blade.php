@extends('admin.layouts.app')

@section('title', 'Editar Proyecto')
@section('page-title', 'Editar Proyecto')

@push('styles')
<style>
/* ═══ Enhanced Form Styles (Overrides) ═══ */

/* Header glow effect */
.pf-header {
    box-shadow: 0 15px 40px rgba(255, 0, 110, 0.3);
    position: relative;
    overflow: hidden;
}
.pf-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

/* Card hover effect */
.pf-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

/* Tech tag enhanced */
.pf-tech-tag {
    background: rgba(124, 58, 237, 0.1);
    color: #7c3aed;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

/* Drag over state */
.pf-upload-zone.is-dragover {
    border-color: #7c3aed;
    background: rgba(124, 58, 237, 0.05);
    transform: scale(1.01);
}

/* Current image preview */
.pf-current-img {
    width: 100%;
    aspect-ratio: 16/10;
    border-radius: 12px;
    object-fit: cover;
    margin-bottom: 1rem;
    border: 2px solid #e5e7eb;
}

/* Gallery delete checkbox */
.pf-gallery-delete {
    position: absolute;
    top: 0.375rem;
    right: 0.375rem;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border-radius: 50%;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 700;
    transition: all 0.2s;
}
.pf-gallery-delete input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}
.pf-gallery-delete:hover {
    background: #dc2626;
    transform: scale(1.1);
}
.pf-gallery-item.marked-delete img {
    opacity: 0.3;
}

/* Step existing image */
.pf-step-current-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}
</style>
@endpush

@section('content')

<form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" id="projectForm">
    @csrf
    @method('PUT')

    {{-- ═══════════════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════════════ --}}
    {{-- Header --}}
    <div class="admin-compact-header">
        <div class="admin-compact-header-left">
            <a href="{{ route('admin.projects.index') }}" class="admin-compact-header-back" title="Volver a la lista">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="admin-compact-header-info">
                <h1>
                    Editar Proyecto: {{ $project->title }}
                    <span class="admin-compact-header-status {{ $project->status }}">
                        {{ $project->status === 'published' ? 'Publicado' : 'Borrador' }}
                    </span>
                </h1>
            </div>
        </div>
        <div class="admin-compact-header-actions">
            <button type="submit" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span>Guardar Cambios</span>
            </button>
            @if($project->status === 'draft')
            <button type="submit" class="admin-btn admin-btn-primary" onclick="document.getElementById('status').value='published'">
                <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                <span>Publicar</span>
            </button>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MAIN LAYOUT
         ═══════════════════════════════════════════════════ --}}
    <div class="pf-layout">
        {{-- LEFT: Main Content --}}
        <div class="pf-main">

            {{-- Card: Información Básica --}}
            <div class="pf-card">
                <div class="pf-card-header">
                    <div class="pf-card-icon pf-card-icon--purple">
                        <i class="fa-solid fa-pen-fancy" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Información Básica</h2>
                        <p class="pf-card-subtitle">Nombre y descripción del proyecto</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    {{-- Título --}}
                    <div class="pf-group">
                        <label for="title" class="pf-label">
                            <i class="fa-solid fa-heading" aria-hidden="true"></i>
                            Título del proyecto
                            <span class="pf-required">*</span>
                        </label>
                        <input type="text" id="title" name="title" class="pf-input pf-input-lg"
                               value="{{ old('title', $project->title) }}"
                               placeholder="Ej: Rediseño completo de plataforma e-commerce"
                               required maxlength="150">
                        <div class="pf-help">
                            <span>Define un nombre atractivo y descriptivo</span>
                            <span class="pf-counter"><span id="titleCount">0</span> / 150</span>
                        </div>
                        @error('title')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Slug --}}
                    <div class="pf-group">
                        <label for="slug" class="pf-label">
                            <i class="fa-solid fa-link" aria-hidden="true"></i>
                            URL amigable (slug)
                        </label>
                        <div class="pf-slug-wrap">
                            <span class="pf-slug-prefix">/proyectos/</span>
                            <input type="text" id="slug" name="slug" class="pf-input"
                                   value="{{ old('slug', $project->slug) }}"
                                   placeholder="se-genera-automaticamente">
                        </div>
                        <div class="pf-help">
                            <span><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Se genera automáticamente del título</span>
                        </div>
                        @error('slug')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="pf-group">
                        <label for="description" class="pf-label">
                            <i class="fa-solid fa-align-left" aria-hidden="true"></i>
                            Descripción general
                            <span class="pf-required">*</span>
                        </label>
                        <textarea id="description" name="description" class="pf-textarea"
                                  placeholder="Escribe una descripción atractiva que capte la esencia del proyecto..."
                                  required rows="4" maxlength="500">{{ old('description', $project->description) }}</textarea>
                        <div class="pf-help">
                            <span>Aparecerá en las cards del portafolio</span>
                            <span class="pf-counter"><span id="descCount">0</span> / 500</span>
                        </div>
                        @error('description')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Card: Caso de Éxito --}}
            <div class="pf-card">
                <div class="pf-card-header">
                    <div class="pf-card-icon pf-card-icon--green">
                        <i class="fa-solid fa-trophy" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Caso de Éxito</h2>
                        <p class="pf-card-subtitle">Cuenta la historia del proyecto de forma convincente</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    {{-- El Desafío --}}
                    <div class="pf-case-item pf-case-item--challenge">
                        <label for="challenge" class="pf-label pf-case-label pf-case-label--challenge">
                            <i class="fa-solid fa-mountain" aria-hidden="true"></i>
                            El Desafío
                        </label>
                        <textarea id="challenge" name="challenge" class="pf-textarea"
                                  placeholder="¿Cuál era el problema inicial? ¿Qué necesidad tenía el cliente?"
                                  rows="3">{{ old('challenge', $project->challenge) }}</textarea>
                        <div class="pf-help"><span>Describe la situación inicial o el reto que enfrentaba el cliente</span></div>
                    </div>

                    {{-- La Solución --}}
                    <div class="pf-case-item pf-case-item--solution">
                        <label for="solution" class="pf-label pf-case-label pf-case-label--solution">
                            <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>
                            La Solución
                        </label>
                        <textarea id="solution" name="solution" class="pf-textarea"
                                  placeholder="¿Qué estrategia implementaste? ¿Cómo abordaste el proyecto?"
                                  rows="3">{{ old('solution', $project->solution) }}</textarea>
                        <div class="pf-help"><span>Explica tu enfoque, metodología y las soluciones que desarrollaste</span></div>
                    </div>

                    {{-- Los Resultados --}}
                    <div class="pf-case-item pf-case-item--results">
                        <label for="results" class="pf-label pf-case-label pf-case-label--results">
                            <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                            Los Resultados
                        </label>
                        <textarea id="results" name="results" class="pf-textarea"
                                  placeholder="¿Qué logros se obtuvieron? Ej: +200% en conversiones, nueva identidad de marca..."
                                  rows="3">{{ old('results', $project->results) }}</textarea>
                        <div class="pf-help"><span>Métricas cuantificables, mejoras o el impacto positivo del proyecto</span></div>
                    </div>
                </div>
            </div>

            {{-- Card: Tecnologías y URL --}}
            <div class="pf-card">
                <div class="pf-card-header">
                    <div class="pf-card-icon pf-card-icon--blue">
                        <i class="fa-solid fa-code" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Tecnologías y Enlace</h2>
                        <p class="pf-card-subtitle">Herramientas utilizadas y acceso al proyecto</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    {{-- Tecnologías --}}
                    <div class="pf-group">
                        <label for="technologies" class="pf-label">
                            <i class="fa-solid fa-tools" aria-hidden="true"></i>
                            Tecnologías / Herramientas
                        </label>
                        <input type="text" id="technologies" name="technologies" class="pf-input"
                               value="{{ old('technologies', is_array($project->technologies) ? implode(', ', $project->technologies) : $project->technologies) }}"
                               placeholder="Laravel, Figma, Tailwind CSS, Adobe XD, Vue.js">
                        <div class="pf-help"><span>Separa con comas cada tecnología o herramienta utilizada</span></div>
                        <div id="techPreview" class="pf-tech-preview" style="display: none;"></div>
                    </div>

                    {{-- URL --}}
                    <div class="pf-group">
                        <label for="url" class="pf-label">
                            <i class="fa-solid fa-globe" aria-hidden="true"></i>
                            URL del proyecto
                        </label>
                        <input type="url" id="url" name="url" class="pf-input"
                               value="{{ old('url', $project->url) }}"
                               placeholder="https://ejemplo.com">
                        <div class="pf-help"><span>Enlace al proyecto en vivo (si está disponible)</span></div>
                        @error('url')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Card: Pasos del Proceso --}}
            <div class="pf-card">
                <div class="pf-card-header">
                    <div class="pf-card-icon pf-card-icon--orange">
                        <i class="fa-solid fa-list-ol" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Pasos del Proceso</h2>
                        <p class="pf-card-subtitle">Define las fases del proyecto con imágenes</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    <div id="stepsContainer" class="pf-steps-list">
                        @forelse($project->steps as $si => $step)
                        <div class="pf-step" data-index="{{ $si }}">
                            <input type="hidden" name="steps[{{ $si }}][id]" value="{{ $step->id }}">
                            <div class="pf-step-header">
                                <span class="pf-step-num">{{ str_pad($si + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <button type="button" class="pf-step-remove" onclick="removeStep(this)" @if($si === 0 && $project->steps->count() === 1) style="display: none;" @endif>
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i> Eliminar
                                </button>
                            </div>
                            <div class="pf-step-fields">
                                <div class="pf-group">
                                    <label class="pf-label">Título del paso</label>
                                    <input type="text" name="steps[{{ $si }}][title]" class="pf-input"
                                           value="{{ old("steps.{$si}.title", $step->title) }}"
                                           placeholder="Ej: Investigación, Diseño, Desarrollo...">
                                </div>
                                <div class="pf-group">
                                    <label class="pf-label">Descripción</label>
                                    <textarea name="steps[{{ $si }}][description]" class="pf-textarea" rows="2"
                                              placeholder="Describe qué se hizo en este paso...">{{ old("steps.{$si}.description", $step->description) }}</textarea>
                                </div>
                            </div>
                            <div class="pf-step-images">
                                @for($img = 1; $img <= 3; $img++)
                                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem; position: relative;">
                                    <div class="pf-step-img-upload">
                                        @if($step->{"image{$img}"})
                                            <div class="pf-step-current-img-wrapper" id="stepImgWrapper_{{ $step->id }}_{{ $img }}" style="position: absolute; inset: 0; z-index: 10; background: #fff;">
                                                <img src="{{ Storage::url($step->{"image{$img}"}) }}" class="pf-step-current-img" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="Step {{ $si+1 }} image {{ $img }}">
                                                <button type="button" 
                                                        class="pf-btn pf-btn--danger" 
                                                        style="position: absolute; top: 0; right: 0; padding: 4px 8px; font-size: 12px; border-radius: 0 4px 0 4px; box-shadow: none; z-index: 20; cursor: pointer;"
                                                        onclick="event.preventDefault(); event.stopPropagation(); removeStepImage({{ $step->id }}, {{ $img }}, 'stepImgWrapper_{{ $step->id }}_{{ $img }}')"
                                                        title="Eliminar imagen">
                                                    <i class="fa-solid fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <i class="fa-solid fa-image" aria-hidden="true"></i>
                                            <span>Imagen {{ $img }}</span>
                                        @endif
                                        <input type="file" name="steps[{{ $si }}][image{{ $img }}]" accept="image/*" onchange="previewStepImg(this, {{ $si }}, {{ $img }})">
                                    </div>
                                    <select name="steps[{{ $si }}][image{{ $img }}_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                                        @php
                                            $defaultDevice = $img == 1 ? 'safari' : ($img == 2 ? 'iphone' : 'ipad');
                                            $currentDevice = $step->{"image{$img}_device"} ?? $defaultDevice;
                                        @endphp
                                        <option value="macbook" {{ $currentDevice === 'macbook' ? 'selected' : '' }}>💻 MacBook</option>
                                        <option value="iphone" {{ $currentDevice === 'iphone' ? 'selected' : '' }}>📱 iPhone 17</option>
                                        <option value="ipad" {{ $currentDevice === 'ipad' ? 'selected' : '' }}>平板 iPad</option>
                                        <option value="safari" {{ $currentDevice === 'safari' ? 'selected' : '' }}>🌐 Safari</option>
                                        <option value="none" {{ $currentDevice === 'none' ? 'selected' : '' }}>🚫 Normal</option>
                                    </select>
                                </div>
                                @endfor
                            </div>
                        </div>
                        @empty
                        <div class="pf-step" data-index="0">
                            <div class="pf-step-header">
                                <span class="pf-step-num">01</span>
                                <button type="button" class="pf-step-remove" onclick="removeStep(this)" style="display: none;">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i> Eliminar
                                </button>
                            </div>
                            <div class="pf-step-fields">
                                <div class="pf-group">
                                    <label class="pf-label">Título del paso</label>
                                    <input type="text" name="steps[0][title]" class="pf-input"
                                           placeholder="Ej: Investigación, Diseño, Desarrollo...">
                                </div>
                                <div class="pf-group">
                                    <label class="pf-label">Descripción</label>
                                    <textarea name="steps[0][description]" class="pf-textarea" rows="2"
                                              placeholder="Describe qué se hizo en este paso..."></textarea>
                                </div>
                            </div>
                            <div class="pf-step-images">
                                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem;">
                                    <div class="pf-step-img-upload">
                                        <input type="file" name="steps[0][image1]" accept="image/*" onchange="previewStepImg(this, 0, 1)">
                                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                                        <span>Imagen 1</span>
                                    </div>
                                    <select name="steps[0][image1_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                                        <option value="macbook">💻 MacBook</option>
                                        <option value="iphone">📱 iPhone 17</option>
                                        <option value="ipad">平板 iPad</option>
                                        <option value="safari" selected>🌐 Safari</option>
                                        <option value="none">🚫 Normal</option>
                                    </select>
                                </div>
                                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem;">
                                    <div class="pf-step-img-upload">
                                        <input type="file" name="steps[0][image2]" accept="image/*" onchange="previewStepImg(this, 0, 2)">
                                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                                        <span>Imagen 2</span>
                                    </div>
                                    <select name="steps[0][image2_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                                        <option value="macbook">💻 MacBook</option>
                                        <option value="iphone" selected>📱 iPhone 17</option>
                                        <option value="ipad">平板 iPad</option>
                                        <option value="safari">🌐 Safari</option>
                                        <option value="none">🚫 Normal</option>
                                    </select>
                                </div>
                                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem;">
                                    <div class="pf-step-img-upload">
                                        <input type="file" name="steps[0][image3]" accept="image/*" onchange="previewStepImg(this, 0, 3)">
                                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                                        <span>Imagen 3</span>
                                    </div>
                                    <select name="steps[0][image3_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                                        <option value="macbook">💻 MacBook</option>
                                        <option value="iphone">📱 iPhone 17</option>
                                        <option value="ipad" selected>平板 iPad</option>
                                        <option value="safari">🌐 Safari</option>
                                        <option value="none">🚫 Normal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" class="pf-add-step" onclick="addStep()">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        Agregar otro paso
                    </button>
                </div>
            </div>

        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="pf-sidebar">

            {{-- Card: Imagen Principal --}}
            <div class="pf-card">
                <div class="pf-card-header pf-card-header--compact">
                    <div class="pf-card-icon pf-card-icon--pink">
                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Imagen Principal</h2>
                        <p class="pf-card-subtitle">La portada de tu proyecto</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="pf-current-img" id="currentThumbnail">
                    @endif
                    <div class="pf-upload-zone" onclick="document.getElementById('thumbnail').click()">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" 
                               onchange="previewThumbnail(event)" style="display:none;">
                        <div id="thumbnailPreview" class="pf-upload-content">
                            <div class="pf-upload-icon">
                                <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                            </div>
                            <p class="pf-upload-text">{{ $project->thumbnail ? 'Cambiar imagen' : 'Click para subir' }}</p>
                            <span class="pf-upload-hint">JPG, PNG, WebP (Max 2MB)</span>
                        </div>
                    </div>
                    <div class="pf-group" style="margin-top: 1rem; margin-bottom: 0;">
                        <label for="thumbnail_device" class="pf-label pf-label--sm" style="margin-bottom: 0.25rem;">
                            <i class="fa-solid fa-laptop" aria-hidden="true"></i>
                            Dispositivo de Portada
                        </label>
                        <select id="thumbnail_device" name="thumbnail_device" class="pf-select" style="width: 100%; padding: 0.5rem; border-radius: 8px; border: 1px solid #d1d5db; background: #fff; color: #374151;">
                            <option value="macbook" {{ old('thumbnail_device', $project->thumbnail_device) === 'macbook' ? 'selected' : '' }}>💻 MacBook Pro Plata</option>
                            <option value="iphone" {{ old('thumbnail_device', $project->thumbnail_device) === 'iphone' ? 'selected' : '' }}>📱 iPhone 17 Pro</option>
                            <option value="ipad" {{ old('thumbnail_device', $project->thumbnail_device) === 'ipad' ? 'selected' : '' }}>平板 iPad Pro</option>
                            <option value="safari" {{ old('thumbnail_device', $project->thumbnail_device) === 'safari' ? 'selected' : '' }}>🌐 Safari Browser</option>
                            <option value="none" {{ old('thumbnail_device', $project->thumbnail_device) === 'none' ? 'selected' : '' }}>🚫 Ninguno (Plano)</option>
                        </select>
                    </div>
                    @error('thumbnail')<span class="pf-error">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Card: Galería --}}
            <div class="pf-card">
                <div class="pf-card-header pf-card-header--compact">
                    <div class="pf-card-icon pf-card-icon--violet">
                        <i class="fa-solid fa-images" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Galería</h2>
                        <p class="pf-card-subtitle">Imágenes adicionales</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    <input type="file" id="gallery" name="images[]" accept="image/*" multiple
                           onchange="previewGallery(event)" style="display:none;">
                    <div id="galleryPreview" class="pf-gallery-grid">
                        @foreach($project->images as $image)
                        <div class="pf-gallery-item" id="gallery-item-{{ $image->id }}" style="display: flex; flex-direction: column; gap: 0.5rem; position: relative; padding-bottom: 0.5rem;">
                            <img src="{{ Storage::url($image->image_path) }}" alt="Gallery image" style="border-radius: 8px; width: 100%; aspect-ratio: 16/10; object-fit: cover;">
                            <select name="gallery_devices[{{ $image->id }}]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; width: 100%; border: 1px solid #d1d5db; background-color: #fff; cursor: pointer; color: #374151; height: auto;">
                                <option value="macbook" {{ $image->device_type === 'macbook' ? 'selected' : '' }}>💻 MacBook</option>
                                <option value="iphone" {{ $image->device_type === 'iphone' ? 'selected' : '' }}>📱 iPhone</option>
                                <option value="ipad" {{ $image->device_type === 'ipad' ? 'selected' : '' }}>平板 iPad</option>
                                <option value="safari" {{ $image->device_type === 'safari' ? 'selected' : '' }}>🌐 Safari</option>
                                <option value="none" {{ $image->device_type === 'none' ? 'selected' : '' }}>🚫 Normal</option>
                            </select>
                            <label class="pf-gallery-delete" title="Marcar para eliminar" style="top: 0.375rem; right: 0.375rem;">
                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" onchange="toggleDeleteMark(this, {{ $image->id }})">
                                <i class="fa-solid fa-xmark"></i>
                            </label>
                        </div>
                        @endforeach
                        <div class="pf-gallery-add" onclick="document.getElementById('gallery').click()">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            <span>Agregar</span>
                        </div>
                    </div>
                    @if($project->images->count() > 0)
                    <div class="pf-help" style="margin-top: 0.75rem;">
                        <span><i class="fa-solid fa-info-circle"></i> Click en ✕ para marcar imágenes a eliminar</span>
                    </div>
                    @endif
                    @error('images.*')<span class="pf-error">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Card: Detalles --}}
            <div class="pf-card">
                <div class="pf-card-header pf-card-header--compact">
                    <div class="pf-card-icon pf-card-icon--cyan">
                        <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Detalles</h2>
                        <p class="pf-card-subtitle">Información del proyecto</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    <div class="pf-group">
                        <label for="type" class="pf-label pf-label--sm">
                            <i class="fa-solid fa-tag" aria-hidden="true"></i>
                            Tipo de proyecto
                        </label>
                        <input type="text" id="type" name="type" class="pf-input"
                               value="{{ old('type', $project->type) }}" placeholder="Web, Branding, App...">
                    </div>
                    <div class="pf-group">
                        <label for="client" class="pf-label pf-label--sm">
                            <i class="fa-solid fa-building" aria-hidden="true"></i>
                            Cliente
                        </label>
                        <input type="text" id="client" name="client" class="pf-input"
                               value="{{ old('client', $project->client) }}" placeholder="Nombre del cliente">
                    </div>
                    <div class="pf-group">
                        <label for="year" class="pf-label pf-label--sm">
                            <i class="fa-solid fa-calendar" aria-hidden="true"></i>
                            Año
                        </label>
                        <input type="text" id="year" name="year" class="pf-input"
                               value="{{ old('year', $project->year) }}" placeholder="2025">
                    </div>
                </div>
            </div>

            {{-- Card: Publicación --}}
            <div class="pf-card">
                <div class="pf-card-header pf-card-header--compact">
                    <div class="pf-card-icon pf-card-icon--amber">
                        <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="pf-card-title">Publicación</h2>
                        <p class="pf-card-subtitle">Estado y fecha</p>
                    </div>
                </div>
                <div class="pf-card-body">
                    <div class="pf-group">
                        <label for="status" class="pf-label pf-label--sm">
                            <i class="fa-solid fa-circle-dot" aria-hidden="true"></i>
                            Estado
                        </label>
                        <select id="status" name="status" class="pf-select">
                            <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>📝 Borrador</option>
                            <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>✅ Publicado</option>
                        </select>
                    </div>
                    <div class="pf-group">
                        <label for="published_at" class="pf-label pf-label--sm">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            Fecha de publicación
                        </label>
                        <input type="datetime-local" id="published_at" name="published_at" class="pf-input"
                               value="{{ old('published_at', $project->published_at?->format('Y-m-d\TH:i')) }}">
                        <div class="pf-help"><span>Déjalo vacío para publicar ahora</span></div>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="pf-tips">
                <div class="pf-tips-header">
                    <div class="pf-tips-icon">
                        <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>
                    </div>
                    <h3 class="pf-tips-title">Tips para destacar</h3>
                </div>
                <ul class="pf-tips-list">
                    <li>
                        <span class="pf-tips-check"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                        Usa un título atractivo y descriptivo
                    </li>
                    <li>
                        <span class="pf-tips-check"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                        Agrega imágenes de alta calidad
                    </li>
                    <li>
                        <span class="pf-tips-check"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                        Detalla el proceso y resultados
                    </li>
                    <li>
                        <span class="pf-tips-check"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                        Incluye todas las tecnologías
                    </li>
                </ul>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// ═══════════════════════════════════════════════════════════════════════════
// Title & Slug
// ═══════════════════════════════════════════════════════════════════════════
const titleInput = document.getElementById('title');
const titleCount = document.getElementById('titleCount');
const slugInput = document.getElementById('slug');

titleInput.addEventListener('input', function() {
    titleCount.textContent = this.value.length;
    
    // Auto-generate slug only if empty
    if (!slugInput.dataset.manual) {
        slugInput.value = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
});

slugInput.addEventListener('input', function() {
    slugInput.dataset.manual = 'true';
});

// ═══════════════════════════════════════════════════════════════════════════
// Description counter
// ═══════════════════════════════════════════════════════════════════════════
const descInput = document.getElementById('description');
const descCount = document.getElementById('descCount');

descInput.addEventListener('input', function() {
    descCount.textContent = this.value.length;
});

// ═══════════════════════════════════════════════════════════════════════════
// Technologies preview
// ═══════════════════════════════════════════════════════════════════════════
const techInput = document.getElementById('technologies');
const techPreview = document.getElementById('techPreview');

techInput.addEventListener('input', function() {
    const techs = this.value.split(',').map(t => t.trim()).filter(t => t);
    
    if (techs.length > 0) {
        techPreview.innerHTML = techs.map(tech => 
            `<span class="pf-tech-tag">${tech}</span>`
        ).join('');
        techPreview.style.display = 'flex';
    } else {
        techPreview.style.display = 'none';
    }
});

// ═══════════════════════════════════════════════════════════════════════════
// Thumbnail preview
// ═══════════════════════════════════════════════════════════════════════════
function previewThumbnail(event) {
    const file = event.target.files[0];
    const currentImg = document.getElementById('currentThumbnail');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (currentImg) {
                currentImg.src = e.target.result;
            } else {
                const preview = document.getElementById('thumbnailPreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="pf-upload-preview">`;
            }
        };
        reader.readAsDataURL(file);
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// Gallery preview
// ═══════════════════════════════════════════════════════════════════════════
let galleryFiles = [];

function previewGallery(event) {
    const files = Array.from(event.target.files);
    const preview = document.getElementById('galleryPreview');
    const addButton = preview.querySelector('.pf-gallery-add');
    
    files.forEach(file => {
        galleryFiles.push(file);
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'pf-gallery-item';
            itemDiv.innerHTML = `
                <img src="${e.target.result}" alt="Gallery">
                <button type="button" class="pf-gallery-remove" onclick="removeGalleryItem(this, '${file.name}')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            
            preview.insertBefore(itemDiv, addButton);
        };
        reader.readAsDataURL(file);
    });
}

function removeGalleryItem(button, fileName) {
    galleryFiles = galleryFiles.filter(f => f.name !== fileName);
    button.parentElement.remove();
    
    const dt = new DataTransfer();
    galleryFiles.forEach(file => dt.items.add(file));
    document.getElementById('gallery').files = dt.files;
}

function toggleDeleteMark(checkbox, imageId) {
    const item = document.getElementById('gallery-item-' + imageId);
    if (checkbox.checked) {
        item.classList.add('marked-delete');
    } else {
        item.classList.remove('marked-delete');
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// Steps Builder
// ═══════════════════════════════════════════════════════════════════════════
let stepCount = {{ $project->steps->count() > 0 ? $project->steps->count() : 1 }};

function addStep() {
    const container = document.getElementById('stepsContainer');
    const index = stepCount;
    
    const stepHtml = `
        <div class="pf-step" data-index="${index}">
            <div class="pf-step-header">
                <span class="pf-step-num">${String(index + 1).padStart(2, '0')}</span>
                <button type="button" class="pf-step-remove" onclick="removeStep(this)">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> Eliminar
                </button>
            </div>
            <div class="pf-step-fields">
                <div class="pf-group">
                    <label class="pf-label">Título del paso</label>
                    <input type="text" name="steps[${index}][title]" class="pf-input"
                           placeholder="Ej: Investigación, Diseño, Desarrollo...">
                </div>
                <div class="pf-group">
                    <label class="pf-label">Descripción</label>
                    <textarea name="steps[${index}][description]" class="pf-textarea" rows="2"
                              placeholder="Describe qué se hizo en este paso..."></textarea>
                </div>
            </div>
            <div class="pf-step-images">
                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <div class="pf-step-img-upload">
                        <input type="file" name="steps[${index}][image1]" accept="image/*" onchange="previewStepImg(this, ${index}, 1)">
                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                        <span>Imagen 1</span>
                    </div>
                    <select name="steps[${index}][image1_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                        <option value="macbook">💻 MacBook</option>
                        <option value="iphone">📱 iPhone 17</option>
                        <option value="ipad">平板 iPad</option>
                        <option value="safari" selected>🌐 Safari</option>
                        <option value="none">🚫 Normal</option>
                    </select>
                </div>
                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <div class="pf-step-img-upload">
                        <input type="file" name="steps[${index}][image2]" accept="image/*" onchange="previewStepImg(this, ${index}, 2)">
                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                        <span>Imagen 2</span>
                    </div>
                    <select name="steps[${index}][image2_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                        <option value="macbook">💻 MacBook</option>
                        <option value="iphone" selected>📱 iPhone 17</option>
                        <option value="ipad">平板 iPad</option>
                        <option value="safari">🌐 Safari</option>
                        <option value="none">🚫 Normal</option>
                    </select>
                </div>
                <div class="pf-step-image-group" style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <div class="pf-step-img-upload">
                        <input type="file" name="steps[${index}][image3]" accept="image/*" onchange="previewStepImg(this, ${index}, 3)">
                        <i class="fa-solid fa-image" aria-hidden="true"></i>
                        <span>Imagen 3</span>
                    </div>
                    <select name="steps[${index}][image3_device]" class="pf-select pf-select--sm" style="font-size: 11px; padding: 4px 6px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #374151; height: auto; cursor: pointer;">
                        <option value="macbook">💻 MacBook</option>
                        <option value="iphone">📱 iPhone 17</option>
                        <option value="ipad" selected>平板 iPad</option>
                        <option value="safari">🌐 Safari</option>
                        <option value="none">🚫 Normal</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', stepHtml);
    stepCount++;
    updateStepNumbers();
    updateRemoveButtons();
}

function removeStep(button) {
    const step = button.closest('.pf-step');
    const idInput = step.querySelector('input[type="hidden"][name$="[id]"]');
    if (idInput && idInput.value) {
        // Appending a hidden input to the form to track deleted steps
        const form = document.getElementById('projectForm');
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete_steps[]';
        deleteInput.value = idInput.value;
        form.appendChild(deleteInput);
    }
    step.remove();
    updateStepNumbers();
    updateRemoveButtons();
}

function removeStepImage(stepId, imgNumber, wrapperId) {
    if(confirm('¿Estás seguro de que quieres eliminar esta imagen del paso? La imagen se eliminará permanentemente al guardar.')) {
        // Ocultar la imagen visualmente
        const wrapper = document.getElementById(wrapperId);
        wrapper.style.display = 'none';
        
        // Mostrar el icono y texto de placeholder
        const iconSpan = document.createElement('div');
        iconSpan.innerHTML = `<i class="fa-solid fa-image" aria-hidden="true"></i><span>Imagen ${imgNumber}</span>`;
        iconSpan.style.display = 'flex';
        iconSpan.style.flexDirection = 'column';
        iconSpan.style.alignItems = 'center';
        iconSpan.style.gap = '0.5rem';
        wrapper.parentNode.insertBefore(iconSpan, wrapper);

        // Añadir input oculto para que el backend sepa que debe borrarla
        const form = document.getElementById('projectForm');
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = `delete_step_images[${stepId}][]`;
        deleteInput.value = imgNumber;
        form.appendChild(deleteInput);
    }
}

function updateStepNumbers() {
    const steps = document.querySelectorAll('.pf-step');
    steps.forEach((step, idx) => {
        const numEl = step.querySelector('.pf-step-num');
        if (numEl) {
            numEl.textContent = String(idx + 1).padStart(2, '0');
        }
    });
}

function updateRemoveButtons() {
    const steps = document.querySelectorAll('.pf-step');
    steps.forEach(step => {
        const removeBtn = step.querySelector('.pf-step-remove');
        if (removeBtn) {
            removeBtn.style.display = steps.length > 1 ? 'block' : 'none';
        }
    });
}

function previewStepImg(input, stepIndex, imgNum) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = input.parentElement;
            
            // Remove existing static elements (icon, text or old full image)
            const oldImg = container.querySelector('.pf-step-current-img');
            if (oldImg) oldImg.remove();
            const icon = container.querySelector('i');
            if (icon) icon.remove();
            const span = container.querySelector('span');
            if (span) span.remove();
            
            // Render or update the new preview image inside the container
            let preview = container.querySelector('.pf-step-img-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'pf-step-img-preview';
                container.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// Initialize
// ═══════════════════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', function() {
    // Initialize counters
    titleInput.dispatchEvent(new Event('input'));
    descInput.dispatchEvent(new Event('input'));
    techInput.dispatchEvent(new Event('input'));
    
    // Initialize step buttons
    updateRemoveButtons();
    
    // Mark slug as manual if it has a value
    if (slugInput.value) {
        slugInput.dataset.manual = 'true';
    }
});
</script>
@endpush
