@extends('layouts.app')

@section('title', $project->title . ' | Proyectos CreativeUp')
@section('meta_description', Str::limit($project->description, 160))
@section('body-class', 'page-project-show')

@push('head')
<meta property="og:title" content="{{ $project->title }} | CreativeUp">
<meta property="og:description" content="{{ Str::limit($project->description, 200) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
@if($project->thumbnail)
<meta property="og:image" content="{{ Storage::url($project->thumbnail) }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="{{ route('projects.show', $project->slug) }}">
@if(!empty($project->technologies) && is_array($project->technologies))
<meta name="keywords" content="{{ implode(', ', $project->technologies) }}">
@endif
@endpush

@section('content')

<article class="pshow-page" itemscope itemtype="https://schema.org/CreativeWork">

{{-- Scroll Progress Bar --}}
<div class="pshow-progress-bar" id="pshowProgress"></div>

{{-- ═══ HERO — Split layout con imagen prominente ═══ --}}
<section class="pshow-hero" aria-labelledby="pshow-title">
    <div class="pshow-hero-shapes" aria-hidden="true">
        <div class="pshow-hero-shape pshow-hero-shape--1"></div>
        <div class="pshow-hero-shape pshow-hero-shape--2"></div>
    </div>

    <div class="pshow-hero-split">
        {{-- Columna texto --}}
        <div class="pshow-hero-text anim-hidden" data-anim="fade-up">
            <a href="{{ route('projects.index') }}" class="pshow-back" aria-label="Volver a todos los proyectos">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>Todos los proyectos</span>
            </a>

            @if(!empty($project->type))
                <span class="pshow-hero-tag">
                    <i class="fa-solid fa-folder" aria-hidden="true"></i>
                    <span itemprop="genre">{{ $project->type }}</span>
                </span>
            @endif

            <h1 id="pshow-title" class="pshow-hero-title" itemprop="name">{{ $project->title }}</h1>

            <div class="pshow-hero-meta">
                @if(!empty($project->client))
                    <div class="pshow-hero-meta-item">
                        <i class="fa-solid fa-building" aria-hidden="true"></i>
                        <span itemprop="creator">{{ $project->client }}</span>
                    </div>
                @endif
                @if(!empty($project->year))
                    <div class="pshow-hero-meta-item">
                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                        <time datetime="{{ $project->year }}" itemprop="dateCreated">{{ $project->year }}</time>
                    </div>
                @endif
                @if(!empty($project->technologies) && is_array($project->technologies))
                    <div class="pshow-hero-meta-item">
                        <i class="fa-solid fa-code" aria-hidden="true"></i>
                        <span>{{ count($project->technologies) }} tecnologías</span>
                    </div>
                @endif
            </div>

            <p class="pshow-hero-desc" itemprop="description">{{ $project->description }}</p>

            @if(!empty($project->technologies) && is_array($project->technologies))
                <div class="pshow-hero-techs" role="list" aria-label="Tecnologías utilizadas">
                    @foreach($project->technologies as $tech)
                        <span class="pshow-hero-tech" role="listitem" itemprop="keywords">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif

            <div class="pshow-hero-actions">
                @if($project->url)
                    <a href="{{ $project->url }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="pshow-hero-btn pshow-hero-btn--primary"
                       itemprop="url">
                        <span>Ver en vivo</span>
                        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    </a>
                @endif
                <a href="{{ route('contact.index') }}" class="pshow-hero-btn pshow-hero-btn--ghost">
                    <span>Proyecto similar</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        {{-- Columna imagen --}}
        <div class="pshow-hero-visual anim-hidden" data-anim="fade-left">
            <figure class="pshow-hero-img-frame" style="overflow: visible; box-shadow: none; background: transparent;">
                @php
                    $mainImage = $project->thumbnail ? Storage::url($project->thumbnail) : ($project->images->first() ? Storage::url($project->images->first()->image_path) : asset('images/hero-1.jpg'));
                    $device = $project->thumbnail_device ?? 'macbook';
                    $displayUrl = 'localhost';
                    if ($project->url) {
                        $parsed = parse_url($project->url);
                        $displayUrl = ($parsed['host'] ?? '') . ($parsed['path'] ?? '');
                    }
                @endphp
                <div class="apple-device-wrapper" id="heroDeviceWrapper" data-device-type="{{ $device }}">
                    @include('front.projects._device-mockup', [
                        'device' => $device,
                        'image' => $mainImage,
                        'title' => $project->title,
                        'displayUrl' => $displayUrl
                    ])
                </div>
                {{-- Esquinas decorativas --}}
                <div class="pshow-hero-corner pshow-hero-corner--tl" aria-hidden="true"></div>
                <div class="pshow-hero-corner pshow-hero-corner--br" aria-hidden="true"></div>
            </figure>

            {{-- Badges flotantes --}}
            @if($project->images->count() > 0)
            <div class="pshow-hero-float pshow-hero-float--imgs" aria-label="{{ $project->images->count() }} imágenes">
                <span class="pshow-hero-float-num">{{ $project->images->count() }}</span>
                <span class="pshow-hero-float-label">Imágenes</span>
            </div>
            @endif
            @if($project->steps->count() > 0)
            <div class="pshow-hero-float pshow-hero-float--steps" aria-label="{{ $project->steps->count() }} fases">
                <span class="pshow-hero-float-num">{{ $project->steps->count() }}</span>
                <span class="pshow-hero-float-label">Fases</span>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══ SECCIONES DE PASOS ═══ --}}
