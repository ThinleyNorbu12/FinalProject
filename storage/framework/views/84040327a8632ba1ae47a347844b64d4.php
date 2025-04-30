

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Make Payment</h4>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" name="card_number" id="cardNumber" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="expiry" class="form-label">Expiry Date</label>
                            <input type="text" name="expiry_date" id="expiry" class="form-control" placeholder="MM/YY" required>
                        </div>

                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" name="cvv" id="cvv" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-lock me-2"></i>Confirm & Pay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/payment.blade.php ENDPATH**/ ?>