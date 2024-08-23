<div class="home-page">
		<div class="home-page-head">
				<div class="container">
						<div class="row">
								<div class="col-12 col-sm-12 col-md-7">
										<div class="head-page-content h-100">
												<h1><?php echo e($bannerData['Header']); ?><br>
													<?php echo e($bannerData['Title']); ?></h1>
												<p class="bl"><?php echo e($bannerData['SubTitle']); ?></p>
												<!-- <div class="head-btn-block">
														<a href="<?php echo e(url('/company-signup')); ?>" class="border-btn">Company</a>
														<a href="<?php echo e(url('/recruiter-signup')); ?>" class="border-btn">Recruiter</a>
														<a href="<?php echo e(url('/candidate-signup')); ?>" class="border-btn">Candidate</a>
												</div> -->
												<div class="get-start-btn">
													<?php if(Auth::check()): ?>
												    <?php if(Auth::user()->role_id=='3'): ?>
												    	<a class="fill-btn" href="<?php echo e(url('/company-dashboard')); ?>">Go to dashboard!</a>
												    <?php elseif(Auth::user()->role_id=='4'): ?>
												    	<a class="fill-btn" href="<?php echo e(url('recruiter-dashboard')); ?>">Go to dashboard!</a>
														<?php elseif(Auth::user()->role_id=='5'): ?>
															<a class="fill-btn" href="<?php echo e(url('candidate-dashboard')); ?>">Go to dashboard!</a>
												    <?php endif; ?>
											    <?php else: ?>
											    	<a class="fill-btn" href="<?php echo e(url('/signup')); ?>">Sign up now!</a>
											    <?php endif; ?>

												</div>
												<div class="layout-636">
													<?php if(!empty($bannerData['CompanyLine'])): ?>
													<p class="ll"><?php echo $bannerData['CompanyLine']; ?></p>
													<?php endif; ?>
													<?php if(!empty($bannerData['RecruiterLine'])): ?>
													<p class="ll"><?php echo $bannerData['RecruiterLine']; ?></p>
													<?php endif; ?>
													<?php if(!empty($bannerData['CandidateLine'])): ?>
													<p class="ll"><?php echo $bannerData['CandidateLine']; ?></p>
													<?php endif; ?>
												</div>
										</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
										<div class="head-page-img pl-24">
												<img src="<?php echo e($bannerData['MainBanner']); ?>" alt="" />
										</div>
								</div>
						</div>
				</div>
		</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/homepage-component/banner.blade.php ENDPATH**/ ?>