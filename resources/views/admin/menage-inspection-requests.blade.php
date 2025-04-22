@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/menage-inspection-requests.css') }}">

<div class="container">
    <h2 class="mb-4 text-center">Rescheduled Inspection Requests</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($inspectionRequests->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Sl. No</th>
                        <th>Car</th>
                        <th>Reg. No.</th>
                        <th>Owner Email</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspectionRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}</td>
                            <td>{{ $request->car->registration_no ?? 'N/A' }}</td>
                            <td>{{ $request->car->owner->email ?? 'N/A' }}</td>
                            <td>{{ $request->inspection_date }}</td>
                            <td>{{ $request->inspection_time }}</td>
                            <td>{{ $request->location }}</td>
                            <td>
                                <span class="badge bg-{{ $request->status === 'canceled' ? 'danger' : 'primary' }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>
                                @if($request->status !== 'canceled')
                                    @if(!$request->is_confirmed_by_admin)
                                        <form action="{{ route('car-admin.inspection.confirm', $request->id) }}" method="POST" class="d-inline" onsubmit="return disableButton(this)">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" id="btn-{{ $request->id }}">
                                                <i class="bi bi-check-circle"></i> Confirm
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-check2-circle"></i> Done
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">No inspection requests found.</div>
    @endif
</div>

{{-- Bootstrap icons (optional if not already included in layout) --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
    function disableButton(form) {
        const btn = form.querySelector('button');
        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';

        // Fake delay (adjust to your liking)
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check2-circle"></i> Done';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
        }, 1000); // 1 second delay
        return true; // Allow form to continue submitting
    }
</script>
@endsection
