{{-- Admin Projects Grid Partial - For AJAX Loading --}}
@if($projects->count() > 0)
<div class="svc-grid" id="projectsGrid">
@foreach($projects as $project)
<div class="svc-card-item" 
     style="--card-color: var(--admin-primary)"
     data-id="{{ $project->id }}"
     data-status="{{ $project->status }}"
     data-title="{{ e(strtolower($project->title)) }}"
     data-slug="{{ e(strtolower($project->slug)) }}"
     data-desc="{{ e($project->description ?? '') }}"
     data-client="{{ e($project->client ?? '') }}"
     data-year="{{ e($project->year ?? '') }}"
     data-url="{{ e($project->url ?? '') }}"
     data-thumbnail="{{ $project->thumbnail ? asset('storage/' . $project->thumbnail) : '' }}"
     data-images-count="{{ $project->images->count() }}"
     data-images-list="{{ e(json_encode($project->images->pluck('image_path')->map(fn($p) => asset('storage/' . $p)))) }}"
     data-technologies-list="{{ e($project->technologies ? json_encode($project->technologies) : '[]') }}">
     
     {{-- Card Top Banner --}}
     <div class="svc-card-banner">
         @if($project->thumbnail)
             <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="svc-card-img" loading="lazy">
         @else
             <div class="svc-card-img" style="background: linear-gradient(135deg, rgba(255, 0, 110, 0.15) 0%, rgba(131, 56, 236, 0.05) 100%); display: flex; align-items: center; justify-content: center; height: 100%;">
                 <i class="fa-solid fa-diagram-project" style="font-size: 3rem; color: var(--admin-primary); opacity: 0.25;"></i>
             </div>
         @endif
         
         <div class="svc-card-overlay"></div>
         
         {{-- Status Switch (iOS style) --}}
         <div class="svc-card-switch" onclick="event.stopPropagation();">
              <span class="svc-switch-label" id="statusLabel-{{ $project->id }}">
                  {{ $project->status === 'published' ? 'Publicado' : 'Borrador' }}
              </span>
              <label class="svc-switch">
                  <input type="checkbox" class="proj-active-toggle" data-id="{{ $project->id }}" {{ $project->status === 'published' ? 'checked' : '' }}>
                  <span class="svc-slider"></span>
              </label>
         </div>
     </div>

     {{-- Overlapping Icon Badge --}}
     <div class="svc-card-emoji-wrap">
         @if($project->type && Str::contains(strtolower($project->type), 'web'))
             <i class="fa-solid fa-globe"></i>
         @elseif($project->type && Str::contains(strtolower($project->type), 'brand'))
             <i class="fa-solid fa-palette"></i>
         @elseif($project->type && Str::contains(strtolower($project->type), 'app'))
             <i class="fa-solid fa-mobile-screen-button"></i>
         @elseif($project->type && Str::contains(strtolower($project->type), 'marketing'))
             <i class="fa-solid fa-chart-line"></i>
         @else
             <i class="fa-solid fa-diagram-project"></i>
         @endif
     </div>

     {{-- Card Body --}}
     <div class="svc-card-body">
         <h3 class="svc-card-title">{{ $project->title }}</h3>
         <span class="svc-card-slug">/proyectos/{{ $project->slug }}</span>
         
         <p class="svc-card-desc">{{ Str::limit($project->description, 100) }}</p>

         {{-- Metadata Badges --}}
         <div class="svc-card-metadata">
             @if($project->client)
             <span class="svc-card-badge" title="Cliente">
                 <i class="fa-regular fa-building"></i>
                 <span>{{ $project->client }}</span>
             </span>
             @endif

             @if($project->year)
             <span class="svc-card-badge" title="Año">
                 <i class="fa-regular fa-calendar-days"></i>
                 <span>{{ $project->year }}</span>
             </span>
             @endif

             @if($project->type)
             <span class="svc-card-badge" style="background: rgba(255, 0, 110, 0.1); color: var(--admin-primary); border-color: rgba(255, 0, 110, 0.15);" title="Tipo">
                 <i class="fa-solid fa-tag"></i>
                 <span>{{ $project->type }}</span>
             </span>
             @endif
         </div>

         {{-- Technologies Tags (up to 3) --}}
         @if($project->technologies && is_array($project->technologies) && count($project->technologies) > 0)
         <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; margin-bottom: 1.25rem;">
             @foreach(array_slice($project->technologies, 0, 3) as $tech)
                 <span style="font-size: 0.7rem; font-weight: 700; color: var(--admin-primary); background: rgba(255, 0, 110, 0.08); padding: 0.15rem 0.5rem; border-radius: 6px; border: 1px solid rgba(255, 0, 110, 0.12);">{{ $tech }}</span>
             @endforeach
             @if(count($project->technologies) > 3)
                 <span style="font-size: 0.7rem; font-weight: 700; color: #64748b; background: #f1f5f9; padding: 0.15rem 0.4rem; border-radius: 6px;">+{{ count($project->technologies) - 3 }}</span>
             @endif
         </div>
         @endif

         {{-- Actions Grid --}}
         <div class="svc-card-actions" onclick="event.stopPropagation();">
              <button type="button" class="svc-card-btn svc-card-btn--preview" onclick="openProjectPreview({{ $project->id }})" title="Vista Previa">
                  <i class="fa-solid fa-eye"></i>
                  <span>Vista Previa</span>
              </button>
              <a href="{{ route('admin.projects.edit', $project) }}" class="svc-card-btn svc-card-btn--edit" title="Editar">
                  <i class="fa-solid fa-pen-to-square"></i>
                  <span>Editar</span>
              </a>
              <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                    onsubmit="return confirm('¿Seguro que deseas eliminar el proyecto {{ $project->title }}?')" style="display: contents;">
                   @csrf @method('DELETE')
                   <button type="submit" class="svc-card-btn svc-card-btn--delete" title="Eliminar">
                       <i class="fa-solid fa-trash-can"></i>
                       <span>Eliminar</span>
                   </button>
              </form>
         </div>
     </div>
</div>
@endforeach
</div>
@else
<div class="svc-empty-state" style="grid-column: 1 / -1; width: 100%;">
    <i class="fa-solid fa-folder-open svc-empty-icon"></i>
    <h3>No se encontraron proyectos</h3>
    <p>Intenta ajustar los filtros de búsqueda o crea un nuevo proyecto.</p>
</div>
@endif
