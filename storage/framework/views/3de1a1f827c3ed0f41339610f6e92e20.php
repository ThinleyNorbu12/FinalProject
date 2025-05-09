<?php $__env->startComponent('mail::message'); ?>
# New Driving License Submission

**Customer Name:** <?php echo e($customer->name); ?>  
**License Number:** <?php echo e($license->license_no); ?>  
**Issuing Dzongkhag:** <?php echo e($license->issuing_dzongkhag); ?>  
**Expiry Date:** <?php echo e($expiryDate->format('d/m/Y')); ?>


<?php $__env->startComponent('mail::button', ['url' => route('admin.licenses.show', $license->id)]); ?>
Review License
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/emails/license-verification.blade.php ENDPATH**/ ?>