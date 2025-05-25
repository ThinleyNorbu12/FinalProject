<h2>Hello <?php echo e($inspectionRequest->car->owner->name); ?>,</h2>

<p>Your car inspection has been scheduled.</p>

<ul>
    <li><strong>Car:</strong> <?php echo e($inspectionRequest->car->maker); ?> <?php echo e($inspectionRequest->car->model); ?></li>
    <li><strong>Registration No:</strong> <?php echo e($inspectionRequest->car->registration_no); ?></li>
    <li><strong>Date:</strong> <?php echo e($inspectionRequest->inspection_date); ?></li>
    <li><strong>Time:</strong> <?php echo e($inspectionRequest->inspection_time); ?></li>
    <li><strong>Location:</strong> <?php echo e($inspectionRequest->location); ?></li>
</ul>

<p><em>Note: Each car inspection typically takes around 1 hour.</em></p>

<p>Thank you!</p>
<?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/emails/inspection_requested.blade.php ENDPATH**/ ?>