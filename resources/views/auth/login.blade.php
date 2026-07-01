<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso Admin | CreativeUP</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary: #ff006e;
            --primary-rgb: 255, 0, 110;
            --secondary: #8338ec;
            --secondary-rgb: 131, 56, 236;
            --accent: #3b82f6;
            --bg: #ffffff;
            --bg-page: #f8f9fc;
            --surface: #ffffff;
            --surface-alt: #f4f5f9;
            --text-main: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e5e7ef;
            --border-light: #f1f2f6;
            --error: #ef4444;
            --error-bg: #fef2f2;
            --success: #10b981;
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ══════════════════════════════════════════════════════════════
           LEFT PANEL - Branding Visual
           ══════════════════════════════════════════════════════════════ */
        .login-brand-panel {
            flex: 1;
            background: linear-gradient(160deg, #ff006e 0%, #8338ec 50%, #6320c7 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            overflow: hidden;
            min-height: 100vh;
        }

        /* Geometric decoration */
        .brand-decoration {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .brand-decoration::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -20%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            border: 80px solid rgba(255, 255, 255, 0.04);
            animation: floatShape 20s ease-in-out infinite;
        }

        .brand-decoration::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -15%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            border: 60px solid rgba(255, 255, 255, 0.03);
            animation: floatShape 20s ease-in-out infinite reverse;
        }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, -20px) rotate(5deg); }
        }

        /* Noise texture overlay */
        .brand-noise {
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Floating dots */
        .brand-dot {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            animation: floatDot 8s ease-in-out infinite;
        }

        .brand-dot:nth-child(1) {
            width: 8px; height: 8px;
            top: 15%; left: 20%;
            animation-delay: 0s;
        }
        .brand-dot:nth-child(2) {
            width: 12px; height: 12px;
            top: 25%; right: 25%;
            animation-delay: -2s;
        }
        .brand-dot:nth-child(3) {
            width: 6px; height: 6px;
            bottom: 30%; left: 15%;
            animation-delay: -4s;
        }
        .brand-dot:nth-child(4) {
            width: 10px; height: 10px;
            bottom: 20%; right: 20%;
            animation-delay: -6s;
        }
        .brand-dot:nth-child(5) {
            width: 5px; height: 5px;
            top: 60%; left: 40%;
            animation-delay: -1s;
        }

        @keyframes floatDot {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.12; }
            50% { transform: translateY(-15px) scale(1.3); opacity: 0.25; }
        }

        /* Brand content */
        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 420px;
            animation: brandFadeIn 1s ease 0.3s both;
        }

        @keyframes brandFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-icon-wrap {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
        }

        .brand-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 28px;
            border: 1px dashed rgba(255, 255, 255, 0.12);
            animation: spinSlow 30s linear infinite;
        }

        @keyframes spinSlow {
            to { transform: rotate(360deg); }
        }

        .brand-icon-wrap svg {
            width: 36px;
            height: 36px;
            fill: white;
            opacity: 0.95;
        }

        .brand-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
            margin-bottom: 1rem;
            line-height: 1.15;
        }

        .brand-description {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.7;
            font-weight: 400;
        }

        /* Stats row */
        .brand-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2.5rem;
            justify-content: center;
        }

        .brand-stat {
            text-align: center;
        }

        .brand-stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            margin-bottom: 4px;
        }

        .brand-stat-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.55);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .brand-stat-divider {
            width: 1px;
            background: rgba(255, 255, 255, 0.15);
            align-self: stretch;
        }

        /* ══════════════════════════════════════════════════════════════
           RIGHT PANEL - Login Form
           ══════════════════════════════════════════════════════════════ */
        .login-form-panel {
            width: 520px;
            min-width: 520px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 3.5rem;
            background: var(--bg);
            position: relative;
            overflow-y: auto;
        }

        .login-form-inner {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
            animation: formSlideIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }

        @keyframes formSlideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 2.5rem;
            transition: all 0.25s ease;
            padding: 6px 0;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .back-link i {
            font-size: 0.75rem;
            transition: transform 0.25s ease;
        }

        .back-link:hover i {
            transform: translateX(-3px);
        }

        /* Header */
        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-greeting {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-greeting::before {
            content: '';
            width: 20px;
            height: 2px;
            background: var(--primary);
            border-radius: 1px;
        }

        .form-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .form-subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
            font-weight: 400;
            line-height: 1.5;
        }

        /* ══════════════════════════════════════════════════════════════
           FORM INPUTS
           ══════════════════════════════════════════════════════════════ */
        .field-group {
            margin-bottom: 1.5rem;
        }

        .field-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .field-wrapper {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
            transition: color 0.25s ease;
            pointer-events: none;
            z-index: 2;
        }

        .field-input {
            width: 100%;
            background: var(--surface-alt);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            color: var(--text-main);
            font-size: 0.95rem;
            outline: none;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
        }

        .field-input::placeholder {
            color: var(--text-muted);
            font-weight: 400;
        }

        .field-input:focus {
            border-color: var(--primary);
            background: var(--bg);
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.06);
        }

        .field-input:focus ~ .field-icon {
            color: var(--primary);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            z-index: 2;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            padding: 4px;
        }

        .toggle-password:hover {
            color: var(--text-main);
        }

        /* ══════════════════════════════════════════════════════════════
           FORM OPTIONS
           ══════════════════════════════════════════════════════════════ */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.85rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            color: var(--text-secondary);
            font-weight: 500;
            transition: color 0.2s ease;
            user-select: none;
        }

        .checkbox-label:hover {
            color: var(--text-main);
        }

        .checkbox-label input {
            display: none;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            background: var(--bg);
            flex-shrink: 0;
        }

        .checkbox-custom i {
            font-size: 9px;
            color: white;
            opacity: 0;
            transform: scale(0);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .checkbox-label input:checked + .checkbox-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
            box-shadow: 0 2px 8px rgba(var(--primary-rgb), 0.3);
        }

        .checkbox-label input:checked + .checkbox-custom i {
            opacity: 1;
            transform: scale(1);
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--secondary);
        }

        /* ══════════════════════════════════════════════════════════════
           SUBMIT BUTTON
           ══════════════════════════════════════════════════════════════ */
        .btn-submit {
            width: 100%;
            padding: 0.95rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.01em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(var(--primary-rgb), 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.6s ease;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(var(--primary-rgb), 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit .btn-icon {
            transition: transform 0.25s ease;
        }

        .btn-submit:hover .btn-icon {
            transform: translateX(3px);
        }

        .btn-loading-state {
            display: none;
        }

        /* ══════════════════════════════════════════════════════════════
           DIVIDER
           ══════════════════════════════════════════════════════════════ */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 1.5rem 0;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ══════════════════════════════════════════════════════════════
           DEMO BUTTON
           ══════════════════════════════════════════════════════════════ */
        .demo-btn {
            width: 100%;
            padding: 0.85rem;
            background: var(--surface-alt);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            font-size: 0.88rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .demo-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(var(--primary-rgb), 0.03);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .demo-btn i {
            font-size: 0.85rem;
        }

        /* ══════════════════════════════════════════════════════════════
           ALERT ERROR
           ══════════════════════════════════════════════════════════════ */
        .alert-error {
            background: var(--error-bg);
            border: 1.5px solid rgba(239, 68, 68, 0.2);
            color: var(--error);
            padding: 0.85rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            font-weight: 500;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-3px, 0, 0); }
            40%, 60% { transform: translate3d(3px, 0, 0); }
        }

        .alert-error i {
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ══════════════════════════════════════════════════════════════
           FOOTER
           ══════════════════════════════════════════════════════════════ */
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 400;
        }

        .login-footer a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .login-footer a:hover {
            color: var(--primary);
        }

        /* ══════════════════════════════════════════════════════════════
           RESPONSIVE
           ══════════════════════════════════════════════════════════════ */

        /* Tablet */
        @media (max-width: 1024px) {
            .login-brand-panel {
                display: none;
            }

            .login-form-panel {
                width: 100%;
                min-width: 100%;
            }
        }

        /* Mobile */
        @media (max-width: 600px) {
            .login-form-panel {
                padding: 2rem 1.5rem;
            }

            .login-form-inner {
                max-width: 100%;
            }

            .back-link {
                margin-bottom: 2rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .form-subtitle {
                font-size: 0.88rem;
            }

            .form-header {
                margin-bottom: 2rem;
            }

            .field-input {
                font-size: 16px; /* Prevent zoom on iOS */
            }

            .form-options {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .btn-submit {
                padding: 0.9rem;
            }
        }

        /* Very small phones */
        @media (max-width: 374px) {
            .login-form-panel {
                padding: 1.5rem 1.2rem;
            }

            .form-title {
                font-size: 1.35rem;
            }

            .brand-stats {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>

    {{-- ══════════════════════════════════════════════════════════════
         LEFT PANEL - Visual Branding
         ══════════════════════════════════════════════════════════════ --}}
    <div class="login-brand-panel">
        <div class="brand-decoration"></div>
        <div class="brand-noise"></div>
        <div class="brand-dot"></div>
        <div class="brand-dot"></div>
        <div class="brand-dot"></div>
        <div class="brand-dot"></div>
        <div class="brand-dot"></div>

        <div class="brand-content">
            <div class="brand-icon-wrap">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </div>
            <h1 class="brand-title">Panel de<br>Administración</h1>
            <p class="brand-description">
                Gestiona tu presencia digital, administra proyectos, 
                leads y contenido desde un solo lugar.
            </p>

            <div class="brand-stats">
                <div class="brand-stat">
                    <div class="brand-stat-value">+500</div>
                    <div class="brand-stat-label">Proyectos</div>
                </div>
                <div class="brand-stat-divider"></div>
                <div class="brand-stat">
                    <div class="brand-stat-value">24/7</div>
                    <div class="brand-stat-label">Soporte</div>
                </div>
                <div class="brand-stat-divider"></div>
                <div class="brand-stat">
                    <div class="brand-stat-value">99%</div>
                    <div class="brand-stat-label">Uptime</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         RIGHT PANEL - Login Form
         ══════════════════════════════════════════════════════════════ --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            {{-- Back link --}}
            <a href="{{ route('home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al sitio</span>
            </a>

            {{-- Header --}}
            <div class="form-header">
                <div class="form-greeting">Bienvenido</div>
                <h2 class="form-title">Inicia sesión en tu cuenta</h2>
                <p class="form-subtitle">Ingresa tus credenciales para acceder al panel de administración.</p>
            </div>

            {{-- Error Alert --}}
            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                {{-- Email --}}
                <div class="field-group">
                    <label for="email" class="field-label">Correo electrónico</label>
                    <div class="field-wrapper">
                        <i class="fas fa-envelope field-icon"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="field-input" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="nombre@empresa.com" 
                            autofocus 
                            autocomplete="email">
                    </div>
                </div>

                {{-- Password --}}
                <div class="field-group">
                    <label for="password" class="field-label">Contraseña</label>
                    <div class="field-wrapper">
                        <i class="fas fa-lock field-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="field-input" 
                            required 
                            placeholder="••••••••" 
                            autocomplete="current-password">
                        <span class="toggle-password" id="togglePw">
                            <i class="far fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <div class="checkbox-custom">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Recordar sesión</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text">Iniciar Sesión</span>
                    <i class="fas fa-arrow-right btn-icon"></i>
                    <span class="btn-loading-state">
                        <i class="fas fa-spinner fa-spin"></i> Verificando...
                    </span>
                </button>
            </form>

            {{-- Divider --}}
            <div class="form-divider">o</div>

            {{-- Demo Button --}}
            <button type="button" class="demo-btn" id="demoBtn">
                <i class="fas fa-bolt"></i>
                <span>Cargar credenciales de Demo</span>
            </button>

            {{-- Footer --}}
            <div class="login-footer">
                <p>&copy; {{ date('Y') }} CreativeUp &middot; <a href="{{ route('home') }}">Volver al inicio</a></p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         JAVASCRIPT
         ══════════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Toggle Password
            const togglePw = document.getElementById('togglePw');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePw && passwordInput && eyeIcon) {
                togglePw.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.className = type === 'password' ? 'far fa-eye' : 'far fa-eye-slash';
                });
            }

            // Submit Loading State
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnIcon = submitBtn.querySelector('.btn-icon');
            const btnLoading = submitBtn.querySelector('.btn-loading-state');

            if (form && submitBtn) {
                form.addEventListener('submit', () => {
                    btnText.style.display = 'none';
                    btnIcon.style.display = 'none';
                    btnLoading.style.display = 'inline-flex';
                    submitBtn.style.pointerEvents = 'none';
                    submitBtn.style.opacity = '0.8';
                });
            }

            // Demo Button
            const demoBtn = document.getElementById('demoBtn');
            const emailInput = document.getElementById('email');

            if (demoBtn && emailInput && passwordInput) {
                demoBtn.addEventListener('click', () => {
                    emailInput.value = 'admin@creativeup.com';
                    passwordInput.value = 'password';
                    
                    emailInput.focus();
                    setTimeout(() => {
                        passwordInput.focus();
                        setTimeout(() => passwordInput.blur(), 150);
                    }, 150);
                });
            }
        });
    </script>
</body>
</html>
