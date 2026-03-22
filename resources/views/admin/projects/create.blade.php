@extends('admin.layouts.app')

@section('title', 'Nuevo Proyecto')
@section('page-title', 'Crear Proyecto')

@section('content')

<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" id="projectForm">
    @csrf

    {{-- ═══════════════════════════════════════════════════
         HEADER WITH ACTIONS
         ═══════════════════════════════════════════════════ --}}
    <div class="admin-post-header" style="background: linear-gradient(135deg, #5e17eb 0%, #7c3aed 100%); color: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(124, 58, 237, 0.25);">
        <div class="admin-post-header-left">
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm" style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px);">
                <i class="fa-solid fa-arrow-left"></i>
                Volver
            </a>
            <div class="admin-post-header-info">
                <h1 class="admin-post-header-title" style="color: white; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-sparkles" style="color: #fbbf24; margin-right: 0.5rem;"></i>
                    Nuevo Proyecto
                </h1>
                <p class="admin-post-header-subtitle" style="color: rgba(255, 255, 255, 0.9); font-size: 1rem;">Crea un proyecto increíble para tu portafolio</p>
            </div>
        </div>
        <div class="admin-post-header-actions">
            <button type="submit" name="status" value="draft" class="admin-btn admin-btn-secondary" style="background: rgba(255, 255, 255, 0.15); color: white; border: 1px solid rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px);">
                <i class="fa-solid fa-floppy-disk"></i>
                Guardar borrador
            </button>
            <button type="submit" name="status" value="published" class="admin-btn admin-btn-primary" style="background: white; color: #7c3aed; font-weight: 600; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);">
                <i class="fa-solid fa-rocket"></i>
                Publicar Proyecto
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MAIN EDITOR LAYOUT (2 COLUMNS)
         ═══════════════════════════════════════════════════ --}}
    <div class="admin-post-editor">
        {{-- Left Column: Main Content --}}
        <div class="admin-post-main">

            {{-- Información Básica Card --}}
            <div class="admin-project-card" style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <div class="admin-project-card-header">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #7c3aed, #a855f7); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-pen-fancy" style="color: white; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin: 0;">Información Básica</h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Nombre y descripción del proyecto</p>
                        </div>
                    </div>
                </div>

                {{-- Título --}}
                <div class="admin-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-heading" style="color: #7c3aed; margin-right: 0.5rem;"></i>
                        Título del proyecto
                        <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="Ej: Rediseño completo de plataforma e-commerce"
                           required
                           maxlength="150"
                           style="width: 100%; padding: 0.875rem 1rem; font-size: 1.125rem; font-weight: 600; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; background: white;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                        <p style="font-size: 0.75rem; color: #9ca3af; margin: 0;">Define un nombre atractivo y descriptivo</p>
                        <span style="font-size: 0.75rem; color: #9ca3af; font-weight: 500;">
                            <span id="titleCount" style="color: #7c3aed; font-weight: 700;">0</span> / 150
                        </span>
                    </div>
                    @error('title')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="admin-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-link" style="color: #7c3aed; margin-right: 0.5rem;"></i>
                        URL amigable (slug)
                    </label>
                    <div style="display: flex; align-items: center; border: 2px solid #e5e7eb; border-radius: 12px; overflow: hidden; background: white;">
                        <span style="background: #f9fafb; padding: 0.875rem 1rem; font-size: 0.875rem; color: #6b7280; border-right: 2px solid #e5e7eb; font-weight: 500;">/proyectos/</span>
                        <input type="text"
                               id="slug"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="se-genera-automaticamente"
                               style="flex: 1; padding: 0.875rem 1rem; border: none; outline: none; font-size: 0.9375rem;">
                    </div>
                    <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="margin-right: 0.25rem;"></i>
                        Se genera automáticamente del título
                    </p>
                    @error('slug')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="admin-form-group">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-align-left" style="color: #7c3aed; margin-right: 0.5rem;"></i>
                        Descripción general
                        <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              placeholder="Escribe una descripción atractiva que capte la esencia del proyecto y enganche al lector..."
                              required
                              rows="4"
                              maxlength="300"
                              style="width: 100%; padding: 1rem; font-size: 0.9375rem; line-height: 1.6; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; resize: vertical; background: white;">{{ old('description') }}</textarea>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                        <p style="font-size: 0.75rem; color: #9ca3af; margin: 0;">Esta descripción aparecerá en las cards del portafolio</p>
                        <span style="font-size: 0.75rem; color: #9ca3af; font-weight: 500;">
                            <span id="descCount" style="color: #7c3aed; font-weight: 700;">0</span> / 300
                        </span>
                    </div>
                    @error('description')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- El Caso de Éxito --}}
            <div class="admin-project-card" style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <div class="admin-project-card-header">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-trophy" style="color: white; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin: 0;">Caso de Éxito</h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Cuenta la historia del proyecto de forma convincente</p>
                        </div>
                    </div>
                </div>

                <div style="display: grid; gap: 1.5rem;">
                    {{-- El Desafío --}}
                    <div style="position: relative;">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #f59e0b, #fbbf24); border-radius: 4px;"></div>
                        <div style="padding-left: 1.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                <i class="fa-solid fa-mountain" style="color: #f59e0b;"></i>
                                El Desafío
                            </label>
                            <textarea name="challenge"
                                      id="challenge"
                                      placeholder="¿Cuál era el problema inicial? ¿Qué necesidad tenía el cliente que requería solución?"
                                      rows="4"
                                      style="width: 100%; padding: 1rem; font-size: 0.9375rem; line-height: 1.6; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; resize: vertical; background: white;">{{ old('challenge') }}</textarea>
                            <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0;">
                                <i class="fa-solid fa-lightbulb" style="color: #f59e0b; margin-right: 0.25rem;"></i>
                                Describe la situación inicial o el reto que enfrentaba el cliente
                            </p>
                        </div>
                    </div>

                    {{-- La Solución --}}
                    <div style="position: relative;">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #3b82f6, #60a5fa); border-radius: 4px;"></div>
                        <div style="padding-left: 1.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                <i class="fa-solid fa-lightbulb" style="color: #3b82f6;"></i>
                                La Solución
                            </label>
                            <textarea name="solution"
                                      id="solution"
                                      placeholder="¿Qué estrategia implementaste? ¿Cómo abordaste el proyecto? ¿Qué soluciones creativas propusiste?"
                                      rows="4"
                                      style="width: 100%; padding: 1rem; font-size: 0.9375rem; line-height: 1.6; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; resize: vertical; background: white;">{{ old('solution') }}</textarea>
                            <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0;">
                                <i class="fa-solid fa-rocket" style="color: #3b82f6; margin-right: 0.25rem;"></i>
                                Explica tu enfoque, metodología y las soluciones que desarrollaste
                            </p>
                        </div>
                    </div>

                    {{-- Los Resultados --}}
                    <div style="position: relative;">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #10b981, #34d399); border-radius: 4px;"></div>
                        <div style="padding-left: 1.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                <i class="fa-solid fa-chart-line" style="color: #10b981;"></i>
                                Los Resultados
                            </label>
                            <textarea name="results"
                                      id="results"
                                      placeholder="¿Qué logros se obtuvieron? Ej: +200% en conversiones, nueva identidad de marca, mejora en UX..."
                                      rows="4"
                                      style="width: 100%; padding: 1rem; font-size: 0.9375rem; line-height: 1.6; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; resize: vertical; background: white;">{{ old('results') }}</textarea>
                            <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0;">
                                <i class="fa-solid fa-star" style="color: #10b981; margin-right: 0.25rem;"></i>
                                Métricas cuantificables, mejoras o el impacto positivo del proyecto
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tecnologías y URL --}}
            <div class="admin-project-card" style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <div class="admin-project-card-header">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #60a5fa); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-code" style="color: white; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin: 0;">Tecnologías y Enlace</h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Herramientas utilizadas y acceso al proyecto</p>
                        </div>
                    </div>
                </div>

                <div style="display: grid; gap: 1.5rem;">
                    {{-- Tecnologías --}}
                    <div class="admin-form-group">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-tools" style="color: #7c3aed; margin-right: 0.5rem;"></i>
                            Tecnologías / Herramientas
                        </label>
                        <input type="text"
                               id="technologies"
                               name="technologies"
                               value="{{ old('technologies') }}"
                               placeholder="Laravel, Figma, Tailwind CSS, Adobe XD, Vue.js"
                               style="width: 100%; padding: 0.875rem 1rem; font-size: 0.9375rem; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; background: white;">
                        <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0;">
                            <i class="fa-solid fa-info-circle" style="margin-right: 0.25rem;"></i>
                            Separa con comas cada tecnología o herramienta utilizada
                        </p>
                        <div id="techPreview" class="admin-project-techs" style="margin-top: 12px; display: none; gap: 0.5rem; flex-wrap: wrap;"></div>
                    </div>

                    {{-- URL del proyecto --}}
                    <div class="admin-form-group">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-globe" style="color: #7c3aed; margin-right: 0.5rem;"></i>
                            URL del proyecto
                        </label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-external-link-alt" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af;"></i>
                            <input type="url"
                                   id="url"
                                   name="url"
                                   value="{{ old('url') }}"
                                   placeholder="https://ejemplo.com"
                                   style="width: 100%; padding: 0.875rem 1rem 0.875rem 2.75rem; font-size: 0.9375rem; border: 2px solid #e5e7eb; border-radius: 12px; transition: all 0.3s; background: white;">
                        </div>
                        <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; margin-bottom: 0;">
                            <i class="fa-solid fa-link" style="margin-right: 0.25rem;"></i>
                            Enlace al proyecto en vivo (si está disponible públicamente)
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column: Sidebar --}}
        <div class="admin-post-sidebar">

            {{-- Thumbnail --}}
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <h3 style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1rem 0;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-image" style="color: white; font-size: 0.875rem;"></i>
                    </div>
                    Imagen Principal
                </h3>
                <p style="font-size: 0.8125rem; color: #6b7280; margin-bottom: 1rem;">La imagen destacada de tu proyecto</p>

                <div class="admin-post-image-upload">
                    <input type="file"
                           id="thumbnail"
                           name="thumbnail"
                           accept="image/*"
                           class="admin-file-input"
                           onchange="previewThumbnail(event)">
                    <div id="thumbnailPreview" style="position: relative; width: 100%; aspect-ratio: 16/10; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 2px dashed #d1d5db; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; overflow: hidden;" onclick="document.getElementById('thumbnail').click()">
                        <div style="text-align: center; padding: 1.5rem;">
                            <div style="width: 50px; height: 50px; margin: 0 auto 0.75rem; background: linear-gradient(135deg, #7c3aed, #a855f7); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-cloud-arrow-up" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #374151; margin: 0 0 0.25rem 0;">Click para subir imagen</p>
                            <span style="font-size: 0.75rem; color: #9ca3af;">JPG, PNG, GIF (Max 2MB)</span>
                        </div>
                    </div>
                    <label for="thumbnail" class="admin-btn admin-btn-secondary admin-btn-sm" style="width: 100%; margin-top: 12px; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; border-radius: 10px; background: #f9fafb; border: 1px solid #e5e7eb; color: #374151; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        <i class="fa-solid fa-upload"></i>
                        Seleccionar imagen
                    </label>
                </div>
                @error('thumbnail')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Galería de Imágenes --}}
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <h3 style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1rem 0;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-images" style="color: white; font-size: 0.875rem;"></i>
                    </div>
                    Galería del Proyecto
                </h3>
                <p style="font-size: 0.8125rem; color: #6b7280; margin-bottom: 1rem;">
                    Sube múltiples imágenes del proceso o resultados
                </p>
                <div class="admin-post-image-upload">
                    <input type="file"
                           id="gallery"
                           name="images[]"
                           accept="image/*"
                           multiple
                           class="admin-file-input"
                           onchange="previewGallery(event)">
                    <div id="galleryPreview" class="admin-gallery-upload" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                        <div class="admin-gallery-item" onclick="document.getElementById('gallery').click()" style="aspect-ratio: 1; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 2px dashed #d1d5db; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s;">
                            <div style="text-align: center;">
                                <i class="fa-solid fa-plus" style="color: #7c3aed; font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                                <p style="margin: 0; font-size: 0.75rem; color: #6b7280; font-weight: 500;">Agregar<br>imágenes</p>
                            </div>
                        </div>
                    </div>
                </div>
                @error('images.*')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Configuración de Publicación --}}
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <h3 style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1rem 0;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #f59e0b, #fbbf24); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-calendar-check" style="color: white; font-size: 0.875rem;"></i>
                    </div>
                    Publicación
                </h3>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-circle-dot" style="color: #7c3aed; margin-right: 0.375rem; font-size: 0.75rem;"></i>
                        Estado
                    </label>
                    <select name="status_select" id="status" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.875rem; border: 2px solid #e5e7eb; border-radius: 10px; background: white; cursor: pointer; transition: all 0.3s;">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                            📝 Borrador
                        </option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                            ✅ Publicado
                        </option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-clock" style="color: #7c3aed; margin-right: 0.375rem; font-size: 0.75rem;"></i>
                        Fecha de publicación
                    </label>
                    <input type="datetime-local"
                           name="published_at"
                           value="{{ old('published_at') }}"
                           style="width: 100%; padding: 0.75rem 1rem; font-size: 0.875rem; border: 2px solid #e5e7eb; border-radius: 10px; background: white; transition: all 0.3s;">
                    <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.375rem; margin-bottom: 0;">Déjalo vacío para publicar ahora</p>
                </div>
            </div>

            {{-- Información del Proyecto --}}
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 1.5rem; border: 1px solid #f3f4f6;">
                <h3 style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1rem 0;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #06b6d4, #22d3ee); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-folder-open" style="color: white; font-size: 0.875rem;"></i>
                    </div>
                    Detalles del Proyecto
                </h3>

                <div style="display: grid; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-tag" style="color: #7c3aed; margin-right: 0.375rem; font-size: 0.75rem;"></i>
                            Tipo de proyecto
                        </label>
                        <input type="text"
                               id="type"
                               name="type"
                               value="{{ old('type') }}"
                               placeholder="Branding, Web Design, App..."
                               style="width: 100%; padding: 0.75rem 1rem; font-size: 0.875rem; border: 2px solid #e5e7eb; border-radius: 10px; background: white; transition: all 0.3s;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-building" style="color: #7c3aed; margin-right: 0.375rem; font-size: 0.75rem;"></i>
                            Cliente
                        </label>
                        <input type="text"
                               id="client"
                               name="client"
                               value="{{ old('client') }}"
                               placeholder="Nombre del cliente"
                               style="width: 100%; padding: 0.75rem 1rem; font-size: 0.875rem; border: 2px solid #e5e7eb; border-radius: 10px; background: white; transition: all 0.3s;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-calendar" style="color: #7c3aed; margin-right: 0.375rem; font-size: 0.75rem;"></i>
                            Año
                        </label>
                        <input type="text"
                               id="year"
                               name="year"
                               value="{{ old('year', date('Y')) }}"
                               placeholder="2026"
                               style="width: 100%; padding: 0.75rem 1rem; font-size: 0.875rem; border: 2px solid #e5e7eb; border-radius: 10px; background: white; transition: all 0.3s;">
                    </div>
                </div>
            </div>

            {{-- Tips Card --}}
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(251, 191, 36, 0.15); border: 1px solid #fcd34d;">
                <h3 style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 700; color: #92400e; margin: 0 0 1rem 0;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-lightbulb" style="color: white; font-size: 0.875rem;"></i>
                    </div>
                    Tips para un buen proyecto
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 0.75rem;">
                    <li style="display: flex; align-items: flex-start; gap: 0.625rem; font-size: 0.8125rem; color: #78350f;">
                        <span style="width: 20px; height: 20px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;">
                            <i class="fa-solid fa-check" style="color: white; font-size: 0.625rem;"></i>
                        </span>
                        Usa un título descriptivo y atractivo que capte la atención
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.625rem; font-size: 0.8125rem; color: #78350f;">
                        <span style="width: 20px; height: 20px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;">
                            <i class="fa-solid fa-check" style="color: white; font-size: 0.625rem;"></i>
                        </span>
                        Agrega imágenes de alta calidad del proyecto
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.625rem; font-size: 0.8125rem; color: #78350f;">
                        <span style="width: 20px; height: 20px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;">
                            <i class="fa-solid fa-check" style="color: white; font-size: 0.625rem;"></i>
                        </span>
                        Detalla el proceso y los resultados obtenidos
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.625rem; font-size: 0.8125rem; color: #78350f;">
                        <span style="width: 20px; height: 20px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;">
                            <i class="fa-solid fa-check" style="color: white; font-size: 0.625rem;"></i>
                        </span>
                        Incluye todas las tecnologías utilizadas
                    </li>
                </ul>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// Title & Slug
