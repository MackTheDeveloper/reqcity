<?php if(!empty($jobListData) && count($jobListData) > 0): ?>
    <?php $__currentLoopData = $jobListData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="job-posts-row">
            <div class="job-post-data">
                <a href="<?php echo e(route('showJobDetails', $jobs['jobSlug'])); ?>">
                    <p class="tm"><?php echo e($jobs['jobTitle']); ?> (<?php echo e($jobs['companyName']); ?>)</p>
                </a>
                
                <p class="ll blur-color">
                    <?php if(isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote'): ?>
                        <?php echo e($jobs['jobRemoteWork']); ?> - <?php echo e($jobs['companyCountry']); ?>

                    <?php else: ?>
                        <?php echo e($jobs['companyCity']); ?><?php echo e($jobs['companyState'] ? ',' . $jobs['companyState'] : ''); ?>

                    <?php endif; ?>
                </p>
                <p class="bm blur-color"><?php echo e($jobs['jobShortDescription']); ?></p>
                <div class="job-table">
                    <div class="first-data">
                        <?php if(empty($jobs['isHidecompensationDetails']) || $jobs['isHidecompensationDetails'] == 'no'): ?>
                            <label class="ll"><?php echo e($jobs['salaryText']); ?> a <?php echo e($jobs['salaryType']); ?></label>
                        <?php endif; ?>
                        <span class="bs blur-color"><?php echo e($jobs['postedOn']); ?></span>
                    </div>
                    <div class="last-data">
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><?php echo e($jobs['jobOpenings']); ?></label>
                                <span class="bs blur-color">Openings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-post-status">
                <?php if($jobs['isApplied'] != 1): ?>
                    <form data-job-id="<?php echo e($jobs['jobId']); ?>" class="applyNowCandidate" data-type="downgrade">

                        <button class="fill-btn">Apply Now</button>
                    </form>
                <?php else: ?>
                    <button class="fill-btn" disabled>Applied</button>
                <?php endif; ?>
                <label class="bk">
                    <input data-job-id="<?php echo e($jobs['jobId']); ?>" class="makeFavourite" type="checkbox"
                        <?php echo e($jobs['isFavorite'] == 1 ? 'checked' : ''); ?> />
                    <span class="bk-checkmark"></span>
                </label>

            </div>

        </div>
        <?php echo $__env->make('frontend.components.delete-confirm', [
            'title' => 'Confirm',
            'message' => 'Are you sure?',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.candidate.jobs.components.apply-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/jobs/components/job-list.blade.php ENDPATH**/ ?>