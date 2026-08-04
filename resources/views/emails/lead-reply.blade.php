@php
    $emailTitle = 'Respuesta de CreativeUP Studio';
    $emailBadge = '✉️ Respuesta a tu consulta';
    $footerNote = 'Recibiste este correo porque contactaste a nuestro equipo. Si no solicitaste esta información, ignora este mensaje.';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    {{-- Greeting --}}
    <h1 style="color:#111827; font-size:26px; font-weight:800; margin:0 0 12px 0; line-height:1.25; font-family:'Inter',Arial,sans-serif;">
        ¡Hola, {{ explode(' ', $lead->name)[0] }}! 👋
    </h1>
    <p style="color:#6b7280; font-size:15px; line-height:1.65; margin:0 0 32px 0; font-family:'Inter',Arial,sans-serif;">
        Gracias por contactar a <strong style="color:#111827;">CreativeUP Studio</strong>. Hemos revisado tu consulta y queremos compartirte nuestra respuesta.
    </p>

    {{-- Original Message --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td style="background:#f9fafb; border-left:4px solid #e5e7eb; border-radius:0 12px 12px 0; padding:20px 24px;">
                <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px;">
                    <tr>
                        <td style="vertical-align:middle;">
                            <div style="width:28px; height:28px; background:linear-gradient(135deg,rgba(255,0,110,0.12),rgba(131,56,236,0.12)); border-radius:8px; text-align:center; line-height:28px; display:inline-block; vertical-align:middle; margin-right:10px; font-size:14px;">💬</div>
                            <span style="color:#9ca3af; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px; vertical-align:middle; font-family:'Inter',Arial,sans-serif;">Tu mensaje original</span>
                        </td>
                    </tr>
                </table>
                <p style="color:#4b5563; font-size:15px; line-height:1.7; margin:0; font-style:italic; font-family:'Inter',Arial,sans-serif;">
                    "{{ $lead->message }}"
                </p>
                @if($lead->service)
                <div style="margin-top:14px; padding-top:14px; border-top:1px solid #e5e7eb;">
                    <span style="color:#9ca3af; font-size:12px; font-weight:600; font-family:'Inter',Arial,sans-serif;">Servicio de interés:</span>
                    <span style="color:#6b7280; font-size:13px; font-weight:600; background:#ffffff; padding:4px 10px; border-radius:6px; margin-left:8px; border:1px solid #e5e7eb; font-family:'Inter',Arial,sans-serif;">{{ $lead->service->title }}</span>
                </div>
                @endif
            </td>
        </tr>
    </table>

    {{-- Response Card --}}
    <div style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); border:2px solid rgba(255,0,110,0.15); border-radius:16px; padding:28px; margin-bottom:32px;">
        {{-- Label --}}
        <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:16px;">
            <tr>
                <td style="vertical-align:middle;">
                    <div style="width:36px; height:36px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:10px; text-align:center; line-height:36px; display:inline-block; vertical-align:middle; margin-right:10px; font-size:18px;">✨</div>
                    <span style="color:#ff006e; font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:1px; vertical-align:middle; font-family:'Inter',Arial,sans-serif;">Nuestra respuesta</span>
                </td>
            </tr>
        </table>

        {{-- Reply content --}}
        <div style="color:#1f2937; font-size:16px; line-height:1.8; margin:0 0 24px 0; font-family:'Inter',Arial,sans-serif;">
            {!! nl2br(e($reply->message)) !!}
        </div>

        {{-- Author --}}
        <div style="padding-top:20px; border-top:1px solid rgba(255,0,110,0.1);">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="vertical-align:middle;">
                        <div style="width:44px; height:44px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:50%; text-align:center; line-height:44px; display:inline-block; vertical-align:middle; margin-right:12px;">
                            <span style="color:#ffffff; font-size:18px; font-weight:800; font-family:'Inter',Arial,sans-serif;">{{ strtoupper(substr($reply->user->name, 0, 1)) }}</span>
                        </div>
                    </td>
                    <td style="vertical-align:middle;">
                        <div style="color:#111827; font-size:15px; font-weight:700; font-family:'Inter',Arial,sans-serif;">{{ $reply->user->name }}</div>
                        <div style="color:#6b7280; font-size:13px; font-family:'Inter',Arial,sans-serif;">Equipo CreativeUP Studio</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- CTA Section --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f9fafb; border-radius:14px; margin-bottom:24px;">
        <tr>
            <td align="center" style="padding:28px 24px;">
                <p style="color:#4b5563; font-size:15px; line-height:1.6; margin:0 0 20px 0; text-align:center; font-family:'Inter',Arial,sans-serif;">
                    ¿Tienes más preguntas? Estamos aquí para ayudarte 🙌
                </p>
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="border-radius:12px; overflow:hidden;">
                            <a href="mailto:{{ config('mail.from.address') }}" style="display:block; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; padding:14px 32px; border-radius:12px; text-align:center; font-family:'Inter',Arial,sans-serif;">
                                📧 Responder este correo
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Tip --}}
    <div style="background:#fff7ed; border-left:3px solid #f97316; border-radius:0 10px 10px 0; padding:16px;">
        <p style="color:#9a3412; font-size:13px; line-height:1.6; margin:0; font-family:'Inter',Arial,sans-serif;">
            <strong>💡 Consejo:</strong> Puedes responder directamente a este correo. Tu mensaje llegará a nuestro equipo y te responderemos lo antes posible.
        </p>
    </div>

@endcomponent
