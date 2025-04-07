

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <p>Hello, <?php echo e($carOwnerName); ?></p>

    <p>Your email has been successfully verified. Please click the button below to set your password:</p>

    <a href="<?php echo e($verificationUrl); ?>" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Set Your Password
    </a>

    <p>If you did not request this, please ignore this email.</p>
</body>
</html>


<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/emails/carowner-verification.blade.php ENDPATH**/ ?>