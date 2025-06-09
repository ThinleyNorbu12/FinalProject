<!-- Create this file as resources/views/user-guide.blade.php -->

 <!-- Adjust based on your layout file -->

<?php $__env->startSection('title', 'User Guide - Car Rental System'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4">
                    <i class="fas fa-question-circle text-primary"></i>
                    Car Rental System User Guide
                </h1>
                <p class="lead text-muted">Complete guide to help you navigate and use our car rental system</p>
                <div class="badge badge-info">Version 1.0.0</div>
                <hr class="my-4">
            </div>

            <!-- Quick Navigation -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-compass"></i> Quick Navigation</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6><i class="fas fa-home text-primary"></i> Getting Started</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#system-overview">System Overview</a></li>
                                <li><a href="#homepage-guide">Homepage Guide</a></li>
                                <li><a href="#registration">Registration & Login</a></li>
                                <li><a href="#system-requirements">System Requirements</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6><i class="fas fa-user text-primary"></i> Customer Guide</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#customer-dashboard">Customer Dashboard</a></li>
                                <li><a href="#booking-process">Booking Process</a></li>
                                <li><a href="#sidebar-navigation">Dashboard Navigation</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6><i class="fas fa-cog text-primary"></i> Account Management</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#profile-management">Profile Management</a></li>
                                <li><a href="#license-management">Driving License</a></li>
                                <li><a href="#payment-management">Payment Management</a></li>
                                <li><a href="#rental-history">Rental History</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6><i class="fas fa-life-ring text-primary"></i> Support</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#troubleshooting">Troubleshooting</a></li>
                                <li><a href="#tips">Tips & Best Practices</a></li>
                                <li><a href="#quick-reference">Quick Reference</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Overview Section -->
            <div class="card mb-4" id="system-overview">
                <div class="card-header bg-info text-white">
                    <h3><i class="fas fa-info-circle"></i> System Overview</h3>
                </div>
                <div class="card-body">
                    <p class="lead">The Car Rental System is a comprehensive web-based platform that allows customers to search, book, and manage car rentals online.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-star text-warning"></i> Key Features:</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-search text-primary"></i> Easy car search and booking</li>
                                <li class="list-group-item"><i class="fas fa-tachometer-alt text-primary"></i> User-friendly dashboard for customers</li>
                                <li class="list-group-item"><i class="fas fa-history text-primary"></i> Rental history and payment tracking</li>
                                <li class="list-group-item"><i class="fas fa-clock text-primary"></i> Real-time car availability</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-shield-alt text-success"></i> System Benefits:</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-lock text-success"></i> Secure user authentication</li>
                                <li class="list-group-item"><i class="fas fa-mobile-alt text-success"></i> Mobile-responsive design</li>
                                <li class="list-group-item"><i class="fas fa-credit-card text-success"></i> Insurance and fuel policy options</li>
                                <li class="list-group-item"><i class="fas fa-chart-line text-success"></i> Advanced search with filters</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Requirements -->
            <div class="card mb-4" id="system-requirements">
                <div class="card-header">
                    <h4><i class="fas fa-desktop"></i> System Requirements</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-globe fa-2x text-primary mb-2"></i>
                                <h6>Web Browser</h6>
                                <small>Chrome, Firefox, Safari, Edge</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-wifi fa-2x text-primary mb-2"></i>
                                <h6>Internet Connection</h6>
                                <small>Stable internet required</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-code fa-2x text-primary mb-2"></i>
                                <h6>JavaScript</h6>
                                <small>Must be enabled</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Homepage Guide Section -->
            <div class="card mb-4" id="homepage-guide">
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-home"></i> Homepage Guide</h3>
                </div>
                <div class="card-body">
                    <h5>Main Interface Elements:</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-header text-primary"></i> Header Section:</h6>
                            <ul>
                                <li><strong>Car Rental System Logo</strong> with car icon</li>
                                <li><strong>Login Button</strong> (blue outline) for existing users</li>
                                <li><strong>Sign Up Button</strong> (blue filled) for new users</li>
                                <li><strong>Hamburger Menu</strong> (☰) for navigation</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-search text-primary"></i> Search Form Fields:</h6>
                            <ul>
                                <li>Pickup Location</li>
                                <li>Pickup Date (mm/dd/yyyy format)</li>
                                <li>Pickup Time (default: 12:00 PM)</li>
                                <li>Drop-off Location</li>
                                <li>Drop-off Date & Time</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Main Content Features:</strong>
                        <ul class="mb-0">
                            <li>"Find Your Perfect Ride" - Main heading</li>
                            <li>"Browse through our selection of top-quality rental cars" - Subtitle</li>
                            <li>Available Cars section showing current inventory</li>
                            <li>Footer with copyright and version information</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Registration & Login Section -->
            <div class="card mb-4" id="registration">
                <div class="card-header">
                    <h3><i class="fas fa-user-plus"></i> Registration & Login</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-user-plus"></i> New Users Registration</h5>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>Click the <strong>"Sign Up"</strong> button (blue filled button)</li>
                                        <li>Fill out the registration form with personal details</li>
                                        <li>Create a secure password</li>
                                        <li>Submit the form to create your account</li>
                                        <li>Receive confirmation of successful registration</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5><i class="fas fa-sign-in-alt"></i> Existing Users Login</h5>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>Click the <strong>"Login"</strong> button (blue outline button)</li>
                                        <li>Enter your registered email address</li>
                                        <li>Enter your password</li>
                                        <li>Click login to access your customer dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Dashboard Section -->
            <div class="card mb-4" id="customer-dashboard">
                <div class="card-header bg-warning text-dark">
                    <h3><i class="fas fa-tachometer-alt"></i> Customer Dashboard Guide</h3>
                </div>
                <div class="card-body">
                    <h5>Dashboard Overview:</h5>
                    <p>Once logged in as a customer, you'll see a personalized dashboard with:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-header text-info"></i> Header Section:</h6>
                            <ul>
                                <li><strong>Welcome message</strong> showing your name (e.g., "Thinley Norbu")</li>
                                <li><strong>Logout button</strong> for secure session termination</li>
                                <li><strong>Car Rental System logo</strong> for navigation</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-content text-info"></i> Main Dashboard Content:</h6>
                            <ul>
                                <li>"Welcome to Your Car Rental Dashboard" heading</li>
                                <li>Personal greeting with activity summary</li>
                                <li>Current rental status display</li>
                                <li>Recent rental history table</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <div class="card mb-4" id="sidebar-navigation">
                <div class="card-header">
                    <h4><i class="fas fa-bars"></i> Left Sidebar Navigation Menu</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6><i class="fas fa-home text-primary"></i> MAIN SECTIONS:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-tachometer-alt"></i> Dashboard - Main control panel</li>
                                <li class="list-group-item"><i class="fas fa-car"></i> Browse Cars - Search available rentals</li>
                                <li class="list-group-item"><i class="fas fa-calendar"></i> My Reservations - Current bookings</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6><i class="fas fa-user text-success"></i> MY ACCOUNT SECTION:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-user"></i> Profile - Personal information</li>
                                <li class="list-group-item"><i class="fas fa-history"></i> Rental History - Past rentals</li>
                                <li class="list-group-item"><i class="fas fa-credit-card"></i> Payment History - Transactions</li>
                                <li class="list-group-item"><i class="fas fa-money-bill"></i> Pay Later - Pending payments</li>
                                <li class="list-group-item"><i class="fas fa-id-card"></i> Driving License - License info</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6><i class="fas fa-cogs text-warning"></i> SERVICES SECTION:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-map-marker"></i> Locations - Pickup/drop-off points</li>
                                <li class="list-group-item"><i class="fas fa-shield"></i> Insurance Options - Coverage plans</li>
                                <li class="list-group-item"><i class="fas fa-gas-pump"></i> Fuel Policy - Fuel charges info</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Process Section -->
            <div class="card mb-4" id="booking-process">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-calendar-check"></i> Car Booking Process</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5><i class="fas fa-home"></i> From Homepage</h5>
                                </div>
                                <div class="card-body">
                                    <h6>1. Fill the Search Form:</h6>
                                    <ul>
                                        <li>Enter your <strong>pickup location</strong></li>
                                        <li>Select <strong>pickup date and time</strong></li>
                                        <li>Enter your <strong>drop-off location</strong></li>
                                        <li>Select <strong>return date and time</strong></li>
                                        <li>Click <strong>"Search Car"</strong> button</li>
                                    </ul>
                                    
                                    <h6>2. Browse Available Cars:</h6>
                                    <ul>
                                        <li>View the list of available vehicles</li>
                                        <li>Compare prices and features</li>
                                        <li>Select your preferred car</li>
                                    </ul>
                                    
                                    <h6>3. Complete Booking:</h6>
                                    <ul>
                                        <li>Review rental details</li>
                                        <li>Confirm dates and locations</li>
                                        <li>Proceed to payment</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5><i class="fas fa-tachometer-alt"></i> From Customer Dashboard</h5>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>Click <strong>"Browse Cars"</strong> in the left sidebar</li>
                                        <li>Use search filters to find suitable cars</li>
                                        <li>Select and book your preferred vehicle</li>
                                        <li>Track your booking in <strong>"My Reservations"</strong></li>
                                    </ol>
                                    
                                    <div class="alert alert-success mt-3">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Pro Tip:</strong> Use the dashboard for quicker access to your booking history and preferences!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Management Sections -->
            <div class="card mb-4" id="profile-management">
                <div class="card-header">
                    <h4><i class="fas fa-user-cog"></i> Account Management</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accountAccordion">
                        <!-- Profile Management -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#profileCollapse">
                                        <i class="fas fa-user"></i> Managing Your Profile
                                    </button>
                                </h6>
                            </div>
                            <div id="profileCollapse" class="collapse" data-parent="#accountAccordion">
                                <div class="card-body">
                                    <ol>
                                        <li>Go to <strong>Dashboard → Profile</strong> (👤)</li>
                                        <li>Update your personal information:
                                            <ul>
                                                <li>Name and contact details</li>
                                                <li>Email address</li>
                                                <li>Phone number</li>
                                                <li>Address information</li>
                                            </ul>
                                        </li>
                                        <li>Save changes to update your profile</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- License Management -->
                        <div class="card" id="license-management">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#licenseCollapse">
                                        <i class="fas fa-id-card"></i> Driving License Management
                                    </button>
                                </h6>
                            </div>
                            <div id="licenseCollapse" class="collapse" data-parent="#accountAccordion">
                                <div class="card-body">
                                    <ol>
                                        <li>Navigate to <strong>Dashboard → Driving License</strong> (🪪)</li>
                                        <li>Upload a clear photo of your license</li>
                                        <li>Ensure all details are visible and current</li>
                                        <li>Wait for verification (if required)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Management -->
                        <div class="card" id="payment-management">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#paymentCollapse">
                                        <i class="fas fa-credit-card"></i> Payment Management
                                    </button>
                                </h6>
                            </div>
                            <div id="paymentCollapse" class="collapse" data-parent="#accountAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-history text-primary"></i> Payment History:</h6>
                                            <ul>
                                                <li>View all past payments in <strong>Payment History</strong> (💳)</li>
                                                <li>Download receipts for your records</li>
                                                <li>Track payment status and dates</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-clock text-warning"></i> Pay Later Option:</h6>
                                            <ul>
                                                <li>Access <strong>Pay Later</strong> (💰) for pending payments</li>
                                                <li>Complete outstanding payments</li>
                                                <li>Set up payment reminders</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rental History -->
                        <div class="card" id="rental-history">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#historyCollapse">
                                        <i class="fas fa-history"></i> Viewing Rental History
                                    </button>
                                </h6>
                            </div>
                            <div id="historyCollapse" class="collapse" data-parent="#accountAccordion">
                                <div class="card-body">
                                    <ol>
                                        <li>Go to <strong>Dashboard → Rental History</strong> (🔄)</li>
                                        <li>View complete rental records including:
                                            <ul>
                                                <li>Rental dates and duration</li>
                                                <li>Car details and photos</li>
                                                <li>Total costs and breakdown</li>
                                                <li>Pickup/drop-off locations</li>
                                                <li>Rental status and reviews</li>
                                            </ul>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting Section -->
            <div class="card mb-4" id="troubleshooting">
                <div class="card-header bg-danger text-white">
                    <h3><i class="fas fa-wrench"></i> Troubleshooting</h3>
                </div>
                <div class="card-body">
                    <h5>Common Issues and Solutions:</h5>
                    <div class="accordion" id="troubleshootingAccordion">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#issue1">
                                        <i class="fas fa-exclamation-triangle text-warning"></i> "No cars available at the moment" message
                                    </button>
                                </h6>
                            </div>
                            <div id="issue1" class="collapse" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <strong>Solution:</strong> Try different dates or locations, or check back later as new cars may be added to the system.
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#issue2">
                                        <i class="fas fa-ban text-danger"></i> Can't access customer dashboard
                                    </button>
                                </h6>
                            </div>
                            <div id="issue2" class="collapse" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <strong>Solution:</strong> Ensure you're logged in with valid customer credentials. Try logging out and back in if the issue persists.
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#issue3">
                                        <i class="fas fa-search-minus text-info"></i> Search form not working
                                    </button>
                                </h6>
                            </div>
                            <div id="issue3" class="collapse" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <strong>Solutions:</strong>
                                    <ul>
                                        <li>Check that all required fields are filled</li>
                                        <li>Ensure dates are in correct mm/dd/yyyy format</li>
                                        <li>Verify pickup date is not in the past</li>
                                        <li>Make sure drop-off date is after pickup date</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#issue4">
                                        <i class="fas fa-bars text-secondary"></i> Sidebar menu not visible
                                    </button>
                                </h6>
                            </div>
                            <div id="issue4" class="collapse" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <strong>Solution:</strong> Click the hamburger menu (☰) in the top-left corner to open the sidebar.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips and Best Practices -->
            <div class="card mb-4" id="tips">
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-lightbulb"></i> Tips for Best Experience</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6><i class="fas fa-user-plus"></i> For New Users</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="small">
                                        <li><strong>Complete your profile</strong> immediately after registration</li>
                                        <li><strong>Upload your driving license</strong> before attempting to book</li>
                                        <li><strong>Familiarize yourself</strong> with the dashboard layout</li>
                                        <li><strong>Start with the search function</strong> on the homepage</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h6><i class="fas fa-car"></i> For Booking Cars</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="small">
                                        <li><strong>Book in advance</strong> for better car availability</li>
                                        <li><strong>Double-check dates and times</strong> before confirming</li>
                                        <li><strong>Review pickup and drop-off locations</strong> carefully</li>
                                        <li><strong>Consider insurance options</strong> for better coverage</li>
                                        <li><strong>Check fuel policy</strong> to understand refueling requirements</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6><i class="fas fa-shield-alt"></i> For Account Security</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="small">
                                        <li><strong>Always logout</strong> when finished using the system</li>
                                        <li><strong>Keep your login credentials</strong> secure and private</li>
                                        <li><strong>Update your profile</strong> with current information</li>
                                        <li><strong>Monitor your rental history</strong> regularly</li>
                                        <li><strong>Keep payment information</strong> up to date</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Reference -->
            <div class="card mb-4" id="quick-reference">
                <div class="card-header">
                    <h3><i class="fas fa-bookmark"></i> Quick Reference</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-sitemap text-primary"></i> Important Sections:</h5>
                            <ul>
                                <li><strong>Homepage:</strong> Car search and system overview</li>
                                <li><strong>Dashboard:</strong> Personal control center</li>
                                <li><strong>Browse Cars:</strong> Available vehicle inventory</li>
                                <li><strong>My Reservations:</strong> Current and upcoming bookings</li>
                                <li><strong>Profile:</strong> Personal information management</li>
                                <li><strong>Rental History:</strong> Past booking records</li>
                                <li><strong>Payment History:</strong> Financial transaction records</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-star text-warning"></i> Key Features:</h5>
                            <ul>
                                <li>Advanced car search with multiple filters</li>
                                <li>Real-time availability checking</li>
                                <li>Comprehensive booking management</li>
                                <li>Secure payment processing</li>
                                <li>Detailed rental history tracking</li>
                                <li>Personalized car recommendations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="card mb-4" id="contact">
                <div class="card-header bg-info text-white">
                    <h3><i class="fas fa-envelope"></i> Getting Help</h3>
                </div>
                <div class="card-body">
                    <p>If you need additional help or have questions not covered in this guide:</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                                <h6>Phone Support</h6>
                                <p class="small">Call us during business hours for immediate assistance</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                                <h6>Email Support</h6>
                                <p class="small">Send us your questions anytime - we'll respond promptly</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-comments fa-3x text-primary mb-3"></i>
                                <h6>Live Chat</h6>
                                <p class="small">Chat with our support team in real-time</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-globe fa-3x text-primary mb-3"></i>
                                <h6>Online Help</h6>
                                <p class="small">Browse our knowledge base and FAQ section</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h6><i class="fas fa-info-circle"></i> Additional Support Tips:</h6>
                        <ul class="mb-0">
                            <li>Use the contact information provided by your rental company</li>
                            <li>Check that you have a stable internet connection</li>
                            <li>Ensure your browser supports JavaScript and cookies</li>
                            <li>Try refreshing the page if elements don't load properly</li>
                            <li>Clear browser cache if experiencing persistent issues</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Navigation Tips -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="fas fa-compass"></i> Navigation Tips</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-mouse-pointer text-primary"></i> Quick Navigation:</h6>
                            <ul>
                                <li><strong>Use the sidebar menu</strong> for quick access to all features</li>
                                <li><strong>Bookmark your dashboard</strong> for faster access</li>
                                <li><strong>The homepage search</strong> is perfect for quick car searches</li>
                                <li><strong>Dashboard recommendations</strong> help find suitable cars based on your history</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-keyboard text-success"></i> Keyboard Shortcuts:</h6>
                            <div class="alert alert-light">
                                <small>
                                    <strong>Tip:</strong> Most modern browsers support tabbing through form fields. 
                                    Use <kbd>Tab</kbd> to move between fields and <kbd>Enter</kbd> to submit forms quickly.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Version Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="fas fa-info"></i> System Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Current Version:</h6>
                            <span class="badge badge-info badge-lg">Version 1.0.0</span>
                        </div>
                        <div class="col-md-6">
                            <h6>Last Updated:</h6>
                            <span class="text-muted">2025</span>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted small">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        <strong>Note:</strong> This user guide is based on the current version (1.0.0) of the Car Rental System. 
                        Features and interface may be updated in future versions. For the most current information, 
                        always refer to the system's help section or contact customer support.
                    </p>
                </div>
            </div>

            <!-- Back to Top Button -->
            <div class="text-center mb-4">
                <a href="#top" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-up"></i> Back to Top
                </a>
            </div>

            <!-- Footer -->
            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <h5><i class="fas fa-heart text-danger"></i> Thank you for using our Car Rental System!</h5>
                    <p class="mb-0">© 2025 Car Rental System. All rights reserved.</p>
                    <small class="text-muted">
                        Need help? Contact our support team for assistance with any questions or issues.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add smooth scrolling and enhanced interactivity -->
<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add active state to navigation links
document.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('[id]');
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active', 'font-weight-bold');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active', 'font-weight-bold');
        }
    });
});

