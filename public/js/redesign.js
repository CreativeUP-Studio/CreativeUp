/**
 * CREATIVEUP - REDESIGN JAVASCRIPT
 * Funcionalidad principal del sitio rediseñado con soporte para Hotwire Turbo
 */

// =========================================================================
// 1. LISTENERS GLOBALES (Se registran exactamente UNA vez al cargar el archivo)
// =========================================================================

// Scroll listener global unificado (Optimizado y pasivo)
window.addEventListener('scroll', () => {
    // A. Efecto scroll en Navbar
    const navbar = document.getElementById('mainNavbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    // B. Visibilidad del botón Scroll to Top
    const scrollToTop = document.getElementById('scrollToTop');
    if (scrollToTop) {
        if (window.scrollY > 500) {
            scrollToTop.classList.add('visible');
        } else {
            scrollToTop.classList.remove('visible');
        }
    }

    // C. Efecto de Paralaje
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    if (parallaxElements.length > 0) {
        const scrolled = window.pageYOffset;
        parallaxElements.forEach(element => {
            const speed = element.dataset.parallax || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    }

    // D. Barra de progreso de lectura (Detalle de proyecto)
    const bar = document.getElementById('pshowProgress');
    if (bar) {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        bar.style.width = scrolled + '%';
    }

    // E. Efecto scroll en Topbar (.topbar de app.js)
    const topbar = document.querySelector(".topbar");
    if (topbar) {
        if (window.scrollY > 80) {
            topbar.classList.add("scrolled");
        } else {
            topbar.classList.remove("scrolled");
        }
    }
}, { passive: true });

// Cursor personalizado global
let mouseX = 0, mouseY = 0;
let cursorX = 0, cursorY = 0;
let cursorElement = null;

document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    if (!cursorElement) {
        cursorElement = document.querySelector('.custom-cursor');
    }
});

function animateCursor() {
    if (cursorElement) {
        const dx = mouseX - cursorX;
        const dy = mouseY - cursorY;
        cursorX += dx * 0.1;
        cursorY += dy * 0.1;
        cursorElement.style.left = cursorX + 'px';
        cursorElement.style.top = cursorY + 'px';
    }
    requestAnimationFrame(animateCursor);
}
// animateCursor(); // Descomentar si se requiere activar el cursor personalizado

// Escuchar eventos de Turbo para aplicar las transiciones visuales de página
document.addEventListener('turbo:visit', () => {
    document.body.classList.add('turbo-loading');
});

document.addEventListener('turbo:load', () => {
    document.body.classList.remove('turbo-loading');
    
    // Forzar desvanecimiento de entrada de la página
    const main = document.querySelector('.main-content');
    if (main) {
        main.classList.remove('fade-in');
        void main.offsetWidth; // Forzar reflow
        main.classList.add('fade-in');
    }
});

// =========================================================================
// 2. INICIALIZACIÓN DE ELEMENTOS DINÁMICOS POR PÁGINA
// =========================================================================
let lastLoadedUrl = null;

function initRedesign() {
    const currentUrl = window.location.href;
    if (lastLoadedUrl === currentUrl) return;
    lastLoadedUrl = currentUrl;

    console.log('%c🚀 CreativeUp Page Initialized: ' + window.location.pathname, 'color: #8338ec; font-weight: bold;');

    // A. MENÚ MÓVIL (TOGGLE)
    const navbarToggle = document.getElementById('navbarToggle');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileClose = document.getElementById('mobileClose');

    if (navbarToggle && mobileOverlay) {
        navbarToggle.addEventListener('click', () => {
            navbarToggle.classList.toggle('active');
            mobileOverlay.classList.toggle('active');
            document.body.style.overflow = mobileOverlay.classList.contains('active') ? 'hidden' : '';
        });
    }

    if (mobileClose) {
        mobileClose.addEventListener('click', () => {
            if (navbarToggle) navbarToggle.classList.remove('active');
            if (mobileOverlay) mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Cerrar menú móvil al hacer click en un enlace
    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            if (navbarToggle) navbarToggle.classList.remove('active');
            if (mobileOverlay) mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    });

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', (e) => {
            if (e.target === mobileOverlay) {
                if (navbarToggle) navbarToggle.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // B. MENÚ NAV FULLSCREEN (9 DOTS)
    const fsTrigger = document.getElementById('fsNavTrigger');
    const fsNav = document.getElementById('fsNavigation');
    const fsCloseBtn = document.getElementById('fsCloseBtn');

    const toggleFsMenu = () => {
        if(fsTrigger) fsTrigger.classList.toggle('is-active');
        if(fsNav) {
            fsNav.classList.toggle('is-open');
            document.body.style.overflow = fsNav.classList.contains('is-open') ? 'hidden' : '';
        }
    };

    if (fsTrigger) fsTrigger.addEventListener('click', toggleFsMenu);
    if (fsCloseBtn) fsCloseBtn.addEventListener('click', toggleFsMenu);

    // Cerrar menú fullscreen al hacer click en cualquier link de navegación (esencial para Turbo)
    document.querySelectorAll('.main-navigation .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (fsNav && fsNav.classList.contains('is-open')) {
                toggleFsMenu();
            }
        });
    });

    // C. PREVIEW DE CONTENIDO EN NAVEGACIÓN FULLSCREEN (INTERACTIVO)
    const navLinks = document.querySelectorAll('.main-navigation .nav-link[data-preview-img]');
    const previewCard = document.querySelector('.fs-nav-preview-card');
    const previewImg = document.getElementById('fsNavPreviewImg');
    const previewBadge = document.getElementById('fsNavPreviewBadge');
    const previewTitle = document.getElementById('fsNavPreviewTitle');
    const previewDesc = document.getElementById('fsNavPreviewDesc');
    
    if (navLinks.length && previewCard && previewImg) {
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                const imgUrl = link.getAttribute('data-preview-img');
                const title = link.getAttribute('data-preview-title');
                const desc = link.getAttribute('data-preview-desc');
                
                // Agregar clase de transición (desvanecimiento)
                previewCard.classList.add('switching');
                
                setTimeout(() => {
                    if (imgUrl) previewImg.style.backgroundImage = `url(${imgUrl})`;
                    if (title) {
                        previewTitle.textContent = title;
                        // Establecer badge dinámico (usando el nombre de marca o primera palabra)
                        if (previewBadge) {
                            previewBadge.textContent = title === 'CreativeUp Studio' ? 'CreativeUp' : title;
                        }
                    }
                    if (desc) previewDesc.textContent = desc;
                    
                    // Quitar clase para desvanecer de regreso
                    previewCard.classList.remove('switching');
                }, 180); // Ajustado al tiempo de la transición CSS
            });
        });
    }

    // D. BOTÓN SCROLL TO TOP (CLICK)
    const scrollToTop = document.getElementById('scrollToTop');
    if (scrollToTop) {
        scrollToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // E. SCROLL SUAVE PARA ENLACES ANCLA
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const navbar = document.getElementById('mainNavbar');
                const navHeight = navbar ? navbar.offsetHeight : 80;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Cerrar menú móvil si estuviese abierto
                if (navbarToggle) navbarToggle.classList.remove('active');
                if (mobileOverlay) mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // F. FORMULARIO DE NEWSLETTER
    const newsletterForms = document.querySelectorAll('#newsletterForm, .bshow-subscribe-form, .bidx-newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = form.querySelector('input[type="email"]');
            const email = emailInput ? emailInput.value.trim() : '';
            if (!email) return;

            const url = form.getAttribute('action') || '/subscribe';
            const csrfToken = form.querySelector('input[name="_token"]')?.value || 
                              document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const button = form.querySelector('button[type="submit"]') || form.querySelector('button');
            const originalHTML = button ? button.innerHTML : 'Suscribirse';
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => {
                if (!res.ok) throw new Error('Error en la respuesta del servidor');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showPublicToast('success', data.message || '¡Gracias por suscribirte!');
                    if (emailInput) emailInput.value = '';
                } else if (data.already_subscribed) {
                    // Caso especial: correo ya suscrito
                    showPublicToast('info', data.message || 'Este correo ya está suscrito.');
                    if (emailInput) emailInput.value = '';
                } else {
                    showPublicToast('error', data.message || 'Error al suscribirse.');
                }
            })
            .catch(err => {
                console.error(err);
                showPublicToast('error', 'Ocurrió un error al procesar tu suscripción.');
            })
            .finally(() => {
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                }
            });
        });
    });

    // Helper para Toast en sitio público
    function showPublicToast(type, message) {
        let container = document.getElementById('public-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'public-toast-container';
            container.style.cssText = 'position: fixed; bottom: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;';
            document.body.appendChild(container);
        }
        
        // Definir colores según el tipo
        let bgGradient, iconClass;
        switch(type) {
            case 'success':
                bgGradient = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                iconClass = 'fa-solid fa-circle-check';
                break;
            case 'info':
                bgGradient = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
                iconClass = 'fa-solid fa-circle-info';
                break;
            case 'warning':
                bgGradient = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
                iconClass = 'fa-solid fa-triangle-exclamation';
                break;
            case 'error':
            default:
                bgGradient = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                iconClass = 'fa-solid fa-circle-exclamation';
                break;
        }
        
        const toast = document.createElement('div');
        toast.style.cssText = `
            background: ${bgGradient};
            color: white;
            padding: 14px 20px;
            border-radius: 12px;
            font-family: "Poppins", sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: auto;
            max-width: 400px;
        `;
        const icon = document.createElement('i');
        icon.className = iconClass;
        const text = document.createElement('span');
        text.textContent = message;
        toast.appendChild(icon);
        toast.appendChild(text);
        container.appendChild(toast);
        requestAnimationFrame(() => {
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
        });
        setTimeout(() => {
            toast.style.transform = 'translateY(-20px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        }, 4500);
    }

    // G. ENLACES ACTIVOS EN MENÚS (Header, Menú móvil, Menú Fullscreen)
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link, .mobile-link, .menu-link').forEach(link => {
        const href = link.getAttribute('href');
        link.classList.remove('active');
        if (href === currentPath || (currentPath === '/' && href === '/')) {
            link.classList.add('active');
        }
    });

    // H. IMÁGENES LAZY LOADING
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // I. RE-INICIALIZAR ANIMACIONES AOS
    if (window.AOS) {
        window.AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });
    }

    // J. CAROUSEL CINEMATOGRÁFICO Y FILTRADO INTERACTIVO
    const slider = document.getElementById('cuProjectsSlider');
    const prevBtn = document.getElementById('cuSliderPrev');
    const nextBtn = document.getElementById('cuSliderNext');
    const progressFill = document.getElementById('cuSliderProgressFill');

    if (slider) {
        // A. Botones Prev/Next
        const updateButtonsState = () => {
            if (prevBtn) prevBtn.disabled = slider.scrollLeft <= 5;
            if (nextBtn) nextBtn.disabled = slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 5);
        };

        const getScrollAmount = () => {
            const card = slider.querySelector('.cu-project-slider-card');
            const cardWidth = card ? card.offsetWidth : 340;
            const gap = parseInt(window.getComputedStyle(slider).gap) || 24;
            return cardWidth + gap;
        };

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
            });
        }

        // B. Barra de Progreso y control de botones
        const updateProgress = () => {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            const percent = maxScroll > 0 ? (slider.scrollLeft / maxScroll) * 100 : 0;
            if (progressFill) {
                progressFill.style.width = percent + '%';
            }
            updateButtonsState();
        };

        slider.addEventListener('scroll', updateProgress, { passive: true });
        
        // Recalcular en caso de redimensionamiento de pantalla
        window.addEventListener('resize', updateProgress, { passive: true });

        // Inicializar estado después de que el DOM y CSS se asienten
        setTimeout(updateProgress, 100);

        // C. Integración con Filtros
        const filterBtns = document.querySelectorAll('.cu-filter-btn');
        const projectCards = document.querySelectorAll('.cu-project-slider-card');

        // Comparador inteligente de categorías (soporta mapeo multilenguaje y substrings)
        const categoryMatches = (cardCategory, filter) => {
            if (filter === 'all') return true;
            
            const cat = cardCategory.toLowerCase().trim();
            const filt = filter.toLowerCase().trim();
            
            if (cat === filt) return true;
            
            // Mapeos específicos
            if (filt === 'web' && (cat.includes('web') || cat.includes('desarrollo') || cat.includes('software') || cat.includes('programacion'))) return true;
            if (filt === 'design' && (cat.includes('diseño') || cat.includes('design') || cat.includes('ux') || cat.includes('ui'))) return true;
            if (filt === 'ecommerce' && (cat.includes('ecommerce') || cat.includes('e-commerce') || cat.includes('tienda') || cat.includes('commerce'))) return true;
            if (filt === 'branding' && (cat.includes('branding') || cat.includes('marca') || cat.includes('identidad'))) return true;
            if (filt === 'marketing' && (cat.includes('marketing') || cat.includes('campaña') || cat.includes('publicidad') || cat.includes('ads'))) return true;
            
            return false;
        };

        if (filterBtns.length > 0 && projectCards.length > 0) {
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    // Actualizar botones de filtro activos
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Desplazar carrusel al inicio suavemente
                    slider.scrollTo({ left: 0, behavior: 'smooth' });

                    let visibleIndex = 0;
                    
                    projectCards.forEach((card) => {
                        const category = card.getAttribute('data-category') || '';
                        const shouldShow = categoryMatches(category, filter);
                        
                        if (shouldShow) {
                            // Limpiar animaciones previas
                            card.classList.remove('filtering-out', 'filtering-in');
                            card.style.display = 'flex';
                            card.style.animationDelay = `${visibleIndex * 0.08}s`;
                            
                            // Forzar reflow para reiniciar animación
                            void card.offsetWidth;
                            
                            card.classList.add('filtering-in');
                            
                            visibleIndex++;
                        } else {
                            card.classList.remove('filtering-in');
                            card.classList.add('filtering-out');
                            
                            // Esperar a que termine la animación de salida para ocultar
                            setTimeout(() => {
                                if (card.classList.contains('filtering-out')) {
                                    card.style.display = 'none';
                                    card.classList.remove('filtering-out');
                                }
                            }, 400);
                        }
                    });

                    // Recalcular barra de progreso una vez que los elementos cambian de display
                    setTimeout(updateProgress, 450);
                });
            });
        }
    }
}

// Registrar eventos de inicialización en DOMContentLoaded y en turbo:load
document.addEventListener('DOMContentLoaded', initRedesign);
document.addEventListener('turbo:load', initRedesign);

// =========================================================================
// 3. UTILIDADES GLOBALES
// =========================================================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function animateCounter(element, target, duration = 2000) {
    const start = parseInt(element.textContent) || 0;
    const increment = (target - start) / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= target) || (increment < 0 && current <= target)) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

window.CreativeUpUtils = {
    debounce,
    throttle,
    isInViewport,
    animateCounter
};
