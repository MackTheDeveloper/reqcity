<div class="filter-section-wrapper">
    <div class="filter-section">
        <div class="filter-sec-header">
            <div class="filter-name-close">
                <p class="tl">Filter</p>
                <img src="<?php echo e(asset('public/assets/frontend/img/x.svg')); ?>" class="close-filter" alt="" />
            </div>
            <div class="clear-apply">
                <button class="border-btn">Clear All</button>
                <button class="fill-btn">Apply</button>
            </div>
        </div>
        <div class="filter-data-wrapper">
            <div class="row" "filtercheckboxes">
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    
                    <div class="input-groups filterDropDown">
                        <span>Category</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="parent_cat[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                <?php if(!empty($parentCategories) && count($parentCategories) > 0): ?>
                                    <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="ck"><?php echo e($row['name']); ?>

                                            <input name="parent_cat[]" type="checkbox" class="ck check"
                                                value="<?php echo e($row['id']); ?>">
                                            <span class="ck-checkmark" values="<?php echo e($row['name']); ?>"></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    
                    <div class="input-groups filterDropDown">
                        <span>Sub-Category</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="child_cat[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                <?php if(!empty($childCategories) && count($childCategories) > 0): ?>
                                    <?php $__currentLoopData = $childCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="ck"><?php echo e($row['name']); ?>

                                            <input name="child_cat[]" type="checkbox" class="ck check"
                                                value="<?php echo e($row['id']); ?>">
                                            <span class="ck-checkmark" values="<?php echo e($row['name']); ?>"></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <?php if(!empty($jobStatus)): ?>
                    <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                        
                        <div class="input-groups filterDropDown">
                            <span>Status</span>
                            <div class="multi-select-dropdown">
                                <label class="multi-dropdown-label"></label>
                                <div class="multi-dropdown-list">
                                    <label class="ck">All
                                        <input name="jobstatus[]" type="checkbox" class="ck check checkAllOption" checked>
                                        <span class="ck-checkmark" values="All"></span>
                                    </label>
                                    <?php if(!empty($jobStatus) && count($jobStatus) > 0): ?>
                                        <?php $__currentLoopData = $jobStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="ck"><?php echo e($row); ?>

                                                <input name="jobstatus[]" type="checkbox" class="ck check"
                                                    value="<?php echo e($key); ?>">
                                                <span class="ck-checkmark" values="<?php echo e($row); ?>"></span>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <label id="schedule-error-container" class="error"
                                for="job_schedule_ids[]"></label>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    

                    <div class="input-groups filterDropDown">
                        <span>Job Locations</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="joblocation[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                <?php if(!empty($jobLocations) && count($jobLocations) > 0): ?>
                                    <?php $__currentLoopData = $jobLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="ck"><?php echo e($row); ?>

                                            <input name="joblocation[]" type="checkbox" class="ck check"
                                                value="<?php echo e($key); ?>">
                                            <span class="ck-checkmark" values="<?php echo e($row); ?>"></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    
                    <div class="input-groups filterDropDown">
                        <span>Job Type</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="emp_type[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                <?php if(!empty($employmentType) && count($employmentType) > 0): ?>
                                    <?php $__currentLoopData = $employmentType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="ck"><?php echo e($row['value']); ?>

                                            <input name="emp_type[]" type="checkbox" class="ck check"
                                                value="<?php echo e($row['key']); ?>">
                                            <span class="ck-checkmark" values="<?php echo e($row['value']); ?>"></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-4">
                    
                    <div class="input-groups filterDropDown">
                        <span>Contract Type</span>
                        <div class="multi-select-dropdown">
                            <label class="multi-dropdown-label"></label>
                            <div class="multi-dropdown-list">
                                <label class="ck">All
                                    <input name="con_type[]" type="checkbox" class="ck check checkAllOption" checked>
                                    <span class="ck-checkmark" values="All"></span>
                                </label>
                                <?php if(!empty($contractType) && count($contractType) > 0): ?>
                                    <?php $__currentLoopData = $contractType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="ck"><?php echo e($row['value']); ?>

                                            <input name="con_type[]" type="checkbox" class="ck check"
                                                value="<?php echo e($row['key']); ?>">
                                            <span class="ck-checkmark" values="<?php echo e($row['value']); ?>"></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label id="schedule-error-container" class="error" for="job_schedule_ids[]"></label>
                    </div>
                </div>
                <div class="col-12 text-right job-filter-btn">
                    <button class="border-btn clearFilterJob">Clear All</button>
                    <button class="fill-btn filterJob">Apply</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/components/job-filters.blade.php ENDPATH**/ ?>