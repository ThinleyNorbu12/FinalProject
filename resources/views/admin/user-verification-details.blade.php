@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Verification Details</h1>
        <a href="{{ route('admin.verify-users') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-2">
                        <strong>Phone:</strong> {{ $user->phone }}
                    </div>
                    <div class="mb-2">
                        <strong>Registered On:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') }}
                    </div>
                    <div class="mb-2">
                        <strong>Status:</strong>
                        @if($user->verification_status == 'Pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($user->verification_status == 'Verified')
                            <span class="badge badge-success">Verified</span>
                        @elseif($user->verification_status == 'Rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-secondary">Incomplete</span>
                        @endif
                    </div>
                    @if($user->verification_status == 'Rejected' && $user->rejection_reason)
                    <div class="mb-2">
                        <strong>Rejection Reason:</strong>
                        <p class="text-danger">{{ $user->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ID Documents Section -->
        <div class="col-xl-8 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Verification Documents</h6>
                </div>
                <div class="card-body">
                    <!-- You would customize this section based on what documents users upload -->
                    <div class="row">
                        <!-- ID Document -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold">ID Document</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if(isset($user->id_document_path))
                                        <img src="{{ asset('storage/' . $user->id_document_path) }}" 
                                             class="img-fluid mb-2" alt="ID Document">
                                        <a href="{{ asset('storage/' . $user->id_document_path) }}" 
                                           class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-search-plus"></i> View Full Size
                                        </a>
                                    @else
                                        <div class="alert alert-warning">
                                            No ID document uploaded
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Proof -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold">Address Proof</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if(isset($user->address_proof_path))
                                        <img src="{{ asset('storage/' . $user->address_proof_path) }}" 
                                             class="img-fluid mb-2" alt="Address Proof">
                                        <a href="{{ asset('storage/' . $user->address_proof_path) }}" 
                                           class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-search-plus"></i> View Full Size
                                        </a>
                                    @else
                                        <div class="alert alert-warning">
                                            No address proof uploaded
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($user->verification_status != 'Verified')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Verification Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        {{-- <form action="{{ route('admin.user-verification.approve', $user->id) }}" method="POST" class="mr-2"> --}}
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Approve Verification
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Verification
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{-- <form action="{{ route('admin.user-verification.reject', $user->id) }}" method="POST"> --}}
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Verification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                        <small class="form-text text-muted">Please provide a reason why this verification is being rejected. This will be shown to the user.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Verification</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection