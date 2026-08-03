@extends('layouts.app')

@section('title', 'Política de Cookies | CreativeUP')
@section('meta_description', 'Descubre cómo utilizamos las cookies en CreativeUP para brindarte una navegación fluida, segura y personalizada.')

@push('styles')
<style>
    .legal-hero {
        padding: clamp(4rem, 8vw, 7rem) 1rem 3rem;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.05) 0%, rgba(131, 56, 236, 0.05) 100%);
        border-bottom: 1px solid var(--border-light, #e2e8f0);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .legal-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        background: rgba(236, 72, 153, 0.1);
        color: #ec4899;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(236, 72, 153, 0.2);
    }

    .legal-title {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        margin-bottom: 1rem;
        letter-spacing: -1px;
    }

    .legal-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        max-width: 650px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }

    .legal-meta {
        font-size: 0.85rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .legal-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 3rem 1.5rem 6rem;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 3rem;
    }

    .legal-toc {
        position: sticky;
        top: 100px;
        align-self: start;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .legal-toc-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .legal-toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .legal-toc-link {
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: block;
    }

    .legal-toc-link:hover {
        color: #ec4899;
        background: rgba(236, 72, 153, 0.05);
    }

    .legal-content {
        display: flex;
        flex-direction: column;
        gap: 2.5rem;
    }

    .legal-section {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 2.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease;
    }

    .legal-section:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .legal-section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .legal-section-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(131, 56, 236, 0.1));
        color: #ec4899;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .legal-section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .legal-text {
        color: #475569;
        font-size: 0.98rem;
        line-height: 1.7;
    }

    .legal-text p {
        margin-bottom: 1rem;
    }

    .legal-text p:last-child {
        margin-bottom: 0;
    }

    .legal-text ul {
        margin: 0.75rem 0 1.25rem 1.25rem;
        color: #475569;
    }

    .legal-text li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    .cookie-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.25rem 0;
        font-size: 0.9rem;
    }

    .cookie-table th {
        background: #f8fafc;
        color: #0f172a;
        font-weight: 600;
        text-align: left;
        padding: 0.75rem 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .cookie-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }

    .legal-highlight-box {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.03), rgba(131, 56, 236, 0.03));
        border-left: 4px solid #ec4899;
        padding: 1.25rem 1.5rem;
        border-radius: 0 12px 12px 0;
        margin: 1.25rem 0;
        font-size: 0.95rem;
        color: #334155;
    }

    @media (max-width: 900px) {
        .legal-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .legal-toc {
            display: none;
        }
    }
</style>
@endpush

@section('content')

{{-- Hero Header --}}
<header class="legal-hero">
    <div class="legal-badge">
        <i class="fa-solid fa-cookie-bite"></i>
        <span>Navegación Personalizada</span>
    </div>
    <h1 class="legal-title">Política de Cookies</h1>
    <p class="legal-subtitle">
        Explicación detallada sobre el uso de cookies y tecnologías de almacenamiento en nuestro portal web.
    </p>
    <div class="legal-meta">
        <span><i class="fa-regular fa-calendar" style="margin-right: 6px;"></i> Revisión: {{ date('Y') }}</span>
        <span>•</span>
        <span><i class="fa-regular fa-clock" style="margin-right: 6px;"></i> Lectura estimada: 4 min</span>
    </div>
</header>