@if($project->steps->count() > 0)
    @foreach($project->steps as $index => $step)
        @php $isEven = $index % 2 === 1; @endphp
        <section class="pshow-step {{ $isEven ? 'pshow-step--reverse' : '' }}">
            <div class="pshow-step-inner">
                {{-- Texto --}}
                @php
                    $stepImagesCount = 0;
                    if($step->image1) $stepImagesCount++;
                    if($step->image2) $stepImagesCount++;
                    if($step->image3) $stepImagesCount++;
                    
                    $finalCount = $stepImagesCount > 0 ? $stepImagesCount : min(3, $project->images->count() - ($index * 3));
                    if ($finalCount <= 0) $finalCount = 0;
                @endphp
                <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                    <div class="pshow-step-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <h2 class="pshow-step-title">{{ $step->title }}</h2>
                    <p class="pshow-step-desc">{{ $step->description }}</p>
                </div>
                {{-- Collage de imágenes --}}
                <div class="pshow-step-collage anim-scroll pshow-step-collage--count-{{ $finalCount }}" data-anim="fade-up">
                    {{-- Usaremos un contador de imágenes activas para determinar la clase de grid si es necesario --}}
                    @php
                        $activeImages = 0;
                        if($step->image1) $activeImages++;
                        if($step->image2) $activeImages++;
                        if($step->image3) $activeImages++;
                        
                        $imgIndex = 1;
                    @endphp

                    @if($activeImages > 0)
                        @if($step->image1)
                            <div class="pshow-collage-img pshow-collage-img--{{ $imgIndex++ }}">
                                @include('front.projects._device-mockup', [
                                    'device' => $step->image1_device ?? 'safari',
                                    'image' => Storage::url($step->image1),
                                    'title' => $step->title,
                                    'displayUrl' => $displayUrl
                                ])
                            </div>
                        @endif
                        @if($step->image2)
                            <div class="pshow-collage-img pshow-collage-img--{{ $imgIndex++ }}">
                                @include('front.projects._device-mockup', [
                                    'device' => $step->image2_device ?? 'iphone',
                                    'image' => Storage::url($step->image2),
                                    'title' => $step->title,
                                    'displayUrl' => $displayUrl
                                ])
                            </div>
                        @endif
                        @if($step->image3)
                            <div class="pshow-collage-img pshow-collage-img--{{ $imgIndex++ }}">
                                @include('front.projects._device-mockup', [
                                    'device' => $step->image3_device ?? 'ipad',
                                    'image' => Storage::url($step->image3),
                                    'title' => $step->title,
                                    'displayUrl' => $displayUrl
                                ])
                            </div>
                        @endif
                    @elseif($project->images->count() > 0)
                        @foreach($project->images->slice($index * 3, 3) as $fallbackImg)
                            <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                                @include('front.projects._device-mockup', [
                                    'device' => 'safari',
                                    'image' => Storage::url($fallbackImg->image_path),
                                    'title' => $step->title,
                                    'displayUrl' => $displayUrl
                                ])
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@else
    {{-- Fallback: challenge/solution/results --}}
    @if(!empty($project->challenge))
    <section class="pshow-step">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <div class="pshow-step-num">01</div>
                <h2 class="pshow-step-title">El Reto</h2>
                <p class="pshow-step-desc">{{ $project->challenge }}</p>
            </div>
            <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                @foreach($project->images->slice(0, 3) as $img)
                    <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                        <div class="pshow-mockup pshow-mockup--safari">
                            <img src="{{ Storage::url($img->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!empty($project->solution))
    <section class="pshow-step pshow-step--reverse">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <div class="pshow-step-num">02</div>
                <h2 class="pshow-step-title">La Solución</h2>
                <p class="pshow-step-desc">{{ $project->solution }}</p>
            </div>
            <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                @foreach($project->images->slice(3, 3) as $img)
                    <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                        <div class="pshow-mockup pshow-mockup--safari">
                            <img src="{{ Storage::url($img->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!empty($project->results))
    <section class="pshow-step">
        <div class="pshow-step-inner">
            <div class="pshow-step-text anim-scroll" data-anim="fade-up">
                <div class="pshow-step-num">03</div>
                <h2 class="pshow-step-title">Los Resultados</h2>
                <p class="pshow-step-desc">{{ $project->results }}</p>
            </div>
            <div class="pshow-step-collage anim-scroll" data-anim="fade-up">
                @foreach($project->images->slice(6, 3) as $img)
                    <div class="pshow-collage-img pshow-collage-img--{{ $loop->iteration }}">
                        <div class="pshow-mockup pshow-mockup--safari">
                            <img src="{{ Storage::url($img->image_path) }}" alt="{{ $project->title }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endif