// Initialize tooltips if Bootstrap is available
$(document).ready(function() {
    if (typeof $().tooltip === 'function') {
        $('[data-toggle="tooltip"]').tooltip();
    }
});

// Add search functionality for the guide
function addSearchFunctionality() {
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search this guide...';
    searchInput.className = 'form-control mb-3';
    searchInput.id = 'guideSearch';
    
    const firstCard = document.querySelector('.card');
    if (firstCard) {
        firstCard.parentNode.insertBefore(searchInput, firstCard);
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
}

// Initialize search functionality
document.addEventListener('DOMContentLoaded', addSearchFunctionality);
</script>

<!-- Additional CSS for enhanced styling -->
<style>
.card-header {
    font-weight: 600;
}

.badge-lg {
    font-size: 1em;
    padding: 0.5em 0.75em;
}

.list-group-item {
    border: none;
    padding: 0.25rem 0;
}

.accordion .card {
    border: 1px solid #dee2e6;
}

a.active {
    color: #007bff !important;
    text-decoration: underline;
}

.alert ul {
    padding-left: 1.5rem;
}

.small {
    font-size: 0.875rem;
}

kbd {
    background-color: #212529;
    color: #fff;
    padding: 0.2rem 0.4rem;
    border-radius: 0.2rem;
}

#guideSearch {
    position: sticky;
    top: 20px;
    z-index: 100;
    background: white;
    border: 2px solid #007bff;
}

.fa-2x, .fa-3x {
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .card-body .row .col-md-3,
    .card-body .row .col-md-4,
    .card-body .row .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/user-guide.blade.php ENDPATH**/ ?>