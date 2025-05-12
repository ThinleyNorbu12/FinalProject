<!DOCTYPE html>
<html>
<head>
    <title>Inspection Accepted</title>
</head>
<body>
    <h3>Hello <?php echo e($adminName); ?>,</h3> <!-- Display the admin's name -->
    <p>The following inspection request has been accepted by the car owner:</p>

    <ul>
        <li><strong>Car:</strong> <?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?></li>
        <li><strong>Registration No:</strong> <?php echo e($request->car->registration_no ?? 'N/A'); ?></li>
        <li><strong>Inspection Date:</strong> <?php echo e($request->inspection_date); ?></li>
        <li><strong>Inspection Time:</strong> <?php echo e($request->inspection_time); ?></li>
        <li><strong>Location:</strong> <?php echo e($request->location); ?></li>
    </ul>

    <p>Please proceed with the scheduled inspection.</p>
</body>
</html>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/emails/inspection_accepted.blade.php ENDPATH**/ ?>