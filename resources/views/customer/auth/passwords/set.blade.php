<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
    <h2>Set Your Password</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('customer.password.save') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
    
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
    
        <div>
            <label>New Password:</label>
            <input type="password" name="password" required>
        </div>
    
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>
    
        <button type="submit">Set Password</button>
    </form>
    
</body>
</html>
