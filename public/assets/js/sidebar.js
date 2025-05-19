
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const body = document.body;

    // Function to check window width and set appropriate classes
    function checkWidth() {
        if (window.innerWidth < 768) {
            // Mobile view - sidebar hidden by default
            body.classList.remove('sidebar-expanded');
        } else if (window.innerWidth < 992) {
            // Tablet view - collapsed sidebar by default
            body.classList.add('sidebar-collapsed');
            body.classList.remove('sidebar-expanded');
        }
    }

    // Run on page load
    checkWidth();

    // Toggle sidebar on button click
    sidebarToggle.addEventListener('click', function() {
        if (window.innerWidth < 768) {
            // For mobile: toggle expanded class
            body.classList.toggle('sidebar-expanded');
        } else {
            // For tablet and desktop: toggle collapsed class
            body.classList.toggle('sidebar-collapsed');
        }
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (
            window.innerWidth < 768 && 
            body.classList.contains('sidebar-expanded') && 
            !event.target.closest('.dashboard-sidebar') && 
            !event.target.closest('#sidebar-toggle')
        ) {
            body.classList.remove('sidebar-expanded');
        }
    });

    // Adjust on window resize
    window.addEventListener('resize', checkWidth);
});

