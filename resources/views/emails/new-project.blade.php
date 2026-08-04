@php
    $emailTitle = 'Nuevo Proyecto – CreativeUP Studio';
    $emailBadge = '🚀 ¡Nuevo caso de éxito publicado!';
    $footerNote = 'Recibiste este correo porque estás suscrito al boletín de CreativeUP.';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    {{-- Type Tag --}}
    <div style="margin-bottom:20px;">
        <span style="display:inline-block; padding:5px 14px; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:11px; font-weight:700; border-radius:50px; text-transform:uppercase; letter-spacing:1px; font-family:'Inter',Arial,sans-serif;">
            {{ $project->type ?? 'Caso de Éxito' }}
        </span>
    </div>

    {{-- Title --}}
    <h1 style="color:#111827; font-size:24px; font-weight:800; margin:0 0 20px 0; line-height:1.3; font-family:'Inter',Arial,sans-serif;">
        {{ $project->title }}
    </h1>

    {{-- Project Meta Row --}}
    @if($project->client || $project->year)
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1.5px solid #e5e7eb; border-radius:12px; overflow:hidden; margin-bottom:24px;">
        <tr>
            @if($project->client)
            <td style="padding:16px 20px; background:#fafafa; border-right:1px solid #f0f0f5;">
                <p style="margin:0; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Cliente</p>
                <p style="margin:4px 0 0; font-size:15px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">{{ $project->client }}</p>
            </td>
            @endif
            @if($project->year)
            <td style="padding:16px 20px; background:#fafafa;">
                <p style="margin:0; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Año</p>
                <p style="margin:4px 0 0; font-size:15px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">{{ $project->year }}</p>
            </td>
            @endif
        </tr>
    </table>
    @endif

    {{-- Thumbnail --}}
    @if($project->thumbnail)
    <div style="margin-bottom:24px; border-radius:14px; overflow:hidden; border:1px solid #f0f0f5;">
        <img src="{{ url('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" style="max-width:100%; height:auto; display:block;" />
    </div>
    @endif

    {{-- Description --}}
    <div style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); border:1.5px solid rgba(131,56,236,0.15); border-radius:14px; padding:24px; margin-bottom:28px;">
        <p style="color:#1f2937; font-size:15px; line-height:1.75; margin:0; font-family:'Inter',Arial,sans-serif;">
            {{ Str::limit(strip_tags($project->description), 200) }}
        </p>
    </div>

    {{-- Technologies --}}
    @if($project->technologies && count($project->technologies) > 0)
    <div style="margin-bottom:36px;">
        <p style="margin:0 0 10px 0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#8338ec; font-family:'Inter',Arial,sans-serif;">Tecnologías & Herramientas</p>
        @foreach($project->technologies as $tech)
        <span style="display:inline-block; padding:5px 12px; background:#f3f4f6; color:#4b5563; font-size:12px; font-weight:600; border-radius:8px; margin:0 4px 6px 0; border:1px solid #e5e7eb; font-family:'Inter',Arial,sans-serif;">
            {{ $tech }}
        </span>
        @endforeach
    </div>
    @endif

    {{-- CTA --}}
    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
        <tr>
            <td style="border-radius:12px; overflow:hidden;">
                <a href="{{ url('/projects/' . $project->slug) }}" style="display:block; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; padding:15px 36px; border-radius:12px; text-align:center; letter-spacing:0.3px; font-family:'Inter',Arial,sans-serif;">
                    Ver caso de estudio →
                </a>
            </td>
        </tr>
    </table>

@endcomponent
