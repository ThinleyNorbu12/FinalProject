@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Rented Cars</h2>

    @if(isset($message))
        <p>{{ $message }}</p>
    @elseif($rentedCars->isEmpty())
        <p>You have not rented any cars yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Car Name</th>
                        <th>Model</th>
                        <th>Rental Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentedCars as $index => $car)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->rental_date }}</td>
                            <td>
                                @if($car->status == 'pending')
                                    <span class="badge badge-warning">Pending Approval</span>
                                @else
                                    <span class="badge badge-success">Rented</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
