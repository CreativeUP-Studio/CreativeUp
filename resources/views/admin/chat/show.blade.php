@extends('admin.layouts.app')

@section('title', 'Conversación con ' . $conversation->name)
@section('page-title', 'Chat con ' . $conversation->name)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/chat.css') }}">
@endpush

@section('content')
<div class="chat-conversation-wrapper">
    {{-- Header Compact --}}
    <div class="admin-compact-header" style="margin-bottom: 1.5rem;">
        <div class="admin-compact-header-left">
            <a href="{{ route('admin.chat.index') }}" class="admin-compact-header-back" title="Volver a la lista">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="admin-compact-header-info">
                <h1>
                    <i class="fa-solid fa-comments"></i>
                    {{ $conversation->name }}
                    <span class="admin-badge admin-badge-blue" style="margin-left: 0.5rem; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 12px; font-weight: 600;">
                        <i class="fa-solid fa-envelope" style="font-size: 0.65rem;"></i> {{ $conversation->email }}
                    </span>
                    <span class="admin-badge admin-badge-purple" style="margin-left: 0.5rem; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 12px; font-weight: 600;">
                        <i class="fa-solid fa-comment" style="font-size: 0.65rem;"></i> {{ $messages->count() }} mensajes
                    </span>
                </h1>
            </div>
        </div>
        <div class="admin-compact-header-actions">
            <button onclick="deleteConversationFromShow('{{ $conversationId }}', '{{ $conversation->name }}')" class="admin-btn admin-btn-danger" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
                <i class="fa-solid fa-trash"></i>
                <span>Eliminar</span>
            </button>
        </div>
    </div>

    <form id="delete-form" action="{{ route('admin.chat.destroy', $conversationId) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Contenedor de Mensajes --}}
    <div class="chat-conversation-container">
        {{-- Messages --}}
        <div class="chat-messages-container" id="messagesContainer">
            @foreach($messages as $message)
                <div class="chat-message-item {{ $message->sender }}" data-message-id="{{ $message->id }}">
                    <div class="message-avatar-circle">
                        {{ $message->sender === 'admin' ? 'A' : strtoupper(substr($message->name, 0, 1)) }}
                    </div>
                    <div class="message-content-wrapper">
                        <div class="message-bubble-item">
                            {{ $message->message }}
                        </div>
                        <div class="message-time-stamp">
                            <i class="fas fa-clock"></i>
                            {{ $message->created_at->format('d/m/Y H:i') }}
                            @if($message->sender === 'admin')
                                <span class="message-status">
                                    <i class="fas fa-check-double"></i> Enviado
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            
            {{-- Typing Indicator --}}
            <div class="chat-message-item user" style="display: none;">
                <div class="message-avatar-circle">
                    {{ strtoupper(substr($conversation->name, 0, 1)) }}
                </div>
                <div class="message-content-wrapper">
                    <div class="typing-indicator" id="typingIndicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Replies --}}
        <div class="quick-replies">
            <button type="button" class="quick-reply-btn" data-text="¡Hola! Gracias por contactarnos. ¿En qué podemos ayudarte?">
                👋 Saludo
            </button>
            <button type="button" class="quick-reply-btn" data-text="Perfecto, déjame revisar eso y te respondo en breve.">
                ⏱️ Revisar
            </button>
            <button type="button" class="quick-reply-btn" data-text="¿Podrías darme más detalles sobre lo que necesitas?">
                ℹ️ Más info
            </button>
            <button type="button" class="quick-reply-btn" data-text="¡Excelente! Nos pondremos en contacto contigo pronto.">
                ✅ Confirmar
            </button>
            <button type="button" class="quick-reply-btn" data-text="Gracias por tu mensaje. Te responderemos lo antes posible.">
                🙏 Gracias
            </button>
        </div>

        {{-- Reply Form --}}
        <div class="chat-reply-form">
            <form id="replyForm" style="display: flex; gap: 1rem; width: 100%; align-items: flex-end;">
                @csrf
                <div class="reply-input-wrapper">
                    <textarea 
                        id="replyMessage" 
                        name="message" 
                        class="reply-textarea" 
                        placeholder="Escribe tu respuesta..." 
                        required
                        maxlength="2000"></textarea>
                    <div class="reply-char-count">
                        <span id="charCount">0</span>/2000
                    </div>
                </div>
                <button type="submit" class="reply-button" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                    <span>Enviar</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    const replyForm = document.getElementById('replyForm');
    if (!replyForm || replyForm.dataset.initialized === 'true') return;
    replyForm.dataset.initialized = 'true';

    const conversationId = '{{ $conversationId }}';
    const messagesContainer = document.getElementById('messagesContainer');
    const replyMessage = document.getElementById('replyMessage');
    const sendButton = document.getElementById('sendButton');
    const charCount = document.getElementById('charCount');
    const typingIndicator = document.getElementById('typingIndicator');
    const quickReplyButtons = document.querySelectorAll('.quick-reply-btn');
    
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    let pollingInterval;
    let isTyping = false;

    // Scroll al final
    function scrollToBottom(smooth = true) {
        if (smooth) {
            messagesContainer.scrollTo({
                top: messagesContainer.scrollHeight,
                behavior: 'smooth'
            });
        } else {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    scrollToBottom(false);

    // Contador de caracteres
    replyMessage.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        
        // Auto-resize
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 150) + 'px';
    });

    // Quick replies
    quickReplyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const text = this.dataset.text;
            replyMessage.value = text;
            charCount.textContent = text.length;
            replyMessage.focus();
            
            // Animación
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });

    // Agregar mensaje al DOM
    function addMessage(message) {
        // Evitar duplicados comprobando si el ID del mensaje ya existe en el DOM
        if (document.querySelector(`[data-message-id="${message.id}"]`)) {
            // Actualizar el lastMessageId por si acaso
            if (message.id > lastMessageId) {
                lastMessageId = message.id;
            }
            return;
        }

        // Remover typing indicator si existe
        typingIndicator.classList.remove('active');
        const typingContainer = typingIndicator.closest('.chat-message-item');
        if (typingContainer) {
            typingContainer.style.display = 'none';
        }
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message-item ${message.sender}`;
        messageDiv.setAttribute('data-message-id', message.id);
        
        const avatar = message.sender === 'admin' ? 'A' : message.name.charAt(0).toUpperCase();
        const time = new Date(message.created_at).toLocaleString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const statusHtml = message.sender === 'admin' 
            ? '<span class="message-status"><i class="fas fa-check-double"></i> Enviado</span>'
            : '';
        
        messageDiv.innerHTML = `
            <div class="message-avatar-circle">${avatar}</div>
            <div class="message-content-wrapper">
                <div class="message-bubble-item">${escapeHtml(message.message)}</div>
                <div class="message-time-stamp">
                    <i class="fas fa-clock"></i>
                    ${time}
                    ${statusHtml}
                </div>
            </div>
        `;
        
        // Insertar antes del typing indicator
        messagesContainer.insertBefore(messageDiv, typingContainer);
        
        scrollToBottom();
        lastMessageId = message.id;
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Mostrar typing indicator
    function showTyping() {
        if (!isTyping) {
            isTyping = true;
            typingIndicator.classList.add('active');
            const typingContainer = typingIndicator.closest('.chat-message-item');
            if (typingContainer) {
                typingContainer.style.display = 'flex';
            }
            scrollToBottom();
        }
    }

    // Ocultar typing indicator
    function hideTyping() {
        isTyping = false;
        typingIndicator.classList.remove('active');
        const typingContainer = typingIndicator.closest('.chat-message-item');
        if (typingContainer) {
            typingContainer.style.display = 'none';
        }
    }

    // Polling para nuevos mensajes
    function checkNewMessages() {
        // Auto-limpieza del intervalo al cambiar de página mediante Turbo
        if (!document.getElementById('messagesContainer')) {
            if (pollingInterval) {
                clearInterval(pollingInterval);
            }
            return;
        }

        fetch(`/admin/chat/${conversationId}/new-messages?last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.has_new) {
                    hideTyping();
                    data.messages.forEach(message => {
                        addMessage(message);
                    });
                }
            })
            .catch(error => console.error('Error checking messages:', error));
    }

    // Iniciar polling cada 3 segundos
    pollingInterval = setInterval(checkNewMessages, 3000);

    // Enviar respuesta
    replyForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = replyMessage.value.trim();
        if (!message) return;
        
        sendButton.disabled = true;
        sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Enviando...</span>';
        
        try {
            const response = await fetch(`/admin/chat/${conversationId}/reply`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Agregar el mensaje inmediatamente (sin esperar al polling)
                addMessage(data.message);
                
                // Actualizar lastMessageId para evitar duplicados en el polling
                lastMessageId = data.message.id;
                
                replyMessage.value = '';
                charCount.textContent = '0';
                replyMessage.style.height = 'auto';
                
                // Mostrar toast de éxito
                Toast.fire({
                    icon: 'success',
                    title: 'Mensaje enviado',
                    text: 'Tu respuesta ha sido enviada correctamente'
                });
                
                // Mostrar typing indicator brevemente
                setTimeout(() => showTyping(), 500);
                setTimeout(() => hideTyping(), 2000);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo enviar el mensaje'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Toast.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Por favor verifica tu conexión a internet'
            });
        } finally {
            sendButton.disabled = false;
            sendButton.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Enviar</span>';
        }
    });

    // Función para eliminar conversación
    window.deleteConversationFromShow = async function(conversationId, userName) {
        const result = await confirmDelete(`la conversación con <strong>${userName}</strong>`);
        
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            document.getElementById('delete-form').submit();
        }
    };

    // Atajos de teclado
    replyMessage.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter para enviar
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            replyForm.dispatchEvent(new Event('submit'));
        }
    });

    // Limpiar polling al salir
    window.addEventListener('beforeunload', function() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
    });
    
    console.log('Admin Chat Conversation: Inicializado');
})();
</script>
@endpush
