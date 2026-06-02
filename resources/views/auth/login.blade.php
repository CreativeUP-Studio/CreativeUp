<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso Admin | CreativeUP</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #030305;
            --surface: rgba(15, 15, 20, 0.7);
            --primary: #ff006e;
            --secondary: #00f5d4;
            --accent: #8338ec;
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --error: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ══════════════════════════════════════════════════════════════════════════
           ANIMATED BACKGROUND - Orbs & Grid
           ══════════════════════════════════════════════════════════════════════════ */
        .bg-layer {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.35;
            animation: floatOrb 12s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 500px; 
            height: 500px;
            background: var(--primary);
            top: -15%; 
            left: -10%;
        }

        .orb-2 {
            width: 600px; 
            height: 600px;
            background: var(--accent);
            bottom: -20%; 
            right: -15%;
            animation-delay: -6s;
        }

        .orb-3 {
            width: 350px; 
            height: 350px;
            background: var(--secondary);
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            animation-delay: -3s;
        }

        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(var(--border) 1px, transparent 1px),
                linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(circle at center, black 20%, transparent 75%);
            -webkit-mask-image: radial-gradient(circle at center, black 20%, transparent 75%);
            z-index: 1;
        }

        @keyframes floatOrb {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 40px) scale(1.15); }
        }

        /* ══════════════════════════════════════════════════════════════════════════
           GLASS CARD - Login Container
           ══════════════════════════════════════════════════════════════════════════ */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
            background: var(--surface);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            padding: 3.5rem;
            box-shadow: 
                0 40px 80px rgba(0, 0, 0, 0.6), 
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
            animation: cardEntrance 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(40px);
        }

        @keyframes cardEntrance {
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        /* ══════════════════════════════════════════════════════════════════════════
           HEADER - Logo & Subtitle
           ══════════════════════════════════════════════════════════════════════════ */
        .login-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .login-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: -1.5px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            line-height: 1;
        }

        .logo-text {
            color: #404040;
            font-weight: 700;
        }

        .logo-gradient {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .logo-dot {
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            margin-left: 6px;
            animation: logoPulse 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            box-shadow: 0 0 0 0 rgba(255, 0, 110, 0.7);
        }

        @keyframes logoPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 0, 110, 0.7);
            }
            50% {
                transform: scale(1.3);
                box-shadow: 0 0 0 10px rgba(255, 0, 110, 0);
            }
        }

        .login-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        /* ══════════════════════════════════════════════════════════════════════════
           FORM INPUTS - Modern Floating Labels
           ══════════════════════════════════════════════════════════════════════════ */
        .input-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .input-icon-left {
            position: absolute;
            left: 1.3rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
            font-size: 1.1rem;
        }

        .input-control {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1.1rem 1.3rem 1.1rem 3.2rem;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Inter', sans-serif;
        }

        .input-control::placeholder {
            color: transparent;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255, 0, 110, 0.15);
            background: rgba(0, 0, 0, 0.5);
        }

        .input-control:focus ~ .input-icon-left {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        .input-label {
            position: absolute;
            left: 3.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
        }

        .input-control:focus ~ .input-label,
        .input-control:not(:placeholder-shown) ~ .input-label {
            top: -12px;
            left: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary);
            background: var(--bg-dark);
            padding: 0 8px;
            border-radius: 6px;
        }

        .toggle-password {
            position: absolute;
            right: 1.3rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            z-index: 2;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .toggle-password:hover {
            color: var(--text-main);
            transform: translateY(-50%) scale(1.15);
        }

        /* ══════════════════════════════════════════════════════════════════════════
           FORM OPTIONS - Remember & Forgot
           ══════════════════════════════════════════════════════════════════════════ */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            font-size: 0.9rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .checkbox-container:hover {
            color: var(--text-main);
        }

        .checkbox-container input {
            display: none;
        }

        .custom-checkbox {
            width: 20px; 
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(0, 0, 0, 0.3);
        }

        .custom-checkbox i {
            font-size: 11px;
            color: var(--bg-dark);
            opacity: 0;
            transition: all 0.3s ease;
            transform: scale(0);
        }

        .checkbox-container input:checked + .custom-checkbox {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            border-color: var(--secondary);
            box-shadow: 0 0 15px rgba(0, 245, 212, 0.5);
        }

        .checkbox-container input:checked + .custom-checkbox i {
            opacity: 1;
            transform: scale(1);
        }

        .forgot-link {
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: var(--primary);
        }

        /* ══════════════════════════════════════════════════════════════════════════
           SUBMIT BUTTON - Gradient with Shimmer Effect
           ══════════════════════════════════════════════════════════════════════════ */
        .btn-submit {
            width: 100%;
            padding: 1.3rem;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            font-size: 1.05rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 12px 24px rgba(255, 0, 110, 0.35);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; 
            left: -100%;
            width: 100%; 
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            100% { left: 100%; }
        }

        .btn-submit:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 36px rgba(255, 0, 110, 0.5);
        }

        .btn-submit:active {
            transform: translateY(-2px);
        }

        .btn-loading-state {
            display: none;
        }

        /* ══════════════════════════════════════════════════════════════════════════
           ALERTS - Error Messages
           ══════════════════════════════════════════════════════════════════════════ */
        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1.5px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            padding: 1.1rem 1.3rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-2px, 0, 0); }
            20%, 80% { transform: translate3d(3px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-5px, 0, 0); }
            40%, 60% { transform: translate3d(5px, 0, 0); }
        }

        .alert-error i {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        /* ══════════════════════════════════════════════════════════════════════════
           DEMO BUTTON
           ══════════════════════════════════════════════════════════════════════════ */
        .demo-btn {
            background: transparent;
            border: 1.5px dashed var(--border);
            color: var(--text-muted);
            width: 100%;
            padding: 1rem;
            margin-top: 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .demo-btn:hover {
            border-color: var(--secondary);
            border-style: solid;
            color: var(--secondary);
            background: rgba(0, 245, 212, 0.08);
            transform: translateY(-2px);
        }

        /* ══════════════════════════════════════════════════════════════════════════
           BACK TO SITE BUTTON
           ══════════════════════════════════════════════════════════════════════════ */
        .back-to-site {
            position: absolute;
            top: 2.5rem;
            left: 2.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 20;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255,255,255,0.06);
            padding: 0.7rem 1.3rem;
            border-radius: 100px;
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            font-weight: 500;
        }

        .back-to-site:hover {
            color: var(--text-main);
            background: rgba(255,255,255,0.12);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateX(-4px);
        }

        .back-to-site i {
            transition: transform 0.3s ease;
        }

        .back-to-site:hover i {
            transform: translateX(-3px);
        }

        /* ══════════════════════════════════════════════════════════════════════════
           RESPONSIVE DESIGN
           ══════════════════════════════════════════════════════════════════════════ */
        @media (max-width: 600px) {
            .login-card {
                margin: 1.5rem;
                padding: 2.5rem 2rem;
                border-radius: 24px;
            }
            
            .back-to-site {
                top: 1.5rem;
                left: 1.5rem;
                font-size: 0.85rem;
                padding: 0.6rem 1rem;
            }

            .login-logo {
                font-size: 2rem;
            }

            .login-subtitle {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    {{-- ══════════════════════════════════════════════════════════════════════════
         ANIMATED BACKGROUND
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-layer">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="grid-overlay"></div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         BACK TO SITE LINK
         ══════════════════════════════════════════════════════════════════════════ --}}
    <a href="{{ route('home') }}" class="back-to-site">
        <i class="fas fa-arrow-left"></i> 
        <span>Volver al sitio</span>
    </a>

    {{-- ══════════════════════════════════════════════════════════════════════════
         LOGIN CARD
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="login-card">
        {{-- Header --}}
        <div class="login-header">
            <div class="login-logo">
                <span class="logo-text">creative</span>
                <span class="logo-gradient">up</span>
                <div class="logo-dot"></div>
            </div>
            <p class="login-subtitle">Accede a tu centro de comando</p>
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
            
            {{-- Email Input --}}
            <div class="input-group">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="input-control" 
                    value="{{ old('email') }}" 
                    required 
                    placeholder=" " 
                    autofocus 
                    autocomplete="email">
                <i class="fas fa-envelope input-icon-left"></i>
                <label for="email" class="input-label">Correo electrónico</label>
            </div>

            {{-- Password Input --}}
            <div class="input-group">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="input-control" 
                    required 
                    placeholder=" " 
                    autocomplete="current-password">
                <i class="fas fa-lock input-icon-left"></i>
                <label for="password" class="input-label">Contraseña</label>
                <span class="toggle-password" id="togglePw">
                    <i class="far fa-eye" id="eyeIcon"></i>
                </span>
            </div>

            {{-- Remember & Forgot --}}
            <div class="form-options">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <div class="custom-checkbox">
                        <i class="fas fa-check"></i>
                    </div>
                    <span>Recordar sesión</span>
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <span class="btn-text">Iniciar Sesión</span>
                <i class="fas fa-arrow-right btn-icon"></i>
                <span class="btn-loading-state">
                    <i class="fas fa-spinner fa-spin"></i> Verificando...
                </span>
            </button>
        </form>

        {{-- Demo Button --}}
        <button type="button" class="demo-btn" id="demoBtn">
            <i class="fas fa-bolt"></i> 
            <span>Cargar credenciales de Demo</span>
        </button>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         JAVASCRIPT
         ══════════════════════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ══════════════════════════════════════════════════════════════════════
            // Toggle Password Visibility
            // ══════════════════════════════════════════════════════════════════════
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

            // ══════════════════════════════════════════════════════════════════════
            // Submit Loading State
            // ══════════════════════════════════════════════════════════════════════
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

            // ══════════════════════════════════════════════════════════════════════
            // Demo Button - Auto-fill Credentials
            // ══════════════════════════════════════════════════════════════════════
            const demoBtn = document.getElementById('demoBtn');
            const emailInput = document.getElementById('email');

            if (demoBtn && emailInput && passwordInput) {
                demoBtn.addEventListener('click', () => {
                    emailInput.value = 'admin@creativeup.com';
                    passwordInput.value = 'password';
                    
                    // Trigger focus to activate floating labels
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
