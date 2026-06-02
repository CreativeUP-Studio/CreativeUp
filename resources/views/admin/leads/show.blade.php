@extends('admin.layouts.app')

@section('title', 'Lead: ' . $lead->name)
@section('page-title', 'Detalle del Lead')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    /* Estilos adicionales de rediseño premium para los detalles */
    .lead-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 30px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid transparent;
    }
    .lead-badge--new {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    .lead-badge--contacted {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.2);
    }
    .lead-badge--closed {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
        border-color: rgba(100, 116, 139, 0.2);
    }
</style>
@endpush

@section('content')

@php
    $priorityColor = '#6366f1';
    $priorityGradient = 'linear-gradient(135deg, #6366f1 0%, #8338ec 100%)';
    $priorityGlow = 'rgba(99, 102, 241, 0.2)';
    if ($lead->priority === 'high') {
        $priorityColor = '#ef4444';
        $priorityGradient = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
        $priorityGlow = 'rgba(239, 68, 68, 0.2)';
    } elseif ($lead->priority === 'medium') {
        $priorityColor = '#f59e0b';
        $priorityGradient = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
        $priorityGlow = 'rgba(245, 158, 11, 0.2)';
    }
@endphp

{{-- ═══════════════════════════════════════════════════
     1. HERO HEADER - PREMIUM DESIGN
     ═══════════════════════════════════════════════════ --}}
