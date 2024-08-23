<h2><?php echo e($howItWorksCompanyData['title']); ?></h2>
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="pr-24">
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCompanyData['feature_1'])? $howItWorksCompanyData['feature_1']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCompanyData['description_1'])? $howItWorksCompanyData['description_1']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCompanyData['feature_2'])? $howItWorksCompanyData['feature_2']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCompanyData['description_2'])? $howItWorksCompanyData['description_2']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCompanyData['feature_3'])? $howItWorksCompanyData['feature_3']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCompanyData['description_3'])? $howItWorksCompanyData['description_3']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCompanyData['feature_4'])? $howItWorksCompanyData['feature_4']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCompanyData['description_4'])? $howItWorksCompanyData['description_4']:''); ?></span>
			</div>
			<?php if(!Auth::check()): ?>
				<a href="<?php echo e(url('/company-signup')); ?>" class="fill-btn">Post a Job</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-6 hide-991">
		<img src="<?php echo e($howItWorksCompanyData['Image']); ?>" alt="" />
	</div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/homepage-component/how-it-works-for-company.blade.php ENDPATH**/ ?>