/**
 * CREATIVEUP - HOME REDESIGN JAVASCRIPT
 * Animaciones y funcionalidad específica del home
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========== TYPING EFFECT ==========
    const typingText = document.getElementById('typingText');
    
    if (typingText) {
        const words = ['ideas', 'marcas', 'negocios', 'proyectos', 'sueños'];
        let wordIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        function type() {
            const currentWord = words[wordIndex];
            
            if (isDeleting) {
                typingText.textContent = currentWord.substring(0, charIndex - 1);
                charIndex--;
            } else {
                typingText.textContent = currentWord.substring(0, charIndex + 1);
                charIndex++;
            }

            let typeSpeed = isDeleting ? 50 : 100;

            if (!isDeleting && charIndex === currentWord.length) {
                isDeleting = true;
                typeSpeed = 2000; // Pause at end
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                wordIndex = (wordIndex + 1) % words.length;
                typeSpeed = 500; // Pause before next word
            }

            setTimeout(type, typeSpeed);
        }

        // Start typing after a delay
        setTimeout(type, 1000);
    }

    // ========== 3D CARD EFFECT ==========
    const heroCard = document.getElementById('heroCard');
    
    if (heroCard) {
        const cardInner = heroCard.querySelector('.card-inner');
        
        heroCard.addEventListener('mousemove', (e) => {
            const rect = heroCard.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            if (cardInner) {
                cardInner.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            }
        });
        
        heroCard.addEventListener('mouseleave', () => {
            if (cardInner) {
                cardInner.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
            }
        });
    }

    // ========== ANIMATED COUNTERS ==========
    const counters = document.querySelectorAll('[data-count]');
    
    if (counters.length > 0) {
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const target = parseInt(element.dataset.count);
                    const duration = 2000;
                    const start = performance.now();
                    
                    function updateCounter(currentTime) {
                        const elapsed = currentTime - start;
                        const progress = Math.min(elapsed / duration, 1);
                        
                        // Easing function (ease-out cubic)
                        const easeOut = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(easeOut * target);
                        
                        element.textContent = current;
                        
                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            element.textContent = target;
                        }
                    }
                    
                    requestAnimationFrame(updateCounter);
                    counterObserver.unobserve(element);
                }
            });
        }, observerOptions);

        counters.forEach(counter => counterObserver.observe(counter));
    }

    // ========== BENTO CARD HOVER EFFECT ==========
    const bentoCards = document.querySelectorAll('.bento-card');
    
    bentoCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    });

    // ========== MASONRY GRID LAYOUT ==========
    const masonryGrid = document.querySelector('.masonry-grid');
    
    if (masonryGrid && window.innerWidth > 768) {
        function resizeMasonryItem(item) {
            const grid = masonryGrid;
            const rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
            const rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
            const rowSpan = Math.ceil((item.querySelector('.project-card').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
            item.style.gridRowEnd = 'span ' + rowSpan;
        }

        function resizeAllMasonryItems() {
            const items = masonryGrid.querySelectorAll('.masonry-item');
            items.forEach(item => resizeMasonryItem(item));
        }

        // Resize on load and window resize
        window.addEventListener('load', resizeAllMasonryItems);
        window.addEventListener('resize', window.CreativeUpUtils.debounce(resizeAllMasonryItems, 250));
        
        // Resize after images load
        const images = masonryGrid.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('load', resizeAllMasonryItems);
        });
    }

    // ========== PROJECT CARD HOVER ==========
    const projectCards = document.querySelectorAll('.project-card');
    
    projectCards.forEach(card => {
        const overlay = card.querySelector('.project-overlay');
        
        if (overlay) {
            card.addEventListener('mouseenter', () => {
                overlay.style.opacity = '1';
            });
            
            card.addEventListener('mouseleave', () => {
                overlay.style.opacity = '0';
            });
        }
    });

    // ========== BLOG CARD HOVER ==========
    const blogCards = document.querySelectorAll('.blog-card-modern');
    
    blogCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

    // ========== FLOATING STATS ANIMATION ==========
    const floatingStats = document.querySelectorAll('.floating-stat');
    
    floatingStats.forEach((stat, index) => {
        // Random float animation
        const randomDelay = Math.random() * 2;
        const randomDuration = 3 + Math.random() * 2;
        
        stat.style.animationDelay = `${randomDelay}s`;
        stat.style.animationDuration = `${randomDuration}s`;
    });

    // ========== GRADIENT ORBS ANIMATION ==========
    const gradientOrbs = document.querySelectorAll('.hero-gradient-orb, .cta-gradient-orb, .footer-gradient-orb');
    
    gradientOrbs.forEach((orb, index) => {
        // Random movement
        const randomX = Math.random() * 100 - 50;
        const randomY = Math.random() * 100 - 50;
        const randomDuration = 8 + Math.random() * 4;
        
        orb.style.setProperty('--random-x', `${randomX}px`);
        orb.style.setProperty('--random-y', `${randomY}px`);
        orb.style.animationDuration = `${randomDuration}s`;
    });

    // ========== SCROLL REVEAL ANIMATION ==========
    const revealElements = document.querySelectorAll('[data-reveal]');
    
    if (revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(element => revealObserver.observe(element));
    }

    // ========== PARALLAX SCROLL ==========
    const parallaxElements = document.querySelectorAll('[data-parallax-speed]');
    
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.parallaxSpeed) || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        }, { passive: true });
    }

    // ========== EXPERTISE CARD ACTIVE STATE ==========
    const expertiseCards = document.querySelectorAll('.expertise-card');
    
    expertiseCards.forEach(card => {
        card.addEventListener('click', () => {
            expertiseCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
        });
    });

    // ========== SMOOTH SCROLL PROGRESS ==========
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366F1, #EC4899);
        z-index: 9999;
        transition: width 0.1s ease-out;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (window.pageYOffset / windowHeight) * 100;
        progressBar.style.width = scrolled + '%';
    }, { passive: true });

    // ========== LAZY LOAD BACKGROUND IMAGES ==========
    const lazyBackgrounds = document.querySelectorAll('[data-bg]');
    
    if (lazyBackgrounds.length > 0) {
        const bgObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const bgUrl = element.dataset.bg;
                    element.style.backgroundImage = `url(${bgUrl})`;
                    element.removeAttribute('data-bg');
                    bgObserver.unobserve(element);
                }
            });
        });

        lazyBackgrounds.forEach(element => bgObserver.observe(element));
    }

    // ========== CURSOR TRAIL EFFECT (Optional) ==========
    let cursorTrail = [];
    const trailLength = 10;

    document.addEventListener('mousemove', (e) => {
        cursorTrail.push({ x: e.clientX, y: e.clientY });
        
        if (cursorTrail.length > trailLength) {
            cursorTrail.shift();
        }
    });

    // ========== EASTER EGG: KONAMI CODE ==========
    const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
    let konamiIndex = 0;

    document.addEventListener('keydown', (e) => {
        if (e.key === konamiCode[konamiIndex]) {
            konamiIndex++;
            if (konamiIndex === konamiCode.length) {
                activateEasterEgg();
                konamiIndex = 0;
            }
        } else {
            konamiIndex = 0;
        }
    });

    function activateEasterEgg() {
        console.log('🎉 ¡Easter Egg Activado!');
        document.body.style.animation = 'rainbow 2s linear infinite';
        
        setTimeout(() => {
            document.body.style.animation = '';
        }, 5000);
    }

    // ========== PERFORMANCE MONITORING ==========
    if (window.performance) {
        window.addEventListener('load', () => {
            const perfData = window.performance.timing;
            const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log(`⚡ Página cargada en ${pageLoadTime}ms`);
        });
    }

    // ========== CONSOLE ART ==========
    console.log(`
    ╔═══════════════════════════════════════╗
    ║                                       ║
    ║     🚀 CREATIVEUP REDESIGN 2.0       ║
    ║                                       ║
    ║     Diseño Ultra Moderno              ║
    ║     Animaciones Premium               ║
    ║     Performance Optimizado            ║
    ║                                       ║
    ╚═══════════════════════════════════════╝
    `);
});

// ========== EXPORT FUNCTIONS ==========
window.HomeRedesign = {
    // Add any functions you want to expose globally
};
