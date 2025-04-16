@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inspection Requests from Admin</h2>

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
                        <button class="btn btn-danger btn-sm" disabled>Cancel</button>
                        <button class="btn btn-warning btn-sm" disabled>Request Edit</button>
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
@endsection
