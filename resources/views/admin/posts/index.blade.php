@extends('admin.layouts.app')

@section('title', 'Blog / Posts')
@section('page-title', 'Blog / Posts')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
<style>
    /* Google Search Snippet Preview Styling */
    .google-preview-card {
        background: #ffffff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        font-family: Arial, sans-serif;
    }
    .google-preview-url {
        font-size: 12px;
        color: #202124;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .google-preview-title {
        font-size: 20px;
        color: #1a0dab;
        line-height: 1.3;
        margin: 0 0 4px 0;
        font-weight: normal;
        cursor: pointer;
        display: inline-block;
    }
    .google-preview-title:hover {
        text-decoration: underline;
    }
    .google-preview-snippet {
        font-size: 14px;
        color: #4d5156;
        line-height: 1.58;
        margin: 0;
    }
    
    /* Reading Mode container */
    .reading-mode-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1.25rem;
        max-height: 250px;
        overflow-y: auto;
        color: #e2e8f0;
        font-size: 0.85rem;
        line-height: 1.6;
        white-space: pre-wrap;
    }
    .reading-mode-box::-webkit-scrollbar {
        width: 6px;
    }
    .reading-mode-box::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     1. COMPACT PAGE HEADER
     ═══════════════════════════════════════════════════ --}}
<div class="svc-header" data-ajax-stats>
    <div class="svc-header-left">
        <div class="svc-header-info">
            <h1>
                <i class="fa-solid fa-newspaper" style="color: var(--primary-color);"></i>
                Blog & Artículos
            </h1>
        </div>
    </div>
    <div class="svc-header-stats">
        <div class="svc-header-stat-item" title="Posts Publicados">
            <span class="svc-header-stat-lbl">Publicados:</span>
            <span class="svc-header-stat-num text-success" data-stat="published">{{ \App\Models\Post::where('status', 'published')->count() }}</span>
        </div>
        <div class="svc-header-stat-item" title="Posts en Borrador">
            <span class="svc-header-stat-lbl">Borradores:</span>
            <span class="svc-header-stat-num text-warning" data-stat="draft">{{ \App\Models\Post::where('status', 'draft')->count() }}</span>
        </div>
        <div class="svc-header-stat-item" title="Total Posts">
            <span class="svc-header-stat-lbl">Total:</span>
            <span class="svc-header-stat-num" data-stat="total">{{ \App\Models\Post::count() }}</span>
        </div>
        <button type="button" class="admin-btn admin-btn-secondary" id="toggleInsightsBtn" onclick="toggleInsights()" style="margin: 0 0 0 1rem; padding: 0.4rem 0.8rem; font-size: 0.75rem; border-radius: 8px; height: 32px; display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-chart-line"></i>
            <span>Ver Insights</span>
        </button>
    </div>
</div>

