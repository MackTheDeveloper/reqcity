<?php $__env->startSection('title',$cms->seo_title); ?>
<?php $__env->startSection('metaTitle',$cms->seo_title); ?>
<?php $__env->startSection('metaKeywords',$cms->seo_meta_keyword); ?>
<?php $__env->startSection('metaDescription',$cms->seo_description); ?>
<?php $__env->startSection('content'); ?>
<!--------------------------
        ABOUT US START
--------------------------->

<div class="aboutus-page">
    <div class="container">
      <div class="aboutus-pagein">
        <h2>Why ReqCity</h2>
        <div class="aboutpage-banner">
          <img src="<?php echo e(asset('public/assets/frontend/img/aboutus.png')); ?>" alt="aboutbanner">
        </div>
        <div class="aboutpage-content">
          <?php echo $cms->content; ?>

        </div>
      </div>
    </div>
</div>

<!--------------------------
        ABOUT US END
--------------------------->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
<script type="text/javascript">
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/pages/why-reqcity.blade.php ENDPATH**/ ?>