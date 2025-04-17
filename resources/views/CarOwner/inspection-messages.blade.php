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
                        @if($request->status !== 'canceled')
                            <form action="{{ route('inspection.cancel', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                @csrf
                                <button class="btn btn-danger btn-sm" type="submit">Cancel for Inspection Request</button>
                            </form>
                        @else
                            <!-- Disabled button if already canceled -->
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled</button>
                        @endif
                    
                        @if($request->status !== 'canceled')
                            <form action="{{ route('inspection.editdatetime', $request->id) }}" method="GET" onsubmit="return confirm('Are you sure you want to edit this request?');">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">Request for New Date</button>
                            </form>
                        @else
                            <!-- Disabled button if already canceled -->
                            <button class="btn btn-secondary btn-sm" disabled>New Date Requested</button>
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
@endsection
