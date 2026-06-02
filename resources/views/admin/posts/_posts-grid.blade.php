{{-- Admin Posts Grid Partial - For AJAX Loading --}}
@forelse($posts as $post)
<div class="svc-card-item" 
     style="--card-color: var(--admin-primary)"
     data-id="{{ $post->id }}"
     data-status="{{ $post->status }}"
     data-title="{{ e($post->title) }}"
     data-slug="{{ e($post->slug) }}"
     data-excerpt="{{ e(Str::limit(strip_tags($post->content), 150)) }}"
     data-content="{{ e(strip_tags($post->content)) }}"
     data-category="{{ e($post->category ?? '') }}"
     data-date="{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}"
     data-published-at-raw="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '' }}"
     data-meta-description="{{ e($post->meta_description ?? '') }}"
     data-author="{{ $post->user->name ?? 'Admin' }}"
     data-image="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}">
     
     {{-- Card Top Banner --}}
     <div class="svc-card-banner">
         @if($post->featured_image)
             <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="svc-card-img" loading="lazy">
         @else
              <div class="svc-card-img" style="background: linear-gradient(135deg, rgba(255, 0, 110, 0.15) 0%, rgba(131, 56, 236, 0.05) 100%); display: flex; align-items: center; justify-content: center; height: 100%;">
                  <i class="fa-solid fa-newspaper" style="font-size: 3rem; color: var(--admin-primary); opacity: 0.25;"></i>
              </div>
         @endif
         
         <div class="svc-card-overlay"></div>
         
         {{-- Status Switch (iOS style) --}}
         <div class="svc-card-switch" onclick="event.stopPropagation();">
              <span class="svc-switch-label" id="statusLabel-{{ $post->id }}">
                  {{ $post->status === 'published' ? 'Publicado' : 'Borrador' }}
              </span>
              <label class="svc-switch">
                  <input type="checkbox" class="post-active-toggle" data-id="{{ $post->id }}" {{ $post->status === 'published' ? 'checked' : '' }}>
                  <span class="svc-slider"></span>
              </label>
         </div>
     </div>

     {{-- Overlapping Icon Badge --}}
     <div class="svc-card-emoji-wrap">
         @if($post->category === 'branding')
             <i class="fa-solid fa-copyright"></i>
         @elseif($post->category === 'diseno')
             <i class="fa-solid fa-bezier-curve"></i>
         @elseif($post->category === 'seo')
             <i class="fa-solid fa-magnifying-glass-chart"></i>
         @elseif($post->category === 'redes')
             <i class="fa-solid fa-share-nodes"></i>
         @elseif($post->category === 'marketing')
             <i class="fa-solid fa-bullhorn"></i>
         @else
             <i class="fa-solid fa-newspaper"></i>
         @endif
     </div>

     {{-- Card Body --}}
     <div class="svc-card-body">
         <h3 class="svc-card-title">{{ $post->title }}</h3>
         <span class="svc-card-slug">/blog/{{ $post->slug }}</span>
         
         <p class="svc-card-desc">{{ Str::limit(strip_tags($post->content), 100) }}</p>

         {{-- Metadata Badges --}}
         <div class="svc-card-metadata">
             <span class="svc-card-badge" title="Fecha de Publicación">
                 <i class="fa-regular fa-calendar"></i>
                 <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
             </span>

             <span class="svc-card-badge" title="Autor">
                 <i class="fa-regular fa-user"></i>
                 <span>{{ $post->user->name ?? 'Admin' }}</span>
             </span>

             @if($post->category)
              <span class="svc-card-badge" style="background: rgba(255, 0, 110, 0.1); color: var(--admin-primary); border-color: rgba(255, 0, 110, 0.15);" title="Categoría">
                  <i class="fa-solid fa-tag"></i>
                  <span>{{ ucfirst($post->category) }}</span>
              </span>
             @endif
         </div>

         {{-- Reading Stats --}}
         <div style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem; font-size: 0.75rem; color: #64748b;">
             <span title="Palabras"><i class="fa-solid fa-text-width" style="margin-right: 0.25rem;"></i>{{ str_word_count(strip_tags($post->content)) }} palabras</span>
             <span title="Tiempo de lectura"><i class="fa-regular fa-clock" style="margin-right: 0.25rem;"></i>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min lectura</span>
         </div>

         {{-- Actions Grid --}}
         <div class="svc-card-actions" onclick="event.stopPropagation();">
              <button type="button" class="svc-card-btn svc-card-btn--preview" onclick="openPostPreview({{ $post->id }})" title="Vista Previa">
                  <i class="fa-solid fa-eye"></i>
                  <span>Vista Previa</span>
              </button>
              <button type="button" class="svc-card-btn svc-card-btn--quick" onclick="openQuickEdit({{ $post->id }})" title="Edición Rápida" style="background: rgba(14, 165, 233, 0.1); color: rgb(14, 165, 233);">
                  <i class="fa-solid fa-bolt"></i>
                  <span>Rápido</span>
              </button>
              <a href="{{ route('admin.posts.edit', $post) }}" class="svc-card-btn svc-card-btn--edit" title="Editar">
                  <i class="fa-solid fa-pen-to-square"></i>
                  <span>Editar</span>
              </a>
              <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                    onsubmit="return confirm('¿Seguro que deseas eliminar el post {{ $post->title }}?')" style="display: contents;">
                   @csrf @method('DELETE')
                   <button type="submit" class="svc-card-btn svc-card-btn--delete" title="Eliminar">
                       <i class="fa-solid fa-trash-can"></i>
                       <span>Eliminar</span>
                   </button>
              </form>
         </div>
     </div>
</div>
@empty
<div class="svc-empty-state" style="grid-column: 1 / -1;">
    <i class="fa-solid fa-newspaper svc-empty-icon"></i>
    <h3>No se encontraron artículos</h3>
    <p>Intenta ajustar los filtros de búsqueda o crea un nuevo artículo.</p>
</div>
@endforelse
