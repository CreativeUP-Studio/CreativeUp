<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo artículo en el Blog - CreativeUP</title>
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
                            <p style="color:rgba(255,255,255,0.8); font-size:13px; margin:8px 0 0; font-weight:500;">📢 Publicación reciente en el blog</p>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 40px; border-left:1px solid #e5e5ef; border-right:1px solid #e5e5ef;">
                            <span style="display:inline-block; padding:4px 12px; background:{{ $post->category_gradient }}; color:#ffffff; font-size:11px; font-weight:700; border-radius:20px; text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
                                {{ $post->category_label }}
                            </span>
                            
                            <h1 style="color:#1a1a2e; font-size:22px; margin:0 0 12px 0; font-weight:700; line-height:1.3;">
                                {{ $post->title }}
                            </h1>
                            
                            <p style="color:#6b7280; font-size:14px; margin:0 0 24px 0; line-height:1.6; font-style:italic;">
                                ⏱️ Tiempo estimado de lectura: {{ $post->read_time }} min — Publicado el {{ $post->published_at ? $post->published_at->format('d/m/Y') : now()->format('d/m/Y') }}
                            </p>

                            @if($post->featured_image)
                            <div style="margin-bottom:24px; text-align:center; border-radius:12px; overflow:hidden;">
                                <img src="{{ url('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="max-width:100%; height:auto; border-radius:12px; border:1px solid #e5e5ef;" />
                            </div>
                            @endif

                            <div style="background:rgba(94,23,235,0.04); border:1px solid rgba(94,23,235,0.12); border-radius:10px; padding:20px; margin-bottom:28px;">
                                <p style="color:#1a1a2e; font-size:15px; line-height:1.7; margin:0;">
                                    {{ $post->excerpt }}
                                </p>
                            </div>

                            {{-- CTA --}}
                            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#5e17eb,#ff00cc); border-radius:8px; padding:12px 28px;">
                                        <a href="{{ url('/blog/' . $post->slug) }}" style="color:#ffffff; font-size:14px; font-weight:600; text-decoration:none; display:inline-block;">
                                            Leer artículo completo →
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
