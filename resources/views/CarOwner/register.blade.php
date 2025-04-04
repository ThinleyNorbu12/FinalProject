@extends('layouts.app')

@section('content')
<h2>Car Owner Register</h2>

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('carowner.register.submit') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="text" name="phone" placeholder="Phone Number" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <textarea name="address" placeholder="Address" required></textarea><br><br>
    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="{{ route('carowner.login') }}">Login</a></p>
@endsection
