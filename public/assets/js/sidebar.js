 // Get elements
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const dashboardSidebar = document.getElementById('dashboardSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const adminDashboard = document.getElementById('adminDashboard');

        // Desktop sidebar toggle
        sidebarToggle.addEventListener('click', function() {
            dashboardSidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });

        // Mobile menu toggle
        mobileMenuToggle.addEventListener('click', function() {
            dashboardSidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = dashboardSidebar.classList.contains('mobile-open') ? 'hidden' : 'auto';
        });

        // Close mobile menu when overlay is clicked
        sidebarOverlay.addEventListener('click', function() {
            dashboardSidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        // Close mobile menu when pressing escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && dashboardSidebar.classList.contains('mobile-open')) {
                dashboardSidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Active menu item handling
        const menuItems = document.querySelectorAll('.sidebar-menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Remove active class from all items
                menuItems.forEach(menuItem => menuItem.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
                
                // Close mobile menu if open
                if (window.innerWidth <= 768) {
                    dashboardSidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                dashboardSidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Auto-collapse sidebar on smaller screens
        function handleResize() {
            if (window.innerWidth <= 992 && window.innerWidth > 768) {
                dashboardSidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            } else if (window.innerWidth > 992) {
                dashboardSidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        }

        // Run on load
        handleResize();
        window.addEventListener('resize', handleResize);