

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Edit Inspection Date & Time</h3>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('inspection.updatedatetime', $request->id)); ?>">
        <?php echo csrf_field(); ?>
        
        <div class="mb-3">
            <label for="inspection_date">Inspection Date:</label>
            <input type="date" name="inspection_date" id="inspection_date" class="form-control"
                   value="<?php echo e($request->inspection_date); ?>" required>
        </div>
        
        <div class="mb-3">
            
            <p><strong>Current Time Chosen by Admin:</strong> <?php echo e($request->inspection_time); ?></p>
            <label for="inspection_time">Inspection Time:</label>
            <select name="inspection_time" id="inspection_time" class="form-control" required>
                <option selected disabled>Select Time Slot</option>
                <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($slot); ?>" <?php echo e($slot == $request->inspection_time ? 'selected' : ''); ?>><?php echo e($slot); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $('#inspection_date').on('change', function () {
                let date = $(this).val();
                let id = <?php echo e($request->id); ?>; // pass current request ID to exclude from query
        
                $.ajax({
                    url: '<?php echo e(route('inspection.available-slots')); ?>',
                    method: 'GET',
                    data: { date: date, id: id },
                    success: function (slots) {
                        let dropdown = $('#inspection_time');
                        dropdown.empty();
                        if (slots.length > 0) {
                            dropdown.append('<option disabled selected>Select Time Slot</option>');
                            slots.forEach(function (slot) {
                                dropdown.append(`<option value="${slot}">${slot}</option>`);
                            });
                        } else {
                            dropdown.append('<option disabled selected>No slots available</option>');
                        }
                    },
                    error: function () {
                        alert('Failed to load time slots.');
                    }
                });
            });
        </script>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/inspection_requests/editdatetime.blade.php ENDPATH**/ ?>