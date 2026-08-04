@php
    $emailTitle = 'Nuevo Lead – CreativeUP Studio';
    $emailBadge = '🔔 Nueva solicitud de contacto';
    $footerNote = 'Notificación automática del formulario de contacto.';
@endphp

@component('emails._layout', compact('emailTitle','emailBadge','footerNote'))

    {{-- Greeting --}}
    <h1 style="color:#111827; font-size:24px; font-weight:800; margin:0 0 8px 0; line-height:1.25; font-family:'Inter',Arial,sans-serif;">
        Nuevo lead recibido 🎯
    </h1>
    <p style="color:#6b7280; font-size:15px; line-height:1.6; margin:0 0 32px 0; font-family:'Inter',Arial,sans-serif;">
        Se ha recibido un nuevo mensaje desde el formulario de contacto de <strong>CreativeUP Studio</strong>.
    </p>

    {{-- Contact Card --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1.5px solid #e5e7eb; border-radius:14px; overflow:hidden; margin-bottom:28px;">
        <tr>
            <td style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); padding:20px 24px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Nombre</p>
                <p style="margin:4px 0 0; font-size:16px; font-weight:700; color:#111827; font-family:'Inter',Arial,sans-serif;">{{ $lead->name }}</p>
            </td>
        </tr>
        <tr>
            <td style="background:#ffffff; padding:20px 24px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Correo Electrónico</p>
                <a href="mailto:{{ $lead->email }}" style="display:block; margin:4px 0 0; font-size:15px; font-weight:600; color:#ff006e; text-decoration:none; font-family:'Inter',Arial,sans-serif;">{{ $lead->email }}</a>
            </td>
        </tr>
        @if($lead->phone)
        <tr>
            <td style="background:linear-gradient(135deg,rgba(255,0,110,0.02),rgba(131,56,236,0.02)); padding:20px 24px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Teléfono</p>
                <p style="margin:4px 0 0; font-size:15px; font-weight:600; color:#374151; font-family:'Inter',Arial,sans-serif;">{{ $lead->phone }}</p>
            </td>
        </tr>
        @endif
        @if($lead->service)
        <tr>
            <td style="background:#ffffff; padding:20px 24px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Servicio de interés</p>
                <p style="margin:4px 0 0; font-size:15px; font-weight:600; color:#374151; font-family:'Inter',Arial,sans-serif;">{{ $lead->service->title }}</p>
            </td>
        </tr>
        @endif
        @if($lead->budget)
        <tr>
            <td style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); padding:20px 24px; border-bottom:1px solid #f0f0f5;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Presupuesto Estimado</p>
                <p style="margin:4px 0 0; font-size:16px; font-weight:800; background:linear-gradient(135deg,#ff006e,#8338ec); -webkit-background-clip:text; -webkit-text-fill-color:transparent; font-family:'Inter',Arial,sans-serif;">{{ $lead->budget }}</p>
            </td>
        </tr>
        @endif
        <tr>
            <td style="background:#f9fafb; padding:16px 24px;">
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-family:'Inter',Arial,sans-serif;">Fecha de Envío</p>
                <p style="margin:4px 0 0; font-size:13px; color:#6b7280; font-family:'Inter',Arial,sans-serif;">{{ $lead->created_at->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    {{-- Message Box --}}
    <div style="background:linear-gradient(135deg,rgba(255,0,110,0.04),rgba(131,56,236,0.04)); border:1.5px solid rgba(131,56,236,0.15); border-radius:14px; padding:24px; margin-bottom:36px;">
        <p style="margin:0 0 10px 0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#8338ec; font-family:'Inter',Arial,sans-serif;">💬 Mensaje del Cliente</p>
        <p style="color:#1f2937; font-size:15px; line-height:1.75; margin:0; font-family:'Inter',Arial,sans-serif;">{{ $lead->message }}</p>
    </div>

    {{-- CTA Button --}}
    <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
        <tr>
            <td style="border-radius:12px; overflow:hidden;">
                <a href="{{ url('/admin/leads/' . $lead->id) }}" style="display:block; background:linear-gradient(135deg,#ff006e,#8338ec); color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; padding:15px 36px; border-radius:12px; text-align:center; letter-spacing:0.3px; font-family:'Inter',Arial,sans-serif;">
                    Ver en el panel admin →
                </a>
            </td>
        </tr>
    </table>

@endcomponent
