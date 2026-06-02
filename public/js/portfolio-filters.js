// ========== PORTFOLIO FILTERS CON ANIMACIONES ==========
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.cu-filter-btn');
    const projectCards = document.querySelectorAll('.cu-project-card');

    if (filterBtns.length === 0 || projectCards.length === 0) return;

    // Add fadeOut animation dynamically
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
        }
    `;
    document.head.appendChild(style);

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button with animation
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter projects with staggered animation
            let visibleIndex = 0;
            
            projectCards.forEach((card) => {
                const category = card.getAttribute('data-category');
                const shouldShow = filter === 'all' || category === filter;
                
                if (shouldShow) {
                    // Show card with fade in animation
                    card.style.display = 'block';
                    card.style.animation = 'none';
                    
                    setTimeout(() => {
                        card.style.animation = `fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) ${visibleIndex * 0.1}s backwards`;
                    }, 10);
                    
                    visibleIndex++;
                } else {
                    // Hide card with fade out animation
                    card.style.animation = 'fadeOut 0.4s ease-out forwards';
                    
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 400);
                }
            });
        });
    });

    // Add hover effect to project cards
    projectCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });
});
