@php
    $emailTitle = 'Nuevo Servicio – CreativeUP Studio';
    $emailBadge = '✨ ¡Ampliamos nuestras soluciones!';
    $footerNote = 'Recibiste este correo porque estás suscrito al boletín de CreativeUP.';
    $serviceColor = $service->color ?? '#ff006e';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    {{-- Service Icon + Title --}}
    @if($service->icon)
    <div style="margin-bottom:16px;">
        <div style="width:56px; height:56px; background:linear-gradient(135deg,{{ $serviceColor }},#8338ec); border-radius:16px; display:inline-flex; align-items:center; justify-content:center; text-align:center; line-height:56px;">
            <span style="font-size:24px; color:#ffffff;">{{ $service->icon }}</span>
        </div>
    </div>
    @endif

    <h1 style="color:#111827; font-size:24px; font-weight:800; margin:0 0 8px 0; line-height:1.3; font-family:'Inter',Arial,sans-serif;">
        {{ $service->title }}
    </h1>
    <div style="width:48px; height:4px; background:linear-gradient(90deg,#ff006e,#8338ec); border-radius:2px; margin-bottom:20px;"></div>

    <p style="color:#6b7280; font-size:15px; margin:0 0 28px 0; line-height:1.65; font-family:'Inter',Arial,sans-serif;">
        {{ $service->short_description ?? 'Tenemos el agrado de presentarte nuestro nuevo servicio especializado, diseñado para potenciar tu marca e impulsar tus resultados digitales.' }}
    </p>

    {{-- Image --}}
    @if($service->image)
    <div style="margin-bottom:24px; border-radius:14px; overflow:hidden; border:1px solid #f0f0f5;">
        <img src="{{ url('storage/' . $service->image) }}" alt="{{ $service->title }}" style="max-width:100%; height:auto; display:block;" />
    </div>
    @endif

    {{-- Features List --}}
    @if($service->features && count($service->features) > 0)
    <div style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); border:1.5px solid rgba(131,56,236,0.15); border-radius:14px; padding:24px; margin-bottom:36px;">
        <p style="margin:0 0 16px 0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#8338ec; font-family:'Inter',Arial,sans-serif;">¿Qué incluye este servicio?</p>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            @foreach($service->features as $feature)
            <tr>
                <td width="28" style="vertical-align:top; padding-bottom:10px; padding-top:2px;">
                    <div style="width:20px; height:20px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:6px; text-align:center; line-height:20px; font-size:11px; color:#ffffff; font-weight:700;">✓</div>
                </td>
                <td style="padding-bottom:10px; color:#374151; font-size:14px; line-height:1.5; font-family:'Inter',Arial,sans-serif;">{{ $feature }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    {{-- CTA --}}
    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
        <tr>
            <td style="border-radius:12px; overflow:hidden;">
                <a href="{{ url('/services/' . $service->slug) }}" style="display:block; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; padding:15px 36px; border-radius:12px; text-align:center; letter-spacing:0.3px; font-family:'Inter',Arial,sans-serif;">
                    Ver detalles del servicio →
                </a>
            </td>
        </tr>
    </table>

@endcomponent
