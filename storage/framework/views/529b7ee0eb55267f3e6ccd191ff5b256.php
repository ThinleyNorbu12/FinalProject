

<?php $__env->startSection('title', 'User Verification Details'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('admin.verify-users')); ?>">User Verification</a>
    </li>
    <li class="breadcrumb-item active">Verification Details</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Verification Details</h1>
    
    </div>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">Name:</th>
                                <td><?php echo e($customer->name); ?></td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td><?php echo e($customer->gender); ?></td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td><?php echo e($customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->format('d M Y') : 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>CID Number:</th>
                                <td><?php echo e($customer->cid_no); ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo e($customer->email); ?></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td><?php echo e($customer->phone); ?></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><?php echo e($customer->address ?? 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>Registered On:</th>
                                <td><?php echo e(\Carbon\Carbon::parse($customer->created_at)->format('d M Y')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- License Information -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">License Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">License No:</th>
                                <td><?php echo e($customer->drivingLicense->license_no ?? 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>Issuing Dzongkhag:</th>
                                <td><?php echo e($customer->drivingLicense->issuing_dzongkhag ?? 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>Issue Date:</th>
                                <td><?php echo e($customer->drivingLicense->issue_date ? \Carbon\Carbon::parse($customer->drivingLicense->issue_date)->format('d M Y') : 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <th>Expiry Date:</th>
                                <td>
                                    <?php if($customer->drivingLicense->expiry_date): ?>
                                        <?php echo e(\Carbon\Carbon::parse($customer->drivingLicense->expiry_date)->format('d M Y')); ?>

                                        
                                        <?php if($customer->isLicenseAboutToExpire()): ?>
                                        <span class="badge bg-info text-dark ms-2">Expiring Soon</span>
                                        <?php elseif($customer->drivingLicense->expiry_date < now()): ?>
                                        <span class="badge bg-dark ms-2">Expired</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        Not provided
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <?php if($customer->drivingLicense->status == 'Pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                    <?php elseif($customer->drivingLicense->status == 'Verified'): ?>
                                    <span class="badge bg-success">Verified</span>
                                    <?php elseif($customer->drivingLicense->status == 'Rejected'): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Not Submitted</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if($customer->drivingLicense->status == 'Rejected' && $customer->drivingLicense->rejection_reason): ?>
                            <tr>
                                <th>Rejection Reason:</th>
                                <td><?php echo e($customer->drivingLicense->rejection_reason); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- License Images -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-id-card"></i> License Front
                    </h6>
                </div>
                <div class="card-body text-center">
                    <?php if($customer->drivingLicense->license_front_image): ?>
                        <img src="<?php echo e(asset($customer->drivingLicense->license_front_image)); ?>" 
                            class="img-fluid border license-image" 
                            alt="License Front" 
                            style="max-height: 300px;"
                            onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Front image not available</p></div>';">
                        <a href="<?php echo e(asset($customer->drivingLicense->license_front_image)); ?>" 
                            class="btn btn-sm btn-info mt-2" 
                            target="_blank">
                            <i class="fas fa-search-plus"></i> View Full Size
                        </a>
                    <?php else: ?>
                        <div class="no-image">
                            <i class="fas fa-id-card"></i>
                            <p>Front image not available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-id-card-alt"></i> License Back
                    </h6>
                </div>
                <div class="card-body text-center">
                    <?php if($customer->drivingLicense->license_back_image): ?>
                        <img src="<?php echo e(asset($customer->drivingLicense->license_back_image)); ?>" 
                            class="img-fluid border license-image" 
                            alt="License Back" 
                            style="max-height: 300px;"
                            onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Back image not available</p></div>';">
                        <a href="<?php echo e(asset($customer->drivingLicense->license_back_image)); ?>" 
                            class="btn btn-sm btn-info mt-2" 
                            target="_blank">
                            <i class="fas fa-search-plus"></i> View Full Size
                        </a>
                    <?php else: ?>
                        <div class="no-image">
                            <i class="fas fa-id-card"></i>
                            <p>Back image not available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php if(!$customer->drivingLicense->license_front_image && !$customer->drivingLicense->license_back_image): ?>
        <div class="col-md-12">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> No license images uploaded by the user.
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Alternative Document Verification Form -->
    <?php if($customer->drivingLicense->status == 'Pending' && 
        (!$customer->drivingLicense->license_front_image || 
         !$customer->drivingLicense->license_back_image || 
         isset($images_unclear) && $images_unclear == true)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alternative Document Verification</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        License images are not clearly uploaded or missing. Please verify the user using alternative ID proof.
                    </div>
                    
                    <form action="<?php echo e(route('admin.user-verification.alternative', $customer->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_proof_type" class="form-label">ID/Document Proof Type</label>
                                    <input type="text" class="form-control" id="id_proof_type" name="id_proof_type" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_proof_number" class="form-label">ID Proof Number</label>
                                    <input type="text" class="form-control" id="id_proof_number" name="id_proof_number" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_verified" name="is_verified" value="1" required>
                                <label class="form-check-label" for="is_verified">Is Verified</label>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Regular Verification Form -->
    <?php if($customer->drivingLicense->status == 'Pending'): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Verification Status</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.user-verification.update', $customer->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Verification Decision:</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status-approve" name="status" value="Verified" class="form-check-input" required>
                                <label class="form-check-label" for="status-approve">Approve</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="status-reject" name="status" value="Rejected" class="form-check-input" required>
                                <label class="form-check-label" for="status-reject">Reject</label>
                            </div>
                        </div>
                        
                        <div class="mb-3" id="rejection-reason-group" style="display: none;">
                            <label for="rejection_reason" class="form-label">Rejection Reason:</label>
                            <textarea class="form-control <?php $__errorArgs = ['rejection_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
                            <div class="form-text">Please provide a reason for rejection that will be visible to the user.</div>
                            <?php $__errorArgs = ['rejection_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Submit Decision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php elseif($customer->drivingLicense->status == 'Rejected'): ?>
    <!-- Reset verification status option for rejected licenses -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reset Verification Status</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.user-verification.update', $customer->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="status" value="Pending">
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            Resetting the status to pending will allow the user to update their driving license information.
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset to Pending
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide rejection reason based on selection
        const statusInputs = document.querySelectorAll('input[name="status"]');
        const rejectionReasonGroup = document.getElementById('rejection-reason-group');
        const rejectionReasonTextarea = document.getElementById('rejection_reason');
        
        statusInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'Rejected') {
                    rejectionReasonGroup.style.display = 'block';
                    rejectionReasonTextarea.setAttribute('required', true);
                } else {
                    rejectionReasonGroup.style.display = 'none';
                    rejectionReasonTextarea.removeAttribute('required');
                }
            });
        });
        
        // Function to check if license images are unclear
        function checkImageClarity() {
            const frontImg = document.querySelector('.license-image');
            const backImg = document.querySelectorAll('.license-image')[1];
            
            if (frontImg && backImg) {
                // This is a simplified check - in production you might want more sophisticated image clarity detection
                if (frontImg.naturalWidth < 300 || frontImg.naturalHeight < 200 || 
                    backImg.naturalWidth < 300 || backImg.naturalHeight < 200) {
                    const altVerificationForm = document.querySelector('.alternative-verification-form');
                    if (altVerificationForm) {
                        altVerificationForm.style.display = 'block';
                    }
                }
            }
        }
        
        // Run after images are loaded
        const licenseImages = document.querySelectorAll('.license-image');
        licenseImages.forEach(img => {
            img.addEventListener('load', checkImageClarity);
        });
        
        // Run once on page load (for cached images)
        setTimeout(checkImageClarity, 500);
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/user-verification-details.blade.php ENDPATH**/ ?>