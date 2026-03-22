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
<body class="bg-gray-950 text-white @yield('body-class')">

    <header class="topbar anim-hidden" data-anim="fade-down">
        <a href="/" class="topbar-logo anim-hidden" data-anim="fade-left">
            <span class="logo-creative">creative</span><span class="logo-up">up</span>
        </a>
        <button class="topbar-dots anim-hidden" data-anim="fade-right" aria-label="Menú">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </button>
    </header>

    {{-- Menú Fullscreen Premium --}}
    <div class="fullscreen-menu" id="fullscreenMenu">
        <div class="menu-overlay"></div>
        <div class="menu-content">
            {{-- Header del menú --}}
            <div class="menu-header">
                <div class="menu-logo">
                    <span class="menu-logo-creative">creative</span><span class="menu-logo-up">up</span>
                </div>
            </div>

            {{-- Grid de 2 columnas --}}
            <div class="menu-grid">
                {{-- Columna izquierda: Navegación --}}
                <div class="menu-left-col">
                    <nav class="menu-nav">
                        <ul class="menu-links">
                            <li class="menu-link-item" style="--i: 0" data-page="home">
                                <a href="{{ route('home') }}" class="menu-link">
                                    <div class="menu-link-icon">
                                        <i class="fa-solid fa-house"></i>
                                    </div>
                                    <div class="menu-link-content">
                                        <span class="menu-link-number">01</span>
                                        <span class="menu-link-text">Inicio</span>
                                    </div>
                                    <div class="menu-link-arrow">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="menu-link-item" style="--i: 1" data-page="services">
                                <a href="{{ route('services.index') }}" class="menu-link">
                                    <div class="menu-link-icon">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>
                                    <div class="menu-link-content">
                                        <span class="menu-link-number">02</span>
                                        <span class="menu-link-text">Servicios</span>
                                    </div>
                                    <div class="menu-link-arrow">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="menu-link-item" style="--i: 2" data-page="projects">
                                <a href="{{ route('projects.index') }}" class="menu-link">
                                    <div class="menu-link-icon">
                                        <i class="fa-solid fa-folder-open"></i>
                                    </div>
                                    <div class="menu-link-content">
                                        <span class="menu-link-number">03</span>
                                        <span class="menu-link-text">Proyectos</span>
                                    </div>
                                    <div class="menu-link-arrow">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="menu-link-item" style="--i: 3" data-page="blog">
                                <a href="{{ route('blog.index') }}" class="menu-link">
                                    <div class="menu-link-icon">
                                        <i class="fa-solid fa-newspaper"></i>
                                    </div>
                                    <div class="menu-link-content">
                                        <span class="menu-link-number">04</span>
                                        <span class="menu-link-text">Blog</span>
                                    </div>
                                    <div class="menu-link-arrow">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="menu-link-item" style="--i: 4" data-page="contact">
                                <a href="{{ route('contact.index') }}" class="menu-link">
                                    <div class="menu-link-icon">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </div>
                                    <div class="menu-link-content">
                                        <span class="menu-link-number">05</span>
                                        <span class="menu-link-text">Contacto</span>
                                    </div>
                                    <div class="menu-link-arrow">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    {{-- Stats --}}
                    <div class="menu-stats">
                        <div class="menu-stat-item">
                            <span class="menu-stat-number">150+</span>
                            <span class="menu-stat-label">Proyectos</span>
                        </div>
                        <div class="menu-stat-item">
                            <span class="menu-stat-number">95%</span>
                            <span class="menu-stat-label">Satisfacción</span>
                        </div>
                        <div class="menu-stat-item">
                            <span class="menu-stat-number">5+</span>
                            <span class="menu-stat-label">Años</span>
                        </div>
                    </div>

                    {{-- Redes sociales --}}
                    <div class="menu-social">
                        <span class="menu-social-label">Síguenos</span>
                        <div class="menu-social-links">
                            <a href="#" class="menu-social-link" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="menu-social-link" aria-label="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="menu-social-link" aria-label="TikTok">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                            <a href="#" class="menu-social-link" aria-label="LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: Info y CTAs --}}
                <div class="menu-right-col">
                    {{-- Servicios destacados --}}
                    <div class="menu-section">
                        <h3 class="menu-section-title">Servicios Destacados</h3>
                        <div class="menu-services-grid">
                            <a href="{{ route('services.index') }}" class="menu-service-card">
                                <div class="menu-service-icon">
                                    <i class="fa-solid fa-code"></i>
                                </div>
                                <span class="menu-service-name">Desarrollo Web</span>
                            </a>
                            <a href="{{ route('services.index') }}" class="menu-service-card">
                                <div class="menu-service-icon">
                                    <i class="fa-solid fa-palette"></i>
                                </div>
                                <span class="menu-service-name">Branding</span>
                            </a>
                            <a href="{{ route('services.index') }}" class="menu-service-card">
                                <div class="menu-service-icon">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>
                                <span class="menu-service-name">Social Media</span>
                            </a>
                            <a href="{{ route('services.index') }}" class="menu-service-card">
                                <div class="menu-service-icon">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <span class="menu-service-name">SEO</span>
                            </a>
                        </div>
                    </div>

                    {{-- CTA Principal --}}
                    <div class="menu-section">
                        <div class="menu-cta-card">
                            <div class="menu-cta-badge">
                                <i class="fa-solid fa-sparkles"></i>
                                <span>Consultoría Gratuita</span>
                            </div>
                            <h3 class="menu-cta-title">¿Tienes un proyecto en mente?</h3>
                            <p class="menu-cta-desc">Conversemos sobre cómo podemos ayudarte a alcanzar tus objetivos digitales.</p>
                            <a href="{{ route('contact.index') }}" class="menu-cta-btn">
                                <span>Iniciar Proyecto</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Info de contacto --}}
                    <div class="menu-section">
                        <h3 class="menu-section-title">Contacto</h3>
                        <div class="menu-contact-grid">
                            <a href="mailto:hola@creativeup.com" class="menu-contact-item">
                                <div class="menu-contact-icon">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div class="menu-contact-info">
                                    <span class="menu-contact-label">Email</span>
                                    <span class="menu-contact-value">hola@creativeup.com</span>
                                </div>
                            </a>
                            <a href="tel:+1234567890" class="menu-contact-item">
                                <div class="menu-contact-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="menu-contact-info">
                                    <span class="menu-contact-label">Teléfono</span>
                                    <span class="menu-contact-value">+1 (234) 567-890</span>
                                </div>
                            </a>
                        </div>
                        <div class="menu-schedule">
                            <i class="fa-regular fa-clock"></i>
                            <span>Lunes a Viernes, 9:00 AM - 6:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Chat flotante -->
    <div id="msgChat" class="msg-chat">
        <div class="chat-header-anim">
            <div class="chat-header-left">
                <div class="chat-logo-up">UP</div>
                <div>
                    <div class="chat-title">Chat UP</div>
                    <div class="chat-status">
                        <span class="chat-status-dot"></span>Disponible ahora
                    </div>
                </div>
            </div>
            <button id="closeMsgChat" class="chat-close-btn" aria-label="Cerrar chat">&times;</button>
        </div>
        <div class="chat-body" id="chatBody">
            <div class="chat-message chat-message-bot">
                <div class="chat-avatar">UP</div>
                <div class="chat-bubble">
                    ¡Hola! 👋 Soy el asistente de CreativeUP. ¿En qué puedo ayudarte?
                </div>
            </div>
        </div>
        <div id="chatFormArea">
            {{-- Paso 1: Nombre --}}
            <div class="chat-step" id="chatStep1">
                <div class="chat-step-label">¿Cómo te llamas?</div>
                <form class="chat-form" id="chatFormName">
                    <input type="text" id="chatName" placeholder="Tu nombre..." class="chat-input" required autocomplete="off">
                    <button type="submit" class="chat-submit-btn" aria-label="Enviar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
                    </button>
                </form>
            </div>
            {{-- Paso 2: Email --}}
            <div class="chat-step" id="chatStep2" style="display:none">
                <div class="chat-step-label">¿Cuál es tu email?</div>
                <form class="chat-form" id="chatFormEmail">
                    <input type="email" id="chatEmail" placeholder="tu@email.com" class="chat-input" required autocomplete="off">
                    <button type="submit" class="chat-submit-btn" aria-label="Enviar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
                    </button>
                </form>
            </div>
            {{-- Paso 3: Mensaje --}}
            <div class="chat-step" id="chatStep3" style="display:none">
                <div class="chat-step-label">¿Cuéntanos en qué te ayudamos?</div>
                <form class="chat-form" id="chatFormMsg">
                    <input type="text" id="chatMsg" placeholder="Escribe tu mensaje..." class="chat-input" required autocomplete="off">
                    <button type="submit" class="chat-submit-btn" aria-label="Enviar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
                    </button>
                </form>
            </div>
            {{-- Paso final: confirmación --}}
            <div class="chat-step" id="chatStepDone" style="display:none">
                <div class="chat-step-done">
                    <span class="chat-done-check">✓</span> Mensaje enviado
                </div>
            </div>
        </div>
        <div class="chat-disclaimer">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
            Chat privado y seguro
        </div>
    </div>

    <!-- Botón flotante de mensaje -->
    <button id="floatingMsgBtn" class="floating-msg-btn" aria-label="Abrir chat">
        <span class="floating-msg-icon-open">
            <i class="fa-regular fa-comment-dots"></i>
        </span>
        <span class="floating-msg-icon-close">
            <i class="fa-solid fa-xmark"></i>
        </span>
        <span class="floating-msg-badge" id="chatBadge">1</span>
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
                wrapper.innerHTML = '<div class="chat-avatar">UP</div><div class="chat-bubble">' + text + '</div>';
            } else {
                wrapper.innerHTML = '<div class="chat-bubble">' + text + '</div>';
            }
            chatBody.appendChild(wrapper);
            scrollChat();
            if (!skipSave) saveChatState();
        }

        // Mostrar typing indicator
        function showTyping() {
            const typing = document.createElement('div');
            typing.className = 'chat-message chat-message-bot chat-typing-wrapper';
            typing.innerHTML = '<div class="chat-avatar">UP</div><div class="chat-bubble chat-typing"><span></span><span></span><span></span></div>';
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
            msgChat.classList.add('chat-visible');
            floatingMsgBtn.classList.add('chat-active');
            chatBadge.style.display = 'none';
            chatOpen = true;
            scrollChat();
            saveChatState();
        }

        // Cerrar chat
        function closeChat() {
            msgChat.classList.remove('chat-visible');
            floatingMsgBtn.classList.remove('chat-active');
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
        {{-- Línea gradiente superior --}}
        <div class="footer-gradient-line"></div>

        {{-- CTA Banner --}}
        <div class="footer-cta">
            <div class="footer-cta-inner">
                <div class="footer-cta-text">
                    <h3 class="footer-cta-title">¿Listo para llevar tu marca al siguiente nivel?</h3>
                    <p class="footer-cta-desc">Hablemos de tu próximo proyecto. Sin compromiso.</p>
                </div>
                <a href="{{ route('contact.index') }}" class="footer-cta-btn">
                    <span>Iniciar conversación</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Contenido principal del footer --}}
        <div class="footer-main">
            <div class="footer-container">

                {{-- Col 1: Marca --}}
                <div class="footer-col footer-col--brand">
                    <a href="/" class="footer-logo">
                        <span class="footer-logo-creative">creative</span><span class="footer-logo-up">up</span>
                    </a>
                    <p class="footer-brand-desc">Potenciamos la experiencia digital de negocios en cualquier etapa y en cualquier parte del mundo.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook" class="footer-social-link">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" aria-label="Instagram" class="footer-social-link">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" aria-label="TikTok" class="footer-social-link">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                {{-- Col 2: Navegación --}}
                <div class="footer-col">
                    <h4 class="footer-heading">Navegación</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}" class="footer-link">Inicio</a></li>
                        <li><a href="{{ route('services.index') }}" class="footer-link">Servicios</a></li>
                        <li><a href="{{ route('projects.index') }}" class="footer-link">Proyectos</a></li>
                        <li><a href="{{ route('blog.index') }}" class="footer-link">Blog</a></li>
                        <li><a href="{{ route('contact.index') }}" class="footer-link">Contacto</a></li>
                    </ul>
                </div>

                {{-- Col 3: Servicios --}}
                <div class="footer-col">
                    <h4 class="footer-heading">Servicios</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('services.index') }}" class="footer-link">Desarrollo Web</a></li>
                        <li><a href="{{ route('services.index') }}" class="footer-link">Branding</a></li>
                        <li><a href="{{ route('services.index') }}" class="footer-link">Social Media</a></li>
                        <li><a href="{{ route('services.index') }}" class="footer-link">SEO Profesional</a></li>
                    </ul>
                </div>

                {{-- Col 4: Contacto --}}
                <div class="footer-col">
                    <h4 class="footer-heading">Contacto</h4>
                    <ul class="footer-links">
                        <li>
                            <a href="mailto:hola@creativeup.com" class="footer-link footer-link--icon">
                                <i class="fa-regular fa-envelope"></i>
                                hola@creativeup.com
                            </a>
                        </li>
                        <li>
                            <a href="tel:+1234567890" class="footer-link footer-link--icon">
                                <i class="fa-solid fa-phone"></i>
                                +1 (234) 567-890
                            </a>
                        </li>
                        <li>
                            <span class="footer-link footer-link--icon footer-link--static">
                                <i class="fa-solid fa-location-dot"></i>
                                Ciudad de México, MX
                            </span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Barra inferior --}}
        <div class="footer-bottom">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">&copy; {{ date('Y') }} CreativeUP. Todos los derechos reservados.</p>
                <p class="footer-credit">Diseñado con <span class="footer-heart">&hearts;</span> por el equipo CreativeUP</p>
            </div>
        </div>
    </footer>

@stack('scripts')
</body>
</html>