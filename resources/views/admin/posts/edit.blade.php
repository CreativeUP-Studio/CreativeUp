@extends('admin.layouts.app')

@section('title', 'Editar Post')
@section('page-title', 'Editar Post')

@section('content')

<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" id="postForm">
    @csrf
    @method('PUT')

    {{-- ═══════════════════════════════════════════════════
         HEADER WITH ACTIONS
         ═══════════════════════════════════════════════════ --}}
    <div class="admin-post-header">
        <div class="admin-post-header-left">
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
                <i class="fa-solid fa-arrow-left"></i>
                Volver
            </a>
            <div class="admin-post-header-info">
                <h1 class="admin-post-header-title">Editar Post</h1>
                <p class="admin-post-header-subtitle">{{ $post->title }}</p>
            </div>
        </div>
        <div class="admin-post-header-actions">
            <a href="{{ route('blog.show', $post->slug) }}"
               target="_blank"
               class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-eye"></i>
                Vista previa
            </a>
            <button type="submit" name="status" value="draft" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-floppy-disk"></i>
                Guardar borrador
            </button>
            <button type="submit" name="status" value="published" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-paper-plane"></i>
                {{ $post->status === 'published' ? 'Actualizar' : 'Publicar' }}
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MAIN EDITOR LAYOUT (2 COLUMNS)
         ═══════════════════════════════════════════════════ --}}
    <div class="admin-post-editor">
        {{-- Left Column: Main Content --}}
        <div class="admin-post-main">
            {{-- Title --}}
            <div class="admin-form-group">
                <input type="text"
                       id="title"
                       name="title"
                       class="admin-post-title-input"
                       value="{{ old('title', $post->title) }}"
                       placeholder="Escribe el título del post..."
                       required
                       maxlength="200">
                <div class="admin-post-title-counter">
                    <span id="titleCount">{{ strlen(old('title', $post->title)) }}</span> / 200 caracteres
                </div>
                @error('title')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="admin-form-group">
                <label class="admin-form-label">
                    <i class="fa-solid fa-link"></i>
                    URL amigable (slug)
                </label>
                <div class="admin-input-group">
                    <span class="admin-input-prefix">/blog/</span>
                    <input type="text"
                           id="slug"
                           name="slug"
                           class="admin-form-input"
                           value="{{ old('slug', $post->slug) }}"
                           placeholder="se-genera-automaticamente"
                           data-auto="false">
                </div>
                <p class="admin-form-help">Se genera automáticamente del título si lo dejas vacío</p>
                @error('slug')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Content Editor --}}
            <div class="admin-form-group">
                <label class="admin-form-label">
                    <i class="fa-solid fa-file-lines"></i>
                    Contenido del post
                    <span class="required">*</span>
                </label>
                <div class="admin-editor-toolbar">
                    <button type="button" class="admin-editor-btn" data-action="bold" title="Negrita">
                        <i class="fa-solid fa-bold"></i>
                    </button>
                    <button type="button" class="admin-editor-btn" data-action="italic" title="Cursiva">
                        <i class="fa-solid fa-italic"></i>
                    </button>
                    <button type="button" class="admin-editor-btn" data-action="heading" title="Título">
                        <i class="fa-solid fa-heading"></i>
                    </button>
                    <span class="admin-editor-divider"></span>
                    <button type="button" class="admin-editor-btn" data-action="list" title="Lista">
                        <i class="fa-solid fa-list-ul"></i>
                    </button>
                    <button type="button" class="admin-editor-btn" data-action="link" title="Enlace">
                        <i class="fa-solid fa-link"></i>
                    </button>
                    <button type="button" class="admin-editor-btn" data-action="quote" title="Cita">
                        <i class="fa-solid fa-quote-right"></i>
                    </button>
                </div>
                <textarea id="content"
                          name="content"
                          class="admin-post-content-editor"
                          placeholder="Escribe el contenido de tu post aquí..."
                          required
                          rows="20">{{ old('content', $post->content) }}</textarea>
                <div class="admin-editor-stats">
                    <span class="admin-editor-stat">
                        <i class="fa-solid fa-text-width"></i>
                        <span id="wordCount">0</span> palabras
                    </span>
                    <span class="admin-editor-stat">
                        <i class="fa-solid fa-align-left"></i>
                        <span id="charCount">0</span> caracteres
                    </span>
                    <span class="admin-editor-stat">
                        <i class="fa-regular fa-clock"></i>
                        <span id="readTime">0</span> min de lectura
                    </span>
                </div>
                @error('content')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- SEO Section --}}
            <div class="admin-post-section">
                <div class="admin-post-section-header">
                    <h3 class="admin-post-section-title">
                        <i class="fa-solid fa-search"></i>
                        SEO & Meta información
                    </h3>
                </div>
                <div class="admin-post-section-content">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Meta descripción</label>
                        <textarea name="meta_description"
                                  id="metaDescription"
                                  class="admin-form-textarea"
                                  placeholder="Breve descripción para motores de búsqueda..."
                                  maxlength="160"
                                  rows="3">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                        <div class="admin-form-help">
                            <span id="metaCount">0</span> / 160 caracteres
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebar --}}
        <div class="admin-post-sidebar">
            {{-- Featured Image --}}
            <div class="admin-post-sidebar-card">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-image"></i>
                    Imagen destacada
                </h3>
                <div class="admin-post-image-upload">
                    <input type="file"
                           id="featured_image"
                           name="featured_image"
                           accept="image/*"
                           class="admin-file-input"
                           onchange="previewImage(event)">
                    <div id="imagePreview" class="admin-image-preview">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                 alt="{{ $post->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--admin-radius);">
                        @else
                            <div class="admin-image-preview-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <p>Click para subir imagen</p>
                                <span>JPG, PNG, GIF (Max 2MB)</span>
                            </div>
                        @endif
                    </div>
                    <label for="featured_image" class="admin-btn admin-btn-secondary admin-btn-sm" style="width: 100%; margin-top: 12px;">
                        <i class="fa-solid fa-upload"></i>
                        {{ $post->featured_image ? 'Cambiar imagen' : 'Seleccionar imagen' }}
                    </label>
                </div>
                @error('featured_image')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Publish Settings --}}
            <div class="admin-post-sidebar-card">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-calendar-check"></i>
                    Configuración de publicación
                </h3>

                <div class="admin-form-group">
                    <label class="admin-form-label">Estado</label>
                    <select name="status_select" id="status" class="admin-form-select">
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>
                            Borrador
                        </option>
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>
                            Publicado
                        </option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Fecha de publicación</label>
                    <input type="datetime-local"
                           name="published_at"
                           class="admin-form-input"
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                    <p class="admin-form-help">Déjalo vacío para publicar ahora</p>
                </div>
            </div>

            {{-- Post Info --}}
            <div class="admin-post-sidebar-card">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-info-circle"></i>
                    Información del post
                </h3>
                <div class="admin-post-info">
                    <div class="admin-post-info-item">
                        <span class="admin-post-info-label">Autor</span>
                        <span class="admin-post-info-value">{{ $post->user->name ?? 'Admin' }}</span>
                    </div>
                    <div class="admin-post-info-item">
                        <span class="admin-post-info-label">Creado</span>
                        <span class="admin-post-info-value">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="admin-post-info-item">
                        <span class="admin-post-info-label">Actualizado</span>
                        <span class="admin-post-info-value">{{ $post->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Category/Tags --}}
            <div class="admin-post-sidebar-card">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-tag"></i>
                    Categoría
                </h3>
                <div class="admin-post-categories">
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="branding">
                        <span class="admin-category-label">
                            <i class="fa-solid fa-palette"></i>
                            Branding
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="diseno">
                        <span class="admin-category-label">
                            <i class="fa-solid fa-pen-nib"></i>
                            Diseño Web
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="seo">
                        <span class="admin-category-label">
                            <i class="fa-solid fa-chart-line"></i>
                            SEO
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="redes">
                        <span class="admin-category-label">
                            <i class="fa-solid fa-share-nodes"></i>
                            Social Media
                        </span>
                    </label>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="admin-post-sidebar-card admin-post-danger">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Zona de peligro
                </h3>
                <p class="admin-danger-text">Esta acción no se puede deshacer</p>
                <form method="POST"
                      action="{{ route('admin.posts.destroy', $post) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar este post permanentemente?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" style="width: 100%;">
                        <i class="fa-solid fa-trash"></i>
                        Eliminar post
                    </button>
                </form>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// Title character counter
