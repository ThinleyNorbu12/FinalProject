<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
    <h1>Set Your Password</h1>

    <form action="{{ route('carowner.setPassword.post', ['token' => $token]) }}" method="POST">
        @csrf
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <button type="submit">Set Password</button>
    </form>
</body>
</html>
