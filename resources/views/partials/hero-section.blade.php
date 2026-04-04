{{-- Componente Hero Section --}}
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-text anim-hidden" data-anim="fade-right">
            <h1 class="hero-title">
                {{ $title }}
            </h1>
        </div>

        <div class="hero-images">
            <div class="hero-img-wrapper anim-hidden" data-anim="fade-up">
                <img src="{{ asset($image1) }}"
                     alt="{{ $alt1 }}"
                     width="320" height="400"
                     decoding="async"
                     fetchpriority="high">
            </div>

            <div class="hero-img-wrapper anim-hidden" data-anim="fade-up">
                <img src="{{ asset($image2) }}"
                     alt="{{ $alt2 }}"
                     width="320" height="400"
                     decoding="async"
                     fetchpriority="high">
            </div>

            <p class="hero-description anim-hidden" data-anim="flip-up">
                {{ $description }}
            </p>
        </div>
    </div>
</section>
