<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Respuesta de CreativeUP</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, Helvetica, sans-serif !important;}
    </style>
    <![endif]-->
</head>
<body style="margin:0; padding:0; background-color:#f8f9fb; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
    <!-- Wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8f9fb; padding:40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,0.08);">
                    
                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #ff006e 0%, #8338ec 100%); padding:0; position:relative;">
                            <!-- Decorative Pattern -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding:40px 40px 30px; text-align:center; position:relative;">
                                        <!-- Logo -->
                                        <div style="margin-bottom:16px;">
                                            <span style="font-size:32px; font-weight:900; color:#ffffff; letter-spacing:1px; text-transform:lowercase;">creative</span><span style="font-size:32px; font-weight:900; color:#ffffff; background:rgba(255,255,255,0.25); padding:4px 12px; border-radius:8px; margin-left:6px; letter-spacing:1px; text-transform:lowercase;">up</span>
                                        </div>
                                        <!-- Badge -->
                                        <div style="display:inline-block; background:rgba(255,255,255,0.2); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.3); border-radius:100px; padding:8px 20px;">
                                            <span style="color:#ffffff; font-size:13px; font-weight:600; letter-spacing:0.5px;">✉️ Respuesta a tu consulta</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding:50px 40px;">
                            <!-- Greeting -->
                            <h1 style="color:#111827; font-size:28px; font-weight:800; margin:0 0 12px 0; line-height:1.2;">
                                ¡Hola, {{ explode(' ', $lead->name)[0] }}! 👋
                            </h1>
                            <p style="color:#6b7280; font-size:16px; line-height:1.6; margin:0 0 32px 0;">
                                Gracias por contactarnos. Hemos revisado tu mensaje y queremos compartir nuestra respuesta contigo.
                            </p>

                            <!-- Original Message Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="background:#f9fafb; border-left:4px solid #e5e7eb; border-radius:12px; padding:24px;">
                                        <div style="display:flex; align-items:center; margin-bottom:12px;">
                                            <div style="width:32px; height:32px; background:linear-gradient(135deg, rgba(255,0,110,0.1) 0%, rgba(131,56,236,0.1) 100%); border-radius:8px; display:inline-flex; align-items:center; justify-content:center; margin-right:12px; vertical-align:middle;">
                                                <span style="font-size:16px;">💬</span>
                                            </div>
                                            <span style="color:#9ca3af; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Tu mensaje original</span>
                                        </div>
                                        <p style="color:#4b5563; font-size:15px; line-height:1.7; margin:0; font-style:italic;">
                                            "{{ $lead->message }}"
                                        </p>
                                        @if($lead->service)
                                        <div style="margin-top:16px; padding-top:16px; border-top:1px solid #e5e7eb;">
                                            <span style="color:#9ca3af; font-size:12px; font-weight:600;">Servicio de interés:</span>
                                            <span style="color:#6b7280; font-size:13px; font-weight:600; background:#ffffff; padding:4px 10px; border-radius:6px; margin-left:8px;">{{ $lead->service->title }}</span>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Response Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                <tr>
                                    <td style="background:linear-gradient(135deg, rgba(255,0,110,0.05) 0%, rgba(131,56,236,0.05) 100%); border:2px solid rgba(255,0,110,0.15); border-radius:16px; padding:28px;">
                                        <div style="display:flex; align-items:center; margin-bottom:16px;">
                                            <div style="width:40px; height:40px; background:linear-gradient(135deg, #ff006e 0%, #8338ec 100%); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; margin-right:12px; vertical-align:middle;">
                                                <span style="font-size:20px;">✨</span>
                                            </div>
                                            <span style="color:#ff006e; font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Nuestra respuesta</span>
                                        </div>
                                        <div style="color:#1f2937; font-size:16px; line-height:1.8; margin:0 0 20px 0;">
                                            {!! nl2br(e($reply->message)) !!}
                                        </div>
                                        <!-- Author -->
                                        <div style="display:flex; align-items:center; padding-top:20px; border-top:1px solid rgba(255,0,110,0.1);">
                                            <div style="width:44px; height:44px; background:linear-gradient(135deg, #ff006e 0%, #8338ec 100%); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-right:12px; vertical-align:middle;">
                                                <span style="color:#ffffff; font-size:18px; font-weight:700;">{{ strtoupper(substr($reply->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div style="display:inline-block; vertical-align:middle;">
                                                <div style="color:#111827; font-size:15px; font-weight:700; margin:0;">{{ $reply->user->name }}</div>
                                                <div style="color:#6b7280; font-size:13px; margin:2px 0 0 0;">Equipo CreativeUP</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Section -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f9fafb; border-radius:12px; padding:28px; margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <p style="color:#4b5563; font-size:15px; line-height:1.6; margin:0 0 20px 0; text-align:center;">
                                            ¿Tienes más preguntas? Estamos aquí para ayudarte
                                        </p>
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="border-radius:10px; background:linear-gradient(135deg, #ff006e 0%, #8338ec 100%); padding:0;">
                                                    <a href="mailto:{{ config('mail.from.address') }}" style="display:inline-block; padding:14px 32px; color:#ffffff; text-decoration:none; font-size:15px; font-weight:700; border-radius:10px;">
                                                        📧 Responder este correo
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background:#fef3f2; border-left:3px solid #f97316; border-radius:8px; padding:16px;">
                                        <p style="color:#9a3412; font-size:13px; line-height:1.6; margin:0;">
                                            <strong style="font-weight:700;">💡 Consejo:</strong> Puedes responder directamente a este correo. Tu mensaje llegará a nuestro equipo y te responderemos lo antes posible.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#111827; padding:40px; text-align:center;">
                            <!-- Social Links -->
                            <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin-bottom:24px;">
                                <tr>
                                    <td style="padding:0 8px;">
                                        <a href="{{ config('app.url') }}" style="display:inline-block; width:40px; height:40px; background:rgba(255,255,255,0.1); border-radius:50%; text-align:center; line-height:40px; text-decoration:none; transition:all 0.3s;">
                                            <span style="color:#ffffff; font-size:16px;">🌐</span>
                                        </a>
                                    </td>
                                    <td style="padding:0 8px;">
                                        <a href="#" style="display:inline-block; width:40px; height:40px; background:rgba(255,255,255,0.1); border-radius:50%; text-align:center; line-height:40px; text-decoration:none;">
                                            <span style="color:#ffffff; font-size:16px;">📱</span>
                                        </a>
                                    </td>
                                    <td style="padding:0 8px;">
                                        <a href="#" style="display:inline-block; width:40px; height:40px; background:rgba(255,255,255,0.1); border-radius:50%; text-align:center; line-height:40px; text-decoration:none;">
                                            <span style="color:#ffffff; font-size:16px;">💼</span>
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer Text -->
                            <p style="color:rgba(255,255,255,0.6); font-size:14px; line-height:1.6; margin:0 0 8px 0;">
                                <strong style="color:#ffffff; font-weight:700;">CreativeUP</strong> - Transformando ideas en realidad digital
                            </p>
                            <p style="color:rgba(255,255,255,0.4); font-size:12px; margin:0 0 16px 0;">
                                © {{ date('Y') }} CreativeUP. Todos los derechos reservados.
                            </p>
                            <p style="color:rgba(255,255,255,0.3); font-size:11px; line-height:1.5; margin:0;">
                                Recibiste este correo porque contactaste a nuestro equipo.<br>
                                Si no solicitaste esta información, puedes ignorar este mensaje.
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Spacer -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%; margin-top:20px;">
                    <tr>
                        <td align="center" style="padding:0 20px;">
                            <p style="color:#9ca3af; font-size:11px; line-height:1.5; margin:0; text-align:center;">
                                Este es un correo automático, por favor no respondas a esta dirección.<br>
                                Para contactarnos, responde al correo o visita nuestro sitio web.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
