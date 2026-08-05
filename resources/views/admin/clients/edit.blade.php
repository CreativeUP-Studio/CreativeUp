@extends('admin.layouts.app')

@section('title', 'Editar Logo de Cliente | CreativeUP Admin')
@section('page-title', 'Editar Logo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    .client-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }
    .client-upload-zone:hover {
        border-color: #ff006e;
        background: rgba(255, 0, 110, 0.02);
    }
    .client-upload-preview {
        max-width: 100%;
        max-height: 180px;
        object-fit: contain;
        margin: 0 auto 0.75rem auto;
        display: block;
        border-radius: 12px;
    }
    .client-upload-icon {
        font-size: 2.5rem;
        color: #ff006e;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')

<form method="POST" action="{{ route('admin.clients.update', $client->id) }}" enctype="multipart/form-data" id="clientForm">
    @csrf
    @method('PUT')

    {{-- Header --}}
    <div class="svc-header">
        <div class="svc-header-left">
            <a href="{{ route('admin.clients.index') }}" class="svc-header-back" title="Volver a los logos">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="svc-header-info">
                <h1>Editar Logo: {{ $client->name }}</h1>
            </div>
        </div>
        <div class="svc-header-actions">
            <a href="{{ route('admin.clients.index') }}" class="admin-btn admin-btn-secondary">
                <i class="fa-solid fa-xmark"></i>
                <span>Cancelar</span>
            </a>
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar Cambios</span>
            </button>
        </div>
    </div>

    <div style="max-width: 700px; margin: 0 auto;">
        <section class="svc-card">
            <header class="svc-card-header">
                <span class="svc-card-icon svc-card-icon--pink"><i class="fa-solid fa-image"></i></span>
                <div>
                    <h2>Logo de la Empresa</h2>
                    <p>Subir una nueva imagen para reemplazar el logo actual</p>
                </div>
            </header>

            <div class="client-upload-zone" onclick="document.getElementById('logo_input').click()">
                @if($client->logo_url)
                    <img id="logo_preview" src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="client-upload-preview">
                    <div id="upload_placeholder" style="display: none;">
                        <i class="fa-solid fa-cloud-arrow-up client-upload-icon"></i>
                        <p style="margin: 0; font-weight: 600; color: #1e293b; font-size: 0.9rem;">Cambiar logo</p>
                    </div>
                @else
                    <img id="logo_preview" src="" alt="Previsualización" class="client-upload-preview" style="display: none;">
                    <div id="upload_placeholder">
                        <i class="fa-solid fa-cloud-arrow-up client-upload-icon"></i>
                        <p style="margin: 0; font-weight: 600; color: #1e293b; font-size: 0.9rem;">Haz clic para subir logo</p>
                    </div>
                @endif
                <input type="file" id="logo_input" name="logo" accept="image/*" style="display: none;" onchange="previewLogo(this)">
            </div>
            @error('logo')<span class="svc-error" style="margin-top: 0.75rem; display: block;">{{ $message }}</span>@enderror

            <div class="svc-field" style="margin-top: 1.5rem;">
                <label for="name">Nombre / Etiqueta de la Empresa</label>
                <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}" placeholder="Nombre de la empresa">
                @error('name')<span class="svc-error">{{ $message }}</span>@enderror
            </div>

            <div class="svc-field" style="margin-top: 1rem;">
                <label for="order">Orden de aparición</label>
                <input type="number" id="order" name="order" value="{{ old('order', $client->order) }}" min="0" placeholder="0">
                <span style="font-size: 0.75rem; color: #94a3b8;">Menor número = primero en la lista pública.</span>
            </div>

            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                <label style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                    <span style="font-size: 0.95rem; font-weight: 600; color: #1e293b;">Mostrar en el sitio web</span>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $client->is_active) ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: #10b981;">
                </label>
            </div>
        </section>
    </div>
</form>

<script>
function previewLogo(input) {
    const preview = document.getElementById('logo_preview');
    const placeholder = document.getElementById('upload_placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
