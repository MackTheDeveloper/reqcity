<?php $__env->startSection('title','Find Jobs'); ?>

<?php $__env->startSection('content'); ?>
<div class="candidate-fint-job">
  <div class="find-career-header">
    <div class="container">
      <h5>Find a career you'll love</h5>
      <p class="bm">Explore which careers have the highest job satisfaction, best salaries, and more</p>
      <div class="find-box-wrapper">
        <div class="input-searchbar">
          <span>What</span>
          <div class="searchbar">
            <input type="text" placeholder="Job title" class="input search_txt" id="search_txt" name="search_txt" value="<?php echo e($searchTitle ? $searchTitle : ''); ?>"/>
            <button><img src="<?php echo e(asset('public/assets/frontend/img/search.svg')); ?>" alt="" /></button>
          </div>
        </div>
        <div class="input-groups">
          <span>Where</span>
          <input type="text" placeholder="Job location" class="search_loc" id="search_loc" name="search_loc"/>
        </div>
        <button class="fill-btn searchJob">Search</button>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="browse-job-section">
      <div class="this-header">
        <h5>Browse top jobs by category</h5>
        <div class="choose-sortby">
          <div class="input-groups">
            <span>Choose a category</span>
            <select id="filter" name="filter" class="filterJob">
              <option value="">Select...</option>
              <?php if(!empty($parentCategories) && count($parentCategories)>0): ?>
              <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php if(!empty($searchCat) && $searchCat==$cat['id']) echo 'selected'; ?> value="<?php echo e($cat['id']); ?>"><?php echo e($cat['name']); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="sort-by-sec">
            <p class="bm">Sort by</p>
            <select class="select job-sort" id="job_sort" name="job_sort">
              <option value="latest">Recently Posted</option>
              <option value="old">Old Jobs</option>
              <option value="title_asc">A-Z</option>
              <option value="title_desc">Z-A</option>
            </select>
          </div>
        </div>
      </div>
      <?php if(!empty($jobListData)): ?>
      <div class="ajaxJobList">
       <?php echo $__env->make('frontend.candidate.jobs.components.job-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
      <?php endif; ?>
      <div class="job-posts-row not-found <?php echo e(!empty($jobListData) ? 'd-none' : ''); ?>">
        <div class="job-post-data"><?php echo e(config('message.frontendMessages.recordNotFound')); ?></div>
      </div>
      <div class="joblist-loadmore text-center <?php echo e(empty($jobListData) ? 'd-none' : ''); ?>">
           <input type="hidden" name="page_no" id="page_no" value="1">
           <button class="border-btn clickLoadMore  mb-5">Load More</button>
       </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footscript'); ?>
    <script type="text/javascript">
    $(document).on("click", ".makeFavourite", function(e) {
        var jobId = $(this).attr('data-job-id');
        $.ajax({
            url: "<?php echo e(url('/candidate-jobs/make-favorite')); ?>",
            type: "POST",
            data: {
                jobId: jobId,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.message);
            },
        });
    });

    $(document).on('submit','.applyNowCandidate',function (e) {
            e.preventDefault();
            var jobId = $(this).attr('data-job-id');
            $("#applyJob #applyConfirmed input#jobId").val(jobId);
            $("#applyJob").modal('show');
    })
        $(document).on('change', '.job-sort', function() {
          $('.loader-bg').removeClass('d-none');
          sortSearchFilterAjax();
        })
        $(document).on('click', '.searchJob', function() {
          $('.loader-bg').removeClass('d-none');
          sortSearchFilterAjax();
        })
        $(document).on('change', '.filterJob', function() {
          $('.loader-bg').removeClass('d-none');
          sortSearchFilterAjax();
        })
        $(document).on('change keydown', '.search_txt', function(e) {
          if(e.keyCode === 13) {
           sortSearchFilterAjax();
         }
        });
        $(document).on('change keydown', '.search_loc', function(e) {
          if(e.keyCode === 13) {
           sortSearchFilterAjax();
         }
        });
        function sortSearchFilterAjax(page="1",append=0) {
            var search = $('.search_txt').val();
            var searchLoc = $('.search_loc').val();
            var sort = $('.job-sort').val();
            var filter=$('.filterJob').val();
            $.ajax({
                url: "<?php echo e(route('ajaxFindJobList')); ?>",
                method: 'post',
                data: 'search=' + search + '&searchLoc=' + searchLoc + '&page=' + page +  '&sort=' + sort + '&filter=' + filter +  '&_token=<?php echo e(csrf_token()); ?>',
                success: function(response) {
                    $('.loader-bg').addClass('d-none');
                    if (append) {
                         if (response.statusCode == '300')  {
                            $('.clickLoadMore').hide();
                        }else{
                            $('.ajaxJobList').append(response);
                        }
                    }else {
                      if (response.statusCode == '300') {
                        $('.not-found').removeClass('d-none');
                        $('.clickLoadMore').hide();
                      } else {
                        $('.not-found').addClass('d-none');
                      }
                      $('.ajaxJobList').html(response);
                    }
                    $('input[name="page_no"]').val(page);
                }
            })
        }
        $(document).on('click', '.clickLoadMore', function() {
            var pageNo = $('input[name="page_no"]').val();
            // pageNo+=1;
            pageNo=parseInt(pageNo)+1;
            sortSearchFilterAjax(pageNo,1)
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/jobs/find-job.blade.php ENDPATH**/ ?>