<!DOCTYPE html>
<html>
<?php echo $__env->make('frontend.include.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="body">
    <!--------------------------
 HEADER START
 --------------------------->
    <?php echo $__env->yieldContent('content'); ?>

</body>
<?php echo $__env->make('frontend.include.bottom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</html>
<?php /**PATH /var/www/html/php/reqcity/resources/views/errors/layout.blade.php ENDPATH**/ ?>