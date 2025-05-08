@extends('layouts.app')

@section('content')
<style>
    /* Add these styles to your dashboard.css file */

/* Verify Users List Page */
.verify-users .section-header {
    margin-bottom: 25px;
}

.verify-users .section-header h1 {
    color: #333;
    font-size: 24px;
    margin-bottom: 5px;
}

.verify-users .section-header p {
    color: #666;
    font-size: 16px;
}

.filters-section {
    background-color: #f7f7f7;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.filter-container {
    display: flex;
    gap: 15px;
    align-items: center;
}

.filter-container select,
.filter-container input {
    flex: 1;
}

.licenses-container {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: bold;
}

.user-email {
    font-size: 12px;
    color: #666;
}

.status-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-pending {
    background-color: #ffeeba;
    color: #856404;
}

.status-verified {
    background-color: #d4edda;
    color: #155724;
}

.status-rejected {
    background-color: #f8d7da;
    color: #721c24;
}

.btn-group {
    display: flex;
    gap: 5px;
}

.pagination-container {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

/* Verify User Details Page */
.verify-user-details .section-header {
    margin-bottom: 25px;
}

.verify-user-details .section-header h1 {
    color: #333;
    font-size: 24px;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.user-info-card .card-body,
.license-info-card .card-body {
    padding: 20px;
}

.user-detail-item,
.license-detail-item {
    margin-bottom: 12px;
    display: flex;
    flex-wrap: wrap;
}

.user-detail-item .label,
.license-detail-item .label {
    font-weight: 600;
    color: #555;
    width: 40%;
}

.user-detail-item .value,
.license-detail-item .value {
    width: 60%;
    color: #333;
}

.license-details {
    margin-bottom: 25px;
}

.license-images h4,
.license-actions h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e9ecef;
}

.license-image-container {
    margin-bottom: 20px;
}

.license-image-container h5 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}

.image-preview {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    margin-bottom: 10px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #f8f9fa;
    cursor: pointer;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.license-actions .btn-group {
    display: flex;
    gap: 10px;
}
</style>

<div class="container verify-users">
    <div class="section-header">
        <h1><i class="fas fa-id-card"></i> Verify User Licenses</h1>
        <p>Review and verify customer driving licenses</p>
    </div>

    <div class="filters-section">
        <div class="filter-container">
            <select id="status-filter" class="form-control">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Verified">Verified</option>
                <option value="Rejected">Rejected</option>
            </select>
            <input type="text" id="search-filter" class="form-control" placeholder="Search by name, email, or license no.">
            <button class="btn btn-primary" id="apply-filters"><i class="fas fa-filter"></i> Apply Filters</button>
        </div>
    </div>

    <div class="licenses-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>License No.</th>
                    <th>Issue Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($licenses as $license)
                <tr>
                    <td>
                        <div class="user-info">
                            <span class="user-name">{{ $license->customer->name }}</span>
                            <span class="user-email">{{ $license->customer->email }}</span>
                        </div>
                    </td>
                    <td>{{ $license->license_no }}</td>
                    <td>{{ $license->issue_date->format('M d, Y') }}</td>
                    <td>{{ $license->expiry_date->format('M d, Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($license->status) }}">
                            {{ $license->status }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.verify-user-details', $license->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if($license->status == 'Pending')
                            <button type="button" class="btn btn-sm btn-success verify-btn" data-id="{{ $license->id }}">
                                <i class="fas fa-check"></i> Verify
                            </button>
                            <button type="button" class="btn btn-sm btn-danger reject-btn" data-id="{{ $license->id }}">
                                <i class="fas fa-times"></i> Reject
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No licenses found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $licenses->links() }}
        </div>
    </div>
</div>

<!-- Modal for rejection reason -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reject-form" action="{{ route('admin.reject-license') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="license_id" id="reject-license-id">
                    <div class="form-group">
                        <label for="rejection-reason">Please provide a reason for rejection:</label>
                        <textarea class="form-control" id="rejection-reason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject License</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle verify button click
        $('.verify-btn').on('click', function() {
            let licenseId = $(this).data('id');
            if (confirm('Are you sure you want to verify this license?')) {
                $.ajax({
                    url: "{{ route('admin.verify-license') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        license_id: licenseId
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error verifying license. Please try again.');
                    }
                });
            }
        });

        // Handle reject button click - show modal
        $('.reject-btn').on('click', function() {
            let licenseId = $(this).data('id');
            $('#reject-license-id').val(licenseId);
            $('#rejectModal').modal('show');
        });

        // Handle filter application
        $('#apply-filters').on('click', function() {
            let status = $('#status-filter').val();
            let search = $('#search-filter').val();
            
            window.location.href = "{{ route('admin.verify-users') }}" + 
                                  "?status=" + status + 
                                  "&search=" + search;
        });
    });
</script>
@endsection