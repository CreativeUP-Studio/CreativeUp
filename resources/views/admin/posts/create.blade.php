@extends('admin.layouts.app')

@section('title', 'Nuevo Post')
@section('page-title', 'Crear Post')

@section('content')
<div class="admin-form-card">
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="title">Título *</label>
                <input type="text" id="title" name="title" class="admin-form-control"
                       value="{{ old('title') }}" required placeholder="Título del post">
            </div>
            <div class="admin-form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" class="admin-form-control"
                       value="{{ old('slug') }}" placeholder="Se genera automáticamente">
            </div>
        </div>
        <div class="admin-form-group">
            <label for="content">Contenido *</label>
            <textarea id="content" name="content" class="admin-form-control"
                      required placeholder="Escribe el contenido del post...">{{ old('content') }}</textarea>
        </div>
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="featured_image">Imagen destacada</label>
                <input type="file" id="featured_image" name="featured_image" class="admin-form-control" accept="image/*">
            </div>
            <div class="admin-form-group">
                <label for="status">Estado *</label>
                <select id="status" name="status" class="admin-form-control">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                </select>
            </div>
        </div>
        <div class="admin-form-group">
            <label for="published_at">Fecha de publicación</label>
            <input type="date" id="published_at" name="published_at" class="admin-form-control"
                   value="{{ old('published_at') }}">
        </div>
        <div class="admin-form-actions">
            <button type="submit" class="admin-btn admin-btn-primary">Guardar post</button>
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
