@extends('admin.layouts.app')

@section('title', 'Editar Servicio')
@section('page-title', 'Editar: ' . $service->title)

@section('content')

<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" id="serviceForm">
    @csrf @method('PUT')

    {{-- Header --}}
    <div class="svc-header">
        <a href="{{ route('admin.services.index') }}" class="svc-header-back">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="svc-header-info">
            <h1>
                @if($service->icon)<span>{{ $service->icon }}</span>@endif
                {{ $service->title }}
            </h1>
            <p><i class="fa-solid fa-pen"></i> Editando servicio</p>
        </div>
        <div class="svc-header-actions">
            <button type="submit" name="is_active" value="0" class="svc-btn svc-btn--secondary">
                <i class="fa-solid fa-eye-slash"></i>
                Guardar inactivo
            </button>
            <button type="submit" name="is_active" value="1" class="svc-btn svc-btn--primary">
                <i class="fa-solid fa-check"></i>
                Guardar cambios
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
                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $service->short_description) }}" maxlength="300">
                    <div class="svc-field-footer">
                        <small>Aparecerá en las cards de servicios</small>
                        <span class="svc-counter"><span id="shortDescCount">{{ strlen($service->short_description ?? '') }}</span>/300</span>
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
                    @if($feats && count($feats) > 0)
                        @foreach($feats as $feat)
                        <div class="svc-dynamic-item">
                            <span class="svc-dynamic-icon"><i class="fa-solid fa-check"></i></span>
                            <input type="text" name="features[]" value="{{ $feat }}">
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
                    @php $bens = old('benefits', $service->benefits ?? []); @endphp
                    @if($bens && count($bens) > 0)
                        @foreach($bens as $i => $ben)
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
                    @php $steps = old('process_steps', $service->process_steps ?? []); @endphp
                    @if($steps && count($steps) > 0)
                        @foreach($steps as $i => $step)
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
            {{-- Image Upload --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-image"></i> Imagen principal</h3>

                @if($service->image)
                <div class="svc-current-image">
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}">
                    <label class="svc-remove-checkbox">
                        <input type="checkbox" name="remove_image" value="1">
                        <i class="fa-solid fa-trash"></i> Eliminar imagen
                    </label>
                </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*" hidden onchange="previewImage(event)">
                <div id="imagePreview" class="svc-image-upload" onclick="document.getElementById('image').click()">
                    <div class="svc-image-placeholder">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>{{ $service->image ? 'Cambiar imagen' : 'Click para subir' }}</span>
                    </div>
                </div>
                @error('image')<span class="svc-error">{{ $message }}</span>@enderror
            </div>

            {{-- Gallery --}}
            <div class="svc-sidebar-card">
                <h3><i class="fa-solid fa-images"></i> Galería</h3>

                @if($service->gallery && count($service->gallery) > 0)
                <p class="svc-sidebar-hint">Imágenes actuales:</p>
                <div class="svc-current-gallery">
                    @foreach($service->gallery as $gImg)
                    <div class="svc-gallery-existing">
                        <img src="{{ Storage::url($gImg) }}" alt="Galería">
                        <label>
                            <input type="checkbox" name="remove_gallery[]" value="{{ $gImg }}">
                            <span>Eliminar</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                @endif

                <p class="svc-sidebar-hint">Agregar más imágenes:</p>
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
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="🎨" class="svc-emoji-input">
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="color">Color</label>
                    <div class="svc-color-picker">
                        <input type="color" id="color" name="color" value="{{ old('color', $service->color ?? '#7c3aed') }}">
                        <span id="colorValue">{{ old('color', $service->color ?? '#7c3aed') }}</span>
                    </div>
                </div>

                <div class="svc-field svc-field--compact">
                    <label for="order">Orden</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $service->order) }}" min="0">
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="svc-sidebar-card svc-danger-zone">
                <h3><i class="fa-solid fa-triangle-exclamation"></i> Zona de peligro</h3>
                <p>Esta acción no se puede deshacer</p>
                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('¿Eliminar el servicio {{ $service->title }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="svc-delete-btn">
                        <i class="fa-solid fa-trash"></i>
                        Eliminar servicio
                    </button>
                </form>
            </div>
        </aside>
    </div>
</form>

<style>
/* ═══════════════════════════════════════════════════
   SERVICES FORM STYLES
   ═══════════════════════════════════════════════════ */

/* Header */
.svc-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px -10px rgba(102, 126, 234, 0.4);
}

