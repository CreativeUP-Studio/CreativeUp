import "./bootstrap";

// Animaciones de entrada estilo AOS - todas al mismo tiempo
document.addEventListener("DOMContentLoaded", () => {
    const topbar = document.querySelector(".topbar");

    // Activar animaciones iniciales (solo las que no son de scroll)
    const animElements = document.querySelectorAll(
        "[data-anim]:not(.anim-scroll)",
    );
    animElements.forEach((el) => {
        el.classList.remove("anim-hidden");
    });

    // Los puntos aparecen con pop individual
    const dots = document.querySelector(".topbar-dots");
    if (dots) {
        const dotEls = dots.querySelectorAll(".dot");
        dotEls.forEach((dot, i) => {
            dot.classList.add("dot-hidden");
            setTimeout(
                () => {
                    dot.classList.add("anim-dot-pop");
                    dot.addEventListener(
                        "animationend",
                        () => {
                            dot.classList.remove("dot-hidden", "anim-dot-pop");
                        },
                        { once: true },
                    );
                },
                200 + i * 60,
            );
        });
    }

    // Topbar scroll animation
    if (!topbar) return;

    const threshold = 80;

    window.addEventListener(
        "scroll",
        () => {
            const currentScroll = window.scrollY;

            if (currentScroll > threshold) {
                topbar.classList.add("scrolled");
            } else {
                topbar.classList.remove("scrolled");
            }
        },
        { passive: true },
    );

    // Animaciones activadas por scroll (IntersectionObserver)
    const scrollElements = document.querySelectorAll(".anim-scroll");
    if (scrollElements.length) {
        const scrollObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove("anim-scroll");
                        scrollObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15 },
        );
        scrollElements.forEach((el) => scrollObserver.observe(el));
    }

    // Fullscreen Menu toggle
    const dotsBtn = document.querySelector(".topbar-dots");
    const fullMenu = document.getElementById("fullscreenMenu");
    const menuCloseBtn = document.getElementById("menuCloseBtn");

    function closeMenu() {
        fullMenu.classList.remove("active");
        dotsBtn.classList.remove("menu-open");
        topbar.classList.remove("menu-open");
        document.body.style.overflow = "";
    }

    function openMenu() {
        fullMenu.classList.add("active");
        dotsBtn.classList.add("menu-open");
        topbar.classList.add("menu-open");
        document.body.style.overflow = "hidden";

        // Marcar página activa
        const currentPath = window.location.pathname;
        const menuItems = document.querySelectorAll(".menu-link-item");
        menuItems.forEach((item) => {
            const link = item.querySelector(".menu-link");
            const href = link.getAttribute("href");
            item.classList.remove("active");

            if (currentPath === href ||
                (currentPath === "/" && href === "/") ||
                (currentPath.startsWith(href) && href !== "/")) {
                item.classList.add("active");
            }
        });
    }

    if (dotsBtn && fullMenu) {
        dotsBtn.addEventListener("click", () => {
            if (fullMenu.classList.contains("active")) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Botón de cerrar del menú
        if (menuCloseBtn) {
            menuCloseBtn.addEventListener("click", closeMenu);
        }

        // Cerrar con Escape
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && fullMenu.classList.contains("active")) {
                closeMenu();
            }
        });

        // Cerrar al hacer click en el overlay
        const overlay = fullMenu.querySelector(".menu-overlay");
        if (overlay) {
            overlay.addEventListener("click", closeMenu);
        }
    }

    // ═══ SERVICES PAGE — Counter Animation & Process Timeline ═══

    // Animated counter for stats
    const statNumbers = document.querySelectorAll(
        ".svc-stat-number[data-count]",
    );
    if (statNumbers.length) {
        const counterObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.dataset.count, 10);
                        const duration = 2000;
                        const start = performance.now();

                        function step(now) {
                            const elapsed = now - start;
                            const progress = Math.min(elapsed / duration, 1);
                            const eased = 1 - Math.pow(1 - progress, 3);
                            el.textContent = Math.round(target * eased);
                            if (progress < 1) requestAnimationFrame(step);
                        }

                        requestAnimationFrame(step);
                        counterObserver.unobserve(el);
                    }
                });
            },
            { threshold: 0.5 },
        );
        statNumbers.forEach((el) => counterObserver.observe(el));
    }

    // Process timeline — activate steps and fill line on scroll
    const processSteps = document.querySelectorAll(".svc-process-step");
    const processLineFill = document.getElementById("svcProcessLineFill");

    if (processSteps.length && processLineFill) {
        const stepObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-active");

                        // Calculate fill percentage
                        const activeCount = document.querySelectorAll(
                            ".svc-process-step.is-active",
                        ).length;
                        const total = processSteps.length;
                        const percent = (activeCount / total) * 100;
                        processLineFill.style.width = percent + "%";
                    }
                });
            },
            { threshold: 0.4 },
        );
        processSteps.forEach((step) => stepObserver.observe(step));
    }

    // ═══ SERVICES SHOW PAGE — Lightbox ═══
    const lightbox = document.getElementById("svcLightbox");
    if (lightbox) {
        const galleryItems = document.querySelectorAll(
            ".svc-show-gallery-item img",
        );
        const lightboxImg = document.getElementById("svcLightboxImg");
        const lightboxCounter = document.getElementById("svcLightboxCounter");
        const lightboxClose = document.getElementById("svcLightboxClose");
        const lightboxPrev = document.getElementById("svcLightboxPrev");
        const lightboxNext = document.getElementById("svcLightboxNext");

        let currentIdx = 0;
        const images = Array.from(galleryItems).map((img) => img.src);

        function showImage(idx) {
            currentIdx = idx;
            lightboxImg.src = images[idx];
            lightboxImg.alt = "Imagen " + (idx + 1);
            lightboxCounter.textContent = idx + 1 + " / " + images.length;
        }

        function openLightbox(idx) {
            showImage(idx);
            lightbox.classList.add("active");
            document.body.style.overflow = "hidden";
        }

        function closeLightbox() {
            lightbox.classList.remove("active");
            document.body.style.overflow = "";
        }

        galleryItems.forEach((img) => {
            img.addEventListener("click", () => {
                const idx = parseInt(img.dataset.galleryIdx, 10);
                openLightbox(idx);
            });
        });

        // Also clicking overlay area
        document
            .querySelectorAll(".svc-show-gallery-item-overlay")
            .forEach((ov) => {
                ov.addEventListener("click", () => {
                    const img = ov.parentElement.querySelector("img");
                    const idx = parseInt(img.dataset.galleryIdx, 10);
                    openLightbox(idx);
                });
            });

        lightboxClose.addEventListener("click", closeLightbox);
        lightboxPrev.addEventListener("click", () => {
            showImage((currentIdx - 1 + images.length) % images.length);
        });
        lightboxNext.addEventListener("click", () => {
            showImage((currentIdx + 1) % images.length);
        });

        lightbox.addEventListener("click", (e) => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener("keydown", (e) => {
            if (!lightbox.classList.contains("active")) return;
            if (e.key === "Escape") closeLightbox();
            if (e.key === "ArrowLeft")
                showImage((currentIdx - 1 + images.length) % images.length);
            if (e.key === "ArrowRight")
                showImage((currentIdx + 1) % images.length);
        });
    }

    // Smooth scroll for anchor links on services page
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", (e) => {
            const target = document.querySelector(anchor.getAttribute("href"));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });
});
