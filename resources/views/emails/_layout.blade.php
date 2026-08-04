{{--
    ═══════════════════════════════════════════════════════════════
    LAYOUT BASE DE CORREOS — CreativeUP Studio
    Uso: @include('emails._layout', ['slot' => $slot, ...])
    ═══════════════════════════════════════════════════════════════
--}}
<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $emailTitle ?? 'CreativeUP Studio' }}</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td { font-family: Arial, Helvetica, sans-serif !important; }
    </style>
    <![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        body { margin: 0; padding: 0; background-color: #f0f2f8; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; }
        a { color: inherit; }
        img { border: 0; display: block; }
        @media only screen and (max-width: 640px) {
            .email-wrapper { padding: 20px 12px !important; }
            .email-card { border-radius: 16px !important; }
            .email-body { padding: 32px 24px !important; }
            .email-header { padding: 32px 24px 24px !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f0f2f8; font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">

{{-- Outer Wrapper --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="email-wrapper" style="background-color:#f0f2f8; padding:48px 20px;">
<tr><td align="center">

{{-- Email Card Container --}}
<table width="600" cellpadding="0" cellspacing="0" border="0" class="email-card" style="max-width:600px; width:100%; background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.10);">

    {{-- ══ HEADER ══════════════════════════════════════ --}}
    <tr>
        <td class="email-header" style="background:linear-gradient(135deg, #ff006e 0%, #8338ec 60%, #3a0ca3 100%); padding:40px 48px 32px; text-align:center; position:relative; overflow:hidden;">

            {{-- Decorative circle (top right) --}}
            <div style="position:absolute; top:-60px; right:-60px; width:200px; height:200px; background:rgba(255,255,255,0.06); border-radius:50%;"></div>
            <div style="position:absolute; top:-20px; right:20px; width:80px; height:80px; background:rgba(255,255,255,0.06); border-radius:50%;"></div>

            {{-- ─ LOGO (texto tipográfico, al igual que la web) ─ --}}
            <div style="margin-bottom:18px; display:inline-block;">
                <span style="font-size:30px; font-weight:300; color:#ffffff; letter-spacing:2px; font-family:'Inter',Arial,sans-serif;">creative</span><span style="font-size:30px; font-weight:900; color:#ffffff; letter-spacing:2px; font-family:'Inter',Arial,sans-serif;">UP</span><span style="display:inline-block; width:8px; height:8px; background:#ff006e; border-radius:50%; margin-left:3px; vertical-align:super; box-shadow:0 0 10px rgba(255,0,110,0.8);"></span>
                <div style="font-size:10px; font-weight:600; color:rgba(255,255,255,0.55); letter-spacing:4px; text-transform:uppercase; margin-top:4px;">S T U D I O</div>
            </div>

            {{-- ─ Badge de contexto del email ─ --}}
            <div style="margin-top:4px;">
                <span style="display:inline-block; background:rgba(255,255,255,0.18); border:1px solid rgba(255,255,255,0.3); border-radius:50px; padding:7px 20px; font-size:13px; font-weight:600; color:#ffffff; letter-spacing:0.3px;">
                    {{ $emailBadge ?? '✉️ Mensaje de CreativeUP' }}
                </span>
            </div>
        </td>
    </tr>

    {{-- ══ BODY CONTENT ══════════════════════════════════ --}}
    <tr>
        <td class="email-body" style="padding:44px 48px; background:#ffffff;">
            {{ $slot }}
        </td>
    </tr>

    {{-- ══ DIVIDER ════════════════════════════════════════ --}}
    <tr>
        <td style="padding:0 48px;">
            <div style="height:1px; background:linear-gradient(90deg, transparent, #e5e7eb, transparent);"></div>
        </td>
    </tr>

    {{-- ══ FOOTER ═════════════════════════════════════════ --}}
    <tr>
        <td style="padding:28px 48px 36px; text-align:center; background:#fafafa;">
            {{-- Social Links --}}
            <div style="margin-bottom:18px;">
                @if(!empty($social_ig))
                <a href="{{ $social_ig }}" style="display:inline-block; margin:0 6px; width:34px; height:34px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:8px; text-align:center; line-height:34px; font-size:15px; text-decoration:none; color:#fff;">in</a>
                @endif
                <a href="{{ url('/') }}" style="display:inline-block; margin:0 6px; width:34px; height:34px; background:linear-gradient(135deg,#ff006e,#8338ec); border-radius:8px; text-align:center; line-height:34px; text-decoration:none;">
                    <span style="font-size:12px; font-weight:900; color:#fff; font-family:Arial;">C</span>
                </a>
            </div>

            <p style="color:#9ca3af; font-size:12px; margin:0 0 4px 0; font-family:'Inter',Arial,sans-serif;">
                © {{ date('Y') }} <strong style="color:#6b7280;">CreativeUP Studio</strong>. Todos los derechos reservados.
            </p>
            <p style="color:#c4c9d4; font-size:11px; margin:0 0 12px 0; font-family:'Inter',Arial,sans-serif;">
                {{ $footerNote ?? 'Correo enviado automáticamente desde creativeuP Studio.' }}
            </p>
            <a href="{{ url('/') }}" style="color:#d1d5db; font-size:11px; text-decoration:underline; font-family:'Inter',Arial,sans-serif;">
                studiocreativeup.com
            </a>
        </td>
    </tr>

</table>
{{-- /Email Card --}}

</td></tr>
</table>
{{-- /Outer Wrapper --}}

</body>
</html>
