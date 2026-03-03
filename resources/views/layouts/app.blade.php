<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | CreativeUP</title>
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

    {{-- Menú Fullscreen --}}
    <div class="fullscreen-menu" id="fullscreenMenu">
        <div class="menu-overlay"></div>
        <div class="menu-content">
            <div class="menu-section menu-links-section" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:40px;width:100%;">
                <nav class="menu-nav">
                    <ul class="menu-links">
                        <li class="menu-link-item" style="--i: 0">
                            <a href="{{ route('home') }}" class="menu-link">
                                <span class="menu-link-number">01</span>
                                <span class="menu-link-text">Inicio</span>
                                <span class="menu-link-arrow">&longrightarrow;</span>
                            </a>
                        </li>
                        <li class="menu-link-item" style="--i: 1">
                            <a href="{{ route('services.index') }}" class="menu-link">
                                <span class="menu-link-number">02</span>
                                <span class="menu-link-text">Servicios</span>
                                <span class="menu-link-arrow">&longrightarrow;</span>
                            </a>
                        </li>
                        <li class="menu-link-item" style="--i: 2">
                            <a href="{{ route('projects.index') }}" class="menu-link">
                                <span class="menu-link-number">03</span>
                                <span class="menu-link-text">Proyectos</span>
                                <span class="menu-link-arrow">&longrightarrow;</span>
                            </a>
                        </li>
                        <li class="menu-link-item" style="--i: 3">
                            <a href="{{ route('blog.index') }}" class="menu-link">
                                <span class="menu-link-number">04</span>
                                <span class="menu-link-text">Blog</span>
                                <span class="menu-link-arrow">&longrightarrow;</span>
                            </a>
                        </li>
                        <li class="menu-link-item" style="--i: 4">
                            <a href="{{ route('contact.index') }}" class="menu-link">
                                <span class="menu-link-number">05</span>
                                <span class="menu-link-text">Contacto</span>
                                <span class="menu-link-arrow">&longrightarrow;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="menu-section menu-image-section" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:40px;width:100%;">
                <div class="menu-image-hover-container" style="position:relative;width:340px;height:220px;margin-bottom:32px;">
                    <div id="menuLogoUP" class="menu-logo-up-gradient" style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;z-index:1;transition:opacity 0.3s;opacity:1;">
                        <span style="font-size:72px;font-weight:bold;background:linear-gradient(135deg,#5e17eb,#ff00cc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:2px;">UP</span>
                    </div>
                    <img id="menuBlobImage" src="/images/menu/inicio.jpg" alt="Imagen menú" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);height:80vh;width:auto;object-fit:cover;border-radius:24px;box-shadow:0 4px 24px rgba(94,23,235,0.18);z-index:2;transition:opacity 0.3s;" />
                </div>
            </div>
            <div class="menu-section menu-info-section" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:24px;width:100%;">
                <div class="menu-info-block menu-info-services" style="width:100%;max-width:340px;">
                    <h4 class="menu-info-title">Nuestros servicios</h4>
                    <ul class="menu-info-list">
                        <li><a href="{{ route('services.index') }}">Social Media</a></li>
                        <li><a href="{{ route('services.index') }}">Branding</a></li>
                        <li><a href="{{ route('services.index') }}">Desarrollo Web</a></li>
                        <li><a href="{{ route('services.index') }}">SEO Profesional</a></li>
                    </ul>
                </div>
                <div class="menu-info-block menu-info-contact" style="width:100%;max-width:340px;">
                    <h4 class="menu-info-title">Hablemos</h4>
                    <ul class="menu-info-list">
                        <li><a href="mailto:hola@creativeup.com">hola@creativeup.com</a></li>
                        <li><a href="tel:+1234567890">+1 (234) 567-890</a></li>
                    </ul>
                </div>
                <div class="menu-info-block menu-info-social" style="width:100%;max-width:340px;">
                    <h4 class="menu-info-title">Síguenos</h4>
                    <div class="menu-social-links">
                        <a href="#" class="menu-social-link" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22">
                                <rect x="2" y="2" width="20" height="20" rx="5"/>
                                <circle cx="12" cy="12" r="5"/>
                                <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/>
                            </svg>
                        </a>
                        <a href="#" class="menu-social-link" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                                <path d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.3 6.5a1.78 1.78 0 01-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z"/>
                            </svg>
                        </a>
                        <a href="#" class="menu-social-link" aria-label="Behance">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                                <path d="M7.5 11c1.38 0 2.5-1.12 2.5-2.5S8.88 6 7.5 6H3v5h4.5zm0 2H3v5h4.5c1.38 0 2.5-1.12 2.5-2.5S8.88 13 7.5 13zM21 12.5c0-2.49-2.01-4.5-4.5-4.5S12 10.01 12 12.5s2.01 4.5 4.5 4.5c1.8 0 3.36-1.06 4.08-2.59h-2.15c-.47.66-1.18 1.09-1.93 1.09-1.38 0-2.5-1.12-2.5-2.5h7zM14 11.5c.28-1.2 1.32-2 2.5-2s2.22.8 2.5 2h-5zM15 5h5v1.5h-5z"/>
                            </svg>
                        </a>
                        <a href="#" class="menu-social-link" aria-label="Dribbble">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72M19.13 5.09C15.22 9.14 10.93 10.44 2.25 10.94M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"/>
                            </svg>
                        </a>
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
        <svg class="floating-msg-icon-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="26" height="26">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
            <circle cx="8" cy="10" r="1.2"/>
            <circle cx="12" cy="10" r="1.2"/>
            <circle cx="16" cy="10" r="1.2"/>
        </svg>
        <svg class="floating-msg-icon-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </svg>
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
        <div class="footer-container">
            <!-- Logo -->
            <div class="footer-col">
                <a href="/" class="topbar-logo footer-logo">
                    <span class="logo-creative footer-logo-creative">creative</span><span class="logo-up">up</span>
                </a>
            </div>
            <!-- Servicios -->
            <div class="footer-col">
                <div class="footer-heading">Servicios</div>
                <ul class="footer-links">
                    <li><a href="{{ route('services.index') }}" class="footer-link footer-link--purple">Desarrollo Web</a></li>
                    <li><a href="{{ route('services.index') }}" class="footer-link footer-link--pink">Branding</a></li>
                    <li><a href="{{ route('services.index') }}" class="footer-link footer-link--dark">Marketing Digital</a></li>
                    <li><a href="{{ route('services.index') }}" class="footer-link footer-link--purple">Diseño UX/UI</a></li>
                    <li><a href="{{ route('services.index') }}" class="footer-link footer-link--pink">Consultoría</a></li>
                </ul>
            </div>
            <!-- Redes sociales -->
            <div class="footer-col">
                <div class="footer-heading">Síguenos</div>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram" class="footer-social-link footer-social-link--pink"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg></a>
                    <a href="#" aria-label="LinkedIn" class="footer-social-link footer-social-link--purple"><svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.3 6.5a1.78 1.78 0 01-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z"/></svg></a>
                    <a href="#" aria-label="Behance" class="footer-social-link footer-social-link--dark"><svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M7.5 11c1.38 0 2.5-1.12 2.5-2.5S8.88 6 7.5 6H3v5h4.5zm0 2H3v5h4.5c1.38 0 2.5-1.12 2.5-2.5S8.88 13 7.5 13zM21 12.5c0-2.49-2.01-4.5-4.5-4.5S12 10.01 12 12.5s2.01 4.5 4.5 4.5c1.8 0 3.36-1.06 4.08-2.59h-2.15c-.47.66-1.18 1.09-1.93 1.09-1.38 0-2.5-1.12-2.5-2.5h7zM14 11.5c.28-1.2 1.32-2 2.5-2s2.22.8 2.5 2h-5zM15 5h5v1.5h-5z"/></svg></a>
                    <a href="#" aria-label="Dribbble" class="footer-social-link footer-social-link--dark"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72M19.13 5.09C15.22 9.14 10.93 10.44 2.25 10.94M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"/></svg></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; CreativeUP. Todos los derechos reservados.<br>
            <span class="footer-credit">con <span class="footer-heart">♥</span> hecho por el equipo de CreativeUP</span>
        </div>
    </footer>

@stack('scripts')
</body>
</html>