.svc-header-back {
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.svc-header-back:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-3px);
}

.svc-header-info {
    flex: 1;
}

.svc-header-info h1 {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 800;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.svc-header-info p {
    margin: 0.375rem 0 0 0;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9375rem;
}

.svc-header-actions {
    display: flex;
    gap: 0.75rem;
}

.svc-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.svc-btn--secondary {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.svc-btn--secondary:hover {
    background: rgba(255, 255, 255, 0.25);
}

.svc-btn--primary {
    background: white;
    color: #764ba2;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.svc-btn--primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Layout */
.svc-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 1.5rem;
    align-items: start;
}

.svc-main {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.svc-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    position: sticky;
    top: 96px;
}

/* Card */
.svc-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #f3f4f6;
}

.svc-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #f3f4f6;
}

.svc-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    color: white;
}

.svc-card-icon--purple { background: linear-gradient(135deg, #7c3aed, #a855f7); }
.svc-card-icon--emerald { background: linear-gradient(135deg, #10b981, #34d399); }
.svc-card-icon--amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
.svc-card-icon--blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.svc-card-icon--cyan { background: linear-gradient(135deg, #06b6d4, #22d3ee); }

.svc-card-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a2e;
}

.svc-card-header p {
    margin: 0.25rem 0 0 0;
    font-size: 0.875rem;
    color: #6b7280;
}

/* Fields */
.svc-field {
    margin-bottom: 1.5rem;
}

.svc-field:last-child {
    margin-bottom: 0;
}

.svc-field label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.svc-field .required {
    color: #ef4444;
}

.svc-field input[type="text"],
.svc-field input[type="number"],
.svc-field textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-family: inherit;
    transition: all 0.3s;
    background: white;
}

.svc-field input:focus,
.svc-field textarea:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
}

.svc-field small {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: #9ca3af;
}

.svc-field-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
}

.svc-counter {
    font-size: 0.75rem;
    color: #9ca3af;
}

.svc-counter span {
    color: #7c3aed;
    font-weight: 600;
}

.svc-error {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.8125rem;
    color: #ef4444;
}

/* Input Group */
.svc-input-group {
    display: flex;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.svc-input-prefix {
    padding: 0.875rem 1rem;
    background: #f9fafb;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
    border-right: 2px solid #e5e7eb;
}

.svc-input-group input {
    flex: 1;
    border: none !important;
    border-radius: 0 !important;
}

/* Dynamic Lists */
.svc-dynamic-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.svc-dynamic-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.svc-dynamic-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #10b981, #34d399);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.svc-dynamic-item input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
}

.svc-dynamic-item input:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.svc-dynamic-remove,
.svc-benefit-remove,
.svc-step-remove {
    width: 36px;
    height: 36px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 10px;
    color: #ef4444;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    flex-shrink: 0;
}

.svc-dynamic-remove:hover,
.svc-benefit-remove:hover,
.svc-step-remove:hover {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
}

.svc-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    margin-top: 1rem;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.05));
    border: 2px dashed #10b981;
    border-radius: 12px;
    color: #10b981;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.svc-add-btn:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.1));
}

.svc-add-btn--amber {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.05));
    border-color: #f59e0b;
    color: #d97706;
}

.svc-add-btn--blue {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.05));
    border-color: #3b82f6;
    color: #2563eb;
}

/* Benefits */
.svc-benefits-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.svc-benefit-card {
    display: grid;
    grid-template-columns: 60px 1fr 1fr auto;
    gap: 0.75rem;
    padding: 1rem;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1px solid #fde68a;
    border-radius: 14px;
    align-items: center;
}

.svc-benefit-emoji {
    padding: 0.75rem;
    text-align: center;
    font-size: 1.5rem;
    border: 2px solid #fcd34d !important;
    border-radius: 10px;
    background: white;
}

.svc-benefit-title,
.svc-benefit-desc {
    padding: 0.75rem 1rem;
    border: 2px solid #fcd34d;
    border-radius: 10px;
    font-size: 0.9375rem;
    background: white;
}

.svc-benefit-title:focus,
.svc-benefit-desc:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

/* Steps */
.svc-steps-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.svc-step-card {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid #bfdbfe;
    border-radius: 14px;
    align-items: flex-start;
}

.svc-step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    font-weight: 800;
    flex-shrink: 0;
}

.svc-step-inputs {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.svc-step-inputs input {
    padding: 0.75rem 1rem;
    border: 2px solid #93c5fd;
    border-radius: 10px;
    font-size: 0.9375rem;
    background: white;
}

.svc-step-inputs input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Sidebar */
.svc-sidebar-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    border: 1px solid #f3f4f6;
}