{{-- Insights Panel --}}
<div class="svc-insights-panel" id="insightsPanel" style="max-height: 0px; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); margin-bottom: 0rem; opacity: 0;">
    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.25rem; margin-bottom: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
        
        {{-- Stat Card 1: Palabras y Lectura --}}
        <div style="background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; gap: 0.5rem;">
            <h4 style="margin: 0; font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-book-open" style="color: #38bdf8;"></i>
                Lectura & Palabras
            </h4>
            <div style="font-size: 1.5rem; font-weight: 700; color: white; margin-top: 4px;">
                <span data-stat="words">{{ number_format(\App\Models\Post::all()->sum(function($p) { return str_word_count(strip_tags($p->content)); })) }}</span>
                <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">palabras escritas</span>
            </div>
            <div style="font-size: 0.8rem; color: #cbd5e1;">
                Tiempo de lectura acumulado: <strong style="color: white;"><span data-stat="reading_time">{{ \App\Models\Post::all()->sum(function($p) { return max(1, (int) ceil(str_word_count(strip_tags($p->content)) / 200)); }) }}</span> min</strong>
            </div>
        </div>

        {{-- Stat Card 2: Categorías Distribution --}}
        <div style="background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; gap: 0.5rem; grid-column: span 2;">
            <h4 style="margin: 0; font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-tags" style="color: #a855f7;"></i>
                Distribución de Categorías
            </h4>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 4px;">
                @php
                    $cats = ['branding' => 'Branding', 'diseno' => 'Diseño Web', 'seo' => 'SEO', 'redes' => 'Social Media', 'marketing' => 'Marketing'];
                    $colors = ['branding' => '#ff006e', 'diseno' => '#8338ec', 'seo' => '#00b4d8', 'redes' => '#f59e0b', 'marketing' => '#06d6a0'];
                    $totalPosts = \App\Models\Post::count() ?: 1;
                @endphp
                @foreach($cats as $slug => $label)
                    @php
                        $count = \App\Models\Post::where('category', $slug)->count();
                        $pct = round(($count / $totalPosts) * 100);
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem;">
                        <span style="color: #cbd5e1; display: flex; align-items: center; gap: 6px; width: 150px;">
                            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: {{ $colors[$slug] }};"></span>
                            {{ $label }}:
                            <strong style="color: white;"><span data-stat="{{ $slug }}">{{ $count }}</span></strong>
                        </span>
                        <div style="flex: 1; margin: 0 12px; height: 6px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden; position: relative;">
                            <div id="bar-{{ $slug }}" style="width: {{ $pct }}%; height: 100%; background-color: {{ $colors[$slug] }}; border-radius: 10px; transition: width 0.6s ease;"></div>
                        </div>
                        <span style="color: #94a3b8; width: 35px; text-align: right;"><span data-pct="{{ $slug }}">{{ $pct }}</span>%</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     2. TOOLBAR (SEARCH, FILTERS & ACTION)
     ═══════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('admin.posts.index') }}" class="svc-toolbar" role="search" data-ajax-filter id="postsFilterForm">
    <div style="display: flex; align-items: center; gap: 1rem; flex: 1; flex-wrap: wrap;">
        <input type="hidden" name="status" id="statusFilterHidden" class="admin-form-select" data-filter-select value="{{ request('status') }}">
        
        <div class="svc-filters">
            <button type="button" class="svc-filter-pill {{ request('status') === '' || !request('status') ? 'active' : '' }}" onclick="setStatusFilter(this, '')">
                <i class="fa-solid fa-border-all"></i>
                <span>Todos</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'published' ? 'active' : '' }}" onclick="setStatusFilter(this, 'published')">
                <i class="fa-solid fa-circle-check"></i>
                <span>Publicados</span>
            </button>
            <button type="button" class="svc-filter-pill {{ request('status') === 'draft' ? 'active' : '' }}" onclick="setStatusFilter(this, 'draft')">
                <i class="fa-solid fa-circle-pause"></i>
                <span>Borradores</span>
            </button>
        </div>

        <div class="svc-search-box">
            <input type="text" class="svc-search-input" id="search-input" name="search" data-search-input value="{{ request('search') }}" placeholder="Buscar por título, contenido..." autocomplete="off">
            <i class="fa-solid fa-magnifying-glass svc-search-icon"></i>
            <kbd class="svc-search-shortcut">/</kbd>
        </div>

        <div style="position: relative;">
            <select id="category-filter" name="category" class="admin-form-select" data-filter-select style="min-width: 165px; height: 38px; border-radius: 10px; border: 1px solid var(--admin-border); padding: 0 1rem; font-size: 0.825rem; font-weight: 600; background-color: #f1f5f9; color: var(--admin-text-secondary); cursor: pointer;">
                <option value="">Todas las categorías</option>
                <option value="branding" {{ request('category') === 'branding' ? 'selected' : '' }}>Branding</option>
                <option value="diseno" {{ request('category') === 'diseno' ? 'selected' : '' }}>Diseño</option>
                <option value="seo" {{ request('category') === 'seo' ? 'selected' : '' }}>SEO</option>
                <option value="redes" {{ request('category') === 'redes' ? 'selected' : '' }}>Redes</option>
                <option value="marketing" {{ request('category') === 'marketing' ? 'selected' : '' }}>Marketing</option>
            </select>
        </div>

        <div style="position: relative;">
            <select id="sort-filter" name="sort" class="admin-form-select" data-filter-select style="min-width: 150px; height: 38px; border-radius: 10px; border: 1px solid var(--admin-border); padding: 0 1rem; font-size: 0.825rem; font-weight: 600; background-color: #f1f5f9; color: var(--admin-text-secondary); cursor: pointer;">
                <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>Más recientes</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Título A-Z</option>
            </select>
        </div>
    </div>

    <a href="{{ route('admin.posts.create') }}" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.65rem 1.25rem; font-size: 0.85rem; border-radius: 10px;">
        <i class="fa-solid fa-plus"></i>
        <span>Nuevo Post</span>
    </a>