{{-- ═══ GALERÍA DE IMÁGENES ═══ --}}
@if($project->images->count() > 0)
<section class="pshow-gallery" aria-labelledby="pshow-gallery-title">
    <div class="pshow-gallery-inner">
        <div class="pshow-gallery-header anim-scroll" data-anim="fade-up">
            <span class="pshow-gallery-badge">
                <i class="fa-solid fa-images" aria-hidden="true"></i>
                Galería del proyecto
            </span>
            <h2 id="pshow-gallery-title" class="pshow-gallery-title">Imágenes del proyecto</h2>
        </div>
        <div class="pshow-gallery-grid" role="list">
            @foreach($project->images as $gi => $gImg)
                @php
                $imgUrl = Storage::url($gImg->image_path);
                $deviceType = $gImg->device_type;
                $isConfigured = !empty($deviceType) && $deviceType !== 'none';
                $isNone = $deviceType === 'none';
                $displayUrl = 'localhost';
                if ($project->url) {
                    $parsed = parse_url($project->url);
                    $displayUrl = ($parsed['host'] ?? '') . ($parsed['path'] ?? '');
                }
            @endphp
            <figure class="pshow-gallery-item anim-scroll" 
                    data-anim="fade-up" 
                    style="animation-delay: {{ $gi * 0.08 }}s; cursor: pointer;"
                    role="listitem"
                    data-lightbox="{{ $imgUrl }}"
                    data-device-configured="{{ ($isConfigured || $isNone) ? 'true' : 'false' }}">
                @if($isConfigured)
                    @include('front.projects._device-mockup', [
                        'device' => $deviceType,
                        'image' => $imgUrl,
                        'title' => $project->title . ' - Imagen ' . ($gi + 1),
                        'displayUrl' => $displayUrl
                    ])
                @else
                    {{-- Default raw image (will be wrapped by JS dynamic aspect ratio script) --}}
                    <img src="{{ $imgUrl }}" 
                         alt="{{ $project->title }} - Imagen {{ $gi + 1 }}" 
                         loading="lazy" 
                         decoding="async"
                         width="400"
                         height="300">
                @endif
                <div class="pshow-gallery-item-overlay" aria-hidden="true">
                    <i class="fa-solid fa-expand"></i>
                </div>
            </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ BANNER CTA ═══ --}}
