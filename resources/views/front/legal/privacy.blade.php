@extends('layouts.app')

@section('title', 'Política de Privacidad | CreativeUP')
@section('meta_description', 'Conoce nuestra Política de Privacidad y cómo en CreativeUP protegemos tus datos personales conforme a la ley.')

@push('styles')
<style>
    .legal-hero {
        padding: clamp(4rem, 8vw, 7rem) 1rem 3rem;
        background: linear-gradient(135deg, rgba(255, 0, 110, 0.05) 0%, rgba(131, 56, 236, 0.05) 100%);
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
        background: rgba(255, 0, 110, 0.1);
        color: #ff006e;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(255, 0, 110, 0.2);
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
        color: #ff006e;
        background: rgba(255, 0, 110, 0.05);
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
        background: linear-gradient(135deg, rgba(255, 0, 110, 0.1), rgba(131, 56, 236, 0.1));
        color: #ff006e;
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

    .legal-highlight-box {
        background: linear-gradient(135deg, rgba(255, 0, 110, 0.03), rgba(131, 56, 236, 0.03));
        border-left: 4px solid #ff006e;
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
        <i class="fa-solid fa-user-shield"></i>
        <span>Transparencia y Seguridad</span>
    </div>
    <h1 class="legal-title">Política de Privacidad</h1>
    <p class="legal-subtitle">
        En CreativeUP valoramos tu confianza. Descubre cómo recopilamos, utilizamos y protegemos tu información personal.
    </p>
    <div class="legal-meta">
        <span><i class="fa-regular fa-calendar" style="margin-right: 6px;"></i> Última actualización: {{ date('d/m/Y') }}</span>
        <span>•</span>
        <span><i class="fa-regular fa-clock" style="margin-right: 6px;"></i> Lectura estimada: 5 min</span>
    </div>
</header>

{{-- Main Layout --}}
<div class="legal-container">
    {{-- Tabla de Contenidos --}}
    <aside class="legal-toc">
        <div class="legal-toc-title">Contenido</div>
        <ul class="legal-toc-list">
            <li><a href="#sec-1" class="legal-toc-link">1. Información que recopilamos</a></li>
            <li><a href="#sec-2" class="legal-toc-link">2. Uso de la información</a></li>
            <li><a href="#sec-3" class="legal-toc-link">3. Almacenamiento y Seguridad</a></li>
            <li><a href="#sec-4" class="legal-toc-link">4. Transferencia a terceros</a></li>
            <li><a href="#sec-5" class="legal-toc-link">5. Derechos ARCO del usuario</a></li>
            <li><a href="#sec-6" class="legal-toc-link">6. Contacto y Consultas</a></li>
        </ul>
    </aside>

    {{-- Secciones de Política --}}
    <main class="legal-content">
        {{-- Sección 1 --}}
        <section class="legal-section" id="sec-1">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-folder-open"></i></div>
                <h2 class="legal-section-title">1. Información que Recopilamos</h2>
            </div>
            <div class="legal-text">
                <p>En <strong>CreativeUP Studio</strong> recopilamos datos personales únicamente cuando el usuario nos los proporciona de manera voluntaria a través de nuestros formularios digitales de contacto, suscripción al boletín, solicitudes de cotización o canal interactivo de chat.</p>
                <div class="legal-highlight-box">
                    <strong>Datos habituales recabados:</strong> Nombres, apellidos, dirección de correo electrónico, teléfono corporativo, empresa y requerimientos específicos de proyecto.
                </div>
                <p>Adicionalmente, al navegar en nuestro sitio web, recopilamos información técnica no identificable, como dirección IP, navegador, sistema operativo y páginas visitadas para fines estadísticos y de optimización de rendimiento.</p>
            </div>
        </section>

        {{-- Sección 2 --}}
        <section class="legal-section" id="sec-2">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-bullseye"></i></div>
                <h2 class="legal-section-title">2. Uso de la Información</h2>
            </div>
            <div class="legal-text">
                <p>La información recopilada por CreativeUP se utiliza de manera exclusiva para los siguientes propósitos legítimos:</p>
                <ul>
                    <li>Procesar solicitudes de contacto, presupuesto y propuestas comerciales.</li>
                    <li>Enviar artículos de blog, lanzamientos de proyectos y novedades del boletín (únicamente si el usuario se suscribió de forma explícita).</li>
                    <li>Mejorar la experiencia de usuario y optimizar la navegación de nuestras soluciones web.</li>
                    <li>Cumplir con obligaciones contractuales y legales vigentes.</li>
                </ul>
            </div>
        </section>

        {{-- Sección 3 --}}
        <section class="legal-section" id="sec-3">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h2 class="legal-section-title">3. Almacenamiento y Seguridad</h2>
            </div>
            <div class="legal-text">
                <p>Adoptamos medidas de seguridad técnicas, organizativas y físicas estrictas para proteger tus datos contra acceso no autorizado, alteración, divulgación o destrucción. Empleamos cifrado de datos SSL/TLS en todo momento.</p>
                <p>Tus datos son almacenados en servidores seguros respaldados en la nube con altos estándares de cumplimiento de protección de datos internacionales.</p>
            </div>
        </section>

        {{-- Sección 4 --}}
        <section class="legal-section" id="sec-4">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-share-nodes"></i></div>
                <h2 class="legal-section-title">4. Transferencia a Terceros</h2>
            </div>
            <div class="legal-text">
                <p><strong>CreativeUP no vende, alquila ni comercializa datos personales de sus usuarios con ninguna empresa externa.</strong></p>
                <p>Únicamente compartimos datos con proveedores tecnológicos de confianza necesarios para la prestación del servicio (por ejemplo, proveedores de servidores de correo SMTP o plataformas de alojamiento web), quienes operan bajo estrictos acuerdos de confidencialidad.</p>
            </div>
        </section>

        {{-- Sección 5 --}}
        <section class="legal-section" id="sec-5">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-user-check"></i></div>
                <h2 class="legal-section-title">5. Derechos del Usuario (Derechos ARCO)</h2>
            </div>
            <div class="legal-text">
                <p>Como titular de tus datos personales, tienes derecho a ejercer en cualquier momento tus derechos de <strong>Acceso, Rectificación, Cancelación y Oposición (ARCO)</strong>.</p>
                <p>Puedes solicitar la eliminación total de tus datos o cancelar tu suscripción al boletín en cualquier momento escribiendo a nuestro correo oficial de privacidad.</p>
            </div>
        </section>

        {{-- Sección 6 --}}
        <section class="legal-section" id="sec-6">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                <h2 class="legal-section-title">6. Contacto y Consultas</h2>
            </div>
            <div class="legal-text">
                <p>Si tienes preguntas, requerimientos o deseas ejercer tus derechos en relación a esta Política de Privacidad, puedes escribirnos directamente:</p>
                <div class="legal-highlight-box" style="margin-bottom:0;">
                    <i class="fa-solid fa-envelope" style="margin-right: 8px; color: #ff006e;"></i>
                    <strong>Correo de Privacidad:</strong> <a href="mailto:hola@studiocreativeup.com" style="color:#ff006e; text-decoration:none; font-weight:600;">hola@studiocreativeup.com</a>
                </div>
            </div>
        </section>
    </main>
</div>

@endsection