</form>

{{-- ═══════════════════════════════════════════════════
     3. BLOG POSTS GRID WITH AJAX
     ═══════════════════════════════════════════════════ --}}
<div data-ajax-results>
    @if($posts->count() > 0)
    <div class="svc-grid" id="postsGrid">
        @include('admin.posts._posts-grid')
    </div>

    {{-- Paginación --}}
    @if($posts->hasPages())
    <div class="admin-pagination" id="postsPagination" data-ajax-pagination>
        {{ $posts->appends(request()->query())->links() }}
    </div>
    @endif
    
    @else
    <div class="svc-empty-state">
        <i class="fa-solid fa-newspaper svc-empty-icon"></i>
        <h3>No se encontraron artículos</h3>
        <p>Intenta ajustar los filtros de búsqueda o crea un nuevo artículo.</p>
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════
     4. SLIDE-OVER DRAWER (PREVIEW PANEL)
     ═══════════════════════════════════════════════════ --}}
<div class="svc-drawer" id="svcDrawer">
    <div class="svc-drawer-backdrop" onclick="closePostDrawer()"></div>
    <div class="svc-drawer-content">
        <div class="svc-drawer-header">
            <h3><i class="fa-solid fa-mobile-screen-button"></i> Vista Previa del Artículo</h3>
            <button type="button" class="svc-drawer-close" onclick="closePostDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="svc-drawer-body" id="drawerBody">
            {{-- Cargado dinámicamente --}}
        </div>
    </div>
</div>

{{-- Quick Edit Modal --}}
<div class="svc-modal" id="quickEditModal" style="display: none; position: fixed; inset: 0; z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
    <div class="svc-modal-backdrop" onclick="closeQuickEdit()" style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px); transition: all 0.3s ease;"></div>
    <div class="svc-modal-content" style="position: relative; width: 100%; max-width: 500px; background: #1e293b; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 1.5rem; color: white; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); z-index: 1001;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 0.75rem;">
            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; display: flex; align-items: center; gap: 8px; color: #38bdf8;">
                <i class="fa-solid fa-bolt"></i>
                Edición Rápida
            </h3>
            <button type="button" onclick="closeQuickEdit()" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.25rem; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="quickEditForm" onsubmit="saveQuickEdit(event)">
            @csrf
            <input type="hidden" id="qe_post_id">

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                {{-- Title --}}
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <label for="qe_title" style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">Título del Artículo</label>
                    <input type="text" id="qe_title" required style="width: 100%; height: 38px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: rgba(0,0,0,0.25); color: white; padding: 0 0.75rem; font-size: 0.85rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#38bdf8'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                </div>

                {{-- Slug --}}
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <label for="qe_slug" style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">Slug URL</label>
                    <input type="text" id="qe_slug" required style="width: 100%; height: 38px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: rgba(0,0,0,0.25); color: white; padding: 0 0.75rem; font-size: 0.85rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#38bdf8'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    {{-- Category --}}
                    <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                        <label for="qe_category" style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">Categoría</label>
                        <select id="qe_category" style="width: 100%; height: 38px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: #0f172a; color: white; padding: 0 0.5rem; font-size: 0.85rem; cursor: pointer; outline: none;">
                            <option value="branding">Branding</option>
                            <option value="diseno">Diseño Web</option>
                            <option value="seo">SEO & Analytics</option>
                            <option value="redes">Social Media</option>
                            <option value="marketing">Marketing Digital</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                        <label for="qe_status" style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">Estado</label>
                        <select id="qe_status" style="width: 100%; height: 38px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: #0f172a; color: white; padding: 0 0.5rem; font-size: 0.85rem; cursor: pointer; outline: none;">
                            <option value="draft">Borrador</option>
                            <option value="published">Publicado</option>
                        </select>
                    </div>
                </div>

                {{-- Published At --}}
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <label for="qe_published_at" style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">Fecha de Publicación</label>
                    <input type="datetime-local" id="qe_published_at" style="width: 100%; height: 38px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: rgba(0,0,0,0.25); color: white; padding: 0 0.75rem; font-size: 0.85rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#38bdf8'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                </div>

                {{-- Meta Description --}}
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <label for="qe_meta_description" style="font-size: 0.75rem; font-weight: 600; color: #94a3b8;">Meta Descripción (SEO)</label>
                    <textarea id="qe_meta_description" rows="2" style="width: 100%; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: rgba(0,0,0,0.25); color: white; padding: 0.5rem 0.75rem; font-size: 0.85rem; resize: vertical; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#38bdf8'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'"></textarea>
                </div>
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1rem;">
                <button type="button" class="admin-btn admin-btn-secondary" onclick="closeQuickEdit()" style="margin: 0; padding: 0.5rem 1rem; border-radius: 8px; height: 36px;">
                    Cancelar
                </button>
                <button type="submit" class="admin-btn admin-btn-primary" style="margin: 0; padding: 0.5rem 1.25rem; border-radius: 8px; height: 36px; background: #38bdf8; color: #0f172a; font-weight: 700; border: none; transition: background 0.2s;" onmouseover="this.style.background='#0ea5e9'" onmouseout="this.style.background='#38bdf8'">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     5. JAVASCRIPT LOGIC
     ═══════════════════════════════════════════════════ --}}