<section class="pshow-banner" aria-labelledby="pshow-banner-title">
    <div class="pshow-banner-shapes" aria-hidden="true">
        <div class="pshow-banner-shape pshow-banner-shape--1"></div>
        <div class="pshow-banner-shape pshow-banner-shape--2"></div>
    </div>
    <div class="pshow-banner-content anim-scroll" data-anim="fade-up">
        <div class="pshow-banner-badge">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            ¿Te gustó lo que viste?
        </div>
        <h2 id="pshow-banner-title" class="pshow-banner-title">¿Listo para crear algo increíble?</h2>
        <p class="pshow-banner-text">Llevamos tu idea al siguiente nivel con diseño y estrategia.</p>
        <a href="{{ route('contact.index') }}" class="pshow-banner-btn">
            <span>Empecemos tu proyecto</span>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>

{{-- ═══ SIGUIENTE PROYECTO ═══ --}}
@if($nextProject)
<section class="pshow-next">
    <a href="{{ route('projects.show', $nextProject->slug) }}" class="pshow-next-link">
        <div class="pshow-next-label anim-scroll" data-anim="fade-up">
            <span class="pshow-next-small">Siguiente proyecto</span>
            <i class="fa-solid fa-arrow-right"></i>
        </div>
        <h2 class="pshow-next-title anim-scroll" data-anim="fade-up">{{ $nextProject->title }}</h2>
        <div class="pshow-next-img anim-scroll" data-anim="fade-up">
            <img src="{{ $nextProject->thumbnail ? Storage::url($nextProject->thumbnail) : ($nextProject->images->first() ? Storage::url($nextProject->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                 alt="{{ $nextProject->title }}">
        </div>
    </a>
</section>
@elseif($previousProject)
<section class="pshow-next">
    <a href="{{ route('projects.show', $previousProject->slug) }}" class="pshow-next-link">
        <div class="pshow-next-label anim-scroll" data-anim="fade-up">
            <span class="pshow-next-small">Ver otro proyecto</span>
        </div>
        <h2 class="pshow-next-title anim-scroll" data-anim="fade-up">{{ $previousProject->title }}</h2>
        <div class="pshow-next-img anim-scroll" data-anim="fade-up">
            <img src="{{ $previousProject->thumbnail ? Storage::url($previousProject->thumbnail) : ($previousProject->images->first() ? Storage::url($previousProject->images->first()->image_path) : asset('images/hero-1.jpg')) }}"
                 alt="{{ $previousProject->title }}">
        </div>
    </a>
</section>
@endif

</article>

