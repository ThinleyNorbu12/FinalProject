@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inspection Requests from Admin</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($inspectionRequests->count() > 0)
        <ul class="list-group mt-4">
            @foreach($inspectionRequests as $request)
                <li class="list-group-item">
                    <strong>Car Name:</strong> {{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}<br>
                    <strong>Registration No:</strong> {{ $request->car->registration_no ?? 'N/A' }}<br>
                    <strong>Inspection Date:</strong> {{ $request->inspection_date }}<br>
                    <strong>Inspection Time:</strong> {{ $request->inspection_time }}<br>
                    <strong>Location:</strong> {{ $request->location }}<br>
                    <strong>Details:</strong> {{ $request->details }}<br>
                    <strong>Status:</strong> {{ ucfirst($request->status) }}<br>
                    <small class="text-muted">
                        Sent on {{ $request->created_at->timezone('Asia/Thimphu')->format('d M Y, h:i A') }}
                    </small>

                    <div class="mt-3 d-flex gap-2">
                        {{-- Cancel Button --}}
                        @if($request->status !== 'canceled' && !$request->request_accepted)
                            <form action="{{ route('inspection.cancel', $request->id) }}" method="POST" class="d-inline cancel-form">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm show-confirm-modal" 
                                    data-message="Are you sure you want to cancel this request?" 
                                    data-form-id="{{ $request->id }}">
                                    Cancel for Inspection Request
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled or Accepted</button>
                        @endif

                        {{-- Request for New Date --}}
                        @if($request->status !== 'canceled' && !$request->request_accepted)
                            @if($request->request_new_date_sent)
                                <button class="btn btn-secondary btn-sm" disabled>New Date Already Requested</button>
                            @else
                                <form action="{{ route('inspection.editdatetime', $request->id) }}" method="GET" class="d-inline edit-form">
                                    @csrf
                                    <button type="button" class="btn btn-warning btn-sm show-confirm-modal" 
                                        data-message="Are you sure you want to edit this request?" 
                                        data-form-id="{{ $request->id }}">
                                        Request for New Date
                                    </button>
                                </form>
                            @endif
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled or Accepted</button>
                        @endif

                        {{-- Accept Button --}}
                        @if($request->status !== 'canceled' && !$request->request_accepted)
                            <form action="{{ route('inspection.accept', $request->id) }}" method="POST" class="d-inline accept-form">
                                @csrf
                                <button type="button" class="btn btn-success btn-sm show-confirm-modal" 
                                    data-message="Do you accept the scheduled date and time?" 
                                    data-form-id="{{ $request->id }}">
                                    OK with Inspection Date/Time
                                </button>
                            </form>
                        @elseif($request->request_accepted)
                            <button class="btn btn-success btn-sm" disabled>Accepted by You</button>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info mt-4">
            No inspection requests found.
        </div>
    @endif
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="confirmModalLabel">Please Confirm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="confirmMessage">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmBtn">OK</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedForm = null;

    document.querySelectorAll('.show-confirm-modal').forEach(button => {
        button.addEventListener('click', function () {
            const message = this.getAttribute('data-message');
            selectedForm = this.closest('form');
            document.getElementById('confirmMessage').textContent = message;
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        });
    });

    document.getElementById('confirmBtn').addEventListener('click', function () {
        if (selectedForm) {
            selectedForm.submit();
        }
    });
</script>
@endsection
