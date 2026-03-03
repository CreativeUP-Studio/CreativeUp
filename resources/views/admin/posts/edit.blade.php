@extends('admin.layouts.app')

@section('title', 'Editar Post')
@section('page-title', 'Editar Post')

@section('content')
<div class="admin-form-card">
    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="title">Título *</label>
                <input type="text" id="title" name="title" class="admin-form-control"
                       value="{{ old('title', $post->title) }}" required>
            </div>
            <div class="admin-form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" class="admin-form-control"
                       value="{{ old('slug', $post->slug) }}">
            </div>
        </div>
        <div class="admin-form-group">
            <label for="content">Contenido *</label>
            <textarea id="content" name="content" class="admin-form-control"
                      required>{{ old('content', $post->content) }}</textarea>
        </div>
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="featured_image">Imagen destacada</label>
                @if($post->featured_image)
                    <div class="admin-mb-sm">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="admin-preview-img">
                    </div>
                @endif
                <input type="file" id="featured_image" name="featured_image" class="admin-form-control" accept="image/*">
                <small class="admin-form-hint">Dejar vacío para mantener la imagen actual.</small>
            </div>
            <div class="admin-form-group">
                <label for="status">Estado *</label>
                <select id="status" name="status" class="admin-form-control">
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                </select>
            </div>
        </div>
        <div class="admin-form-group">
            <label for="published_at">Fecha de publicación</label>
            <input type="date" id="published_at" name="published_at" class="admin-form-control"
                   value="{{ old('published_at', $post->published_at?->format('Y-m-d')) }}">
        </div>
        <div class="admin-form-actions">
            <button type="submit" class="admin-btn admin-btn-primary">Actualizar post</button>
            <a href="{{ route('admin.posts.index') }}" class="admin-btn admin-btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
