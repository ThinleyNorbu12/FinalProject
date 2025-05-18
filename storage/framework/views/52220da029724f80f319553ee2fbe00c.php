

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
<body>
    <!-- Header -->
    <header class="main-header">
        <button class="header-menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="header-logo">
            <i class="fas fa-car"></i>
            <span>CarRental</span>
        </div>
        
        <div class="header-search">
            <input type="text" placeholder="Search for cars...">
            <button><i class="fas fa-search"></i></button>
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
                
                <a href="<?php echo e(route('customer.insurance-options')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="<?php echo e(route('customer.fuel-policy')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-gas-pump"></i>
                    <span>Fuel Policy</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">Help</div>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-headset"></i>
                    <span>Support</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Report Issue</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <h1 class="page-title">Insurance Options</h1>
            
            <div class="card">
                <div class="card-body">
                    <h2 class="section-title">Protecting Your Journey</h2>
                    <p class="mb-4">At CarRental, we offer comprehensive insurance options to ensure your peace of mind during your rental period. Choose the coverage that best suits your needs and driving style.</p>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle"></i> All rentals include basic liability coverage as required by law. Additional protection plans described below are optional but recommended.
                    </div>
                    
                    <!-- Insurance Plans Section -->
                    <div class="insurance-plans">
                        <!-- Basic Plan -->
                        <div class="insurance-plan">
                            <div class="plan-header">
                                <h3><i class="fas fa-shield-alt"></i> Basic Protection</h3>
                                <span class="plan-price">Included</span>
                            </div>
                            <div class="plan-content">
                                <p>Our standard liability coverage that meets minimum legal requirements.</p>
                                <div class="coverage-details">
                                    <div class="coverage-item">
                                        <span class="coverage-label">Liability Coverage:</span>
                                        <span class="coverage-value">Up to $50,000 per accident</span>
                                    </div>
                                    <div class="coverage-item">
                                        <span class="coverage-label">Property Damage:</span>
                                        <span class="coverage-value">Up to $25,000</span>
                                    </div>
                                    <div class="coverage-item">
                                        <span class="coverage-label">Personal Injury:</span>
                                        <span class="coverage-value">Up to $15,000 per person</span>
                                    </div>
                                </div>
                                <div class="deductible">
                                    <strong>Deductible:</strong> $2,500 for collision damage
                                </div>
                                <ul class="plan-features">
                                    <li><i class="fas fa-check text-success"></i> Third-party liability coverage</li>
                                    <li><i class="fas fa-times text-danger"></i> No personal accident insurance</li>
                                    <li><i class="fas fa-times text-danger"></i> No theft protection</li>
                                    <li><i class="fas fa-times text-danger"></i> No coverage for vehicle damage</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Standard Plan -->
                        <div class="insurance-plan recommended">
                            <div class="recommended-badge">RECOMMENDED</div>
                            <div class="plan-header">
                                <h3><i class="fas fa-shield-alt"></i> Standard Protection</h3>
                                <span class="plan-price">$19.99/day</span>
                            </div>
                            <div class="plan-content">
                                <p>Our most popular option. Provides essential coverage for most common incidents.</p>
                                <div class="coverage-details">
                                    <div class="coverage-item">
                                        <span class="coverage-label">Liability Coverage:</span>
                                        <span class="coverage-value">Up to $100,000 per accident</span>
                                    </div>
                                    <div class="coverage-item">
                                        <span class="coverage-label">Property Damage:</span>
                                        <span class="coverage-value">Up to $50,000</span>
                                    </div>
                                    <div class="coverage-item">
                                        <span class="coverage-label">Personal Injury:</span>
                                        <span class="coverage-value">Up to $25,000 per person</span>
                                    </div>
                                </div>
                                <div class="deductible">
                                    <strong>Deductible:</strong> $1,000 for collision damage
                                </div>
                                <ul class="plan-features">
                                    <li><i class="fas fa-check text-success"></i> Enhanced third-party liability</li>
                                    <li><i class="fas fa-check text-success"></i> Collision Damage Waiver (CDW)</li>
                                    <li><i class="fas fa-check text-success"></i> Basic theft protection</li>
                                    <li><i class="fas fa-times text-danger"></i> No personal effects coverage</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Premium Plan -->
                        <div class="insurance-plan">
                            <div class="plan-header">
                                <h3><i class="fas fa-shield-alt"></i> Premium Protection</h3>
                                <span class="plan-price">$34.99/day</span>
                            </div>
                            <div class="plan-content">
                                <p>Comprehensive protection with minimal deductible for complete peace of mind.</p>
                                <div class="coverage-details">
                                    <div class="coverage-item">
                                        <span class="coverage-label">Liability Coverage:</span>
                                        <span class="coverage-value">Up to $300,000 per accident</span>
                                    </div>
                                    <div class="coverage-item">
                                        <span class="coverage-label">Property Damage:</span>
                                        <span class="coverage-value">Up to $100,000</span>
                                    </div>
                                    <div class="coverage-item">
                                        <span class="coverage-label">Personal Injury:</span>
                                        <span class="coverage-value">Up to $50,000 per person</span>
                                    </div>
                                </div>
                                <div class="deductible">
                                    <strong>Deductible:</strong> $0 (Zero deductible)
                                </div>
                                <ul class="plan-features">
                                    <li><i class="fas fa-check text-success"></i> Maximum liability coverage</li>
                                    <li><i class="fas fa-check text-success"></i> Full Collision Damage Waiver</li>
                                    <li><i class="fas fa-check text-success"></i> Comprehensive theft protection</li>
                                    <li><i class="fas fa-check text-success"></i> Personal effects coverage up to $2,500</li>
                                    <li><i class="fas fa-check text-success"></i> Emergency medical expenses</li>
                                    <li><i class="fas fa-check text-success"></i> 24/7 premium roadside assistance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Coverage Options -->
                    <div class="additional-coverage">
                        <h3 class="section-title">Additional Coverage Options</h3>
                        <p>Enhance your protection with these specialized coverage options:</p>
                        
                        <div class="coverage-grid">
                            <div class="coverage-item">
                                <div class="coverage-icon">
                                    <i class="fas fa-road"></i>
                                </div>
                                <div class="coverage-details">
                                    <h4>Roadside Assistance Plus</h4>
                                    <p>24/7 emergency support for breakdowns, flat tires, lockouts, and more.</p>
                                    <span class="coverage-price">$8.99/day</span>
                                </div>
                            </div>
                            
                            <div class="coverage-item">
                                <div class="coverage-icon">
                                    <i class="fas fa-glass-broken"></i>
                                </div>
                                <div class="coverage-details">
                                    <h4>Glass & Tire Protection</h4>
                                    <p>Coverage for windshield, window, and tire damage with no deductible.</p>
                                    <span class="coverage-price">$6.99/day</span>
                                </div>
                            </div>
                            
                            <div class="coverage-item">
                                <div class="coverage-icon">
                                    <i class="fas fa-suitcase"></i>
                                </div>
                                <div class="coverage-details">
                                    <h4>Personal Effects Coverage</h4>
                                    <p>Protects your belongings in the vehicle from theft or damage.</p>
                                    <span class="coverage-price">$5.99/day</span>
                                </div>
                            </div>
                            
                            <div class="coverage-item">
                                <div class="coverage-icon">
                                    <i class="fas fa-user-injured"></i>
                                </div>
                                <div class="coverage-details">
                                    <h4>Personal Accident Insurance</h4>
                                    <p>Medical coverage for driver and passengers in case of accident.</p>
                                    <span class="coverage-price">$7.99/day</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comparison Table -->
                    <div class="coverage-comparison">
                        <h3 class="section-title">Protection Plan Comparison</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Coverage Feature</th>
                                        <th>Basic</th>
                                        <th>Standard</th>
                                        <th>Premium</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Liability Coverage</td>
                                        <td>$50,000</td>
                                        <td>$100,000</td>
                                        <td>$300,000</td>
                                    </tr>
                                    <tr>
                                        <td>Collision Damage Waiver</td>
                                        <td><i class="fas fa-times text-danger"></i></td>
                                        <td><i class="fas fa-check text-success"></i></td>
                                        <td><i class="fas fa-check text-success"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Theft Protection</td>
                                        <td><i class="fas fa-times text-danger"></i></td>
                                        <td>Basic</td>
                                        <td>Comprehensive</td>
                                    </tr>
                                    <tr>
                                        <td>Personal Effects Coverage</td>
                                        <td><i class="fas fa-times text-danger"></i></td>
                                        <td><i class="fas fa-times text-danger"></i></td>
                                        <td>Up to $2,500</td>
                                    </tr>
                                    <tr>
                                        <td>Roadside Assistance</td>
                                        <td>Basic</td>
                                        <td>Standard</td>
                                        <td>Premium 24/7</td>
                                    </tr>
                                    <tr>
                                        <td>Deductible</td>
                                        <td>$2,500</td>
                                        <td>$1,000</td>
                                        <td>$0</td>
                                    </tr>
                                    <tr>
                                        <td>Cost per Day</td>
                                        <td>Included</td>
                                        <td>$19.99</td>
                                        <td>$34.99</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- FAQ Section -->
                    <div class="insurance-faq">
                        <h3 class="section-title">Frequently Asked Questions</h3>
                        
                        <div class="accordion" id="insuranceFAQ">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Do I need to purchase additional insurance if I already have auto insurance?
                                    </button>
                                </h4>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#insuranceFAQ">
                                    <div class="accordion-body">
                                        Your personal auto insurance policy may provide some coverage for rental cars, but there are often limitations. It's important to check with your insurance provider about what is covered. Our additional protection plans can fill gaps in your personal coverage and potentially save you from having to file a claim on your personal policy.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Does my credit card offer rental car insurance?
                                    </button>
                                </h4>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#insuranceFAQ">
                                    <div class="accordion-body">
                                        Some credit cards do offer rental car coverage, but it varies widely by card issuer and typically only covers damage to the rental vehicle (Collision Damage Waiver) rather than liability. To utilize credit card coverage, you generally must decline our CDW and charge the entire rental to that specific card. We recommend contacting your credit card company for details on their specific coverage before declining our protection options.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        What happens if I decline all additional insurance options?
                                    </button>
                                </h4>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#insuranceFAQ">
                                    <div class="accordion-body">
                                        If you decline additional coverage, you will be responsible for any damage to the rental vehicle up to its full value, as well as potential loss of use charges, administrative fees, and diminution of value. You will still have the basic liability coverage required by law, but this typically has high deductibles and lower coverage limits.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Can I purchase insurance at the time of pickup?
                                    </button>
                                </h4>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#insuranceFAQ">
                                    <div class="accordion-body">
                                        Yes, you can purchase any of our protection plans at the time of vehicle pickup. However, we recommend selecting your insurance options during the booking process to save time at the counter and ensure availability of all coverage options.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Are there any exclusions to the insurance coverage?
                                    </button>
                                </h4>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#insuranceFAQ">
                                    <div class="accordion-body">
                                        Yes, all insurance plans have certain exclusions. Common exclusions include damage resulting from prohibited uses of the vehicle (off-road driving, driving under the influence, unauthorized drivers), ceiling and undercarriage damage, interior damage, lost keys, and violation of the rental agreement terms. Please refer to the full terms and conditions for a complete list of exclusions.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Section -->
                    <div class="insurance-cta">
                        <h3>Protect Your Journey with Confidence</h3>
                        <p>Select your preferred insurance option during the booking process or speak with our representative at the rental counter.</p>
                        <div class="cta-buttons">
                            <a href="<?php echo e(route('customer.browse-cars')); ?>" class="btn btn-primary">Browse Cars</a>
                            <a href="#" class="btn btn-outline-secondary">Contact Insurance Team</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/insurance-options.blade.php ENDPATH**/ ?>