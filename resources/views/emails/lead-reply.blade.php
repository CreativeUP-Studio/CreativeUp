<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta de CreativeUP</title>
</head>
<body style="margin:0; padding:0; background-color:#09090b; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#09090b; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:30px 40px; text-align:center; background:linear-gradient(135deg,#5e17eb,#ff00cc); border-radius:16px 16px 0 0;">
                            <span style="font-size:28px; font-weight:800; color:#fff; letter-spacing:2px;">creative</span><span style="font-size:28px; font-weight:800; color:#fff; background:rgba(255,255,255,0.2); padding:2px 8px; border-radius:6px; margin-left:4px; letter-spacing:2px;">up</span>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#131318; padding:40px; border-left:1px solid rgba(94,23,235,0.15); border-right:1px solid rgba(94,23,235,0.15);">
                            <h1 style="color:#fff; font-size:22px; margin:0 0 8px 0; font-weight:700;">¡Hola, {{ $lead->name }}! 👋</h1>
                            <p style="color:rgba(255,255,255,0.6); font-size:14px; margin:0 0 28px 0; line-height:1.5;">
                                Hemos respondido a tu consulta. Aquí tienes los detalles:
                            </p>

                            {{-- Mensaje original --}}
                            <div style="background:rgba(94,23,235,0.08); border:1px solid rgba(94,23,235,0.15); border-radius:12px; padding:20px; margin-bottom:24px;">
                                <p style="color:rgba(255,255,255,0.4); font-size:12px; text-transform:uppercase; letter-spacing:1px; margin:0 0 8px 0; font-weight:600;">Tu mensaje</p>
                                <p style="color:rgba(255,255,255,0.75); font-size:14px; line-height:1.6; margin:0;">{{ $lead->message }}</p>
                            </div>

                            {{-- Respuesta --}}
                            <div style="background:linear-gradient(135deg,rgba(94,23,235,0.15),rgba(255,0,204,0.08)); border:1px solid rgba(94,23,235,0.25); border-radius:12px; padding:20px; margin-bottom:24px;">
                                <p style="color:rgba(255,255,255,0.4); font-size:12px; text-transform:uppercase; letter-spacing:1px; margin:0 0 8px 0; font-weight:600;">Nuestra respuesta</p>
                                <p style="color:#fff; font-size:15px; line-height:1.7; margin:0;">{!! nl2br(e($reply->message)) !!}</p>
                                <p style="color:rgba(255,255,255,0.35); font-size:12px; margin:16px 0 0 0;">
                                    — {{ $reply->user->name }}, Equipo CreativeUP
                                </p>
                            </div>

                            <p style="color:rgba(255,255,255,0.5); font-size:13px; line-height:1.6; margin:0;">
                                Si tienes más preguntas, puedes responder directamente a este correo o visitarnos en nuestro sitio web.
                            </p>
                        </td>
                    </tr>
                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#0a0a0e; padding:24px 40px; text-align:center; border-radius:0 0 16px 16px; border:1px solid rgba(94,23,235,0.1); border-top:none;">
                            <p style="color:rgba(255,255,255,0.3); font-size:12px; margin:0 0 8px 0;">
                                © {{ date('Y') }} CreativeUP. Todos los derechos reservados.
                            </p>
                            <p style="color:rgba(255,255,255,0.2); font-size:11px; margin:0;">
                                Este correo fue enviado porque contactaste a nuestro equipo.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
