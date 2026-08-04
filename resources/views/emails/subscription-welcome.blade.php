@php
    $emailTitle = '¡Bienvenido al boletín de CreativeUP Studio!';
    $emailBadge = '✨ Suscripción Confirmada';
    $footerNote = 'Recibiste este correo porque te suscribiste al boletín de CreativeUP.';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    {{-- Greeting --}}
    <div style="text-align:center; margin-bottom:32px;">
        <h1 style="color:#111827; font-size:26px; font-weight:800; margin:0 0 12px 0; line-height:1.25; font-family:'Inter',Arial,sans-serif;">
            ¡Gracias por suscribirte! 🎉
        </h1>
        <p style="color:#6b7280; font-size:15px; line-height:1.65; margin:0; font-family:'Inter',Arial,sans-serif;">
            Nos da mucho gusto tenerte con nosotros. A partir de ahora recibirás lo mejor de <strong style="color:#111827;">CreativeUP Studio</strong> directamente en tu bandeja de entrada.
        </p>
    </div>

    {{-- What to expect --}}
    <div style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); border:1.5px solid rgba(131,56,236,0.15); border-radius:16px; padding:28px; margin-bottom:32px;">
        <p style="margin:0 0 16px 0; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#8338ec; font-family:'Inter',Arial,sans-serif;">¿Qué puedes esperar de nosotros?</p>

        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding:10px 0; border-bottom:1px solid rgba(131,56,236,0.1);">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="width:36px; vertical-align:top; padding-top:2px;">
                                <div style="width:28px; height:28px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:8px; text-align:center; line-height:28px; font-size:14px;">💡</div>
                            </td>
                            <td style="padding-left:12px; vertical-align:top;">
                                <p style="margin:0; font-size:14px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">Tendencias e Insights</p>
                                <p style="margin:2px 0 0; font-size:13px; color:#6b7280; font-family:'Inter',Arial,sans-serif;">Artículos sobre diseño UI/UX, desarrollo y marketing digital.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:10px 0; border-bottom:1px solid rgba(131,56,236,0.1);">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="width:36px; vertical-align:top; padding-top:2px;">
                                <div style="width:28px; height:28px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:8px; text-align:center; line-height:28px; font-size:14px;">🚀</div>
                            </td>
                            <td style="padding-left:12px; vertical-align:top;">
                                <p style="margin:0; font-size:14px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">Casos de Éxito</p>
                                <p style="margin:2px 0 0; font-size:13px; color:#6b7280; font-family:'Inter',Arial,sans-serif;">Nuevos proyectos y portafolios que lanzamos al mercado.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:10px 0; border-bottom:1px solid rgba(131,56,236,0.1);">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="width:36px; vertical-align:top; padding-top:2px;">
                                <div style="width:28px; height:28px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:8px; text-align:center; line-height:28px; font-size:14px;">✨</div>
                            </td>
                            <td style="padding-left:12px; vertical-align:top;">
                                <p style="margin:0; font-size:14px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">Nuevos Servicios</p>
                                <p style="margin:2px 0 0; font-size:13px; color:#6b7280; font-family:'Inter',Arial,sans-serif;">Lanzamientos y mejoras en nuestras ofertas de servicios.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:10px 0 0;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="width:36px; vertical-align:top; padding-top:2px;">
                                <div style="width:28px; height:28px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:8px; text-align:center; line-height:28px; font-size:14px;">🎁</div>
                            </td>
                            <td style="padding-left:12px; vertical-align:top;">
                                <p style="margin:0; font-size:14px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">Contenido Exclusivo</p>
                                <p style="margin:2px 0 0; font-size:13px; color:#6b7280; font-family:'Inter',Arial,sans-serif;">Recursos gratuitos, guías y consejos de nuestro equipo.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <p style="color:#6b7280; font-size:14px; line-height:1.6; margin:0 0 32px 0; text-align:center; font-family:'Inter',Arial,sans-serif;">
        Mantente atento a tu bandeja de entrada. ¡Te enviaremos novedades increíbles muy pronto! 🌟
    </p>

    {{-- CTA --}}
    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
        <tr>
            <td style="border-radius:12px; overflow:hidden;">
                <a href="{{ url('/') }}" style="display:block; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; padding:15px 36px; border-radius:12px; text-align:center; letter-spacing:0.3px; font-family:'Inter',Arial,sans-serif;">
                    Visitar nuestro sitio web →
                </a>
            </td>
        </tr>
    </table>

@endcomponent
