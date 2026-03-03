@extends('admin.layouts.app')

@section('title', 'Nuevo Servicio')
@section('page-title', 'Crear Servicio')

@section('content')
<div class="admin-form-card">
    <form method="POST" action="{{ route('admin.services.store') }}">
        @csrf
        <div class="admin-form-group">
            <label for="title">Título *</label>
            <input type="text" id="title" name="title" class="admin-form-control"
                   value="{{ old('title') }}" required placeholder="Ej: Diseño Web">
        </div>
        <div class="admin-form-group">
            <label for="slug">Slug (se genera automáticamente si se deja vacío)</label>
            <input type="text" id="slug" name="slug" class="admin-form-control"
                   value="{{ old('slug') }}" placeholder="diseno-web">
        </div>
        <div class="admin-form-group">
            <label for="description">Descripción *</label>
            <textarea id="description" name="description" class="admin-form-control"
                      required placeholder="Describe el servicio...">{{ old('description') }}</textarea>
        </div>
        <div class="admin-form-group">
            <label for="icon">Icono (nombre de clase o emoji)</label>
            <input type="text" id="icon" name="icon" class="admin-form-control"
                   value="{{ old('icon') }}" placeholder="Ej: 🎨 o fa-paint-brush">
        </div>
        <div class="admin-form-group">
            <label class="admin-checkbox-label">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                Servicio activo
            </label>
        </div>
        <div class="admin-form-actions">
            <button type="submit" class="admin-btn admin-btn-primary">Guardar servicio</button>
            <a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
