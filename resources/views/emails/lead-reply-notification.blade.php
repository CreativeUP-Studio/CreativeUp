@php
    $emailTitle = 'Copia de respuesta enviada – CreativeUP Studio';
    $emailBadge = '📋 Copia de respuesta al Lead';
    $footerNote = 'Copia automática generada por el CRM de CreativeUP Studio.';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    <h1 style="color:#111827; font-size:20px; font-weight:800; margin:0 0 8px 0; font-family:'Inter',Arial,sans-serif;">
        Respuesta enviada correctamente ✅
    </h1>
    <p style="color:#6b7280; font-size:14px; line-height:1.6; margin:0 0 28px 0; font-family:'Inter',Arial,sans-serif;">
        Esta es una copia interna de la respuesta que fue enviada al lead.
    </p>

    {{-- Lead info --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1.5px solid #e5e7eb; border-radius:12px; overflow:hidden; margin-bottom:24px;">
        <tr>
            <td style="background:#fafafa; padding:14px 20px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Lead</p>
                <p style="margin:3px 0 0; font-size:14px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">{{ $lead->name }}</p>
            </td>
        </tr>
        <tr>
            <td style="background:#ffffff; padding:14px 20px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Email destino</p>
                <p style="margin:3px 0 0; font-size:14px; font-weight:600; color:#ff006e; font-family:'Inter',Arial,sans-serif;">{{ $lead->email }}</p>
            </td>
        </tr>
        <tr>
            <td style="background:#fafafa; padding:14px 20px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Respondido por</p>
                <p style="margin:3px 0 0; font-size:14px; font-weight:700; color:#1f2937; font-family:'Inter',Arial,sans-serif;">{{ $reply->user->name }}</p>
            </td>
        </tr>
        <tr>
            <td style="background:#ffffff; padding:14px 20px;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Fecha y Hora</p>
                <p style="margin:3px 0 0; font-size:13px; color:#6b7280; font-family:'Inter',Arial,sans-serif;">{{ $reply->created_at->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    {{-- Original query --}}
    <div style="background:#f9fafb; border-left:3px solid #e5e7eb; border-radius:8px; padding:20px; margin-bottom:16px;">
        <p style="margin:0 0 8px 0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">💬 Consulta original</p>
        <p style="color:#374151; font-size:14px; line-height:1.65; margin:0; font-family:'Inter',Arial,sans-serif;">{{ $lead->message }}</p>
    </div>

    {{-- Reply sent --}}
    <div style="background:linear-gradient(135deg,rgba(16,185,129,0.05),rgba(5,150,105,0.03)); border:1.5px solid rgba(16,185,129,0.25); border-radius:12px; padding:20px;">
        <p style="margin:0 0 8px 0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#10b981; font-family:'Inter',Arial,sans-serif;">✅ Respuesta enviada</p>
        <p style="color:#1f2937; font-size:14px; line-height:1.7; margin:0; font-family:'Inter',Arial,sans-serif;">{!! nl2br(e($reply->message)) !!}</p>
    </div>

@endcomponent
