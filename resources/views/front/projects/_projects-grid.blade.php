{{-- Projects Grid Partial - For AJAX Loading --}}
@forelse($projects as $index => $project)
    @php
        $mainImage = $project->thumbnail
            ? Storage::url($project->thumbnail)
            : ($project->images->first()
                ? Storage::url($project->images->first()->image_path)
                : asset('images/hero-1.jpg'));
        $projectNum = str_pad($projects->firstItem() + $index, 2, '0', STR_PAD_LEFT);
    @endphp

    <article class="pidx-card" role="listitem">
        {{-- Número grande decorativo --}}
        <div class="pidx-card-number" aria-hidden="true">
            <span>{{ $projectNum }}</span>
        </div>

        <a href="{{ route('projects.show', $project->slug) }}" 
           class="pidx-card-link"
           aria-label="Ver proyecto: {{ $project->title }}">
            {{-- Imagen principal --}}
            <div class="pidx-card-image">
                <img src="{{ $mainImage }}"
                     alt="{{ $project->title }}"
                     loading="lazy"
                     decoding="async"
                     width="600"
                     height="375">
                <div class="pidx-card-image-overlay" aria-hidden="true">
                    <span class="pidx-card-view">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Ver proyecto</span>
                    </span>
                </div>
                @if(!empty($project->type))
                <span class="pidx-card-tag">{{ $project->type }}</span>
                @endif
            </div>

            {{-- Contenido --}}
            <div class="pidx-card-content">
                {{-- Header con año --}}
                <div class="pidx-card-header">
                    @if(!empty($project->year))
                    <span class="pidx-card-year">
                        <time datetime="{{ $project->year }}">{{ $project->year }}</time>
                    </span>
                    @endif
                    @if(!empty($project->client))
                    <span class="pidx-card-client">
                        <i class="fa-regular fa-building" aria-hidden="true"></i>
                        {{ $project->client }}
                    </span>
                    @endif
                </div>

                {{-- Título --}}
                <h3 class="pidx-card-title">{{ $project->title }}</h3>

                {{-- Descripción --}}
                <p class="pidx-card-desc">{{ Str::limit($project->description, 140) }}</p>

                {{-- Tecnologías como badges --}}
                @if(!empty($project->technologies) && is_array($project->technologies))
                <div class="pidx-card-techs" aria-label="Tecnologías utilizadas">
                    @foreach(array_slice($project->technologies, 0, 4) as $tech)
                        <span class="pidx-card-tech">{{ $tech }}</span>
                    @endforeach
                    @if(count($project->technologies) > 4)
                        <span class="pidx-card-tech pidx-card-tech--more">+{{ count($project->technologies) - 4 }}</span>
                    @endif
                </div>
                @endif

                {{-- Footer con CTA --}}
                <div class="pidx-card-footer">
                    <span class="pidx-card-cta">
                        <span>Explorar proyecto</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
        </a>
    </article>
@empty
    <div class="ajax-no-results">
        <div class="ajax-no-results-icon">
            <i class="fa-solid fa-folder-open"></i>
        </div>
        <h3 class="ajax-no-results-title">No se encontraron proyectos</h3>
        <p class="ajax-no-results-text">
            Intenta con otros filtros o explora todas las categorías.
        </p>
    </div>
@endforelse
