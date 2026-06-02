/* ============================================
   NAVBAR PREMIUM - JavaScript Functionality
   ============================================ */

class NavbarPremium {
    constructor() {
        this.navbar = document.querySelector('.navbar-premium');
        this.searchBtn = document.querySelector('.navbar-search-btn');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.searchClose = document.querySelector('.search-close');
        this.searchInput = document.querySelector('.search-input');
        this.mobileToggle = document.querySelector('.navbar-mobile-toggle');
        this.mobileMenu = document.querySelector('.mobile-menu-overlay');
        this.mobileClose = document.querySelector('.mobile-menu-close');
        this.progressBar = document.querySelector('.navbar-progress');
        
        this.lastScrollTop = 0;
        this.scrollThreshold = 100;
        
        this.init();
    }

    init() {
        this.handleScroll();
        this.handleSearch();
        this.handleMobileMenu();
        this.handleProgressBar();
        this.handleKeyboardShortcuts();
        this.handleNotifications();
    }

    // ── Scroll Behavior ──
    handleScroll() {
        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    this.onScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    onScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Add scrolled class
        if (scrollTop > 50) {
            this.navbar.classList.add('scrolled');
        } else {
            this.navbar.classList.remove('scrolled');
        }

        // Hide/show navbar on scroll
        if (scrollTop > this.lastScrollTop && scrollTop > this.scrollThreshold) {
            // Scrolling down
            this.navbar.classList.add('hidden');
        } else {
            // Scrolling up
            this.navbar.classList.remove('hidden');
        }

        this.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }

    // ── Search Functionality ──
    handleSearch() {
        if (!this.searchBtn || !this.searchOverlay) return;

        // Open search
        this.searchBtn.addEventListener('click', () => {
            this.openSearch();
        });

        // Close search
        this.searchClose?.addEventListener('click', () => {
            this.closeSearch();
        });

        // Close on overlay click
        this.searchOverlay.addEventListener('click', (e) => {
            if (e.target === this.searchOverlay) {
                this.closeSearch();
            }
        });

        // Handle search input
        this.searchInput?.addEventListener('input', (e) => {
            this.handleSearchInput(e.target.value);
        });

        // Handle search submit
        this.searchInput?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.performSearch(e.target.value);
            }
        });
    }

    openSearch() {
        this.searchOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Focus input after animation
        setTimeout(() => {
            this.searchInput?.focus();
        }, 400);
    }

    closeSearch() {
        this.searchOverlay.classList.remove('active');
        document.body.style.overflow = '';
        this.searchInput.value = '';
    }

    handleSearchInput(value) {
        // Debounce search
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            if (value.length >= 3) {
                this.liveSearch(value);
            }
        }, 300);
    }

    liveSearch(query) {
        // Implement live search functionality
        console.log('Searching for:', query);
        // You can make an AJAX call here to search your content
    }

    performSearch(query) {
        if (query.trim()) {
            // Redirect to search results page or handle search
            window.location.href = `/search?q=${encodeURIComponent(query)}`;
        }
    }

    // ── Mobile Menu ──
    handleMobileMenu() {
        if (!this.mobileToggle || !this.mobileMenu) return;

        // Open mobile menu
        this.mobileToggle.addEventListener('click', () => {
            this.toggleMobileMenu();
        });

        // Close mobile menu
        this.mobileClose?.addEventListener('click', () => {
            this.closeMobileMenu();
        });

        // Close on overlay click
        this.mobileMenu.addEventListener('click', (e) => {
            if (e.target === this.mobileMenu) {
                this.closeMobileMenu();
            }
        });

        // Close on link click
        const mobileLinks = this.mobileMenu.querySelectorAll('.mobile-nav-link');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.closeMobileMenu();
            });
        });
    }

    toggleMobileMenu() {
        this.mobileToggle.classList.toggle('active');
        this.mobileMenu.classList.toggle('active');
        document.body.style.overflow = this.mobileMenu.classList.contains('active') ? 'hidden' : '';
    }

    closeMobileMenu() {
        this.mobileToggle.classList.remove('active');
        this.mobileMenu.classList.remove('active');
        document.body.style.overflow = '';
    }

    // ── Progress Bar ──
    handleProgressBar() {
        if (!this.progressBar) return;

        window.addEventListener('scroll', () => {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.pageYOffset / windowHeight);
            this.progressBar.style.transform = `scaleX(${scrolled})`;
        });
    }

    // ── Keyboard Shortcuts ──
    handleKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Cmd/Ctrl + K to open search
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                this.openSearch();
            }

            // Escape to close overlays
            if (e.key === 'Escape') {
                if (this.searchOverlay.classList.contains('active')) {
                    this.closeSearch();
                }
                if (this.mobileMenu.classList.contains('active')) {
                    this.closeMobileMenu();
                }
            }
        });
    }

    // ── Notifications ──
    handleNotifications() {
        const notificationBtn = document.querySelector('.navbar-notification-btn');
        if (!notificationBtn) return;

        notificationBtn.addEventListener('click', () => {
            this.showNotifications();
        });
    }

    showNotifications() {
        // Implement notification panel
        console.log('Show notifications');
        // You can create a dropdown panel here
    }
}

