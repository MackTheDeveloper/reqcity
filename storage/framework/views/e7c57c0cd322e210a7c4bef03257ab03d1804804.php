<h2><?php echo e($howItWorksRecruiterData['title']); ?></h2>
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="pr-24">
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksRecruiterData['feature_1'])? $howItWorksRecruiterData['feature_1']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksRecruiterData['description_1'])? $howItWorksRecruiterData['description_1']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksRecruiterData['feature_2'])? $howItWorksRecruiterData['feature_2']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksRecruiterData['description_2'])? $howItWorksRecruiterData['description_2']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksRecruiterData['feature_3'])? $howItWorksRecruiterData['feature_3']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksRecruiterData['description_3'])? $howItWorksRecruiterData['description_3']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksRecruiterData['feature_4'])? $howItWorksRecruiterData['feature_4']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksRecruiterData['description_4'])? $howItWorksRecruiterData['description_4']:''); ?></span>
			</div>
			<?php if(!Auth::check()): ?>
				<a href="<?php echo e(url('/recruiter-signup')); ?>" class="fill-btn">Submit a Candidate</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-6 hide-991">
		<img src="<?php echo e($howItWorksRecruiterData['Image']); ?>" alt="" />
	</div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/homepage-component/how-it-works-for-recruiter.blade.php ENDPATH**/ ?>