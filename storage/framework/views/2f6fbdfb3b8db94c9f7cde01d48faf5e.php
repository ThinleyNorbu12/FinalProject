

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Profile</li>
<?php $__env->stopSection(); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/profile.css')); ?>">
<?php $__env->startSection('content'); ?>
<!-- Profile Content -->
<div class="row g-4">
    <!-- Profile Picture Section -->
    <div class="col-lg-4 col-md-12">
        <div class="profile-card">
            <div class="profile-card-body">
                <div class="profile-picture-section">
                    <div class="profile-picture-container">
                        <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" 
                             alt="Profile Picture" 
                             class="profile-picture" 
                             id="profileImage">
                        <div class="profile-picture-overlay" onclick="document.getElementById('profilePictureInput').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    
                    <!-- Profile Picture Upload Form -->
                    <form id="profilePictureForm" action="<?php echo e(route('admin.profile.picture')); ?>" method="POST" enctype="multipart/form-data" class="d-none">
                        <?php echo csrf_field(); ?>
                        <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*">
                    </form>
                    
                    <div class="profile-basic-info">
                        <h4 class="profile-name"><?php echo e(Auth::guard('admin')->user()->name); ?></h4>
                        <p class="profile-role">Administrator</p>
                        <p class="profile-member-since">Member since <?php echo e(Auth::guard('admin')->user()->created_at->format('M Y')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Info Card -->
        <div class="profile-card account-info-card">
            <div class="profile-card-header">
                <h5 class="card-title">
                    <i class="fas fa-info-circle me-2"></i>Account Information
                </h5>
            </div>
            <div class="profile-card-body">
                <div class="info-item">
                    <label class="info-label">Account ID</label>
                    <p class="info-value">#<?php echo e(Auth::guard('admin')->user()->id); ?></p>
                </div>
                <div class="info-item">
                    <label class="info-label">Role</label>
                    <p class="info-value">
                        <span class="badge badge-admin">Administrator</span>
                    </p>
                </div>
                <div class="info-item">
                    <label class="info-label">Last Updated</label>
                    <p class="info-value"><?php echo e(Auth::guard('admin')->user()->updated_at->format('M d, Y')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information Section -->
    <div class="col-lg-8 col-md-12">
        <!-- Profile Update Form -->
        <div class="profile-card">
            <div class="profile-card-header">
                <h5 class="card-title">
                    <i class="fas fa-user-edit me-2"></i>Profile Information
                </h5>
            </div>
            <div class="profile-card-body">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" id="profileUpdateForm" class="profile-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-1"></i>Full Name
                        </label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="name" 
                               name="name" 
                               value="<?php echo e(old('name', Auth::guard('admin')->user()->name)); ?>" 
                               required>
                        <?php $__errorArgs = ['name'];
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

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>Email Address
                        </label>
                        <input type="email" 
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="email" 
                               name="email" 
                               value="<?php echo e(old('email', Auth::guard('admin')->user()->email)); ?>" 
                               required>
                        <?php $__errorArgs = ['email'];
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

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="updateProfileBtn">
                            <i class="fas fa-save me-1"></i> Update Profile
                        </button>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="profile-card password-card">
            <div class="profile-card-header">
                <h5 class="card-title">
                    <i class="fas fa-lock me-2"></i>Change Password
                </h5>
            </div>
            <div class="profile-card-body">
                <form action="<?php echo e(route('admin.password.update')); ?>" method="POST" id="passwordUpdateForm" class="profile-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-key me-1"></i>Current Password
                        </label>
                        <div class="password-input-group">
                            <input type="password" 
                                   class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            <button class="password-toggle-btn" type="button" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye" id="current_password_icon"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['current_password'];
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

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>New Password
                                </label>
                                <div class="password-input-group">
                                    <input type="password" 
                                           class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="new_password" 
                                           name="new_password" 
                                           required 
                                           minlength="8">
                                    <button class="password-toggle-btn" type="button" onclick="togglePassword('new_password')">
                                        <i class="fas fa-eye" id="new_password_icon"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text">Password must be at least 8 characters long</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">
                                    <i class="fas fa-check-circle me-1"></i>Confirm New Password
                                </label>
                                <div class="password-input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           required>
                                    <button class="password-toggle-btn" type="button" onclick="togglePassword('new_password_confirmation')">
                                        <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                                    </button>
                                </div>
                                <small class="form-text" id="password_match_message"></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                            <i class="fas fa-key me-1"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile picture upload handling
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profileImage = document.getElementById('profileImage');
    const profilePictureForm = document.getElementById('profilePictureForm');

    if (profilePictureInput && profileImage && profilePictureForm) {
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file.');
                    return;
                }
                
                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                    // Auto-submit the form
                    profilePictureForm.submit();
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Password visibility toggle
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        
        if (field && icon) {
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    };

    // Password confirmation validation
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    const passwordMessage = document.getElementById('password_match_message');

    function validatePasswords() {
        if (!confirmPassword || !newPassword || !passwordMessage) return;
        
        if (confirmPassword.value === '') {
            passwordMessage.textContent = '';
            passwordMessage.className = 'form-text text-muted';
            return;
        }
        
        if (newPassword.value === confirmPassword.value) {
            passwordMessage.textContent = 'Passwords match ✓';
            passwordMessage.className = 'form-text text-success';
            confirmPassword.classList.remove('is-invalid');
            confirmPassword.classList.add('is-valid');
        } else {
            passwordMessage.textContent = 'Passwords do not match';
            passwordMessage.className = 'form-text text-danger';
            confirmPassword.classList.remove('is-valid');
            confirmPassword.classList.add('is-invalid');
        }
    }

    if (newPassword && confirmPassword) {
        newPassword.addEventListener('input', validatePasswords);
        confirmPassword.addEventListener('input', validatePasswords);
    }

    // Form submission loading states
    const profileUpdateForm = document.getElementById('profileUpdateForm');
    const updateProfileBtn = document.getElementById('updateProfileBtn');
    
    if (profileUpdateForm && updateProfileBtn) {
        profileUpdateForm.addEventListener('submit', function() {
            updateProfileBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Updating...';
            updateProfileBtn.disabled = true;
        });
    }

    const passwordUpdateForm = document.getElementById('passwordUpdateForm');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    
    if (passwordUpdateForm && changePasswordBtn) {
        passwordUpdateForm.addEventListener('submit', function() {
            changePasswordBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Changing...';
            changePasswordBtn.disabled = true;
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/profile.blade.php ENDPATH**/ ?>