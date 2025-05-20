@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
<!-- Main Content -->
<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
            <h2>Admin Portal</h2>
        </div>
        <button id="sidebar-toggle" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div> 
    <div class="admin-profile">
        @if(Auth::guard('admin')->check())
            <div class="profile-avatar">
                <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar">
            </div>
            <div class="profile-info">
                <h3>{{ Auth::guard('admin')->user()->name }}</h3>
                <span>Administrator</span>
            </div>
        @endif
    </div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Car Owner</div>

            <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item ">
                <i class="fas fa-car"></i>
                <span>Car Registration</span>
            </a>

            <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item">
                <i class="fas fa-clipboard-check"></i>
                <span>Inspection Requests</span>
            </a>

            <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item">
                <i class="fas fa-check-circle"></i>
                <span>Approve Inspections</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Customer</div>

            <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item">
                <i class="fas fa-id-card"></i>
                <span>Verify Users</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="sidebar-menu-item">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>

            <a href="{{ url('admin/update-car-registration') }}" class="sidebar-menu-item">
                <i class="fas fa-edit"></i>
                <span>Update Registration</span>
            </a>

            <a href="{{ url('admin/car-information-update') }}" class="sidebar-menu-item">
                <i class="fas fa-info-circle"></i>
                <span>Car Information</span>
            </a>

            <a href="{{ route ('admin.booked-car') }}" class="sidebar-menu-item active">
                <i class="fas fa-calendar-check"></i>
                <span>Booked Cars</span>
            </a>

            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>

            <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" style="display: none;">
                @csrf
            </form>
        </div>
    </div>       
</div>
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Booked Cars</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booked Cars</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Section -->
    <div class="filter-section card">
        <div class="card-body">
            <form action="{{ route('admin.booked-car.filter') }}" method="GET" class="row g-3 align-items-center">
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
                    <a href="{{ route('admin.booked-car') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Status Summary Cards -->
    <div class="booking-summary">
        <div class="row mt-4">
            <div class="col-md-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">All Bookings</h5>
                        <p class="card-text fs-2">{{ array_sum($statusCounts) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Pending</h5>
                        <p class="card-text fs-2">{{ $statusCounts['pending'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Confirmed</h5>
                        <p class="card-text fs-2">{{ $statusCounts['confirmed'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Verification</h5>
                        <p class="card-text fs-2">{{ $statusCounts['pending_verification'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Cancelled</h5>
                        <p class="card-text fs-2">{{ $statusCounts['cancelled'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Completed</h5>
                        <p class="card-text fs-2">{{ $statusCounts['completed'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Search -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Car Bookings</h5>
            <div class="export-options">
                <button class="btn btn-sm btn-outline-secondary" id="export-csv">Export CSV</button>
                <button class="btn btn-sm btn-outline-secondary" id="export-pdf">Export PDF</button>
            </div>
        </div>
        <div class="card-body">
            <!-- DataTable will automatically add the search box here -->
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
                        @forelse ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                @if($booking->car)
                                    {{ $booking->car->brand }} {{ $booking->car->model }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($booking->customer)
                                    {{ $booking->customer->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $booking->pickup_location }}</td>
                            <td data-sort="{{ $booking->pickup_datetime->format('Y-m-d H:i:s') }}">
                                {{ $booking->pickup_datetime->format('M d, Y h:i A') }}
                            </td>
                            <td data-sort="{{ $booking->dropoff_datetime->format('Y-m-d H:i:s') }}">
                                {{ $booking->dropoff_datetime->format('M d, Y h:i A') }}
                            </td>
                            <td>
                                @if($booking->payment && $booking->payment->status === 'completed')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($booking->payment && $booking->payment->status === 'pending_verification')
                                    <span class="badge bg-warning">Pending Verification</span>
                                @elseif($booking->payment)
                                    <span class="badge bg-danger">{{ ucfirst($booking->payment->status) }}</span>
                                @else
                                    <span class="badge bg-secondary">No Payment</span>
                                @endif
                            </td>
                            <td>
                                @switch($booking->status)
                                    @case('confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('pending_verification')
                                        <span class="badge bg-info">Verification</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-secondary">Completed</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.booked-car.show', $booking->id) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal{{ $booking->id }}" title="Update Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>

                                <!-- Status Update Modal -->
                                <div class="modal fade" id="statusModal{{ $booking->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $booking->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="statusModalLabel{{ $booking->id }}">Update Booking Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.booked-car.update-status', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" id="status" class="form-select">
                                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="pending_verification" {{ $booking->status == 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No bookings found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    /* Custom styles for the search box */
    #bookings-table_filter {
        margin-bottom: 15px;
    }
    
    #live-search {
        width: 300px;
        max-width: 100%;
    }
    
    .responsive-wrapper {
        width: 100%;
        overflow-x: auto;
    }
    
    /* Custom styles for the table */
    #bookings-table {
        width: 100% !important;
    }
    
    /* Highlight search terms */
    .highlight {
        background-color: #ffff99;
        padding: 2px;
    }
</style>
@endsection

@section('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Include your custom script -->

<!-- Inline script for existing functionality -->
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
            ]
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
@endsection