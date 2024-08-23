<?php $__currentLoopData = $companies['companies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="cpc-card">
  <img src="<?php echo e($v['companyLogo']); ?>" alt="" />
  <div class="this-content">
    <div class="company-list-header">
      <a href="<?php echo e(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_view')?route('companyViewDetails',$v['companyId']):'javascript:void(0)'); ?>"><p class="tl"><?php echo e($v['companyName']); ?></p></a>
      <div class="button-options pull-right dropdown">
        <button class="btn-icon btn-square btn btn-primary btn-sm getLoginLink" data-id="<?php echo e($v['companyId']); ?>">Login</button>
        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="threedot-toggle">
            <img src="<?php echo e(asset('public/assets/frontend/img/more-vertical.svg')); ?>" class="c-icon">
        </button>
        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
            <ul class="nav flex-column">
              <li class="nav-item"><a data-id="<?php echo e($v['companyId']); ?>" class="assignManager nav-link" href="javascript:void(0)">Assign Account Manager</a></li>
              <li class="nav-item"><a data-id="<?php echo e($v['companyId']); ?>" class="delete-company nav-link" href="javascript:void(0)">Delete</a></li>
            </ul>
        </div>
      </div>
    </div>
    <span class="ts blur-color"><?php echo e($v['companyCity']); ?><?php echo e($v['companyState'] ?', '.$v['companyState'] :''); ?><?php echo e($v['companyCountry'] ?', '.$v['companyCountry'] :''); ?></span>
    <span class="bm "><?php echo e($v['aboutCompany']); ?></span>
    <div class="last-data">
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll"><?php echo e($v['activeJobsCount']); ?></label>
          <span class="bs blur-color">Active Jobs</span>
        </div>
      </div>
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll"><?php echo e(ucfirst($v['currentSubscription'])); ?></label>
          <span class="bs blur-color">Subscription</span>
        </div>
      </div>
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll"><?php echo e($v['activeJobsBalance']); ?></label>
          <span class="bs blur-color">Balance</span>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/company-details/list/components/company-list.blade.php ENDPATH**/ ?>