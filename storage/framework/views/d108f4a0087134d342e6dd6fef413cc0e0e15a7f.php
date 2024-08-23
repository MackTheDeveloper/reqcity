<?php $__env->startSection('title','Permission'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="app-main">
        <?php echo $__env->make('admin.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="app-main__outer" style="width: 100%;">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-head center-elem">
                                <span class="d-inline-block pr-2">
                                    <i class="lnr-users opacity-6"></i>
                                </span>
                                <span class="d-inline-block">Permission</span>
                            </div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a>
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0);">Roles</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo e(url(config('app.adminPrefix').'/user/role/list')); ?>">Roles List</a>
                                        </li>
                                        <li class="breadcrumb-item" aria-current="page">
                                           <a href="#">Permission</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <!-- <h5 class="card-title">List Of Permissions</h5> -->
                        <div style="width:100%;height:387px;overflow-x:auto;overflow-y:auto;">
                            <table style="white-space:nowrap;margin-bottom: 0;" class="table table-striped table-bordered table-hover">
                                <?php $__currentLoopData = $arrPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $permissionGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th><?php echo e($group); ?></th>
                                    <?php $__currentLoopData = $permissionGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td style="font-size:14px;">
                                            <?php if($role->permissions()->find($permission->id)): ?>
                                            <div class="row">
                                                <div class="col-sm-12" style="display: flex;justify-content: space-between;align-items:center">
                                                    <label style="margin-bottom: 0;" for="permission_title"><?php echo e($permission->permission_title); ?></label>
                                                    <button type="button" style="margin-right: 0" data-permId="<?php echo e($permission->id); ?>" class="btn btn-sm btn-toggle active toggle-is-active-switch permission_click" data-toggle="button" aria-pressed="true" autocomplete="off">
                                                    <div class="handle"></div>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <div class="row">
                                                <div class="col-sm-12" style="display: flex;justify-content: space-between;align-items:center">
                                                    <label style="margin-bottom: 0;" for="permission_title"><?php echo e($permission->permission_title); ?></label>
                                                    <button type="button" style="margin-right: 0" data-permId="<?php echo e($permission->id); ?>" class="btn btn-sm btn-toggle toggle-is-active-switch permission_click" data-toggle="button" aria-pressed="false" autocomplete="off">
                                                    <div class="handle"></div>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('admin.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<div style="background:rgba(0, 0, 0, 0.5); height:100%; left:0; opacity:0.3; position:fixed; top:0; width:100%; display:none;" id="loadingorverlay"></div>
<div style="left:50%; position:fixed; top:50%; display:none;" id="loaderimage">
    <img src="<?php echo e(asset('admin/layout/img/loading-spinner-blue.gif')); ?>" alt="" />
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    var role_id = "<?php echo e($role->id); ?>";
    $('.permission_click').on('click', function(){
        var permId = $(this).attr('data-permId');
        $('#loaderimage').css("display", "block");
        $('#loadingorverlay').css("display", "block");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                url:"<?php echo e(url(config('app.adminPrefix').'/role/permissions/')); ?>" + "/" + role_id,
                type: "post",
                async: true,
                data: 'permission=' + permId + '&_token=<?php echo e(csrf_token()); ?>',
                success: function (response) {
                    $('#loaderimage').css("display", "none");
                    $('#loadingorverlay').css("display", "none");
                    if (response == 'success') {
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.success('Permission has been updated successfully!');
                } else {
                    toastr.options.closeButton = true;
                    toastr.success('Permission has not been updated!')
                }

                }
        });
    })
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/users/role/permissions.blade.php ENDPATH**/ ?>