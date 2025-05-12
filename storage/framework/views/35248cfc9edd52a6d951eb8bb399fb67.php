<!DOCTYPE html>
<html>
<head>
    <title>Inspection Decision</title>
</head>
<body>
    <h2>Dear <?php echo e($inspectionRequest->car->owner->name ?? 'Owner'); ?>,</h2>

    <p>Your car inspection request for <strong><?php echo e($inspectionRequest->car->maker); ?> <?php echo e($inspectionRequest->car->model); ?></strong> (Reg. No: <?php echo e($inspectionRequest->car->registration_no); ?>) has been <strong><?php echo e($decision); ?></strong>.</p>

    <?php if($decision === 'approved'): ?>
        <p>Congratulations! Your car is now ready for the next steps.</p>
    <?php else: ?>
        <p>Unfortunately, your car did not pass the inspection. You can review and resubmit if necessary.</p>
    <?php endif; ?>

    <p>Thank you,<br>Car Inspection Admin Team</p>
</body>
</html>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/emails/inspection-decision.blade.php ENDPATH**/ ?>