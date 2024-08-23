<?php if(!empty($jobListData) && count($jobListData) > 0): ?>
    <?php $__currentLoopData = $jobListData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="job-posts">
            <div class="job-post-data">
                <a href="<?php echo e(route('showCompanyJobDetails', $jobs['jobSlug'])); ?>">
                    <p class="tm"><?php echo e($jobs['jobTitle']); ?></p>
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
                                <label class="ll"><a
                                        href="<?php echo e(route('showCompanyCandidate', ['jobid' => $jobs['jobId']])); ?>"
                                        class="ll"><?php echo e($jobs['jobPending']); ?></a></label>
                                <span class="bs blur-color"><a
                                        href="<?php echo e(route('showCompanyCandidate', ['jobid' => $jobs['jobId']])); ?>"
                                        class="bs blur-color">Pending</a></span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><a
                                        href="<?php echo e(route('showCompanyCandidate', ['jobid' => $jobs['jobId']])); ?>"
                                        class="ll"><?php echo e($jobs['jobApproved']); ?></a></label>
                                <span class="bs blur-color"><a
                                        href="<?php echo e(route('showCompanyCandidate', ['jobid' => $jobs['jobId']])); ?>"
                                        class="bs blur-color">Approved</a></span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll"><a
                                        href="<?php echo e(route('showCompanyCandidate', ['jobid' => $jobs['jobId']])); ?>"
                                        class="ll"><?php echo e($jobs['jobRejected']); ?></label>
                                <span class="bs blur-color"><a
                                        href="<?php echo e(route('showCompanyCandidate', ['jobid' => $jobs['jobId']])); ?>"
                                        class="bs blur-color">Rejected</a></span>
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
            <div class="job-post-status">
                <div class="dropdown status_dropdown"
                    data-color="<?php echo e($jobs['statusColor'] ? $jobs['statusColor'] : ''); ?>">
                    <button
                        class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn"
                        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                        data-bs-offset="0,12">
                        <?php echo e($jobs['statusText'] ? $jobs['statusText'] : ''); ?>

                    </button>
                    <ul class="dropdown-menu status_change" aria-labelledby="dropdownMenuButton1">
                        <?php if(($jobs['companyStatus'] === 3 || $jobs['companyStatus'] === 2) && !getPaymentStatusByJobId($jobs['jobId'])): ?>
                            <li>
                                <a class="dropdown-item job-change-status" data-class="open" data-status="1"
                                    data-id="<?php echo e($jobs['jobId']); ?>" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Open
                                </a>
                            </li>
                            
                        <?php endif; ?>
                        <?php if($jobs['companyStatus'] === 1): ?>
                            <li>
                                <a class="dropdown-item job-change-status" data-class="paused" data-status="3"
                                    data-id="<?php echo e($jobs['jobId']); ?>" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Paused
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(in_array($jobs['companyStatus'], [1, 2])): ?>
                            <?php if($jobs['blanaceToCheck']>0): ?>
                                <li>
                                    <a class="dropdown-item job-close" data-class="closed"
                                        data-id="<?php echo e($jobs['jobId']); ?>" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#closeJob">
                                        <div class="status-round"></div>Closed
                                    </a>
                                </li>
                            <?php else: ?>
                                <a class="dropdown-item job-change-status" data-class="closed" data-status="4"
                                    data-id="<?php echo e($jobs['jobId']); ?>" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Closed
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if($jobs['companyStatus'] === 1 || $jobs['companyStatus'] === 3): ?>
                            <li>
                                <a class="dropdown-item job-change-status" data-class="drafted" data-status="2"
                                    data-id="<?php echo e($jobs['jobId']); ?>" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Drafted
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="dropdown c-dropdown my-playlist-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?php echo e(asset('public/assets/frontend/img/more-vertical.svg')); ?>"
                            class="c-icon" />
                    </button>
                    <div class="dropdown-menu">
                        <?php ($statuses = [2, 3]); ?>
                        <a class="dropdown-item" href="<?php echo e(route('showCompanyJobDetails', $jobs['jobSlug'])); ?>">
                            <!-- <img src="<?php echo e(asset('public/assets/frontend/img/Hovered-heart.svg')); ?>" alt="" /> -->
                            <?php if(in_array($jobs['status'], $statuses)): ?>
                                <span>Edit & Publish Job</span>
                            <?php else: ?>
                                <span>View Detail</span>
                            <?php endif; ?>
                        </a>
                        <?php if(!in_array($jobs['status'], $statuses)): ?>
                            <a class="dropdown-item edit-job-description" href="javascript:void(0)"
                                data-id="<?php echo e($jobs['jobId']); ?>">
                                <span>Edit Job Detail</span>
                            </a>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/components/job-list.blade.php ENDPATH**/ ?>