@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('admin.set-password.submit', $token) }}">
    @csrf
    <label>New Password:</label>
    <input type="password" name="password" required><br>

    <label>Confirm Password:</label>
    <input type="password" name="password_confirmation" required><br>

    <button type="submit">Set Password</button>
</form>

@endsection
