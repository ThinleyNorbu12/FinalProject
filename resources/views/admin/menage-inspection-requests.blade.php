@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/menage-inspection-requests.css') }}">
<div class="container">
    <h2 class="mb-4">Inspection Requests of TIME and DATE from Car Owners</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($inspectionRequests->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
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
                        <td>{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}</td>
                        <td>{{ $request->car->registration_no ?? 'N/A' }}</td>
                        <td>{{ $request->car->owner->email ?? 'N/A' }}</td>
                        <td>{{ $request->inspection_date }}</td>
                        <td>{{ $request->inspection_time }}</td>
                        <td>{{ $request->location }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>
                            @if($request->status !== 'canceled')
                                @if(!$request->new_date_requested)
                                    <!-- Ok Button (for confirming date and time) -->
                                    <!-- Confirm Inspection -->
                                    <form action="{{ route('car-admin.inspection.confirm', $request->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Ok</button>
                                    </form>

                                    <!-- Send Mail -->
                                    {{-- <form action="{{ route('car-admin.inspection.sendMail', $request->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">Send Mail</button>
                                    </form> --}}

                                @endif
                            @endif
                        </td>             
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">No inspection requests found.</div>
    @endif
</div>
@endsection
