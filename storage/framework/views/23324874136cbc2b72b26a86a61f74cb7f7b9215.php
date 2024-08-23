<style>
#monthlychartdiv {
  width: 100%;
  height: 500px;
}
#yearlychartdiv {
  width: 100%;
  height: 500px;
}
#lifetimechartdiv{
  width: 100%;
  height: 500px;
}
.amcharts-chart-div a {display:none !important;}
</style>
<div class="comp-performance-detailed">
    <div class="copm-perfromance-graph">
        <div class="req-cspanel">
            <ul class="nav " id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="tab-link active" id="pills-home-tab" data-toggle="pill"
                        href="#pills-home" role="tab" aria-controls="pills-home"
                        aria-selected="true">Monthly</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="tab-link" id="pills-profile-tab" data-toggle="pill"
                        href="#pills-profile" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Yearly</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="tab-link" id="pills-contact-tab" data-toggle="pill"
                        href="#pills-contact" role="tab" aria-controls="pills-contact"
                        aria-selected="false">Lifetime</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <?php echo $__env->make('frontend.company.dashboard.components.cluster-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('frontend.company.dashboard.components.pi-chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('footscript'); ?>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/index.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/xy.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/percent.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/themes/Animated.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/dashboard.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/dashboard/components/company-performance.blade.php ENDPATH**/ ?>