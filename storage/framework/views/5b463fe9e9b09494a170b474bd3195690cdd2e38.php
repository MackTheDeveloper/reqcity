<div class="active-jobs-dash">
    <div class="active-job-head">
        <h6>Active Jobs</h6>
        <a href="<?php echo e(url('/company-jobs/open')); ?>">View All</a>
    </div>
    <span class="full-hr"></span>
    <?php if(!empty($activeJobs) && count($activeJobs)>0): ?>
    <?php $__currentLoopData = $activeJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="activejobs-detailed">
        <div class="activejob-titlehead">
            <div class="active-jobtitle">
              <a href="<?php echo e(route('showCompanyJobDetails',$jobs['jobSlug'])); ?>">   <p class="tm"><?php echo e($jobs['jobTitle']); ?></p></a>
                
                <span class="ll blur-color">
                    <?php if(isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote'): ?>
                        <?php echo e($jobs['jobRemoteWork']); ?> - <?php echo e($jobs['companyCountry']); ?>

                    <?php else: ?>
                        <?php echo e($jobs['companyCity']); ?><?php echo e($jobs['companyState'] ? ',' . $jobs['companyState'] : ''); ?>

                    <?php endif; ?>
                </span>
            </div>
            <div class="mores-dots">
                <div class="dropdown c-dropdown my-playlist-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?php echo e(asset('public/assets/frontend/img/more-vertical.svg')); ?>" class="c-icon" />
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="<?php echo e(route('showCompanyJobDetails',$jobs['jobSlug'])); ?>">
                        <!-- <img src="<?php echo e(asset('public/assets/frontend/img/Hovered-heart.svg')); ?>" alt="" /> -->
                        <span>View Detail</span>
                      </a>
                      <!-- <a class="dropdown-item">
                        <img src="<?php echo e(asset('public/assets/frontend/img/Hovered-heart.svg')); ?>" alt="" />
                        <span>Download</span>
                      </a> -->
                    </div>
                </div>
            </div>
        </div>
        <span class="actjob-address"><?php echo e($jobs['jobShortDescription']); ?></span>
        <div class="active-jobnumeric">
            <div class="job-table">
                <div class="first-data">
                    <label class="ll"><?php echo e($jobs['salaryText']); ?> a <?php echo e($jobs['salaryType']); ?></label>
                    <span class="bs blur-color"><?php echo e($jobs['postedOn']); ?></span>
                </div>
                <div class="last-data">
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><?php echo e($jobs['jobOpenings']); ?></label>
                            <span class="bs blur-color">Openings</span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobs['jobId']])); ?>" class="ll"><?php echo e($jobs['jobPending']); ?></label>
                            <span class="bs blur-color"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobs['jobId']])); ?>" class="bs blur-color">Pending</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobs['jobId']])); ?>" class="ll"><?php echo e($jobs['jobApproved']); ?></a></label>
                            <span class="bs blur-color"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobs['jobId']])); ?>" class="bs blur-color">Approved</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobs['jobId']])); ?>" class="ll"><?php echo e($jobs['jobRejected']); ?></a></label>
                            <span class="bs blur-color"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobs['jobId']])); ?>" class="bs blur-color">Rejected</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><?php echo e($jobs['amountRequired']); ?></label>
                            <span class="bs blur-color">Total Cost</span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><?php echo e($jobs['blanace']); ?></label>
                            <span class="bs blur-color">Balance</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/dashboard/components/active-jobs.blade.php ENDPATH**/ ?>