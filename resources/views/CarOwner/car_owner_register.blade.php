@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Car Owner Registration</h2>
    <form action="{{ route('register.car-owner') }}" method="POST">
        @csrf
        <label for="name">Full Name:</label>
        <input type="text" name="name" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="address">Address:</label>
        <textarea name="address" required></textarea>

        <button type="submit">Register</button>
    </form>
</div>
@endsection
