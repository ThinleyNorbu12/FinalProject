

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Request for Car Inspection</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Car Details</div>
        <div class="card-body">
            <p><strong>Maker:</strong> <?php echo e($car->maker); ?></p>
            <p><strong>Model:</strong> <?php echo e($car->model); ?></p>
            <p><strong>Registration Number:</strong> <?php echo e($car->registration_no); ?></p>
        </div>
    </div>

    
    <div class="car-owner-info mt-4">
        <h4>Registered By:</h4>
        <?php if($car->owner): ?>
            <p><strong>Name:</strong> <?php echo e($car->owner->name); ?></p>
            <p><strong>Email:</strong> <?php echo e($car->owner->email); ?></p>
        <?php else: ?>
            <p>Unknown Owner</p>
        <?php endif; ?>
    </div>

    
    <form action="<?php echo e(url('car-admin/submit-inspection-request/' . $car->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="date">Inspection Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Inspection Time:</label>
            <select id="time" name="time" class="form-control" required>
                <option value="">-- Select Date First --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Inspection Location:</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="details">Additional Details:</label>
            <textarea id="details" name="details" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Inspection Request</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#date').on('change', function () {
    const selectedDate = $(this).val();

    $.ajax({
        url: "<?php echo e(route('car-admin.getAvailableTimes')); ?>",
        type: "GET",
        data: { date: selectedDate },
        success: function (response) {
            let options = '<option value="">-- Select Time Slot --</option>';

            if (response.length === 0) {
                options += '<option disabled>No available time slots</option>';
            } else {
                response.forEach(slot => {
                    options += `<option value="${slot}">${slot}</option>`;
                });
            }

            $('#time').html(options);
        },
        error: function () {
            alert('Failed to load time slots. Please try again.');
            $('#time').html('<option value="">-- Select Date First --</option>');
        }
    });
});

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/request-inspection.blade.php ENDPATH**/ ?>