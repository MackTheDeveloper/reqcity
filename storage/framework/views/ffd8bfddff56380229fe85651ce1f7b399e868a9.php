<title><?php echo e(config('app.name_show')); ?> | Company Portal</title>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="app-main">
    <?php echo $__env->make('admin.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper justify-content-between">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo e(route('adminDashboard')); ?>">
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0);">Company Portal</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-switch d-none">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Card View</label>
                    </div>
                </div>
            </div>
            <div class="search-with-button">
                <input type="text" class="input search_text" id="search_text" name="search_text" placeholder="Search for company" />
                <button class="search-btn searchComapny"><img src="<?php echo e(asset('public/assets/frontend/img/white-search.svg')); ?>" alt="" /></button>
                <select class="ml-2 form-control sortBy" name="sortBy">
                    <option selected value="date_desc">Recently Added</option>
                    <option value="date_asc">Oldest</option>
                    <option value="name_asc">A-Z</option>
                    <option value="name_desc">Z-A</option>
                </select>
            </div>

            <div class="company-portal-card new-to-old">
                <div class="a-z-links">
                    <a class="charSearch selectedChar" data-char='' href="javascript:void(0)">#</a>
                    <?php $__currentLoopData = range('A', 'Z'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $char): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="javascript:void(0)" class="charSearch" data-char='<?php echo e($char); ?>'><?php echo e($char); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="ajaxComapnyList">
                    <?php echo $__env->make('admin.company-details.list.components.company-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <div class="job-posts not-found <?php echo e(!empty($companies['companies']) ? 'd-none' : ''); ?>">
                <div class="job-post-data"><?php echo e(config('message.frontendMessages.recordNotFound')); ?></div>
            </div>

            <div class="joblist-loadmore text-center <?php echo e(empty($companies['companies']) ? 'd-none' : ''); ?>">
                <input type="hidden" name="page_no" id="page_no" value="1">
                <button class="border-btn clickLoadMore  mb-5">Load More</button>
            </div>
        </div>
        <?php echo $__env->make('admin.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModelLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" name="module_id" id="module_id">
                <p class="mb-0" id="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="deleteCompany">Yes</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modals-content'); ?>
<?php echo $__env->make('admin.company-details.list.components.assign-manager', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    let token = '<?php echo e(csrf_token()); ?>';
</script>
<script src="<?php echo e(asset('public/assets/js/companies/companies.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/company-details/list/index.blade.php ENDPATH**/ ?>