.svc-sidebar-card h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 0 1rem 0;
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a2e;
}

.svc-sidebar-card h3 i {
    color: #7c3aed;
}

.svc-sidebar-hint {
    margin: 0 0 0.75rem 0;
    font-size: 0.8125rem;
    color: #6b7280;
}

/* Current Image */
.svc-current-image {
    margin-bottom: 1rem;
}

.svc-current-image img {
    width: 100%;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.svc-remove-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    font-size: 0.8125rem;
    color: #ef4444;
    cursor: pointer;
}

.svc-remove-checkbox input {
    width: 16px;
    height: 16px;
}

/* Current Gallery */
.svc-current-gallery {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.svc-gallery-existing {
    position: relative;
}

.svc-gallery-existing img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.svc-gallery-existing label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(239, 68, 68, 0.95);
    color: white;
    padding: 0.375rem;
    font-size: 0.6875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    cursor: pointer;
    border-radius: 0 0 10px 10px;
}

.svc-gallery-existing input {
    width: 12px;
    height: 12px;
}

/* Image Upload */
.svc-image-upload {
    width: 100%;
    aspect-ratio: 16/10;
    border: 2px dashed #d1d5db;
    border-radius: 14px;
    background: linear-gradient(135deg, #f9fafb, #f3f4f6);
    cursor: pointer;
    overflow: hidden;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.svc-image-upload:hover {
    border-color: #7c3aed;
    background: linear-gradient(135deg, #faf5ff, #f5f3ff);
}

.svc-image-placeholder {
    text-align: center;
    padding: 1.5rem;
}

.svc-image-placeholder i {
    font-size: 2rem;
    color: #7c3aed;
    margin-bottom: 0.5rem;
}

.svc-image-placeholder span {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.svc-image-upload img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Gallery */
.svc-gallery-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.svc-gallery-add {
    aspect-ratio: 1;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    background: linear-gradient(135deg, #f9fafb, #f3f4f6);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.svc-gallery-add:hover {
    border-color: #7c3aed;
    background: linear-gradient(135deg, #faf5ff, #f5f3ff);
}

.svc-gallery-add i {
    font-size: 1.5rem;
    color: #9ca3af;
}

.svc-gallery-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 12px;
    overflow: hidden;
}

.svc-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.svc-gallery-item button {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 24px;
    height: 24px;
    background: rgba(239, 68, 68, 0.9);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.svc-gallery-item:hover button {
    opacity: 1;
}

/* Emoji Input */
.svc-emoji-input {
    text-align: center;
    font-size: 1.5rem !important;
}

/* Color Picker */
.svc-color-picker {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.svc-color-picker input[type="color"] {
    width: 50px;
    height: 40px;
    padding: 2px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
}

.svc-color-picker span {
    font-family: 'SF Mono', monospace;
    font-size: 0.875rem;
    color: #6b7280;
}

/* Compact Field */
.svc-field--compact {
    margin-bottom: 1rem;
}

.svc-field--compact label {
    font-size: 0.8125rem;
    margin-bottom: 0.375rem;
}

.svc-field--compact input {
    padding: 0.75rem 1rem;
}

/* Danger Zone */
.svc-danger-zone {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border-color: #fecaca;
}

.svc-danger-zone h3 {
    color: #991b1b;
}

.svc-danger-zone h3 i {
    color: #ef4444;
}

.svc-danger-zone p {
    margin: 0 0 1rem 0;
    font-size: 0.8125rem;
    color: #b91c1c;
}

.svc-delete-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: #ef4444;
    border: none;
    border-radius: 12px;
    color: white;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.svc-delete-btn:hover {
    background: #dc2626;
}

/* Responsive */
@media (max-width: 1024px) {
    .svc-layout {
        grid-template-columns: 1fr;
    }

    .svc-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .svc-header {
        flex-direction: column;
        text-align: center;
    }

    .svc-header-info {
        text-align: center;
    }

    .svc-header-actions {
        flex-direction: column;
        width: 100%;
    }

    .svc-btn {
        justify-content: center;
    }

    .svc-benefit-card {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection

@push('scripts')
<script>
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
let benefitIdx = {{ count(old('benefits', $service->benefits ?? [])) }};
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
let stepIdx = {{ count(old('process_steps', $service->process_steps ?? [])) }};
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
</script>
@endpush
