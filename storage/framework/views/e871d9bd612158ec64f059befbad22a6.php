

<?php $__env->startSection('title', 'Car Registration'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Car Registration</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-car me-2"></i>
            Car Registration Request
        </h1>
        <div class="page-actions">
            <!-- Add any action buttons here if needed -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/newly-registered-cars.css')); ?>">
<style>
    .search-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .search-input {
        border-radius: 25px;
        padding: 12px 20px;
        border: 1px solid #ddd;
    }
    .search-btn {
        border-radius: 25px;
        padding: 12px 30px;
    }
    .clear-btn {
        border-radius: 25px;
        padding: 12px 20px;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-top: none;
    }
    .registration-date {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    /* Success Modal Styles */
    .success-message {
        font-family: 'Courier New', monospace;
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border-left: 4px solid #28a745;
        white-space: pre-line;
        line-height: 1.6;
    }
    .success-message strong {
        font-weight: bold;
    }
    .success-message code {
        background-color: #e9ecef;
        padding: 2px 4px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Live Search Bar -->
    <div class="search-container">
        <div class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search" id="search-icon"></i>
                        <i class="fas fa-spinner fa-spin d-none" id="loading-icon"></i>
                    </span>
                    <input 
                        type="text" 
                        id="live-search" 
                        class="form-control search-input" 
                        placeholder="Search by Maker, Model, Vehicle Type, Price, Registration Number, or Status..." 
                        value="<?php echo e(request('search')); ?>"
                        autocomplete="off"
                    >
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="button" id="clear-search" class="btn btn-outline-secondary clear-btn <?php echo e(request('search') ? '' : 'd-none'); ?>">
                        <i class="fas fa-times me-1"></i> Clear
                    </button>
                </div>
            </div>
        </div>
        <div id="search-status" class="mt-2 text-muted small d-none">
            <i class="fas fa-info-circle me-1"></i>
            <span id="search-text"></span>
        </div>
    </div>

    <?php if($cars->isEmpty()): ?>
        <div class="card">
            <div class="card-body">
                <div class="empty-message text-center py-5">
                    <i class="fas fa-car fa-3x mb-3" style="color: #ccc;"></i>
                    <?php if(request('search')): ?>
                        <h4>No Car Registration Requests Found</h4>
                        <p class="mb-3">No car registration requests match your search criteria: "<strong><?php echo e(request('search')); ?></strong>"</p>
                        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i> View All Requests
                        </a>
                    <?php else: ?>
                        <h4>No Car Registration Requests</h4>
                        <p class="mb-0">There are currently no car registration requests to review.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Registration Requests (<?php echo e($cars->count()); ?>)
                    <?php if(request('search')): ?>
                        <small class="text-muted">- Search: "<?php echo e(request('search')); ?>"</small>
                    <?php endif; ?>
                </h5>
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Sorted by most recent registration
                </small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div id="search-results">
                        <div id="no-results" class="text-center py-4 d-none">
                            <i class="fas fa-search fa-2x mb-3 text-muted"></i>
                            <h5>No results found</h5>
                            <p class="text-muted">Try adjusting your search terms</p>
                        </div>
                        <table class="table table-hover mb-0" id="cars-table">
                        <thead>
                            <tr>
                                <th>Registration Date</th>
                                <th>Maker</th>
                                <th>Model</th>
                                <th>Vehicle Type</th>
                                <th>Price per Day</th>
                                <th>Registration Number</th>
                                <th>Status</th>
                                <th>Car Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="registration-date">
                                            <div class="fw-medium"><?php echo e($car->created_at->format('M d, Y')); ?></div>
                                            <small class="text-muted"><?php echo e($car->created_at->format('h:i A')); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium"><?php echo e($car->maker); ?></span>
                                    </td>
                                    <td><?php echo e($car->model); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($car->vehicle_type); ?></span>
                                    </td>
                                    <td>
                                        <span class="fw-medium text-success">BTN <?php echo e(number_format($car->price, 2)); ?></span>
                                    </td>
                                    <td>
                                        <code><?php echo e($car->registration_no); ?></code>
                                    </td>
                                    <td>
                                        <?php if(strtolower($car->status) === 'pending'): ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>
                                                Pending
                                            </span>
                                        <?php elseif(strtolower($car->status) === 'approved'): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                Approved
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-info">
                                                <?php echo e(ucfirst($car->status)); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($car->car_image): ?>
                                            <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-image"></i> No image
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('car-admin.view-car', $car->id)); ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>                            
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php if(method_exists($cars, 'links')): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($cars->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php if(session('success')): ?>
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="success-message">
                    <?php echo nl2br(e(session('success'))); ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-thumbs-up me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('live-search');
        const searchIcon = document.getElementById('search-icon');
        const loadingIcon = document.getElementById('loading-icon');
        const clearBtn = document.getElementById('clear-search');
        const searchStatus = document.getElementById('search-status');
        const searchText = document.getElementById('search-text');
        const carsTable = document.getElementById('cars-table');
        const noResults = document.getElementById('no-results');
        
        let searchTimeout;
        let originalTableContent = carsTable.innerHTML;
        
        // Live search functionality
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            if (query.length === 0) {
                // Reset to original content
                carsTable.innerHTML = originalTableContent;
                noResults.classList.add('d-none');
                clearBtn.classList.add('d-none');
                searchStatus.classList.add('d-none');
                return;
            }
            
            if (query.length < 2) {
                return; // Wait for at least 2 characters
            }
            
            // Show loading state
            searchIcon.classList.add('d-none');
            loadingIcon.classList.remove('d-none');
            clearBtn.classList.remove('d-none');
            
            // Debounce search
            searchTimeout = setTimeout(() => {
                performLiveSearch(query);
            }, 300);
        });
        
        // Clear search functionality
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            carsTable.innerHTML = originalTableContent;
            noResults.classList.add('d-none');
            this.classList.add('d-none');
            searchStatus.classList.add('d-none');
            searchInput.focus();
        });
        
        // Perform live search
        function performLiveSearch(query) {
            fetch(`<?php echo e(route('car-admin.live-search')); ?>?search=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading state
                searchIcon.classList.remove('d-none');
                loadingIcon.classList.add('d-none');
                
                if (data.success) {
                    if (data.cars.length > 0) {
                        renderSearchResults(data.cars);
                        noResults.classList.add('d-none');
                        
                        // Show search status
                        searchStatus.classList.remove('d-none');
                        searchText.textContent = `Found ${data.cars.length} result(s) for "${query}"`;
                    } else {
                        carsTable.querySelector('tbody').innerHTML = '';
                        noResults.classList.remove('d-none');
                        searchStatus.classList.remove('d-none');
                        searchText.textContent = `No results found for "${query}"`;
                    }
                } else {
                    console.error('Search failed:', data.message);
                    // Show error message
                    searchStatus.classList.remove('d-none');
                    searchText.textContent = 'Search failed. Please try again.';
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                searchIcon.classList.remove('d-none');
                loadingIcon.classList.add('d-none');
                searchStatus.classList.remove('d-none');
                searchText.textContent = 'Search failed. Please try again.';
            });
        }
        
        // Render search results
        function renderSearchResults(cars) {
            const tbody = carsTable.querySelector('tbody');
            tbody.innerHTML = '';
            
            cars.forEach(car => {
                const row = document.createElement('tr');
                
                // Format date
                const createdAt = new Date(car.created_at);
                const formattedDate = createdAt.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                const formattedTime = createdAt.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
                
                // Create status badge
                let statusBadge = '';
                if (car.status.toLowerCase() === 'pending') {
                    statusBadge = `<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>`;
                } else if (car.status.toLowerCase() === 'approved') {
                    statusBadge = `<span class="badge bg-success"><i class="fas fa-check me-1"></i>Approved</span>`;
                } else {
                    statusBadge = `<span class="badge bg-info">${car.status.charAt(0).toUpperCase() + car.status.slice(1)}</span>`;
                }
                
                // Create car image
                let carImage = '';
                if (car.car_image) {
                    carImage = `<img src="<?php echo e(asset('')); ?>${car.car_image}" alt="Car Image" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">`;
                } else {
                    carImage = `<span class="text-muted"><i class="fas fa-image"></i> No image</span>`;
                }
                
                row.innerHTML = `
                    <td>
                        <div class="registration-date">
                            <div class="fw-medium">${formattedDate}</div>
                            <small class="text-muted">${formattedTime}</small>
                        </div>
                    </td>
                    <td><span class="fw-medium">${car.maker}</span></td>
                    <td>${car.model}</td>
                    <td><span class="badge bg-secondary">${car.vehicle_type}</span></td>
                    <td><span class="fw-medium text-success">${parseFloat(car.price).toFixed(2)}</span></td>
                    <td><code>${car.registration_no}</code></td>
                    <td>${statusBadge}</td>
                    <td>${carImage}</td>
                    <td>
                        <a href="/car-admin/view-car/${car.id}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }
        
        // Search input focus enhancement
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('shadow-sm');
            });
            
            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('shadow-sm');
            });
        }
    });

    // Success Modal functionality
    $(document).ready(function() {
        <?php if(session('success')): ?>
            $('#successModal').modal('show');
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/newly-registered-cars.blade.php ENDPATH**/ ?>