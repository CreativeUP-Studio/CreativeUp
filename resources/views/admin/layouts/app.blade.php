<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | CreativeUP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="admin-body">

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-brand">
            <span>creative</span><span>up</span>
        </div>
        <nav class="admin-sidebar-nav">
            <div class="admin-nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>

            <div class="admin-nav-section">Contenido</div>
            <a href="{{ route('admin.services.index') }}" class="admin-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                Servicios
            </a>
            <a href="{{ route('admin.projects.index') }}" class="admin-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="fa-solid fa-diagram-project"></i>
                Proyectos
            </a>
            <a href="{{ route('admin.posts.index') }}" class="admin-nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i>
                Blog / Posts
            </a>

            <div class="admin-nav-section">CRM</div>
            <a href="{{ route('admin.leads.index') }}" class="admin-nav-item {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                Leads
            </a>
        </nav>
        <div class="admin-sidebar-footer">
            <div class="admin-sidebar-footer-inner">
                <span class="admin-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-logout-btn">Salir</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div class="admin-sidebar-overlay" onclick="document.getElementById('adminSidebar').classList.remove('open'); this.style.display='none';"></div>

    {{-- Main --}}
    <div class="admin-main">
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="admin-toggle-btn" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                    <i class="fa-solid fa-bars" style="font-size:1.2rem"></i>
                </button>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="admin-topbar-actions">
                <a href="{{ route('home') }}" class="admin-btn admin-btn-secondary admin-btn-sm" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    Ver sitio
                </a>
            </div>
        </div>

        <div class="admin-content">
            @if(session('success'))
                <div class="admin-alert admin-alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="admin-alert admin-alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="admin-alert admin-alert-danger">
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

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