const titleInput = document.getElementById('title');
const titleCount = document.getElementById('titleCount');
const slugInput = document.getElementById('slug');

titleInput.addEventListener('input', function() {
    titleCount.textContent = this.value.length;

    // Auto-generate slug
    if (!slugInput.value || slugInput.dataset.auto !== 'false') {
        slugInput.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        slugInput.dataset.auto = 'true';
    }
});

slugInput.addEventListener('input', function() {
    slugInput.dataset.auto = 'false';
});

// Description counter
const descInput = document.getElementById('description');
const descCount = document.getElementById('descCount');

descInput.addEventListener('input', function() {
    descCount.textContent = this.value.length;
});

// Technologies preview
const techInput = document.getElementById('technologies');
const techPreview = document.getElementById('techPreview');

techInput.addEventListener('input', function() {
    const techs = this.value.split(',').map(t => t.trim()).filter(t => t);

    if (techs.length > 0) {
        techPreview.innerHTML = techs.map(tech =>
            `<span class="admin-project-tech">${tech}</span>`
        ).join('');
        techPreview.style.display = 'flex';
    } else {
        techPreview.style.display = 'none';
    }
});

// Thumbnail preview
function previewThumbnail(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('thumbnailPreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--admin-radius);">`;
        };
        reader.readAsDataURL(file);
    }
}

// Gallery preview
let galleryFiles = [];

function previewGallery(event) {
    const files = Array.from(event.target.files);
    const preview = document.getElementById('galleryPreview');

    files.forEach(file => {
        galleryFiles.push(file);

        const reader = new FileReader();
        reader.onload = function(e) {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'admin-gallery-item';
            itemDiv.style.position = 'relative';
            itemDiv.innerHTML = `
                <img src="${e.target.result}" alt="Gallery" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button" class="admin-gallery-remove" onclick="removeGalleryItem(this, '${file.name}')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            // Insert before the "add" button
            const addButton = preview.querySelector('.admin-gallery-item:last-child');
            preview.insertBefore(itemDiv, addButton);
        };
        reader.readAsDataURL(file);
    });
}

function removeGalleryItem(button, fileName) {
    // Remove from array
    galleryFiles = galleryFiles.filter(f => f.name !== fileName);

    // Remove from DOM
    button.parentElement.remove();

    // Update file input
    const dt = new DataTransfer();
    galleryFiles.forEach(file => dt.items.add(file));
    document.getElementById('gallery').files = dt.files;
}

// Initialize counters
titleInput.dispatchEvent(new Event('input'));
descInput.dispatchEvent(new Event('input'));
</script>
@endpush
