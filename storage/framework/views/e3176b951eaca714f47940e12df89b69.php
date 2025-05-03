<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Your Password</title>
</head>
<body>
    <h2>Welcome to Our Service!</h2>
    <p>We received a request to create your account. To set your password, click the link below:</p>

    <?php if(Route::has('customer.password.set')): ?>
        <p><a href="<?php echo e(route('customer.password.set', ['token' => $token])); ?>">Set Your Password</a></p>
    <?php else: ?>
        <p>❌ Route not found.</p>
    <?php endif; ?>

    <p>If you did not request this, please ignore this email.</p>
</body>
</html>
<?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/emails/customer/set_password.blade.php ENDPATH**/ ?>