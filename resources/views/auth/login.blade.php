<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | CreativeUP Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">

    {{-- Orbes animados de fondo --}}
    <div class="login-orb login-orb--1"></div>
    <div class="login-orb login-orb--2"></div>
    <div class="login-orb login-orb--3"></div>

    <div class="login-card">
        {{-- Logo --}}
        <div class="login-brand">
            <div class="login-logo-icon">
                <span>UP</span>
            </div>
            <h1 class="login-brand-title">
                <span class="login-brand-creative">creative</span><span class="login-brand-up">up</span>
            </h1>
            <p class="login-brand-subtitle">Panel de Administración</p>
        </div>

        {{-- Errores --}}
        @if($errors->any())
            <div class="login-error">
                <svg class="login-error-icon" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="login-field">
                <label for="email" class="login-label">Correo electrónico</label>
                <div class="login-input-wrapper">
                    <svg class="login-input-icon" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <input type="email" id="email" name="email" class="login-input"
                           value="{{ old('email') }}" required autofocus placeholder="admin@creativeup.com">
                </div>
            </div>

            <div class="login-field">
                <label for="password" class="login-label">Contraseña</label>
                <div class="login-input-wrapper">
                    <svg class="login-input-icon" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <input type="password" id="password" name="password" class="login-input"
                           required placeholder="••••••••">
                    <button type="button" class="login-toggle-pw" onclick="togglePassword()" aria-label="Mostrar contraseña">
                        <svg id="eyeIcon" viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="login-remember">
                <label class="login-remember-label">
                    <input type="checkbox" id="remember" name="remember" class="login-checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <span class="login-checkmark"></span>
                    Recordarme
                </label>
            </div>

            <button type="submit" class="login-btn">
                <span>Iniciar sesión</span>
                <svg viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </form>

        <div class="login-footer">
            <a href="{{ route('home') }}" class="login-back-link">
                <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                Volver al sitio
            </a>
        </div>
    </div>

    <script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.innerHTML = '<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>';
        } else {
            pw.type = 'password';
            icon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>';
        }
    }
    </script>
</body>
</html>
