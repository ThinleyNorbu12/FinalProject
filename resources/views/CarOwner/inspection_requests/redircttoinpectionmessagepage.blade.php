{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h3>Inspection Requests from Admin</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($inspectionRequests->isEmpty())
        <div class="alert alert-info">
            No inspection requests found.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inspectionRequests as $request)
                    <tr>
                        <td>{{ $request->inspection_date }}</td>
                        <td>{{ $request->inspection_time }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            <a href="{{ route('inspection.editdatetime', $request->id) }}" class="btn btn-sm btn-primary">
                                Edit Schedule
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection --}}
