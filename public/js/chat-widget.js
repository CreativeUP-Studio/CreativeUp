/**
 * Chat Widget - Con Conversaciones en Tiempo Real
 * Versión 4.0 - Con persistencia de mensajes
 */

(function() {
    'use strict';
    
    // Estado del chat
    let isOpen = false;
    let userName = localStorage.getItem('chat_user_name') || '';
    let userEmail = localStorage.getItem('chat_user_email') || '';
    let conversationId = localStorage.getItem('chat_conversation_id') || null;
    let lastMessageId = parseInt(localStorage.getItem('chat_last_message_id') || '0');
    let hasUserInfo = !!(userName && userEmail && conversationId);
    let pollingInterval = null;
    let isLoadingHistory = false;
    
    // Elementos del DOM
    const chatTrigger = document.getElementById('chatTrigger');
    const chatWidget = document.getElementById('chatWidget');
    const chatClose = document.getElementById('chatClose');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const chatBody = document.getElementById('chatBody');
    
    // Verificar que los elementos existan
    if (!chatTrigger || !chatWidget || !chatClose || !chatForm || !chatInput || !chatBody) {
        console.error('Chat Widget: Elementos del DOM no encontrados');
        return;
    }
    
    /**
     * Inicializar chat - Cargar historial si existe conversación
     */
    function initializeChat() {
        if (conversationId && hasUserInfo) {
            loadConversationHistory();
            startPolling();
        }
    }
    
    /**
     * Agregar separador de fecha
     */
    function addDateSeparator(date) {
        const today = new Date();
        const messageDate = new Date(date);
        
        let dateText = '';
        if (messageDate.toDateString() === today.toDateString()) {
            dateText = 'Hoy';
        } else {
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            if (messageDate.toDateString() === yesterday.toDateString()) {
                dateText = 'Ayer';
            } else {
                dateText = messageDate.toLocaleDateString('es-ES', { 
                    day: 'numeric', 
                    month: 'long',
                    year: messageDate.getFullYear() !== today.getFullYear() ? 'numeric' : undefined
                });
            }
        }
        
        const separatorDiv = document.createElement('div');
        separatorDiv.className = 'chat-date-separator';
        separatorDiv.innerHTML = `<span>${dateText}</span>`;
        chatBody.appendChild(separatorDiv);
    }
    
    /**
     * Cargar historial de conversación
     */
    async function loadConversationHistory() {
        if (isLoadingHistory) return;
        isLoadingHistory = true;
        
        try {
            const response = await fetch(`/chat-messages/history?conversation_id=${conversationId}`);
            const data = await response.json();
            
            if (data.messages && data.messages.length > 0) {
                // Limpiar mensajes de bienvenida
                const welcomeMsg = chatBody.querySelector('.chat-welcome');
                const botMsg = chatBody.querySelector('.chat-message.bot');
                if (welcomeMsg) welcomeMsg.remove();
                if (botMsg) botMsg.remove();
                
                // Agrupar mensajes por fecha
                let lastDate = null;
                
                // Agregar mensajes del historial
                data.messages.forEach(message => {
                    const messageDate = new Date(message.created_at).toDateString();
                    
                    // Agregar separador de fecha si es necesario
                    if (messageDate !== lastDate) {
                        addDateSeparator(message.created_at);
                        lastDate = messageDate;
                    }
                    
                    const type = message.sender === 'user' ? 'user' : 'bot';
                    addMessage(message.message, type, true, message.created_at);
                    
                    if (message.id > lastMessageId) {
                        lastMessageId = message.id;
                        localStorage.setItem('chat_last_message_id', lastMessageId);
                    }
                });
                
                // Actualizar datos del usuario si están en el historial
                if (data.conversation) {
                    userName = data.conversation.name;
                    userEmail = data.conversation.email;
                    localStorage.setItem('chat_user_name', userName);
                    localStorage.setItem('chat_user_email', userEmail);
                }
                
                // Agregar mensaje del sistema
                const systemMsg = document.createElement('div');
                systemMsg.className = 'chat-system-message';
                systemMsg.innerHTML = '<i class="fas fa-info-circle"></i> Conversación cargada';
                chatBody.appendChild(systemMsg);
                
                // Remover mensaje del sistema después de 2 segundos
                setTimeout(() => {
                    systemMsg.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => systemMsg.remove(), 300);
                }, 2000);
            }
        } catch (error) {
            console.error('Error loading history:', error);
        } finally {
            isLoadingHistory = false;
        }
    }
    
    /**
     * Toggle del chat
     */
    function toggleChat() {
        isOpen = !isOpen;
        chatWidget.classList.toggle('is-open', isOpen);
        chatTrigger.classList.toggle('is-active', isOpen);
        
        if (isOpen) {
            chatInput.focus();
            const badge = chatTrigger.querySelector('.trigger-badge');
            if (badge) badge.style.display = 'none';
        }
    }
    
    /**
     * Agregar mensaje al chat
     */
    function addMessage(text, type = 'bot', showTime = true, timestamp = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${type}`;
        
        const messageTime = timestamp ? new Date(timestamp) : new Date();
        const time = showTime ? messageTime.toLocaleTimeString('es-ES', { 
            hour: '2-digit', 
            minute: '2-digit' 
        }) : '';
        
        const avatar = type === 'bot' ? 'UP' : (userName ? userName.charAt(0).toUpperCase() : 'U');
        
        // Determinar estado del mensaje para usuario
        const statusHtml = type === 'user' ? '<span class="message-status sent"><i class="fas fa-check-double"></i> Enviado</span>' : '';
        
        messageDiv.innerHTML = `
            <div class="message-avatar">${avatar}</div>
            <div class="message-content">
                <div class="message-bubble">${escapeHtml(text)}</div>
                ${showTime ? `
                    <div class="message-time">
                        <i class="fas fa-clock" style="font-size: 9px;"></i>
                        ${time}
                        ${statusHtml}
                    </div>
                ` : ''}
            </div>
        `;
        
        chatBody.appendChild(messageDiv);
        scrollToBottom();
    }
    
    /**
     * Mostrar loading
     */
    function showLoading() {
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'typing-indicator';
        loadingDiv.id = 'chatLoading';
        loadingDiv.innerHTML = `
            <div class="message-avatar">UP</div>
            <div class="message-content">
                <div class="message-bubble">
                    <div class="chat-loading">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        `;
        chatBody.appendChild(loadingDiv);
        scrollToBottom();
    }
    
    /**
     * Remover loading
     */
    function removeLoading() {
        const loading = document.getElementById('chatLoading');
        if (loading) loading.remove();
    }
    
    /**
     * Scroll al final
     */
    function scrollToBottom() {
        setTimeout(() => {
            chatBody.scrollTop = chatBody.scrollHeight;
        }, 100);
    }
    
    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    /**
     * Solicitar información del usuario
     */
    function requestUserInfo(firstMessage) {
        const formDiv = document.createElement('div');
        formDiv.className = 'chat-info-form';
        formDiv.innerHTML = `
            <div class="chat-message bot">
                <div class="message-avatar">UP</div>
                <div class="message-content">
                    <div class="message-bubble">
                        Para poder ayudarte mejor, necesito algunos datos:
                    </div>
                </div>
            </div>
            <form class="user-info-form" id="userInfoForm">
                <div class="form-group">
                    <label for="userName">
                        <i class="fas fa-user"></i>
                        Tu nombre
                    </label>
                    <input type="text" id="userNameInput" name="name" required placeholder="Ej: Juan Pérez" autocomplete="name">
                </div>
                <div class="form-group">
                    <label for="userEmail">
                        <i class="fas fa-envelope"></i>
                        Tu email
                    </label>
                    <input type="email" id="userEmailInput" name="email" required placeholder="tu@email.com" autocomplete="email">
                </div>
                <button type="submit" class="form-submit">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                        <path d="M18 2L9 11M18 2L12 18L9 11L2 8L18 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Enviar mensaje
                </button>
            </form>
        `;
        
        chatBody.appendChild(formDiv);
        scrollToBottom();
        
        // Focus en el primer input
        setTimeout(() => {
            document.getElementById('userNameInput').focus();
        }, 100);
        
        const userInfoForm = document.getElementById('userInfoForm');
        userInfoForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            userName = document.getElementById('userNameInput').value.trim();
            userEmail = document.getElementById('userEmailInput').value.trim();
            
            if (!userName || !userEmail) return;
            
            // Guardar en localStorage
            localStorage.setItem('chat_user_name', userName);
            localStorage.setItem('chat_user_email', userEmail);
            
            hasUserInfo = true;
            
            // Animación de salida del formulario
            formDiv.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                formDiv.remove();
                sendMessage(firstMessage);
            }, 300);
        });
    }
    
    /**
     * Enviar mensaje al servidor
     */
    async function sendMessage(message) {
        addMessage(message, 'user');
        showLoading();
        
        try {
            const response = await fetch('/chat-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    conversation_id: conversationId,
                    name: userName,
                    email: userEmail,
                    message: message
                })
            });
            
            removeLoading();
            
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            
            const data = await response.json();
            
            if (data.success) {
                // Guardar conversation_id
                if (data.conversation_id) {
                    const isNewConversation = !conversationId;
                    conversationId = data.conversation_id;
                    localStorage.setItem('chat_conversation_id', conversationId);
                    lastMessageId = data.message_id;
                    localStorage.setItem('chat_last_message_id', lastMessageId);
                    
                    // Iniciar polling
                    startPolling();
                    
                    // Mostrar mensaje de agradecimiento solo en la primera vez
                    if (isNewConversation) {
                        setTimeout(() => {
                            addMessage('¡Gracias! Hemos recibido tu mensaje. Te responderemos pronto.', 'bot');
                        }, 500);
                    }
                }
            } else {
                addMessage('Lo siento, hubo un error. Por favor intenta de nuevo.', 'bot');
            }
        } catch (error) {
            console.error('Error al enviar mensaje:', error);
            removeLoading();
            addMessage('Lo siento, hubo un error de conexión. Por favor intenta de nuevo.', 'bot');
        }
    }
    
    /**
     * Polling para nuevos mensajes del admin
     */
    function checkNewMessages() {
        if (!conversationId) return;
        
        fetch(`/chat-messages/new?conversation_id=${conversationId}&last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.has_new && data.messages.length > 0) {
                    let playSound = false;
                    data.messages.forEach(message => {
                        addMessage(message.message, 'bot', true, message.created_at);
                        lastMessageId = message.id;
                        localStorage.setItem('chat_last_message_id', lastMessageId);
                        
                        // Mostrar badge si el chat está cerrado
                        if (!isOpen) {
                            const badge = chatTrigger.querySelector('.trigger-badge');
                            if (badge) {
                                badge.style.display = 'flex';
                                badge.textContent = '1';
                            }
                        }
                        playSound = true;
                    });

                    if (playSound) {
                        playNotificationSound();
                    }
                }
            })
            .catch(error => console.error('Error checking messages:', error));
    }
    
    /**
     * Iniciar polling
     */
    function startPolling() {
        if (pollingInterval) return;
        pollingInterval = setInterval(checkNewMessages, 3000);
    }
    
    /**
     * Detener polling
     */
    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }

    /**
     * Reproducir sonido de notificación premium usando Web Audio API
     */
    function playNotificationSound() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            const ctx = new AudioContext();
            
            const playNote = (frequency, startTime, duration) => {
                const osc = ctx.createOscillator();
                const gainNode = ctx.createGain();
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(frequency, startTime);
                
                gainNode.gain.setValueAtTime(0, startTime);
                gainNode.gain.linearRampToValueAtTime(0.2, startTime + 0.04);
                gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);
                
                osc.connect(gainNode);
                gainNode.connect(ctx.destination);
                
                osc.start(startTime);
                osc.stop(startTime + duration);
            };
            
            const now = ctx.currentTime;
            // Tono limpio dual: Sol5 (784Hz) seguido de Do6 (1046.5Hz)
            playNote(784, now, 0.35);
            playNote(1046.5, now + 0.08, 0.45);
        } catch (e) {
            console.warn('Audio context failed to play sound:', e);
        }
    }
    
    /**
     * Event Listeners
     */
    
    chatTrigger.addEventListener('click', toggleChat);
    chatClose.addEventListener('click', toggleChat);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) {
            toggleChat();
        }
    });
    
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message) return;
        
        chatInput.value = '';
        
        if (!hasUserInfo) {
            requestUserInfo(message);
            return;
        }
        
        await sendMessage(message);
    });
    
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    
    // Limpiar polling al salir
    window.addEventListener('beforeunload', function() {
        stopPolling();
    });
    
    // Inicializar al cargar
    initializeChat();
    
    console.log('Chat Widget: Inicializado con persistencia de mensajes');
})();
