@extends('admin.layouts.app')

@section('title', 'Configuración General del Sitio')
@section('page-title', 'Configuración del Sitio')

@push('styles')
<style>
.settings-admin-container { max-width: 1400px; margin: 0 auto; }
.settings-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 1.5rem; overflow: hidden; border: 1px solid #e5e7eb; transition: all 0.3s ease; }
.settings-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.settings-card-header { background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); padding: 1.25rem 1.5rem; }
.settings-card-header h5 { color: #fff; font-size: 1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.75rem; }
.settings-card-body { padding: 1.75rem; }
.settings-form-group { margin-bottom: 1.5rem; }
.settings-form-label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem; transition: color 0.3s ease; }
.settings-form-control { width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.875rem; transition: all 0.2s ease; background: #fff; color: #374151; }
.settings-form-control:focus { outline: none; border-color: var(--admin-primary); box-shadow: 0 0 0 3px rgba(255, 0, 110, 0.1); background: #fff; color: #374151; }
.settings-form-control.is-invalid { border-color: #ef4444; }
.settings-form-text { display: block; margin-top: 0.375rem; font-size: 0.8rem; color: #6b7280; }
.invalid-feedback { display: block; margin-top: 0.375rem; font-size: 0.8rem; color: #ef4444; }
.settings-switch { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 10px; margin-bottom: 0.75rem; transition: background 0.3s ease; }
.settings-switch input[type="checkbox"] { width: 44px; height: 24px; position: relative; appearance: none; background: #d1d5db; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; }
.settings-switch input[type="checkbox"]:checked { background: var(--admin-primary); }
.settings-switch input[type="checkbox"]::before { content: ''; position: absolute; width: 18px; height: 18px; border-radius: 50%; background: white; top: 3px; left: 3px; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
.settings-switch input[type="checkbox"]:checked::before { left: 23px; }
.settings-switch label { margin: 0; font-size: 0.875rem; color: #374151; font-weight: 500; cursor: pointer; transition: color 0.3s ease; }

/* Dark Mode Overrides */
body[data-theme="dark"] .settings-card {
    background: var(--admin-surface, #1a1a2e);
    border-color: var(--admin-border, #2d2d4a);
}
body[data-theme="dark"] .settings-form-label {
    color: var(--admin-text-secondary, #a0a0b8);
}
body[data-theme="dark"] .settings-form-control {
    background: var(--admin-surface-hover, #242442);
    border-color: var(--admin-border, #2d2d4a);
    color: var(--admin-text, #f1f1f7);
}
body[data-theme="dark"] .settings-form-control:focus {
    background: var(--admin-surface-hover, #242442);
    color: var(--admin-text, #f1f1f7);
    border-color: var(--admin-primary);
}
body[data-theme="dark"] .settings-switch {
    background: var(--admin-surface-hover, #242442);
}
body[data-theme="dark"] .settings-switch label {
    color: var(--admin-text-secondary, #a0a0b8);
}
.settings-grid { display: grid; gap: 1.5rem; }
.settings-grid-2 { grid-template-columns: repeat(2, 1fr); }
.settings-grid-3 { grid-template-columns: repeat(3, 1fr); }
.settings-btn-primary { padding: 0.875rem 2rem; background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); color: white; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.75rem; box-shadow: 0 4px 12px rgba(255, 0, 110, 0.3); }
.settings-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255, 0, 110, 0.4); }
.settings-btn-secondary { padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; }
.settings-btn-secondary:hover { background: #e5e7eb; border-color: #d1d5db; }
.settings-alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; animation: slideDown 0.3s ease; }
.settings-alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
.settings-alert-success i { color: #10b981; font-size: 1.25rem; }
@keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
@media (max-width: 1024px) { .settings-grid-2, .settings-grid-3 { grid-template-columns: 1fr; } }
@media (max-width: 768px) { .settings-card-body { padding: 1.25rem; } }
</style>
@endpush

@section('content')
<div class="settings-admin-container">
    {{-- Header Compact --}}
    <div class="admin-compact-header" style="margin-bottom: 1.5rem;">
        <div class="admin-compact-header-left">
            <a href="{{ route('admin.dashboard') }}" class="admin-compact-header-back" title="Volver al Dashboard">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="admin-compact-header-info">
                <h1>
                    <i class="fa-solid fa-gears"></i>
                    Configuración General del Sitio
                </h1>
            </div>
        </div>
        <div class="admin-compact-header-actions">
            <a href="{{ route('home') }}" target="_blank" class="admin-btn admin-btn-secondary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
                <i class="fa-solid fa-eye"></i>
                <span>Ver Sitio</span>
            </a>
            <button type="submit" form="settingsForm" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="settings-alert settings-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- INFORMACIÓN DE CONTACTO --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <h5><i class="fas fa-address-book"></i> Información de Contacto</h5>
            </div>
            <div class="settings-card-body">
                <div class="settings-grid settings-grid-2">
                    <div class="settings-form-group">
                        <label class="settings-form-label">Teléfono de Contacto</label>
                        <input type="text" name="phone" class="settings-form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings->phone) }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label">Correo Electrónico de Contacto</label>
                        <input type="email" name="email" class="settings-form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="settings-grid settings-grid-3">
                    <div class="settings-form-group">
                        <label class="settings-form-label">Dirección Física</label>
                        <input type="text" name="address" class="settings-form-control @error('address') is-invalid @enderror" value="{{ old('address', $settings->address) }}" required>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label">Enlace de Google Maps (Ubicación)</label>
                        <input type="url" name="maps_url" class="settings-form-control @error('maps_url') is-invalid @enderror" value="{{ old('maps_url', $settings->maps_url) }}" required>
                        <small class="settings-form-text">Ej: https://maps.google.com/...</small>
                        @error('maps_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label">Zona Horaria del Reloj Corporativo</label>
                        <select name="timezone" class="settings-form-control @error('timezone') is-invalid @enderror" required>
                            @foreach(timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) === $tz ? 'selected' : '' }}>
                                    {{ $tz }}
                                </option>
                            @endforeach
                        </select>
                        <small class="settings-form-text">Usado en el reloj del pie de página.</small>
                        @error('timezone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="settings-form-group" style="margin-bottom: 0;">
                    <label class="settings-form-label">Enlace a WhatsApp Directo</label>
                    <input type="url" name="whatsapp_url" class="settings-form-control @error('whatsapp_url') is-invalid @enderror" value="{{ old('whatsapp_url', $settings->whatsapp_url) }}" required>
                    <small class="settings-form-text">Ej: https://wa.me/34123456789</small>
                    @error('whatsapp_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- REDES SOCIALES --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <h5><i class="fas fa-share-nodes"></i> Redes Sociales</h5>
            </div>
            <div class="settings-card-body">
                <div class="settings-grid settings-grid-2">
                    <div class="settings-form-group">
                        <label class="settings-form-label"><i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook URL</label>
                        <input type="text" name="facebook_url" class="settings-form-control @error('facebook_url') is-invalid @enderror" value="{{ old('facebook_url', $settings->facebook_url) }}">
                        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label"><i class="fab fa-instagram" style="color: #e1306c;"></i> Instagram URL</label>
                        <input type="text" name="instagram_url" class="settings-form-control @error('instagram_url') is-invalid @enderror" value="{{ old('instagram_url', $settings->instagram_url) }}">
                        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label"><i class="fab fa-linkedin" style="color: #0a66c2;"></i> LinkedIn URL</label>
                        <input type="text" name="linkedin_url" class="settings-form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url', $settings->linkedin_url) }}">
                        @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label"><i class="fab fa-x-twitter" style="color: #000000;"></i> Twitter / X URL</label>
                        <input type="text" name="twitter_url" class="settings-form-control @error('twitter_url') is-invalid @enderror" value="{{ old('twitter_url', $settings->twitter_url) }}">
                        @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="settings-form-group" style="margin-bottom: 0;">
                    <label class="settings-form-label"><i class="fab fa-github" style="color: #333;"></i> GitHub URL</label>
                    <input type="text" name="github_url" class="settings-form-control @error('github_url') is-invalid @enderror" value="{{ old('github_url', $settings->github_url) }}">
                    @error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- BRANDING Y TEXTOS GENERALES --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <h5><i class="fas fa-brush"></i> Branding & Textos Generales</h5>
            </div>
            <div class="settings-card-body">
                <div class="settings-grid settings-grid-3">
                    <div class="settings-form-group">
                        <label class="settings-form-label">Texto del Logo (Normal)</label>
                        <input type="text" name="logo_text" class="settings-form-control @error('logo_text') is-invalid @enderror" value="{{ old('logo_text', $settings->logo_text) }}" required>
                        <small class="settings-form-text">Ej: creative</small>
                        @error('logo_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label">Texto del Logo (Gradiente)</label>
                        <input type="text" name="logo_gradient_text" class="settings-form-control @error('logo_gradient_text') is-invalid @enderror" value="{{ old('logo_gradient_text', $settings->logo_gradient_text) }}" required>
                        <small class="settings-form-text">Ej: up</small>
                        @error('logo_gradient_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="settings-form-group">
                        <label class="settings-form-label">Estado de Disponibilidad (Footer)</label>
                        <input type="text" name="status_text" class="settings-form-control @error('status_text') is-invalid @enderror" value="{{ old('status_text', $settings->status_text) }}" required>
                        <small class="settings-form-text">Ej: Disponible, Cerrado, En reunión</small>
                        @error('status_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="settings-form-group" style="margin-bottom: 0;">
                    <label class="settings-form-label">Eslogan del Pie de Página (Footer Tagline)</label>
                    <textarea name="footer_tagline" rows="3" class="settings-form-control @error('footer_tagline') is-invalid @enderror" required>{{ old('footer_tagline', $settings->footer_tagline) }}</textarea>
                    @error('footer_tagline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- SEO GENERAL --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <h5><i class="fas fa-search"></i> SEO General del Sitio</h5>
            </div>
            <div class="settings-card-body">
                <div class="settings-form-group">
                    <label class="settings-form-label">Meta Título por Defecto (Meta Title)</label>
                    <input type="text" name="meta_title" class="settings-form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $settings->meta_title) }}" required>
                    @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="settings-form-group" style="margin-bottom: 0;">
                    <label class="settings-form-label">Meta Descripción por Defecto (Meta Description)</label>
                    <textarea name="meta_description" rows="3" class="settings-form-control @error('meta_description') is-invalid @enderror" required>{{ old('meta_description', $settings->meta_description) }}</textarea>
                    @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- IMÁGENES DEL MENÚ DE NAVEGACIÓN FULLSCREEN --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <h5><i class="fas fa-images"></i> Imágenes de Previsualización del Menú</h5>
            </div>
            <div class="settings-card-body">
                <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 1.5rem;">
                    Sube las imágenes que aparecerán en la tarjeta de previsualización interactiva al desplegar el menú de navegación pantalla completa (Fullscreen Navigation). Tamaño máximo 50MB por imagen.
                </p>

                <div class="settings-grid settings-grid-3">
                    {{-- 01. INICIO --}}
                    <div class="settings-form-group">
                        <label class="settings-form-label">
                            <i class="fas fa-home" style="color: var(--admin-primary); margin-right: 4px;"></i>
                            01. Imagen Enlace "Inicio"
                        </label>
                        <div style="margin-bottom: 0.75rem; border-radius: 10px; overflow: hidden; height: 110px; background: #f3f4f6; position: relative; border: 1px dashed #cbd5e1;">
                            <img id="prev_menu_img_home" src="{{ $settings->menu_img_home_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <input type="file" name="menu_img_home" class="settings-form-control @error('menu_img_home') is-invalid @enderror" accept="image/*" onchange="previewMenuImg(this, 'prev_menu_img_home')">
                        <small class="settings-form-text">Recomendado: 800x600px. (Max 50MB)</small>
                        @if($settings->menu_img_home)
                            <div style="margin-top: 0.5rem;">
                                <label style="font-size: 0.8rem; color: #ef4444; cursor: pointer;">
                                    <input type="checkbox" name="remove_menu_img_home" value="1"> Restablecer a imagen por defecto
                                </label>
                            </div>
                        @endif
                        @error('menu_img_home')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- 02. SERVICIOS --}}
                    <div class="settings-form-group">
                        <label class="settings-form-label">
                            <i class="fas fa-layer-group" style="color: var(--admin-primary); margin-right: 4px;"></i>
                            02. Imagen Enlace "Servicios"
                        </label>
                        <div style="margin-bottom: 0.75rem; border-radius: 10px; overflow: hidden; height: 110px; background: #f3f4f6; position: relative; border: 1px dashed #cbd5e1;">
                            <img id="prev_menu_img_services" src="{{ $settings->menu_img_services_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <input type="file" name="menu_img_services" class="settings-form-control @error('menu_img_services') is-invalid @enderror" accept="image/*" onchange="previewMenuImg(this, 'prev_menu_img_services')">
                        <small class="settings-form-text">Recomendado: 800x600px. (Max 50MB)</small>
                        @if($settings->menu_img_services)
                            <div style="margin-top: 0.5rem;">
                                <label style="font-size: 0.8rem; color: #ef4444; cursor: pointer;">
                                    <input type="checkbox" name="remove_menu_img_services" value="1"> Restablecer a imagen por defecto
                                </label>
                            </div>
                        @endif
                        @error('menu_img_services')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- 03. PORTAFOLIO --}}
                    <div class="settings-form-group">
                        <label class="settings-form-label">
                            <i class="fas fa-briefcase" style="color: var(--admin-primary); margin-right: 4px;"></i>
                            03. Imagen Enlace "Portafolio"
                        </label>
                        <div style="margin-bottom: 0.75rem; border-radius: 10px; overflow: hidden; height: 110px; background: #f3f4f6; position: relative; border: 1px dashed #cbd5e1;">
                            <img id="prev_menu_img_projects" src="{{ $settings->menu_img_projects_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <input type="file" name="menu_img_projects" class="settings-form-control @error('menu_img_projects') is-invalid @enderror" accept="image/*" onchange="previewMenuImg(this, 'prev_menu_img_projects')">
                        <small class="settings-form-text">Recomendado: 800x600px. (Max 50MB)</small>
                        @if($settings->menu_img_projects)
                            <div style="margin-top: 0.5rem;">
                                <label style="font-size: 0.8rem; color: #ef4444; cursor: pointer;">
                                    <input type="checkbox" name="remove_menu_img_projects" value="1"> Restablecer a imagen por defecto
                                </label>
                            </div>
                        @endif
                        @error('menu_img_projects')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- 04. BLOG --}}
                    <div class="settings-form-group">
                        <label class="settings-form-label">
                            <i class="fas fa-newspaper" style="color: var(--admin-primary); margin-right: 4px;"></i>
                            04. Imagen Enlace "Blog"
                        </label>
                        <div style="margin-bottom: 0.75rem; border-radius: 10px; overflow: hidden; height: 110px; background: #f3f4f6; position: relative; border: 1px dashed #cbd5e1;">
                            <img id="prev_menu_img_blog" src="{{ $settings->menu_img_blog_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <input type="file" name="menu_img_blog" class="settings-form-control @error('menu_img_blog') is-invalid @enderror" accept="image/*" onchange="previewMenuImg(this, 'prev_menu_img_blog')">
                        <small class="settings-form-text">Recomendado: 800x600px. (Max 50MB)</small>
                        @if($settings->menu_img_blog)
                            <div style="margin-top: 0.5rem;">
                                <label style="font-size: 0.8rem; color: #ef4444; cursor: pointer;">
                                    <input type="checkbox" name="remove_menu_img_blog" value="1"> Restablecer a imagen por defecto
                                </label>
                            </div>
                        @endif
                        @error('menu_img_blog')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- 05. CONTACTO --}}
                    <div class="settings-form-group">
                        <label class="settings-form-label">
                            <i class="fas fa-paper-plane" style="color: var(--admin-primary); margin-right: 4px;"></i>
                            05. Imagen Enlace "Contacto"
                        </label>
                        <div style="margin-bottom: 0.75rem; border-radius: 10px; overflow: hidden; height: 110px; background: #f3f4f6; position: relative; border: 1px dashed #cbd5e1;">
                            <img id="prev_menu_img_contact" src="{{ $settings->menu_img_contact_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <input type="file" name="menu_img_contact" class="settings-form-control @error('menu_img_contact') is-invalid @enderror" accept="image/*" onchange="previewMenuImg(this, 'prev_menu_img_contact')">
                        <small class="settings-form-text">Recomendado: 800x600px. (Max 50MB)</small>
                        @if($settings->menu_img_contact)
                            <div style="margin-top: 0.5rem;">
                                <label style="font-size: 0.8rem; color: #ef4444; cursor: pointer;">
                                    <input type="checkbox" name="remove_menu_img_contact" value="1"> Restablecer a imagen por defecto
                                </label>
                            </div>
                        @endif
                        @error('menu_img_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- OPCIONES Y FUNCIONALIDADES --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <h5><i class="fas fa-toggle-on"></i> Opciones & Funcionalidades</h5>
            </div>
            <div class="settings-card-body">
                <div class="settings-grid settings-grid-2">
                    <div class="settings-switch">
                        <input type="checkbox" name="show_chat_widget" id="show_chat_widget" {{ old('show_chat_widget', $settings->show_chat_widget) ? 'checked' : '' }}>
                        <label for="show_chat_widget">Habilitar Chat Flotante interactivo</label>
                    </div>
                    <div class="settings-switch">
                        <input type="checkbox" name="show_newsletter" id="show_newsletter" {{ old('show_newsletter', $settings->show_newsletter) ? 'checked' : '' }}>
                        <label for="show_newsletter">Mostrar sección de Boletín de Noticias (Newsletter)</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="settings-footer-actions" style="display: flex; justify-content: space-between; align-items: center; padding: 2rem 0; margin-top: 2rem; border-top: 2px solid #f3f4f6;">
            <a href="{{ route('admin.dashboard') }}" class="settings-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
            <button type="submit" class="settings-btn-primary">
                <i class="fas fa-save"></i> Guardar Configuración
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewMenuImg(input, targetId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(targetId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
