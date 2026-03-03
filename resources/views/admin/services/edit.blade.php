@extends('admin.layouts.app')

@section('title', 'Editar Servicio')
@section('page-title', 'Editar Servicio')

@section('content')
<div class="admin-form-card">
    <form method="POST" action="{{ route('admin.services.update', $service) }}">
        @csrf @method('PUT')
        <div class="admin-form-group">
            <label for="title">Título *</label>
            <input type="text" id="title" name="title" class="admin-form-control"
                   value="{{ old('title', $service->title) }}" required>
        </div>
        <div class="admin-form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" class="admin-form-control"
                   value="{{ old('slug', $service->slug) }}">
        </div>
        <div class="admin-form-group">
            <label for="description">Descripción *</label>
            <textarea id="description" name="description" class="admin-form-control"
                      required>{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="admin-form-group">
            <label for="icon">Icono</label>
            <input type="text" id="icon" name="icon" class="admin-form-control"
                   value="{{ old('icon', $service->icon) }}">
        </div>
        <div class="admin-form-group">
            <label class="admin-checkbox-label">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                Servicio activo
            </label>
        </div>
        <div class="admin-form-actions">
            <button type="submit" class="admin-btn admin-btn-primary">Actualizar servicio</button>
            <a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
