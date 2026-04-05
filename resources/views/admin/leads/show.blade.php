@extends('admin.layouts.app')

@section('title', 'Lead: ' . $lead->name)
@section('page-title', 'Detalle del Lead')

@section('content')
{{-- ═══════════════════════════════════════════════════════════════════════════
     HEADER DEL LEAD CON BADGES
     ═══════════════════════════════════════════════════════════════════════════ --}}
<div class="admin-lead-show-header">
    <div class="admin-lead-show-header-content">
        <div class="admin-lead-show-title-wrapper">
            <div class="admin-lead-show-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <h1 class="admin-lead-show-title">{{ $lead->name }}</h1>
                <p class="admin-lead-show-subtitle">
                    <i class="fa-regular fa-clock"></i>
                    Contactó {{ $lead->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        <div class="admin-lead-show-badges">
            @if(!$lead->read_at)
                <span class="admin-badge admin-badge-red admin-badge-pulse">
                    <i class="fa-solid fa-circle"></i> Nuevo
                </span>
            @endif
            
            @if($lead->status === 'new')
                <span class="admin-badge admin-badge-green"><i class="fa-solid fa-sparkles"></i> Nuevo</span>
            @elseif($lead->status === 'contacted')
                <span class="admin-badge admin-badge-yellow"><i class="fa-solid fa-phone"></i> Contactado</span>
            @else
                <span class="admin-badge admin-badge-gray"><i class="fa-solid fa-check-circle"></i> Cerrado</span>
            @endif

            @if($lead->priority === 'high')
                <span class="admin-badge admin-badge-red"><i class="fa-solid fa-arrow-up"></i> Alta prioridad</span>
            @elseif($lead->priority === 'medium')
                <span class="admin-badge admin-badge-amber"><i class="fa-solid fa-minus"></i> Media</span>
            @else
                <span class="admin-badge admin-badge-gray"><i class="fa-solid fa-arrow-down"></i> Baja</span>
            @endif

            @if($lead->source === 'chat')
                <span class="admin-badge admin-badge-purple"><i class="fa-solid fa-comment-dots"></i> Chat</span>
            @else
                <span class="admin-badge admin-badge-blue"><i class="fa-solid fa-envelope"></i> Formulario</span>
            @endif
        </div>
    </div>
</div>

<div class="admin-detail-grid">
    {{-- ═══════════════════════════════════════════════════════════════════════════
         COLUMNA PRINCIPAL
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <div>
        {{-- Información del contacto --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <i class="fa-solid fa-address-card"></i>
                    Información de contacto
                </h2>
            </div>

            <div class="admin-lead-info-grid">
                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="admin-lead-info-content">
                        <span class="admin-lead-info-label">Email</span>
                        <a href="mailto:{{ $lead->email }}" class="admin-lead-info-value admin-lead-info-link">
                            {{ $lead->email }}
                        </a>
                    </div>
                </div>

                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="admin-lead-info-content">
                        <span class="admin-lead-info-label">Teléfono</span>
                        @if($lead->phone)
                            <a href="tel:{{ $lead->phone }}" class="admin-lead-info-value admin-lead-info-link">
                                {{ $lead->phone }}
                            </a>
                        @else
                            <span class="admin-lead-info-value admin-text-muted">No proporcionado</span>
                        @endif
                    </div>
                </div>

                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div class="admin-lead-info-content">
                        <span class="admin-lead-info-label">Servicio de interés</span>
                        <span class="admin-lead-info-value">
                            {{ $lead->service->title ?? 'No especificado' }}
                        </span>
                    </div>
                </div>

                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="admin-lead-info-content">
                        <span class="admin-lead-info-label">Presupuesto estimado</span>
                        <span class="admin-lead-info-value">
                            {{ $lead->budget ?? 'No especificado' }}
                        </span>
                    </div>
                </div>

                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fa-solid fa-calendar"></i>
                    </div>
                    <div class="admin-lead-info-content">
                        <span class="admin-lead-info-label">Fecha de contacto</span>
                        <span class="admin-lead-info-value">
                            {{ $lead->created_at->format('d/m/Y \a \l\a\s H:i') }}
                        </span>
                    </div>
                </div>

                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div class="admin-lead-info-content">
                        <span class="admin-lead-info-label">Respuestas enviadas</span>
                        <span class="admin-lead-info-value">
                            {{ $lead->replies->count() }} {{ $lead->replies->count() === 1 ? 'respuesta' : 'respuestas' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mensaje original --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <i class="fa-solid fa-message"></i>
                    Mensaje del cliente
                </h2>
            </div>
            <div class="admin-lead-message-box">
                <div class="admin-lead-message-quote">
                    <i class="fa-solid fa-quote-left"></i>
                </div>
                <p class="admin-lead-message-text">{{ $lead->message }}</p>
            </div>
        </div>

        {{-- Conversación / Historial de respuestas --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <i class="fa-solid fa-comments"></i>
                    Historial de conversación
                </h2>
                <span class="admin-badge admin-badge-blue">
                    {{ $lead->replies->count() + 1 }} {{ $lead->replies->count() + 1 === 1 ? 'mensaje' : 'mensajes' }}
                </span>
            </div>

            <div class="admin-conversation-timeline">
                {{-- Mensaje original del lead --}}
                <div class="admin-timeline-item admin-timeline-item--client">
                    <div class="admin-timeline-marker admin-timeline-marker--client">
                        <div class="admin-timeline-avatar">
                            {{ strtoupper(substr($lead->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="admin-timeline-content">
                        <div class="admin-timeline-header">
                            <div>
                                <strong class="admin-timeline-name">{{ $lead->name }}</strong>
                                <span class="admin-timeline-role">Cliente</span>
                            </div>
                            <span class="admin-timeline-date">
                                <i class="fa-regular fa-clock"></i>
                                {{ $lead->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div class="admin-timeline-bubble admin-timeline-bubble--client">
                            <div class="admin-timeline-message">{{ $lead->message }}</div>
                            <div class="admin-timeline-footer">
                                <span class="admin-timeline-badge">
                                    @if($lead->source === 'chat')
                                        <i class="fa-solid fa-comment-dots"></i> Desde Chat
                                    @else
                                        <i class="fa-solid fa-envelope"></i> Desde Formulario
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Respuestas --}}
                @forelse($lead->replies as $reply)
                    <div class="admin-timeline-item admin-timeline-item--admin">
                        <div class="admin-timeline-marker admin-timeline-marker--admin">
                            <div class="admin-timeline-avatar">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="admin-timeline-content">
                            <div class="admin-timeline-header">
                                <div>
                                    <strong class="admin-timeline-name">{{ $reply->user->name ?? 'Admin' }}</strong>
                                    <span class="admin-timeline-role">Tu equipo</span>
                                </div>
                                <span class="admin-timeline-date">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $reply->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <div class="admin-timeline-bubble admin-timeline-bubble--admin">
                                <div class="admin-timeline-message">{!! nl2br(e($reply->message)) !!}</div>
                                @if($reply->sent_to_email)
                                    <div class="admin-timeline-footer">
                                        <span class="admin-timeline-badge admin-timeline-badge--success">
                                            <i class="fa-solid fa-check-circle"></i> Enviado por email
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="admin-timeline-empty">
                        <div class="admin-timeline-empty-icon">
                            <i class="fa-solid fa-inbox"></i>
                        </div>
                        <p class="admin-timeline-empty-text">
                            No hay respuestas aún. Escribe la primera respuesta abajo.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Formulario de respuesta --}}
        <div class="admin-form-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">
                    <i class="fa-solid fa-paper-plane"></i>
                    Responder a {{ $lead->name }}
                </h2>
            </div>

            <form method="POST" action="{{ route('admin.leads.reply', $lead) }}" class="admin-reply-form">
                @csrf
                <div class="admin-form-group">
                    <label class="admin-form-label">
                        <i class="fa-solid fa-message"></i>
                        Tu respuesta
                    </label>
                    <div class="admin-reply-textarea-wrapper">
                        <textarea name="message" 
                                  class="admin-form-control admin-textarea-modern" 
                                  rows="6"
                                  placeholder="Escribe tu respuesta aquí... Puedes incluir detalles sobre presupuestos, tiempos de entrega, siguientes pasos, etc." 
                                  required>{{ old('message') }}</textarea>
                        <div class="admin-textarea-tools">
                            <span class="admin-textarea-hint">
                                <i class="fa-solid fa-lightbulb"></i>
                                Tip: Sé claro y profesional en tu respuesta
                            </span>
                        </div>
                    </div>
                    @error('message')
                        <p class="admin-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="admin-reply-options-modern">
                    <div class="admin-checkbox-card">
                        <label class="admin-checkbox-card-label">
                            <input type="checkbox" name="send_to_email" value="1" checked class="admin-checkbox-card-input">
                            <div class="admin-checkbox-card-content">
                                <div class="admin-checkbox-card-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="admin-checkbox-card-text">
                                    <strong>Enviar por email</strong>
                                    <span>Se enviará a {{ $lead->email }}</span>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="admin-checkbox-card">
                        <label class="admin-checkbox-card-label">
                            <input type="checkbox" name="send_copy" value="1" class="admin-checkbox-card-input">
                            <div class="admin-checkbox-card-content">
                                <div class="admin-checkbox-card-icon">
                                    <i class="fa-regular fa-copy"></i>
                                </div>
                                <div class="admin-checkbox-card-text">
                                    <strong>Enviar copia</strong>
                                    <span>Recibirás una copia en tu email</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn-lg">
                        <i class="fa-solid fa-paper-plane"></i> 
                        Enviar respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         PANEL LATERAL
         ═══════════════════════════════════════════════════════════════════════════ --}}
    <div>
        {{-- Estado y Prioridad --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-card-header">
                <h3 class="admin-card-title admin-card-title--sm">
                    <i class="fa-solid fa-sliders"></i>
                    Estado y Prioridad
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                @csrf @method('PUT')
                <div class="admin-form-group">
                    <label class="admin-form-label">Estado del lead</label>
                    <div class="admin-select-modern">
                        <select name="status" class="admin-form-control">
                            <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>
                                <span class="admin-select-icon">●</span> Nuevo
                            </option>
                            <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>
                                <span class="admin-select-icon">●</span> Contactado
                            </option>
                            <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>
                                <span class="admin-select-icon">●</span> Cerrado
                            </option>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Nivel de prioridad</label>
                    <div class="admin-select-modern">
                        <select name="priority" class="admin-form-control">
                            <option value="high" {{ $lead->priority === 'high' ? 'selected' : '' }}>🔴 Alta</option>
                            <option value="medium" {{ $lead->priority === 'medium' ? 'selected' : '' }}>🟡 Media</option>
                            <option value="low" {{ $lead->priority === 'low' ? 'selected' : '' }}>⚪ Baja</option>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-block">
                    <i class="fa-solid fa-save"></i> Guardar cambios
                </button>
            </form>
        </div>

        {{-- Estadísticas rápidas --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-card-header">
                <h3 class="admin-card-title admin-card-title--sm">
                    <i class="fa-solid fa-chart-simple"></i>
                    Estadísticas
                </h3>
            </div>
            <div class="admin-stats-grid-sidebar">
                <div class="admin-stat-card-mini">
                    <div class="admin-stat-mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div class="admin-stat-mini-content">
                        <span class="admin-stat-mini-value">{{ $lead->replies->count() }}</span>
                        <span class="admin-stat-mini-label">Respuestas</span>
                    </div>
                </div>
                <div class="admin-stat-card-mini">
                    <div class="admin-stat-mini-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="admin-stat-mini-content">
                        <span class="admin-stat-mini-value">{{ $lead->replies->where('sent_to_email', true)->count() }}</span>
                        <span class="admin-stat-mini-label">Emails</span>
                    </div>
                </div>
                <div class="admin-stat-card-mini">
                    <div class="admin-stat-mini-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div class="admin-stat-mini-content">
                        <span class="admin-stat-mini-value">{{ $lead->created_at->diffInDays(now()) }}</span>
                        <span class="admin-stat-mini-label">Días</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notas internas --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-card-header">
                <h3 class="admin-card-title admin-card-title--sm">
                    <i class="fa-solid fa-sticky-note"></i>
                    Notas internas
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                @csrf @method('PUT')
                <div class="admin-form-group">
                    <textarea name="notes" 
                              class="admin-form-control admin-textarea-notes" 
                              rows="4"
                              placeholder="Notas privadas sobre este lead... Estas notas solo son visibles para tu equipo.">{{ old('notes', $lead->notes) }}</textarea>
                </div>
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-block admin-btn-sm">
                    <i class="fa-solid fa-save"></i> Guardar notas
                </button>
            </form>
        </div>

        {{-- Acciones rápidas --}}
        <div class="admin-form-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title admin-card-title--sm">
                    <i class="fa-solid fa-bolt"></i>
                    Acciones rápidas
                </h3>
            </div>
            <div class="admin-actions-stack">
                <a href="mailto:{{ $lead->email }}" class="admin-btn admin-btn-success admin-btn-block admin-btn-action">
                    <i class="fa-solid fa-envelope"></i> 
                    Abrir cliente de email
                </a>
                @if($lead->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" 
                       target="_blank"
                       class="admin-btn admin-btn-whatsapp admin-btn-block admin-btn-action">
                        <i class="fa-brands fa-whatsapp"></i> 
                        Contactar por WhatsApp
                    </a>
                @endif
                <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary admin-btn-block admin-btn-action">
                    <i class="fa-solid fa-arrow-left"></i> 
                    Volver a leads
                </a>
                <form method="POST" 
                      action="{{ route('admin.leads.destroy', $lead) }}" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este lead? Esta acción eliminará también todas las respuestas asociadas y no se puede deshacer.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-block admin-btn-action">
                        <i class="fa-solid fa-trash"></i> 
                        Eliminar lead
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
