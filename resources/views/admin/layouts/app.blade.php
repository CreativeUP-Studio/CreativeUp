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
<body class="admin-body">

    {{-- ═══════════════════════════════════════════════════
         SIDEBAR
         ═══════════════════════════════════════════════════ --}}
    <aside class="admin-sidebar" id="adminSidebar">
        {{-- Brand --}}
        <div class="admin-sidebar-brand">
            <span>creative</span><span>up</span>
        </div>

        {{-- Navigation --}}
        <nav class="admin-sidebar-nav">
            <div class="admin-nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <div class="admin-nav-section">Contenido</div>
            <a href="{{ route('admin.services.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>Servicios</span>
            </a>
            <a href="{{ route('admin.projects.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="fa-solid fa-diagram-project"></i>
                <span>Proyectos</span>
            </a>
            <a href="{{ route('admin.posts.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog / Posts</span>
            </a>

            <div class="admin-nav-section">CRM</div>
            <a href="{{ route('admin.leads.index') }}"
               class="admin-nav-item {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Leads</span>
            </a>
        </nav>

        {{-- Footer --}}
        <div class="admin-sidebar-footer">
            <div class="admin-sidebar-footer-inner">
                <span class="admin-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="admin-logout-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div class="admin-sidebar-overlay" id="adminOverlay" onclick="closeSidebar()"></div>

    {{-- ═══════════════════════════════════════════════════
         MAIN CONTENT
         ═══════════════════════════════════════════════════ --}}
    <div class="admin-main">
        {{-- Topbar --}}
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="admin-toggle-btn" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="admin-topbar-actions">
                <a href="{{ route('home') }}"
                   class="admin-btn admin-btn-secondary admin-btn-sm"
                   target="_blank"
                   title="Ver sitio web">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Ver sitio</span>
                </a>
            </div>
        </header>

        {{-- Content Area --}}
        <main class="admin-content">
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="admin-alert admin-alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            {{-- Error Alert --}}
            @if(session('error'))
                <div class="admin-alert admin-alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="admin-alert admin-alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </main>
    </div>

    {{-- JavaScript --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminOverlay');

            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('open');
                overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminOverlay');

            sidebar.classList.remove('open');
            overlay.style.display = 'none';
        }

        // Close sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('adminSidebar').classList.remove('open');
                document.getElementById('adminOverlay').style.display = 'none';
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
