<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Password</title>
</head>
<body>
    <h1>Set Your Password</h1>

    <form action="<?php echo e(route('carowner.set-password.submit')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">

        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Set Password</button>
    </form>
</body>
</html>
<?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/CarOwner/set-password.blade.php ENDPATH**/ ?>