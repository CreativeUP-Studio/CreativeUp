@extends('layouts.app')

@section('title', 'Términos y Condiciones | CreativeUP')
@section('meta_description', 'Consulta los Términos y Condiciones que rigen el uso del sitio web y los servicios de desarrollo y diseño en CreativeUP.')

@push('styles')
<style>
    .legal-hero {
        padding: clamp(4rem, 8vw, 7rem) 1rem 3rem;
        background: linear-gradient(135deg, rgba(131, 56, 236, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
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
        background: rgba(131, 56, 236, 0.1);
        color: #8338ec;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(131, 56, 236, 0.2);
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
        color: #8338ec;
        background: rgba(131, 56, 236, 0.05);
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
        background: linear-gradient(135deg, rgba(131, 56, 236, 0.1), rgba(59, 130, 246, 0.1));
        color: #8338ec;
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
        background: linear-gradient(135deg, rgba(131, 56, 236, 0.03), rgba(59, 130, 246, 0.03));
        border-left: 4px solid #8338ec;
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
        <i class="fa-solid fa-file-contract"></i>
        <span>Marco Legal y Condiciones</span>
    </div>
    <h1 class="legal-title">Términos y Condiciones</h1>
    <p class="legal-subtitle">
        Conoce los términos que regulan el acceso a nuestra plataforma y la prestación de nuestros servicios digitales.
    </p>
    <div class="legal-meta">
        <span><i class="fa-regular fa-calendar" style="margin-right: 6px;"></i> Vigencia: {{ date('Y') }}</span>
        <span>•</span>
        <span><i class="fa-regular fa-clock" style="margin-right: 6px;"></i> Lectura estimada: 6 min</span>
    </div>
</header>

{{-- Main Layout --}}
<div class="legal-container">
    {{-- Tabla de Contenidos --}}
    <aside class="legal-toc">
        <div class="legal-toc-title">Contenido</div>
        <ul class="legal-toc-list">
            <li><a href="#sec-1" class="legal-toc-link">1. Aceptación de los Términos</a></li>
            <li><a href="#sec-2" class="legal-toc-link">2. Servicios y Propuestas</a></li>
            <li><a href="#sec-3" class="legal-toc-link">3. Propiedad Intelectual</a></li>
            <li><a href="#sec-4" class="legal-toc-link">4. Uso Aceptable del Sitio</a></li>
            <li><a href="#sec-5" class="legal-toc-link">5. Limitación de Responsabilidad</a></li>
            <li><a href="#sec-6" class="legal-toc-link">6. Modificaciones y Ley Aplicable</a></li>
        </ul>
    </aside>

    {{-- Secciones de Términos --}}
    <main class="legal-content">
        {{-- Sección 1 --}}
        <section class="legal-section" id="sec-1">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-handshake"></i></div>
                <h2 class="legal-section-title">1. Aceptación de los Términos</h2>
            </div>
            <div class="legal-text">
                <p>Al acceder, navegar o solicitar cotizaciones y servicios a través del sitio web de <strong>CreativeUP Studio</strong>, aceptas de forma explícita quedar vinculado por los presentes Términos y Condiciones de Uso.</p>
                <p>Si no estás de acuerdo con alguna parte de estos términos, te solicitamos abstenerte de utilizar nuestro portal y formularios.</p>
            </div>
        </section>

        {{-- Sección 2 --}}
        <section class="legal-section" id="sec-2">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-laptop-code"></i></div>
                <h2 class="legal-section-title">2. Servicios y Propuestas Comerciales</h2>
            </div>
            <div class="legal-text">
                <p>CreativeUP ofrece soluciones especializadas de diseño UI/UX, desarrollo de software web y móvil, identidad corporativa y marketing digital.</p>
                <div class="legal-highlight-box">
                    <strong>Contratos Específicos de Proyecto:</strong> La información contenida en el sitio web tiene fines informativos. Cada proyecto contratado se regirá adicionalmente por su respectiva propuesta técnica o contrato de servicios.
                </div>
            </div>
        </section>

        {{-- Sección 3 --}}
        <section class="legal-section" id="sec-3">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-copyright"></i></div>
                <h2 class="legal-section-title">3. Propiedad Intelectual</h2>
            </div>
            <div class="legal-text">
                <p>Todos los contenidos presentes en este sitio web, incluyendo textos, gráficos, logotipos, marcas, código fuente, diseños de UI y casos de estudio del portafolio, son propiedad exclusiva de <strong>CreativeUP Studio</strong> o cuentan con la licencia correspondiente.</p>
                <p>Queda estrictamente prohibida la reproducción, distribución o modificación no autorizada de cualquier elemento visual o de código del sitio.</p>
            </div>
        </section>

        {{-- Sección 4 --}}
        <section class="legal-section" id="sec-4">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-shield-cat"></i></div>
                <h2 class="legal-section-title">4. Uso Aceptable del Sitio</h2>
            </div>
            <div class="legal-text">
                <p>El usuario se compromete a hacer un uso adecuado y lícito del sitio web. Queda prohibido:</p>
                <ul>
                    <li>Intentar vulnerar la seguridad, servidores o formularios del portal.</li>
                    <li>Utilizar scripts automatizados de extracción de datos (scraping no autorizado).</li>
                    <li>Enviar información falsa o contenido difamatorio a través de nuestros formularios o chat.</li>
                </ul>
            </div>
        </section>

        {{-- Sección 5 --}}
        <section class="legal-section" id="sec-5">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <h2 class="legal-section-title">5. Limitación de Responsabilidad</h2>
            </div>
            <div class="legal-text">
                <p>CreativeUP trabaja continuamente para garantizar la máxima disponibilidad y seguridad del portal. Sin embargo, no nos hacemos responsables de interrupciones temporales ocasionadas por mantenimiento de servidores, fallos de proveedores de red externos o fuerza mayor.</p>
            </div>
        </section>

        {{-- Sección 6 --}}
        <section class="legal-section" id="sec-6">
            <div class="legal-section-header">
                <div class="legal-section-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                <h2 class="legal-section-title">6. Modificaciones y Ley Aplicable</h2>
            </div>
            <div class="legal-text">
                <p>Nos reservamos el derecho de actualizar o modificar estos términos en cualquier momento para reflejar mejoras en nuestras operaciones o exigencias normativas.</p>
                <p>Para cualquier consulta legal o aclaración sobre estos términos, puedes comunicarte con nuestro equipo legal en <a href="mailto:hola@studiocreativeup.com" style="color:#8338ec; text-decoration:none; font-weight:600;">hola@studiocreativeup.com</a>.</p>
            </div>
        </section>
    </main>
</div>

@endsection
