@extends('admin.layouts.app')

@section('title', 'Lead: ' . $lead->name)
@section('page-title', 'Detalle del Lead')

@section('content')
<div class="admin-detail-grid">
    {{-- Columna principal --}}
    <div>
        {{-- Header del lead --}}
        <div class="admin-form-card admin-mb-md">
            <div class="admin-lead-header">
                <h2 class="admin-section-title admin-mb-0">
                    <i class="fa-solid fa-user" style="color:var(--admin-purple);font-size:0.95rem"></i>
                    {{ $lead->name }}
                </h2>
                <div class="admin-lead-header-badges">
                    @if($lead->source === 'chat')
                        <span class="admin-badge admin-badge-purple"><i class="fa-solid fa-comment-dots"></i> Chat</span>
                    @else
                        <span class="admin-badge admin-badge-blue"><i class="fa-solid fa-envelope"></i> Contacto</span>
                    @endif
                    @if($lead->read_at)
                        <span class="admin-badge admin-badge-gray"><i class="fa-solid fa-eye"></i> Leído {{ $lead->read_at->diffForHumans() }}</span>
                    @endif
                </div>
            </div>

            <div class="admin-form-grid admin-mb-lg" style="margin-top:1rem">
                <div>
                    <p class="admin-detail-label">Email</p>
                    <p class="admin-detail-value"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></p>
                </div>
                <div>
                    <p class="admin-detail-label">Teléfono</p>
                    <p class="admin-detail-value">{{ $lead->phone ?? 'No proporcionado' }}</p>
                </div>
                <div>
                    <p class="admin-detail-label">Servicio de interés</p>
                    <p class="admin-detail-value">{{ $lead->service->title ?? 'No especificado' }}</p>
                </div>
                <div>
                    <p class="admin-detail-label">Fecha de contacto</p>
                    <p class="admin-detail-value">{{ $lead->created_at->format('d/m/Y \a \l\a\s H:i') }}</p>
                </div>
                <div>
                    <p class="admin-detail-label">Presupuesto estimado</p>
                    <p class="admin-detail-value">
                        @if($lead->budget)
                            <span class="admin-badge admin-badge-purple"><i class="fa-solid fa-dollar-sign"></i> {{ $lead->budget }}</span>
                        @else
                            No especificado
                        @endif
                    </p>
                </div>
            </div>

            <div>
                <p class="admin-detail-label">Mensaje del cliente</p>
                <div class="admin-message-box">
                    {{ $lead->message }}
                </div>
            </div>
        </div>

        {{-- Conversación / Historial de respuestas --}}
        <div class="admin-form-card admin-mb-md">
            <h3 class="admin-section-title">
                <i class="fa-solid fa-comments" style="color:var(--admin-purple);font-size:0.95rem"></i>
                Conversación
            </h3>

            <div class="admin-conversation">
                {{-- Mensaje original del lead --}}
                <div class="admin-conv-message admin-conv-message--client">
                    <div class="admin-conv-avatar admin-conv-avatar--client">
                        {{ strtoupper(substr($lead->name, 0, 2)) }}
                    </div>
                    <div class="admin-conv-content">
                        <div class="admin-conv-meta">
                            <strong>{{ $lead->name }}</strong>
                            <span>{{ $lead->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="admin-conv-bubble admin-conv-bubble--client">
                            {{ $lead->message }}
                        </div>
                    </div>
                </div>

                {{-- Respuestas --}}
                @forelse($lead->replies as $reply)
                    <div class="admin-conv-message admin-conv-message--admin">
                        <div class="admin-conv-content">
                            <div class="admin-conv-meta">
                                <strong>{{ $reply->user->name ?? 'Admin' }}</strong>
                                <span>{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                @if($reply->sent_to_email)
                                    <span class="admin-badge admin-badge-green" style="font-size:10px; padding:2px 6px;"><i class="fa-solid fa-envelope"></i> Enviado por email</span>
                                @endif
                            </div>
                            <div class="admin-conv-bubble admin-conv-bubble--admin">
                                {!! nl2br(e($reply->message)) !!}
                            </div>
                        </div>
                        <div class="admin-conv-avatar admin-conv-avatar--admin">
                            UP
                        </div>
                    </div>
                @empty
                    <div class="admin-empty-conv">
                        <p>No hay respuestas aún. Escribe la primera respuesta abajo.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Formulario de respuesta --}}
        <div class="admin-form-card">
            <h3 class="admin-section-title">
                <i class="fa-solid fa-paper-plane" style="color:var(--admin-purple);font-size:0.95rem"></i>
                Responder a {{ $lead->name }}
            </h3>

            <form method="POST" action="{{ route('admin.leads.reply', $lead) }}">
                @csrf
                <div class="admin-form-group">
                    <label class="admin-form-label">Tu respuesta</label>
                    <textarea name="message" class="admin-form-control admin-textarea-lg" rows="5"
                              placeholder="Escribe tu respuesta aquí..." required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="admin-error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="admin-reply-options">
                    <label class="admin-checkbox-label">
                        <input type="checkbox" name="send_to_email" value="1" checked class="admin-checkbox">
                        <span><i class="fa-solid fa-envelope"></i> Enviar respuesta al email del cliente ({{ $lead->email }})</span>
                    </label>
                    <label class="admin-checkbox-label">
                        <input type="checkbox" name="send_copy" value="1" class="admin-checkbox">
                        <span><i class="fa-regular fa-copy"></i> Enviar copia a mi correo</span>
                    </label>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Enviar respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Panel lateral --}}
    <div>
        {{-- Estado y Prioridad --}}
        <div class="admin-form-card admin-mb-md">
            <h3 class="admin-section-title admin-section-title--sm">Estado y Prioridad</h3>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                @csrf @method('PUT')
                <div class="admin-form-group">
                    <label class="admin-form-label" style="font-size:0.75rem;color:var(--admin-text-muted)">Estado</label>
                    <select name="status" class="admin-form-control">
                        <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>● Nuevo</option>
                        <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>● Contactado</option>
                        <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>● Cerrado</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label" style="font-size:0.75rem;color:var(--admin-text-muted)">Prioridad</label>
                    <select name="priority" class="admin-form-control">
                        <option value="high" {{ $lead->priority === 'high' ? 'selected' : '' }}>🔴 Alta</option>
                        <option value="medium" {{ $lead->priority === 'medium' ? 'selected' : '' }}>🟡 Media</option>
                        <option value="low" {{ $lead->priority === 'low' ? 'selected' : '' }}>⚪ Baja</option>
                    </select>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-block">
                    <i class="fa-solid fa-save"></i> Guardar cambios
                </button>
            </form>
        </div>

        {{-- Notas internas --}}
        <div class="admin-form-card admin-mb-md">
            <h3 class="admin-section-title admin-section-title--sm">
                <i class="fa-solid fa-sticky-note" style="color:var(--admin-purple);font-size:0.85rem"></i>
                Notas internas
            </h3>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                @csrf @method('PUT')
                <div class="admin-form-group">
                    <textarea name="notes" class="admin-form-control" rows="4"
                              placeholder="Notas privadas sobre este lead...">{{ old('notes', $lead->notes) }}</textarea>
                </div>
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-block admin-btn-sm">
                    <i class="fa-solid fa-save"></i> Guardar notas
                </button>
            </form>
        </div>

        {{-- Info rápida --}}
        <div class="admin-form-card admin-mb-md">
            <h3 class="admin-section-title admin-section-title--sm">Resumen</h3>
            <div class="admin-quick-stats">
                <div class="admin-quick-stat">
                    <span class="admin-quick-stat-value">{{ $lead->replies->count() }}</span>
                    <span class="admin-quick-stat-label">Respuestas</span>
                </div>
                <div class="admin-quick-stat">
                    <span class="admin-quick-stat-value">{{ $lead->replies->where('sent_to_email', true)->count() }}</span>
                    <span class="admin-quick-stat-label">Emails enviados</span>
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="admin-form-card">
            <h3 class="admin-section-title admin-section-title--sm">Acciones</h3>
            <div class="admin-actions-stack">
                <a href="mailto:{{ $lead->email }}" class="admin-btn admin-btn-success admin-btn-block">
                    <i class="fa-solid fa-envelope"></i> Abrir email directo
                </a>
                @if($lead->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank"
                       class="admin-btn admin-btn-secondary admin-btn-block">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                @endif
                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('¿Eliminar este lead y todas sus respuestas?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-block">
                        <i class="fa-solid fa-trash"></i> Eliminar lead
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="admin-mt-lg">
    <a href="{{ route('admin.leads.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Volver a leads
    </a>
</div>
@endsection
