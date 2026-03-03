<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copia de respuesta enviada</title>
</head>
<body style="margin:0; padding:0; background-color:#09090b; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#09090b; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:24px 40px; text-align:center; background:#131318; border-radius:16px 16px 0 0; border:1px solid rgba(94,23,235,0.15); border-bottom:none;">
                            <span style="font-size:12px; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:2px; font-weight:600;">📋 Copia de respuesta enviada</span>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#131318; padding:30px 40px; border-left:1px solid rgba(94,23,235,0.15); border-right:1px solid rgba(94,23,235,0.15);">
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                                <tr>
                                    <td style="padding:8px 0;">
                                        <span style="color:rgba(255,255,255,0.4); font-size:12px;">Lead:</span>
                                        <span style="color:#fff; font-size:14px; font-weight:600; margin-left:8px;">{{ $lead->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">
                                        <span style="color:rgba(255,255,255,0.4); font-size:12px;">Email destino:</span>
                                        <span style="color:#7c6ef0; font-size:14px; margin-left:8px;">{{ $lead->email }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">
                                        <span style="color:rgba(255,255,255,0.4); font-size:12px;">Respondido por:</span>
                                        <span style="color:#fff; font-size:14px; margin-left:8px;">{{ $reply->user->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">
                                        <span style="color:rgba(255,255,255,0.4); font-size:12px;">Fecha:</span>
                                        <span style="color:rgba(255,255,255,0.6); font-size:14px; margin-left:8px;">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                </tr>
                            </table>

                            <div style="background:rgba(94,23,235,0.08); border:1px solid rgba(94,23,235,0.15); border-radius:12px; padding:16px; margin-bottom:16px;">
                                <p style="color:rgba(255,255,255,0.4); font-size:11px; text-transform:uppercase; letter-spacing:1px; margin:0 0 6px 0;">Consulta original</p>
                                <p style="color:rgba(255,255,255,0.65); font-size:13px; line-height:1.5; margin:0;">{{ $lead->message }}</p>
                            </div>

                            <div style="background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2); border-radius:12px; padding:16px;">
                                <p style="color:rgba(52,211,153,0.6); font-size:11px; text-transform:uppercase; letter-spacing:1px; margin:0 0 6px 0;">Respuesta enviada</p>
                                <p style="color:#fff; font-size:14px; line-height:1.6; margin:0;">{!! nl2br(e($reply->message)) !!}</p>
                            </div>
                        </td>
                    </tr>
                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#0a0a0e; padding:16px 40px; text-align:center; border-radius:0 0 16px 16px; border:1px solid rgba(94,23,235,0.1); border-top:none;">
                            <p style="color:rgba(255,255,255,0.25); font-size:11px; margin:0;">
                                Copia automática generada por CreativeUP CRM
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