@push('scripts')
<script>
function initPostsModule() {
    // A. status pill filters
    window.setStatusFilter = function(button, statusValue) {
        const pills = button.closest('.svc-filters').querySelectorAll('.svc-filter-pill');
        pills.forEach(p => p.classList.remove('active'));
        button.classList.add('active');
        
        const hiddenInput = document.getElementById('statusFilterHidden');
        if (hiddenInput) {
            hiddenInput.value = statusValue;
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    };

    // B. Conmutadores de Estado AJAX (Switches)
    const grid = document.getElementById('postsGrid');
    if (grid && !grid.dataset.listenerBound) {
        grid.dataset.listenerBound = 'true';
        grid.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('post-active-toggle')) {
                const toggle = e.target;
                const postId = toggle.getAttribute('data-id');
                const isChecked = toggle.checked;
                const label = document.getElementById(`statusLabel-${postId}`);
                const card = toggle.closest('.svc-card-item');

                // Actualizar localmente inmediatamente
                if (label) label.textContent = isChecked ? 'Publicado' : 'Borrador';
                if (card) card.setAttribute('data-status', isChecked ? 'published' : 'draft');

                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const token = csrfMeta ? csrfMeta.getAttribute('content') : '';

                fetch(`/admin/posts/${postId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Error al actualizar estado');
                    return res.json();
                })
                .then(data => {
                    if (window.Toast) {
                        window.Toast.fire({
                            icon: 'success',
                            title: data.status === 'published' ? 'Artículo publicado' : 'Artículo en borrador'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    // Revertir en caso de fallo
                    toggle.checked = !toggle.checked;
                    if (label) label.textContent = toggle.checked ? 'Publicado' : 'Borrador';
                    if (card) card.setAttribute('data-status', toggle.checked ? 'published' : 'draft');
                    alert('Ocurrió un error al actualizar el estado del artículo.');
                });
            }
        });
    }

    // C. Insights Panel Toggle
    window.toggleInsights = function() {
        const panel = document.getElementById('insightsPanel');
        const btn = document.getElementById('toggleInsightsBtn');
        if (!panel || !btn) return;
        
        if (panel.style.maxHeight === '0px' || panel.style.maxHeight === '') {
            panel.style.maxHeight = '600px';
            panel.style.opacity = '1';
            panel.style.marginBottom = '1.5rem';
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> <span>Ocultar Insights</span>';
        } else {
            panel.style.maxHeight = '0px';
            panel.style.opacity = '0';
            panel.style.marginBottom = '0rem';
            btn.innerHTML = '<i class="fa-solid fa-chart-line"></i> <span>Ver Insights</span>';
        }
    };

    // D. Quick Edit Modal Functions
    window.openQuickEdit = function(id) {
        const card = document.querySelector(`.svc-card-item[data-id="${id}"]`);
        if (!card) return;

        const title = card.getAttribute('data-title') || '';
        const slug = card.getAttribute('data-slug') || '';
        const category = card.getAttribute('data-category') || '';
        const status = card.getAttribute('data-status') || 'draft';
        const publishedAtRaw = card.getAttribute('data-published-at-raw') || '';
        const metaDesc = card.getAttribute('data-meta-description') || '';

        document.getElementById('qe_post_id').value = id;
        document.getElementById('qe_title').value = title;
        document.getElementById('qe_slug').value = slug;
        document.getElementById('qe_category').value = category;
        document.getElementById('qe_status').value = status;
        document.getElementById('qe_published_at').value = publishedAtRaw;
        document.getElementById('qe_meta_description').value = metaDesc;

        document.getElementById('quickEditModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeQuickEdit = function() {
        document.getElementById('quickEditModal').style.display = 'none';
        document.body.style.overflow = '';
    };

    window.saveQuickEdit = function(e) {
        e.preventDefault();
        const id = document.getElementById('qe_post_id').value;
        const title = document.getElementById('qe_title').value;
        const slug = document.getElementById('qe_slug').value;
        const category = document.getElementById('qe_category').value;
        const status = document.getElementById('qe_status').value;
        const published_at = document.getElementById('qe_published_at').value;
        const meta_description = document.getElementById('qe_meta_description').value;

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const token = csrfMeta ? csrfMeta.getAttribute('content') : '';

        fetch(`/admin/posts/${id}/quick-update`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title, slug, category, status, published_at, meta_description
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Error al actualizar');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                closeQuickEdit();

                if (window.Toast) {
                    window.Toast.fire({
                        icon: 'success',
                        title: 'Artículo actualizado exitosamente'
                    });
                }
                
                // Disparar recarga AJAX del listado para reflejar cambios y actualizar Insights
                const searchInput = document.getElementById('search-input');
                if (searchInput) {
                    searchInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        })
        .catch(err => {
            console.error(err);
            alert('Ocurrió un error al actualizar el artículo.');
        });
    };

    // E. Drawer Open / Close / Tabs Functions
    window.switchPreviewTab = function(tabName) {
        const tabs = ['google', 'facebook', 'twitter'];
        tabs.forEach(t => {
            const content = document.getElementById('tab-' + t);
            const btn = document.getElementById('btn-tab-' + t);
            if (content && btn) {
                if (t === tabName) {
                    content.style.display = 'block';
                    btn.style.background = '#38bdf8';
                    btn.style.color = '#0f172a';
                } else {
                    content.style.display = 'none';
                    btn.style.background = 'none';
                    btn.style.color = '#cbd5e1';
                }
            }
        });
    };

    window.openPostPreview = function(id) {
        const card = document.querySelector(`.svc-card-item[data-id="${id}"]`);
        const drawer = document.getElementById('svcDrawer');
        const drawerBody = document.getElementById('drawerBody');
        
        if (!card || !drawer || !drawerBody) {
            console.error("Preview error: Elements missing", { card, drawer, drawerBody });
            return;
        }

        const title = card.getAttribute('data-title') || '';
        const slug = card.getAttribute('data-slug') || '';
        const excerpt = card.getAttribute('data-excerpt') || '';
        const content = card.getAttribute('data-content') || '';
        const category = card.getAttribute('data-category') || '';
        const date = card.getAttribute('data-date') || '';
        const author = card.getAttribute('data-author') || '';
        const image = card.getAttribute('data-image') || '';
        const metaDesc = card.getAttribute('data-meta-description') || '';
        const status = card.getAttribute('data-status') === 'published' ? 'Publicado' : 'Borrador';

        const imageHtml = image 
            ? `<img src="${image}" alt="${title}" style="width:100%; height:180px; object-fit:cover; border-radius:14px; margin-bottom:1rem; border: 1px solid rgba(255,255,255,0.08);">`
            : `<div style="width:100%; height:180px; background:linear-gradient(135deg, rgba(255, 0, 110, 0.15) 0%, rgba(131, 56, 236, 0.05) 100%); display:flex; align-items:center; justify-content:center; border-radius:14px; margin-bottom:1rem; border:1px solid rgba(255,255,255,0.08);">
                 <i class="fa-solid fa-newspaper" style="font-size:3.5rem; color:var(--admin-primary); opacity:0.4;"></i>
               </div>`;

        // Contar palabras y tiempo de lectura
        const words = content.trim().split(/\s+/).filter(w => w).length;
        const readTime = Math.max(1, Math.ceil(words / 200));

        // Calcular Score SEO
        let seoScore = 0;
        let checklistHtml = '';

        // 1. Título
        const titleLen = title.length;
        if (titleLen >= 40 && titleLen <= 70) {
            seoScore += 30;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#4ade80;"><i class="fa-solid fa-circle-check" style="margin-top:2px;"></i><span>El título tiene una longitud óptima (${titleLen} caracteres).</span></div>`;
        } else {
            seoScore += 15;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#facc15;"><i class="fa-solid fa-circle-exclamation" style="margin-top:2px;"></i><span>Longitud de título no recomendada (actual: ${titleLen}). Lo ideal es entre 40 y 70 caracteres.</span></div>`;
        }

        // 2. Meta descripción
        const metaLen = metaDesc.length;
        if (metaLen >= 110 && metaLen <= 160) {
            seoScore += 30;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#4ade80;"><i class="fa-solid fa-circle-check" style="margin-top:2px;"></i><span>Meta descripción optimizada (${metaLen} caracteres).</span></div>`;
        } else if (metaLen > 0) {
            seoScore += 15;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#facc15;"><i class="fa-solid fa-circle-exclamation" style="margin-top:2px;"></i><span>La meta descripción debería tener entre 110 y 160 caracteres (actual: ${metaLen}).</span></div>`;
        } else {
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#f87171;"><i class="fa-solid fa-circle-xmark" style="margin-top:2px;"></i><span>Falta la meta descripción SEO.</span></div>`;
        }

        // 3. Extensión de contenido
        if (words >= 500) {
            seoScore += 25;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#4ade80;"><i class="fa-solid fa-circle-check" style="margin-top:2px;"></i><span>Contenido extenso y rico (${words} palabras).</span></div>`;
        } else if (words >= 300) {
            seoScore += 15;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#cbd5e1;"><i class="fa-solid fa-circle-check" style="margin-top:2px;"></i><span>Extensión de contenido aceptable (${words} palabras).</span></div>`;
        } else {
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#f87171;"><i class="fa-solid fa-circle-xmark" style="margin-top:2px;"></i><span>El contenido es muy corto para posicionar bien en buscadores (menos de 300 palabras).</span></div>`;
        }

        // 4. Imagen Destacada
        if (image) {
            seoScore += 15;
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#4ade80;"><i class="fa-solid fa-circle-check" style="margin-top:2px;"></i><span>Imagen destacada lista para SEO social (OpenGraph).</span></div>`;
        } else {
            checklistHtml += `<div style="display:flex; align-items:start; gap:8px; font-size:0.78rem; color:#f87171;"><i class="fa-solid fa-circle-xmark" style="margin-top:2px;"></i><span>No se ha subido una imagen destacada.</span></div>`;
        }

        // Color del score
        let scoreColor = '#f87171'; // Red
        if (seoScore >= 80) scoreColor = '#4ade80'; // Green
        else if (seoScore >= 50) scoreColor = '#facc15'; // Yellow

        drawerBody.innerHTML = `
            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                ${imageHtml}
                
                <div>
                    <span style="display:inline-flex; padding:0.25rem 0.75rem; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); color:#cbd5e1; font-size:0.68rem; font-weight:700; border-radius:30px; text-transform:uppercase; margin-bottom:0.75rem;">
                        ${status}
                    </span>
                    <h2 style="color:white; font-size:1.45rem; font-weight:800; margin:0; line-height:1.25;">
                        ${title}
                    </h2>
                    <p style="color:#94a3b8; font-size:0.75rem; font-family:monospace; margin:0.35rem 0 0 0;">/blog/${slug}</p>
                </div>

                {{-- Detalles Metas --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem; font-size:0.78rem; color:#cbd5e1; background:rgba(255,255,255,0.03); padding:0.85rem; border-radius:10px; border:1px solid rgba(255,255,255,0.05);">
                    <div><span style="color:#94a3b8;">Autor:</span> <strong>${author}</strong></div>
                    <div><span style="color:#94a3b8;">Categoría:</span> <strong style="text-transform: capitalize;">${category}</strong></div>
                    <div><span style="color:#94a3b8;">Fecha:</span> <strong>${date}</strong></div>
                    <div><span style="color:#94a3b8;">Lectura:</span> <strong>${readTime} min (${words} pal)</strong></div>
                </div>

                {{-- Sección: SEO Puntuación y Recomendaciones --}}
                <div style="background:rgba(255,255,255,0.02); padding:1rem; border-radius:12px; border:1px solid rgba(255,255,255,0.05);">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
                        <h4 style="color:white; font-size:0.85rem; font-weight:700; text-transform:uppercase; margin:0; display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-gauge-high" style="color:#0ea5e9;"></i>
                            Análisis de SEO On-Page
                        </h4>
                        <div style="background:${scoreColor}20; color:${scoreColor}; padding:2px 10px; border-radius:30px; font-size:0.8rem; font-weight:800; border:1px solid ${scoreColor}40;">
                            Puntaje: ${seoScore}/100
                        </div>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        ${checklistHtml}
                    </div>
                </div>

                {{-- Sección: Pestañas Simuladoras de Compartido --}}
                <div>
                    <h4 style="color:white; font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 0.5rem 0; display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-share-nodes"></i>
                        <span>Simulador de Compartido Social</span>
                    </h4>
                    
                    <div style="display: flex; gap: 4px; background: rgba(0,0,0,0.25); border-radius: 8px; padding: 4px; margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.05);">
                        <button type="button" class="preview-tab-btn active" onclick="switchPreviewTab('google')" style="flex:1; background: #38bdf8; border: none; color: #0f172a; padding: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer; border-radius: 6px; transition: all 0.2s;" id="btn-tab-google">Google SEO</button>
                        <button type="button" class="preview-tab-btn" onclick="switchPreviewTab('facebook')" style="flex:1; background: none; border: none; color: #cbd5e1; padding: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer; border-radius: 6px; transition: all 0.2s;" id="btn-tab-facebook">Facebook</button>
                        <button type="button" class="preview-tab-btn" onclick="switchPreviewTab('twitter')" style="flex:1; background: none; border: none; color: #cbd5e1; padding: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer; border-radius: 6px; transition: all 0.2s;" id="btn-tab-twitter">Twitter / X</button>
                    </div>

                    {{-- Google SEO Card --}}
                    <div id="tab-google" class="tab-content" style="display: block;">
                        <div class="google-preview-card" style="margin-top:0;">
                            <div class="google-preview-url">
                                <span>https://creativeup.com.co</span>
                                <span style="color:#5f6368;">› blog › ${slug}</span>
                            </div>
                            <a class="google-preview-title" target="_blank" href="/blog/${slug}">
                                ${title} | CreativeUP
                            </a>
                            <p class="google-preview-snippet">
                                <span style="color:#70757a;">${date} — </span>${metaDesc || excerpt || 'No hay descripción SEO configurada para este artículo de blog.'}
                            </p>
                        </div>
                    </div>

                    {{-- Facebook Card --}}
                    <div id="tab-facebook" class="tab-content" style="display: none;">
                        <div style="background: #ffffff; border: 1px solid #dddfe2; border-radius: 8px; overflow: hidden; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; text-align: left; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                            ${image ? `<img src="${image}" style="width: 100%; height: 180px; object-fit: cover;">` : `<div style="width: 100%; height: 180px; background: #f2f3f5; display: flex; align-items: center; justify-content: center; color: #8d949e;"><i class="fa-solid fa-image" style="font-size: 2.5rem;"></i></div>`}
                            <div style="padding: 10px 12px; background: #f2f3f5; border-top: 1px solid #dddfe2;">
                                <div style="font-size: 11px; color: #606770; text-transform: uppercase; margin-bottom: 2px; letter-spacing: 0.5px;">CREATIVEUP.COM.CO</div>
                                <div style="font-size: 14px; font-weight: bold; color: #1c1e21; line-height: 18px; margin-bottom: 3px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">${title}</div>
                                <div style="font-size: 12px; color: #606770; line-height: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${metaDesc || excerpt || 'Visita nuestra web para ver el artículo completo.'}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Twitter Card --}}
                    <div id="tab-twitter" class="tab-content" style="display: none;">
                        <div style="background: #15202b; border: 1px solid #38444d; border-radius: 12px; overflow: hidden; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #ffffff; text-align: left;">
                            ${image ? `<img src="${image}" style="width: 100%; height: 170px; object-fit: cover;">` : `<div style="width: 100%; height: 170px; background: #253341; display: flex; align-items: center; justify-content: center; color: #8899a6;"><i class="fa-solid fa-image" style="font-size: 2.5rem;"></i></div>`}
                            <div style="padding: 10px 12px; background: #15202b; border-top: 1px solid #38444d;">
                                <div style="font-size: 12px; color: #8899a6; margin-bottom: 2px;">creativeup.com.co</div>
                                <div style="font-size: 14px; font-weight: bold; line-height: 18px; margin-bottom: 3px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">${title}</div>
                                <div style="font-size: 12px; color: #8899a6; line-height: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${metaDesc || excerpt || 'Descubre más en nuestro sitio web.'}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección: Modo de Lectura --}}
                <div>
                    <h4 style="color:white; font-size:0.875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin: 1rem 0 0.5rem 0; display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Modo Lectura / Corrección</span>
                    </h4>
                    <div class="reading-mode-box">
                        ${content || 'Este artículo no tiene contenido textual disponible.'}
                    </div>
                </div>
                
                <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid rgba(255,255,255,0.08); display:flex; gap:0.75rem;">
                    <a href="/blog/${slug}" target="_blank" style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:10px; color:white; font-size:0.8rem; font-weight:700; text-transform:uppercase; text-decoration:none; text-align:center; transition:0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                        <i class="fa-solid fa-up-right-from-square"></i>
                        <span>Ver en Web</span>
                    </a>
                    <a href="/admin/posts/${id}/edit" style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.75rem; background:var(--admin-primary); border:none; border-radius:10px; color:white; font-size:0.8rem; font-weight:700; text-transform:uppercase; text-decoration:none; text-align:center; transition:0.2s;" onmouseover="this.style.background='var(--admin-secondary)'" onmouseout="this.style.background='var(--admin-primary)'">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Editar Post</span>
                    </a>
                </div>
            </div>
        `;

        drawer.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closePostDrawer = function() {
        const drawer = document.getElementById('svcDrawer');
        if (drawer) {
            drawer.classList.remove('open');
            document.body.style.overflow = '';
        }
    };

    // F. Escuchar la actualización de filtros AJAX para refrescar las métricas del panel de Insights
    document.removeEventListener('ajaxFilterUpdated', window.handleAjaxStatsUpdate);
    window.handleAjaxStatsUpdate = function(e) {
        const stats = e.detail.stats;
        if (!stats) return;

        // Actualizar el panel de Insights
        const cats = ['branding', 'diseno', 'seo', 'redes', 'marketing'];
        const total = parseInt(stats.total) || 1;
        cats.forEach(c => {
            const count = stats[c] || 0;
            const pct = Math.round((count / total) * 100);
            
            // Actualizar número
            const countEl = document.querySelector(`span[data-stat="${c}"]`);
            if (countEl) countEl.textContent = count;
            
            // Actualizar porcentaje texto
            const pctEl = document.querySelector(`span[data-pct="${c}"]`);
            if (pctEl) pctEl.textContent = pct;
            
            // Actualizar ancho de barra
            const bar = document.getElementById(`bar-${c}`);
            if (bar) bar.style.width = pct + '%';
        });

        // Actualizar palabras y lectura
        if (stats.words) {
            const wordsEl = document.querySelector('span[data-stat="words"]');
            if (wordsEl) wordsEl.textContent = stats.words;
        }
        if (stats.reading_time) {
            const rtEl = document.querySelector('span[data-stat="reading_time"]');
            if (rtEl) rtEl.textContent = stats.reading_time + ' min';
        }
    };
    document.addEventListener('ajaxFilterUpdated', window.handleAjaxStatsUpdate);
}

// Cargar tanto para MPA como Turbo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPostsModule);
} else {
    initPostsModule();
}
document.addEventListener('turbo:load', initPostsModule);

// Cargar tanto para MPA como Turbo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPostsModule);
} else {
    initPostsModule();
}
document.addEventListener('turbo:load', initPostsModule);
</script>
@endpush

@endsection
