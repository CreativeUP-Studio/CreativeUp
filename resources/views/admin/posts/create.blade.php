@extends('admin.layouts.app')

@section('title', 'Nuevo Post')
@section('page-title', 'Crear Nuevo Post')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/posts.css') }}">
@endpush

@section('content')

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" id="postForm">
    @csrf

    {{-- Header --}}
    <div class="admin-compact-header">
        <div class="admin-compact-header-left">
            <a href="{{ route('admin.posts.index') }}" class="admin-compact-header-back" title="Volver a la lista">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="admin-compact-header-info">
                <h1>Nuevo Post</h1>
            </div>
        </div>
        <div class="admin-compact-header-actions">
            <button type="submit" name="status" value="draft" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar Borrador</span>
            </button>
            <button type="submit" name="status" value="published" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Publicar</span>
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
                       value="{{ old('title') }}"
                       placeholder="Escribe el título del post..."
                       required
                       maxlength="200">
                <div class="admin-post-title-counter">
                    <span id="titleCount">0</span> / 200 caracteres
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
                <div class="admin-input-group" style="position: relative;">
                    <span class="admin-input-prefix">/blog/</span>
                    <input type="text"
                           id="slug"
                           name="slug"
                           class="admin-form-input"
                           value="{{ old('slug') }}"
                           placeholder="se-genera-automaticamente"
                           style="padding-right: 40px;">
                    <button type="button" id="toggleSlugLock" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1rem; z-index: 5;" title="Bloquear/Desbloquear generación automática">
                        <i class="fa-solid fa-lock"></i>
                    </button>
                </div>
                <p class="admin-form-help">Se genera automáticamente del título si lo dejas vacío</p>
                @error('slug')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Content Editor --}}
            <div class="admin-form-group">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                    <label class="admin-form-label" style="margin-bottom: 0;">
                        <i class="fa-solid fa-file-lines"></i>
                        Contenido del post
                        <span class="required">*</span>
                    </label>
                </div>

                <div id="editor-write-container" style="border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; background: #0b0f19;">
                    <textarea id="content"
                              name="content"
                              class="admin-post-content-editor"
                              placeholder="Escribe el contenido de tu post aquí..."
                              required
                              rows="20">{{ old('content') }}</textarea>
                </div>

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
                                  rows="3">{{ old('meta_description') }}</textarea>
                        <div class="admin-form-help">
                            <span id="metaCount">0</span> / 160 caracteres
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebar --}}
        <div class="admin-post-sidebar">
            {{-- Live SEO Assistant --}}
            <div class="admin-post-sidebar-card" style="border: 1px solid rgba(56, 189, 248, 0.25); background: rgba(56, 189, 248, 0.03); border-radius: 12px; padding: 1.25rem;">
                <h3 class="admin-post-sidebar-title" style="color: #38bdf8; display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px solid rgba(56,189,248,0.15); padding-bottom: 8px; font-size: 0.9rem;">
                    <span style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-gauge-high"></i>
                        Asistente SEO
                    </span>
                    <span id="liveSeoScore" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 800; border: 1px solid rgba(56,189,248,0.25);">0/100</span>
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 8px;" id="liveSeoChecklist">
                    <div style="display: flex; align-items: start; gap: 8px; font-size: 0.75rem; color: #f87171; transition: color 0.3s;" id="check-title">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 2px; width: 12px; text-align: center;"></i>
                        <span>Título del post (40-70 car.)</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 8px; font-size: 0.75rem; color: #f87171; transition: color 0.3s;" id="check-slug">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 2px; width: 12px; text-align: center;"></i>
                        <span>Slug URL amigable</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 8px; font-size: 0.75rem; color: #f87171; transition: color 0.3s;" id="check-content">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 2px; width: 12px; text-align: center;"></i>
                        <span>Contenido (mín. 300 palabras)</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 8px; font-size: 0.75rem; color: #f87171; transition: color 0.3s;" id="check-meta">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 2px; width: 12px; text-align: center;"></i>
                        <span>Meta descripción (110-160 car.)</span>
                    </div>
                    <div style="display: flex; align-items: start; gap: 8px; font-size: 0.75rem; color: #f87171; transition: color 0.3s;" id="check-image">
                        <i class="fa-solid fa-circle-xmark" style="margin-top: 2px; width: 12px; text-align: center;"></i>
                        <span>Imagen destacada subida</span>
                    </div>
                </div>
            </div>

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
                        <div class="admin-image-preview-placeholder">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>Click para subir imagen</p>
                            <span>JPG, PNG, GIF (Max 2MB)</span>
                        </div>
                    </div>
                    <label for="featured_image" class="admin-btn admin-btn-secondary admin-btn-sm" style="width: 100%; margin-top: 12px;">
                        <i class="fa-solid fa-upload"></i>
                        Seleccionar imagen
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
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                            Borrador
                        </option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                            Publicado
                        </option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Fecha de publicación</label>
                    <input type="datetime-local"
                           name="published_at"
                           class="admin-form-input"
                           value="{{ old('published_at') }}">
                    <p class="admin-form-help">Déjalo vacío para publicar ahora</p>
                </div>
            </div>

            {{-- Category/Tags (Future) --}}
            <div class="admin-post-sidebar-card">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-tag"></i>
                    Categoría
                </h3>
                <div class="admin-post-categories">
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="branding" {{ old('category') === 'branding' ? 'checked' : '' }}>
                        <span class="admin-category-label">
                            <i class="fa-solid fa-palette"></i>
                            Branding
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="diseno" {{ old('category') === 'diseno' ? 'checked' : '' }}>
                        <span class="admin-category-label">
                            <i class="fa-solid fa-pen-nib"></i>
                            Diseño Web
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="seo" {{ old('category') === 'seo' ? 'checked' : '' }}>
                        <span class="admin-category-label">
                            <i class="fa-solid fa-chart-line"></i>
                            SEO
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="redes" {{ old('category') === 'redes' ? 'checked' : '' }}>
                        <span class="admin-category-label">
                            <i class="fa-solid fa-share-nodes"></i>
                            Social Media
                        </span>
                    </label>
                    <label class="admin-category-item">
                        <input type="radio" name="category" value="marketing" {{ old('category', 'marketing') === 'marketing' ? 'checked' : '' }}>
                        <span class="admin-category-label">
                            <i class="fa-solid fa-bullhorn"></i>
                            Marketing Digital
                        </span>
                    </label>
                </div>
            </div>

            {{-- Quick Tips --}}
            <div class="admin-post-sidebar-card admin-post-tips">
                <h3 class="admin-post-sidebar-title">
                    <i class="fa-solid fa-lightbulb"></i>
                    Consejos
                </h3>
                <ul class="admin-tips-list">
                    <li><i class="fa-solid fa-check"></i> Usa un título llamativo y descriptivo</li>
                    <li><i class="fa-solid fa-check"></i> Agrega una imagen destacada atractiva</li>
                    <li><i class="fa-solid fa-check"></i> Escribe contenido de valor y bien estructurado</li>
                    <li><i class="fa-solid fa-check"></i> Optimiza la meta descripción para SEO</li>
                </ul>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE
    tinymce.init({
        selector: '#content',
        language: 'es',
        height: 550,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount directionality emoticons visualchars codesample',
        toolbar: 'undo redo | blocks | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | fullscreen code preview',
        menubar: 'file edit view insert format table tools help',
        branding: false,
        promotion: false,
        skin: 'oxide-dark',
        content_css: 'dark',
        content_style: `
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
            body { 
                font-family: 'Poppins', sans-serif; 
                font-size: 15px; 
                line-height: 1.8; 
                color: #e2e8f0; 
                background-color: #0f172a; 
                padding: 1.5rem;
            }
            h1, h2, h3, h4, h5, h6 { 
                color: #ffffff; 
                font-weight: 700; 
            }
            a { 
                color: #ff006e; 
                text-decoration: underline; 
            }
            blockquote { 
                border-left: 4px solid #ff006e; 
                padding: 1.25rem 1.75rem; 
                background: rgba(255, 0, 110, 0.03); 
                color: #cbd5e1; 
                font-style: italic; 
                margin: 1.5rem 0;
                position: relative;
            }
            img, video, iframe { 
                max-width: 100%; 
                height: auto; 
                border-radius: 16px; 
                display: block; 
                margin: 2rem 0; 
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            iframe {
                aspect-ratio: 16 / 9;
                width: 100%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 1.5rem 0;
                color: #e2e8f0;
            }
            th, td {
                border: 1px solid #334155;
                padding: 10px 14px;
            }
            th {
                background-color: #1e293b;
                font-weight: 600;
            }
        `,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image media',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            
            if (meta.filetype === 'image') {
                input.setAttribute('accept', 'image/*');
            } else if (meta.filetype === 'media') {
                input.setAttribute('accept', 'video/*,audio/*');
            }

            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();
                
                reader.onload = function () {
                    // Show a uploading state
                    Swal.fire({
                        title: 'Subiendo archivo...',
                        text: 'Por favor espera a que se complete la carga.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    var formData = new FormData();
                    formData.append('upload', file);

                    fetch("{{ route('admin.posts.upload-media') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al subir archivo');
                        }
                        return response.json();
                    })
                    .then(result => {
                        Swal.close();
                        cb(result.url, { title: file.name });
                        showSuccess('Archivo subido con éxito');
                    })
                    .catch(error => {
                        Swal.close();
                        console.error(error);
                        showError('Error al subir archivo. Formato no compatible o excede los 50MB.');
                    });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },
        setup: function (editor) {
            editor.on('change keyup input', function () {
                // Sync content to textarea
                editor.save();
                updateCountersAndSeo();
            });
        }
    });

    // Helper functions for counters & SEO
    const titleInput = document.getElementById('title');
    const titleCount = document.getElementById('titleCount');
    const slugInput = document.getElementById('slug');
    const slugLockBtn = document.getElementById('toggleSlugLock');
    const wordCount = document.getElementById('wordCount');
    const charCount = document.getElementById('charCount');
    const readTime = document.getElementById('readTime');
    const metaDescription = document.getElementById('metaDescription');
    const metaCount = document.getElementById('metaCount');
    const previewImg = document.getElementById('imagePreview');

    let isSlugAuto = slugInput.dataset.auto !== 'false';

    function updateSlugLockUI() {
        if (slugLockBtn) {
            if (isSlugAuto) {
                slugLockBtn.innerHTML = '<i class="fa-solid fa-lock-open" style="color: #38bdf8;"></i>';
                slugLockBtn.title = "Generación automática activada (clic para bloquear)";
                slugInput.readOnly = true;
                slugInput.style.backgroundColor = 'rgba(255,255,255,0.02)';
                slugInput.style.color = '#94a3b8';
            } else {
                slugLockBtn.innerHTML = '<i class="fa-solid fa-lock" style="color: #f43f5e;"></i>';
                slugLockBtn.title = "Generación automática desactivada (clic para activar)";
                slugInput.readOnly = false;
                slugInput.style.backgroundColor = '';
                slugInput.style.color = '';
            }
        }
    }

    updateSlugLockUI();

    if (slugLockBtn) {
        slugLockBtn.addEventListener('click', function() {
            isSlugAuto = !isSlugAuto;
            slugInput.dataset.auto = isSlugAuto ? 'true' : 'false';
            updateSlugLockUI();
            if (isSlugAuto) {
                titleInput.dispatchEvent(new Event('input'));
            }
        });
    }

    titleInput.addEventListener('input', function() {
        titleCount.textContent = this.value.length;
        if (isSlugAuto) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        }
        runLiveSeoAnalysis();
    });

    slugInput.addEventListener('input', function() {
        if (isSlugAuto) {
            isSlugAuto = false;
            slugInput.dataset.auto = 'false';
            updateSlugLockUI();
        }
        runLiveSeoAnalysis();
    });

    if (metaDescription) {
        metaDescription.addEventListener('input', function() {
            metaCount.textContent = this.value.length;
            runLiveSeoAnalysis();
        });
    }

    function updateCountersAndSeo() {
        const text = tinymce.get('content') ? tinymce.get('content').getContent({ format: 'text' }).trim() : '';
        const words = text ? text.split(/\s+/).filter(w => w).length : 0;
        const chars = text.length;
        const minutes = Math.max(1, Math.ceil(words / 200));

        wordCount.textContent = words;
        charCount.textContent = chars;
        readTime.textContent = minutes;
        
        runLiveSeoAnalysis();
    }

    window.runLiveSeoAnalysis = function() {
        let score = 0;
        
        // 1. Título
        const titleVal = titleInput.value.trim();
        const titleLen = titleVal.length;
        const checkTitle = document.getElementById('check-title');
        if (titleLen >= 40 && titleLen <= 70) {
            score += 30;
            checkTitle.style.color = '#4ade80';
            checkTitle.querySelector('i').className = 'fa-solid fa-circle-check';
        } else {
            checkTitle.style.color = '#f87171';
            checkTitle.querySelector('i').className = 'fa-solid fa-circle-xmark';
        }

        // 2. Slug
        const slugVal = slugInput.value.trim();
        const checkSlug = document.getElementById('check-slug');
        const slugRegex = /^[a-z0-9-]+$/;
        if (slugVal.length > 0 && slugRegex.test(slugVal)) {
            score += 15;
            checkSlug.style.color = '#4ade80';
            checkSlug.querySelector('i').className = 'fa-solid fa-circle-check';
        } else {
            checkSlug.style.color = '#f87171';
            checkSlug.querySelector('i').className = 'fa-solid fa-circle-xmark';
        }

        // 3. Contenido
        const contentVal = tinymce.get('content') ? tinymce.get('content').getContent({ format: 'text' }).trim() : '';
        const words = contentVal ? contentVal.split(/\s+/).filter(w => w).length : 0;
        const checkContent = document.getElementById('check-content');
        if (words >= 300) {
            score += 25;
            checkContent.style.color = '#4ade80';
            checkContent.querySelector('i').className = 'fa-solid fa-circle-check';
            if (words >= 600) {
                score += 5;
            }
        } else {
            checkContent.style.color = '#f87171';
            checkContent.querySelector('i').className = 'fa-solid fa-circle-xmark';
        }

        // 4. Meta descripción
        const metaVal = metaDescription ? metaDescription.value.trim() : '';
        const metaLen = metaVal.length;
        const checkMeta = document.getElementById('check-meta');
        if (checkMeta) {
            if (metaLen >= 110 && metaLen <= 160) {
                score += 20;
                checkMeta.style.color = '#4ade80';
                checkMeta.querySelector('i').className = 'fa-solid fa-circle-check';
            } else {
                checkMeta.style.color = '#f87171';
                checkMeta.querySelector('i').className = 'fa-solid fa-circle-xmark';
            }
        }

        // 5. Imagen destacada
        const hasImage = previewImg ? previewImg.querySelector('img') !== null : false;
        const checkImage = document.getElementById('check-image');
        if (checkImage) {
            if (hasImage) {
                score += 10;
                checkImage.style.color = '#4ade80';
                checkImage.querySelector('i').className = 'fa-solid fa-circle-check';
            } else {
                checkImage.style.color = '#f87171';
                checkImage.querySelector('i').className = 'fa-solid fa-circle-xmark';
            }
        }

        // Actualizar score UI
        const scoreEl = document.getElementById('liveSeoScore');
        if (scoreEl) {
            scoreEl.textContent = score + '/100';
            if (score >= 80) {
                scoreEl.style.backgroundColor = 'rgba(74, 222, 128, 0.15)';
                scoreEl.style.color = '#4ade80';
                scoreEl.style.borderColor = 'rgba(74, 222, 128, 0.25)';
            } else if (score >= 50) {
                scoreEl.style.backgroundColor = 'rgba(250, 204, 21, 0.15)';
                scoreEl.style.color = '#facc15';
                scoreEl.style.borderColor = 'rgba(250, 204, 21, 0.25)';
            } else {
                scoreEl.style.backgroundColor = 'rgba(248, 113, 113, 0.15)';
                scoreEl.style.color = '#f87171';
                scoreEl.style.borderColor = 'rgba(248, 113, 113, 0.25)';
            }
        }
    };

    // Initialize state
    titleInput.dispatchEvent(new Event('input'));
    if (metaDescription) metaDescription.dispatchEvent(new Event('input'));
    setTimeout(updateCountersAndSeo, 800);
});

// Image preview
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--admin-radius);">`;
            runLiveSeoAnalysis();
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
