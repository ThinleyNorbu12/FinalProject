<form method="POST" action="{{ route('customer.password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email">Email Address</label>
        <input type="email" name="email" value="{{ old('email', $email) }}" required>
    </div>

    <div>
        <label for="password">New Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Reset Password</button>
</form>
