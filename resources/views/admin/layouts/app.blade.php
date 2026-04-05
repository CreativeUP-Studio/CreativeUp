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
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon" onclick="event.preventDefault(); if(document.body.getAttribute('data-sidebar-collapsed') === 'true') toggleSidebarCollapse();">
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                </div>
                <div class="sidebar-brand-text">
                    <span class="sidebar-brand-name">
                        <span class="brand-creative">creative</span><span class="brand-up">up</span>
                    </span>
                    <span class="sidebar-brand-tagline">Admin Panel</span>
                </div>
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

            {{-- Configuración Section --}}
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-section-title">
                    <i class="fa-solid fa-gear" aria-hidden="true"></i>
                    <span>Sistema</span>
                </span>
            </div>
            <button class="sidebar-nav-item sidebar-nav-submenu-toggle" 
                    onclick="toggleSubmenu(this)" aria-expanded="false">
                <div class="sidebar-nav-icon">
                    <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                </div>
                <span class="sidebar-nav-text">Configuración</span>
                <i class="fa-solid fa-chevron-down sidebar-nav-arrow" aria-hidden="true"></i>
            </button>
            <div class="sidebar-submenu">
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

            {{-- User Profile --}}
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <span>{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                </div>
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <span class="sidebar-user-role">Administrador</span>
                </div>
                <div class="sidebar-user-actions">
                    <button class="sidebar-user-btn" title="Configuración de cuenta" onclick="openUserMenu()">
                        <i class="fa-solid fa-ellipsis-vertical" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            {{-- User Menu Dropdown --}}
            <div class="sidebar-user-menu" id="sidebarUserMenu">
                <a href="#" class="sidebar-user-menu-item">
                    <i class="fa-solid fa-user-pen" aria-hidden="true"></i>
                    <span>Editar Perfil</span>
                </a>
                <a href="#" class="sidebar-user-menu-item">
                    <i class="fa-solid fa-key" aria-hidden="true"></i>
                    <span>Cambiar Contraseña</span>
                </a>
                <div class="sidebar-user-menu-divider"></div>
                <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
                    @csrf
                    <button type="submit" class="sidebar-user-menu-item sidebar-user-menu-item--danger">
                        <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
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
                            @php $notifCount = \App\Models\Lead::where('status', 'nuevo')->count(); @endphp
                            @if($notifCount > 0)
                            <span class="topbar-notification-badge">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
                            @endif
                        </button>
                        <div class="topbar-dropdown-menu topbar-notifications-menu" id="notificationsMenu">
                            <div class="topbar-dropdown-header">
                                <span class="topbar-dropdown-title">Notificaciones</span>
                                <button class="topbar-dropdown-action">Marcar todas leídas</button>
                            </div>
                            <div class="topbar-dropdown-body">
                                @if($notifCount > 0)
                                <a href="{{ route('admin.leads.index') }}" class="topbar-notification-item topbar-notification-item--unread">
                                    <div class="topbar-notification-icon topbar-notification-icon--success">
                                        <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                                    </div>
                                    <div class="topbar-notification-content">
                                        <p class="topbar-notification-text">Tienes <strong>{{ $notifCount }} leads nuevos</strong></p>
                                        <span class="topbar-notification-time">Revisa el CRM</span>
                                    </div>
                                </a>
                                @else
                                <div class="topbar-notification-empty">
                                    <i class="fa-solid fa-bell-slash" aria-hidden="true"></i>
                                    <p>No hay notificaciones</p>
                                </div>
                                @endif
                            </div>
                            <div class="topbar-dropdown-footer">
                                <a href="{{ route('admin.leads.index') }}">Ver todos los leads</a>
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
                            <span>{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                        </div>
                        <div class="topbar-user-info">
                            <span class="topbar-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <span class="topbar-user-role">Admin</span>
                        </div>
                        <i class="fa-solid fa-chevron-down topbar-user-arrow" aria-hidden="true"></i>
                    </button>
                    <div class="topbar-dropdown-menu topbar-user-dropdown" id="userDropdown">
                        <div class="topbar-dropdown-header topbar-user-dropdown-header">
                            <div class="topbar-user-avatar topbar-user-avatar--lg">
                                <span>{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="topbar-user-dropdown-name">{{ Auth::user()->name ?? 'Admin' }}</p>
                                <p class="topbar-user-dropdown-email">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                            </div>
                        </div>
                        <div class="topbar-dropdown-body">
                            <a href="#" class="topbar-dropdown-item">
                                <i class="fa-solid fa-user" aria-hidden="true"></i>
                                <span>Mi Perfil</span>
                            </a>
                            <a href="#" class="topbar-dropdown-item">
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
    // User Menu (Sidebar)
    // ═══════════════════════════════════════════════════════════════════════════
    function openUserMenu() {
        const menu = document.getElementById('sidebarUserMenu');
        menu.classList.toggle('open');
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
        // Close sidebar user menu
        if (!e.target.closest('.sidebar-user-btn') && !e.target.closest('#sidebarUserMenu')) {
            document.getElementById('sidebarUserMenu')?.classList.remove('open');
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

    @stack('scripts')
</body>
</html>
