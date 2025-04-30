@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile-section">
                <h2>Welcome to the Customer Dashboard</h2>

                @if(Auth::guard('customer')->check())
                    <p>Hello, {{ Auth::guard('customer')->user()->name }}!</p>
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @else
                    <p>Hello, Guest!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
