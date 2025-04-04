@extends('layouts.app')

@section('content')
<h2>Car Owner Login</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('carowner.login.submit') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="{{ route('carowner.register') }}">Register</a></p>
@endsection
