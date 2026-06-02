@extends('admin.layouts.app')

@section('title', 'Conversaciones del Chat')
@section('page-title', 'Conversaciones del Chat')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/chat.css') }}">
@endpush

@section('content')
<div class="admin-chat-container">
    {{-- Header Compact --}}
    <div class="admin-compact-header" style="margin-bottom: 1.5rem;">
        <div class="admin-compact-header-left">
            <div class="admin-compact-header-info">
                <h1>
                    <i class="fa-solid fa-comments"></i>
                    Chat en Vivo
                </h1>
            </div>
        </div>
        <div class="admin-compact-header-stats">
            <div class="admin-compact-header-stat-item" title="Total Conversaciones">
                <span class="admin-compact-header-stat-lbl">Conversaciones:</span>
                <span class="admin-compact-header-stat-num">{{ $conversations->count() }}</span>
            </div>
            <div class="admin-compact-header-stat-item" title="Mensajes Sin Leer">
                <span class="admin-compact-header-stat-lbl">Sin leer:</span>
                <span class="admin-compact-header-stat-num text-danger">{{ $totalUnread }}</span>
            </div>
            <div class="admin-compact-header-stat-item" title="Conversaciones Activas Hoy">
                <span class="admin-compact-header-stat-lbl">Activas hoy:</span>
                <span class="admin-compact-header-stat-num text-success">{{ $conversations->where('last_message_at', '>=', now()->startOfDay())->count() }}</span>
            </div>
        </div>
        <div class="admin-compact-header-actions">
            <button class="admin-btn admin-btn-secondary" onclick="location.reload()" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span>Actualizar</span>
            </button>
        </div>
    </div>

    {{-- Filtros y Búsqueda --}}
    <div class="admin-chat-filters">
        <div class="admin-chat-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar por nombre, email o mensaje...">
        </div>
        <button class="admin-chat-filter-btn active" data-filter="all">
            <i class="fas fa-list"></i> Todas
        </button>
        <button class="admin-chat-filter-btn" data-filter="unread">
            <i class="fas fa-envelope"></i> Sin leer
        </button>
        <button class="admin-chat-filter-btn" data-filter="today">
            <i class="fas fa-calendar-day"></i> Hoy
        </button>
    </div>

    {{-- Conversations List --}}
    <div class="admin-chat-table-container">
        @forelse($conversations as $conversation)
            <a href="{{ route('admin.chat.show', $conversation->conversation_id) }}" 
               class="conversation-item {{ $conversation->unread_count > 0 ? 'unread' : '' }}"
               data-unread="{{ $conversation->unread_count }}"
               data-date="{{ $conversation->last_message_at->format('Y-m-d') }}"
               data-search="{{ strtolower($conversation->name . ' ' . $conversation->email . ' ' . ($conversation->last_user_message ?? '')) }}">
                <div class="conversation-avatar {{ $conversation->last_message_at->diffInMinutes(now()) < 30 ? 'online' : '' }}">
                    {{ strtoupper(substr($conversation->name, 0, 1)) }}
                </div>
                <div class="conversation-content">
                    <div class="conversation-header">
                        <span class="conversation-name">{{ $conversation->name }}</span>
                        <span class="conversation-time">{{ $conversation->last_message_at->diffForHumans() }}</span>
                    </div>
                    <div class="conversation-preview">
                        <i class="fas fa-user"></i>
                        {{ Str::limit($conversation->last_user_message ?? 'Sin mensajes', 60) }}
                    </div>
                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem; font-size: 0.8rem; color: #9ca3af;">
                        <span><i class="fas fa-envelope"></i> {{ $conversation->email }}</span>
                        <span><i class="fas fa-comment"></i> {{ $conversation->message_count }} mensajes</span>
                    </div>
                </div>
                <div class="conversation-meta">
                    @if($conversation->unread_count > 0)
                        <span class="conversation-badge">{{ $conversation->unread_count }}</span>
                    @endif
                    <div class="conversation-actions">
                        <button class="conversation-action-btn" title="Ver conversación">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="conversation-action-btn delete" title="Eliminar" 
                                onclick="event.preventDefault(); deleteConversation('{{ $conversation->conversation_id }}', '{{ $conversation->name }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </a>
            <form id="delete-form-{{ $conversation->conversation_id }}" 
                  action="{{ route('admin.chat.destroy', $conversation->conversation_id) }}" 
                  method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @empty
            <div class="admin-chat-empty">
                <div class="admin-chat-empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>No hay conversaciones</h3>
                <p>Las conversaciones del chat aparecerán aquí cuando los usuarios te escriban</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.admin-chat-filter-btn');
    const conversationItems = document.querySelectorAll('.conversation-item');
    
    let currentFilter = 'all';
    let currentSearch = '';
    
    // Búsqueda
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value.toLowerCase().trim();
            filterConversations();
        });
    }
    
    // Filtros
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterConversations();
        });
    });
    
    // Función de filtrado
    function filterConversations() {
        let visibleCount = 0;
        const today = new Date().toISOString().split('T')[0];
        
        conversationItems.forEach(item => {
            let show = true;
            
            // Filtro de búsqueda
            if (currentSearch && !item.dataset.search.includes(currentSearch)) {
                show = false;
            }
            
            // Filtro de tipo
            if (currentFilter === 'unread' && item.dataset.unread === '0') {
                show = false;
            } else if (currentFilter === 'today' && item.dataset.date !== today) {
                show = false;
            }
            
            if (show) {
                item.style.display = 'flex';
                visibleCount++;
                // Animación de entrada
                item.style.animation = 'none';
                setTimeout(() => {
                    item.style.animation = 'fadeIn 0.3s ease';
                }, 10);
            } else {
                item.style.display = 'none';
            }
        });
        
        // Mostrar mensaje si no hay resultados
        const container = document.querySelector('.admin-chat-table-container');
        let noResults = container.querySelector('.no-results-message');
        
        if (visibleCount === 0 && conversationItems.length > 0) {
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.className = 'admin-chat-empty no-results-message';
                noResults.innerHTML = `
                    <div class="admin-chat-empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No se encontraron resultados</h3>
                    <p>Intenta con otros términos de búsqueda o filtros</p>
                `;
                container.appendChild(noResults);
            }
            noResults.style.display = 'block';
        } else if (noResults) {
            noResults.style.display = 'none';
        }
    }
    
    // Función para eliminar conversación con SweetAlert2
    window.deleteConversation = async function(conversationId, userName) {
        const result = await confirmDelete(`la conversación con <strong>${userName}</strong>`);
        
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar formulario
            document.getElementById('delete-form-' + conversationId).submit();
        }
    };
    
    // Auto-refresh cada 30 segundos
    setInterval(() => {
        // Solo recargar si no hay búsqueda o filtros activos
        if (!currentSearch && currentFilter === 'all') {
            location.reload();
        }
    }, 30000);
    
    console.log('Admin Chat: Filtros y búsqueda inicializados con SweetAlert2');
})();
</script>
@endpush
