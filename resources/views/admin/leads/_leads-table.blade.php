{{-- Admin Leads Grid Partial - Premium Design --}}
<div class="leads-cards-grid">
    @forelse($leads as $lead)
    <article class="lead-card {{ !$lead->read_at ? 'lead-card--unread' : '' }}" 
             data-lead-id="{{ $lead->id }}"
             data-aos="fade-up"
             data-aos-delay="{{ $loop->index * 50 }}">
        
        {{-- Card Glow Effect --}}
        <div class="lead-card-glow"></div>
        
        {{-- Priority Indicator --}}
        <div class="lead-card-priority-bar lead-card-priority-bar--{{ $lead->priority }}"></div>
        
        {{-- Card Header --}}
        <div class="lead-card-header">
            <div class="lead-card-checkbox-wrapper">
                <input type="checkbox" 
                       name="lead_ids[]" 
                       value="{{ $lead->id }}" 
                       class="lead-checkbox-input lead-check"
                       id="lead-{{ $lead->id }}">
                <label for="lead-{{ $lead->id }}" class="lead-checkbox-label">
                    <svg class="lead-checkbox-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </label>
            </div>

            <div class="lead-card-avatar-wrapper">
                <div class="lead-card-avatar lead-card-avatar--{{ $lead->priority }}">
                    <span class="lead-card-avatar-text">{{ strtoupper(substr($lead->name, 0, 2)) }}</span>
                    @if(!$lead->read_at)
                        <span class="lead-card-new-badge">
                            <span class="lead-card-new-badge-dot"></span>
                        </span>
                    @endif
                </div>
                <div class="lead-card-priority-icon lead-card-priority-icon--{{ $lead->priority }}">
                    @if($lead->priority === 'high')
                        <i class="fa-solid fa-flag"></i>
                    @elseif($lead->priority === 'medium')
                        <i class="fa-solid fa-flag"></i>
                    @else
                        <i class="fa-regular fa-flag"></i>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="lead-card-body">
            <h3 class="lead-card-name">
                <a href="{{ route('admin.leads.show', $lead) }}" class="lead-card-name-link">
                    {{ $lead->name }}
                </a>
            </h3>

            <div class="lead-card-contacts">
                <div class="lead-card-contact-item">
                    <div class="lead-card-contact-icon lead-card-contact-icon--email">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <a href="mailto:{{ $lead->email }}" class="lead-card-contact-text lead-card-contact-text--link">
                        {{ $lead->email }}
                    </a>
                </div>
                
                @if($lead->phone)
                <div class="lead-card-contact-item">
                    <div class="lead-card-contact-icon lead-card-contact-icon--phone">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <span class="lead-card-contact-text">{{ $lead->phone }}</span>
                </div>
                @endif
            </div>

            @if($lead->service)
            <div class="lead-card-service">
                <i class="fa-solid fa-briefcase"></i>
                <span>{{ $lead->service->title }}</span>
            </div>
            @endif

            @if($lead->message)
            <div class="lead-card-message">
                <div class="lead-card-message-icon">
                    <i class="fa-solid fa-quote-left"></i>
                </div>
                <p class="lead-card-message-text">{{ Str::limit($lead->message, 120) }}</p>
            </div>
            @endif
        </div>

        {{-- Card Footer --}}
        <div class="lead-card-footer">
            <div class="lead-card-badges">
                @if($lead->status === 'new')
                    <span class="lead-badge lead-badge--new">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>Nuevo</span>
                    </span>
                @elseif($lead->status === 'contacted')
                    <span class="lead-badge lead-badge--contacted">
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>Contactado</span>
                    </span>
                @else
                    <span class="lead-badge lead-badge--closed">
                        <i class="fa-solid fa-check-circle"></i>
                        <span>Cerrado</span>
                    </span>
                @endif

                @if($lead->source === 'chat')
                    <span class="lead-badge lead-badge--chat">
                        <i class="fa-solid fa-comment-dots"></i>
                        <span>Chat</span>
                    </span>
                @else
                    <span class="lead-badge lead-badge--form">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Web</span>
                    </span>
                @endif
            </div>

            <div class="lead-card-meta">
                <span class="lead-card-meta-item" title="Respuestas">
                    <i class="fa-solid fa-reply"></i>
                    <span>{{ $lead->replies_count }}</span>
                </span>
                <span class="lead-card-meta-item" title="Fecha">
                    <i class="fa-regular fa-clock"></i>
                    <span>{{ $lead->created_at->diffForHumans() }}</span>
                </span>
            </div>
        </div>

        {{-- Card Actions --}}
        <div class="lead-card-actions">
            <a href="{{ route('admin.leads.show', $lead) }}" 
               class="lead-card-btn lead-card-btn--primary">
                <i class="fa-solid fa-eye"></i>
                <span>Ver detalles</span>
            </a>

            <div class="lead-card-quick-actions">
                @if($lead->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" 
                   target="_blank"
                   class="lead-card-quick-btn lead-card-quick-btn--whatsapp"
                   title="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                @endif

                <a href="mailto:{{ $lead->email }}" 
                   class="lead-card-quick-btn lead-card-quick-btn--email"
                   title="Enviar email">
                    <i class="fa-solid fa-envelope"></i>
                </a>

                <form method="POST" 
                      action="{{ route('admin.leads.destroy', $lead) }}" 
                      onsubmit="return confirm('¿Eliminar este lead permanentemente?')"
                      style="display: inline;">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="lead-card-quick-btn lead-card-quick-btn--delete"
                            title="Eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </article>
    @empty
    {{-- Empty State --}}
    <div class="leads-empty-state">
        <div class="leads-empty-state-illustration">
            <div class="leads-empty-state-icon">
                <i class="fa-solid fa-inbox"></i>
            </div>
            <div class="leads-empty-state-circle leads-empty-state-circle-1"></div>
            <div class="leads-empty-state-circle leads-empty-state-circle-2"></div>
            <div class="leads-empty-state-circle leads-empty-state-circle-3"></div>
        </div>
        <h3 class="leads-empty-state-title">No se encontraron leads</h3>
        <p class="leads-empty-state-text">
            @if(request('search') || request('status') || request('priority') || request('source'))
                No hay leads que coincidan con los filtros aplicados.<br>
                Intenta ajustar los criterios de búsqueda.
            @else
                Aún no has recibido ningún lead.<br>
                Los nuevos contactos aparecerán aquí automáticamente.
            @endif
        </p>
        @if(request('search') || request('status') || request('priority') || request('source'))
            <button type="button" class="leads-empty-state-btn" data-filter-clear>
                <i class="fa-solid fa-rotate-left"></i>
                <span>Limpiar filtros</span>
            </button>
        @endif
    </div>
    @endforelse
</div>
