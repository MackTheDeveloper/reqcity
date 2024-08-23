<?php $__env->startSection('title', $cms ? $cms->seo_title : 'Home page'); ?>
<?php $__env->startSection('metaKeywords', $cms ? $cms->seo_meta_keyword : ''); ?>
<?php $__env->startSection('metaDescription', $cms ? $cms->seo_description : ''); ?>

<?php $__env->startSection('content'); ?>
    <!--------------------------
            HOME START
        --------------------------->
    <div class="home-page">
        <!--- banner starts here --->
        <?php echo $__env->make('frontend.homepage-component.banner', ['bannerData' => $homePageBanner], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--- banner end here ---->
        <!--- how it works start here ---->
        <div class="CR-wrapper2">
            <div class="container">
                <div class="owl-carousel owl-theme">
                    <?php if($howItWorksCompanyData): ?>
                        <div class="item" data-dot="<button class='tl'>For Company</button>">
                            <?php echo $__env->make(
                                'frontend.homepage-component.how-it-works-for-company',
                                ['companyData' => $howItWorksCompanyData]
                            , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($howItWorksRecruiterData): ?>
                        <div class="item" data-dot="<button class='tl'>For Recruiter</button>">
                            <?php echo $__env->make(
                                'frontend.homepage-component.how-it-works-for-recruiter',
                                ['recruiterData' => $howItWorksRecruiterData]
                            , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($howItWorksCandidateData): ?>
                        <div class="item" data-dot="<button class='tl'>For Candidate</button>">
                            <?php echo $__env->make(
                                'frontend.homepage-component.how-it-works-for-candidate',
                                ['candidateData' => $howItWorksCandidateData]
                            , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--- how it works end here --->
        <!--- category starts here ---->
        
        <!--- category end here ---->
        <!--- highligheted jobs start here ---->
        
        <!--- highligheted jobs end here ---->
    </div>
    <!--------------------------
            HOME END
        --------------------------->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footscript'); ?>
    <!-- Start of HubSpot Embed Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/21856003.js"></script>
    <!-- End of HubSpot Embed Code -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/home.blade.php ENDPATH**/ ?>