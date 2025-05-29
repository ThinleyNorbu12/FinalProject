

<?php $__env->startSection('content'); ?>
<body>
    <!-- Header -->
    <header class="main-header">
        <button class="header-menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="header-logo">
            <i class="fas fa-car"></i>
            <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
        </div>
        

        <div class="header-user">
            <?php if(Auth::guard('customer')->check()): ?>
                <span class="header-user-name"><?php echo e(Auth::guard('customer')->user()->name); ?></span>
                <form method="POST" action="<?php echo e(route('customer.logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('customer.login')); ?>" class="btn-logout">Login</a>
            <?php endif; ?>
        </div>        
    </header>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="<?php echo e(route('customer.my-reservations')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="<?php echo e(route('customer.profile')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                
                <a href="<?php echo e(route('customer.rental-history')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-history"></i>
                    <span>Rental History</span>
                </a>
                
                <a href="<?php echo e(route('customer.payment-history')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment History</span>
                </a>

                <a href="<?php echo e(route('customer.paylater')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Pay Later</span>
                </a>
                
                <a href="<?php echo e(route('customer.license')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Driving License</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">Services</div>
                
                <a href="<?php echo e(route('customer.locations')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Locations</span>
                </a>
                
                <a href="<?php echo e(route('customer.insurance-options')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="<?php echo e(route('customer.fuel-policy')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-gas-pump"></i>
                    <span>Fuel Policy</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
               
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <h1 class="page-title">Fuel Policy</h1>
            
            <div class="card">
                <div class="card-body">
                    <h2 class="section-title">Understanding Our Fuel Policies</h2>
                    <p class="mb-4">At CarRental, we offer several fuel policy options to suit your needs. Please read each option carefully to choose the best one for your trip.</p>
                    
                    <div class="fuel-policy-option">
                        <h3><i class="fas fa-gas-pump"></i> Full-to-Full</h3>
                        <p>Our standard and most popular option. We provide the car with a full tank, and you return it with a full tank. This is the most economical option as you only pay for the fuel you use.</p>
                        <div class="fuel-policy-pros-cons">
                            <div class="pros">
                                <h4>Pros:</h4>
                                <ul>
                                    <li>Most economical option</li>
                                    <li>Pay only for what you use</li>
                                    <li>No hidden charges</li>
                                </ul>
                            </div>
                            <div class="cons">
                                <h4>Cons:</h4>
                                <ul>
                                    <li>Need to find a gas station before returning</li>
                                    <li>Must provide receipt as proof of refueling</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="fuel-policy-option">
                        <h3><i class="fas fa-gas-pump"></i> Pre-Purchase (Full Tank)</h3>
                        <p>We provide the car with a full tank, and you pay for the full tank upfront at a competitive rate. Return the car with any amount of fuel without refilling.</p>
                        <div class="fuel-policy-pros-cons">
                            <div class="pros">
                                <h4>Pros:</h4>
                                <ul>
                                    <li>Convenient - no need to refill before return</li>
                                    <li>Competitive fuel rates</li>
                                    <li>Time-saving on return</li>
                                </ul>
                            </div>
                            <div class="cons">
                                <h4>Cons:</h4>
                                <ul>
                                    <li>You pay for a full tank even if you don't use it all</li>
                                    <li>No refund for unused fuel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="fuel-policy-option">
                        <h3><i class="fas fa-gas-pump"></i> Same-to-Same</h3>
                        <p>We provide the car with a specific fuel level (e.g., 3/4 tank), and you return it with the same level. The fuel gauge reading will be recorded on pickup.</p>
                        <div class="fuel-policy-pros-cons">
                            <div class="pros">
                                <h4>Pros:</h4>
                                <ul>
                                    <li>Flexibility - match what you received</li>
                                    <li>Fair and transparent</li>
                                </ul>
                            </div>
                            <div class="cons">
                                <h4>Cons:</h4>
                                <ul>
                                    <li>Can be difficult to match exact fuel level</li>
                                    <li>Risk of charges if returned with less fuel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-4">
                        <h4><i class="fas fa-exclamation-triangle"></i> Important Notes</h4>
                        <ul>
                            <li>If you choose the Full-to-Full option and fail to refill, a refueling fee plus premium fuel charges will apply.</li>
                            <li>Always keep fuel receipts as proof of refueling.</li>
                            <li>Fuel level is measured using the vehicle's fuel gauge.</li>
                            <li>Fuel type requirements are specified on each vehicle and at pickup.</li>
                        </ul>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3>Refueling Charges</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Refueling Service Fee</td>
                                        <td>$25.00</td>
                                    </tr>
                                    <tr>
                                        <td>Premium on Fuel Price</td>
                                        <td>50% above market rate</td>
                                    </tr>
                                    <tr>
                                        <td>Missing Fuel Receipt Fee</td>
                                        <td>$15.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <h3 class="mt-4">Frequently Asked Questions</h3>
                    
                    <div class="faq-section">
                        <div class="faq-item">
                            <h4>What happens if I return the car with less fuel than agreed?</h4>
                            <p>If you return the vehicle with less fuel than agreed, we will charge you for the missing fuel plus a refueling service fee of $25.00. The fuel will be charged at a premium rate that is 50% higher than the local average fuel price.</p>
                        </div>
                        
                        <div class="faq-item">
                            <h4>How do you measure the fuel level?</h4>
                            <p>We use the vehicle's fuel gauge to determine the fuel level. Our staff will check and record the fuel gauge reading both at pickup and return in your presence.</p>
                        </div>
                        
                        <div class="faq-item">
                            <h4>Can I change my fuel policy after booking?</h4>
                            <p>You can change your fuel policy at the time of pickup, but not after you have taken possession of the vehicle.</p>
                        </div>
                        
                        <div class="faq-item">
                            <h4>What type of fuel should I use?</h4>
                            <p>You should always use the fuel type specified for the vehicle. This information is provided at pickup and is usually noted on the fuel cap or in the vehicle manual. Using incorrect fuel can cause serious damage to the vehicle and will result in significant charges.</p>
                        </div>
                    </div>
                    
                    <div class="contact-section mt-5">
                        <h3>Still Have Questions?</h3>
                        <p>Our customer service team is available to assist you with any questions about our fuel policies.</p>
                        <div class="contact-buttons">
                            <a href="#" class="btn btn-primary"><i class="fas fa-phone"></i> Call Us</a>
                            <a href="#" class="btn btn-secondary"><i class="fas fa-envelope"></i> Email Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Fuel Policy Specific Styles */
.fuel-policy-option {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    border-left: 4px solid #4CAF50;
}

.fuel-policy-option h3 {
    color: #2C3E50;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.fuel-policy-option h3 i {
    margin-right: 10px;
    color: #4CAF50;
}

.fuel-policy-pros-cons {
    display: flex;
    margin-top: 15px;
    gap: 20px;
}

.fuel-policy-pros-cons .pros,
.fuel-policy-pros-cons .cons {
    flex: 1;
    padding: 15px;
    border-radius: 6px;
}

.fuel-policy-pros-cons .pros {
    background-color: rgba(76, 175, 80, 0.1);
    border-left: 3px solid #4CAF50;
}

.fuel-policy-pros-cons .cons {
    background-color: rgba(244, 67, 54, 0.1);
    border-left: 3px solid #F44336;
}

.fuel-policy-pros-cons h4 {
    font-size: 1rem;
    margin-bottom: 10px;
}

.fuel-policy-pros-cons ul {
    margin-bottom: 0;
    padding-left: 20px;
}

.fuel-policy-pros-cons ul li {
    margin-bottom: 5px;
}

.faq-section {
    margin-top: 25px;
}

.faq-item {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.faq-item h4 {
    color: #2C3E50;
    margin-bottom: 10px;
    font-size: 1.1rem;
}

.contact-section {
    background-color: #f1f8e9;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
}

.contact-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .fuel-policy-pros-cons {
        flex-direction: column;
    }
    
    .contact-buttons {
        flex-direction: column;
    }
    
    .contact-buttons a {
        margin-bottom: 10px;
    }
}
</style>
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
    <script>
        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 576) {
                    sidebar.classList.remove('expanded');
                }
            });
            
            // Resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth > 576) {
                    sidebar.classList.remove('expanded');
                }
            });
        });
    </script>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/fuel-policy.blade.php ENDPATH**/ ?>