<?php if(Auth::check()): ?>
    <?php ($authenticateClass = ''); ?>
<?php else: ?>
    <?php ($authenticateClass = 'loginBeforeGo'); ?>
<?php endif; ?>
<!--------------------------
      FOOTER END
--------------------------->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <div class="footer-first">
                    <a href="" class="footer-logo">
                        <img src="<?php echo e(asset('public/assets/frontend/img/Logo-white.svg')); ?>" alt="" />
                    </a>
                    <p class="bl">
                        <?php echo e(app('App\Models\GlobalSettings')::getSingleSettingVal('about')); ?>

                    </p>
                    <div class="footer-social">
                        <a href="<?php echo e(app('App\Models\GlobalSettings')::getSingleSettingVal('fb_link')); ?>" target="_blank"><img
                                src="<?php echo e(asset('public/assets/frontend/img/Fb.svg')); ?>" alt="" /></a>
                        <a href="<?php echo e(app('App\Models\GlobalSettings')::getSingleSettingVal('twitter_link')); ?>" target="_blank"><img
                                src="<?php echo e(asset('public/assets/frontend/img/Tw.svg')); ?>" alt="" /></a>
                        <a href="<?php echo e(app('App\Models\GlobalSettings')::getSingleSettingVal('insta_link')); ?>" target="_blank"><img
                                src="<?php echo e(asset('public/assets/frontend/img/Inst.svg')); ?>" alt="" target="_blank" /></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                <div class="footer-link-wrapper">
                    <?php $__currentLoopData = $frontendFooter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="footer-block">
                            <p class="tm"><?php echo e($item['footerDetails']['footerName']); ?></p>
                            <ul>
                                <?php $__currentLoopData = $item['footerMenuData']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $item1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($authenticateClass && $item['footerDetails']['footerType'] != ('cms' || 'category') ? 'javascript:void(0)' : $item1); ?>"
                                            class="<?php echo e($item['footerDetails']['footerType'] != ('cms' || 'category') ? $authenticateClass : ''); ?>"><?php echo e($key1); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="footer-hr"></div>
    </div>
</footer>
<!------   FOOTER END
--------------------------->
<!----- Book a demo Moal --->
<div class="modal fade modal-structure book-a-demo-popup" id="bookADemo">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bookRequestFromPopup" method="POST" action="<?php echo e(url('/book-request')); ?>">
                <?php echo csrf_field(); ?>
                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Book a Demo</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" />
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-groups">
                        <span>I am</span>
                        <div class="radio-groups">
                            <div class="row">
                                <div class="col-6">
                                    <label class="rd">Company
                                        <input type="radio" name="type" id="company_type" value="1" checked />
                                        <span class="rd-checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="rd">Recruiter
                                        <input type="radio" name="type" id="recruiter_type" value="2" />
                                        <span class="rd-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-groups">
                        <span>Name</span>
                        <input type="text" name="first_name" id="first_name" />
                    </div>
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="email" name="email" id="email" />
                    </div>
                    <div class="number-groups">
                        <span>Phone Number</span>
                        <div class="number-fields">
                            <input type="text" id="phoneField1" name="phoneField1" class="phone-field" />
                            <input type="number" class="mobile-number" name="phone" id="phone">
                        </div>
                    </div>
                    <div class="input-groups mb-0">
                        <span>Requirement</span>
                        <textarea name="requirement" id="requirement"></textarea>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="border-btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="fill-btn">Book Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---- Book a demo modal end------>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/include/footer.blade.php ENDPATH**/ ?>