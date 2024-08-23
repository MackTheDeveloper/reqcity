<?php $__env->startSection('title','Compnay Password & Security'); ?>

<?php $__env->startSection('content'); ?>
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('frontend.company.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="password-security-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Password & Security</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a href="<?php echo e(route('showPasswordSecurityFormCompany')); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>" /></a>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="boxlayout-infoitem">
                                            
                                            <p>Choose a strong, unique password that’s at least 8 characters long.
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/password-security/password-security.blade.php ENDPATH**/ ?>