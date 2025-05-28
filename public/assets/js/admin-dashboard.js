class AdminDashboard {
    constructor() {
        this.init();
        this.bindEvents();
        this.handleResize();
        this.initializeTheme();
        this.handleActiveMenuItems();
    }

    init() {
        // Cache DOM elements
        this.elements = {
            body: document.body,
            sidebar: document.getElementById('dashboardSidebar'),
            sidebarOverlay: document.getElementById('sidebarOverlay'),
            mobileMenuToggle: document.getElementById('mobileMenuToggle'),
            darkModeToggle: document.getElementById('darkModeToggle'),
            toggleSwitch: document.getElementById('toggleSwitch'),
            headerSearch: document.querySelector('.header-search input'),
            dashboardContent: document.querySelector('.dashboard-content'),
            adminFooter: document.getElementById('adminFooter'),
            menuItems: document.querySelectorAll('.sidebar-menu-item'),
            notifications: document.querySelector('.header-action-item[title="Notifications"]'),
            messages: document.querySelector('.header-action-item[title="Messages"]')
        };

        // State management
        this.state = {
            sidebarCollapsed: this.getSavedState('sidebarCollapsed', false),
            mobileMenuOpen: false,
            darkMode: this.getSavedState('darkMode', false),
            isMobile: window.innerWidth <= 768
        };

        // Apply initial states
        this.applySidebarState();
        this.applyTheme();
    }

    bindEvents() {
        // Sidebar toggle events
        if (this.elements.mobileMenuToggle) {
            this.elements.mobileMenuToggle.addEventListener('click', () => {
                this.toggleMobileMenu();
            });
        }

        // Sidebar overlay
        if (this.elements.sidebarOverlay) {
            this.elements.sidebarOverlay.addEventListener('click', () => {
                this.closeMobileMenu();
            });
        }

        // Dark mode toggle
        if (this.elements.darkModeToggle) {
            this.elements.darkModeToggle.addEventListener('click', () => {
                this.toggleDarkMode();
            });
        }

        // Search functionality
        if (this.elements.headerSearch) {
            this.elements.headerSearch.addEventListener('input', this.debounce((e) => {
                this.handleSearch(e.target.value);
            }, 300));

            this.elements.headerSearch.addEventListener('focus', () => {
                this.showSearchResults();
            });

            this.elements.headerSearch.addEventListener('blur', () => {
                // Delay hiding to allow for clicks on results
                setTimeout(() => this.hideSearchResults(), 150);
            });
        }

        // Window resize
        window.addEventListener('resize', this.debounce(() => {
            this.handleResize();
        }, 250));

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardNavigation(e);
        });

        // Handle menu item clicks
        this.elements.menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                this.handleMenuItemClick(e, item);
            });
        });

        // Handle outside clicks to close dropdowns
        document.addEventListener('click', (e) => {
            this.handleOutsideClick(e);
        });

        // Add arrow toggle button dynamically
        this.addSidebarToggleButton();
    }

    // Sidebar functionality
    // addSidebarToggleButton() {
    //     if (!this.state.isMobile && this.elements.sidebar) {
    //         const toggleButton = document.createElement('button');
    //         toggleButton.className = 'sidebar-arrow-toggle';
    //         toggleButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
    //         toggleButton.setAttribute('title', 'Toggle Sidebar');
            
    //         toggleButton.addEventListener('click', () => {
    //             this.toggleSidebar();
    //         });

    //         this.elements.sidebar.appendChild(toggleButton);
    //     }
    // }

    // toggleSidebar() {
    //     this.state.sidebarCollapsed = !this.state.sidebarCollapsed;
    //     this.applySidebarState();
    //     this.saveState('sidebarCollapsed', this.state.sidebarCollapsed);
    // }

    toggleMobileMenu() {
        this.state.mobileMenuOpen = !this.state.mobileMenuOpen;
        this.applyMobileMenuState();
    }

    closeMobileMenu() {
        this.state.mobileMenuOpen = false;
        this.applyMobileMenuState();
    }

    applySidebarState() {
        if (!this.elements.sidebar) return;

        if (this.state.sidebarCollapsed && !this.state.isMobile) {
            this.elements.sidebar.classList.add('collapsed');
        } else {
            this.elements.sidebar.classList.remove('collapsed');
        }

        // Dispatch custom event for other components
        window.dispatchEvent(new CustomEvent('sidebarToggle', {
            detail: { collapsed: this.state.sidebarCollapsed }
        }));
    }

    applyMobileMenuState() {
        if (!this.elements.sidebar || !this.elements.sidebarOverlay) return;

        if (this.state.mobileMenuOpen) {
            this.elements.sidebar.classList.add('mobile-open');
            this.elements.sidebarOverlay.classList.add('active');
            this.elements.body.classList.add('no-scroll');
        } else {
            this.elements.sidebar.classList.remove('mobile-open');
            this.elements.sidebarOverlay.classList.remove('active');
            this.elements.body.classList.remove('no-scroll');
        }
    }

    // Dark mode functionality
    toggleDarkMode() {
        this.state.darkMode = !this.state.darkMode;
        this.applyTheme();
        this.saveState('darkMode', this.state.darkMode);
    }

    initializeTheme() {
        // Check for system preference if no saved preference
        if (!this.hasState('darkMode')) {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            this.state.darkMode = prefersDark;
        }
        this.applyTheme();
    }

    applyTheme() {
        const root = document.documentElement;
        
        if (this.state.darkMode) {
            root.setAttribute('data-theme', 'dark');
            if (this.elements.toggleSwitch) {
                this.elements.toggleSwitch.classList.add('active');
            }
        } else {
            root.setAttribute('data-theme', 'light');
            if (this.elements.toggleSwitch) {
                this.elements.toggleSwitch.classList.remove('active');
            }
        }

        // Update toggle icon
        const toggleIcon = this.elements.darkModeToggle?.querySelector('i');
        if (toggleIcon) {
            toggleIcon.className = this.state.darkMode ? 'fas fa-sun' : 'fas fa-moon';
        }
    }

    // Search functionality
    handleSearch(query) {
        if (!query.trim()) {
            this.hideSearchResults();
            return;
        }

        // Simulate search (replace with actual search logic)
        const mockResults = this.getMockSearchResults(query);
        this.displaySearchResults(mockResults);
    }

    getMockSearchResults(query) {
        const allItems = [
            { title: 'Dashboard', description: 'Main dashboard overview', url: '/admin/dashboard' },
            { title: 'Cars Management', description: 'Manage available cars', url: '/admin/cars' },
            { title: 'User Verification', description: 'Verify user accounts', url: '/admin/verify-users' },
            { title: 'Payments', description: 'View payment records', url: '/admin/payments' },
            { title: 'Booked Cars', description: 'View car bookings', url: '/admin/booked-cars' },
            { title: 'Car Registration', description: 'Register new cars', url: '/admin/car-registration' },
            { title: 'Inspection Requests', description: 'Handle inspection requests', url: '/admin/inspections' }
        ];

        return allItems.filter(item => 
            item.title.toLowerCase().includes(query.toLowerCase()) ||
            item.description.toLowerCase().includes(query.toLowerCase())
        ).slice(0, 5);
    }

    displaySearchResults(results) {
        let resultsContainer = document.querySelector('.header-search-results');
        
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.className = 'header-search-results';
            this.elements.headerSearch.parentElement.appendChild(resultsContainer);
        }

        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="search-result-item">No results found</div>';
        } else {
            resultsContainer.innerHTML = results.map(result => `
                <div class="search-result-item" data-url="${result.url}">
                    <div class="search-result-title">${result.title}</div>
                    <div class="search-result-description">${result.description}</div>
                </div>
            `).join('');

            // Add click handlers to results
            resultsContainer.querySelectorAll('.search-result-item').forEach(item => {
                item.addEventListener('click', () => {
                    const url = item.getAttribute('data-url');
                    if (url && url !== '#') {
                        window.location.href = url;
                    }
                });
            });
        }

        resultsContainer.classList.add('show');
    }

    showSearchResults() {
        const resultsContainer = document.querySelector('.header-search-results');
        if (resultsContainer && resultsContainer.children.length > 0) {
            resultsContainer.classList.add('show');
        }
    }

    hideSearchResults() {
        const resultsContainer = document.querySelector('.header-search-results');
        if (resultsContainer) {
            resultsContainer.classList.remove('show');
        }
    }

    // Menu item functionality
    handleMenuItemClick(e, item) {
        // Remove active class from all items
        this.elements.menuItems.forEach(menuItem => {
            menuItem.classList.remove('active');
        });

        // Add active class to clicked item
        item.classList.add('active');

        // Close mobile menu if open
        if (this.state.mobileMenuOpen) {
            this.closeMobileMenu();
        }

        // Handle submenu toggle
        if (item.classList.contains('has-submenu')) {
            e.preventDefault();
            this.toggleSubmenu(item);
        }
    }

    toggleSubmenu(menuItem) {
        const submenu = menuItem.nextElementSibling;
        if (submenu && submenu.classList.contains('sidebar-submenu')) {
            const isExpanded = menuItem.classList.contains('expanded');
            
            // Close all other submenus
            document.querySelectorAll('.sidebar-menu-item.expanded').forEach(item => {
                if (item !== menuItem) {
                    item.classList.remove('expanded');
                    const otherSubmenu = item.nextElementSibling;
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('expanded');
                    }
                }
            });

            // Toggle current submenu
            if (isExpanded) {
                menuItem.classList.remove('expanded');
                submenu.classList.remove('expanded');
            } else {
                menuItem.classList.add('expanded');
                submenu.classList.add('expanded');
            }
        }
    }

    handleActiveMenuItems() {
        // Set active menu item based on current URL
        const currentPath = window.location.pathname;
        this.elements.menuItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href && currentPath.includes(href.replace(/^.*\//, ''))) {
                item.classList.add('active');
            }
        });
    }

    // Responsive behavior
    handleResize() {
        const newIsMobile = window.innerWidth <= 768;
        
        if (newIsMobile !== this.state.isMobile) {
            this.state.isMobile = newIsMobile;
            
            if (newIsMobile) {
                // Switched to mobile
                this.elements.sidebar?.classList.remove('collapsed');
                this.closeMobileMenu();
            } else {
                // Switched to desktop
                this.elements.sidebar?.classList.remove('mobile-open');
                this.elements.sidebarOverlay?.classList.remove('active');
                this.elements.body.classList.remove('no-scroll');
                this.applySidebarState();
            }
        }
    }

    // Keyboard navigation
    handleKeyboardNavigation(e) {
        // Toggle sidebar with Ctrl+B
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            if (this.state.isMobile) {
                this.toggleMobileMenu();
            } else {
                this.toggleSidebar();
            }
        }

        // Toggle dark mode with Ctrl+D
        if (e.ctrlKey && e.key === 'd') {
            e.preventDefault();
            this.toggleDarkMode();
        }

        // Focus search with Ctrl+K
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault();
            this.elements.headerSearch?.focus();
        }

        // Close mobile menu with Escape
        if (e.key === 'Escape') {
            if (this.state.mobileMenuOpen) {
                this.closeMobileMenu();
            }
            this.hideSearchResults();
        }
    }

    // Handle clicks outside dropdowns
    handleOutsideClick(e) {
        // Close search results if clicked outside
        if (!e.target.closest('.header-search')) {
            this.hideSearchResults();
        }
    }

    // Utility functions
    debounce(func, wait) {
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

    saveState(key, value) {
        try {
            localStorage.setItem(`adminDashboard_${key}`, JSON.stringify(value));
        } catch (e) {
            console.warn('Could not save state to localStorage:', e);
        }
    }

    getSavedState(key, defaultValue) {
        try {
            const saved = localStorage.getItem(`adminDashboard_${key}`);
            return saved !== null ? JSON.parse(saved) : defaultValue;
        } catch (e) {
            console.warn('Could not load state from localStorage:', e);
            return defaultValue;
        }
    }

    hasState(key) {
        try {
            return localStorage.getItem(`adminDashboard_${key}`) !== null;
        } catch (e) {
            return false;
        }
    }

    // Public API methods
    getState() {
        return { ...this.state };
    }

    setSidebarCollapsed(collapsed) {
        this.state.sidebarCollapsed = collapsed;
        this.applySidebarState();
        this.saveState('sidebarCollapsed', collapsed);
    }

    setDarkMode(enabled) {
        this.state.darkMode = enabled;
        this.applyTheme();
        this.saveState('darkMode', enabled);
    }

    // Cleanup method
    destroy() {
        // Remove event listeners and clean up
        window.removeEventListener('resize', this.handleResize);
        document.removeEventListener('keydown', this.handleKeyboardNavigation);
        document.removeEventListener('click', this.handleOutsideClick);
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.adminDashboard = new AdminDashboard();
});

// Add CSS loading animation
document.addEventListener('DOMContentLoaded', () => {
    // Add loading class to prevent flash of unstyled content
    document.body.classList.add('loading');
    
    // Remove loading class after a short delay
    setTimeout(() => {
        document.body.classList.remove('loading');
        document.body.classList.add('loaded');
    }, 100);
});

// Handle page visibility changes
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        // Page is hidden
        console.log('Dashboard hidden');
    } else {
        // Page is visible
        console.log('Dashboard visible');
        // You could refresh data here
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AdminDashboard;
}