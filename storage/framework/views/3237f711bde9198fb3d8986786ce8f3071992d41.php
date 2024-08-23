<?php $__env->startSection('title','Login'); ?>
<?php $__env->startSection('content'); ?>
<!-- <style type="text/css">
    .bgimg {
        background-image:url(<?php echo e(url('public/admin/images/bg_image.jpg')); ?>)
    }
    </style> -->

<div class="bgimg form-pages login-page">
    <div class="app-container">
        <div class="h-100 bg-plum-plate bg-animation">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class="mx-auto app-login-box col-md-8">

                    <div class="modal-dialog w-100 mx-auto">
                        <div class="modal-content">
                            <form id="loginForm" method="POST" action="<?php echo e(url(config('app.adminPrefix').'/login')); ?>">
                                <?php echo csrf_field(); ?>
                                
                                <div class="modal-body">
                                    <div class="mx-auto text-center mb-3 fan-logo">
                                        <img src="<?php echo e(url('public/images/Logo.svg')); ?>">
                                    </div>
                                    <div class="h5 modal-title text-center">
                                        <h4 class="mt-2">
                                            <div class="welcome-text">Welcome Back</div>
                                            <span class="span">Please sign in to your account below.</span>
                                        </h4>
                                    </div>
                                    <?php if(Session::has('msg')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo e(Session::get('msg')); ?>

                                        <button type="button" class="close session_error" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(Session::has('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo e(Session::get('success')); ?>

                                        <button type="button" class="close session_error" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($errors->any()): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" style="padding-bottom: 0px;" role="alert">
                                        <ul>
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                            <button type="button" class="close session_error" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group inputs-group">
                                                <input name="email" id="exampleEmail" type="text" class="input">
                                                <span>Email</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group inputs-group">
                                                <input name="password" class="input" id="examplePassword" type="password" class="form-control" value="<?php echo e(Cookie::get('password')); ?>">
                                                <span>Password</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 forgot-link-div">
                                            <a href="<?php echo e(url(config('app.adminPrefix').'/forgot-password')); ?>" class="link">Forgot Password</a>
                                        </div>
                                    </div>
                                    <div class="position-relative form-check">
                                        <!-- <input name="remember" id="remember" type="checkbox" <?php echo e((Cookie::get('remember') == 'checked') ? 'checked' : ''); ?> class="form-check-input"><label for="remember" class="form-check-label">Keep me logged in</label> -->
                                        <label class="ck">Keep me logged in
                                          <input type="checkbox" checked="checked" id="remember" <?php echo e((Cookie::get('remember') == 'checked') ? 'checked' : ''); ?> >
                                          <span class="ck-mark"></span>
                                        </label>
                                    </div>
                                    <!-- <div class="divider"></div> -->
                                    <!-- <h6 class="mb-0">No account? <a href="javascript:void(0);" class="text-primary">Sign up now</a></h6> -->
                                </div>
                                <div class="modal-footer clearfix">
                                    <button type="submit" class="fill-btn">Login to Dashboard</button>
                                        <!-- <input type="submit" name="submit" class="btn btn-secondary btn-lg" value="Login to Dashboard"> -->
                                </div>
                            </form>
                        </div>
                    </div>
                        <div class="text-center copy-text opacity-8 mt-3">Copyright © <?php echo e(config('app.name_show')); ?> All rights reserved.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/login.blade.php ENDPATH**/ ?>