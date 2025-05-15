
<link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
<!-- Footer -->
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted mb-0">&copy; {{ date('Y') }} Car Rental System. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0">Version 1.0.0</p>
            </div>
        </div>
    </div>
</footer>

<!-- Custom JavaScript -->
<script>
    // Sidebar Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        
        if (sidebarToggle && sidebar && mainContent) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        }
        
        // Active menu item highlighting
        const currentPath = window.location.pathname;
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const itemPath = item.getAttribute('href');
            if (itemPath && currentPath.includes(itemPath)) {
                item.classList.add('active');
            }
        });
    });
    
    // Confirmation for delete actions
    const confirmDelete = (event, itemName) => {
        if (!confirm(`Are you sure you want to delete this ${itemName}?`)) {
            event.preventDefault();
        }
    };
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Flash message auto-close
    const alerts = document.querySelectorAll('.alert-dismissible.auto-close');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000); // Auto close after 5 seconds
    });
</script>

<!-- Additional JavaScript -->
@yield('scripts')