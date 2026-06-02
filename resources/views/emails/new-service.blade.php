<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Servicio - CreativeUP</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f8; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f8; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:28px 40px; text-align:center; background:linear-gradient(135deg,{{ $service->color ?? '#5e17eb' }},#ff00cc); border-radius:16px 16px 0 0;">
                            <span style="font-size:26px; font-weight:300; color:#fff; letter-spacing:1px;">creative</span><span style="font-size:26px; font-weight:800; color:#fff; letter-spacing:1px;">up</span>
                            <p style="color:rgba(255,255,255,0.8); font-size:13px; margin:8px 0 0; font-weight:500;">✨ ¡Ampliamos nuestras soluciones para ti!</p>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 40px; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                            <h1 style="color:#1a1a2e; font-size:22px; margin:0 0 8px 0; font-weight:700;">
                                {{ $service->title }}
                            </h1>
                            <div style="width:50px; height:4px; background-color:{{ $service->color ?? '#5e17eb' }}; border-radius:2px; margin-bottom:24px;"></div>
                            
                            <p style="color:#6b7280; font-size:15px; margin:0 0 24px 0; line-height:1.6;">
                                {{ $service->short_description ?? 'Tenemos el agrado de presentarte nuestro nuevo servicio especializado, diseñado para potenciar tu marca e impulsar tus resultados digitales.' }}
                            </p>

                            @if($service->image)
                            <div style="margin-bottom:24px; text-align:center; border-radius:12px; overflow:hidden;">
                                <img src="{{ url('storage/' . $service->image) }}" alt="{{ $service->title }}" style="max-width:100%; height:auto; border-radius:12px; border:1px solid #e5e5ef;" />
                            </div>
                            @endif

                            @if($service->features && count($service->features) > 0)
                            <div style="background:rgba(94,23,235,0.03); border-radius:12px; padding:24px; margin-bottom:28px;">
                                <h3 style="color:#1a1a2e; font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin:0 0 16px 0;">
                                    ¿Qué incluye este servicio?
                                </h3>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    @foreach($service->features as $feature)
                                    <tr>
                                        <td width="24" valign="top" style="padding-bottom:10px; color:{{ $service->color ?? '#5e17eb' }}; font-size:16px; font-weight:bold;">✓</td>
                                        <td style="padding-bottom:10px; color:#4b5563; font-size:14px; line-height:1.4;">{{ $feature }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            @endif

                            {{-- CTA --}}
                            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background:linear-gradient(135deg,{{ $service->color ?? '#5e17eb' }},#ff00cc); border-radius:8px; padding:12px 28px;">
                                        <a href="{{ url('/services/' . $service->slug) }}" style="color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; display:inline-block;">
                                            Ver detalles del servicio →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#f0f0f5; padding:20px 40px; text-align:center; border-radius:0 0 16px 16px; border:1px solid #e5e5ef; border-top:none;">
                            <p style="color:#9ca3af; font-size:12px; margin:0 0 4px 0;">
                                © {{ date('Y') }} CreativeUP. Todos los derechos reservados.
                            </p>
                            <p style="color:#c0c0c0; font-size:11px; margin:0;">
                                Recibiste este correo porque estás suscrito al boletín de CreativeUP.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
