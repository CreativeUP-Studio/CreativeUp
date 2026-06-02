{{-- Admin Leads Grid Partial - Rediseño Premium --}}
<div class="svc-grid" id="leadsGrid">
    @forelse($leads as $lead)
    @php
        $cardColor = '#6366f1';
        if ($lead->priority === 'high') {
            $cardColor = '#ef4444';
        } elseif ($lead->priority === 'medium') {
            $cardColor = '#f59e0b';
        }
    @endphp
    <div class="svc-card-item {{ !$lead->read_at ? 'lead-card--unread' : '' }}" style="--card-color: {{ $cardColor }};" data-id="{{ $lead->id }}">
        
        {{-- Card Top Banner --}}
        <div class="svc-card-banner" style="background: linear-gradient(135deg, {{ $cardColor }}e0 0%, #1e293b 100%); position: relative; height: 120px;">
            {{-- Bulk Action Checkbox inside Banner --}}
            <div style="position: absolute; top: 1rem; left: 1rem; z-index: 3;" onclick="event.stopPropagation();">
                <input type="checkbox" name="lead_ids[]" value="{{ $lead->id }}" class="lead-checkbox-input lead-check" id="lead-{{ $lead->id }}" onchange="updateBulkBar()">
                <label for="lead-{{ $lead->id }}" class="lead-checkbox-label">
                    <svg class="lead-checkbox-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </label>
            </div>

            {{-- Priority Badge in Top Right --}}
            <div style="position: absolute; top: 1rem; right: 1rem; z-index: 3;">
                <span style="font-size: 0.65rem; font-weight: 800; color: white; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); padding: 0.35rem 0.65rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $lead->priority === 'high' ? '🔴 Alta' : ($lead->priority === 'medium' ? '🟡 Media' : '⚪ Baja') }}
                </span>
            </div>
            
            <div class="svc-card-overlay"></div>
        </div>

        {{-- Overlapping Avatar Badge --}}
        <div class="svc-card-emoji-wrap" style="top: 98px; width: 44px; height: 44px; border-radius: 12px; font-size: 1.15rem; font-weight: 800; text-transform: uppercase; font-family: inherit; border: 3px solid white; display: flex; align-items: center; justify-content: center; background: {{ $cardColor }}; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <span>{{ strtoupper(substr($lead->name, 0, 2)) }}</span>
        </div>

        {{-- Card Body --}}
        <div class="svc-card-body" style="padding-top: 1.75rem;">
            <h3 class="svc-card-title">
                <a href="{{ route('admin.leads.show', $lead) }}" style="color: var(--text-main); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-main)'">
                    {{ $lead->name }}
                </a>
            </h3>
            
            <span class="svc-card-slug" style="font-size: 0.8rem; color: var(--text-muted); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <i class="fa-regular fa-envelope" style="margin-right: 0.25rem;"></i>{{ $lead->email }}
            </span>

            @if($lead->phone)
            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                <i class="fa-solid fa-phone" style="margin-right: 0.25rem;"></i>{{ $lead->phone }}
            </div>
            @endif

            <p class="svc-card-desc" style="-webkit-line-clamp: 2; margin: 1rem 0 1.25rem 0;">
                {{ $lead->message }}
            </p>

            {{-- Metadata Badges --}}
            <div class="svc-card-metadata">
                {{-- Status Badge --}}
                @if($lead->status === 'new')
                    <span class="lead-badge lead-badge--new">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>Nuevo</span>
                    </span>
                @elseif($lead->status === 'contacted')
                    <span class="lead-badge lead-badge--contacted">
                        <i class="fa-solid fa-spinner"></i>
                        <span>En Proceso</span>
                    </span>
                @else
                    <span class="lead-badge lead-badge--closed">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Cerrado</span>
                    </span>
                @endif

                {{-- Source Badge --}}
                @if($lead->source === 'chat')
                    <span class="lead-badge lead-badge--chat">
                        <i class="fa-solid fa-comment-dots"></i>
                        <span>Chat</span>
                    </span>
                @elseif($lead->source === 'newsletter')
                    <span class="lead-badge lead-badge--newsletter">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Boletín</span>
                    </span>
                @else
                    <span class="lead-badge lead-badge--web">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Web</span>
                    </span>
                @endif

                {{-- Date Badge --}}
                <span class="svc-card-badge" title="Fecha">
                    <i class="fa-regular fa-clock"></i>
                    <span>{{ $lead->created_at->diffForHumans() }}</span>
                </span>
            </div>

            {{-- Actions Grid --}}
            <div class="svc-card-actions" style="margin-top: auto; display: flex; gap: 0.5rem; align-items: center;">
                <a href="{{ route('admin.leads.show', $lead) }}" class="svc-card-btn svc-card-btn--preview" title="Ver Detalles" onclick="event.stopPropagation();">
                    <i class="fa-solid fa-eye"></i>
                    <span>Ver Detalles</span>
                </a>
                
                @if($lead->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="svc-card-btn" title="WhatsApp" onclick="event.stopPropagation();" style="flex: 0 0 38px; width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 8px; text-decoration: none;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.15rem;"></i>
                </a>
                @endif

                <a href="mailto:{{ $lead->email }}" class="svc-card-btn" title="Enviar Email" onclick="event.stopPropagation();" style="flex: 0 0 38px; width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 8px; text-decoration: none;">
                    <i class="fa-solid fa-envelope" style="font-size: 1rem;"></i>
                </a>

                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" style="display: inline-block; margin: 0;" onsubmit="event.stopPropagation(); return confirm('¿Estás seguro de eliminar este lead?\n\nNombre: {{ $lead->name }}\nEmail: {{ $lead->email }}\n\nEsta acción no se puede deshacer.');">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="svc-card-btn svc-card-btn--delete" title="Eliminar Lead" 
                            style="flex: 0 0 38px; width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: none; cursor: pointer; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">
                        <i class="fa-solid fa-trash-can" style="font-size: 0.95rem;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="svc-empty-state" style="grid-column: 1 / -1; padding: 4rem 2rem; width: 100%;">
        <i class="fa-solid fa-inbox svc-empty-icon" style="font-size: 3.5rem; opacity: 0.3; margin-bottom: 1.5rem;"></i>
        <h3>No se encontraron leads</h3>
        <p>Intenta ajustar los filtros de búsqueda o limpiar las opciones seleccionadas.</p>
    </div>
    @endforelse
</div>