// ── Smooth Scroll for Anchor Links ──
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const navbarHeight = document.querySelector('.navbar-premium')?.offsetHeight || 0;
                const targetPosition = target.offsetTop - navbarHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ── Active Link Highlighting ──
function updateActiveLink() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link-premium');

    window.addEventListener('scroll', () => {
        let current = '';
        const navbarHeight = document.querySelector('.navbar-premium')?.offsetHeight || 0;

        sections.forEach(section => {
            const sectionTop = section.offsetTop - navbarHeight - 100;
            const sectionHeight = section.offsetHeight;
            
            if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
}

// ── Mega Menu Hover Effect ──
function initMegaMenu() {
    const navLinks = document.querySelectorAll('.nav-link-premium');
    
    navLinks.forEach(link => {
        const megaMenu = link.querySelector('.mega-menu');
        if (!megaMenu) return;

        let timeout;

        link.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
            megaMenu.style.display = 'block';
        });

        link.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                megaMenu.style.display = 'none';
            }, 300);
        });

        megaMenu.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
        });

        megaMenu.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                megaMenu.style.display = 'none';
            }, 300);
        });
    });
}

// ── Logo Animation on Hover ──
function initLogoAnimation() {
    const logo = document.querySelector('.navbar-logo-premium');
    if (!logo) return;

    logo.addEventListener('mouseenter', () => {
        const icon = logo.querySelector('.logo-icon');
        if (icon) {
            icon.style.transform = 'rotate(360deg)';
        }
    });

    logo.addEventListener('mouseleave', () => {
        const icon = logo.querySelector('.logo-icon');
        if (icon) {
            icon.style.transform = 'rotate(0deg)';
        }
    });
}

// ── Initialize Everything ──
document.addEventListener('DOMContentLoaded', () => {
    // Initialize navbar
    new NavbarPremium();

    // Initialize other features
    initSmoothScroll();
    updateActiveLink();
    initMegaMenu();
    initLogoAnimation();

    // Add loading animation
    setTimeout(() => {
        document.querySelector('.navbar-premium')?.classList.add('loaded');
    }, 100);
});

// ── Handle Window Resize ──
let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        // Close mobile menu on desktop
        if (window.innerWidth > 1024) {
            const mobileMenu = document.querySelector('.mobile-menu-overlay');
            const mobileToggle = document.querySelector('.navbar-mobile-toggle');
            
            if (mobileMenu?.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                mobileToggle?.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    }, 250);
});

// ── Export for use in other scripts ──
window.NavbarPremium = NavbarPremium;
