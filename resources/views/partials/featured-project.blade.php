{{-- Componente Proyecto Destacado --}}
@if($project)
<section class="portfolio-section">
    <div class="featured-project">
        <div class="featured-images">
            <div class="featured-img-main anim-scroll" data-anim="fade-up">
                <img src="{{ $project->thumbnail ? Storage::url($project->thumbnail) : ($project->images->first() ? Storage::url($project->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                     alt="{{ $project->title }}"
                     width="600" height="450"
                     loading="lazy"
                     decoding="async">
                <a href="{{ route('projects.show', $project->slug) }}" 
                   class="btn-ver"
                   aria-label="Ver proyecto {{ $project->title }}">
                    <span>Ver</span>
                </a>
            </div>
            <div class="featured-img-side anim-scroll" data-anim="fade-left">
                <h3 class="featured-project-name">
                    {{ $project->title }}
                </h3>
                @if($project->images->count() > 0)
                <div class="featured-img-small">
                    <img src="{{ Storage::url($project->images->first()->image_path) }}"
                         alt="{{ $project->title }}"
                         width="400" height="250"
                         loading="lazy"
                         decoding="async">
                </div>
                @endif
            </div>
        </div>
        @if(!empty($project->type))
            <span class="featured-type-label anim-scroll" data-anim="fade-in">{{ $project->type }}</span>
        @endif
    </div>
</section>
@endif
