<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<?php
use App\Models\User;
?>
    <?php echo $__env->make('admin.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="app-main">
        <?php echo $__env->make('admin.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(User::getBackendRole() == config('app.superAdminRoleId')): ?>    
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title app-page-title-simple">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div>
                                    <div class="page-title-head center-elem">
                                        <span class="d-inline-block pr-2">
                                            <i class="lnr-apartment opacity-6"></i>
                                        </span>
                                        <span class="d-inline-block">Dashboard</span>
                                    </div>
                                    <div class="page-title-subheading opacity-10">
                                        <nav class="" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a href="<?php echo e(route('adminDashboard')); ?>">
                                                        <i aria-hidden="true" class="fa fa-home"></i>
                                                    </a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    <a>Dashboard</a>
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = $todayCounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-3">
                                <div
                                    class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase"><?php echo e($item['name']); ?></div>
                                            <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                <div class="widget-chart-flex align-items-center">
                                                    <div><?php echo e($item['count']); ?></div>
                                                    <div
                                                        class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                                        <div
                                                            class="circle-progress circle-progress-gradient-alt-sm d-inline-block">
                                                            <i style="font-size: 32px;" class="<?php echo e($item['icon']); ?>"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="main-card mb-3 card expand_filter">
                        <h5 class="card-header" style="display: grid">
                            <a data-toggle="collapse" href="#collapse-example" aria-expanded="true"
                                aria-controls="collapse-example" id="heading-example" class="d-block">
                                <i class="fa fa-chevron-down pull-right"></i>
                                Filter
                            </a>
                        </h5>
                        <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
                            <div class="card-body">
                                <form id="filterDashboardForm" method="post" class="form-inline">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                        <label for="from_date" class="mr-sm-2">From Date</label>
                                        <input type="text" name="from_date" id="from_date" class="form-control"
                                            value="<?php echo e(date('m/01/Y')); ?>" />
                                        <div id="from_date_error" style="color: red;"></div>
                                    </div>
                                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                        <label for="to_date" class="mr-sm-2">To Date</label>
                                        <input type="text" name="to_date" id="to_date" class="form-control"
                                            value="<?php echo e(date('m/d/Y')); ?>" />
                                    </div>
                                    <button type="button" id="filter_dashboard_count" class="btn btn-primary">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = $thisMonthCounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-3">
                                <div
                                    class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase"><?php echo e($item['name']); ?></div>
                                            <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                <div class="widget-chart-flex align-items-center">
                                                    <div id="countBox<?php echo e($key + 1); ?>"><?php echo e($item['count']); ?></div>
                                                    <div
                                                        class="widget-title ml-auto font-size-lg font-weight-normal text-muted">
                                                        <div
                                                            class="circle-progress circle-progress-gradient-alt-sm d-inline-block">
                                                            <i style="font-size: 32px;" class="<?php echo e($item['icon']); ?>"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="mb-3 card">
                                <div class="card-header-tab card-header">
                                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal"
                                        style="display: block;width:100%">Customer Traffic
                                        <div class="pull-right">
                                            <?php ($graphDuration = ['daily' => 'Daily', 'monthly' => 'Monthly', 'yearly' => 'Yearly']); ?>
                                            <?php ($i = 0); ?>
                                            <?php $__currentLoopData = $graphDuration; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="custom-radio custom-control custom-control-inline">
                                                    <?php echo e(Form::radio('result', $key, !$i, ['class' => 'custom-control-input radioBtnGraph1Duration','id' => 'result' . $key])); ?>

                                                    <label class="custom-control-label"
                                                        for="result<?php echo e($key); ?>"><?php echo e($item); ?></label>
                                                </div>
                                                <?php ($i++); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-0 card-body">
                                    <div id="customer-traffic"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="mb-3 card">
                                <div class="card-header-tab card-header">
                                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal"
                                        style="display: block;width:100%">Revenue vs Payout
                                        <div class="pull-right">
                                            <?php ($graphDuration = ['monthly' => 'Monthly', 'yearly' => 'Yearly']); ?>
                                            <?php ($i = 0); ?>
                                            <?php $__currentLoopData = $graphDuration; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="custom-radio custom-control custom-control-inline">
                                                    <?php echo e(Form::radio('result2', $key, !$i, ['class' => 'custom-control-input radioBtnDuration','id' => 'result2' . $key])); ?>

                                                    <label class="custom-control-label"
                                                        for="result2<?php echo e($key); ?>"><?php echo e($item); ?></label>
                                                </div>
                                                <?php ($i++); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-0 card-body">
                                    <div id="revenue-vs-payout"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-left mb-3 border-primary card">
                                <div class="card-header">
                                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Top 5
                                        Companies
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="TdatatableTopSongs"
                                        class="display nowrap table table-hover table-striped table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr class="">
                                                <th>Icon</th>
                                                <th>Company Name</th>
                                                <th>#Jobs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $topCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><img src="<?php echo e($item['company']['logo']); ?>" width="20" alt=""></td>
                                                    <td><?php echo e($item['company']['name']); ?></td>
                                                    <td><?php echo e($item['total']); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-left mb-3 border-primary card">
                                <div class="card-header">
                                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Top 5
                                        Recruiters
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="TdatatableTopArtists"
                                        class="display nowrap table table-hover table-striped table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr class="">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>#Approved</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $topRecruiters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item['related_id']); ?></td>
                                                    <td><?php echo e($item['name']); ?></td>
                                                    <td><?php echo e($item['total']); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Pending Job Fund
                                Transfer Requests</div>
                        </div>
                        <div class="card-body">
                            <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Action</th>
                                        <th>Company</th>
                                        <th>From Job</th>
                                        <th>To Job</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Reject Reason</th>
                                        <th>Requested On</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>

                <?php echo $__env->make('admin.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modals-content'); ?>
    <!-- Modal for approve balance -->
    <div class="modal fade" id="JobBalanceApproveModel" tabindex="-1" role="dialog"
        aria-labelledby="JobBalanceApproveModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="JobBalanceApproveModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="tokenAccept" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="job_balance_id" id="job_balance_id">
                    <p class="mb-0" id="message_approve"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="approveJobBalance">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for reject balance -->
    <div class="modal fade" id="JobBalanceRejectModel" tabindex="-1" role="dialog"
        aria-labelledby="JobBalanceRejectModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="JobBalanceRejectModelLabel">Reject Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="job_balance_id" id="job_balance_id">
                    <div>
                        <label for="paymentId"><b> Reject Reason:</b></label>
                        <span class="text-danger">*</span>
                        <textarea required id="reject_reason" class="form-control"></textarea>
                        <span class="text-danger" id="required-reject_reason"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="rejectJobBalance">Reject</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('public/assets/js/dashboard/dashboard.js')); ?>?r=02032022" data-base-url="<?php echo e(url('/')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>