@push('scripts')
<script>
(function() {
    // Dynamic Mockup Wrapping based on image aspect ratio
    function wrapImageInDevice(img, container, isHero = false) {
        const src = img.src;
        const alt = img.alt;
        
        // Use a temporary image to make sure naturalWidth/naturalHeight are available
        const tempImg = new Image();
        tempImg.onload = function() {
            const aspect = tempImg.naturalWidth / tempImg.naturalHeight;
            
            // Clear container
            container.innerHTML = '';
            
            if (aspect > 1.2) {
                // Landscape -> MacBook / Browser Mockup
                if (isHero) {
                    container.innerHTML = `
                        <div class="apple-macbook-front">
                            <div class="mac-lid">
                                <div class="mac-notch"><div class="mac-camera"></div></div>
                                <div class="mac-screen">
                                    <div class="mac-browser">
                                        <div class="mac-browser-dots"></div>
                                        <div class="mac-browser-url">
                                            <i class="fa-solid fa-lock" style="font-size:8px; margin-right:5px; color:#888;"></i>
                                            ${window.location.hostname}
                                        </div>
                                        <div style="width:40px;"></div>
                                    </div>
                                    <img src="${src}" alt="${alt}" style="width:100%; height:100%; object-fit:cover; display:block;">
                                </div>
                            </div>
                            <div class="mac-keyboard-base">
                                <div class="mac-foot mac-foot--left"></div>
                                <div class="mac-foot mac-foot--right"></div>
                            </div>
                        </div>
                    `;
                } else {
                    container.innerHTML = `
                        <div class="apple-macbook-front">
                            <div class="mac-lid">
                                <div class="mac-notch"><div class="mac-camera"></div></div>
                                <div class="mac-screen">
                                    <div class="mac-browser">
                                        <div class="mac-browser-dots"></div>
                                        <div class="mac-browser-url">
                                            <i class="fa-solid fa-lock" style="font-size:8px; margin-right:5px; color:#888;"></i>
                                            ${window.location.hostname}
                                        </div>
                                        <div style="width:40px;"></div>
                                    </div>
                                    <img src="${src}" alt="${alt}" style="width:100%; height:calc(100% - 30px); object-fit:cover; display:block;">
                                </div>
                            </div>
                            <div class="mac-keyboard-base">
                                <div class="mac-foot mac-foot--left"></div>
                                <div class="mac-foot mac-foot--right"></div>
                            </div>
                        </div>
                    `;
                }
            } else if (aspect < 0.8) {
                // Portrait -> iPhone mockup
                const deviceWidth = isHero ? '300px' : '230px';
                container.innerHTML = `
                    <div class="project-mockup-wrapper mockup-iphone">
                        <div class="iphone-device" style="width: ${deviceWidth};">
                            <div class="iphone-bezel">
                                <div class="iphone-screen">
                                    <div class="iphone-island"></div>
                                    <div class="iphone-screen-img">
                                        <img src="${src}" alt="${alt}">
                                    </div>
                                </div>
                            </div>
                            <div class="iphone-button volume-up"></div>
                            <div class="iphone-button volume-down"></div>
                            <div class="iphone-button power"></div>
                        </div>
                    </div>
                `;
            } else {
                // Square/Tablet -> iPad mockup
                const deviceWidth = isHero ? '480px' : '320px';
                container.innerHTML = `
                    <div class="project-mockup-wrapper mockup-ipad">
                        <div class="ipad-device" style="width: ${deviceWidth};">
                            <div class="ipad-bezel">
                                <div class="ipad-screen">
                                    <div class="ipad-screen-img">
                                        <img src="${src}" alt="${alt}">
                                    </div>
                                </div>
                            </div>
                            <div class="ipad-button power"></div>
                        </div>
                    </div>
                `;
            }
        };
        tempImg.src = src;
    }

    // Run for gallery images (only those that are NOT already configured by the admin)
    document.querySelectorAll('.pshow-gallery-item[data-device-configured="false"] img').forEach(img => {
        const parent = img.closest('.pshow-gallery-item');
        if (img.complete) {
            wrapImageInDevice(img, parent, false);
        } else {
            img.addEventListener('load', function() {
                wrapImageInDevice(img, parent, false);
            });
        }
    });

    // Lightbox functionality for gallery
    document.addEventListener('click', function(e) {
        const galleryItem = e.target.closest('[data-lightbox]');
        if (galleryItem) {
            const src = galleryItem.dataset.lightbox;
            const lightbox = document.createElement('div');
            lightbox.className = 'proj-lightbox is-active';
            lightbox.setAttribute('role', 'dialog');
            lightbox.setAttribute('aria-modal', 'true');
            lightbox.innerHTML = `
                <div class="proj-lightbox-content">
                    <img src="${src}" alt="Imagen ampliada">
                    <button class="proj-lightbox-close" aria-label="Cerrar">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            `;
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox || e.target.closest('.proj-lightbox-close')) {
                    lightbox.remove();
                    document.body.style.overflow = '';
                }
            });
            
            document.addEventListener('keydown', function(ev) {
                if (ev.key === 'Escape' && document.querySelector('.proj-lightbox')) {
                    lightbox.remove();
                    document.body.style.overflow = '';
                }
            }, { once: true });
        }
    });
})();
</script>
@endpush

@endsection
