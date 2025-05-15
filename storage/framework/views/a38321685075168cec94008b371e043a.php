<!-- resources/views/layouts/partials/headers/admin-header.blade.php -->

<style>
    /* Admin Header Styles */
.admin-header {
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 0.75rem 1rem;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
}

.header-left {
    display: flex;
    align-items: center;
}

.mobile-sidebar-toggle {
    display: none;
    background: none;
    border: none;
    color: #555;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    margin-right: 1rem;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

/* Search Input */
.header-search {
    position: relative;
}

.header-search form {
    display: flex;
}

.header-search input {
    background-color: #f5f5f5;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 0.5rem 1rem;
    width: 250px;
    transition: all 0.3s;
}

.header-search input:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.25);
}

.header-search button {
    background: none;
    border: none;
    color: #777;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

/* Notifications Dropdown */
.header-notifications {
    position: relative;
}

.dropdown {
    position: relative;
}

.dropdown-toggle {
    background: none;
    border: none;
    color: #555;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    position: relative;
}

.badge {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #e74c3c;
    color: white;
    border-radius: 50%;
    font-size: 0.7rem;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    min-width: 300px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s;
    z-index: 1001;
}

.dropdown:hover .dropdown-menu,
.dropdown:focus-within .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
}

.dropdown-header span {
    font-weight: 600;
}

.dropdown-header a {
    color: #3498db;
    text-decoration: none;
    font-size: 0.85rem;
}

.dropdown-item {
    display: flex;
    align-items: flex-start;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f5f5f5;
    gap: 0.75rem;
    transition: background-color 0.2s;
}

.dropdown-item:hover {
    background-color: #f9f9f9;
}

.dropdown-item i {
    padding-top: 0.2rem;
}

.notification-content {
    flex: 1;
}

.notification-content p {
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
}

.notification-content span {
    font-size: 0.8rem;
    color: #777;
}

.dropdown-footer {
    padding: 0.75rem 1rem;
    text-align: center;
}

.dropdown-footer a {
    color: #3498db;
    text-decoration: none;
    font-size: 0.9rem;
}

.dropdown-divider {
    height: 1px;
    background-color: #eee;
    margin: 0.5rem 0;
}

/* Profile Dropdown */
.header-profile .dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    background-color: #f5f5f5;
}

.profile-button {
    font-size: 0.9rem;
}

.header-profile .dropdown-menu {
    min-width: 200px;
}

.header-profile .dropdown-item {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #333;
    text-decoration: none;
}

.header-profile .dropdown-item i {
    width: 16px;
}

/* Admin Footer Styles */
.admin-footer {
    background-color: #f8f9fa;
    padding: 1.5rem 0;
    border-top: 1px solid #e9ecef;
    position: relative;
    z-index: 10;
    margin-top: auto;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

.footer-copyright p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.footer-links {
    display: flex;
    gap: 1.5rem;
}

.footer-links a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s;
}

.footer-links a:hover {
    color: #3498db;
}

/* Text colors for notifications */
.text-primary {
    color: #3498db;
}

.text-success {
    color: #2ecc71;
}

.text-warning {
    color: #f39c12;
}

/* Responsive styles */
@media (max-width: 992px) {
    .header-search input {
        width: 200px;
    }
}

@media (max-width: 768px) {
    .mobile-sidebar-toggle {
        display: block;
    }
    
    .header-search {
        display: none;
    }
    
    .footer-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .footer-links {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .header-notifications,
    .header-profile {
        position: static;
    }
    
    .dropdown-menu {
        width: 100%;
        max-width: 100%;
        left: 0;
        right: 0;
    }
    
    .header-right {
        gap: 0.75rem;
    }
    
    .header-profile .dropdown-toggle span {
        display: none;
    }
    
    .footer-links {
        gap: 1rem;
    }
}
</style>
<header class="admin-header">
    <div class="header-container">
        <div class="header-left">
            <button id="mobile-sidebar-toggle" class="mobile-sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <div class="header-right">
            <div class="header-search">
                <form action="#" method="GET">
                    <input type="text" placeholder="Search...">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <div class="header-notifications">
                <div class="dropdown">
                    <button class="dropdown-toggle">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">
                            <span>Notifications</span>
                            <a href="#">Mark all as read</a>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-user-plus text-primary"></i>
                            <div class="notification-content">
                                <p>New user registration</p>
                                <span>15 minutes ago</span>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-car text-success"></i>
                            <div class="notification-content">
                                <p>New car inspection request</p>
                                <span>1 hour ago</span>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-calendar-check text-warning"></i>
                            <div class="notification-content">
                                <p>New booking request</p>
                                <span>3 hours ago</span>
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="#">View all notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="header-profile">
                <div class="dropdown">
                    <button class="dropdown-toggle profile-button">
                        <?php if(Auth::guard('admin')->check()): ?>
                            <span><?php echo e(Auth::guard('admin')->user()->name); ?></span>
                        <?php else: ?>
                            <span>Admin</span>
                        <?php endif; ?>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/layouts/partials/headers/admin.blade.php ENDPATH**/ ?>