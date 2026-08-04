@php
    $emailTitle = 'Nuevo artículo en el Blog – CreativeUP Studio';
    $emailBadge = '📢 Nueva publicación en el blog';
    $footerNote = 'Recibiste este correo porque estás suscrito al boletín de CreativeUP.';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    {{-- Category Tag --}}
    <div style="margin-bottom:20px;">
        <span style="display:inline-block; padding:5px 14px; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:11px; font-weight:700; border-radius:50px; text-transform:uppercase; letter-spacing:1px; font-family:'Inter',Arial,sans-serif;">
            {{ $post->category_label ?? 'Blog' }}
        </span>
    </div>

    {{-- Title --}}
    <h1 style="color:#111827; font-size:24px; font-weight:800; margin:0 0 12px 0; line-height:1.3; font-family:'Inter',Arial,sans-serif;">
        {{ $post->title }}
    </h1>

    {{-- Meta --}}
    <p style="color:#9ca3af; font-size:13px; margin:0 0 28px 0; font-family:'Inter',Arial,sans-serif;">
        ⏱️ {{ $post->read_time }} min de lectura &nbsp;·&nbsp;
        📅 {{ $post->published_at ? $post->published_at->format('d/m/Y') : now()->format('d/m/Y') }}
    </p>

    {{-- Featured Image --}}
    @if($post->featured_image)
    <div style="margin-bottom:28px; border-radius:14px; overflow:hidden; border:1px solid #f0f0f5;">
        <img src="{{ url('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="max-width:100%; height:auto; display:block;" />
    </div>
    @endif

    {{-- Excerpt --}}
    <div style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); border:1.5px solid rgba(131,56,236,0.15); border-radius:14px; padding:24px; margin-bottom:36px;">
        <p style="color:#1f2937; font-size:15px; line-height:1.75; margin:0; font-family:'Inter',Arial,sans-serif;">
            {{ $post->excerpt }}
        </p>
    </div>

    {{-- CTA --}}
    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
        <tr>
            <td style="border-radius:12px; overflow:hidden;">
                <a href="{{ url('/blog/' . $post->slug) }}" style="display:block; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; padding:15px 36px; border-radius:12px; text-align:center; letter-spacing:0.3px; font-family:'Inter',Arial,sans-serif;">
                    Leer artículo completo →
                </a>
            </td>
        </tr>
    </table>

@endcomponent
