/**
 * ╔══════════════════════════════════════════════════════════════════════════════╗
 * ║                    CREATIVEUP - AJAX FILTERS & SEARCH                        ║
 * ║                    Universal filtering without page reload                    ║
 * ╚══════════════════════════════════════════════════════════════════════════════╝
 */

(function() {
    'use strict';

    // ═══════════════════════════════════════════════════════════════════════════
    // CONFIGURATION
    // ═══════════════════════════════════════════════════════════════════════════
    const CONFIG = {
        debounceDelay: 300,
        animationDuration: 300,
        loadingClass: 'is-loading',
        fadeClass: 'is-fading',
        activeClass: 'active',
        selectors: {
            // Containers that will be updated
            resultsContainer: '[data-ajax-results]',
            paginationContainer: '[data-ajax-pagination]',
            statsContainer: '[data-ajax-stats]',
            
            // Filter elements
            filterForm: '[data-ajax-filter]',
            filterInput: '[data-filter-input]',
            filterSelect: '[data-filter-select]',
            filterButton: '[data-filter-button]',
            filterClear: '[data-filter-clear]',
            
            // Search
            searchInput: '[data-search-input]',
            
            // Pagination
            paginationLink: '[data-ajax-pagination] a',
        }
    };

    // ═══════════════════════════════════════════════════════════════════════════
    // UTILITIES
    // ═══════════════════════════════════════════════════════════════════════════
    
    /**
     * Debounce function to limit rapid calls
     */
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

    /**
     * Update URL without page reload
     */
    function updateURL(params) {
        const url = new URL(window.location.href);
        
        // Clear existing search params
        url.search = '';
        
        // Add new params (only non-empty values)
        Object.entries(params).forEach(([key, value]) => {
            if (value && value !== '') {
                url.searchParams.set(key, value);
            }
        });
        
        window.history.pushState({}, '', url.toString());
    }

    /**
     * Get current filter params from URL
     */
    function getURLParams() {
        const params = {};
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.forEach((value, key) => {
            params[key] = value;
        });
        return params;
    }

    /**
     * Serialize form data to object
     */
    function serializeForm(form) {
        const formData = new FormData(form);
        const params = {};
        formData.forEach((value, key) => {
            if (value && value !== '') {
                params[key] = value;
            }
        });
        return params;
    }

    /**
     * Create loading overlay
     */
    function createLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'ajax-loading-overlay';
        overlay.innerHTML = `
            <div class="ajax-loading-spinner">
                <div class="spinner-ring"></div>
            </div>
        `;
        return overlay;
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // AJAX FILTER CLASS
    // ═══════════════════════════════════════════════════════════════════════════
    
    class AjaxFilter {
        constructor(container) {
            this.container = container;
            this.form = container.querySelector(CONFIG.selectors.filterForm) || container;
            this.resultsContainer = document.querySelector(CONFIG.selectors.resultsContainer);
            this.paginationContainer = document.querySelector(CONFIG.selectors.paginationContainer);
            this.statsContainer = document.querySelector(CONFIG.selectors.statsContainer);
            this.baseUrl = this.form.action || window.location.pathname;
            this.isLoading = false;
            
            this.init();
        }

        init() {
            this.bindEvents();
            this.handlePopState();
        }

        bindEvents() {
            // Text/Search inputs with debounce
            const searchInputs = this.container.querySelectorAll(`${CONFIG.selectors.searchInput}, ${CONFIG.selectors.filterInput}[type="text"], ${CONFIG.selectors.filterInput}[type="search"]`);
            searchInputs.forEach(input => {
                input.addEventListener('input', debounce(() => this.handleFilterChange(), CONFIG.debounceDelay));
                input.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.handleFilterChange();
                    }
                });
            });

            // Select dropdowns - immediate change
            const selects = this.container.querySelectorAll(CONFIG.selectors.filterSelect);
            selects.forEach(select => {
                select.addEventListener('change', () => this.handleFilterChange());
            });

            // Filter buttons (like category tabs)
            const filterButtons = this.container.querySelectorAll(CONFIG.selectors.filterButton);
            filterButtons.forEach(button => {
                button.addEventListener('click', (e) => this.handleFilterButtonClick(e));
            });

            // Clear filters button
            const clearButtons = this.container.querySelectorAll(CONFIG.selectors.filterClear);
            clearButtons.forEach(button => {
                button.addEventListener('click', (e) => this.handleClearFilters(e));
            });

            // Form submit prevention
            if (this.form.tagName === 'FORM') {
                this.form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleFilterChange();
                });
            }

            // Pagination links (delegated)
            document.addEventListener('click', (e) => {
                const paginationLink = e.target.closest(CONFIG.selectors.paginationLink);
                if (paginationLink && !paginationLink.classList.contains('disabled')) {
                    e.preventDefault();
                    this.handlePaginationClick(paginationLink);
                }
            });
        }

        handlePopState() {
            window.addEventListener('popstate', () => {
                this.loadResults(getURLParams(), false);
            });
        }

        handleFilterChange() {
            const params = this.collectFilterParams();
            // Reset to page 1 when filters change
            delete params.page;
            this.loadResults(params);
        }

        handleFilterButtonClick(e) {
            e.preventDefault();
            const button = e.currentTarget;
            const filterKey = button.dataset.filterKey || 'category';
            const filterValue = button.dataset.filterValue || '';

            // Update active state
            const siblings = button.parentElement.querySelectorAll(CONFIG.selectors.filterButton);
            siblings.forEach(b => b.classList.remove(CONFIG.activeClass, 'is-active'));
            button.classList.add(CONFIG.activeClass, 'is-active');

            // Collect params and update
            const params = this.collectFilterParams();
            if (filterValue) {
                params[filterKey] = filterValue;
            } else {
                delete params[filterKey];
            }
            delete params.page;
            
            this.loadResults(params);
        }

        handleClearFilters(e) {
            e.preventDefault();
            
            // Reset all form inputs
            const inputs = this.container.querySelectorAll('input[type="text"], input[type="search"]');
            inputs.forEach(input => input.value = '');
            
            const selects = this.container.querySelectorAll('select');
            selects.forEach(select => select.selectedIndex = 0);

            // Reset filter buttons
            const filterButtons = this.container.querySelectorAll(CONFIG.selectors.filterButton);
            filterButtons.forEach((b, i) => {
                b.classList.toggle(CONFIG.activeClass, i === 0);
                b.classList.toggle('is-active', i === 0);
            });
            
            this.loadResults({});
        }

        handlePaginationClick(link) {
            const url = new URL(link.href);
            const page = url.searchParams.get('page');
            
            if (page) {
                const params = this.collectFilterParams();
                params.page = page;
                this.loadResults(params);
                
                // Scroll to results
                if (this.resultsContainer) {
                    const offset = this.resultsContainer.getBoundingClientRect().top + window.scrollY - 100;
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            }
        }

        collectFilterParams() {
            const params = {};
            
            // From form inputs
            if (this.form.tagName === 'FORM') {
                Object.assign(params, serializeForm(this.form));
            }
            
            // From filter inputs
            const inputs = this.container.querySelectorAll(`${CONFIG.selectors.filterInput}, ${CONFIG.selectors.searchInput}`);
            inputs.forEach(input => {
                if (input.name && input.value) {
                    params[input.name] = input.value;
                }
            });
            
            // From selects
            const selects = this.container.querySelectorAll(CONFIG.selectors.filterSelect);
            selects.forEach(select => {
                if (select.name && select.value) {
                    params[select.name] = select.value;
                }
            });

            // From active filter buttons
            const activeButton = this.container.querySelector(`${CONFIG.selectors.filterButton}.${CONFIG.activeClass}, ${CONFIG.selectors.filterButton}.is-active`);
            if (activeButton && activeButton.dataset.filterValue) {
                const key = activeButton.dataset.filterKey || 'category';
                params[key] = activeButton.dataset.filterValue;
            }

            return params;
        }

        async loadResults(params, updateHistory = true) {
            if (this.isLoading) return;
            
            this.isLoading = true;
            this.showLoading();

            try {
                // Build URL
                const url = new URL(this.baseUrl, window.location.origin);
                Object.entries(params).forEach(([key, value]) => {
                    if (value) url.searchParams.set(key, value);
                });

                // Make AJAX request
                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                
                // Update DOM
                this.updateResults(data);
                
                // Update URL
                if (updateHistory) {
                    updateURL(params);
                }

            } catch (error) {
                console.error('AJAX Filter Error:', error);
                this.showError();
            } finally {
                this.isLoading = false;
                this.hideLoading();
            }
        }

        updateResults(data) {
            // Update results container
            if (this.resultsContainer && data.html) {
                this.resultsContainer.style.opacity = '0';
                setTimeout(() => {
                    this.resultsContainer.innerHTML = data.html;
                    this.resultsContainer.style.opacity = '1';
                }, CONFIG.animationDuration / 2);
            }

            // Update pagination
            if (this.paginationContainer && data.pagination !== undefined) {
                this.paginationContainer.innerHTML = data.pagination || '';
            }

            // Update stats/counters
            if (this.statsContainer && data.stats) {
                Object.entries(data.stats).forEach(([key, value]) => {
                    const statEl = this.statsContainer.querySelector(`[data-stat="${key}"]`);
                    if (statEl) {
                        statEl.textContent = value;
                    }
                });
            }

            // Update total count if provided
            if (data.total !== undefined) {
                const totalEl = document.querySelector('[data-total-count]');
                if (totalEl) totalEl.textContent = data.total;
            }

            // Trigger custom event for other scripts
            document.dispatchEvent(new CustomEvent('ajaxFilterUpdated', { detail: data }));
        }

        showLoading() {
            if (this.resultsContainer) {
                this.resultsContainer.classList.add(CONFIG.loadingClass);
                
                // Add overlay if not exists
                if (!this.resultsContainer.querySelector('.ajax-loading-overlay')) {
                    this.resultsContainer.style.position = 'relative';
                    this.resultsContainer.appendChild(createLoadingOverlay());
                }
            }
        }

        hideLoading() {
            if (this.resultsContainer) {
                this.resultsContainer.classList.remove(CONFIG.loadingClass);
                const overlay = this.resultsContainer.querySelector('.ajax-loading-overlay');
                if (overlay) {
                    overlay.remove();
                }
            }
        }

        showError() {
            if (this.resultsContainer) {
                // Could show a toast/notification here
                console.error('Error loading results');
            }
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // INITIALIZATION
    // ═══════════════════════════════════════════════════════════════════════════
    
    function initAjaxFilters() {
        // Find all filter containers
        const filterContainers = document.querySelectorAll('[data-ajax-filter]');
        filterContainers.forEach(container => {
            new AjaxFilter(container);
        });

        // Also init standalone filter navs
        const filterNavs = document.querySelectorAll('[data-ajax-nav]');
        filterNavs.forEach(nav => {
            new AjaxFilter(nav);
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAjaxFilters);
    } else {
        initAjaxFilters();
    }

    // Expose for manual initialization
    window.AjaxFilter = AjaxFilter;
    window.initAjaxFilters = initAjaxFilters;

})();
