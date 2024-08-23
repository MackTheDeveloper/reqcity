<?php if(!empty($jobListData) && count($jobListData) > 0): ?>
    <?php $__currentLoopData = $jobListData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="job-posts">
            <div class="job-post-data">
                <a href="<?php echo e(route('recruiterJobsDetail', $jobs['jobSlug'])); ?>">
                    <p class="tm"><?php echo e($jobs['jobTitle']); ?> (<?php echo e($jobs['companyName']); ?>)</p>
                </a>
                <p class="ll blur-color">
                    <?php if(isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote'): ?>
                        <?php echo e($jobs['jobRemoteWork']); ?> - <?php echo e($jobs['companyCountry']); ?>

                    <?php else: ?>
                        <?php echo e($jobs['companyCity']); ?><?php echo e($jobs['companyState'] ? ', ' . $jobs['companyState'] : ''); ?><?php echo e($jobs['companyCountry'] ? ', ' . $jobs['companyCountry'] : ''); ?>

                    <?php endif; ?>
                    
                </p>
                <p class="bm blur-color"><?php echo str_replace(['<p>', '</p>'], '', $jobs['jobShortDescription']); ?></p>
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
                                <label class="ll"><?php echo e($jobs['jobApproved']); ?></label>
                                <span class="bs blur-color">Approved</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><?php echo e($jobs['jobRemainingApprovals']); ?></label>
                                <span class="bs blur-color">Remaining Approvals</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><?php echo e($jobs['jobMyApproved']); ?></label>
                                <span class="bs blur-color">My Approved</span>
                                <?php if(!empty($jobs['jobMyApprovedList'])): ?>
                                    <div class="hoverd-data-wrapper">
                                        <div class="hoverd-data-outer">
                                            <div class="hoverd-data-inner">
                                                <ul>
                                                    <?php $__currentLoopData = $jobs['jobMyApprovedList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <a href="">
                                                                <span
                                                                    class="bm"><?php echo e($v['full_name']); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><?php echo e($jobs['jobMyRejected']); ?></label>
                                <span class="bs blur-color">My Rejected</span>
                                <?php if(!empty($jobs['jobMyRejectedList'])): ?>
                                    <div class="hoverd-data-wrapper">
                                        <div class="hoverd-data-outer">
                                            <div class="hoverd-data-inner">
                                                <ul>
                                                    <?php $__currentLoopData = $jobs['jobMyRejectedList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <a href="">
                                                                <span
                                                                    class="bm"><?php echo e($v['full_name']); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><?php echo e($jobs['jobMyPending']); ?></label>
                                <span class="bs blur-color">My Pending</span>
                                <?php if(!empty($jobs['jobMyPendingList'])): ?>
                                    <div class="hoverd-data-wrapper">
                                        <div class="hoverd-data-outer">
                                            <div class="hoverd-data-inner">
                                                <ul>
                                                    <?php $__currentLoopData = $jobs['jobMyPendingList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <a href="">
                                                                <span
                                                                    class="bm"><?php echo e($v['full_name']); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-post-status">
                <a href="<?php echo e(route('recruiterCandidateSubmitStart', $jobs['jobSlug'])); ?>" class="fill-btn">Submit
                    Candidate</a>
                <label class="bk">
                    <input type="checkbox" data-job-id="<?php echo e($jobs['jobId']); ?>" class="makeFavourite"
                        <?php echo e($jobs['isFavorite'] == 1 ? 'checked' : ''); ?> />
                    <span class="bk-checkmark"></span>
                </label>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/jobs/components/job-list.blade.php ENDPATH**/ ?>