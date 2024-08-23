<?php $__env->startSection('title','404'); ?>

<?php $__env->startSection('content'); ?>

<header class="top-shadow">
	<div class="container">
		<nav class="navbar navbar-expand">
			<a class="navbar-brand header-only-logo" href="#">
				<img src="<?php echo e(asset('public/assets/frontend/img/Logo.svg')); ?>" alt="" />
			</a>
		</nav>
	</div>
</header>

<div class="page-404">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 order-2 order-md-1 offset-lg-1 col-md-6 col-lg-5">
				<div class="error-content">
					<h2>404:<br>Page not found</h2>
					<p class="bl">The link you clicked may be broken or the page may have been removed.</p>
					<a href="<?php echo e(url('/')); ?>" class="fill-btn">Go Home</a>
				</div>
			</div>
			<div class="col-12 col-sm-12 order-1 order-md-2 col-md-6 col-lg-4">
				<div class="error-img">
					<img src="<?php echo e(asset('public/assets/frontend/img/404.svg')); ?>" alt="" />
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/errors/404.blade.php ENDPATH**/ ?>