<?php $__env->startSection('title', 'Sign In'); ?>

<?php $__env->startSection('content'); ?>
    <!--------------------------
                SIGN IN START
        --------------------------->

    <div class="container">
        <form id="loginForm" method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="layout-352 form-page login">
                <h5>Log in to ReqCity</h5>
                <div class="or">
                    <p class="bm blur-color">or <a href="<?php echo e(url('signup')); ?>" class="a">create an account</a></p>
                </div>
                <div>
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="text" class="email" name="email" id="email"
                            pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
                    </div>
                    <div class="input-groups">
                        <span>Password</span>
                        <input type="password" name="password" id="password">
                    </div>
                </div>
                <div class="forgot-link">
                    <a href="<?php echo e(route('showForgotPassword')); ?>" class="a"><span>Forgot Password?</span></a>
                </div>
                <div class="terms-links">
                    <p class="bm blur-color">By continuing, you have read and agree to the <a href="<?php echo e(route('termsOfService')); ?>"
                            class="a">Terms of Service.</a></p>
                </div>
                <button type="submit" class="fill-btn">Log In</button>
            </div>
        </form>
    </div>

    <!--------------------------
                SIGN IN END
        --------------------------->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
    <script type="text/javascript">
        $("#loginForm").validate({
            ignore: [],
            rules: {
                email: "required",
                password: "required",
            },
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/auth/login.blade.php ENDPATH**/ ?>