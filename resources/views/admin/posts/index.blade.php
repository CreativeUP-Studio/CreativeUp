@extends('admin.layouts.app')

@section('title', 'Posts')
@section('page-title', 'Blog / Posts')

@section('content')
<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h2>Todos los posts ({{ $posts->total() }})</h2>
        <a href="{{ route('admin.posts.create') }}" class="admin-btn admin-btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo post
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Estado</th>
                <th>Publicado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="admin-thumb">
                    @else
                        <div class="admin-thumb-placeholder">
                            <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ Str::limit($post->title, 50) }}</strong><br>
                    <span class="text-muted">{{ $post->slug }}</span>
                </td>
                <td>{{ $post->user->name ?? '—' }}</td>
                <td>
                    @if($post->status === 'published')
                        <span class="admin-badge admin-badge-green">Publicado</span>
                    @else
                        <span class="admin-badge admin-badge-yellow">Borrador</span>
                    @endif
                </td>
                <td>{{ $post->published_at?->format('d/m/Y') ?? '—' }}</td>
                <td>
                    <div class="admin-actions-group">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Editar</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('¿Eliminar este post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="empty-message">No hay posts registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($posts->hasPages())
        <div class="admin-pagination">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
