@extends('admin.layouts.app')

@section('title', 'Gestionar Hero del Home')
@section('page-title', 'Hero del Home')

@push('styles')
<style>
.hero-admin-container { max-width: 1400px; margin: 0 auto; }
.hero-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 1.5rem; overflow: hidden; border: 1px solid #e5e7eb; transition: all 0.3s ease; }
.hero-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.hero-card-header { background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); padding: 1.25rem 1.5rem; }
.hero-card-header h5 { color: #fff; font-size: 1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.75rem; }
.hero-card-body { padding: 1.75rem; }
.hero-form-group { margin-bottom: 1.5rem; }
.hero-form-label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem; }
.hero-form-control { width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.875rem; transition: all 0.2s ease; background: #fff; }
.hero-form-control:focus { outline: none; border-color: var(--admin-primary); box-shadow: 0 0 0 3px rgba(255, 0, 110,0.1); }
.hero-form-control.is-invalid { border-color: #ef4444; }
.hero-form-text { display: block; margin-top: 0.375rem; font-size: 0.8rem; color: #6b7280; }
.invalid-feedback { display: block; margin-top: 0.375rem; font-size: 0.8rem; color: #ef4444; }
.hero-switch { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 10px; margin-bottom: 0.75rem; }
.hero-switch input[type="checkbox"] { width: 44px; height: 24px; position: relative; appearance: none; background: #d1d5db; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; }
.hero-switch input[type="checkbox"]:checked { background: var(--admin-primary); }
.hero-switch input[type="checkbox"]::before { content: ''; position: absolute; width: 18px; height: 18px; border-radius: 50%; background: white; top: 3px; left: 3px; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
.hero-switch input[type="checkbox"]:checked::before { left: 23px; }
.hero-switch label { margin: 0; font-size: 0.875rem; color: #374151; font-weight: 500; cursor: pointer; }
.hero-grid { display: grid; gap: 1.5rem; }
.hero-grid-2 { grid-template-columns: repeat(2, 1fr); }
.hero-grid-3 { grid-template-columns: repeat(3, 1fr); }
.hero-image-preview { margin-top: 1rem; }
.hero-image-preview img { max-width: 300px; height: auto; border-radius: 12px; border: 2px solid #e5e7eb; }
.hero-btn-delete { margin-top: 0.75rem; padding: 0.5rem 1rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-size: 0.875rem; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.5rem; }
.hero-btn-delete:hover { background: #dc2626; transform: translateY(-1px); }
.hero-btn-primary { padding: 0.875rem 2rem; background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); color: white; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.75rem; box-shadow: 0 4px 12px rgba(255, 0, 110,0.3); }
.hero-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255, 0, 110,0.4); }
.hero-btn-secondary { padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; }
.hero-btn-secondary:hover { background: #e5e7eb; border-color: #d1d5db; }
.hero-btn-preview { padding: 0.625rem 1.25rem; background: white; color: var(--admin-primary); border: 2px solid var(--admin-primary); border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; }
.hero-btn-preview:hover { background: var(--admin-primary); color: white; }
.hero-alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; animation: slideDown 0.3s ease; }
.hero-alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
.hero-alert-success i { color: #10b981; font-size: 1.25rem; }
@keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
.hero-header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 1.5rem; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.hero-header-title { display: flex; align-items: center; gap: 1rem; }
.hero-header-title h4 { margin: 0; font-size: 1.5rem; font-weight: 700; color: #111827; }
.hero-header-icon { width: 48px; height: 48px; background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; }
.hero-footer-actions { display: flex; justify-content: space-between; align-items: center; padding: 2rem 0; margin-top: 2rem; border-top: 2px solid #f3f4f6; }
@media (max-width: 1024px) { .hero-grid-2, .hero-grid-3 { grid-template-columns: 1fr; } }
@media (max-width: 768px) { .hero-card-body { padding: 1.25rem; } .hero-header-actions { flex-direction: column; gap: 1rem; align-items: flex-start; } .hero-footer-actions { flex-direction: column-reverse; gap: 1rem; } .hero-btn-primary, .hero-btn-secondary { width: 100%; justify-content: center; } }
</style>
@endpush

@section('content')
<div class="hero-admin-container">
    {{-- Header Compact --}}
    <div class="admin-compact-header" style="margin-bottom: 1.5rem;">
        <div class="admin-compact-header-left">
            <a href="{{ route('admin.dashboard') }}" class="admin-compact-header-back" title="Volver al Dashboard">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="admin-compact-header-info">
                <h1>
                    <i class="fa-solid fa-star"></i>
                    Configuración del Hero
                </h1>
            </div>
        </div>
        <div class="admin-compact-header-actions">
            <a href="{{ route('home') }}" target="_blank" class="admin-btn admin-btn-secondary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
                <i class="fa-solid fa-eye"></i>
                <span>Vista Previa</span>
            </a>
            <button type="submit" form="heroForm" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="hero-alert hero-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form id="heroForm" action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- BADGE --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-tag"></i>Badge Superior</h5></div>
            <div class="hero-card-body">
                <div class="hero-grid hero-grid-2">
                    <div class="hero-form-group">
                        <label class="hero-form-label">Texto del Badge</label>
                        <input type="text" name="badge_text" class="hero-form-control @error('badge_text') is-invalid @enderror" value="{{ old('badge_text', $hero->badge_text) }}" required>
                        @error('badge_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="hero-form-label">Elementos Visuales</label>
                        <div class="hero-switch">
                            <input type="checkbox" name="badge_show_dot" id="badge_show_dot" {{ old('badge_show_dot', $hero->badge_show_dot) ? 'checked' : '' }}>
                            <label for="badge_show_dot">Mostrar punto pulsante</label>
                        </div>
                        <div class="hero-switch">
                            <input type="checkbox" name="badge_show_sparkle" id="badge_show_sparkle" {{ old('badge_show_sparkle', $hero->badge_show_sparkle) ? 'checked' : '' }}>
                            <label for="badge_show_sparkle">Mostrar sparkle ✨</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TÍTULO --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-heading"></i>Título Principal</h5></div>
            <div class="hero-card-body">
                <div class="hero-grid hero-grid-3">
                    <div class="hero-form-group">
                        <label class="hero-form-label">Primera Línea</label>
                        <input type="text" name="title_line_1" class="hero-form-control @error('title_line_1') is-invalid @enderror" value="{{ old('title_line_1', $hero->title_line_1) }}" required>
                        <small class="hero-form-text">Ej: "Diseñamos el"</small>
                        @error('title_line_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="hero-form-group">
                        <label class="hero-form-label">Palabra con Gradiente</label>
                        <input type="text" name="title_gradient_word" class="hero-form-control @error('title_gradient_word') is-invalid @enderror" value="{{ old('title_gradient_word', $hero->title_gradient_word) }}" required>
                        <small class="hero-form-text">Ej: "Futuro" (con efecto gradiente)</small>
                        @error('title_gradient_word')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="hero-form-group">
                        <label class="hero-form-label">Palabra Outline</label>
                        <input type="text" name="title_outline_word" class="hero-form-control @error('title_outline_word') is-invalid @enderror" value="{{ old('title_outline_word', $hero->title_outline_word) }}" required>
                        <small class="hero-form-text">Ej: "Digital" (con efecto outline)</small>
                        @error('title_outline_word')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="hero-form-group">
                    <label class="hero-form-label">Palabras Rotativas (Efecto Typing)</label>
                    <input type="text" name="rotating_words" class="hero-form-control @error('rotating_words') is-invalid @enderror" value="{{ old('rotating_words', is_array($hero->rotating_words) ? implode(', ', $hero->rotating_words) : '') }}" placeholder="Futuro, Éxito, Diseño, Negocio">
                    <small class="hero-form-text">Separar con comas. Estas palabras rotarán automáticamente en el título.</small>
                    @error('rotating_words')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- SUBTÍTULO --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-align-left"></i>Subtítulo</h5></div>
            <div class="hero-card-body">
                <div class="hero-form-group">
                    <label class="hero-form-label">Descripción</label>
                    <textarea name="subtitle" rows="3" class="hero-form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $hero->subtitle) }}</textarea>
                    <small class="hero-form-text">Descripción breve que aparece debajo del título principal.</small>
                    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- BOTONES CTA --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-mouse-pointer"></i>Botones de Acción (CTA)</h5></div>
            <div class="hero-card-body">
                <div class="hero-grid hero-grid-2">
                    <div>
                        <h6 style="color: var(--admin-primary); margin-bottom: 1rem; font-weight: 600;">Botón Principal</h6>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Texto del Botón</label>
                            <input type="text" name="primary_button_text" class="hero-form-control @error('primary_button_text') is-invalid @enderror" value="{{ old('primary_button_text', $hero->primary_button_text) }}" required>
                            @error('primary_button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">URL del Botón</label>
                            <input type="text" name="primary_button_url" class="hero-form-control @error('primary_button_url') is-invalid @enderror" value="{{ old('primary_button_url', $hero->primary_button_url) }}" required>
                            <small class="hero-form-text">Ej: /contacto o https://...</small>
                            @error('primary_button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-switch">
                            <input type="checkbox" name="primary_button_active" id="primary_button_active" {{ old('primary_button_active', $hero->primary_button_active) ? 'checked' : '' }}>
                            <label for="primary_button_active">Mostrar botón principal</label>
                        </div>
                    </div>
                    <div>
                        <h6 style="color: #6b7280; margin-bottom: 1rem; font-weight: 600;">Botón Secundario</h6>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Texto del Botón</label>
                            <input type="text" name="secondary_button_text" class="hero-form-control @error('secondary_button_text') is-invalid @enderror" value="{{ old('secondary_button_text', $hero->secondary_button_text) }}">
                            @error('secondary_button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">URL del Botón</label>
                            <input type="text" name="secondary_button_url" class="hero-form-control @error('secondary_button_url') is-invalid @enderror" value="{{ old('secondary_button_url', $hero->secondary_button_url) }}">
                            <small class="hero-form-text">Ej: #portfolio o https://...</small>
                            @error('secondary_button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-switch">
                            <input type="checkbox" name="secondary_button_active" id="secondary_button_active" {{ old('secondary_button_active', $hero->secondary_button_active) ? 'checked' : '' }}>
                            <label for="secondary_button_active">Mostrar botón secundario</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- IMAGEN/MOCKUP --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-image"></i>Imagen del Mockup</h5></div>
            <div class="hero-card-body">
                <div class="hero-grid hero-grid-2">
                    <div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Subir Imagen Personalizada</label>
                            <input type="file" name="mockup_image" class="hero-form-control @error('mockup_image') is-invalid @enderror" accept="image/*">
                            <small class="hero-form-text">Formatos: JPG, PNG, WEBP. Máximo 5MB.</small>
                            @error('mockup_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @if($hero->mockup_image)
                            <div class="hero-image-preview">
                                <img src="{{ Storage::url($hero->mockup_image) }}" alt="Mockup actual">
                                <button type="button" class="hero-btn-delete" onclick="deleteHeroImage()">
                                    <i class="fas fa-trash"></i> Eliminar Imagen
                                </button>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">O Seleccionar Proyecto Destacado</label>
                            <select name="featured_project_id" class="hero-form-control @error('featured_project_id') is-invalid @enderror">
                                <option value="">-- Ninguno --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('featured_project_id', $hero->featured_project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="hero-form-text">Si seleccionas un proyecto, se usará su imagen destacada.</small>
                            @error('featured_project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SOCIAL PROOF --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-users"></i>Social Proof (Prueba Social)</h5></div>
            <div class="hero-card-body">
                <div class="hero-switch" style="margin-bottom: 1.5rem;">
                    <input type="checkbox" name="show_social_proof" id="show_social_proof" {{ old('show_social_proof', $hero->show_social_proof) ? 'checked' : '' }}>
                    <label for="show_social_proof">Mostrar Social Proof</label>
                </div>
                <div class="hero-grid hero-grid-2">
                    <div class="hero-form-group">
                        <label class="hero-form-label">Texto</label>
                        <input type="text" name="social_proof_text" class="hero-form-control @error('social_proof_text') is-invalid @enderror" value="{{ old('social_proof_text', $hero->social_proof_text) }}">
                        @error('social_proof_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="hero-form-group">
                        <label class="hero-form-label">Cantidad (+)</label>
                        <input type="number" name="social_proof_count" class="hero-form-control @error('social_proof_count') is-invalid @enderror" value="{{ old('social_proof_count', $hero->social_proof_count) }}" min="0">
                        @error('social_proof_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- TARJETAS FLOTANTES --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-layer-group"></i>Tarjetas Flotantes</h5></div>
            <div class="hero-card-body">
                <div class="hero-grid hero-grid-2">
                    <div>
                        <h6 style="color: var(--admin-primary); margin-bottom: 1rem; font-weight: 600;">Tarjeta Flotante 1</h6>
                        <div class="hero-switch">
                            <input type="checkbox" name="show_float_card_1" id="show_float_card_1" {{ old('show_float_card_1', $hero->show_float_card_1) ? 'checked' : '' }}>
                            <label for="show_float_card_1">Mostrar tarjeta 1</label>
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Icono (Font Awesome)</label>
                            <input type="text" name="float_card_1_icon" class="hero-form-control @error('float_card_1_icon') is-invalid @enderror" value="{{ old('float_card_1_icon', $hero->float_card_1_icon) }}" placeholder="fa-rocket">
                            <small class="hero-form-text">Ej: fa-rocket, fa-chart-line</small>
                            @error('float_card_1_icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Título</label>
                            <input type="text" name="float_card_1_title" class="hero-form-control @error('float_card_1_title') is-invalid @enderror" value="{{ old('float_card_1_title', $hero->float_card_1_title) }}">
                            @error('float_card_1_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Valor</label>
                            <input type="text" name="float_card_1_value" class="hero-form-control @error('float_card_1_value') is-invalid @enderror" value="{{ old('float_card_1_value', $hero->float_card_1_value) }}">
                            @error('float_card_1_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div>
                        <h6 style="color: #10b981; margin-bottom: 1rem; font-weight: 600;">Tarjeta Flotante 2</h6>
                        <div class="hero-switch">
                            <input type="checkbox" name="show_float_card_2" id="show_float_card_2" {{ old('show_float_card_2', $hero->show_float_card_2) ? 'checked' : '' }}>
                            <label for="show_float_card_2">Mostrar tarjeta 2</label>
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Icono (Font Awesome)</label>
                            <input type="text" name="float_card_2_icon" class="hero-form-control @error('float_card_2_icon') is-invalid @enderror" value="{{ old('float_card_2_icon', $hero->float_card_2_icon) }}" placeholder="fa-chart-line">
                            <small class="hero-form-text">Ej: fa-rocket, fa-chart-line</small>
                            @error('float_card_2_icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Título</label>
                            <input type="text" name="float_card_2_title" class="hero-form-control @error('float_card_2_title') is-invalid @enderror" value="{{ old('float_card_2_title', $hero->float_card_2_title) }}">
                            @error('float_card_2_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="hero-form-group">
                            <label class="hero-form-label">Valor</label>
                            <input type="text" name="float_card_2_value" class="hero-form-control @error('float_card_2_value') is-invalid @enderror" value="{{ old('float_card_2_value', $hero->float_card_2_value) }}">
                            @error('float_card_2_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SCROLL INDICATOR --}}
        <div class="hero-card">
            <div class="hero-card-header"><h5><i class="fas fa-mouse"></i>Indicador de Scroll</h5></div>
            <div class="hero-card-body">
                <div class="hero-switch">
                    <input type="checkbox" name="show_scroll_indicator" id="show_scroll_indicator" {{ old('show_scroll_indicator', $hero->show_scroll_indicator) ? 'checked' : '' }}>
                    <label for="show_scroll_indicator">Mostrar indicador de scroll animado</label>
                </div>
            </div>
        </div>

        {{-- FOOTER ACTIONS --}}
        <div class="hero-footer-actions">
            <a href="{{ route('admin.dashboard') }}" class="hero-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
            <button type="submit" class="hero-btn-primary">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
function deleteHeroImage() {
    if (confirm('¿Estás seguro de que deseas eliminar la imagen del mockup?')) {
        fetch('{{ route('admin.hero.delete-image') }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar la imagen');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la imagen');
        });
    }
}
</script>
@endsection
