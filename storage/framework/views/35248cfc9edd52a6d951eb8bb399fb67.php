<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <p style="font-size: 16px; color: #333;">
        Dear <strong><?php echo e($inspectionRequest->car->owner->name ?? 'Owner'); ?></strong>,
    </p>

    <p style="font-size: 16px; color: #333;">
        Your car inspection request for 
        <strong><?php echo e($inspectionRequest->car->maker); ?> <?php echo e($inspectionRequest->car->model); ?></strong> 
        (Reg. No: <strong><?php echo e($inspectionRequest->car->registration_no); ?></strong>) has been 
        <span style="font-weight: bold; color: <?php echo e($decision === 'approved' ? 'green' : 'red'); ?>;">
            <?php echo e(strtoupper($decision)); ?>

        </span>.
    </p>

    <?php if($decision === 'approved'): ?>
        <p style="font-size: 16px; color: green;">
            🎉 Congratulations! Your car is now ready for the next steps.
        </p>
    <?php else: ?>
        <p style="font-size: 16px; color: #c0392b;">
            ❌ Unfortunately, your car did not pass the inspection.
        </p>
        <?php if($rejectionReason): ?>
            <p style="font-size: 16px; color: #555;">
                <strong>Reason for rejection:</strong><br>
                <em><?php echo e($rejectionReason); ?></em>
            </p>
        <?php endif; ?>

        <p style="font-size: 16px; color: #333;">
            You can review and resubmit if necessary.
        </p>
    <?php endif; ?>

    <p style="font-size: 16px; color: #333;">
        Thank you,<br>
        <strong>Car Inspection Admin Team</strong>
    </p>
</div>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/emails/inspection-decision.blade.php ENDPATH**/ ?>