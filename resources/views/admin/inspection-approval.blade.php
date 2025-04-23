@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/inspection-approval.css') }}">

<div class="container">
    <h2 class="mb-4 text-center">Approve or Reject Inspected Cars</h2>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($inspectionRequests->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Sl. No</th>
                        <th>Car</th>
                        <th>Reg. No.</th>
                        <th>Owner Email</th>
                        <th>Inspection Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspectionRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}</td>
                            <td>{{ $request->car->registration_no ?? 'N/A' }}</td>
                            <td>{{ $request->car->owner->email ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->inspection_date)->format('d M Y') }}</td>
                            @php
                                $timeRange = $request->inspection_time;
                                $formattedTime = $timeRange;

                                if (strpos($timeRange, ' - ') !== false) {
                                    [$startTime, $endTime] = explode(' - ', $timeRange);
                                    try {
                                        $formattedStart = \Carbon\Carbon::parse($startTime)->format('h:i A');
                                        $formattedEnd = \Carbon\Carbon::parse($endTime)->format('h:i A');
                                        $formattedTime = $formattedStart . ' - ' . $formattedEnd;
                                    } catch (Exception $e) {
                                        $formattedTime = $timeRange;
                                    }
                                }
                            @endphp
                            <td>{{ $formattedTime }}</td>
                            <td>{{ $request->location ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('car-admin.inspection-approval') }}" method="POST" class="d-flex justify-content-center gap-2">
                                    @csrf
                                    <input type="hidden" name="car_id" value="{{ $request->car->id }}">
                                    
                                    <button type="submit" name="decision" value="approved" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Approve this car">
                                        <i class="bi bi-check-circle"></i>
                                    </button>

                                    <button type="submit" name="decision" value="rejected" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Reject this car">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">No confirmed inspection requests pending approval.</div>
    @endif
</div>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

{{-- Tooltip Activation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
