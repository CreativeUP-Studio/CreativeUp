/**
 * Sistema de Notificaciones en Tiempo Real para Admin
 * Versión 1.0
 */

(function() {
    'use strict';
    
    // Estado
    let lastNotificationCheck = Date.now();
    let notificationSound = null;
    let isPageVisible = true;
    let processedMessageIds = new Set(); // IDs de mensajes ya procesados
    let processedConversationIds = new Set(); // IDs de conversaciones ya procesadas
    
    // Configuración
    const POLLING_INTERVAL = 5000; // 5 segundos
    const SOUND_URL = '/sounds/notification.mp3';
    const STORAGE_KEY_MESSAGES = 'admin_processed_messages';
    const STORAGE_KEY_CONVERSATIONS = 'admin_processed_conversations';
    const STORAGE_EXPIRY_HOURS = 24; // Limpiar después de 24 horas
    
    /**
     * Cargar mensajes procesados desde localStorage
     */
    function loadProcessedMessages() {
        try {
            // Cargar mensajes procesados
            const storedMessages = localStorage.getItem(STORAGE_KEY_MESSAGES);
            if (storedMessages) {
                const data = JSON.parse(storedMessages);
                // Verificar si no ha expirado (24 horas)
                if (data.timestamp && (Date.now() - data.timestamp) < STORAGE_EXPIRY_HOURS * 60 * 60 * 1000) {
                    processedMessageIds = new Set(data.ids || []);
                    console.log(`Admin Notifications: Cargados ${processedMessageIds.size} mensajes procesados`);
                } else {
                    // Expirado, limpiar
                    localStorage.removeItem(STORAGE_KEY_MESSAGES);
                }
            }
            
            // Cargar conversaciones procesadas
            const storedConversations = localStorage.getItem(STORAGE_KEY_CONVERSATIONS);
            if (storedConversations) {
                const data = JSON.parse(storedConversations);
                if (data.timestamp && (Date.now() - data.timestamp) < STORAGE_EXPIRY_HOURS * 60 * 60 * 1000) {
                    processedConversationIds = new Set(data.ids || []);
                    console.log(`Admin Notifications: Cargadas ${processedConversationIds.size} conversaciones procesadas`);
                } else {
                    localStorage.removeItem(STORAGE_KEY_CONVERSATIONS);
                }
            }
        } catch (error) {
            console.error('Error loading processed messages:', error);
        }
    }
    
    /**
     * Guardar mensajes procesados en localStorage
     */
    function saveProcessedMessages() {
        try {
            // Guardar mensajes procesados
            localStorage.setItem(STORAGE_KEY_MESSAGES, JSON.stringify({
                ids: Array.from(processedMessageIds),
                timestamp: Date.now()
            }));
            
            // Guardar conversaciones procesadas
            localStorage.setItem(STORAGE_KEY_CONVERSATIONS, JSON.stringify({
                ids: Array.from(processedConversationIds),
                timestamp: Date.now()
            }));
        } catch (error) {
            console.error('Error saving processed messages:', error);
        }
    }
    
    /**
     * Inicializar sonido de notificación
     */
    function initNotificationSound() {
        notificationSound = new Audio(SOUND_URL);
        notificationSound.volume = 0.5;
        
        // Fallback: crear sonido con Web Audio API si el archivo no existe
        notificationSound.addEventListener('error', function() {
            console.log('Using Web Audio API for notification sound');
            createBeepSound();
        });
    }
    
    /**
     * Crear sonido de beep con Web Audio API
     */
    function createBeepSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        notificationSound = {
            play: function() {
                try {
                    // Crear nuevo oscillator para cada reproducción
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    // Configuración del sonido
                    oscillator.frequency.value = 800; // Frecuencia en Hz
                    oscillator.type = 'sine'; // Tipo de onda
                    
                    // Envelope para fade in/out
                    const now = audioContext.currentTime;
                    gainNode.gain.setValueAtTime(0, now);
                    gainNode.gain.linearRampToValueAtTime(0.3, now + 0.05); // Fade in rápido
                    gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.4); // Fade out
                    
                    // Reproducir
                    oscillator.start(now);
                    oscillator.stop(now + 0.4);
                    
                    // Limpiar después de reproducir
                    oscillator.onended = function() {
                        oscillator.disconnect();
                        gainNode.disconnect();
                    };
                } catch (error) {
                    console.error('Error playing beep:', error);
                }
            }
        };
    }
    
    /**
     * Reproducir sonido de notificación
     */
    function playNotificationSound() {
        if (notificationSound) {
            try {
                // Crear una promesa para manejar la reproducción
                const playPromise = notificationSound.play();
                
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.log('Audio play prevented:', error);
                    });
                }
            } catch (error) {
                console.error('Error playing notification sound:', error);
            }
        }
    }
    
    /**
     * Mostrar notificación del navegador
     */
    function showBrowserNotification(title, body, icon = '/favicon.ico') {
        if (!('Notification' in window)) return;
        
        if (Notification.permission === 'granted') {
            const notification = new Notification(title, {
                body: body,
                icon: icon,
                badge: icon,
                tag: 'chat-notification',
                requireInteraction: false
            });
            
            notification.onclick = function() {
                window.focus();
                notification.close();
            };
            
            setTimeout(() => notification.close(), 5000);
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    showBrowserNotification(title, body, icon);
                }
            });
        }
    }
    
    /**
     * Actualizar badge de notificaciones en el topbar
     */
    function updateNotificationBadge(count) {
        const badge = document.querySelector('.topbar-notification-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 9 ? '9+' : count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    /**
     * Actualizar el menú de notificaciones del topbar
     */
    function updateNotificationsMenu(data) {
        const notificationsBody = document.getElementById('notificationsBody');
        if (!notificationsBody) return;
        
        // Si hay notificaciones, actualizar el contenido
        if (data.unread_count > 0) {
            let html = '';
            
            // Agregar mensajes del chat
            if (data.recent_chat_messages && data.recent_chat_messages.length > 0) {
                data.recent_chat_messages.forEach(msg => {
                    const timeAgo = formatTimeAgo(msg.created_at);
                    html += `
                        <a href="/admin/chat/${msg.conversation_id}" class="topbar-notification-item topbar-notification-item--unread">
                            <div class="topbar-notification-icon topbar-notification-icon--primary">
                                <i class="fa-solid fa-comment"></i>
                            </div>
                            <div class="topbar-notification-content">
                                <p class="topbar-notification-text"><strong>${escapeHtml(msg.name)}</strong> te envió un mensaje</p>
                                <span class="topbar-notification-time">${timeAgo}</span>
                            </div>
                        </a>
                    `;
                });
            }
            
            // Agregar leads si hay
            if (data.leads_count > 0) {
                html += `
                    <a href="/admin/leads" class="topbar-notification-item topbar-notification-item--unread">
                        <div class="topbar-notification-icon topbar-notification-icon--success">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div class="topbar-notification-content">
                            <p class="topbar-notification-text">Tienes <strong>${data.leads_count} leads nuevos</strong></p>
                            <span class="topbar-notification-time">Revisa el CRM</span>
                        </div>
                    </a>
                `;
            }
            
            notificationsBody.innerHTML = html;
        } else {
            // Sin notificaciones
            notificationsBody.innerHTML = `
                <div class="topbar-notification-empty">
                    <i class="fa-solid fa-bell-slash"></i>
                    <p>No hay notificaciones</p>
                </div>
            `;
        }
    }
    
    /**
     * Formatear tiempo relativo
     */
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        if (seconds < 60) return 'Hace un momento';
        if (seconds < 3600) return `Hace ${Math.floor(seconds / 60)} minutos`;
        if (seconds < 86400) return `Hace ${Math.floor(seconds / 3600)} horas`;
        if (seconds < 604800) return `Hace ${Math.floor(seconds / 86400)} días`;
        return date.toLocaleDateString('es-ES');
    }
    
    /**
     * Marcar todas las notificaciones como leídas
     */
    window.markAllAsRead = async function() {
        try {
            const response = await fetch('/admin/chat/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            if (response.ok) {
                // Limpiar los Sets de mensajes procesados
                processedMessageIds.clear();
                processedConversationIds.clear();
                
                // Limpiar localStorage
                localStorage.removeItem(STORAGE_KEY_MESSAGES);
                localStorage.removeItem(STORAGE_KEY_CONVERSATIONS);
                
                // Actualizar UI
                updateNotificationBadge(0);
                updateSidebarBadge(0);
                
                const notificationsBody = document.getElementById('notificationsBody');
                if (notificationsBody) {
                    notificationsBody.innerHTML = `
                        <div class="topbar-notification-empty">
                            <i class="fa-solid fa-check-circle"></i>
                            <p>Todas las notificaciones marcadas como leídas</p>
                        </div>
                    `;
                }
                
                // Mostrar toast
                if (typeof showSuccess !== 'undefined') {
                    showSuccess('Todas las notificaciones han sido marcadas como leídas');
                }
            }
        } catch (error) {
            console.error('Error marking as read:', error);
        }
    };
    
    /**
     * Actualizar badge del menú lateral
     */
    function updateSidebarBadge(count) {
        const chatLink = document.querySelector('a[href*="admin.chat"]');
        if (chatLink) {
            let badge = chatLink.querySelector('.sidebar-nav-badge');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'sidebar-nav-badge sidebar-nav-badge--primary';
                    chatLink.appendChild(badge);
                }
                badge.textContent = count;
                badge.style.display = 'flex';
            } else if (badge) {
                badge.style.display = 'none';
            }
        }
    }
    
    /**
     * Mostrar toast de nueva conversación
     */
    function showNewConversationToast(conversation) {
        if (typeof Toast !== 'undefined') {
            Toast.fire({
                icon: 'info',
                title: '💬 Nueva conversación',
                html: `<strong>${escapeHtml(conversation.name)}</strong><br><small>${escapeHtml(conversation.message.substring(0, 60))}${conversation.message.length > 60 ? '...' : ''}</small>`,
                timer: 5000,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                }
            });
        }
    }
    
    /**
     * Mostrar toast de nuevo mensaje
     */
    function showNewMessageToast(message) {
        if (typeof Toast !== 'undefined') {
            Toast.fire({
                icon: 'success',
                title: '💬 Nuevo mensaje',
                html: `<strong>${escapeHtml(message.name)}</strong><br><small>${escapeHtml(message.message.substring(0, 60))}${message.message.length > 60 ? '...' : ''}</small>`,
                timer: 5000,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                }
            });
        }
    }
    
    /**
     * Escape HTML para prevenir XSS
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    /**
     * Verificar nuevas notificaciones
     */
    async function checkNotifications() {
        try {
            const response = await fetch('/admin/chat/notifications', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) return;
            
            const data = await response.json();
            
            // Actualizar badges
            updateNotificationBadge(data.unread_count);
            updateSidebarBadge(data.unread_count);
            
            // Actualizar menú de notificaciones
            updateNotificationsMenu(data);
            
            // Filtrar nuevas conversaciones que no han sido procesadas
            const newConversations = (data.new_conversations || []).filter(conv => {
                const key = `conv_${conv.conversation_id}_${conv.created_at}`;
                if (processedConversationIds.has(key)) {
                    return false;
                }
                processedConversationIds.add(key);
                return true;
            });
            
            // Filtrar nuevos mensajes que no han sido procesados
            const newMessages = (data.new_messages || []).filter(msg => {
                const key = `msg_${msg.conversation_id}_${msg.created_at}`;
                if (processedMessageIds.has(key)) {
                    return false;
                }
                processedMessageIds.add(key);
                return true;
            });
            
            // Guardar en localStorage si hay cambios
            if (newConversations.length > 0 || newMessages.length > 0) {
                saveProcessedMessages();
            }
            
            // Contar total de notificaciones REALMENTE nuevas
            const totalNewConversations = newConversations.length;
            const totalNewMessages = newMessages.length;
            const totalNotifications = totalNewConversations + totalNewMessages;
            
            // Si no hay notificaciones nuevas, salir
            if (totalNotifications === 0) {
                return;
            }
            
            // Si hay múltiples notificaciones, mostrar contador
            if (totalNotifications > 1) {
                showMultipleNotificationsIndicator(totalNotifications);
            }
            
            // Verificar nuevas conversaciones
            if (newConversations.length > 0) {
                newConversations.forEach((conversation, index) => {
                    // Reproducir sonido con delay para cada conversación
                    setTimeout(() => {
                        playNotificationSound();
                    }, index * 500); // 500ms entre cada sonido
                    
                    // Mostrar toast con delay
                    setTimeout(() => {
                        showNewConversationToast(conversation);
                    }, index * 500);
                    
                    // Notificación del navegador si la página no está visible
                    if (!isPageVisible) {
                        showBrowserNotification(
                            'Nueva conversación',
                            `${conversation.name}: ${conversation.message}`
                        );
                    }
                });
            }
            
            // Verificar nuevos mensajes
            if (newMessages.length > 0) {
                newMessages.forEach((message, index) => {
                    const delay = totalNewConversations * 500 + index * 500;
                    
                    // Reproducir sonido con delay para cada mensaje
                    setTimeout(() => {
                        playNotificationSound();
                    }, delay);
                    
                    // Mostrar toast con delay
                    setTimeout(() => {
                        showNewMessageToast(message);
                    }, delay);
                    
                    // Notificación del navegador si la página no está visible
                    if (!isPageVisible) {
                        showBrowserNotification(
                            'Nuevo mensaje',
                            `${message.name}: ${message.message}`
                        );
                    }
                });
                
                // Si estamos en la página de chat index, recargar la lista
                if (window.location.pathname.includes('/admin/chat') && 
                    !window.location.pathname.includes('/admin/chat/')) {
                    // Esperar a que terminen todos los sonidos antes de recargar
                    setTimeout(() => {
                        refreshConversationsList();
                    }, totalNotifications * 500 + 1000);
                }
            }
            
        } catch (error) {
            console.error('Error checking notifications:', error);
        }
    }
    
    /**
     * Mostrar indicador de múltiples notificaciones
     */
    function showMultipleNotificationsIndicator(count) {
        // Remover indicador anterior si existe
        const existingIndicator = document.getElementById('multipleNotificationsIndicator');
        if (existingIndicator) {
            existingIndicator.remove();
        }
        
        const indicator = document.createElement('div');
        indicator.id = 'multipleNotificationsIndicator';
        indicator.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
            z-index: 10001;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        `;
        
        indicator.innerHTML = `
            <div style="
                width: 32px;
                height: 32px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                font-weight: 700;
            ">${count}</div>
            <div>
                <div style="font-size: 15px; margin-bottom: 2px;">Nuevas notificaciones</div>
                <div style="font-size: 12px; opacity: 0.9;">Reproduciendo sonidos...</div>
            </div>
        `;
        
        document.body.appendChild(indicator);
        
        // Remover después de que terminen todos los sonidos
        setTimeout(() => {
            indicator.style.animation = 'slideOutRight 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            setTimeout(() => indicator.remove(), 400);
        }, count * 500 + 2000);
        
        // Agregar animaciones CSS si no existen
        if (!document.getElementById('notificationAnimations')) {
            const style = document.createElement('style');
            style.id = 'notificationAnimations';
            style.textContent = `
                @keyframes slideInRight {
                    from {
                        opacity: 0;
                        transform: translateX(100px);
                    }
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }
                @keyframes slideOutRight {
                    from {
                        opacity: 1;
                        transform: translateX(0);
                    }
                    to {
                        opacity: 0;
                        transform: translateX(100px);
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }
    
    /**
     * Refrescar lista de conversaciones
     */
    function refreshConversationsList() {
        const container = document.querySelector('.admin-chat-table-container');
        if (!container) return;
        
        // Agregar indicador de actualización
        const indicator = document.createElement('div');
        indicator.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            z-index: 10000;
            animation: slideDown 0.3s ease;
        `;
        indicator.innerHTML = '<i class="fas fa-sync fa-spin"></i> Actualizando...';
        document.body.appendChild(indicator);
        
        // Recargar después de 1 segundo
        setTimeout(() => {
            location.reload();
        }, 1000);
    }
    
    /**
     * Limpiar Sets de mensajes procesados periódicamente
     * Esto evita que crezcan indefinidamente
     */
    function cleanupProcessedMessages() {
        const MAX_SIZE = 100; // Máximo de mensajes a recordar
        
        let needsSave = false;
        
        // Si los Sets son muy grandes, limpiarlos
        if (processedMessageIds.size > MAX_SIZE) {
            // Convertir a array, tomar los últimos 50, y recrear el Set
            const messagesArray = Array.from(processedMessageIds);
            processedMessageIds = new Set(messagesArray.slice(-50));
            needsSave = true;
            console.log('Admin Notifications: Limpieza de mensajes procesados');
        }
        
        if (processedConversationIds.size > MAX_SIZE) {
            const conversationsArray = Array.from(processedConversationIds);
            processedConversationIds = new Set(conversationsArray.slice(-50));
            needsSave = true;
            console.log('Admin Notifications: Limpieza de conversaciones procesadas');
        }
        
        // Guardar en localStorage si hubo cambios
        if (needsSave) {
            saveProcessedMessages();
        }
    }
    
    /**
     * Detectar visibilidad de la página
     */
    function handleVisibilityChange() {
        isPageVisible = !document.hidden;
        
        if (isPageVisible) {
            // Verificar notificaciones inmediatamente al volver a la página
            checkNotifications();
        }
    }
    
    /**
     * Inicializar
     */
    function init() {
        // Solo ejecutar en páginas del admin
        if (!window.location.pathname.includes('/admin')) return;
        
        // Cargar mensajes procesados desde localStorage
        loadProcessedMessages();
        
        // Inicializar sonido
        initNotificationSound();
        
        // Detectar visibilidad de la página
        document.addEventListener('visibilitychange', handleVisibilityChange);
        
        // Solicitar permiso para notificaciones del navegador
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
        
        // Limpiar Sets periódicamente (cada 5 minutos)
        setInterval(cleanupProcessedMessages, 5 * 60 * 1000);
        
        // Iniciar polling
        checkNotifications(); // Primera verificación inmediata
        setInterval(checkNotifications, POLLING_INTERVAL);
        
        console.log('Admin Notifications: Sistema inicializado');
    }
    
    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();
