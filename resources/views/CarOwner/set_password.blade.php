@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Set Your Password</h2>
    <form action="{{ url('/set-password') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->query('token') }}">
        
        <label for="password">New Password:</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Set Password</button>
    </form>
</div>
@endsection
