<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | CreativeUP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="@yield('body-class')">

    {{-- Logo flotante --}}
    <div class="floating-logo" id="floatingLogo">
        <a href="/" class="brand-logo">
            <span class="brand-creative">creative</span><span class="brand-up">up</span>
        </a>
    </div>

    {{-- Botón de menú flotante --}}
    <button class="floating-menu-btn" id="menuTrigger" aria-label="Abrir menú">
        <span class="menu-dots">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </span>
        <span class="menu-close">
            <span class="close-line"></span>
            <span class="close-line"></span>
        </span>
    </button>

    {{-- Menú Fullscreen Premium --}}
    <div class="fullscreen-menu" id="fullscreenMenu">
        <div class="menu-backdrop"></div>
        
        {{-- SVG Gradients Definition --}}
        <svg width="0" height="0" style="position: absolute;">
            <defs>
                <linearGradient id="nav-arrow-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#5e17eb;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#e870c2;stop-opacity:1" />
                </linearGradient>
            </defs>
        </svg>
        
        <div class="menu-wrapper">
            <div class="menu-container">
                {{-- Navegación Principal --}}
                <nav class="menu-nav">
                    <ul class="nav-list">
                        <li class="nav-item" style="--delay: 0">
                            <a href="{{ route('home') }}" class="nav-link">
                                <span class="nav-number">01</span>
                                <span class="nav-text" data-text="Inicio">Inicio</span>
                                <span class="nav-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="arrow-gradient" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="url(#nav-arrow-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" style="--delay: 1">
                            <a href="{{ route('services.index') }}" class="nav-link">
                                <span class="nav-number">02</span>
                                <span class="nav-text" data-text="Servicios">Servicios</span>
                                <span class="nav-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="arrow-gradient" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="url(#nav-arrow-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" style="--delay: 2">
                            <a href="{{ route('projects.index') }}" class="nav-link">
                                <span class="nav-number">03</span>
                                <span class="nav-text" data-text="Proyectos">Proyectos</span>
                                <span class="nav-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="arrow-gradient" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="url(#nav-arrow-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" style="--delay: 3">
                            <a href="{{ route('blog.index') }}" class="nav-link">
                                <span class="nav-number">04</span>
                                <span class="nav-text" data-text="Blog">Blog</span>
                                <span class="nav-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="arrow-gradient" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="url(#nav-arrow-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" style="--delay: 4">
                            <a href="{{ route('contact.index') }}" class="nav-link">
                                <span class="nav-number">05</span>
                                <span class="nav-text" data-text="Contacto">Contacto</span>
                                <span class="nav-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="arrow-gradient" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14m0 0l-7-7m7 7l-7 7" stroke="url(#nav-arrow-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                {{-- Sección Secundaria --}}
                <div class="menu-secondary">
                    {{-- CTA Card --}}
                    <div class="menu-cta" style="--delay: 5">
                        <div class="cta-badge">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 1L10 5.5L14.5 6L10.5 9.5L11.5 14L8 11.5L4.5 14L5.5 9.5L1.5 6L6 5.5L8 1Z" fill="currentColor"/>
                            </svg>
                            Consultoría Gratuita
                        </div>
                        <h3 class="cta-title">¿Listo para Crecer?</h3>
                        <p class="cta-desc">Conversemos sobre tu proyecto y descubre cómo podemos ayudarte</p>
                        <a href="{{ route('contact.index') }}" class="cta-button">
                            Iniciar Proyecto
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    
                    {{-- Stats --}}
                    <div class="menu-stats" style="--delay: 6">
                        <div class="stat-item">
                            <div class="stat-value">150+</div>
                            <div class="stat-label">Proyectos</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value">95%</div>
                            <div class="stat-label">Satisfacción</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value">10+</div>
                            <div class="stat-label">Años</div>
                        </div>
                    </div>
                    
                    {{-- Contacto y Social --}}
                    <div class="menu-footer" style="--delay: 7">
                        <div class="menu-contact">
                            <a href="mailto:hola@creativeup.com" class="contact-link">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M3 4h14a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M18 5l-8 6-8-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                hola@creativeup.com
                            </a>
                            <a href="tel:+1234567890" class="contact-link">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                +1 (234) 567-890
                            </a>
                        </div>
                        
                        <div class="menu-social">
                            <span class="social-label">Síguenos</span>
                            <div class="social-links">
                                <a href="#" class="social-link" aria-label="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="Twitter">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="main-content min-h-screen">
        @yield('content')
    </main>

    <!-- Chat Popup -->
    <div id="msgChat" class="chat-popup">
        {{-- Header del Chat --}}
        <div class="chat-popup-header">
            <div class="chat-header-content">
                <div class="chat-header-avatar">
                    <span class="chat-avatar-gradient">UP</span>
                    <span class="chat-status-indicator"></span>
                </div>
                <div class="chat-header-info">
                    <h4 class="chat-header-title">CreativeUP</h4>
                    <p class="chat-header-status">
                        <span class="status-dot"></span>
                        En línea · Respuesta inmediata
                    </p>
                </div>
            </div>
            <button id="closeMsgChat" class="chat-header-close" aria-label="Cerrar chat">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Cuerpo del Chat --}}
        <div class="chat-popup-body" id="chatBody">
            <div class="chat-welcome-card">
                <div class="welcome-icon">👋</div>
                <h3 class="welcome-title">¡Hola! Bienvenido</h3>
                <p class="welcome-text">Soy el asistente de CreativeUP. Estoy aquí para ayudarte con cualquier consulta sobre nuestros servicios.</p>
            </div>
            
            <div class="chat-message chat-message-bot">
                <div class="chat-message-avatar">UP</div>
                <div class="chat-message-content">
                    <div class="chat-bubble chat-bubble-bot">
                        ¿En qué puedo ayudarte hoy? 😊
                    </div>
                    <span class="chat-message-time">Ahora</span>
                </div>
            </div>
        </div>

        {{-- Área de Formularios --}}
        <div class="chat-popup-footer" id="chatFormArea">
            {{-- Paso 1: Nombre --}}
            <div class="chat-input-wrapper" id="chatStep1">
                <div class="chat-step-indicator">
                    <span class="step-number">1/3</span>
                    <span class="step-label">¿Cómo te llamas?</span>
                </div>
                <form class="chat-input-form" id="chatFormName">
                    <input 
                        type="text" 
                        id="chatName" 
                        placeholder="Escribe tu nombre aquí..." 
                        class="chat-input" 
                        required 
                        autocomplete="off"
                    >
                    <button type="submit" class="chat-send-btn" aria-label="Enviar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Paso 2: Email --}}
            <div class="chat-input-wrapper" id="chatStep2" style="display:none">
                <div class="chat-step-indicator">
                    <span class="step-number">2/3</span>
                    <span class="step-label">¿Cuál es tu email?</span>
                </div>
                <form class="chat-input-form" id="chatFormEmail">
                    <input 
                        type="email" 
                        id="chatEmail" 
                        placeholder="tu@email.com" 
                        class="chat-input" 
                        required 
                        autocomplete="off"
                    >
                    <button type="submit" class="chat-send-btn" aria-label="Enviar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Paso 3: Mensaje --}}
            <div class="chat-input-wrapper" id="chatStep3" style="display:none">
                <div class="chat-step-indicator">
                    <span class="step-number">3/3</span>
                    <span class="step-label">¿En qué podemos ayudarte?</span>
                </div>
                <form class="chat-input-form" id="chatFormMsg">
                    <input 
                        type="text" 
                        id="chatMsg" 
                        placeholder="Describe tu proyecto o consulta..." 
                        class="chat-input" 
                        required 
                        autocomplete="off"
                    >
                    <button type="submit" class="chat-send-btn" aria-label="Enviar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Paso Final: Confirmación --}}
            <div class="chat-success-state" id="chatStepDone" style="display:none">
                <div class="success-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h4 class="success-title">¡Mensaje Enviado!</h4>
                <p class="success-text">Nos pondremos en contacto contigo pronto.</p>
            </div>

            {{-- Disclaimer --}}
            <div class="chat-disclaimer">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                </svg>
                <span>Conversación segura y privada</span>
            </div>
        </div>
    </div>

    <!-- Botón Flotante del Chat -->
    <button id="floatingMsgBtn" class="chat-floating-btn" aria-label="Abrir chat">
        <span class="chat-btn-icon chat-btn-open">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <span class="chat-btn-icon chat-btn-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <span class="chat-notification-badge" id="chatBadge">1</span>
    </button>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const msgChat = document.getElementById('msgChat');
        const closeMsgChat = document.getElementById('closeMsgChat');
        const floatingMsgBtn = document.getElementById('floatingMsgBtn');
        const chatBody = document.getElementById('chatBody');
        const chatBadge = document.getElementById('chatBadge');

        let chatUserName = '';
        let chatUserEmail = '';
        let chatOpen = false;

        const STORAGE_KEY = 'creativeup_chat';

        // ── Persistencia ──
        function saveChatState() {
            const state = {
                name: chatUserName,
                email: chatUserEmail,
                step: getCurrentStep(),
                messages: getChatMessages(),
                completed: document.getElementById('chatStepDone').style.display !== 'none',
                badgeHidden: chatBadge.style.display === 'none',
                timestamp: Date.now()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        }

        function loadChatState() {
            try {
                const raw = localStorage.getItem(STORAGE_KEY);
                if (!raw) return null;
                const state = JSON.parse(raw);
                // Expirar después de 24 horas
                if (Date.now() - state.timestamp > 24 * 60 * 60 * 1000) {
                    localStorage.removeItem(STORAGE_KEY);
                    return null;
                }
                return state;
            } catch(e) {
                return null;
            }
        }

        function getCurrentStep() {
            if (document.getElementById('chatStepDone').style.display !== 'none') return 'done';
            if (document.getElementById('chatStep3').style.display !== 'none') return 3;
            if (document.getElementById('chatStep2').style.display !== 'none') return 2;
            return 1;
        }

        function getChatMessages() {
            const msgs = [];
            chatBody.querySelectorAll('.chat-message').forEach(function(el) {
                if (el.classList.contains('chat-typing-wrapper')) return;
                const type = el.classList.contains('chat-message-user') ? 'user' : 'bot';
                const bubble = el.querySelector('.chat-bubble');
                if (bubble) msgs.push({ type: type, html: bubble.innerHTML });
            });
            return msgs;
        }

        // Scroll al fondo del chat
        function scrollChat() {
            setTimeout(function() { chatBody.scrollTop = chatBody.scrollHeight; }, 100);
        }

        // Agregar burbuja al chat
        function addBubble(text, type, skipSave) {
            const wrapper = document.createElement('div');
            wrapper.className = 'chat-message chat-message-' + type;
            if (type === 'bot') {
                wrapper.innerHTML = '<div class="chat-message-avatar">UP</div><div class="chat-message-content"><div class="chat-bubble chat-bubble-bot">' + text + '</div><span class="chat-message-time">Ahora</span></div>';
            } else {
                wrapper.innerHTML = '<div class="chat-message-content"><div class="chat-bubble chat-bubble-user">' + text + '</div><span class="chat-message-time">Ahora</span></div>';
            }
            chatBody.appendChild(wrapper);
            scrollChat();
            if (!skipSave) saveChatState();
        }

        // Mostrar typing indicator
        function showTyping() {
            const typing = document.createElement('div');
            typing.className = 'chat-message chat-message-bot chat-typing-indicator';
            typing.innerHTML = '<div class="chat-message-avatar">UP</div><div class="chat-message-content"><div class="chat-bubble chat-bubble-bot chat-typing-dots"><span></span><span></span><span></span></div></div>';
            chatBody.appendChild(typing);
            scrollChat();
            return typing;
        }

        // Bot responde con delay
        function botReply(text, delay) {
            delay = delay || 1200;
            var typing = showTyping();
            return new Promise(function(resolve) {
                setTimeout(function() {
                    typing.remove();
                    addBubble(text, 'bot');
                    resolve();
                }, delay);
            });
        }

        // Abrir chat
        function openChat() {
            msgChat.classList.add('chat-popup-active');
            floatingMsgBtn.classList.add('btn-active');
            chatBadge.style.display = 'none';
            chatOpen = true;
            scrollChat();
            saveChatState();
        }

        // Cerrar chat
        function closeChat() {
            msgChat.classList.remove('chat-popup-active');
            floatingMsgBtn.classList.remove('btn-active');
            chatOpen = false;
        }

        // Toggle chat
        floatingMsgBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (chatOpen) { closeChat(); } else { openChat(); }
        });

        closeMsgChat.addEventListener('click', function(e) {
            e.preventDefault();
            closeChat();
        });

        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && chatOpen) closeChat();
        });

        // Paso 1: Nombre
        document.getElementById('chatFormName').addEventListener('submit', function(e) {
            e.preventDefault();
            var name = document.getElementById('chatName').value.trim();
            if (!name) return;
            chatUserName = name;
            addBubble(name, 'user');
            document.getElementById('chatStep1').style.display = 'none';
            botReply('¡Encantados, ' + name + '! 😊 ¿Cuál es tu email para poder contactarte?').then(function() {
                document.getElementById('chatStep2').style.display = 'block';
                document.getElementById('chatEmail').focus();
                scrollChat();
                saveChatState();
            });
        });

        // Paso 2: Email
        document.getElementById('chatFormEmail').addEventListener('submit', function(e) {
            e.preventDefault();
            var email = document.getElementById('chatEmail').value.trim();
            if (!email) return;
            chatUserEmail = email;
            addBubble(email, 'user');
            document.getElementById('chatStep2').style.display = 'none';
            botReply('Perfecto. Cuéntanos, ¿en qué podemos ayudarte? 💡').then(function() {
                document.getElementById('chatStep3').style.display = 'block';
                document.getElementById('chatMsg').focus();
                scrollChat();
                saveChatState();
            });
        });

        // Paso 3: Mensaje (envío AJAX)
        document.getElementById('chatFormMsg').addEventListener('submit', function(e) {
            e.preventDefault();
            var msg = document.getElementById('chatMsg').value.trim();
            if (!msg) return;
            addBubble(msg, 'user');
            document.getElementById('chatStep3').style.display = 'none';

            var typing = showTyping();

            fetch('{{ route("chat.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: chatUserName,
                    email: chatUserEmail,
                    message: msg
                })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                typing.remove();
                addBubble('¡Gracias, ' + chatUserName + '! 🎉 Hemos recibido tu mensaje. Nuestro equipo te contactará pronto a <strong>' + chatUserEmail + '</strong>.', 'bot');
                document.getElementById('chatStepDone').style.display = 'flex';
                scrollChat();
                saveChatState();
            })
            .catch(function(err) {
                typing.remove();
                addBubble('¡Gracias, ' + chatUserName + '! Tu mensaje fue recibido. Te contactaremos pronto. 🙌', 'bot');
                document.getElementById('chatStepDone').style.display = 'flex';
                scrollChat();
                saveChatState();
            });
        });

        // ── Restaurar estado guardado ──
        var saved = loadChatState();
        if (saved) {
            // Restaurar nombre y email
            chatUserName = saved.name || '';
            chatUserEmail = saved.email || '';

            // Restaurar mensajes
            if (saved.messages && saved.messages.length > 0) {
                chatBody.innerHTML = '';
                saved.messages.forEach(function(m) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'chat-message chat-message-' + m.type;
                    if (m.type === 'bot') {
                        wrapper.innerHTML = '<div class="chat-avatar">UP</div><div class="chat-bubble">' + m.html + '</div>';
                    } else {
                        wrapper.innerHTML = '<div class="chat-bubble">' + m.html + '</div>';
                    }
                    chatBody.appendChild(wrapper);
                });
            }

            // Restaurar paso
            document.getElementById('chatStep1').style.display = 'none';
            document.getElementById('chatStep2').style.display = 'none';
            document.getElementById('chatStep3').style.display = 'none';
            document.getElementById('chatStepDone').style.display = 'none';

            if (saved.step === 'done' || saved.completed) {
                document.getElementById('chatStepDone').style.display = 'flex';
            } else if (saved.step === 3) {
                document.getElementById('chatStep3').style.display = 'block';
            } else if (saved.step === 2) {
                document.getElementById('chatStep2').style.display = 'block';
            } else {
                document.getElementById('chatStep1').style.display = 'block';
            }

            // Restaurar badge
            if (saved.badgeHidden) {
                chatBadge.style.display = 'none';
            }
        }
    });
    </script>

    <footer class="site-footer">
        {{-- CTA Banner Superior --}}
        <div class="footer-cta-banner">
            <div class="container-custom">
                <div class="cta-banner-content">
                    <div class="cta-banner-text">
                        <span class="cta-banner-label">¿Tienes un proyecto en mente?</span>
                        <h3 class="cta-banner-title">Hagamos Algo <span class="text-gradient">Increíble</span> Juntos</h3>
                        <p class="cta-banner-desc">Conversemos sobre cómo podemos ayudarte a alcanzar tus objetivos</p>
                    </div>
                    <div class="cta-banner-action">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary">
                            Iniciar Proyecto
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0l-6-6m6 6l-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contenido Principal del Footer --}}
        <div class="footer-content">
            <div class="container-custom">
                <div class="footer-grid">
                    {{-- Columna 1: Marca --}}
                    <div class="footer-brand">
                        <a href="/" class="footer-logo-link">
                            <span class="footer-logo-text">creative</span><span class="footer-logo-gradient">up</span>
                        </a>
                        <p class="footer-tagline">Transformamos ideas en experiencias digitales que conectan y convierten</p>
                        
                        <div class="footer-social-links">
                            <a href="#" class="social-icon" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon" aria-label="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="social-icon" aria-label="LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-icon" aria-label="Twitter">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Columna 2: Navegación --}}
                    <div class="footer-column">
                        <h4 class="footer-title">Navegación</h4>
                        <ul class="footer-list">
                            <li><a href="{{ route('home') }}" class="footer-link">Inicio</a></li>
                            <li><a href="{{ route('services.index') }}" class="footer-link">Servicios</a></li>
                            <li><a href="{{ route('projects.index') }}" class="footer-link">Proyectos</a></li>
                            <li><a href="{{ route('blog.index') }}" class="footer-link">Blog</a></li>
                            <li><a href="{{ route('contact.index') }}" class="footer-link">Contacto</a></li>
                        </ul>
                    </div>

                    {{-- Columna 3: Servicios --}}
                    <div class="footer-column">
                        <h4 class="footer-title">Servicios</h4>
                        <ul class="footer-list">
                            <li><a href="{{ route('services.index') }}" class="footer-link">Desarrollo Web</a></li>
                            <li><a href="{{ route('services.index') }}" class="footer-link">Diseño UI/UX</a></li>
                            <li><a href="{{ route('services.index') }}" class="footer-link">Branding</a></li>
                            <li><a href="{{ route('services.index') }}" class="footer-link">Marketing Digital</a></li>
                            <li><a href="{{ route('services.index') }}" class="footer-link">SEO</a></li>
                        </ul>
                    </div>

                    {{-- Columna 4: Contacto --}}
                    <div class="footer-column">
                        <h4 class="footer-title">Contacto</h4>
                        <ul class="footer-list footer-contact">
                            <li>
                                <a href="mailto:hola@creativeup.com" class="footer-contact-link">
                                    <i class="fa-regular fa-envelope"></i>
                                    <span>hola@creativeup.com</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:+1234567890" class="footer-contact-link">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>+1 (234) 567-890</span>
                                </a>
                            </li>
                            <li>
                                <span class="footer-contact-link">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Ciudad de México, MX</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barra Inferior --}}
        <div class="footer-bottom">
            <div class="container-custom">
                <div class="footer-bottom-content">
                    <p class="footer-copyright">
                        &copy; {{ date('Y') }} CreativeUp. Todos los derechos reservados.
                    </p>
                    <div class="footer-legal">
                        <a href="#" class="footer-legal-link">Política de Privacidad</a>
                        <span class="footer-separator">·</span>
                        <a href="#" class="footer-legal-link">Términos de Uso</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Menu Toggle & Logo Scroll Effects
        document.addEventListener('DOMContentLoaded', function() {
            const menuTrigger = document.getElementById('menuTrigger');
            const fullscreenMenu = document.getElementById('fullscreenMenu');
            const floatingLogo = document.getElementById('floatingLogo');
            
            // Toggle Menu
            if (menuTrigger && fullscreenMenu) {
                menuTrigger.addEventListener('click', function() {
                    menuTrigger.classList.toggle('active');
                    fullscreenMenu.classList.toggle('active');
                    document.body.style.overflow = fullscreenMenu.classList.contains('active') ? 'hidden' : '';
                });
                
                // Cerrar al hacer click en el backdrop
                const backdrop = fullscreenMenu.querySelector('.menu-backdrop');
                if (backdrop) {
                    backdrop.addEventListener('click', function() {
                        menuTrigger.classList.remove('active');
                        fullscreenMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
                
                // Cerrar al hacer click en un link
                const navLinks = fullscreenMenu.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        menuTrigger.classList.remove('active');
                        fullscreenMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                });
                
                // Cerrar al hacer click en el botón CTA
                const ctaButton = fullscreenMenu.querySelector('.cta-button');
                if (ctaButton) {
                    ctaButton.addEventListener('click', function() {
                        menuTrigger.classList.remove('active');
                        fullscreenMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
                
                // Cerrar con tecla ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && fullscreenMenu.classList.contains('active')) {
                        menuTrigger.classList.remove('active');
                        fullscreenMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            // Logo Scroll Effect
            if (floatingLogo) {
                window.addEventListener('scroll', function() {
                    const currentScroll = window.pageYOffset;
                    
                    if (currentScroll > 100) {
                        floatingLogo.classList.add('scrolled');
                    } else {
                        floatingLogo.classList.remove('scrolled');
                    }
                });
            }
        });
    </script>

@stack('scripts')
</body>
</html>