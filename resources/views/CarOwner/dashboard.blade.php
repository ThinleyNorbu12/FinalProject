@extends('layouts.app')

@section('content')
<h2>Welcome to Car Owner Dashboard</h2>
<p>Hello, {{ Auth::user()->name }}!</p>
<form method="POST" action="{{ route('carowner.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection 
<!-- resources/views/carowner/dashboard.blade.php
@extends('layouts.app') -->
<!--  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Car Owner Dashboard') }}
                    <form action="{{ route('carowner.logout') }}" method="POST" class="float-end">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3>Welcome, {{ $carOwner->name }}!</h3>
                    <p>Email: {{ $carOwner->email }}</p>
                    <p>Phone: {{ $carOwner->phone }}</p>
                    
                    <div class="mt-4">
                        <h4>Your Cars</h4>
                        @if($carOwner->cars->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>License Plate</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carOwner->cars as $car)
                                    <tr>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $car->year }}</td>
                                        <td>{{ $car->license_plate }}</td>
                                        <td>{{ $car->status }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info">View</a>
                                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                You haven't listed any cars yet. <a href="#">Add your first car</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}} -->

<!-- 
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Car Owner Dashboard') }}</span>

                    <form action="{{ route('carowner.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3>Hello, {{ Auth::user()->name ?? 'Car Owner' }}!</h3>
                    <p>Email: {{ Auth::user()->email }}</p>
                    <p>Phone: {{ Auth::user()->phone ?? 'N/A' }}</p>

                    <hr>

                    <h4 class="mt-4">Your Cars</h4>
                    @if(Auth::user()->cars && Auth::user()->cars->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>License Plate</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->cars as $car)
                                <tr>
                                    <td>{{ $car->model }}</td>
                                    <td>{{ $car->year }}</td>
                                    <td>{{ $car->license_plate }}</td>
                                    <td>{{ ucfirst($car->status) }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info">View</a>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            You haven’t listed any cars yet. <a href="#">Add your first car</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
