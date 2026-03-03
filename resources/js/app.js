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
                    // Limpiar después de que termine la animación
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
    }

    if (dotsBtn && fullMenu) {
        dotsBtn.addEventListener("click", () => {
            if (fullMenu.classList.contains("active")) {
                closeMenu();
            } else {
                openMenu();
            }
        });

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

    // Imagen dinámica al hacer hover en links del menú
    const menuLinks = document.querySelectorAll(".menu-link-item");
    const menuImg = document.getElementById("menuBlobImage");
    const menuImgs = [
        "/images/menu/inicio.jpg",
        "/images/menu/servicios.jpg",
        "/images/menu/proyectos.jpg",
        "/images/menu/blog.jpg",
        "/images/menu/contacto.jpg",
    ];
    if (menuImg && menuLinks.length) {
        menuLinks.forEach((link, idx) => {
            link.addEventListener("mouseenter", () => {
                menuImg.style.opacity = "0";
                setTimeout(() => {
                    menuImg.src = menuImgs[idx] || menuImgs[0];
                    menuImg.style.opacity = "1";
                }, 180);
            });
            link.addEventListener("mouseleave", () => {
                menuImg.style.opacity = "1";
                menuImg.src = menuImgs[idx] || menuImgs[0];
            });
        });
    }
});
