@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Login</h2>
    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
