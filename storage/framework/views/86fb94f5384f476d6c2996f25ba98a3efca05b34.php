<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Language" content="en">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title><?php echo e(config('app.name_show')); ?> - <?php echo $__env->yieldContent('title'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
  <meta name="description" content="This is an example dashboard created using build-in elements and components.">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- Disable tap highlight on IE -->
  <meta name="msapplication-tap-highlight" content="no">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- <link rel="icon" href="<?php echo e(asset('public/assets/frontend/img/favicon.png')); ?>" type="image/x-icon" /> -->

  <?php echo $__env->yieldPushContent('styles'); ?>
  <?php echo $__env->make('admin.include.top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
  <div class="loader-bg d-none">
    <section><span class="loader-11"> </span></section>
  </div>
  <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar <?php echo e(Session::get('toggleSidebar')?'':'closed-sidebar'); ?>">
    <?php echo $__env->yieldContent('content'); ?>
  </div>
  <?php echo $__env->yieldContent('modals-content'); ?>

  <!-- Creates the bootstrap modal where the image will appear -->
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body text-center">
          <img src="" id="imagepreview" class="img-fluid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="app-drawer-overlay d-none animated fadeIn"></div>
  <?php echo $__env->make('admin.include.bottom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->yieldPushContent('scripts'); ?>
  <script>
    <?php if(Session::has('message')): ?>
    var type = "<?php echo e(Session::get('alert-type', 'info')); ?>";
    switch (type) {
      case 'info':
        toastr.info("<?php echo e(Session::get('message')); ?>");
        break;

      case 'warning':
        toastr.warning("<?php echo e(Session::get('message')); ?>");
        break;

      case 'success':
        toastr.success("<?php echo e(Session::get('message')); ?>");
        break;

      case 'error':
        toastr.error("<?php echo e(Session::get('message')); ?>");
        break;
    }
    <?php endif; ?>
  </script>

</body>

</html><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/layouts/master.blade.php ENDPATH**/ ?>