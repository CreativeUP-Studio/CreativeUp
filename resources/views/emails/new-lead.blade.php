<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Lead - CreativeUP</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f8; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f8; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:28px 40px; text-align:center; background:linear-gradient(135deg,#5e17eb,#ff00cc); border-radius:16px 16px 0 0;">
                            <span style="font-size:26px; font-weight:300; color:#fff; letter-spacing:1px;">creative</span><span style="font-size:26px; font-weight:800; color:#fff; letter-spacing:1px;">up</span>
                            <p style="color:rgba(255,255,255,0.8); font-size:13px; margin:8px 0 0; font-weight:500;">🔔 Nueva solicitud de contacto</p>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 40px; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                            <h1 style="color:#1a1a2e; font-size:20px; margin:0 0 6px 0; font-weight:700;">Nuevo lead recibido</h1>
                            <p style="color:#6b7280; font-size:14px; margin:0 0 28px 0; line-height:1.5;">
                                Se ha recibido un nuevo mensaje desde el formulario de contacto.
                            </p>

                            {{-- Info del contacto --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="padding:12px 16px; background:#f9f9fb; border:1px solid #e5e5ef; border-radius:10px 10px 0 0; border-bottom:none;">
                                        <span style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Nombre</span><br>
                                        <span style="color:#1a1a2e; font-size:15px; font-weight:600;">{{ $lead->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px; background:#f9f9fb; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                                        <span style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Email</span><br>
                                        <a href="mailto:{{ $lead->email }}" style="color:#5e17eb; font-size:14px; text-decoration:none; font-weight:500;">{{ $lead->email }}</a>
                                    </td>
                                </tr>
                                @if($lead->phone)
                                <tr>
                                    <td style="padding:12px 16px; background:#f9f9fb; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                                        <span style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Teléfono</span><br>
                                        <span style="color:#1a1a2e; font-size:14px;">{{ $lead->phone }}</span>
                                    </td>
                                </tr>
                                @endif
                                @if($lead->service)
                                <tr>
                                    <td style="padding:12px 16px; background:#f9f9fb; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                                        <span style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Servicio de interés</span><br>
                                        <span style="color:#1a1a2e; font-size:14px; font-weight:500;">{{ $lead->service->title }}</span>
                                    </td>
                                </tr>
                                @endif
                                @if($lead->budget)
                                <tr>
                                    <td style="padding:12px 16px; background:#f9f9fb; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                                        <span style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Presupuesto estimado</span><br>
                                        <span style="color:#5e17eb; font-size:14px; font-weight:700;">{{ $lead->budget }}</span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:12px 16px; background:#f9f9fb; border:1px solid #e5e5ef; border-radius:0 0 10px 10px; border-top:none;">
                                        <span style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Fecha</span><br>
                                        <span style="color:#6b7280; font-size:13px;">{{ $lead->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                </tr>
                            </table>

                            {{-- Mensaje --}}
                            <div style="background:rgba(94,23,235,0.04); border:1px solid rgba(94,23,235,0.12); border-radius:10px; padding:20px; margin-bottom:28px;">
                                <p style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin:0 0 10px 0; font-weight:600;">Mensaje</p>
                                <p style="color:#1a1a2e; font-size:14px; line-height:1.7; margin:0;">{{ $lead->message }}</p>
                            </div>

                            {{-- CTA --}}
                            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#5e17eb,#ff00cc); border-radius:8px; padding:12px 28px;">
                                        <a href="{{ url('/admin/leads/' . $lead->id) }}" style="color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; display:inline-block;">
                                            Ver en panel admin →
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
                                Notificación automática del formulario de contacto.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
