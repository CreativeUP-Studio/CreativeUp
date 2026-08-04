<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', $siteSettings->meta_title)</title>
    
    {{-- Meta Tags --}}
    <meta name="description" content="@yield('description', $siteSettings->meta_description)">
    <meta name="keywords" content="diseño web, desarrollo web, marketing digital, branding, UX/UI">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', $siteSettings->meta_title)">
    <meta property="og:description" content="@yield('description', $siteSettings->meta_description)">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- AOS Animation Library --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    
    {{-- Hotwire Turbo --}}
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017-umd.js" defer></script>

    {{-- Main JavaScript --}}
    <script src="{{ asset('js/redesign.js') }}?v={{ file_exists(public_path('js/redesign.js')) ? filemtime(public_path('js/redesign.js')) : '1.0' }}" defer></script>
    
    {{-- Chat Widget JavaScript --}}
    <script src="{{ asset('js/chat-widget.js') }}?v={{ file_exists(public_path('js/chat-widget.js')) ? filemtime(public_path('js/chat-widget.js')) : '1.0' }}" defer></script>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Custom Styles --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/redesign.css') }}?v={{ file_exists(public_path('css/frontend/redesign.css')) ? filemtime(public_path('css/frontend/redesign.css')) : '1.0' }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/redesign-components.css') }}?v={{ file_exists(public_path('css/frontend/redesign-components.css')) ? filemtime(public_path('css/frontend/redesign-components.css')) : '1.0' }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/navbar-premium.css') }}?v={{ file_exists(public_path('css/frontend/navbar-premium.css')) ? filemtime(public_path('css/frontend/navbar-premium.css')) : '1.0' }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/fullscreen-menu-premium.css') }}?v={{ file_exists(public_path('css/frontend/fullscreen-menu-premium.css')) ? filemtime(public_path('css/frontend/fullscreen-menu-premium.css')) : '1.0' }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/portfolio-premium.css') }}?v={{ file_exists(public_path('css/frontend/portfolio-premium.css')) ? filemtime(public_path('css/frontend/portfolio-premium.css')) : '1.0' }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/blog-premium.css') }}?v={{ file_exists(public_path('css/frontend/blog-premium.css')) ? filemtime(public_path('css/frontend/blog-premium.css')) : '1.0' }}">
    <link rel="stylesheet" href="{{ asset('css/chat-widget.css') }}?v={{ file_exists(public_path('css/chat-widget.css')) ? filemtime(public_path('css/chat-widget.css')) : '1.0' }}">
    
    @stack('styles')
    
    <style>
        /* Barra de progreso de Turbo estilo premium */
        .turbo-progress-bar {
            height: 4px;
            background: linear-gradient(90deg, #ff006e, #8338ec, #ff006e);
            background-size: 200% 100%;
            animation: turboProgressGradient 2s linear infinite;
            box-shadow: 0 0 10px rgba(255, 0, 110, 0.6), 0 0 5px rgba(131, 56, 236, 0.4);
            border-radius: 0 100px 100px 0;
            z-index: 9999;
        }

        @keyframes turboProgressGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Transición de contenido suavizada */
        .main-content {
            transition: opacity 0.22s cubic-bezier(0.25, 1, 0.5, 1), transform 0.22s cubic-bezier(0.25, 1, 0.5, 1);
            opacity: 1;
            transform: translateY(0);
            will-change: opacity, transform;
        }

        .turbo-loading .main-content {
            opacity: 0;
            transform: translateY(10px);
        }
        
        /* Desvanecimiento de entrada cuando está listo */
        .main-content.fade-in {
            animation: mainFadeIn 0.35s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        @keyframes mainFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• 
           NAVBAR ULTRA PREMIUM - Minimalista con Animaciones Suaves
           â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â• â•  */
        
        /* Remove any top spacing from main content */
        .main-content {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        
        /* Navbar transparent and dynamic logo */
        .navbar-ultra,
        .navbar-container {
            background-color: transparent !important;
            border-bottom: none !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .navbar-ultra::before,
        .navbar-ultra::after,
        .navbar-container::before,
        .navbar-container::after {
            display: none !important;
        }

        .navbar-ultra {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0 !important;
            margin: 0 !important;
        }

        .navbar-container {
            width: 100% !important;
            max-width: 100% !important;
            height: clamp(80px, 10vw, 120px) !important;
            background: transparent !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            margin: 0 !important;
        }

        /* Logo wrapper with smooth positioning */
        .navbar-logo-wrap {
            position: absolute;
            left: clamp(20px, 5vw, 50px);
            top: clamp(20px, 4vw, 40px);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Dots wrapper with smooth positioning */
        .navbar-dots-wrap {
            position: absolute;
            right: clamp(20px, 5vw, 50px);
            top: clamp(20px, 4vw, 40px);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .navbar-logo {
            font-size: clamp(1.6rem, 3.5vw, 2.2rem) !important;
            display: flex;
            align-items: center;
            gap: 0;
            line-height: 1.1 !important;
            margin: 0 !important;
            padding: 12px 24px !important;
            position: relative;
            background: white;
            border-radius: 100px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .navbar-logo:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .navbar-logo .logo-text {
            color: #404040 !important;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
            display: inline-block;
            white-space: nowrap;
            max-width: 250px;
            font-weight: 700;
        }

        .navbar-logo .logo-gradient {
            background: linear-gradient(135deg, #ff006e, #8338ec) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            font-weight: 700;
        }

        /* Logo dot with pulsing animation */
        .navbar-logo .logo-dot {
            width: 8px;
            height: 8px;
            background: #ff006e;
            border-radius: 50%;
            margin-left: 4px;
            animation: logoPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            box-shadow: 0 0 0 0 rgba(255, 0, 110, 0.7);
        }

        @keyframes logoPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 0, 110, 0.7);
            }
            50% {
                transform: scale(1.2);
                box-shadow: 0 0 0 8px rgba(255, 0, 110, 0);
            }
        }

        /* Scrolled state with smooth transitions */
        .navbar-ultra.scrolled {
            background: transparent !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            border-bottom: none !important;
            box-shadow: none !important;
            padding: 0;
        }

        .navbar-ultra.scrolled .navbar-container {
            padding: 25px 50px !important;
        }

        .navbar-ultra.scrolled .logo-text {
            max-width: 0;
            opacity: 0;
            margin: 0;
        }

        .navbar-ultra.scrolled .logo-dot {
            opacity: 0;
            transform: scale(0);
        }
        
        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           9 DOTS TRIGGER - Con Animaciones Mejoradas
           â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .nav-trigger-9dots {
            background: transparent;
            border: none;
            cursor: pointer;
            width: clamp(32px, 4vw, 40px);
            height: clamp(32px, 4vw, 40px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            position: relative;
            padding: 0 !important;
            margin: 0 !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-trigger-9dots:hover {
            transform: scale(1.1);
        }

        .dots-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: clamp(4px, 0.6vw, 6px);
            width: clamp(32px, 4vw, 40px);
            height: clamp(32px, 4vw, 40px);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .dots-grid span {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ff006e, #8338ec) !important;
            border-radius: 50%;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 2px 8px rgba(255, 0, 110, 0.3);
        }

        .nav-trigger-9dots:hover .dots-grid span {
            box-shadow: 0 4px 12px rgba(255, 0, 110, 0.5);
        }

        /* Active state - Morph into X with smooth animation */
        .nav-trigger-9dots.is-active .dots-grid {
            transform: rotate(45deg);
            gap: 0;
        }
        
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(2),
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(4),
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(6),
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(8) {
            opacity: 0;
            transform: scale(0);
        }

        .nav-trigger-9dots.is-active .dots-grid span:nth-child(1),
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(3),
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(7),
        .nav-trigger-9dots.is-active .dots-grid span:nth-child(9) {
            border-radius: 3px;
            transform: scale(1.6);
            background: linear-gradient(135deg, #ff006e, #ff006e) !important;
        }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           FULLSCREEN NAVIGATION styles are in:
           public/css/frontend/fullscreen-menu-premium.css
           â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
    </style>

</head>
<body class="@yield('body-class', '')">

    {{-- ============================================
         NAVBAR ULTRA MODERNO - Glass Morphism
         ============================================ --}}
    <nav class="navbar-ultra" id="mainNavbar">
        <div class="navbar-container">
            {{-- Logo --}}
            <div class="navbar-logo-wrap">
                <a href="{{ route('home') }}" class="navbar-logo">
                    <span class="logo-text">{{ $siteSettings->logo_text }}</span>
                    <span class="logo-gradient">{{ $siteSettings->logo_gradient_text }}</span>
                    <div class="logo-dot"></div>
                </a>
            </div>

            {{-- Fullscreen Nav Trigger (9 Dots) --}}
            <div class="navbar-dots-wrap">
                <button class="nav-trigger-9dots" id="fsNavTrigger" aria-label="Abrir Menú">
                    <div class="dots-grid">
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                    </div>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Overlay --}}
        <div class="navbar-mobile-overlay" id="mobileOverlay">
            <div class="mobile-menu">
                <div class="mobile-menu-header">
                    <a href="{{ route('home') }}" class="mobile-logo">
                        <span class="logo-text">{{ $siteSettings->logo_text }}</span>
                        <span class="logo-gradient">{{ $siteSettings->logo_gradient_text }}</span>
                    </a>
                    <button class="mobile-close" id="mobileClose">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <nav class="mobile-nav">
                    <a href="{{ route('home') }}" class="mobile-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <span class="link-number">01</span>
                        <span class="link-text">Inicio</span>
                        <span class="link-arrow">â†’</span>
                    </a>
                    <a href="{{ route('services.index') }}" class="mobile-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        <span class="link-number">02</span>
                        <span class="link-text">Servicios</span>
                        <span class="link-arrow">â†’</span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="mobile-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <span class="link-number">03</span>
                        <span class="link-text">Portafolio</span>
                        <span class="link-arrow">â†’</span>
                    </a>
                    <a href="{{ route('blog.index') }}" class="mobile-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                        <span class="link-number">04</span>
                        <span class="link-text">Blog</span>
                        <span class="link-arrow">â†’</span>
                    </a>
                    <a href="{{ route('contact.index') }}" class="mobile-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                        <span class="link-number">05</span>
                        <span class="link-text">Contacto</span>
                        <span class="link-arrow">â†’</span>
                    </a>
                </nav>

                <div class="mobile-footer">
                    <div class="mobile-contact">
                        <a href="mailto:{{ $siteSettings->email }}" class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $siteSettings->email }}</span>
                        </a>
                        <a href="tel:{{ $siteSettings->phone }}" class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $siteSettings->phone }}</span>
                        </a>
                    </div>
                    <div class="footer-social" style="margin-top: 1rem;">
                        @if($siteSettings->facebook_url)
                            <a href="{{ $siteSettings->facebook_url }}" target="_blank" class="social-btn social-facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($siteSettings->instagram_url)
                            <a href="{{ $siteSettings->instagram_url }}" target="_blank" class="social-btn social-instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if($siteSettings->linkedin_url)
                            <a href="{{ $siteSettings->linkedin_url }}" target="_blank" class="social-btn social-linkedin" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if($siteSettings->twitter_url)
                            <a href="{{ $siteSettings->twitter_url }}" target="_blank" class="social-btn social-twitter" aria-label="Twitter">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        @endif
                        @if($siteSettings->github_url)
                            <a href="{{ $siteSettings->github_url }}" target="_blank" class="social-btn social-github" aria-label="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================
         FULLSCREEN NAVIGATION - ULTRA PREMIUM WITH ICONS
         ============================================ --}}
    <div class="fs-navigation" id="fsNavigation">
        
        {{-- Logo en el menú desplegable --}}
        <div class="fs-logo-wrap">
            <a href="{{ route('home') }}" class="navbar-logo">
                <span class="logo-text">{{ $siteSettings->logo_text }}</span>
                <span class="logo-gradient">{{ $siteSettings->logo_gradient_text }}</span>
                <div class="logo-dot"></div>
            </a>
        </div>

        {{-- Botón Cerrar --}}
        <button class="fs-close-btn" id="fsCloseBtn" aria-label="Cerrar Menú">
            <span class="close-line"></span>
            <span class="close-line"></span>
        </button>

        <div class="fs-nav-container">
            {{-- Columna Izquierda: Navegación con Iconos e Interactividad --}}
            <nav class="main-navigation">
                <a href="{{ route('home') }}" class="nav-link" 
                   data-preview-img="{{ $siteSettings->menu_img_home_url }}"
                   data-preview-title="CreativeUp Studio"
                   data-preview-desc="Donde las ideas se convierten en experiencias digitales premium y software a medida.">
                    <span class="nav-number">01</span>
                    <span class="nav-icon"><i class="fas fa-home"></i></span>
                    <span class="nav-text">Inicio</span>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </a>
                <a href="{{ route('services.index') }}" class="nav-link" 
                   data-preview-img="{{ $siteSettings->menu_img_services_url }}"
                   data-preview-title="Nuestras Soluciones"
                   data-preview-desc="Diseño web a medida, desarrollo de software premium, e-commerce y marketing digital.">
                    <span class="nav-number">02</span>
                    <span class="nav-icon"><i class="fas fa-layer-group"></i></span>
                    <span class="nav-text">Servicios</span>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </a>
                <a href="{{ route('projects.index') }}" class="nav-link" 
                   data-preview-img="{{ $siteSettings->menu_img_projects_url }}"
                   data-preview-title="Casos de Éxito"
                   data-preview-desc="Explora nuestra galería de proyectos premium desarrollados para impulsar marcas a nivel global.">
                    <span class="nav-number">03</span>
                    <span class="nav-icon"><i class="fas fa-briefcase"></i></span>
                    <span class="nav-text">Portafolio</span>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </a>
                <a href="{{ route('blog.index') }}" class="nav-link" 
                   data-preview-img="{{ $siteSettings->menu_img_blog_url }}"
                   data-preview-title="Ideas y Tendencias"
                   data-preview-desc="Artículos, tutoriales e insights sobre tecnología, diseño UI/UX y el futuro del desarrollo web.">
                    <span class="nav-number">04</span>
                    <span class="nav-icon"><i class="fas fa-newspaper"></i></span>
                    <span class="nav-text">Blog</span>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </a>
                <a href="{{ route('contact.index') }}" class="nav-link" 
                   data-preview-img="{{ $siteSettings->menu_img_contact_url }}"
                   data-preview-title="Inicia tu Proyecto"
                   data-preview-desc="Hablemos sobre tu visión. Nuestro equipo de expertos está listo para darle vida a tus ideas digitales.">
                    <span class="nav-number">05</span>
                    <span class="nav-icon"><i class="fas fa-paper-plane"></i></span>
                    <span class="nav-text">Contacto</span>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </a>
            </nav>

            {{-- Columna Derecha: Tarjeta de Visualización Interactiva e Información --}}
            <div class="fs-nav-right">
                {{-- Tarjeta de Previsualización Interactiva (Hidden on Mobile/Tablet) --}}
                <div class="fs-nav-preview-card">
                    <div class="fs-nav-preview-img-wrap">
                        <div class="fs-nav-preview-img" id="fsNavPreviewImg" style="background-image: url('{{ $siteSettings->menu_img_home_url }}');"></div>
                    </div>
                    <div class="fs-nav-preview-content">
                        <span class="fs-nav-preview-badge" id="fsNavPreviewBadge">CreativeUp</span>
                        <h4 class="fs-nav-preview-title" id="fsNavPreviewTitle">CreativeUp Studio</h4>
                        <p class="fs-nav-preview-desc" id="fsNavPreviewDesc">Donde las ideas se convierten en experiencias digitales premium y software a medida.</p>
                    </div>
                </div>

                {{-- Grid de Información de Contacto (Modern Cards) --}}
                <div class="fs-nav-info-grid">
                    {{-- Tarjeta Hablemos --}}
                    <div class="info-card">
                        <span class="info-card-title"><i class="fas fa-comments"></i> Hablemos</span>
                        <div class="info-card-links">
                            <a href="mailto:{{ $siteSettings->email }}">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $siteSettings->email }}</span>
                            </a>
                            <a href="tel:{{ $siteSettings->phone }}">
                                <i class="fas fa-phone-alt"></i>
                                <span>{{ $siteSettings->phone }}</span>
                            </a>
                            <a href="{{ $siteSettings->whatsapp_url }}" target="_blank" class="whatsapp-badge">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp Directo</span>
                            </a>
                        </div>
                    </div>

                    {{-- Tarjeta Visítanos --}}
                    <div class="info-card">
                        <span class="info-card-title"><i class="fas fa-map-marker-alt"></i> Visítanos</span>
                        <div class="info-card-content">
                            <p class="address-text">
                                {!! nl2br(e($siteSettings->address)) !!}
                            </p>
                            <a href="{{ $siteSettings->maps_url }}" target="_blank" class="direction-btn">
                                <span>Cómo llegar</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Redes Sociales Sincronizadas (Idénticas al footer) --}}
                <div class="fs-nav-social-section">
                    <span class="social-section-title">Síguenos</span>
                    <div class="footer-social">
                        @if($siteSettings->facebook_url)
                            <a href="{{ $siteSettings->facebook_url }}" target="_blank" class="social-btn social-facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($siteSettings->instagram_url)
                            <a href="{{ $siteSettings->instagram_url }}" target="_blank" class="social-btn social-instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if($siteSettings->linkedin_url)
                            <a href="{{ $siteSettings->linkedin_url }}" target="_blank" class="social-btn social-linkedin" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if($siteSettings->twitter_url)
                            <a href="{{ $siteSettings->twitter_url }}" target="_blank" class="social-btn social-twitter" aria-label="Twitter">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        @endif
                        @if($siteSettings->github_url)
                            <a href="{{ $siteSettings->github_url }}" target="_blank" class="social-btn social-github" aria-label="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- ============================================
         FOOTER ULTRA MODERNO - Gradient Background
         ============================================ --}}
    <footer class="footer-ultra footer-light-theme">
        <div class="footer-bg">
            <div class="footer-gradient-orb orb-1"></div>
            <div class="footer-gradient-orb orb-2"></div>
            <div class="footer-grid-pattern"></div>
        </div>

        <div class="container">
            {{-- Footer CTA Banner (Tarjeta flotante premium) --}}
            <div class="footer-cta-card" data-aos="fade-up" data-aos-once="true">
                <div class="footer-cta-content">
                    <span class="footer-cta-subtitle">¿Tienes una gran idea en mente?</span>
                    <h3 class="footer-cta-title">Hagámosla realidad juntos</h3>
                </div>
                <div class="footer-cta-action">
                    <a href="{{ route('contact.index') }}" class="footer-cta-btn">
                        <span>Iniciar Proyecto</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Footer Top --}}
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <span class="logo-text">{{ $siteSettings->logo_text }}</span>
                        <span class="logo-gradient">{{ $siteSettings->logo_gradient_text }}</span>
                    </a>
                    <p class="footer-tagline">
                        {{ $siteSettings->footer_tagline }}
                    </p>
                    
                    {{-- Status Badge & Reloj Corporativo --}}
                    <div class="footer-meta-widgets">
                        <div class="footer-status-badge">
                            <span class="status-dot"></span>
                            <span class="status-text">{{ $siteSettings->status_text }}</span>
                        </div>
                        <div class="footer-clock" id="footerClockWidget" title="Hora local de nuestra oficina principal">
                            <i class="fa-regular fa-clock"></i>
                            <span id="footerClockTime">Cargando hora...</span>
                        </div>
                    </div>

                    <div class="footer-social">
                        @if($siteSettings->facebook_url)
                            <a href="{{ $siteSettings->facebook_url }}" target="_blank" class="social-btn social-facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($siteSettings->instagram_url)
                            <a href="{{ $siteSettings->instagram_url }}" target="_blank" class="social-btn social-instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if($siteSettings->linkedin_url)
                            <a href="{{ $siteSettings->linkedin_url }}" target="_blank" class="social-btn social-linkedin" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if($siteSettings->twitter_url)
                            <a href="{{ $siteSettings->twitter_url }}" target="_blank" class="social-btn social-twitter" aria-label="Twitter">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        @endif
                        @if($siteSettings->github_url)
                            <a href="{{ $siteSettings->github_url }}" target="_blank" class="social-btn social-github" aria-label="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="footer-links-grid">
                    <div class="footer-column">
                        <h4 class="column-title">Servicios</h4>
                        <ul class="column-list">
                            @php
                                $footerServices = \App\Models\Service::where('is_active', true)
                                    ->orderBy('order')
                                    ->take(5)
                                    ->get(['title','slug']);
                            @endphp
                            @forelse($footerServices as $svc)
                                <li><a href="{{ route('services.show', $svc->slug) }}">{{ $svc->title }}</a></li>
                            @empty
                                <li><a href="{{ route('services.index') }}">Ver todos los servicios</a></li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h4 class="column-title">Empresa</h4>
                        <ul class="column-list">
                            <li><a href="{{ route('about') }}">Sobre Nosotros</a></li>
                            <li><a href="{{ route('projects.index') }}">Portafolio</a></li>
                            <li><a href="{{ route('blog.index') }}">Blog y Noticias</a></li>
                            <li><a href="{{ route('contact.index') }}">Contacto Directo</a></li>
                            <li><a href="{{ route('careers') }}">Trabaja con Nosotros</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h4 class="column-title">Contacto</h4>
                        <ul class="column-contact-list">
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <a href="mailto:{{ $siteSettings->email }}">{{ $siteSettings->email }}</a>
                            </li>
                            <li>
                                <i class="fa-solid fa-phone"></i>
                                <a href="tel:{{ $siteSettings->phone }}">{{ $siteSettings->phone }}</a>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $siteSettings->address }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Footer Newsletter Showcase --}}
            @if($siteSettings->show_newsletter)
            <div class="footer-newsletter-showcase" data-aos="fade-up" data-aos-once="true">
                <div class="newsletter-showcase-info">
                    <span class="newsletter-showcase-badge">Boletín Mensual</span>
                    <h3 class="newsletter-showcase-title">Suscríbete a nuestro boletín</h3>
                    <p class="newsletter-showcase-desc">Recibe ideas frescas sobre diseño, código y tendencias digitales directamente en tu bandeja.</p>
                </div>
                <div class="newsletter-showcase-action">
                    <form class="newsletter-form-minimal-modern" id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="form-group-modern">
                            <input type="email" name="email" placeholder="Escribe tu correo electrónico..." class="newsletter-input-modern" required aria-label="Tu correo electrónico">
                            <button type="submit" class="newsletter-btn-modern" aria-label="Suscribirse">
                                <span>Suscribirse</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M4 10h12m0 0l-5-5m5 5l-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Footer Bottom --}}
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>&copy; {{ date('Y') }} CreativeUp. Todos los derechos reservados. Creatividad y Tecnología para tu negocio.</p>
                </div>
                <div class="footer-legal">
                    <a href="{{ route('legal.privacy') }}">Privacidad</a>
                    <span class="separator">•</span>
                    <a href="{{ route('legal.terms') }}">Términos</a>
                    <span class="separator">•</span>
                    <a href="{{ route('legal.cookies') }}">Cookies</a>
                </div>
            </div>
        </div>
        
        {{-- Reloj Corporativo Live Script --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateFooterClock() {
                    const timeEl = document.getElementById('footerClockTime');
                    if (!timeEl) return;
                    
                    const options = {
                        timeZone: '{{ $siteSettings->timezone }}',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    };
                    
                    const formatter = new Intl.DateTimeFormat('en-US', options);
                    const parts = formatter.formatToParts(new Date());
                    
                    let hour = '', minute = '', second = '', dayPeriod = '';
                    for (const part of parts) {
                        if (part.type === 'hour') hour = part.value;
                        else if (part.type === 'minute') minute = part.value;
                        else if (part.type === 'second') second = part.value;
                        else if (part.type === 'dayPeriod') dayPeriod = part.value;
                    }
                    
                    const tzName = '{{ $siteSettings->timezone }}'.split('/').pop().replace('_', ' ');
                    timeEl.textContent = `${hour}:${minute}:${second} ${dayPeriod.toUpperCase()} (${tzName})`;
                }
                
                updateFooterClock();
                setInterval(updateFooterClock, 1000);
            });
        </script>
    </footer>

    {{-- ============================================
         CHAT WIDGET FLOTANTE - Rediseñado v2.0
         ============================================ --}}
    @if($siteSettings->show_chat_widget)
    <div class="chat-widget" id="chatWidget" data-turbo-permanent>
        {{-- Header --}}
        <div class="chat-header">
            <div class="chat-avatar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 5C13.66 5 15 6.34 15 8C15 9.66 13.66 11 12 11C10.34 11 9 9.66 9 8C9 6.34 10.34 5 12 5ZM12 19.2C9.5 19.2 7.29 17.92 6 15.98C6.03 13.99 10 12.9 12 12.9C13.99 12.9 17.97 13.99 18 15.98C16.71 17.92 14.5 19.2 12 19.2Z" fill="white"/>
                </svg>
            </div>
            <div class="chat-info">
                <h4 class="chat-title">CreativeUp</h4>
                <p class="chat-status">
                    <svg width="8" height="8" viewBox="0 0 8 8" style="margin-right: 6px;">
                        <circle cx="4" cy="4" r="4" fill="#10b981"/>
                    </svg>
                    En línea ahora
                </p>
            </div>
            <button class="chat-close" id="chatClose">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="chat-body" id="chatBody">
            <div class="chat-welcome">
                <div class="welcome-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M20 3.33334C10.8 3.33334 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6667 20 36.6667C29.2 36.6667 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33334 20 3.33334ZM20 8.33334C22.7667 8.33334 25 10.5667 25 13.3333C25 16.1 22.7667 18.3333 20 18.3333C17.2334 18.3333 15 16.1 15 13.3333C15 10.5667 17.2334 8.33334 20 8.33334ZM20 32C15.8334 32 12.15 29.9 10 26.6333C10.05 23.3 16.6667 21.5 20 21.5C23.3167 21.5 29.95 23.3 30 26.6333C27.85 29.9 24.1667 32 20 32Z" fill="white"/>
                    </svg>
                </div>
                <h3>¡Hola! Bienvenido</h3>
                <p>¿En qué podemos ayudarte hoy?</p>
            </div>
            
            <div class="chat-message bot">
                <div class="message-avatar">UP</div>
                <div class="message-content">
                    <div class="message-bubble">
                        Hola! Soy el asistente de CreativeUp. Estoy aquí para ayudarte con cualquier consulta.
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="chat-footer">
            <form class="chat-form" id="chatForm">
                <input type="text" class="chat-input" id="chatInput" placeholder="Escribe tu mensaje..." autocomplete="off">
                <button type="submit" class="chat-send">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M18 2L9 11M18 2L12 18L9 11L2 8L18 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
            <p class="chat-disclaimer">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" style="margin-right: 6px;">
                    <path d="M6 0.5C3.1 0.5 0.75 2.85 0.75 5.75C0.75 8.65 3.1 11 6 11C8.9 11 11.25 8.65 11.25 5.75C11.25 2.85 8.9 0.5 6 0.5ZM6 2C6.69 2 7.25 2.56 7.25 3.25C7.25 3.94 6.69 4.5 6 4.5C5.31 4.5 4.75 3.94 4.75 3.25C4.75 2.56 5.31 2 6 2ZM7.5 8.5H4.5V7.75H5.25V5.75H4.75V5H6.75V7.75H7.5V8.5Z"/>
                </svg>
                Conversación segura y privada
            </p>
        </div>
    </div>

    {{-- Botón Flotante --}}
    <button class="chat-trigger" id="chatTrigger" data-turbo-permanent>
        <span class="trigger-icon trigger-icon-open">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M24.5 14C24.5 19.799 19.799 24.5 14 24.5C12.0326 24.5 10.1968 23.9635 8.63245 23.0368L3.5 24.5L4.96325 19.3675C4.03654 17.8032 3.5 15.9674 3.5 14C3.5 8.20101 8.20101 3.5 14 3.5C19.799 3.5 24.5 8.20101 24.5 14Z" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="10" cy="14" r="1.5" fill="white"/>
                <circle cx="14" cy="14" r="1.5" fill="white"/>
                <circle cx="18" cy="14" r="1.5" fill="white"/>
            </svg>
        </span>
        <span class="trigger-icon trigger-icon-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M18 6L6 18M6 6L18 18" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </span>
        <span class="trigger-badge" style="display: none;">1</span>
    </button>
    @endif

    {{-- Scroll to Top Button --}}
    <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M10 15V5m0 0l-5 5m5-5l5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    {{-- Banner de Consentimiento de Cookies --}}
    <div id="cookieConsentBanner" class="cookie-banner" style="display: none;">
        <div class="cookie-banner-content">
            <div class="cookie-banner-text">
                <i class="fa-solid fa-cookie-bite cookie-icon"></i>
                <p>
                    Utilizamos cookies para ofrecerte la mejor experiencia de navegación y analizar el tráfico del sitio. Consulta nuestra <a href="{{ route('legal.cookies') }}">Política de Cookies</a> y <a href="{{ route('legal.privacy') }}">Política de Privacidad</a>.
                </p>
            </div>
            <div class="cookie-banner-actions">
                <button type="button" id="btnRejectCookies" class="cookie-btn cookie-btn-outline">Solo necesarias</button>
                <button type="button" id="btnAcceptCookies" class="cookie-btn cookie-btn-primary">Aceptar todas</button>
            </div>
        </div>
    </div>

    <style>
        .cookie-banner {
            position: fixed;
            bottom: 24px;
            left: 24px;
            right: 24px;
            max-width: 900px;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 1.25rem 1.75rem;
            z-index: 99999;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            animation: cookieSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes cookieSlideUp {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .cookie-banner-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .cookie-banner-text {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 280px;
        }
        .cookie-icon {
            font-size: 1.8rem;
            color: #ff006e;
            flex-shrink: 0;
        }
        .cookie-banner-text p {
            margin: 0;
            color: #e2e8f0;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .cookie-banner-text a {
            color: #ff006e;
            text-decoration: underline;
            font-weight: 600;
        }
        .cookie-banner-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }
        .cookie-btn {
            padding: 0.65rem 1.35rem;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            border: none;
        }
        .cookie-btn-primary {
            background: linear-gradient(135deg, #ff006e, #8338ec);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(255, 0, 110, 0.3);
        }
        .cookie-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 0, 110, 0.5);
        }
        .cookie-btn-outline {
            background: transparent;
            color: #94a3b8;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .cookie-btn-outline:hover {
            color: #ffffff;
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }
        @media (max-width: 640px) {
            .cookie-banner { bottom: 12px; left: 12px; right: 12px; padding: 1rem 1.25rem; }
            .cookie-banner-actions { width: 100%; justify-content: flex-end; }
            .cookie-btn { flex: 1; text-align: center; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const banner = document.getElementById('cookieConsentBanner');
            const btnAccept = document.getElementById('btnAcceptCookies');
            const btnReject = document.getElementById('btnRejectCookies');

            function sendConsentToServer(type) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const ua = navigator.userAgent || '';

                // ── Device Type ──────────────────────────
                let deviceType = 'Desktop';
                if (/Mobi|Android/i.test(ua)) deviceType = 'Mobile';
                else if (/Tablet|iPad/i.test(ua)) deviceType = 'Tablet';

                // ── Browser ───────────────────────────────
                let browser = 'Otros';
                if (ua.includes('Firefox')) browser = 'Firefox';
                else if (ua.includes('Edg')) browser = 'Edge';
                else if (ua.includes('Chrome')) browser = 'Chrome';
                else if (ua.includes('Safari')) browser = 'Safari';

                // ── Operating System ──────────────────────
                let os = 'Desconocido';
                if (ua.includes('Win')) os = 'Windows';
                else if (ua.includes('Mac')) os = 'macOS';
                else if (ua.includes('Linux')) os = 'Linux';
                else if (ua.includes('Android')) os = 'Android';
                else if (ua.includes('iPhone') || ua.includes('iPad')) os = 'iOS';

                // ── Hardware: CPU Cores (logical) ─────────
                const cpuCores = (navigator.hardwareConcurrency || 'N/A') + ' núcleos';

                // ── Hardware: Device RAM ──────────────────
                const deviceMemory = navigator.deviceMemory
                    ? (navigator.deviceMemory + ' GB RAM')
                    : 'N/A';

                // ── Network: Connection Type ──────────────
                const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
                const connectionType = connection
                    ? (connection.effectiveType || connection.type || 'N/A')
                    : 'N/A';

                // ── Touch Points ──────────────────────────
                const touchPoints = navigator.maxTouchPoints !== undefined
                    ? (navigator.maxTouchPoints + ' touch points')
                    : 'N/A';

                // ── GPU / WebGL Renderer ──────────────────
                let gpuRenderer = 'N/A';
                try {
                    const canvas = document.createElement('canvas');
                    const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
                    if (gl) {
                        const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
                        if (debugInfo) {
                            gpuRenderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL) || 'N/A';
                        }
                    }
                } catch(e) {}

                // ── Canvas Fingerprint (rendering signature) ──
                let canvasHash = 'N/A';
                try {
                    const c = document.createElement('canvas');
                    c.width = 200; c.height = 50;
                    const ctx = c.getContext('2d');
                    ctx.textBaseline = 'top';
                    ctx.font = "14px 'Arial'";
                    ctx.fillStyle = '#f60';
                    ctx.fillRect(125, 1, 62, 20);
                    ctx.fillStyle = '#069';
                    ctx.fillText('CreativeUP🛡️', 2, 15);
                    ctx.fillStyle = 'rgba(102,204,0,0.7)';
                    ctx.fillText('CreativeUP🛡️', 4, 17);
                    canvasHash = c.toDataURL().slice(-32);
                } catch(e) {}

                // ── Hardware Fingerprint (combina todas las señales) ──
                const fingerprintRaw = [
                    ua.substring(0, 50),
                    navigator.hardwareConcurrency || '',
                    navigator.deviceMemory || '',
                    navigator.maxTouchPoints || '',
                    window.screen.width + 'x' + window.screen.height,
                    window.screen.colorDepth || '',
                    navigator.language || '',
                    gpuRenderer.substring(0, 60),
                    canvasHash,
                    Intl.DateTimeFormat().resolvedOptions().timeZone || ''
                ].join('|');

                // Simple hash for fingerprint display (non-crypto, fast)
                let fingerprintHash = 0;
                for (let i = 0; i < fingerprintRaw.length; i++) {
                    const char = fingerprintRaw.charCodeAt(i);
                    fingerprintHash = ((fingerprintHash << 5) - fingerprintHash) + char;
                    fingerprintHash = fingerprintHash & fingerprintHash;
                }
                const hardware_fingerprint = Math.abs(fingerprintHash).toString(16).toUpperCase().padStart(8, '0');

                const auditData = {
                    consent_type:         type,
                    hardware_fingerprint: hardware_fingerprint,
                    device_type:          deviceType,
                    browser:              browser,
                    os:                   os,
                    cpu_cores:            cpuCores,
                    device_memory:        deviceMemory,
                    connection_type:      connectionType,
                    touch_points:         touchPoints,
                    screen_resolution:    window.screen ? (window.screen.width + 'x' + window.screen.height) : null,
                    language:             navigator.language || navigator.userLanguage || null,
                    page_url:             window.location.href,
                    timezone:             Intl.DateTimeFormat().resolvedOptions().timeZone || null
                };

                fetch('{{ route('legal.cookie-consent') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(auditData)
                }).catch(function(err) {
                    console.error('Error registrando consentimiento:', err);
                });
            }

            /**
             * Lógica del Banner de Cookies:
             * - Si el admin elimina el registro de la BD, el banner vuelve a aparecer
             *   aunque el localStorage diga "ya acepté". Esto garantiza que el
             *   consentimiento en la BD sea siempre la fuente de verdad.
             */
            function showBannerDelayed() {
                setTimeout(function() {
                    if (banner) banner.style.display = 'block';
                }, 1000);
            }

            function initCookieBanner() {
                const localChoice = localStorage.getItem('cookie_consent_choice');

                if (!localChoice) {
                    // Sin decisión local → mostrar banner directamente
                    showBannerDelayed();
                } else {
                    // Tiene decisión local → verificar si el registro sigue en la BD
                    fetch('{{ route('legal.check-consent') }}', {
                        method: 'GET',
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (!data.consented) {
                            // El admin eliminó el registro → limpiar y mostrar banner
                            localStorage.removeItem('cookie_consent_choice');
                            showBannerDelayed();
                        }
                        // Si data.consented === true → banner no se muestra (ya registrado)
                    })
                    .catch(function() {
                        // Si falla el servidor → no mostrar banner (comportamiento no invasivo)
                    });
                }
            }

            initCookieBanner();

            if (btnAccept) {
                btnAccept.addEventListener('click', function() {
                    localStorage.setItem('cookie_consent_choice', 'all');
                    if (banner) banner.style.display = 'none';
                    sendConsentToServer('all');
                });
            }

            if (btnReject) {
                btnReject.addEventListener('click', function() {
                    localStorage.setItem('cookie_consent_choice', 'essential');
                    if (banner) banner.style.display = 'none';
                    sendConsentToServer('essential');
                });
            }
        });
    </script>

    {{-- AOS Animation Library --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    @stack('scripts')
</body>
</html>
