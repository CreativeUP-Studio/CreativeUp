<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Te has suscrito al boletín de CreativeUP! 🎉</title>
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
                            <p style="color:rgba(255,255,255,0.8); font-size:13px; margin:8px 0 0; font-weight:500;">✨ ¡Suscripción Confirmada!</p>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 40px; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                            <h1 style="color:#1a1a2e; font-size:22px; margin:0 0 16px 0; font-weight:700; line-height:1.3; text-align:center;">
                                ¡Hola! Te damos la bienvenida a CreativeUP
                            </h1>
                            
                            <p style="color:#4b5563; font-size:15px; margin:0 0 20px 0; line-height:1.6; text-align:center;">
                                Gracias por suscribirte a nuestro boletín. Estamos muy emocionados de tenerte con nosotros.
                            </p>

                            <div style="background:rgba(94,23,235,0.04); border:1px solid rgba(94,23,235,0.12); border-radius:10px; padding:24px; margin-bottom:28px;">
                                <h3 style="color:#5e17eb; font-size:16px; margin:0 0 10px 0; font-weight:700;">¿Qué puedes esperar de nosotros?</h3>
                                <ul style="color:#4b5563; font-size:14px; line-height:1.6; margin:0; padding-left:20px;">
                                    <li style="margin-bottom:8px;">💡 <strong>Tendencias e Insights:</strong> Artículos sobre diseño UI/UX, desarrollo de software y marketing digital.</li>
                                    <li style="margin-bottom:8px;">🚀 <strong>Casos de Éxito:</strong> Nuevos proyectos y portafolios que lanzamos al mercado.</li>
                                    <li style="margin-bottom:8px;">✨ <strong>Nuevos Servicios:</strong> Lanzamientos y mejoras en nuestras ofertas de servicios.</li>
                                    <li>🎁 <strong>Contenido Exclusivo:</strong> Recursos gratuitos, guías y consejos directos de nuestro equipo.</li>
                                </ul>
                            </div>

                            <p style="color:#4b5563; font-size:15px; margin:0 0 28px 0; line-height:1.6; text-align:center;">
                                Mantente atento a tu bandeja de entrada. ¡Te enviaremos novedades increíbles muy pronto!
                            </p>

                            {{-- CTA --}}
                            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#5e17eb,#ff00cc); border-radius:8px; padding:12px 28px;">
                                        <a href="{{ url('/') }}" style="color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; display:inline-block;">
                                            Visitar nuestro sitio web →
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
                                Recibiste este correo porque te suscribiste a nuestro boletín en el sitio web de CreativeUP.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
