

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title mb-0">Dashboard</h1>
        <div class="page-actions">
            <button class="btn btn-primary">
                <a href="<?php echo e(route('carowner.rentCar')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Car
                </a>

            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                        <i class="fas fa-car fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">My Cars</h6>
                        <h2 class="mb-0 fw-bold">12</h2>
                        <small class="text-muted">Total registered cars</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Approved</h6>
                        <h2 class="mb-0 fw-bold text-success">8</h2>
                        <small class="text-muted">Cars ready for rent</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Pending</h6>
                        <h2 class="mb-0 fw-bold text-warning">3</h2>
                        <small class="text-muted">Awaiting approval</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Rejected</h6>
                        <h2 class="mb-0 fw-bold text-danger">1</h2>
                        <small class="text-muted">Denied applications</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt text-primary me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo e(route('carowner.rentCar')); ?>" class="text-decoration-none">
                            <div class="action-card border rounded-3 p-4 h-100 text-center hover-shadow transition-all">
                                <div class="action-icon text-primary mb-3">
                                    <i class="fas fa-car-side fa-3x"></i>
                                </div>
                                <h6 class="fw-semibold mb-2">Rent A Car</h6>
                                <p class="text-muted small mb-0">Submit a new car for rental</p>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo e(route('carowner.car-inspection')); ?>" class="text-decoration-none position-relative">
                            <div class="action-card border rounded-3 p-4 h-100 text-center hover-shadow transition-all">
                                <div class="action-icon text-warning mb-3">
                                    <i class="fas fa-clipboard-check fa-3x"></i>
                                </div>
                                <h6 class="fw-semibold mb-2">Inspection Requests</h6>
                                <p class="text-muted small mb-0">View pending inspections</p>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    2
                                </span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo e(url('carowner/payment-summary')); ?>" class="text-decoration-none">
                            <div class="action-card border rounded-3 p-4 h-100 text-center hover-shadow transition-all">
                                <div class="action-icon text-success mb-3">
                                    <i class="fas fa-wallet fa-3x"></i>
                                </div>
                                <h6 class="fw-semibold mb-2">Payment Summary</h6>
                                <p class="text-muted small mb-0">View your earnings</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history text-primary me-2"></i>Recent Activities
                </h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    <div class="activity-item d-flex align-items-start mb-4">
                        <div class="activity-icon bg-success bg-opacity-10 text-success rounded-circle p-2 me-3 flex-shrink-0">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h6 class="mb-1 fw-semibold">Car Approved</h6>
                            <p class="text-muted mb-1">Your Toyota Camry has been approved for rental</p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>Today, 10:30 AM
                            </small>
                        </div>
                    </div>
                    
                    <div class="activity-item d-flex align-items-start mb-4">
                        <div class="activity-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 flex-shrink-0">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h6 class="mb-1 fw-semibold">Car Registration</h6>
                            <p class="text-muted mb-1">You registered Honda Civic for inspection</p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>Yesterday, 3:45 PM
                            </small>
                        </div>
                    </div>
                    
                    <div class="activity-item d-flex align-items-start">
                        <div class="activity-icon bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3 flex-shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h6 class="mb-1 fw-semibold">Inspection Scheduled</h6>
                            <p class="text-muted mb-1">Inspection for BMW X5 scheduled on May 25, 2025</p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>May 20, 2025, 11:20 AM
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line text-primary me-2"></i>Monthly Earnings
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h2 class="text-success fw-bold mb-1">$2,450</h2>
                    <small class="text-muted">This month</small>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                </div>
                <div class="d-flex justify-content-between text-muted small">
                    <span>Goal: $3,000</span>
                    <span>75%</span>
                </div>
                
                <hr class="my-3">
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Active Rentals</span>
                    <span class="fw-semibold">5</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Avg. Daily Rate</span>
                    <span class="fw-semibold">$85</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Customer Rating</span>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-dark ms-1">4.8</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
}

.action-card {
    transition: all 0.3s ease;
    border: 2px solid transparent !important;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--bs-primary) !important;
}

.hover-shadow {
    transition: box-shadow 0.3s ease;
}

.transition-all {
    transition: all 0.3s ease;
}

.activity-timeline {
    position: relative;
}

.activity-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 20px;
    top: 45px;
    width: 2px;
    height: 30px;
    background: #e9ecef;
    z-index: 1;
}

.activity-icon {
    position: relative;
    z-index: 2;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-title {
    color: #2c3e50;
    font-weight: 600;
}

.card {
    border-radius: 12px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .action-card {
        margin-bottom: 1rem;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling animation for cards
    const cards = document.querySelectorAll('.stat-card, .action-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Add click animation for action cards
    document.querySelectorAll('.action-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});
</script>

<style>
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.carowner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/dashboard.blade.php ENDPATH**/ ?>