<h2><?php echo e($howItWorksCandidateData['title']); ?></h2>
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="pr-24">
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCandidateData['feature_1'])? $howItWorksCandidateData['feature_1']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCandidateData['description_1'])? $howItWorksCandidateData['description_1']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCandidateData['feature_2'])? $howItWorksCandidateData['feature_2']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCandidateData['description_2'])? $howItWorksCandidateData['description_2']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCandidateData['feature_3'])? $howItWorksCandidateData['feature_3']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCandidateData['description_3'])? $howItWorksCandidateData['description_3']:''); ?></span>
			</div>
			<div class="title-value">
				<p class="tm"><?php echo e(($howItWorksCandidateData['feature_4'])? $howItWorksCandidateData['feature_4']:''); ?></p>
				<span class="bl blur-color"><?php echo e(($howItWorksCandidateData['description_4'])? $howItWorksCandidateData['description_4']:''); ?></span>
			</div>
			<?php if(!Auth::check()): ?>
				<a href="<?php echo e(url('/candidate-signup')); ?>" class="fill-btn">Apply to a Job</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-6 hide-991">
		<img src="<?php echo e($howItWorksCandidateData['Image']); ?>" alt="" />
	</div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/homepage-component/how-it-works-for-candidate.blade.php ENDPATH**/ ?>