{{-- Main Layout --}}
<div class="legal-container">
    {{-- Tabla de Contenidos --}}
    <aside class="legal-toc">
        <div class="legal-toc-title">Contenido</div>
        <ul class="legal-toc-list">
            <li><a href="#sec-1" class="legal-toc-link">1. ¿Qué son las cookies?</a></li>
            <li><a href="#sec-2" class="legal-toc-link">2. Tipos de cookies usadas</a></li>
            <li><a href="#sec-3" class="legal-toc-link">3. Tabla de cookies activas</a></li>
            <li><a href="#sec-4" class="legal-toc-link">4. Cómo administrar o desactivar</a></li>
        </ul>
    </aside>

    {{-- Secciones de Cookies --}}
    <main class="legal-content">
        {{-- Sección 1 --}}
        <section class="legal-section" id="sec-1">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-cookie"></i></div>
                <h2 class="legal-section-title">1. ¿Qué son las Cookies?</h2>
            </div>
            <div class="legal-text">
                <p>Las cookies son pequeños archivos de texto que los sitios web almacenan en tu dispositivo (ordenador, tablet o teléfono móvil) al navegar por internet. Sirven para recordar tus preferencias, mejorar la velocidad del portal y ofrecer una navegación adaptada.</p>
            </div>
        </section>

        {{-- Sección 2 --}}
        <section class="legal-section" id="sec-2">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-layer-group"></i></div>
                <h2 class="legal-section-title">2. Tipos de Cookies que Utilizamos</h2>
            </div>
            <div class="legal-text">
                <p>En CreativeUP agrupamos las cookies en tres categorías principales:</p>
                <ul>
                    <li><strong>Esenciales y de Sesión:</strong> Necesarias para el funcionamiento técnico del sitio, como la autenticación en el panel y la protección de formularios.</li>
                    <li><strong>De Rendimiento y Analítica:</strong> Nos ayudan a entender de forma anónima el comportamiento de los visitantes para optimizar tiempos de carga.</li>
                    <li><strong>De Funcionalidad:</strong> Guardan tus preferencias de navegación, como idioma, modo oscuro o cierre del aviso de cookies.</li>
                </ul>
            </div>
        </section>

        {{-- Sección 3 --}}
        <section class="legal-section" id="sec-3">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-list-check"></i></div>
                <h2 class="legal-section-title">3. Tabla de Cookies Activas</h2>
            </div>
            <div class="legal-text">
                <table class="cookie-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Propósito</th>
                            <th>Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>creativeup_session</code></td>
                            <td>Esencial</td>
                            <td>Gestión de sesión del usuario en Laravel</td>
                            <td>Sesión</td>
                        </tr>
                        <tr>
                            <td><code>XSRF-TOKEN</code></td>
                            <td>Seguridad</td>
                            <td>Protección contra ataques CSRF en formularios</td>
                            <td>2 horas</td>
                        </tr>
                        <tr>
                            <td><code>cookie_consent</code></td>
                            <td>Funcional</td>
                            <td>Recuerda tu aceptación de la política de cookies</td>
                            <td>1 año</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Sección 4 --}}
        <section class="legal-section" id="sec-4">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-sliders"></i></div>
                <h2 class="legal-section-title">4. Cómo Administrar o Desactivar Cookies</h2>
            </div>
            <div class="legal-text">
                <p>Puedes cambiar las preferencias de tu navegador en cualquier momento para bloquear o borrar las cookies. A continuación te indicamos los enlaces oficiales de soporte:</p>
                <ul>
                    <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener" style="color:#ec4899; text-decoration:none;">Google Chrome</a></li>
                    <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener" style="color:#ec4899; text-decoration:none;">Mozilla Firefox</a></li>
                    <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener" style="color:#ec4899; text-decoration:none;">Apple Safari</a></li>
                    <li><a href="https://support.microsoft.com/es-es/microsoft-edge/eliminar-las-cookies-en-microsoft-edge-63947406-40cf-4bc0-a41e-579f5013195b" target="_blank" rel="noopener" style="color:#ec4899; text-decoration:none;">Microsoft Edge</a></li>
                </ul>
                <div class="legal-highlight-box" style="margin-bottom:0;">
                    <i class="fa-solid fa-circle-info" style="margin-right: 8px; color: #ec4899;"></i>
                    <strong>Atención:</strong> Bloquear todas las cookies esenciales puede afectar la experiencia en formularios y autenticación del sistema.
                </div>
            </div>
        </section>
    </main>
</div>

@endsection