<div class="admin-lead-show-header" style="background: {{ $priorityGradient }}; box-shadow: 0 10px 30px {{ $priorityGlow }}; border-radius: 1.5rem; padding: 2.5rem; margin-bottom: 2.5rem; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1);">
    {{-- Decorative Orbs --}}
    <div style="position: absolute; top: -50%; right: -10%; width: 350px; height: 350px; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50%; left: -10%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); pointer-events: none;"></div>
    
    <div class="admin-lead-show-header-content" style="position: relative; z-index: 2; display: flex; justify-content: space-between; align-items: center; gap: 2rem; flex-wrap: wrap;">
        <div class="admin-lead-show-title-wrapper" style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('admin.leads.index') }}" style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='translateX(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='none';">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="admin-lead-show-avatar" style="width: 64px; height: 64px; border-radius: 16px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; color: white; text-transform: uppercase;">
                <span>{{ strtoupper(substr($lead->name, 0, 2)) }}</span>
            </div>
            <div>
                <h1 class="admin-lead-show-title" style="font-size: 2.25rem; font-weight: 800; color: white; margin: 0 0 0.5rem 0; line-height: 1.2;">
                    {{ $lead->name }}
                </h1>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    {{-- Priority Badge --}}
                    <span style="font-size: 0.7rem; font-weight: 800; color: white; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); padding: 0.3rem 0.75rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $lead->priority === 'high' ? '🔴 Alta' : ($lead->priority === 'medium' ? '🟡 Media' : '⚪ Baja') }}
                    </span>
                    {{-- Source Badge --}}
                    <span style="font-size: 0.7rem; font-weight: 800; color: white; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); padding: 0.3rem 0.75rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                        @if($lead->source === 'chat')
                            <i class="fa-solid fa-comment-dots"></i> Chat
                        @elseif($lead->source === 'newsletter')
                            <i class="fa-solid fa-paper-plane"></i> Boletín
                        @else
                            <i class="fa-solid fa-envelope"></i> Web
                        @endif
                    </span>
                    {{-- Status Badge --}}
                    <span style="font-size: 0.7rem; font-weight: 800; color: white; background: rgba(0,0,0,0.3); backdrop-filter: blur(4px); padding: 0.3rem 0.75rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $lead->status === 'new' ? 'Nuevo' : ($lead->status === 'contacted' ? 'Contactado' : 'Cerrado') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="admin-lead-show-actions" style="display: flex; gap: 0.75rem;">
            <a href="mailto:{{ $lead->email }}" class="admin-btn" style="margin: 0; padding: 0.75rem 1.5rem; font-size: 0.85rem; border-radius: 10px; background: white; color: {{ $priorityColor }}; font-weight: 700; border: none; display: flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'">
                <i class="fa-solid fa-envelope"></i>
                <span>Email</span>
            </a>
            @if($lead->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="admin-btn" style="margin: 0; padding: 0.75rem 1.5rem; font-size: 0.85rem; border-radius: 10px; background: #25d366; color: white; font-weight: 700; border: none; display: flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 12px rgba(37,211,102,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(37,211,102,0.4)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(37,211,102,0.3)'">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
            @endif
            <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('¿Estás seguro de eliminar este lead?')" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="admin-btn" style="margin: 0; padding: 0.75rem 1.5rem; font-size: 0.85rem; border-radius: 10px; background: rgba(255,255,255,0.15); color: white; font-weight: 700; border: 1px solid rgba(255,255,255,0.3); cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='none'">
                    <i class="fa-solid fa-trash"></i>
                    <span>Eliminar</span>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="admin-detail-grid">
    {{-- ═══════════════════════════════════════════════════
         COLUMNA PRINCIPAL
         ═══════════════════════════════════════════════════ --}}
    <div>
        {{-- Información del contacto --}}
        <div class="admin-form-card admin-mb-md" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; gap: 0.75rem;">
                <h2 class="admin-card-title" style="margin: 0; font-size: 1.2rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-address-card" style="color: var(--primary-color);"></i>
                    Información del Contacto
                </h2>
            </div>

            <div class="admin-lead-info-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; padding: 1.5rem;">
                <div class="admin-lead-info-item">
                    <div class="admin-lead-info-icon" style="background: var(--admin-gradient);">
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
                        <span class="admin-lead-info-label">Respuestas</span>
                        <span class="admin-lead-info-value">
                            {{ $lead->replies->count() }} {{ $lead->replies->count() === 1 ? 'respuesta' : 'respuestas' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mensaje original --}}
        <div class="admin-form-card admin-mb-md" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--admin-border);">
                <h2 class="admin-card-title" style="margin: 0; font-size: 1.2rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-message" style="color: var(--primary-color);"></i>
                    Mensaje del Cliente
                </h2>
            </div>
            <div style="padding: 1.5rem;">
                <div class="admin-lead-message-box" style="position: relative; padding: 2rem; background: linear-gradient(135deg, rgba(255, 0, 110, 0.03) 0%, rgba(131, 56, 236, 0.03) 100%); border-left: 4px solid var(--primary-color); border-radius: 0.75rem;">
                    <div class="admin-lead-message-quote" style="position: absolute; top: 1rem; left: 1rem; font-size: 2rem; color: rgba(255, 0, 110, 0.15); pointer-events: none;">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="admin-lead-message-text" style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main); margin: 0; padding-left: 2rem; white-space: pre-wrap;">{{ $lead->message }}</p>
                </div>
            </div>
        </div>

        {{-- Conversación / Historial de respuestas --}}
        <div class="admin-form-card admin-mb-md" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between;">
                <h2 class="admin-card-title" style="margin: 0; font-size: 1.2rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-comments" style="color: var(--primary-color);"></i>
                    Historial de Conversación
                </h2>
                <span class="lead-badge lead-badge--web">
                    {{ $lead->replies->count() + 1 }} {{ $lead->replies->count() + 1 === 1 ? 'mensaje' : 'mensajes' }}
                </span>
            </div>

            <div class="admin-conversation-timeline" style="padding: 2rem 1.5rem;">
                {{-- Mensaje original del lead --}}
                <div class="admin-timeline-item admin-timeline-item--client">
                    <div class="admin-timeline-marker admin-timeline-marker--client">
                        <div class="admin-timeline-avatar" style="background: var(--admin-gradient); font-family: inherit;">
                            {{ strtoupper(substr($lead->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="admin-timeline-content">
                        <div class="admin-timeline-header">
                            <div>
                                <strong class="admin-timeline-name">{{ $lead->name }}</strong>
                                <span class="admin-timeline-role" style="background: rgba(255, 0, 110, 0.1); color: var(--primary-color);">Cliente</span>
                            </div>
                            <span class="admin-timeline-date">
                                <i class="fa-regular fa-clock"></i>
                                {{ $lead->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div class="admin-timeline-bubble admin-timeline-bubble--client" style="background: linear-gradient(135deg, rgba(255, 0, 110, 0.05) 0%, rgba(131, 56, 236, 0.05) 100%); border: 1px solid rgba(255, 0, 110, 0.1);">
                            <div class="admin-timeline-message" style="white-space: pre-wrap;">{{ $lead->message }}</div>
                            <div class="admin-timeline-footer" style="border-top: 1px solid rgba(255, 0, 110, 0.1); margin-top: 0.75rem; padding-top: 0.5rem;">
                                <span class="admin-timeline-badge">
                                    @if($lead->source === 'chat')
                                        <i class="fa-solid fa-comment-dots"></i> Desde Chat
                                    @elseif($lead->source === 'newsletter')
                                        <i class="fa-solid fa-paper-plane"></i> Desde Boletín
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
                            <div class="admin-timeline-avatar" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="admin-timeline-content">
                            <div class="admin-timeline-header">
                                <div>
                                    <strong class="admin-timeline-name">{{ $reply->user->name ?? 'Admin' }}</strong>
                                    <span class="admin-timeline-role" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">Equipo</span>
                                </div>
                                <span class="admin-timeline-date">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $reply->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <div class="admin-timeline-bubble admin-timeline-bubble--admin" style="background: rgba(241, 245, 249, 0.4); border: 1px solid var(--admin-border);">
                                <div class="admin-timeline-message">{!! nl2br(e($reply->message)) !!}</div>
                                @if($reply->sent_to_email)
                                    <div class="admin-timeline-footer" style="border-top: 1px solid var(--admin-border); margin-top: 0.75rem; padding-top: 0.5rem;">
                                        <span class="admin-timeline-badge admin-timeline-badge--success" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                            <i class="fa-solid fa-check-circle"></i> Enviado por email
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="admin-timeline-empty" style="padding: 2.5rem 1.5rem;">
                        <div class="admin-timeline-empty-icon" style="background: rgba(0,0,0,0.02); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fa-solid fa-inbox" style="color: var(--text-muted);"></i>
                        </div>
                        <p class="admin-timeline-empty-text" style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">
                            No hay respuestas registradas aún. Envía la primera abajo.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Formulario de respuesta --}}
        <div class="admin-form-card" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--admin-border);">
                <h2 class="admin-card-title" style="margin: 0; font-size: 1.2rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-paper-plane" style="color: var(--primary-color);"></i>
                    Responder a {{ $lead->name }}
                </h2>
            </div>

            <form method="POST" action="{{ route('admin.leads.reply', $lead) }}" class="admin-reply-form" style="padding: 1.5rem;">
                @csrf
                <div class="admin-form-group" style="margin-bottom: 1.5rem;">
                    <label class="admin-form-label" style="font-weight: 700; font-size: 0.85rem; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 0.5rem; display: block;">
                        Mensaje de Respuesta
                    </label>
                    <div class="admin-reply-textarea-wrapper">
                        <textarea name="message" 
                                  class="admin-form-control admin-textarea-modern" 
                                  rows="6"
                                  placeholder="Escribe tu respuesta aquí..." 
                                  required style="border-radius: var(--admin-radius); padding: 1rem; font-size: 0.9rem;">{{ old('message') }}</textarea>
                        <div class="admin-textarea-tools" style="margin-top: 0.5rem;">
                            <span class="admin-textarea-hint" style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.35rem;">
                                <i class="fa-solid fa-lightbulb" style="color: #f59e0b;"></i>
                                Consejo: Ofrece una respuesta clara y profesional.
                            </span>
                        </div>
                    </div>
                    @error('message')
                        <p class="admin-error-text" style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="admin-reply-options-modern" style="margin-bottom: 1.5rem;">
                    <div class="admin-checkbox-card">
                        <label class="admin-checkbox-card-label">
                            <input type="checkbox" name="send_to_email" value="1" checked class="admin-checkbox-card-input">
                            <div class="admin-checkbox-card-content" style="border-radius: var(--admin-radius);">
                                <div class="admin-checkbox-card-icon" style="background: var(--admin-gradient);">
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
                            <div class="admin-checkbox-card-content" style="border-radius: var(--admin-radius);">
                                <div class="admin-checkbox-card-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                    <i class="fa-regular fa-copy"></i>
                                </div>
                                <div class="admin-checkbox-card-text">
                                    <strong>Enviar copia</strong>
                                    <span>Copia en tu bandeja administrativa</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="admin-form-actions" style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn-lg" style="border-radius: 10px; font-weight: 700; height: 44px; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-paper-plane"></i> 
                        Enviar Respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         PANEL LATERAL
         ═══════════════════════════════════════════════════ --}}
    <div>
        {{-- Estado y Prioridad --}}
        <div class="admin-form-card admin-mb-md" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--admin-border);">
                <h3 class="admin-card-title admin-card-title--sm" style="margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-sliders" style="color: var(--primary-color);"></i>
                    Estado y Prioridad
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" style="padding: 1.5rem;">
                @csrf @method('PUT')
                <div class="admin-form-group" style="margin-bottom: 1.25rem;">
                    <label class="admin-form-label" style="font-weight: 700; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.4rem; display: block;">Estado del Lead</label>
                    <div class="admin-select-modern" style="border-radius: var(--admin-radius);">
                        <select name="status" class="admin-form-control" style="font-size: 0.875rem;">
                            <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>🟢 Nuevo</option>
                            <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>🟡 En Proceso</option>
                            <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>⚪ Cerrado</option>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
                <div class="admin-form-group" style="margin-bottom: 1.5rem;">
                    <label class="admin-form-label" style="font-weight: 700; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.4rem; display: block;">Nivel de Prioridad</label>
                    <div class="admin-select-modern" style="border-radius: var(--admin-radius);">
                        <select name="priority" class="admin-form-control" style="font-size: 0.875rem;">
                            <option value="high" {{ $lead->priority === 'high' ? 'selected' : '' }}>🔴 Alta</option>
                            <option value="medium" {{ $lead->priority === 'medium' ? 'selected' : '' }}>🟡 Media</option>
                            <option value="low" {{ $lead->priority === 'low' ? 'selected' : '' }}>⚪ Baja</option>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-block" style="border-radius: 10px; font-weight: 700; height: 40px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                </button>
            </form>
        </div>

        {{-- Estadísticas rápidas --}}
        <div class="admin-form-card admin-mb-md" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--admin-border);">
                <h3 class="admin-card-title admin-card-title--sm" style="margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-chart-simple" style="color: var(--primary-color);"></i>
                    Estadísticas del Lead
                </h3>
            </div>
            <div class="admin-stats-grid-sidebar" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <div class="admin-stat-card-mini" style="border-radius: var(--admin-radius);">
                    <div class="admin-stat-mini-icon" style="background: var(--admin-gradient); width: 40px; height: 40px; border-radius: 10px; font-size: 1rem;">
                        <i class="fa-solid fa-reply"></i>
                    </div>
                    <div class="admin-stat-mini-content">
                        <span class="admin-stat-mini-value" style="font-size: 1.25rem;">{{ $lead->replies->count() }}</span>
                        <span class="admin-stat-mini-label" style="font-size: 0.7rem;">Respuestas totales</span>
                    </div>
                </div>
                <div class="admin-stat-card-mini" style="border-radius: var(--admin-radius);">
                    <div class="admin-stat-mini-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); width: 40px; height: 40px; border-radius: 10px; font-size: 1rem;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <div class="admin-stat-mini-content">
                        <span class="admin-stat-mini-value" style="font-size: 1.25rem;">{{ $lead->replies->where('sent_to_email', true)->count() }}</span>
                        <span class="admin-stat-mini-label" style="font-size: 0.7rem;">Emails enviados</span>
                    </div>
                </div>
                <div class="admin-stat-card-mini" style="border-radius: var(--admin-radius);">
                    <div class="admin-stat-mini-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); width: 40px; height: 40px; border-radius: 10px; font-size: 1rem;">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div class="admin-stat-mini-content">
                        <span class="admin-stat-mini-value" style="font-size: 1.25rem;">{{ max(1, $lead->created_at->diffInDays(now())) }}</span>
                        <span class="admin-stat-mini-label" style="font-size: 0.7rem;">Días transcurridos</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notas internas --}}
        <div class="admin-form-card admin-mb-md" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--admin-border);">
                <h3 class="admin-card-title admin-card-title--sm" style="margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-sticky-note" style="color: var(--primary-color);"></i>
                    Notas Internas
                </h3>
            </div>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" style="padding: 1.5rem;">
                @csrf @method('PUT')
                <div class="admin-form-group" style="margin-bottom: 1rem;">
                    <textarea name="notes" 
                              class="admin-form-control admin-textarea-notes" 
                              rows="4"
                              placeholder="Escribe notas de seguimiento privadas..." style="border-radius: var(--admin-radius); padding: 0.85rem; font-size: 0.85rem;">{{ old('notes', $lead->notes) }}</textarea>
                </div>
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-block admin-btn-sm" style="border-radius: 8px; font-weight: 700; height: 36px; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Notas
                </button>
            </form>
        </div>

        {{-- Acciones rápidas --}}
        <div class="admin-form-card" style="background: white; border-radius: 1.25rem; border: 1px solid var(--admin-border); overflow: hidden;">
            <div class="admin-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--admin-border);">
                <h3 class="admin-card-title admin-card-title--sm" style="margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-bolt" style="color: var(--primary-color);"></i>
                    Acciones de Contacto
                </h3>
            </div>
            <div class="admin-actions-stack" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="mailto:{{ $lead->email }}" class="admin-btn admin-btn-success admin-btn-block admin-btn-action" style="border-radius: 10px; font-weight: 700; height: 40px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); text-decoration: none;">
                    <i class="fa-solid fa-envelope"></i> 
                    Enviar correo
                </a>
                @if($lead->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" 
                       target="_blank"
                       class="admin-btn admin-btn-whatsapp admin-btn-block admin-btn-action" style="border-radius: 10px; font-weight: 700; height: 40px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: rgba(37, 211, 102, 0.1); color: #25d366; border: 1px solid rgba(37, 211, 102, 0.2); text-decoration: none;">
                        <i class="fa-brands fa-whatsapp"></i> 
                        Enviar WhatsApp
                    </a>
                @endif
                <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary admin-btn-block admin-btn-action" style="border-radius: 10px; font-weight: 700; height: 40px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                    <i class="fa-solid fa-arrow-left-long"></i> 
                    Volver al CRM
                </a>
                <form method="POST" 
                      action="{{ route('admin.leads.destroy', $lead) }}" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este lead? Esta acción eliminará también todas las respuestas asociadas y no se puede deshacer.')" style="display: contents;">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-block admin-btn-action" style="border-radius: 10px; font-weight: 700; height: 40px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-trash"></i> 
                        Eliminar Registro
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
