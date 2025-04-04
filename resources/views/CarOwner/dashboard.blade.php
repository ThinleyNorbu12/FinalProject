@extends('layouts.app')

@section('content')
<h2>Welcome to Car Owner Dashboard</h2>
<p>Hello, {{ Auth::user()->name }}!</p>
<form method="POST" action="{{ route('carowner.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection
