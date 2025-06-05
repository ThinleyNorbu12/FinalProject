

<?php $__env->startSection('title', 'Approved Cars'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item active">Approved Cars</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h2 class="mb-0">
        <i class="fas fa-check-circle me-2 text-success"></i>
        Approved Cars
    </h2>
    <span class="badge bg-success fs-6"><?php echo e($approvedCars->count()); ?> Car(s)</span>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <?php if($approvedCars->count() > 0): ?>
            <!-- Cards View for Mobile/Tablet -->
            <div class="d-lg-none">
                <div class="row">
                    <?php $__currentLoopData = $approvedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-header bg-success text-white border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="fas fa-car me-2"></i>
                                            <?php echo e($car->maker); ?> <?php echo e($car->model); ?>

                                        </h5>
                                        <span class="badge bg-light text-success fs-6">
                                            #<?php echo e($loop->iteration); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="info-item">
                                                <i class="fas fa-car-side text-primary me-2"></i>
                                                <strong>Type:</strong>
                                                <span class="d-block text-muted"><?php echo e($car->vehicle_type); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-item">
                                                <i class="fas fa-cogs text-primary me-2"></i>
                                                <strong>Condition:</strong>
                                                <span class="d-block text-muted"><?php echo e($car->car_condition); ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6">
                                            <div class="info-item">
                                                <i class="fas fa-hashtag text-primary me-2"></i>
                                                <strong>Reg. No:</strong>
                                                <span class="d-block text-muted"><?php echo e($car->registration_no); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Approved Car
                                        </small>
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Table View for Desktop -->
            <div class="d-none d-lg-block">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-muted">
                                <i class="fas fa-table me-2"></i>
                                Cars Overview
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary btn-sm" onclick="exportTable()">
                                    <i class="fas fa-download me-1"></i>
                                    Export
                                </button>
                                <div class="input-group" style="width: 250px;">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search cars...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="approvedCarsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-hashtag me-2 text-muted"></i>
                                            Sl. No
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-industry me-2 text-muted"></i>
                                            Maker
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-car me-2 text-muted"></i>
                                            Model
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-car-side me-2 text-muted"></i>
                                            Vehicle Type
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-cogs me-2 text-muted"></i>
                                            Condition
                                        </th>
                                        
                                        <th class="border-0 py-3">
                                            <i class="fas fa-id-card me-2 text-muted"></i>
                                            Registration No
                                        </th>
                                        <!-- <th class="border-0 py-3 text-center">
                                            <i class="fas fa-cog me-2 text-muted"></i>
                                            Actions
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $approvedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="searchable-row">
                                            <td class="py-3">
                                                <span class="badge bg-light text-dark fs-6"><?php echo e($loop->iteration); ?></span>
                                            </td>
                                            <td class="py-3">
                                                <div class="fw-medium"><?php echo e($car->maker); ?></div>
                                            </td>
                                            <td class="py-3">
                                                <div class="fw-medium"><?php echo e($car->model); ?></div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <?php echo e($car->vehicle_type); ?>

                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-<?php echo e($car->car_condition === 'Excellent' ? 'success' : ($car->car_condition === 'Good' ? 'info' : 'warning')); ?> bg-opacity-10 text-<?php echo e($car->car_condition === 'Excellent' ? 'success' : ($car->car_condition === 'Good' ? 'info' : 'warning')); ?>">
                                                    <?php echo e($car->car_condition); ?>

                                                </span>
                                            </td>
                                            
                                            <td class="py-3">
                                                <code class="bg-light text-dark p-1 rounded"><?php echo e($car->registration_no); ?></code>
                                            </td>
                                            <!-- <td class="py-3 text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-primary btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination or Summary Footer -->
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Showing <?php echo e($approvedCars->count()); ?> approved cars
                            </small>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success"></i>
                                <small class="text-success fw-medium">All cars are approved and ready for rental</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-car fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted mb-2">No Approved Cars</h4>
                <p class="text-muted mb-4">You don't have any approved cars at the moment.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="<?php echo e(route('carowner.dashboard')); ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Dashboard
                    </a>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add New Car
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.searchable-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
        
        // Update showing count
        const visibleRows = document.querySelectorAll('.searchable-row[style=""]').length;
        const showingText = document.querySelector('.card-footer small');
        if (showingText) {
            showingText.textContent = `Showing ${visibleRows} of <?php echo e($approvedCars->count()); ?> approved cars`;
        }
    });

    // Export functionality (basic)
    function exportTable() {
        const table = document.getElementById('approvedCarsTable');
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const cols = row.querySelectorAll('td, th');
            const rowData = [];
            cols.forEach((col, index) => {
                if (index < cols.length - 1) { // Skip actions column
                    rowData.push(col.textContent.trim());
                }
            });
            csv.push(rowData.join(','));
        });
        
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('hidden', '');
        a.setAttribute('href', url);
        a.setAttribute('download', 'approved_cars.csv');
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    // Add hover effects to table rows
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    // Auto-dismiss alerts
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>

<?php $__env->startPush('styles'); ?>
<style>
    .info-item {
        padding: 8px 0;
    }
    
    .info-item strong {
        font-size: 0.85rem;
        color: #495057;
    }
    
    .card {
        transition: all 0.2s ease;
        border-radius: 12px;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table td {
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa !important;
    }
    
    .badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-weight: 500;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
    }
    
    .btn-group .btn {
        border-radius: 6px;
    }
    
    code {
        font-size: 0.85rem;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    
    .input-group .form-control {
        border-left: none;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    
    @media (max-width: 991px) {
        .card {
            margin-bottom: 1rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.carowner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/approved-cars.blade.php ENDPATH**/ ?>