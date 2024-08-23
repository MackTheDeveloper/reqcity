<?php $__env->startSection('title','Sign Up'); ?>

<?php $__env->startSection('content'); ?>
    <!--------------------------
        Content START
    --------------------------->
    <div class="container">
      <div class="layout-352 form-page signup">
        <h5>Sign Up</h5>
        <div class="or">
          <p class="bm blur-color">or <a href="<?php echo e(url('/login')); ?>" class="a">log in to your account</a></p>
        </div>
        <div>
          <div class="signup-box">
            <label class="rd">I’m a candidate.
              <input type="radio" name="signup" checked="checked" value="candidate-signup">
              <span class="rd-checkmark"></span>
            </label>
          </div>
          <div class="signup-box">
            <label class="rd">I’m a company.
              <input type="radio" name="signup"  value="company-signup">
              <span class="rd-checkmark"></span>
            </label>
          </div>
          <div class="signup-box">
            <label class="rd">I’m a recruiter.
              <input type="radio" name="signup" value="recruiter-signup">
              <span class="rd-checkmark"></span>
            </label>
          </div>
        </div>
        <a href="javascript:void(0);" id="go-to-signup" class="fill-btn ">Create Account</a>
      </div>
    </div>
    <!--------------------------
        Content END
    --------------------------->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footscript'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
          $(document).on('click','#go-to-signup',function(){
             var value=$('input[name="signup"]:checked').val();
            //  var value = $(this).val();
              var signUpUrl = '<?php echo e(url("/:param1")); ?>';
              signUpUrl = signUpUrl.replace(':param1', value);
              window.location.href = signUpUrl;
              //document.getElementById("go-to-signup").href = signUpUrl;
          });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/sign-up.blade.php ENDPATH**/ ?>