@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
{{-- ── Hero de contacto ── --}}
<section class="cf-hero">
    <div class="cf-hero-bg">
        <div class="cf-hero-shape cf-hero-shape--1"></div>
        <div class="cf-hero-shape cf-hero-shape--2"></div>
        <div class="cf-hero-shape cf-hero-shape--3"></div>
    </div>
    <div class="cf-hero-inner">
        <span class="cf-hero-badge anim-hidden" data-anim="fade-up">
            <i class="fa-solid fa-paper-plane"></i> Hablemos de tu proyecto
        </span>
        <h1 class="cf-hero-title anim-hidden" data-anim="fade-up">
            Convirtamos tu idea en <span class="cf-hero-gradient">realidad</span>
        </h1>
        <p class="cf-hero-desc anim-hidden" data-anim="fade-up">
            Estamos listos para escucharte. Cuéntanos sobre tu proyecto y te responderemos en menos de 24 horas.
        </p>
    </div>
</section>

{{-- ── Sección principal: info + formulario ── --}}
<section class="cf-section">
    <div class="cf-container">

        {{-- Panel izquierdo: info --}}
        <div class="cf-info anim-hidden" data-anim="fade-up">
            <h2 class="cf-info-title">¿Por qué elegirnos?</h2>

            <div class="cf-info-cards">
                <div class="cf-info-card">
                    <div class="cf-info-card-icon">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h3 class="cf-info-card-title">Respuesta rápida</h3>
                        <p class="cf-info-card-text">Te respondemos en menos de 24 horas con una propuesta personalizada.</p>
                    </div>
                </div>
                <div class="cf-info-card">
                    <div class="cf-info-card-icon">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <div>
                        <h3 class="cf-info-card-title">Diseño único</h3>
                        <p class="cf-info-card-text">Cada proyecto es diseñado desde cero, sin plantillas genéricas.</p>
                    </div>
                </div>
                <div class="cf-info-card">
                    <div class="cf-info-card-icon">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <div>
                        <h3 class="cf-info-card-title">Desarrollo a medida</h3>
                        <p class="cf-info-card-text">Código limpio, optimizado y escalable para tu negocio.</p>
                    </div>
                </div>
                <div class="cf-info-card">
                    <div class="cf-info-card-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h3 class="cf-info-card-title">Soporte continuo</h3>
                        <p class="cf-info-card-text">Acompañamiento después del lanzamiento para que todo funcione perfecto.</p>
                    </div>
                </div>
            </div>

            <div class="cf-info-contact">
                <h3 class="cf-info-contact-title">Información de contacto</h3>
                <a href="mailto:hola@creativeup.co" class="cf-info-contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>hola@creativeup.co</span>
                </a>
                <a href="https://wa.me/573000000000" target="_blank" rel="noopener" class="cf-info-contact-item">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>+57 300 000 0000</span>
                </a>
                <div class="cf-info-contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Colombia</span>
                </div>
            </div>

            <div class="cf-info-socials">
                <a href="#" target="_blank" rel="noopener" class="cf-info-social" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" target="_blank" rel="noopener" class="cf-info-social" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" target="_blank" rel="noopener" class="cf-info-social" aria-label="TikTok">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
            </div>
        </div>

        {{-- Panel derecho: formulario --}}
        <div class="cf-form-wrapper anim-hidden" data-anim="fade-up">

            {{-- Alerta de éxito --}}
            @if(session('success'))
            <div class="cf-alert cf-alert--success" id="cfAlertSuccess">
                <div class="cf-alert-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="cf-alert-body">
                    <strong>¡Mensaje enviado!</strong>
                    <p>{{ session('success') }}</p>
                </div>
                <button type="button" class="cf-alert-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            {{-- Alertas de error --}}
            @if($errors->any())
            <div class="cf-alert cf-alert--error" id="cfAlertError">
                <div class="cf-alert-icon">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div class="cf-alert-body">
                    <strong>Hay errores en el formulario</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="cf-alert-close" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @endif

            {{-- Indicador de pasos --}}
            <div class="cf-steps-indicator">
                <div class="cf-step-dot cf-step-dot--active" data-step="1">
                    <span>1</span>
                </div>
                <div class="cf-step-line"></div>
                <div class="cf-step-dot" data-step="2">
                    <span>2</span>
                </div>
                <div class="cf-step-line"></div>
                <div class="cf-step-dot" data-step="3">
                    <span>3</span>
                </div>
            </div>
            <div class="cf-steps-labels">
                <span class="cf-step-label cf-step-label--active" data-step="1">Datos personales</span>
                <span class="cf-step-label" data-step="2">Tu proyecto</span>
                <span class="cf-step-label" data-step="3">Mensaje</span>
            </div>

            <form method="POST" action="{{ route('contact.store') }}" class="cf-form" id="contactForm" novalidate>
                @csrf

                {{-- Step 1: Datos personales --}}
                <div class="cf-form-step cf-form-step--active" id="cfStep1">
                    <div class="cf-form-group">
                        <div class="cf-input-wrapper">
                            <input type="text" id="cf-name" name="name" value="{{ old('name') }}" required
                                   class="cf-input" placeholder=" " autocomplete="name" maxlength="150">
                            <label for="cf-name" class="cf-label">
                                <i class="fa-regular fa-user"></i> Nombre completo <span class="cf-required">*</span>
                            </label>
                            <div class="cf-input-border"></div>
                        </div>
                        <span class="cf-error-msg" id="cf-name-error"></span>
                    </div>

                    <div class="cf-form-group">
                        <div class="cf-input-wrapper">
                            <input type="email" id="cf-email" name="email" value="{{ old('email') }}" required
                                   class="cf-input" placeholder=" " autocomplete="email" maxlength="150">
                            <label for="cf-email" class="cf-label">
                                <i class="fa-regular fa-envelope"></i> Correo electrónico <span class="cf-required">*</span>
                            </label>
                            <div class="cf-input-border"></div>
                        </div>
                        <span class="cf-error-msg" id="cf-email-error"></span>
                    </div>

                    <div class="cf-form-group">
                        <div class="cf-input-wrapper">
                            <input type="tel" id="cf-phone" name="phone" value="{{ old('phone') }}"
                                   class="cf-input" placeholder=" " autocomplete="tel" maxlength="30">
                            <label for="cf-phone" class="cf-label">
                                <i class="fa-solid fa-phone"></i> Teléfono <span class="cf-optional">(opcional)</span>
                            </label>
                            <div class="cf-input-border"></div>
                        </div>
                        <span class="cf-error-msg" id="cf-phone-error"></span>
                    </div>

                    <div class="cf-form-nav">
                        <div></div>
                        <button type="button" class="cf-btn cf-btn--next" id="cfNext1">
                            Siguiente <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 2: Tu proyecto --}}
                <div class="cf-form-step" id="cfStep2">
                    <div class="cf-form-group">
                        <input type="hidden" id="cf-service" name="service_id" value="{{ old('service_id') }}">

                        @php
                            $serviceIcons = [
                                'social media' => 'fa-hashtag',
                                'branding' => 'fa-palette',
                                'desarrollo web' => 'fa-code',
                                'seo profesional' => 'fa-chart-line',
                            ];
                            $selectedService = old('service_id') ? $services->firstWhere('id', old('service_id')) : null;
                        @endphp

                        <div class="cf-dropdown" id="cfDropdown">
                            <button type="button" class="cf-dropdown-trigger" id="cfDropdownTrigger">
                                <div class="cf-dropdown-trigger-left">
                                    <div class="cf-dropdown-trigger-icon" id="cfDropdownIcon">
                                        <i class="fa-solid {{ $selectedService ? ($serviceIcons[strtolower($selectedService->title)] ?? 'fa-star') : 'fa-briefcase' }}"></i>
                                    </div>
                                    <div class="cf-dropdown-trigger-text">
                                        <span class="cf-dropdown-trigger-label">Servicio de interés</span>
                                        <span class="cf-dropdown-trigger-value" id="cfDropdownValue">
                                            {{ $selectedService ? $selectedService->title : 'Selecciona un servicio' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="cf-dropdown-arrow">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </button>

                            <div class="cf-dropdown-menu" id="cfDropdownMenu">
                                <div class="cf-dropdown-option cf-dropdown-option--placeholder" data-value="">
                                    <div class="cf-dropdown-opt-icon">
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <div class="cf-dropdown-opt-body">
                                        <span class="cf-dropdown-opt-title">Ninguno</span>
                                        <span class="cf-dropdown-opt-desc">Quitar selección</span>
                                    </div>
                                </div>
                                @foreach($services as $service)
                                <div class="cf-dropdown-option {{ old('service_id') == $service->id ? 'cf-dropdown-option--selected' : '' }}"
                                     data-value="{{ $service->id }}"
                                     data-title="{{ $service->title }}"
                                     data-icon="{{ $serviceIcons[strtolower($service->title)] ?? 'fa-star' }}">
                                    <div class="cf-dropdown-opt-icon">
                                        <i class="fa-solid {{ $serviceIcons[strtolower($service->title)] ?? 'fa-star' }}"></i>
                                    </div>
                                    <div class="cf-dropdown-opt-body">
                                        <span class="cf-dropdown-opt-title">{{ $service->title }}</span>
                                        <span class="cf-dropdown-opt-desc">{{ Str::limit($service->description, 70) }}</span>
                                    </div>
                                    <div class="cf-dropdown-opt-check">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="cf-form-group">
                        <p class="cf-budget-label"><i class="fa-solid fa-wallet"></i> Presupuesto estimado</p>
                        <div class="cf-budget-options">
                            <label class="cf-budget-option">
                                <input type="radio" name="budget" value="< $500">
                                <span class="cf-budget-chip">Menos de $500</span>
                            </label>
                            <label class="cf-budget-option">
                                <input type="radio" name="budget" value="$500 - $2000">
                                <span class="cf-budget-chip">$500 – $2,000</span>
                            </label>
                            <label class="cf-budget-option">
                                <input type="radio" name="budget" value="$2000 - $5000">
                                <span class="cf-budget-chip">$2,000 – $5,000</span>
                            </label>
                            <label class="cf-budget-option">
                                <input type="radio" name="budget" value="> $5000">
                                <span class="cf-budget-chip">Más de $5,000</span>
                            </label>
                            <label class="cf-budget-option">
                                <input type="radio" name="budget" value="No definido">
                                <span class="cf-budget-chip">Aún no lo sé</span>
                            </label>
                        </div>
                    </div>

                    <div class="cf-form-nav">
                        <button type="button" class="cf-btn cf-btn--prev" id="cfPrev2">
                            <i class="fa-solid fa-arrow-left"></i> Anterior
                        </button>
                        <button type="button" class="cf-btn cf-btn--next" id="cfNext2">
                            Siguiente <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 3: Mensaje --}}
                <div class="cf-form-step" id="cfStep3">
                    <div class="cf-form-group">
                        <div class="cf-input-wrapper">
                            <textarea id="cf-message" name="message" required
                                      class="cf-input cf-textarea" placeholder=" " maxlength="2000" rows="5">{{ old('message') }}</textarea>
                            <label for="cf-message" class="cf-label">
                                <i class="fa-regular fa-message"></i> Cuéntanos sobre tu proyecto <span class="cf-required">*</span>
                            </label>
                            <div class="cf-input-border"></div>
                        </div>
                        <div class="cf-textarea-footer">
                            <span class="cf-error-msg" id="cf-message-error"></span>
                            <span class="cf-char-count"><span id="cfCharCount">0</span> / 2000</span>
                        </div>
                    </div>

                    <div class="cf-form-nav">
                        <button type="button" class="cf-btn cf-btn--prev" id="cfPrev3">
                            <i class="fa-solid fa-arrow-left"></i> Anterior
                        </button>
                        <button type="submit" class="cf-btn cf-btn--submit" id="cfSubmitBtn">
                            <span class="cf-btn-text">
                                <i class="fa-solid fa-paper-plane"></i> Enviar mensaje
                            </span>
                            <span class="cf-btn-loading">
                                <i class="fa-solid fa-spinner fa-spin"></i> Enviando...
                            </span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="cf-form-footer">
                <i class="fa-solid fa-shield-halved"></i>
                Tu información está segura. No compartimos tus datos con terceros.
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ rápido ── --}}
<section class="cf-faq anim-hidden" data-anim="fade-up">
    <h2 class="cf-faq-title">Preguntas frecuentes</h2>
    <div class="cf-faq-grid">
        <div class="cf-faq-item">
            <button class="cf-faq-question" aria-expanded="false">
                <span>¿Cuánto tiempo tarda un proyecto?</span>
                <i class="fa-solid fa-plus cf-faq-icon"></i>
            </button>
            <div class="cf-faq-answer">
                <p>Depende de la complejidad. Un sitio web puede estar listo en 2-4 semanas, mientras que un proyecto completo de branding puede tomar 4-8 semanas.</p>
            </div>
        </div>
        <div class="cf-faq-item">
            <button class="cf-faq-question" aria-expanded="false">
                <span>¿Ofrecen planes de pago?</span>
                <i class="fa-solid fa-plus cf-faq-icon"></i>
            </button>
            <div class="cf-faq-answer">
                <p>Sí, ofrecemos opciones de pago flexibles. Generalmente 50% al iniciar y 50% al entregar, pero podemos adaptarnos a tus necesidades.</p>
            </div>
        </div>
        <div class="cf-faq-item">
            <button class="cf-faq-question" aria-expanded="false">
                <span>¿Qué incluye el soporte post-lanzamiento?</span>
                <i class="fa-solid fa-plus cf-faq-icon"></i>
            </button>
            <div class="cf-faq-answer">
                <p>Incluimos 30 días de soporte gratuito para correcciones y ajustes menores. Después ofrecemos planes de mantenimiento mensual.</p>
            </div>
        </div>
        <div class="cf-faq-item">
            <button class="cf-faq-question" aria-expanded="false">
                <span>¿Puedo ver avances durante el desarrollo?</span>
                <i class="fa-solid fa-plus cf-faq-icon"></i>
            </button>
            <div class="cf-faq-answer">
                <p>¡Por supuesto! Trabajamos con revisiones semanales donde puedes ver el avance y dar feedback en tiempo real.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    if (!form) return;

    /* ── Steps Navigation ── */
    const steps = form.querySelectorAll('.cf-form-step');
    const dots = document.querySelectorAll('.cf-step-dot');
    const labels = document.querySelectorAll('.cf-step-label');
    let currentStep = 1;

    function goToStep(n) {
        steps.forEach(s => s.classList.remove('cf-form-step--active'));
        dots.forEach(d => {
            const ds = +d.dataset.step;
            d.classList.toggle('cf-step-dot--active', ds <= n);
            d.classList.toggle('cf-step-dot--done', ds < n);
        });
        labels.forEach(l => {
            l.classList.toggle('cf-step-label--active', +l.dataset.step === n);
        });
        const target = document.getElementById('cfStep' + n);
        if (target) {
            target.classList.add('cf-form-step--active');
            target.style.animation = 'cfSlideIn 0.4s ease forwards';
        }
        currentStep = n;

        // Update step lines
        document.querySelectorAll('.cf-step-line').forEach((line, i) => {
            line.classList.toggle('cf-step-line--active', i < n - 1);
        });
    }

    // Next / Prev buttons
    document.getElementById('cfNext1')?.addEventListener('click', () => {
        if (validateStep(1)) goToStep(2);
    });
    document.getElementById('cfNext2')?.addEventListener('click', () => goToStep(3));
    document.getElementById('cfPrev2')?.addEventListener('click', () => goToStep(1));
    document.getElementById('cfPrev3')?.addEventListener('click', () => goToStep(2));

    /* ── Real-time Validation ── */
    const validators = {
        'cf-name': (v) => {
            if (!v.trim()) return 'El nombre es obligatorio';
            if (v.trim().length < 2) return 'El nombre debe tener al menos 2 caracteres';
            return '';
        },
        'cf-email': (v) => {
            if (!v.trim()) return 'El correo es obligatorio';
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Ingresa un correo válido';
            return '';
        },
        'cf-phone': (v) => {
            if (v && !/^[\d\s\+\-\(\)]{7,30}$/.test(v)) return 'Ingresa un teléfono válido';
            return '';
        },
        'cf-message': (v) => {
            if (!v.trim()) return 'El mensaje es obligatorio';
            if (v.trim().length < 10) return 'Escribe al menos 10 caracteres';
            return '';
        }
    };

    function showError(id, msg) {
        const errEl = document.getElementById(id + '-error');
        const input = document.getElementById(id);
        if (errEl) errEl.textContent = msg;
        if (input) {
            input.classList.toggle('cf-input--error', !!msg);
            input.classList.toggle('cf-input--valid', !msg && input.value.trim().length > 0);
        }
    }

    function validateStep(n) {
        let valid = true;
        const fieldsMap = {
            1: ['cf-name', 'cf-email', 'cf-phone'],
            3: ['cf-message']
        };
        const fields = fieldsMap[n] || [];
        fields.forEach(id => {
            const input = document.getElementById(id);
            const fn = validators[id];
            if (input && fn) {
                const msg = fn(input.value);
                showError(id, msg);
                if (msg) valid = false;
            }
        });
        return valid;
    }

    // Live validation on blur
    Object.keys(validators).forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;
        input.addEventListener('blur', () => {
            const msg = validators[id](input.value);
            showError(id, msg);
        });
        input.addEventListener('input', () => {
            if (input.classList.contains('cf-input--error')) {
                const msg = validators[id](input.value);
                showError(id, msg);
            }
        });
    });

    /* ── Character Counter ── */
    const msgArea = document.getElementById('cf-message');
    const charCount = document.getElementById('cfCharCount');
    if (msgArea && charCount) {
        function updateCount() {
            const len = msgArea.value.length;
            charCount.textContent = len;
            charCount.parentElement.classList.toggle('cf-char-warn', len > 1800);
            charCount.parentElement.classList.toggle('cf-char-limit', len >= 2000);
        }
        msgArea.addEventListener('input', updateCount);
        updateCount();
    }

    /* ── Submit with loading state ── */
    form.addEventListener('submit', function (e) {
        if (!validateStep(currentStep)) {
            e.preventDefault();
            return;
        }
        // Also validate step 1 fields even if on step 3
        if (!validateStep(1)) {
            e.preventDefault();
            goToStep(1);
            return;
        }
        const btn = document.getElementById('cfSubmitBtn');
        if (btn) {
            btn.classList.add('cf-btn--loading');
            btn.disabled = true;
        }
    });

    /* ── Floating Labels: check on load (for old() values) ── */
    form.querySelectorAll('.cf-input').forEach(input => {
        if (input.value.trim()) {
            input.classList.add('cf-input--filled');
        }
        input.addEventListener('input', () => {
            input.classList.toggle('cf-input--filled', input.value.trim().length > 0);
        });
    });

    /* ── FAQ Accordion ── */
    document.querySelectorAll('.cf-faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.cf-faq-item');
            const wasOpen = item.classList.contains('cf-faq-item--open');

            // Close all
            document.querySelectorAll('.cf-faq-item--open').forEach(i => {
                i.classList.remove('cf-faq-item--open');
                i.querySelector('.cf-faq-question').setAttribute('aria-expanded', 'false');
            });

            // Toggle clicked
            if (!wasOpen) {
                item.classList.add('cf-faq-item--open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    /* ── Auto-dismiss alerts ── */
    document.querySelectorAll('.cf-alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 400);
        }, 6000);
    });

    /* ── Service Dropdown ── */
    const cfDropdown = document.getElementById('cfDropdown');
    const cfTrigger = document.getElementById('cfDropdownTrigger');
    const cfMenu = document.getElementById('cfDropdownMenu');
    const cfServiceInput = document.getElementById('cf-service');
    const cfValue = document.getElementById('cfDropdownValue');
    const cfIcon = document.getElementById('cfDropdownIcon');

    if (cfTrigger && cfMenu) {
        cfTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            cfDropdown.classList.toggle('cf-dropdown--open');
        });

        // Close on click outside
        document.addEventListener('click', (e) => {
            if (!cfDropdown.contains(e.target)) {
                cfDropdown.classList.remove('cf-dropdown--open');
            }
        });

        cfMenu.querySelectorAll('.cf-dropdown-option').forEach(opt => {
            opt.addEventListener('click', () => {
                const val = opt.dataset.value;
                const title = opt.dataset.title || '';
                const icon = opt.dataset.icon || 'fa-briefcase';

                // Update selected state
                cfMenu.querySelectorAll('.cf-dropdown-option--selected').forEach(o => {
                    o.classList.remove('cf-dropdown-option--selected');
                });

                if (val) {
                    opt.classList.add('cf-dropdown-option--selected');
                    cfValue.textContent = title;
                    cfValue.classList.add('cf-dropdown-trigger-value--filled');
                    cfIcon.innerHTML = '<i class="fa-solid ' + icon + '"></i>';
                    cfIcon.classList.add('cf-dropdown-trigger-icon--active');
                } else {
                    cfValue.textContent = 'Selecciona un servicio';
                    cfValue.classList.remove('cf-dropdown-trigger-value--filled');
                    cfIcon.innerHTML = '<i class="fa-solid fa-briefcase"></i>';
                    cfIcon.classList.remove('cf-dropdown-trigger-icon--active');
                }

                if (cfServiceInput) cfServiceInput.value = val;
                cfDropdown.classList.remove('cf-dropdown--open');
            });
        });
    }
});
</script>
@endpush
