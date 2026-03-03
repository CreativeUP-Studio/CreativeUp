@extends('admin.layouts.app')

@section('title', 'Editar Proyecto')
@section('page-title', 'Editar Proyecto')

@section('content')
<div class="admin-form-card">
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Sección: Información básica --}}
        <div class="admin-form-section">
            <h3 class="admin-form-section-title">
                <span class="admin-form-section-icon">📋</span>
                Información básica
            </h3>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label for="title">Título del proyecto *</label>
                    <input type="text" id="title" name="title" class="admin-form-control"
                           value="{{ old('title', $project->title) }}" required>
                </div>
                <div class="admin-form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="admin-form-control"
                           value="{{ old('slug', $project->slug) }}">
                </div>
            </div>
            <div class="admin-form-group">
                <label for="description">Descripción general *</label>
                <textarea id="description" name="description" class="admin-form-control admin-textarea-lg"
                          required>{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="admin-form-grid admin-form-grid-3">
                <div class="admin-form-group">
                    <label for="type">Tipo / Categoría</label>
                    <input type="text" id="type" name="type" class="admin-form-control"
                           value="{{ old('type', $project->type) }}" placeholder="Ej: Branding, Web, Social Media">
                </div>
                <div class="admin-form-group">
                    <label for="client">Cliente</label>
                    <input type="text" id="client" name="client" class="admin-form-control"
                           value="{{ old('client', $project->client) }}" placeholder="Nombre del cliente">
                </div>
                <div class="admin-form-group">
                    <label for="year">Año</label>
                    <input type="text" id="year" name="year" class="admin-form-control"
                           value="{{ old('year', $project->year) }}" placeholder="Ej: 2026">
                </div>
            </div>
        </div>

        {{-- Sección: Detalle del caso --}}
        <div class="admin-form-section">
            <h3 class="admin-form-section-title">
                <span class="admin-form-section-icon">🎯</span>
                Detalle del caso
            </h3>
            <div class="admin-form-group">
                <label for="challenge">El desafío</label>
                <textarea id="challenge" name="challenge" class="admin-form-control"
                          placeholder="¿Cuál era el problema o necesidad del cliente?">{{ old('challenge', $project->challenge) }}</textarea>
                <small class="admin-form-hint">Describe la situación inicial o el reto que enfrentaba el cliente.</small>
            </div>
            <div class="admin-form-group">
                <label for="solution">La solución</label>
                <textarea id="solution" name="solution" class="admin-form-control"
                          placeholder="¿Qué estrategia o enfoque se implementó?">{{ old('solution', $project->solution) }}</textarea>
                <small class="admin-form-hint">Explica cómo abordaste el proyecto y qué soluciones propusiste.</small>
            </div>
            <div class="admin-form-group">
                <label for="results">Los resultados</label>
                <textarea id="results" name="results" class="admin-form-control"
                          placeholder="¿Qué se logró con este proyecto?">{{ old('results', $project->results) }}</textarea>
                <small class="admin-form-hint">Métricas, logros o impacto obtenido.</small>
            </div>
        </div>

        {{-- Sección: Tecnologías y enlace --}}
        <div class="admin-form-section">
            <h3 class="admin-form-section-title">
                <span class="admin-form-section-icon">⚙️</span>
                Tecnologías y enlace
            </h3>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label for="technologies">Tecnologías / Herramientas</label>
                    <input type="text" id="technologies" name="technologies" class="admin-form-control"
                           value="{{ old('technologies', is_array($project->technologies) ? implode(', ', $project->technologies) : $project->technologies) }}"
                           placeholder="Laravel, Figma, Tailwind CSS">
                    <small class="admin-form-hint">Separa con comas cada tecnología.</small>
                </div>
                <div class="admin-form-group">
                    <label for="url">URL del proyecto</label>
                    <input type="url" id="url" name="url" class="admin-form-control"
                           value="{{ old('url', $project->url) }}">
                </div>
            </div>
        </div>

        {{-- Sección: Imágenes --}}
        <div class="admin-form-section">
            <h3 class="admin-form-section-title">
                <span class="admin-form-section-icon">🖼️</span>
                Imágenes
            </h3>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label for="thumbnail">Imagen principal</label>
                    @if($project->thumbnail)
                        <div class="admin-mb-sm">
                            <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="admin-preview-img">
                        </div>
                    @endif
                    <input type="file" id="thumbnail" name="thumbnail" class="admin-form-control" accept="image/*">
                    <small class="admin-form-hint">Dejar vacío para mantener la imagen actual.</small>
                </div>
                <div class="admin-form-group">
                    <label for="images">Agregar imágenes de galería</label>
                    <input type="file" id="images" name="images[]" class="admin-form-control" accept="image/*" multiple>
                    <small class="admin-form-hint">Puedes seleccionar múltiples imágenes.</small>
                </div>
            </div>

            {{-- Imágenes existentes --}}
            @if($project->images->count() > 0)
                <div class="admin-form-group">
                    <label>Imágenes actuales de galería</label>
                    <div class="admin-gallery">
                        @foreach($project->images as $image)
                            <div class="admin-gallery-item">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Imagen proyecto">
                                <label class="admin-gallery-delete" title="Marcar para eliminar">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                    ✕
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="admin-form-hint">Haz clic en la ✕ para marcar imágenes a eliminar.</small>
                </div>
            @endif
        </div>

        {{-- Sección: Pasos del proceso --}}
        <div class="admin-form-section">
            <h3 class="admin-form-section-title">
                <span class="admin-form-section-icon">🔢</span>
                Pasos del proceso
            </h3>
            <small class="admin-form-hint" style="display:block; margin-bottom:16px;">Define los pasos que se mostrarán como secciones fullscreen en la vista pública. Cada paso puede tener hasta 3 imágenes que formarán un collage.</small>

            <div id="steps-container">
                @forelse($project->steps as $si => $step)
                <div class="admin-step-item" data-index="{{ $si }}">
                    <input type="hidden" name="steps[{{ $si }}][id]" value="{{ $step->id }}">
                    <div class="admin-step-header">
                        <span class="admin-step-number">Paso {{ str_pad($si + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm admin-step-remove" onclick="removeStep(this)">✕</button>
                    </div>
                    <div class="admin-form-grid">
                        <div class="admin-form-group">
                            <label>Título del paso</label>
                            <input type="text" name="steps[{{ $si }}][title]" class="admin-form-control" value="{{ old("steps.{$si}.title", $step->title) }}">
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <label>Descripción del paso</label>
                        <textarea name="steps[{{ $si }}][description]" class="admin-form-control">{{ old("steps.{$si}.description", $step->description) }}</textarea>
                    </div>
                    <div class="admin-form-grid admin-form-grid-3">
                        @for($img = 1; $img <= 3; $img++)
                        <div class="admin-form-group">
                            <label>Imagen {{ $img }}</label>
                            @if($step->{"image{$img}"})
                                <div class="admin-mb-sm">
                                    <img src="{{ Storage::url($step->{"image{$img}"}) }}" alt="Paso {{ $si+1 }} img {{ $img }}" class="admin-preview-img" style="max-height:80px;">
                                </div>
                            @endif
                            <input type="file" name="steps[{{ $si }}][image{{ $img }}]" class="admin-form-control" accept="image/*">
                        </div>
                        @endfor
                    </div>
                </div>
                @empty
                <div class="admin-step-item" data-index="0">
                    <div class="admin-step-header">
                        <span class="admin-step-number">Paso 01</span>
                        <button type="button" class="admin-btn admin-btn-danger admin-btn-sm admin-step-remove" onclick="removeStep(this)" style="display:none;">✕</button>
                    </div>
                    <div class="admin-form-grid">
                        <div class="admin-form-group">
                            <label>Título del paso</label>
                            <input type="text" name="steps[0][title]" class="admin-form-control" placeholder="Ej: Investigación, Diseño, Desarrollo...">
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <label>Descripción del paso</label>
                        <textarea name="steps[0][description]" class="admin-form-control" placeholder="Describe qué se hizo en este paso..."></textarea>
                    </div>
                    <div class="admin-form-grid admin-form-grid-3">
                        <div class="admin-form-group">
                            <label>Imagen 1</label>
                            <input type="file" name="steps[0][image1]" class="admin-form-control" accept="image/*">
                        </div>
                        <div class="admin-form-group">
                            <label>Imagen 2</label>
                            <input type="file" name="steps[0][image2]" class="admin-form-control" accept="image/*">
                        </div>
                        <div class="admin-form-group">
                            <label>Imagen 3</label>
                            <input type="file" name="steps[0][image3]" class="admin-form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <button type="button" class="admin-btn admin-btn-secondary" onclick="addStep()" style="margin-top:12px;">
                + Agregar paso
            </button>
        </div>

        {{-- Sección: Publicación --}}
        <div class="admin-form-section">
            <h3 class="admin-form-section-title">
                <span class="admin-form-section-icon">📡</span>
                Publicación
            </h3>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label for="status">Estado *</label>
                    <select id="status" name="status" class="admin-form-control">
                        <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="published_at">Fecha de publicación</label>
                    <input type="date" id="published_at" name="published_at" class="admin-form-control"
                           value="{{ old('published_at', $project->published_at?->format('Y-m-d')) }}">
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="admin-btn admin-btn-primary">Actualizar proyecto</button>
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input[name="delete_images[]"]').forEach(cb => {
        cb.addEventListener('change', function() {
            const img = this.closest('.admin-gallery-item').querySelector('img');
            img.style.opacity = this.checked ? '0.3' : '1';
        });
    });

    let stepIndex = {{ $project->steps->count() > 0 ? $project->steps->count() : 1 }};

    function addStep() {
        const container = document.getElementById('steps-container');
        const idx = stepIndex++;
        const num = String(idx + 1).padStart(2, '0');
        const html = `
        <div class="admin-step-item" data-index="${idx}">
            <div class="admin-step-header">
                <span class="admin-step-number">Paso ${num}</span>
                <button type="button" class="admin-btn admin-btn-danger admin-btn-sm admin-step-remove" onclick="removeStep(this)">✕</button>
            </div>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label>Título del paso</label>
                    <input type="text" name="steps[${idx}][title]" class="admin-form-control" placeholder="Ej: Investigación, Diseño, Desarrollo...">
                </div>
            </div>
            <div class="admin-form-group">
                <label>Descripción del paso</label>
                <textarea name="steps[${idx}][description]" class="admin-form-control" placeholder="Describe qué se hizo en este paso..."></textarea>
            </div>
            <div class="admin-form-grid admin-form-grid-3">
                <div class="admin-form-group">
                    <label>Imagen 1</label>
                    <input type="file" name="steps[${idx}][image1]" class="admin-form-control" accept="image/*">
                </div>
                <div class="admin-form-group">
                    <label>Imagen 2</label>
                    <input type="file" name="steps[${idx}][image2]" class="admin-form-control" accept="image/*">
                </div>
                <div class="admin-form-group">
                    <label>Imagen 3</label>
                    <input type="file" name="steps[${idx}][image3]" class="admin-form-control" accept="image/*">
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        updateStepNumbers();
    }

    function removeStep(btn) {
        btn.closest('.admin-step-item').remove();
        updateStepNumbers();
    }

    function updateStepNumbers() {
        document.querySelectorAll('.admin-step-item').forEach((item, i) => {
            item.querySelector('.admin-step-number').textContent = 'Paso ' + String(i + 1).padStart(2, '0');
            if (i === 0 && document.querySelectorAll('.admin-step-item').length === 1) {
                item.querySelector('.admin-step-remove').style.display = 'none';
            } else {
                item.querySelector('.admin-step-remove').style.display = '';
            }
        });
    }
</script>
@endpush
@endsection
