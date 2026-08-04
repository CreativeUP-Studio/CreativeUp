<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | CreativeUP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        /* ═══════════════════════════════════════════════════
           GLOBAL COLOR SCHEME & BROWSER CURSOR VISIBILITY OVERRIDES
           ═══════════════════════════════════════════════════ */
        
        /* Force color-scheme at the document level */
        html, body.admin-body {
            color-scheme: light !important;
        }
        body.admin-body[data-theme="dark"] {
            color-scheme: dark !important;
        }
        
        /* Force color-scheme directly on the inputs to adjust the text selection mouse pointer (I-beam hover cursor) */
        body:not([data-theme="dark"]) input,
        body:not([data-theme="dark"]) textarea,
        body:not([data-theme="dark"]) select,
        body:not([data-theme="dark"]) .admin-form-input,
        body:not([data-theme="dark"]) .admin-form-textarea,
        body:not([data-theme="dark"]) .admin-form-select,
        body:not([data-theme="dark"]) .pf-input,
        body:not([data-theme="dark"]) .pf-textarea,
        body:not([data-theme="dark"]) .pf-select,
        body:not([data-theme="dark"]) .leads-search-input,
        body:not([data-theme="dark"]) .leads-filter-select,
        body:not([data-theme="dark"]) .global-search-input,
        body:not([data-theme="dark"]) .svc-search-input {
            color-scheme: light !important;
        }

        body[data-theme="dark"] input,
        body[data-theme="dark"] textarea,
        body[data-theme="dark"] select,
        body[data-theme="dark"] .admin-form-input,
        body[data-theme="dark"] .admin-form-textarea,
        body[data-theme="dark"] .admin-form-select,
        body[data-theme="dark"] .pf-input,
        body[data-theme="dark"] .pf-textarea,
        body[data-theme="dark"] .pf-select,
        body[data-theme="dark"] .leads-search-input,
        body[data-theme="dark"] .leads-filter-select,
        body[data-theme="dark"] .global-search-input,
        body[data-theme="dark"] .svc-search-input {
            color-scheme: dark !important;
        }
        
        /* Force a high-contrast custom SVG text cursor to prevent invisible browser I-beam bugs on hover */
        input:not([type="submit"]):not([type="button"]):not([type="image"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="range"]):not([type="color"]), 
        textarea,
        .admin-form-input, .admin-form-textarea, .admin-post-title-input, .admin-post-content-editor, .admin-search-input-modern, .admin-textarea-modern,
        .pf-input, .pf-textarea, .leads-search-input, .global-search-input, .svc-search-input {
            cursor: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPScyNCcgaGVpZ2h0PScyNCcgdmlld0JveD0nMCAwIDI0IDI0Jz48cGF0aCBkPSdNMTIgNHYxNk04IDRoOE04IDIwaDgnIHN0cm9rZT0nd2hpdGUnIHN0cm9rZS13aWR0aD0nMycgc3Ryb2tlLWxpbmVjYXA9J3JvdW5kJyBzdHJva2UtbGluZWpvaW49J3JvdW5kJy8+PHBhdGggZD0nTTEyIDR2MTZNOCA0aDhNOCAyMGg4JyBzdHJva2U9JyMxYTFhMmUnIHN0cm9rZT0nd2hpdGUnIHN0cm9rZS13aWR0aD0nMS41JyBzdHJva2UtbGluZWNhcD0ncm91bmQnIHN0cm9rZS1saW5lam9pbj0ncm91bmQnLz48L3N2Zz4=') 12 12, text !important;
        }

        /* Ensure the text caret (vertical blinking line) is always the brand's pink color for high contrast and style */
        input, textarea, select, 
        .admin-form-input, .admin-form-textarea, .admin-form-select,
        .admin-post-title-input, .admin-post-content-editor,
        .admin-search-input-modern, .admin-filter-select-modern, .admin-textarea-modern,
        .hero-form-control, .pf-input, .pf-textarea, .pf-select,
        .leads-search-input, .leads-filter-select, .global-search-input,
        .svc-search-input {
            caret-color: var(--admin-primary, #ff006e) !important;
        }

        /* Prevent parent container white text inheritance in light mode */
        body:not([data-theme="dark"]) input, 
        body:not([data-theme="dark"]) textarea, 
        body:not([data-theme="dark"]) select,
        body:not([data-theme="dark"]) .admin-form-input,
        body:not([data-theme="dark"]) .admin-form-textarea,
        body:not([data-theme="dark"]) .admin-form-select,
        body:not([data-theme="dark"]) .admin-post-title-input,
        body:not([data-theme="dark"]) .admin-post-content-editor,
        body:not([data-theme="dark"]) .admin-search-input-modern,
        body:not([data-theme="dark"]) .admin-filter-select-modern,
        body:not([data-theme="dark"]) .admin-textarea-modern,
        body:not([data-theme="dark"]) .hero-form-control,
        body:not([data-theme="dark"]) .pf-input,
        body:not([data-theme="dark"]) .pf-textarea,
        body:not([data-theme="dark"]) .pf-select,
        body:not([data-theme="dark"]) .leads-search-input,
        body:not([data-theme="dark"]) .leads-filter-select,
        body:not([data-theme="dark"]) .global-search-input,
        body:not([data-theme="dark"]) .svc-search-input {
            color: #1a1a2e !important;
        }
        
        body:not([data-theme="dark"]) input:hover, 
        body:not([data-theme="dark"]) textarea:hover, 
        body:not([data-theme="dark"]) select:hover,
        body:not([data-theme="dark"]) .admin-form-input:hover,
        body:not([data-theme="dark"]) .admin-form-textarea:hover,
        body:not([data-theme="dark"]) .admin-form-select:hover,
        body:not([data-theme="dark"]) .admin-post-title-input:hover,
        body:not([data-theme="dark"]) .admin-post-content-editor:hover,
        body:not([data-theme="dark"]) .admin-search-input-modern:hover,
        body:not([data-theme="dark"]) .admin-filter-select-modern:hover,
        body:not([data-theme="dark"]) .admin-textarea-modern:hover,
        body:not([data-theme="dark"]) .hero-form-control:hover,
        body:not([data-theme="dark"]) .pf-input:hover,
        body:not([data-theme="dark"]) .pf-textarea:hover,
        body:not([data-theme="dark"]) .pf-select:hover,
        body:not([data-theme="dark"]) .leads-search-input:hover,
        body:not([data-theme="dark"]) .leads-filter-select:hover,
        body:not([data-theme="dark"]) .global-search-input:hover,
        body:not([data-theme="dark"]) .svc-search-input:hover {
            color: #1a1a2e !important;
        }

        body:not([data-theme="dark"]) input:focus, 
        body:not([data-theme="dark"]) textarea:focus, 
        body:not([data-theme="dark"]) select:focus,
        body:not([data-theme="dark"]) .admin-form-input:focus,
        body:not([data-theme="dark"]) .admin-form-textarea:focus,
        body:not([data-theme="dark"]) .admin-form-select:focus,
        body:not([data-theme="dark"]) .admin-post-title-input:focus,
        body:not([data-theme="dark"]) .admin-post-content-editor:focus,
        body:not([data-theme="dark"]) .admin-search-input-modern:focus,
        body:not([data-theme="dark"]) .admin-filter-select-modern:focus,
        body:not([data-theme="dark"]) .admin-textarea-modern:focus,
        body:not([data-theme="dark"]) .hero-form-control:focus,
        body:not([data-theme="dark"]) .pf-input:focus,
        body:not([data-theme="dark"]) .pf-textarea:focus,
        body:not([data-theme="dark"]) .pf-select:focus,
        body:not([data-theme="dark"]) .leads-search-input:focus,
        body:not([data-theme="dark"]) .leads-filter-select:focus,
        body:not([data-theme="dark"]) .global-search-input:focus,
        body:not([data-theme="dark"]) .svc-search-input:focus {
            color: #1a1a2e !important;
        }
    </style>
</head>
<body class="admin-body" data-sidebar-collapsed="false">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         SIDEBAR - Professional Redesign
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <aside class="admin-sidebar" id="adminSidebar">
        {{-- ─────────────────────────────────────────────────────────────────────────
             Brand Header
             ───────────────────────────────────────────────────────────────────────── --}}
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-premium" onclick="if(document.body.getAttribute('data-sidebar-collapsed') === 'true') { event.preventDefault(); toggleSidebarCollapse(); }">
                <span class="brand-text">creative</span>
                <span class="brand-gradient">up</span>
                <div class="brand-dot"></div>
            </a>
            <button class="sidebar-collapse-btn" id="sidebarCollapseBtn" onclick="toggleSidebarCollapse()" 
                    aria-label="Colapsar sidebar" title="Colapsar menú">
                <i class="fa-solid fa-angles-left" id="collapseIcon" aria-hidden="true"></i>
            </button>
        </div>

        {{-- ─────────────────────────────────────────────────────────────────────────
             Quick Actions
             ───────────────────────────────────────────────────────────────────────── --}}
        <div class="sidebar-quick-actions">
            <a href="{{ route('admin.projects.create') }}" class="sidebar-quick-btn" title="Nuevo Proyecto">
                <i class="fa-solid fa-folder-plus" aria-hidden="true"></i>
                <span>Nuevo Proyecto</span>
            </a>
            <a href="{{ route('admin.posts.create') }}" class="sidebar-quick-btn" title="Nuevo Post">
                <i class="fa-solid fa-file-pen" aria-hidden="true"></i>
                <span>Nuevo Post</span>
            </a>
        </div>

        {{-- ─────────────────────────────────────────────────────────────────────────
             Navigation
             ───────────────────────────────────────────────────────────────────────── --}}
        <nav class="sidebar-nav" role="navigation" aria-label="Navegación principal">
            {{-- Principal Section --}}
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-section-title">
                    <i class="fa-solid fa-grip" aria-hidden="true"></i>
                    <span>Principal</span>
                </span>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Dashboard</span>
                <span class="sidebar-nav-badge sidebar-nav-badge--new" style="display: none;">Nuevo</span>
            </a>

            {{-- Contenido Section --}}
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-section-title">
                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                    <span>Contenido</span>
                </span>
            </div>
            <a href="{{ route('admin.services.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Servicios</span>
                @php $servicesCount = \App\Models\Service::count(); @endphp
                @if($servicesCount > 0)
                <span class="sidebar-nav-count">{{ $servicesCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.projects.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-diagram-project" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Proyectos</span>
                @php $projectsCount = \App\Models\Project::count(); @endphp
                @if($projectsCount > 0)
                <span class="sidebar-nav-count">{{ $projectsCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.posts.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Blog / Posts</span>
                @php $postsCount = \App\Models\Post::where('status', 'draft')->count(); @endphp
                @if($postsCount > 0)
                <span class="sidebar-nav-badge sidebar-nav-badge--warning">{{ $postsCount }} draft</span>
                @endif
            </a>
            <a href="{{ route('admin.job-offers.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.job-offers.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Trabajos / Vacantes</span>
                @php $jobsCount = \App\Models\JobOffer::where('is_active', true)->count(); @endphp
                @if($jobsCount > 0)
                <span class="sidebar-nav-count">{{ $jobsCount }}</span>
                @endif
            </a>

            {{-- CRM Section --}}
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-section-title">
                    <i class="fa-solid fa-chart-pie" aria-hidden="true"></i>
                    <span>CRM</span>
                </span>
            </div>
            <a href="{{ route('admin.leads.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Leads</span>
                @php $newLeadsCount = \App\Models\Lead::where('status', 'nuevo')->count(); @endphp
                @if($newLeadsCount > 0)
                <span class="sidebar-nav-badge sidebar-nav-badge--success">{{ $newLeadsCount }} nuevos</span>
                @endif
            </a>
            <a href="{{ route('admin.chat.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-comments" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Mensajes Chat</span>
                @php $newChatCount = \App\Models\ChatMessage::unread()->count(); @endphp
                @if($newChatCount > 0)
                <span class="sidebar-nav-badge sidebar-nav-badge--primary">{{ $newChatCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.cookie-consents.index') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.cookie-consents.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Auditoría IPs & Cookies</span>
                @php $consentTodayCount = \App\Models\CookieConsent::whereDate('accepted_at', now())->count(); @endphp
                @if($consentTodayCount > 0)
                <span class="sidebar-nav-badge sidebar-nav-badge--success">+{{ $consentTodayCount }} hoy</span>
                @endif
            </a>

            {{-- Configuración Section --}}
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-section-title">
                    <i class="fa-solid fa-gear" aria-hidden="true"></i>
                    <span>Sistema</span>
                </span>
            </div>
            <a href="{{ route('admin.hero.edit') }}"
               class="sidebar-nav-item {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Hero del Home</span>
                <span class="sidebar-nav-badge sidebar-nav-badge--primary" style="font-size: 0.65rem;">Nuevo</span>
            </a>
            <button class="sidebar-nav-item sidebar-nav-submenu-toggle" 
                    onclick="toggleSubmenu(this)" aria-expanded="false">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Configuración</span>
                <i class="fa-solid fa-chevron-down sidebar-nav-arrow" aria-hidden="true"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('admin.settings.edit') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gears" aria-hidden="true"></i>
                    <span>Detalles del Sitio</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="sidebar-submenu-item">
                    <i class="fa-solid fa-globe" aria-hidden="true"></i>
                    <span>Ver Sitio Web</span>
                    <i class="fa-solid fa-external-link" aria-hidden="true"></i>
                </a>
                <a href="#" class="sidebar-submenu-item" onclick="clearCache()">
                    <i class="fa-solid fa-broom" aria-hidden="true"></i>
                    <span>Limpiar Caché</span>
                </a>
            </div>
        </nav>

        {{-- ─────────────────────────────────────────────────────────────────────────
             Sidebar Footer - User Profile
             ───────────────────────────────────────────────────────────────────────── --}}
        <div class="sidebar-footer">
            {{-- Storage Usage Mini-Widget --}}
            <div class="sidebar-storage-widget">
                <div class="sidebar-storage-header">
                    <i class="fa-solid fa-database" aria-hidden="true"></i>
                    <span>Almacenamiento</span>
                </div>
                <div class="sidebar-storage-bar">
                    <div class="sidebar-storage-fill" style="width: 35%;"></div>
                </div>
                <span class="sidebar-storage-text">3.5 GB de 10 GB</span>
            </div>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div class="admin-sidebar-overlay" id="adminOverlay" onclick="closeSidebar()" aria-hidden="true"></div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MAIN CONTENT AREA
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="admin-main">
        {{-- ─────────────────────────────────────────────────────────────────────────
             TOPBAR - Professional Redesign
             ───────────────────────────────────────────────────────────────────────── --}}
        <header class="admin-topbar" role="banner">
            <div class="topbar-left">
                {{-- Mobile Toggle --}}
                <button class="topbar-toggle" onclick="toggleSidebar()" aria-label="Abrir menú">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>

                {{-- Breadcrumb --}}
                <nav class="topbar-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}" class="topbar-breadcrumb-item">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                    </a>
                    <span class="topbar-breadcrumb-separator">/</span>
                    <span class="topbar-breadcrumb-current">@yield('page-title', 'Dashboard')</span>
                </nav>

                {{-- Page Title --}}
                <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="topbar-right">
                {{-- Global Search --}}
                <div class="topbar-search">
                    <button class="topbar-search-btn" onclick="openGlobalSearch()" title="Buscar (Ctrl+K)">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <span class="topbar-search-text">Buscar...</span>
                        <kbd class="topbar-search-shortcut">⌘K</kbd>
                    </button>
                </div>

                {{-- Quick Actions --}}
                <div class="topbar-actions">
                    {{-- Theme Toggle --}}
                    <button class="topbar-action-btn" onclick="toggleTheme()" title="Cambiar tema">
                        <i class="fa-solid fa-moon" id="themeIcon" aria-hidden="true"></i>
                    </button>

                    {{-- Notifications --}}
                    <div class="topbar-dropdown">
                        <button class="topbar-action-btn topbar-notifications-btn" onclick="toggleNotifications()" 
                                aria-label="Notificaciones" aria-expanded="false">
                            <i class="fa-solid fa-bell" aria-hidden="true"></i>
                            @php 
                                $chatUnreadCount = \App\Models\ChatMessage::unread()->count();
                                $leadsCount = \App\Models\Lead::where('status', 'nuevo')->count();
                                $totalNotifications = $chatUnreadCount + $leadsCount;
                            @endphp
                            @if($totalNotifications > 0)
                            <span class="topbar-notification-badge">{{ $totalNotifications > 9 ? '9+' : $totalNotifications }}</span>
                            @endif
                        </button>
                        <div class="topbar-dropdown-menu topbar-notifications-menu" id="notificationsMenu">
                            <div class="topbar-dropdown-header">
                                <span class="topbar-dropdown-title">Notificaciones</span>
                                <button class="topbar-dropdown-action" onclick="markAllAsRead()">Marcar todas leídas</button>
                            </div>
                            <div class="topbar-dropdown-body" id="notificationsBody">
                                @php
                                    $recentChatMessages = \App\Models\ChatMessage::select('conversation_id', 'name', 'email', 'message', 'created_at')
                                        ->where('sender', 'user')
                                        ->where('is_read', false)
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                
                                @if($chatUnreadCount > 0)
                                    @foreach($recentChatMessages as $chatMsg)
                                    <a href="{{ route('admin.chat.show', $chatMsg->conversation_id) }}" class="topbar-notification-item topbar-notification-item--unread">
                                        <div class="topbar-notification-icon topbar-notification-icon--primary">
                                            <i class="fa-solid fa-comment" aria-hidden="true"></i>
                                        </div>
                                        <div class="topbar-notification-content">
                                            <p class="topbar-notification-text"><strong>{{ $chatMsg->name }}</strong> te envió un mensaje</p>
                                            <span class="topbar-notification-time">{{ $chatMsg->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                    @endforeach
                                @endif
                                
                                @if($leadsCount > 0)
                                <a href="{{ route('admin.leads.index') }}" class="topbar-notification-item topbar-notification-item--unread">
                                    <div class="topbar-notification-icon topbar-notification-icon--success">
                                        <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                                    </div>
                                    <div class="topbar-notification-content">
                                        <p class="topbar-notification-text">Tienes <strong>{{ $leadsCount }} leads nuevos</strong></p>
                                        <span class="topbar-notification-time">Revisa el CRM</span>
                                    </div>
                                </a>
                                @endif
                                
                                @if($totalNotifications === 0)
                                <div class="topbar-notification-empty">
                                    <i class="fa-solid fa-bell-slash" aria-hidden="true"></i>
                                    <p>No hay notificaciones</p>
                                </div>
                                @endif
                            </div>
                            <div class="topbar-dropdown-footer">
                                <a href="{{ route('admin.chat.index') }}">Ver todos los mensajes</a>
                            </div>
                        </div>
                    </div>

                    {{-- Help --}}
                    <button class="topbar-action-btn" onclick="openHelpPanel()" title="Ayuda">
                        <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                    </button>
                </div>

                {{-- Divider --}}
                <div class="topbar-divider"></div>

                {{-- User Quick Menu --}}
                <div class="topbar-user-menu">
                    <button class="topbar-user-btn" onclick="toggleUserDropdown()" aria-expanded="false">
                        <div class="topbar-user-avatar">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="topbar-user-info">
                            <span class="topbar-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <span class="topbar-user-role">Admin</span>
                        </div>
                        <i class="fa-solid fa-chevron-down topbar-user-arrow" aria-hidden="true"></i>
                    </button>
                    <div class="topbar-dropdown-menu topbar-user-dropdown" id="userDropdown">
                        <div class="topbar-dropdown-body">
                            <a href="{{ route('admin.profile.edit') }}" class="topbar-dropdown-item">
                                <i class="fa-solid fa-user" aria-hidden="true"></i>
                                <span>Mi Perfil</span>
                            </a>
                            <a href="{{ route('admin.profile.edit') }}" class="topbar-dropdown-item">
                                <i class="fa-solid fa-gear" aria-hidden="true"></i>
                                <span>Configuración</span>
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="topbar-dropdown-item">
                                <i class="fa-solid fa-globe" aria-hidden="true"></i>
                                <span>Ver Sitio Web</span>
                                <i class="fa-solid fa-external-link" style="margin-left: auto; font-size: 0.75rem; opacity: 0.5;" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="topbar-dropdown-footer">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="topbar-dropdown-item topbar-dropdown-item--danger">
                                    <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ─────────────────────────────────────────────────────────────────────────
             Content Area
             ───────────────────────────────────────────────────────────────────────── --}}
        <main class="admin-content" role="main">
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="admin-alert admin-alert-success" role="alert">
                    <div class="admin-alert-icon">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    </div>
                    <div class="admin-alert-content">
                        <p class="admin-alert-title">¡Éxito!</p>
                        <p class="admin-alert-message">{{ session('success') }}</p>
                    </div>
                    <button class="admin-alert-close" onclick="this.parentElement.remove()" aria-label="Cerrar">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif

            {{-- Error Alert --}}
            @if(session('error'))
                <div class="admin-alert admin-alert-danger" role="alert">
                    <div class="admin-alert-icon">
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    </div>
                    <div class="admin-alert-content">
                        <p class="admin-alert-title">Error</p>
                        <p class="admin-alert-message">{{ session('error') }}</p>
                    </div>
                    <button class="admin-alert-close" onclick="this.parentElement.remove()" aria-label="Cerrar">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="admin-alert admin-alert-danger" role="alert">
                    <div class="admin-alert-icon">
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                    </div>
                    <div class="admin-alert-content">
                        <p class="admin-alert-title">Por favor corrige los siguientes errores:</p>
                        <ul class="admin-alert-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="admin-alert-close" onclick="this.parentElement.remove()" aria-label="Cerrar">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </main>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         GLOBAL SEARCH MODAL
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <div class="global-search-modal" id="globalSearchModal">
        <div class="global-search-backdrop" onclick="closeGlobalSearch()"></div>
        <div class="global-search-container">
            <div class="global-search-header">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="text" class="global-search-input" id="globalSearchInput" 
                       placeholder="Buscar proyectos, posts, leads..." autocomplete="off">
                <kbd class="global-search-esc">ESC</kbd>
            </div>
            <div class="global-search-body" id="globalSearchResults">
                <div class="global-search-shortcuts">
                    <p class="global-search-shortcuts-title">Accesos Rápidos</p>
                    <div class="global-search-shortcuts-grid">
                        <a href="{{ route('admin.projects.create') }}" class="global-search-shortcut">
                            <i class="fa-solid fa-folder-plus" aria-hidden="true"></i>
                            <span>Nuevo Proyecto</span>
                        </a>
                        <a href="{{ route('admin.posts.create') }}" class="global-search-shortcut">
                            <i class="fa-solid fa-file-pen" aria-hidden="true"></i>
                            <span>Nuevo Post</span>
                        </a>
                        <a href="{{ route('admin.leads.index') }}" class="global-search-shortcut">
                            <i class="fa-solid fa-users" aria-hidden="true"></i>
                            <span>Ver Leads</span>
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="global-search-shortcut">
                            <i class="fa-solid fa-globe" aria-hidden="true"></i>
                            <span>Ver Sitio</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         JAVASCRIPT
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <script>
    // ═══════════════════════════════════════════════════════════════════════════
    // Sidebar Toggle (Mobile)
    // ═══════════════════════════════════════════════════════════════════════════
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');

        if (window.innerWidth <= 1024) {
            sidebar.classList.toggle('open');
            overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');

        sidebar.classList.remove('open');
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // Sidebar Collapse (Desktop)
    // ═══════════════════════════════════════════════════════════════════════════
    function toggleSidebarCollapse() {
        const body = document.body;
        const btn = document.getElementById('sidebarCollapseBtn');
        const isCollapsed = body.getAttribute('data-sidebar-collapsed') === 'true';
        const newState = !isCollapsed;
        
        body.setAttribute('data-sidebar-collapsed', newState);
        localStorage.setItem('sidebarCollapsed', newState);
        
        // Update button title
        btn.title = newState ? 'Expandir menú' : 'Colapsar menú';
        btn.setAttribute('aria-label', newState ? 'Expandir sidebar' : 'Colapsar sidebar');
    }

    // Restore sidebar state
    document.addEventListener('DOMContentLoaded', function() {
        const savedState = localStorage.getItem('sidebarCollapsed');
        const btn = document.getElementById('sidebarCollapseBtn');
        
        if (savedState === 'true') {
            document.body.setAttribute('data-sidebar-collapsed', 'true');
            if (btn) {
                btn.title = 'Expandir menú';
                btn.setAttribute('aria-label', 'Expandir sidebar');
            }
        }
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // Submenu Toggle
    // ═══════════════════════════════════════════════════════════════════════════
    function toggleSubmenu(button) {
        const submenu = button.nextElementSibling;
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        
        button.setAttribute('aria-expanded', !isExpanded);
        submenu.classList.toggle('open');
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // Notifications Dropdown
    // ═══════════════════════════════════════════════════════════════════════════
    function toggleNotifications() {
        const menu = document.getElementById('notificationsMenu');
        const userDropdown = document.getElementById('userDropdown');
        
        userDropdown.classList.remove('open');
        menu.classList.toggle('open');
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // User Dropdown (Topbar)
    // ═══════════════════════════════════════════════════════════════════════════
    function toggleUserDropdown() {
        const menu = document.getElementById('userDropdown');
        const notifMenu = document.getElementById('notificationsMenu');
        
        notifMenu.classList.remove('open');
        menu.classList.toggle('open');
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // Global Search
    // ═══════════════════════════════════════════════════════════════════════════
    function openGlobalSearch() {
        const modal = document.getElementById('globalSearchModal');
        const input = document.getElementById('globalSearchInput');
        
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => input.focus(), 100);
    }

    function closeGlobalSearch() {
        const modal = document.getElementById('globalSearchModal');
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openGlobalSearch();
        }
        // ESC to close search
        if (e.key === 'Escape') {
            closeGlobalSearch();
            document.getElementById('notificationsMenu').classList.remove('open');
            document.getElementById('userDropdown').classList.remove('open');
        }
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // Theme Toggle
    // ═══════════════════════════════════════════════════════════════════════════
    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById('themeIcon');
        const currentTheme = body.getAttribute('data-theme');
        const isDark = currentTheme !== 'dark';
        
        body.setAttribute('data-theme', isDark ? 'dark' : 'light');
        icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        localStorage.setItem('adminTheme', isDark ? 'dark' : 'light');
    }

    // Restore theme
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('adminTheme');
        if (savedTheme === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
            document.getElementById('themeIcon').className = 'fa-solid fa-sun';
        }
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // Help Panel (Placeholder)
    // ═══════════════════════════════════════════════════════════════════════════
    function openHelpPanel() {
        alert('Panel de ayuda - Próximamente');
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // Clear Cache (Placeholder)
    // ═══════════════════════════════════════════════════════════════════════════
    function clearCache() {
        alert('Caché limpiado correctamente');
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // Close dropdowns when clicking outside
    // ═══════════════════════════════════════════════════════════════════════════
    document.addEventListener('click', function(e) {
        // Close notifications
        if (!e.target.closest('.topbar-notifications-btn') && !e.target.closest('#notificationsMenu')) {
            document.getElementById('notificationsMenu')?.classList.remove('open');
        }
        // Close user dropdown
        if (!e.target.closest('.topbar-user-btn') && !e.target.closest('#userDropdown')) {
            document.getElementById('userDropdown')?.classList.remove('open');
        }
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // Window Resize Handler
    // ═══════════════════════════════════════════════════════════════════════════
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            document.getElementById('adminSidebar').classList.remove('open');
            document.getElementById('adminOverlay').style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    </script>

    {{-- SweetAlert2 Library --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Configuración global de SweetAlert2
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Función para mostrar alertas de éxito
        function showSuccess(message, title = '¡Éxito!') {
            Toast.fire({
                icon: 'success',
                title: title,
                text: message
            });
        }

        // Función para mostrar alertas de error
        function showError(message, title = 'Error') {
            Toast.fire({
                icon: 'error',
                title: title,
                text: message
            });
        }

        // Función para mostrar alertas de información
        function showInfo(message, title = 'Información') {
            Toast.fire({
                icon: 'info',
                title: title,
                text: message
            });
        }

        // Función para mostrar alertas de advertencia
        function showWarning(message, title = 'Advertencia') {
            Toast.fire({
                icon: 'warning',
                title: title,
                text: message
            });
        }

        // Función para confirmaciones
        function confirmAction(title, text, confirmText = 'Sí, continuar', cancelText = 'Cancelar') {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff006e',
                cancelButtonColor: '#ef4444',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm',
                    cancelButton: 'swal-custom-cancel'
                }
            });
        }

        // Función para confirmación de eliminación
        function confirmDelete(itemName = 'este elemento') {
            return Swal.fire({
                title: '¿Estás seguro?',
                html: `Estás a punto de eliminar <strong>${itemName}</strong>.<br>Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
                cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                reverseButtons: true,
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-delete',
                    cancelButton: 'swal-custom-cancel'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            });
        }

        // Mostrar alertas de sesión automáticamente
        @if(session('success'))
            showSuccess('{{ session('success') }}');
        @endif

        @if(session('error'))
            showError('{{ session('error') }}');
        @endif

        @if(session('info'))
            showInfo('{{ session('info') }}');
        @endif

        @if(session('warning'))
            showWarning('{{ session('warning') }}');
        @endif

        // ============================================================
        // 1. LOADER ANIMADO GLOBAL EN BOTONES DE GUARDAR / SUBMIT
        // ============================================================
        document.addEventListener('submit', function(e) {
            const form = e.target;
            
            if (form.classList.contains('no-loader') || form.hasAttribute('data-no-loader')) {
                return;
            }

            if (form.getAttribute('data-swal-confirming') === 'true') {
                return;
            }

            const submitBtn = form.querySelector('button[type="submit"]:focus') 
                           || document.activeElement 
                           || form.querySelector('button[type="submit"]');

            if (submitBtn && (submitBtn.type === 'submit' || submitBtn.tagName === 'BUTTON') && !submitBtn.classList.contains('is-submitting')) {
                submitBtn.classList.add('is-submitting');
                submitBtn.style.pointerEvents = 'none';

                const textSpan = submitBtn.querySelector('span:not(.fa-solid):not(.fas):not(.far)');
                const originalText = textSpan ? textSpan.textContent.trim() : submitBtn.textContent.trim();

                let loadingText = 'Guardando...';
                if (originalText.toLowerCase().includes('publicar')) {
                    loadingText = 'Publicando...';
                } else if (originalText.toLowerCase().includes('eliminar') || originalText.toLowerCase().includes('borrar')) {
                    loadingText = 'Eliminando...';
                } else if (originalText.toLowerCase().includes('enviar') || originalText.toLowerCase().includes('responder')) {
                    loadingText = 'Enviando...';
                } else if (originalText.toLowerCase().includes('iniciar') || originalText.toLowerCase().includes('acceder')) {
                    loadingText = 'Accediendo...';
                }

                if (textSpan) {
                    const icon = submitBtn.querySelector('i');
                    if (icon) {
                        icon.className = 'fa-solid fa-circle-notch fa-spin';
                    } else {
                        const newIcon = document.createElement('i');
                        newIcon.className = 'fa-solid fa-circle-notch fa-spin';
                        newIcon.style.marginRight = '0.5rem';
                        submitBtn.insertBefore(newIcon, textSpan);
                    }
                    textSpan.textContent = loadingText;
                } else {
                    submitBtn.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin" style="margin-right:0.5rem;"></i><span>${loadingText}</span>`;
                }

                setTimeout(() => {
                    submitBtn.classList.remove('is-submitting');
                    submitBtn.style.pointerEvents = 'auto';
                }, 15000);
            }
        });

        // ============================================================
        // 2. ALERTA MODAL SWEETALERT2 PARA CONFIRMACIÓN DE ELIMINACIÓN
        // ============================================================
        document.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.svc-card-btn--delete, .btn-delete, .admin-btn-danger, [data-confirm-delete], button[onclick*="confirm"], a[onclick*="confirm"]');
            const deleteForm = e.target.closest('form[action*="destroy"], form[action*="delete"], .admin-delete-form, form[onsubmit*="confirm"]');

            if (deleteBtn || (deleteForm && e.target.closest('button[type="submit"]'))) {
                const targetForm = deleteForm || (deleteBtn ? deleteBtn.closest('form') : null);
                const targetLink = deleteBtn ? deleteBtn.closest('a') : null;

                if (targetForm && targetForm.hasAttribute('onsubmit')) {
                    targetForm.removeAttribute('onsubmit');
                }
                if (deleteBtn && deleteBtn.hasAttribute('onclick')) {
                    const onclickAttr = deleteBtn.getAttribute('onclick');
                    if (onclickAttr.includes('confirm(')) {
                        deleteBtn.removeAttribute('onclick');
                    }
                }

                e.preventDefault();
                e.stopPropagation();

                let itemName = 'este elemento';
                if (targetForm) {
                    const card = targetForm.closest('.svc-card-item, .svc-card, .admin-card, tr, .card');
                    if (card) {
                        const titleEl = card.querySelector('.svc-card-title, h3, h2, td:first-child, .card-title');
                        if (titleEl) {
                            itemName = `"${titleEl.textContent.trim()}"`;
                        }
                    }
                }

                Swal.fire({
                    title: '¿Confirmar eliminación?',
                    html: `<div style="font-size: 0.95rem; line-height: 1.5; color: #64748b; margin-top: 0.5rem;">
                             Estás a punto de eliminar <strong style="color: #ef4444;">${itemName}</strong>.<br>
                             Esta acción es permanente y no se podrá deshacer.
                           </div>`,
                    icon: 'warning',
                    iconColor: '#ef4444',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Sí, eliminar',
                    cancelButtonText: '<i class="fa-solid fa-xmark"></i> Cancelar',
                    reverseButtons: true,
                    background: document.body.getAttribute('data-theme') === 'dark' ? '#181825' : '#ffffff',
                    color: document.body.getAttribute('data-theme') === 'dark' ? '#f8fafc' : '#0f172a',
                    customClass: {
                        popup: 'swal-custom-delete-popup',
                        confirmButton: 'swal-custom-delete-btn',
                        cancelButton: 'swal-custom-cancel-btn'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (targetForm) {
                            targetForm.setAttribute('data-swal-confirming', 'true');
                            const btn = deleteBtn || targetForm.querySelector('button[type="submit"]');
                            if (btn) {
                                btn.classList.add('is-submitting');
                                btn.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin" style="margin-right:0.5rem;"></i><span>Eliminando...</span>`;
                            }
                            targetForm.submit();
                        } else if (targetLink && targetLink.href) {
                            window.location.href = targetLink.href;
                        }
                    }
                });
            }
        }, true);
    </script>

    {{-- Sistema de Notificaciones en Tiempo Real --}}
    <script src="{{ asset('js/admin-notifications.js') }}"></script>

    {{-- Estilos personalizados para Loader y SweetAlert2 --}}
    <style>
        /* Form Submit Loader Animation Style */
        .btn-submitting,
        button[type="submit"].is-submitting,
        .admin-btn.is-submitting {
            position: relative !important;
            pointer-events: none !important;
            opacity: 0.88 !important;
            cursor: wait !important;
            box-shadow: 0 0 15px rgba(255, 0, 110, 0.4) !important;
        }

        /* Ultra-Premium SweetAlert2 Custom Styling */
        .swal-custom-delete-popup {
            border-radius: 20px !important;
            padding: 2rem 1.75rem !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: #ffffff !important;
            color: #0f172a !important;
        }

        body[data-theme="dark"] .swal-custom-delete-popup {
            background: #181825 !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .swal-custom-delete-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.75rem 1.75rem !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4) !important;
            transition: all 0.25s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .swal-custom-delete-btn:hover {
            transform: translateY(-2px) scale(1.02) !important;
            box-shadow: 0 8px 22px rgba(239, 68, 68, 0.6) !important;
        }

        .swal-custom-cancel-btn {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        body[data-theme="dark"] .swal-custom-cancel-btn {
            background: #27273a !important;
            color: #cbd5e1 !important;
            border-color: #3f3f5a !important;
        }

        .swal-custom-cancel-btn:hover {
            background: #e2e8f0 !important;
            color: #1e293b !important;
        }

        body[data-theme="dark"] .swal-custom-cancel-btn:hover {
            background: #32324d !important;
            color: #ffffff !important;
        }

        .swal-custom-popup {
            border-radius: 16px !important;
            padding: 2rem !important;
        }

        .swal-custom-confirm,
        .swal-custom-delete {
            border-radius: 10px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
        }

        .swal-custom-confirm:hover,
        .swal-custom-delete:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .swal-custom-cancel {
            border-radius: 10px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
        }

        .swal2-toast {
            border-radius: 12px !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
        }

        .swal2-toast .swal2-title {
            font-size: 0.95rem !important;
            font-weight: 600 !important;
        }

        .swal2-icon {
            border-width: 3px !important;
        }
        
        .topbar-notification-icon--primary {
            background: var(--admin-gradient);
            color: white;
        }
    </style>

    @stack('scripts')
</body>
</html>
