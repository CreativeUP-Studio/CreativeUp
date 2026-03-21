<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | CreativeUP Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">

    <div class="login-split">
        {{-- ── Panel izquierdo: Visual ── --}}
        <div class="login-visual">
            <div class="login-visual-bg">
                <div class="login-orb login-orb--1"></div>
                <div class="login-orb login-orb--2"></div>
                <div class="login-orb login-orb--3"></div>
                <div class="login-grid-pattern"></div>
            </div>

            <div class="login-visual-content">
                <div class="login-visual-logo">
                    <div class="login-logo-icon">
                        <span>UP</span>
                    </div>
                </div>

                <h2 class="login-visual-title">
                    Bienvenido a<br>
                    <span class="login-visual-gradient">CreativeUP</span>
                </h2>
                <p class="login-visual-desc">
                    Gestiona tus proyectos, clientes y contenido desde un solo lugar.
                </p>

                <div class="login-visual-features">
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <span class="login-feature-title">Dashboard intuitivo</span>
                            <span class="login-feature-text">Métricas y estadísticas en tiempo real</span>
                        </div>
                    </div>
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                        <div>
                            <span class="login-feature-title">Gestión de proyectos</span>
                            <span class="login-feature-text">Organiza tu portafolio fácilmente</span>
                        </div>
                    </div>
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-comment-dots"></i>
                        </div>
                        <div>
                            <span class="login-feature-title">CRM de leads</span>
                            <span class="login-feature-text">Responde y gestiona clientes potenciales</span>
                        </div>
                    </div>
                </div>

                <div class="login-visual-testimonial">
                    <p class="login-testimonial-text">
                        "El panel de CreativeUP nos permitió organizar nuestro trabajo y atender mejor a nuestros clientes."
                    </p>
                    <div class="login-testimonial-author">
                        <div class="login-testimonial-avatar">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <span class="login-testimonial-name">CreativeUP Team</span>
                            <span class="login-testimonial-role">Agencia Digital</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-visual-footer">
                <span>&copy; {{ date('Y') }} CreativeUP. Todos los derechos reservados.</span>
            </div>
        </div>

        {{-- ── Panel derecho: Formulario ── --}}
        <div class="login-form-panel">
            <div class="login-form-inner">

                {{-- Header --}}
                <div class="login-form-header">
                    <a href="{{ route('home') }}" class="login-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Volver al sitio</span>
                    </a>
                </div>

                {{-- Brand mobile --}}
                <div class="login-mobile-brand">
                    <div class="login-logo-icon login-logo-icon--sm">
                        <span>UP</span>
                    </div>
                </div>

                <div class="login-form-body">
                    <div class="login-form-title-group">
                        <h1 class="login-form-title">Iniciar sesión</h1>
                        <p class="login-form-subtitle">Ingresa tus credenciales para acceder al panel</p>
                    </div>

                    {{-- Errores --}}
                    @if($errors->any())
                    <div class="login-alert" id="loginAlert">
                        <div class="login-alert-icon">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <div class="login-alert-body">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        <button type="button" class="login-alert-close" onclick="this.parentElement.remove()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                        @csrf

                        <div class="login-field">
                            <div class="login-input-wrapper">
                                <div class="login-input-icon-left">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <input type="email" id="email" name="email" class="login-input"
                                       value="{{ old('email') }}" required autofocus placeholder=" "
                                       autocomplete="email">
                                <label for="email" class="login-label">Correo electrónico</label>
                            </div>
                            <span class="login-field-error" id="emailError"></span>
                        </div>

                        <div class="login-field">
                            <div class="login-input-wrapper">
                                <div class="login-input-icon-left">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <input type="password" id="password" name="password" class="login-input"
                                       required placeholder=" " autocomplete="current-password">
                                <label for="password" class="login-label">Contraseña</label>
                                <button type="button" class="login-toggle-pw" id="togglePw" aria-label="Mostrar contraseña">
                                    <i class="fa-regular fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            <div class="login-pw-strength" id="pwStrength">
                                <div class="login-pw-bar"><div class="login-pw-bar-fill" id="pwBarFill"></div></div>
                                <span class="login-pw-text" id="pwText"></span>
                            </div>
                        </div>

                        <div class="login-options">
                            <label class="login-remember">
                                <input type="checkbox" id="remember" name="remember" class="login-checkbox-input" {{ old('remember') ? 'checked' : '' }}>
                                <div class="login-checkbox-custom">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span>Recordarme</span>
                            </label>
                        </div>

                        <button type="submit" class="login-btn" id="loginBtn">
                            <span class="login-btn-text">
                                Iniciar sesión
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                            <span class="login-btn-loading">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                Ingresando...
                            </span>
                        </button>
                    </form>

                    {{-- Separador --}}
                    <div class="login-divider">
                        <span>o accede con</span>
                    </div>

                    {{-- Acceso rápido demo --}}
                    <button type="button" class="login-demo-btn" id="demoBtn">
                        <i class="fa-solid fa-bolt"></i>
                        Acceso rápido de demostración
                    </button>
                </div>

                <div class="login-form-footer">
                    <div class="login-secure-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        Conexión segura y encriptada
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const togglePw = document.getElementById('togglePw');
        const eyeIcon = document.getElementById('eyeIcon');
        const pwBarFill = document.getElementById('pwBarFill');
        const pwText = document.getElementById('pwText');
        const pwStrength = document.getElementById('pwStrength');
        const loginBtn = document.getElementById('loginBtn');
        const demoBtn = document.getElementById('demoBtn');

        /* ── Toggle password visibility ── */
        if (togglePw) {
            togglePw.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
            });
        }

        /* ── Password strength indicator ── */
        if (passwordInput && pwBarFill) {
            passwordInput.addEventListener('input', function() {
                const val = this.value;
                let score = 0;
                if (val.length >= 6) score++;
                if (val.length >= 10) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                const levels = [
                    { width: '0%', color: '#e0e0e0', text: '' },
                    { width: '20%', color: '#e74c3c', text: 'Muy débil' },
                    { width: '40%', color: '#f39c12', text: 'Débil' },
                    { width: '60%', color: '#f1c40f', text: 'Aceptable' },
                    { width: '80%', color: '#2ecc71', text: 'Fuerte' },
                    { width: '100%', color: '#27ae60', text: 'Muy fuerte' },
                ];

                const level = val.length === 0 ? levels[0] : levels[Math.min(score, 5)];
                pwBarFill.style.width = level.width;
                pwBarFill.style.background = level.color;
                pwText.textContent = level.text;
                pwText.style.color = level.color;
                pwStrength.style.opacity = val.length > 0 ? '1' : '0';
            });
        }

        /* ── Email validation on blur ── */
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                const errorEl = document.getElementById('emailError');
                if (this.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                    errorEl.textContent = 'Ingresa un correo válido';
                    this.classList.add('login-input--error');
                } else {
                    errorEl.textContent = '';
                    this.classList.remove('login-input--error');
                }
            });
        }

        /* ── Submit with loading state ── */
        if (form) {
            form.addEventListener('submit', function() {
                loginBtn.classList.add('login-btn--loading');
                loginBtn.disabled = true;
            });
        }

        /* ── Demo access ── */
        if (demoBtn) {
            demoBtn.addEventListener('click', function() {
                emailInput.value = 'admin@creativeup.com';
                passwordInput.value = 'password';
                emailInput.dispatchEvent(new Event('input'));
                passwordInput.dispatchEvent(new Event('input'));

                // Trigger floating labels
                emailInput.focus();
                setTimeout(() => {
                    passwordInput.focus();
                    setTimeout(() => {
                        passwordInput.blur();
                    }, 200);
                }, 200);
            });
        }

        /* ── Auto-dismiss alert ── */
        const alert = document.getElementById('loginAlert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 400);
            }, 8000);
        }

        /* ── Entrada animada ── */
        document.querySelectorAll('.login-feature').forEach((f, i) => {
            f.style.animationDelay = (0.3 + i * 0.15) + 's';
        });
    });
    </script>
</body>
</html>
