<?php $__env->startSection('title','Roles'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="app-main">
        <?php echo $__env->make('admin.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa fa-users opacity-6"></i>
                                    </span>
                                    <span class="d-inline-block">Roles</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo e(route('adminDashboard')); ?>">
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item ">
                                                <a href="javascript:void(0);">Roles</a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page">
                                                List
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="page-title-actions">
                            <div class="d-inline-block dropdown">
                                <!-- <a href="<?php echo e(url(config('app.adminPrefix').'/user/role/add')); ?>"><button type="button" class="btn-shadow btn btn-info">
                                    <span class="btn-icon-wrapper pr-2 opacity-7">
                                        <i class="fa fa-plus fa-w-20"></i>
                                    </span>
                                    New Role
                                </button></a> -->
                                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_role_add') === true): ?>
                                <a href="<?php echo e(url(config('app.adminPrefix').'/user/role/add')); ?>"><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-plus btn-icon-wrapper"> </i>Add Role</button></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-left" width="300px">
                                        Role
                                    </th>
                                    <th class="text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($roles->count()): ?>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="odd gradeX">
                                    <td class="text-left">
                                        <?php echo e($role->role_title); ?>

                                    </td>
                                    <td class="text-center" style="max-width:100px; min-width:100px;">
                                        <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_role_assign_permission') === true || Auth::guard('admin')->user()->id == 1): ?>
                                        <?php if($role->id != 1): ?>
                                        <a href="<?php echo e(url(config('app.adminPrefix').'/role/permissions').'/'.$role->id); ?>"><i aria-hidden="true" class="fa fa-lock" style="margin-bottom: 10px;font-size: 16px;"></i></a>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_role_edit') === true || Auth::guard('admin')->user()->id == 1): ?>
                                        <a href="<?php echo e(url(config('app.adminPrefix').'/user/role/edit').'/'.$role->id); ?>"><i aria-hidden="true" class="fa fa-edit" style=" margin-left: 10px;margin-bottom: 10px;font-size: 16px;"></i></a>
                                        <?php endif; ?>
                                        <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_role_delete') === true || Auth::guard('admin')->user()->id == 1): ?>
                                            <?php if($role->id != 1): ?>
                                            <a href="javascript:void(0);" data-role_id="<?php echo e($role->id); ?>" class="delete_role"><i class="fa fa-trash" aria-hidden="true" style=" margin-left: 10px;margin-bottom: 10px;font-size: 16px;"> </i></a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="2">No Roles Found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('admin.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modals-content'); ?>
    <!-- Modal Start -->
    <div class="modal" id="deleteRoleModel" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModelLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="role_id" id="role_id">
                    <p class="mb-0" id="delete_message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="deleteRole">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Over -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.delete_role').click(function() {
            var role_id = $(this).attr('data-role_id');
            var message = "Are you sure?";
            $('#deleteRoleModel').on('show.bs.modal', function(e) {
                $('#role_id').val(role_id);
                $('#delete_message').text(message);
            });
            $('#deleteRoleModel').modal('show');
        })

        $('#deleteRole').on('click', function() {
            var role_id = $('#role_id').val();
            $.ajax({
                url: "<?php echo e(url(config('app.adminPrefix').'/user/role/delete')); ?>",
                method: 'POST',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "role_id": role_id
                },
                success: function(response) {
                    if (response.status == 'true') {
                        // $('#deleteRoleModel').modal('hide');
                        // toastr.clear();
                        // toastr.options.closeButton = true;
                        // toastr.success('Role has been deleted successfully!');
                        // setTimeout(function(){
                        location.reload();
                        // }, 3000);
                    } else {
                        // $('#deleteRoleModel').modal('hide');
                        // toastr.clear();
                        // toastr.options.closeButton = true;
                        // toastr.success('Role has not been deleted successfully!');
                        // setTimeout(function(){
                        window.location.href = '/securerccontrol/user/role/list';
                        // }, 3000);
                    }
                }
            })
        })
    })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/users/role/roles.blade.php ENDPATH**/ ?>