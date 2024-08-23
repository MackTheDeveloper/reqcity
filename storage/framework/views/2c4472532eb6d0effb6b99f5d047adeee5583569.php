<head>
	<?php echo $__env->make('frontend.include.meta_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<link rel="icon" type="image/x-icon" href="">

	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/bootstrap4.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/owl.carousel.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/owl.theme.default.min.css')); ?>">

	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/jquery.ccpicker.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/style.css')); ?>?r=20220222">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/style2.css')); ?>?r=20220222">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/cropper.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/developer.css')); ?>?r=20220509">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/style-new.css')); ?>?r=20220222">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/responsive.css')); ?>?r=20220222">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/responsive2.css')); ?>?r=20220222">
	<link rel="stylesheet" href="<?php echo e(asset('public/assets/frontend/css/jquery-ui.css')); ?>">
	<?php echo $__env->yieldContent('styles'); ?>
</head>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/include/head.blade.php ENDPATH**/ ?>