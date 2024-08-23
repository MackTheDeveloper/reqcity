<?php $__env->startSection('title','Candidate Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="dashboard-compnay dash-candidate">
        <div class="dashboards-main">
            <div class="row">
                <div class="col-md-12 col-lg-8 col-xl-9">

                    <div class="recruiter-candidate-dashbox">
                        <div class="reqstudent-dash-head">
                            <h5><?php echo e($candidateData['candidateName']); ?></h5>
                        </div>
                        <span><?php echo e($candidateData['candidatePhone']); ?></span>
                        <span><?php echo e($candidateData['candidateEmail']); ?></span>
                        <span><?php echo e($candidateData['candidateAddress']); ?></span>
                    </div>


                    <div class="active-jobs-dash">
                        <div class="active-job-head">
                            <h6>Applied Jobs</h6>
                            <a href="<?php echo e(route('candidateJobs','applied')); ?>">View All</a>
                        </div>
                        <span class="full-hr"></span>
                        <div class="appliedjobs-detailed">
                            <div class="div-table-wrapper">
                                <div class="div-table">
                                    <div class="div-row">
                                        <div class="div-column">
                                            <p class="ll blur-color">Job Title</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">Company</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">City</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">Salary($)</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">Status</p>
                                        </div>

                                    </div>

                                    <?php if(!empty($appliedJobs->toArray())): ?>
                                    <?php $__currentLoopData = $appliedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="div-row">
                                        <div class="div-column">
                                            <p class="tm"><?php echo e($v->companyJob->title); ?></p>
                                        </div>
                                        <div class="div-column">
                                            <p class="bm"><?php echo e($v->companyJob->Company->name); ?></p>
                                        </div>
                                        <div class="div-column">
                                            <p class="bm"><?php echo e($v->companyJob->Company->address->city); ?>,
                                                <?php echo e($v->companyJob->Company->address->countries->name); ?></p>
                                        </div>
                                        <div class="div-column">
                                            <p class="bm"><?php echo e(getFormatedAmount($v->companyJob->from_salary,2) . ($v->companyJob->compensation_type == 'r' ? ' - '.getFormatedAmount($v->companyJob->to_salary,2) : '') . ' a '. $v->companyJob->salary_type); ?></p>
                                        </div>
                                        <div class="div-column">
                                            <?php if($v->status == 0): ?>
                                            <p class="ll blur-color" style="color: #e0ce09 !important;">Pending</p>
                                            <?php elseif($v->status == 1): ?>
                                            <p class="ll blur-color" style="color: #4C65FF !important;">Recruiter Assigned</p>
                                            <?php elseif($v->status == 2): ?>
                                            <p class="ll blur-color" style="color: #0ba360 !important;">Submitted</p>
                                            <?php elseif($v->status == 3): ?>
                                            <p class="ll blur-color" style="color: #3ac47d !important;">Accepted</p>
                                            <?php elseif($v->status == 4): ?>
                                            <p class="ll blur-color" style="color: red !important;">Rejected</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="active-jobs-dash">
                        <div class="active-job-head">
                            <h6>Similar Jobs</h6>
                            <a href="<?php echo e(route('candidateJobs','similar')); ?>">View All</a>
                        </div>
                        <span class="full-hr"></span>
                        <?php echo $__env->make('frontend.candidate.dashboard.components.similar-jobs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-3">
                    <div class="dashboard-sidebar">
                        <?php echo $__env->make('frontend.candidate.dashboard.components.getting-started', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('frontend.candidate.dashboard.components.updates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('frontend.components.delete-confirm',['title'=>'Confirm','message'=>'Are you sure?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
<script type="text/javascript">
    $(document).on("click", ".makeFavourite", function(e) {
        var jobId = $(this).attr('data-job-id');
        $.ajax({
            url: "<?php echo e(url('/candidate-jobs/make-favorite')); ?>",
            type: "POST",
            data: {
                jobId: jobId,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.message);
            },
        });
    });

    $(document).on('submit', '.applyNowCandidate', function(e) {
        e.preventDefault();
        var formAcion = $(this).attr('action')
        var title = "confirm";
        var message = "Are you sure?";
        $("#ConfirmModel #deleteConfirmed").attr("action", formAcion);
        $("#ConfirmModel").modal('show');
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/dashboard/dashboard.blade.php ENDPATH**/ ?>