

<?php $__env->startSection('title', 'Booked Cars'); ?>
<?php $__env->startPush('styles'); ?>
     <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/bookedcar.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header mb-4">
    <h1>Booked Cars</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Booked Cars</li>
        </ol>
    </nav>
</div>

<!-- Filter Section -->
<div class="filter-section card mb-4">
    <div class="card-body">
        <form action="<?php echo e(route('admin.booked-car.filter')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Bookings</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="pending_verification">Pending Verification</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_range" class="form-label">Date Range</label>
                <input type="text" id="date_range" class="form-control" placeholder="Select date range">
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
            </div>
            <div class="col-md-2 align-self-end">
                <a href="<?php echo e(route('admin.booked-car')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Status Summary Cards -->
<div class="booking-summary mb-4">
    <div class="row">
        <div class="col-md-2">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">All Bookings</h5>
                    <p class="card-text fs-2"><?php echo e(array_sum($statusCounts)); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <p class="card-text fs-2"><?php echo e($statusCounts['pending'] ?? 0); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Confirmed</h5>
                    <p class="card-text fs-2"><?php echo e($statusCounts['confirmed'] ?? 0); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Verification</h5>
                    <p class="card-text fs-2"><?php echo e($statusCounts['pending_verification'] ?? 0); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Cancelled</h5>
                    <p class="card-text fs-2"><?php echo e($statusCounts['cancelled'] ?? 0); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <p class="card-text fs-2"><?php echo e($statusCounts['completed'] ?? 0); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Car Bookings</h5>
        <div class="export-options">
            <button class="btn btn-sm btn-outline-secondary" id="export-csv">Export CSV</button>
            <button class="btn btn-sm btn-outline-secondary" id="export-pdf">Export PDF</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="bookings-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Customer</th>
                        <th>Pickup Location</th>
                        <th>Pickup Date & Time</th>
                        <th>Return Date & Time</th>
                        <th>Payment Status</th>
                        <th>Booking Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($booking->id); ?></td>
                        <td>
                            <?php if($booking->car): ?>
                                <?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($booking->customer): ?>
                                <?php echo e($booking->customer->name); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($booking->pickup_location); ?></td>
                        <td data-sort="<?php echo e($booking->pickup_datetime->format('Y-m-d H:i:s')); ?>">
                            <?php echo e($booking->pickup_datetime->format('M d, Y h:i A')); ?>

                        </td>
                        <td data-sort="<?php echo e($booking->dropoff_datetime->format('Y-m-d H:i:s')); ?>">
                            <?php echo e($booking->dropoff_datetime->format('M d, Y h:i A')); ?>

                        </td>
                        <td>
                            <?php if($booking->payment && $booking->payment->status === 'completed'): ?>
                                <span class="badge bg-success">Paid</span>
                            <?php elseif($booking->payment && $booking->payment->status === 'pending_verification'): ?>
                                <span class="badge bg-warning">Pending Verification</span>
                            <?php elseif($booking->payment): ?>
                                <span class="badge bg-danger"><?php echo e(ucfirst($booking->payment->status)); ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">No Payment</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php switch($booking->status):
                                case ('confirmed'): ?>
                                    <span class="badge bg-success">Confirmed</span>
                                    <?php break; ?>
                                <?php case ('pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                    <?php break; ?>
                                <?php case ('pending_verification'): ?>
                                    <span class="badge bg-info">Verification</span>
                                    <?php break; ?>
                                <?php case ('cancelled'): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                    <?php break; ?>
                                <?php case ('completed'): ?>
                                    <span class="badge bg-secondary">Completed</span>
                                    <?php break; ?>
                                <?php default: ?>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($booking->status)); ?></span>
                            <?php endswitch; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo e(route('admin.booked-car.show', $booking->id)); ?>" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                            </div>

                            <!-- Status Update Modal -->
                            
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center">No bookings found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
    $(document).ready(function() {
        // Initialize date range picker
        $('#date_range').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Set active status filter based on URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        if (statusParam) {
            $('#status').val(statusParam);
        }

        // Initialize DataTables with chronological sorting and live search
        const bookingTable = $('#bookings-table').DataTable({
            order: [[4, 'asc']], // Sort by pickup date (column 4) ascending
            pageLength: 15,      // Show 15 entries per page
            lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "All"]],
            dom: '<"top"fl>rt<"bottom"ip><"clear">',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search bookings...",
                lengthMenu: "Show _MENU_ bookings",
                info: "Showing _START_ to _END_ of _TOTAL_ bookings",
                infoEmpty: "Showing 0 to 0 of 0 bookings",
                infoFiltered: "(filtered from _MAX_ total bookings)"
            },
            columnDefs: [
                { targets: -1, orderable: false } // Disable sorting on Actions column
            ],
            responsive: true
        });

        // Add search box above the table
        $('#bookings-table_filter').addClass('mb-2');
        $('#bookings-table_filter input').addClass('form-control');
        $('#bookings-table_filter input').attr('id', 'live-search');
        $('#bookings-table_filter').prepend('<label for="live-search" class="form-label">Live Search:</label><br>');
        
        // Make the design responsive
        $('#bookings-table_wrapper').addClass('responsive-wrapper');
        
        // Add custom filtering functionality
        $('#live-search').on('keyup', function() {
            bookingTable.search(this.value).draw();
        });
        
        // Apply status filter from the main filter form to DataTable
        $('#status').on('change', function() {
            let selectedStatus = $(this).val();
            
            // Clear any existing filter before applying a new one
            bookingTable.column(7).search('').draw();
            
            if (selectedStatus) {
                // Apply filter based on the selected status
                bookingTable.column(7).search(selectedStatus, true, false).draw();
            }
        });
        
        // Handle export buttons
        $('#export-csv').on('click', function() {
            // Create a CSV export of the current filtered data
            exportTableToCSV($('#bookings-table'), 'car_bookings.csv');
        });
        
        $('#export-pdf').on('click', function() {
            // For PDF export you'd typically use a library like jsPDF
            alert('PDF export functionality will be implemented with a library like jsPDF');
        });

        // Add click functionality to status cards for filtering
        $('.booking-summary .card').on('click', function() {
            const cardTitle = $(this).find('.card-title').text().toLowerCase();
            let statusValue = '';
            
            switch(cardTitle) {
                case 'pending':
                    statusValue = 'pending';
                    break;
                case 'confirmed':
                    statusValue = 'confirmed';
                    break;
                case 'verification':
                    statusValue = 'pending_verification';
                    break;
                case 'cancelled':
                    statusValue = 'cancelled';
                    break;
                case 'completed':
                    statusValue = 'completed';
                    break;
                default:
                    statusValue = '';
            }
            
            $('#status').val(statusValue).trigger('change');
        });
    });
    
    // Helper function for CSV export
    function exportTableToCSV($table, filename) {
        const $rows = $table.find('tr:has(td,th)'),
            tmpColDelim = String.fromCharCode(11), // vertical tab as a delimiter
            tmpRowDelim = String.fromCharCode(0), // null character as a delimiter
            colDelim = '","',
            rowDelim = '"\r\n"';
            
        let csv = '"';
        
        // Get headers
        $rows.each(function() {
            const $cells = $(this).find('th, td');
            $cells.each(function(i) {
                // Don't include the actions column
                if (i < $cells.length - 1) {
                    // Get the text content
                    csv += $(this).text().replace(/"/g, '""').replace(/\s+/g, ' ').trim();
                    
                    // Add delimiter except for the last cell
                    if (i < $cells.length - 2) {
                        csv += tmpColDelim;
                    }
                }
            });
            
            csv += tmpRowDelim;
        });
        
        // Process to CSV format
        csv = csv
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim);
            
        // Add closing quotes
        csv += '"';
        
        // Create download link
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8' });
        const link = document.createElement('a');
        
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, filename);
        } else {
            link.href = URL.createObjectURL(blob);
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/booked-car.blade.php ENDPATH**/ ?>