<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Caso de Éxito - CreativeUP</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f8; font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f8; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:28px 40px; text-align:center; background:linear-gradient(135deg,#ff00cc,#5e17eb); border-radius:16px 16px 0 0;">
                            <span style="font-size:26px; font-weight:300; color:#fff; letter-spacing:1px;">creative</span><span style="font-size:26px; font-weight:800; color:#fff; letter-spacing:1px;">up</span>
                            <p style="color:rgba(255,255,255,0.8); font-size:13px; margin:8px 0 0; font-weight:500;">🚀 ¡Nuevo proyecto publicado en nuestro portafolio!</p>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 40px; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                            <span style="display:inline-block; padding:4px 12px; background:rgba(94,23,235,0.08); color:#5e17eb; font-size:11px; font-weight:700; border-radius:20px; text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
                                {{ $project->type ?? 'Caso de Éxito' }}
                            </span>
                            
                            <h1 style="color:#1a1a2e; font-size:22px; margin:0 0 12px 0; font-weight:700; line-height:1.3;">
                                {{ $project->title }}
                            </h1>
                            
                            {{-- Info del Proyecto --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px; border:1px solid #e5e5ef; border-radius:10px; overflow:hidden;">
                                <tr>
                                    @if($project->client)
                                    <td style="padding:12px 16px; background:#f9f9fb; border-right:1px solid #e5e5ef;">
                                        <span style="color:#9ca3af; font-size:10px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Cliente</span><br>
                                        <span style="color:#1a1a2e; font-size:14px; font-weight:600;">{{ $project->client }}</span>
                                    </td>
                                    @endif
                                    @if($project->year)
                                    <td style="padding:12px 16px; background:#f9f9fb;">
                                        <span style="color:#9ca3af; font-size:10px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Año</span><br>
                                        <span style="color:#1a1a2e; font-size:14px; font-weight:600;">{{ $project->year }}</span>
                                    </td>
                                    @endif
                                </tr>
                            </table>

                            @if($project->thumbnail)
                            <div style="margin-bottom:24px; text-align:center; border-radius:12px; overflow:hidden;">
                                <img src="{{ url('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" style="max-width:100%; height:auto; border-radius:12px; border:1px solid #e5e5ef;" />
                            </div>
                            @endif

                            <p style="color:#6b7280; font-size:15px; margin:0 0 24px 0; line-height:1.6;">
                                {{ Str::limit(strip_tags($project->description), 180) }}
                            </p>

                            @if($project->technologies && count($project->technologies) > 0)
                            <div style="margin-bottom:28px;">
                                <span style="color:#9ca3af; font-size:10px; text-transform:uppercase; letter-spacing:1px; font-weight:600; display:block; margin-bottom:8px;">Tecnologías & herramientas</span>
                                @foreach($project->technologies as $tech)
                                <span style="display:inline-block; padding:4px 10px; background:#f3f4f6; color:#4b5563; font-size:12px; font-weight:500; border-radius:6px; margin:0 4px 6px 0;">
                                    {{ $tech }}
                                </span>
                                @endforeach
                            </div>
                            @endif

                            {{-- CTA --}}
                            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#ff00cc,#5e17eb); border-radius:8px; padding:12px 28px;">
                                        <a href="{{ url('/projects/' . $project->slug) }}" style="color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; display:inline-block;">
                                            Ver caso de estudio →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{-- Firma del remitente --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:0 40px 28px; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                            <table cellpadding="0" cellspacing="0" style="border-top:1px solid #f0f0f5; padding-top:20px; width:100%;">
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="vertical-align:middle; padding-right:12px;">
                                                    @if(isset($sender) && $sender->avatar)
                                                        <img src="{{ url(Storage::url($sender->avatar)) }}" alt="{{ $sender->name }}" width="48" height="48" style="width:48px; height:48px; border-radius:50%; object-fit:cover; display:block; border:2px solid rgba(255,0,204,0.3);">
                                                    @else
                                                        <div style="width:48px; height:48px; background:linear-gradient(135deg,#ff00cc,#5e17eb); border-radius:50%; text-align:center; line-height:48px;">
                                                            <span style="color:#fff; font-size:20px; font-weight:700;">{{ isset($sender) ? strtoupper(substr($sender->name,0,1)) : 'C' }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td style="vertical-align:middle;">
                                                    <div style="color:#1a1a2e; font-size:14px; font-weight:700;">{{ isset($sender) ? $sender->name : 'CreativeUP' }}</div>
                                                    <div style="color:#9ca3af; font-size:12px; margin-top:2px;">Equipo CreativeUP</div>
                                                </td>
                                            </tr>
                                        </table>
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
                                Recibiste este correo porque estás suscrito al boletín de CreativeUP.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