const titleInput = document.getElementById('title');
const titleCount = document.getElementById('titleCount');
const slugInput = document.getElementById('slug');

titleInput.addEventListener('input', function() {
    titleCount.textContent = this.value.length;

    // Auto-generate slug if empty
    if (slugInput.dataset.auto !== 'false') {
        slugInput.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
});

slugInput.addEventListener('input', function() {
    slugInput.dataset.auto = 'false';
});

// Content stats counter
const contentEditor = document.getElementById('content');
const wordCount = document.getElementById('wordCount');
const charCount = document.getElementById('charCount');
const readTime = document.getElementById('readTime');

contentEditor.addEventListener('input', function() {
    const text = this.value.trim();
    const words = text ? text.split(/\s+/).length : 0;
    const chars = text.length;
    const minutes = Math.max(1, Math.ceil(words / 200));

    wordCount.textContent = words;
    charCount.textContent = chars;
    readTime.textContent = minutes;
});

// Meta description counter
const metaDescription = document.getElementById('metaDescription');
const metaCount = document.getElementById('metaCount');

if (metaDescription) {
    metaDescription.addEventListener('input', function() {
        metaCount.textContent = this.value.length;
    });
}

// Image preview
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--admin-radius);">`;
        };

        reader.readAsDataURL(file);
    }
}

// Editor toolbar actions
document.querySelectorAll('.admin-editor-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const action = this.dataset.action;
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        let replacement = selectedText;

        switch(action) {
            case 'bold':
                replacement = `**${selectedText}**`;
                break;
            case 'italic':
                replacement = `*${selectedText}*`;
                break;
            case 'heading':
                replacement = `## ${selectedText}`;
                break;
            case 'list':
                replacement = `- ${selectedText}`;
                break;
            case 'link':
                replacement = `[${selectedText}](url)`;
                break;
            case 'quote':
                replacement = `> ${selectedText}`;
                break;
        }

        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start, start + replacement.length);

        // Trigger content update
        contentEditor.dispatchEvent(new Event('input'));
    });
});

// Initialize counters
titleInput.dispatchEvent(new Event('input'));
contentEditor.dispatchEvent(new Event('input'));
if (metaDescription) metaDescription.dispatchEvent(new Event('input'));
</script>
@endpush
