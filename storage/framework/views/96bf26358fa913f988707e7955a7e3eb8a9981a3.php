<?php $__env->startSection('title', 'Company Jobs'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('frontend.company.jobs.components.job-tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="company-jobs">
        <div class="container">
            <div class="job-data-wrapper">
                <div class="job-header">
                    <div class="searchbar-btn">
                        <input type="text" class="input search_text" id="search_text" name="search_text"
                            placeholder="Search for job" />
                        <button class="search-btn searchJob"><img
                                src="<?php echo e(asset('public/assets/frontend/img/white-search.svg')); ?>" alt="" /></button>
                    </div>
                    <button class="border-btn filter-btn web-filter">
                        <img src="<?php echo e(asset('public/assets/frontend/img/bell.svg')); ?>" alt="" />Filter
                    </button>
                    <button class="border-btn filter-btn mobile-filter">
                        <img src="<?php echo e(asset('public/assets/frontend/img/bell.svg')); ?>" alt="" />Filter
                    </button>
                    <div class="sort-by-sec">
                        <p class="bm">Sort by</p>
                        <select class="select job-sort" id="job_sort" name="job_sort">
                            <option value="latest">Recently Posted</option>
                            <option value="old">Old Jobs</option>
                            <option value="title_asc">A-Z</option>
                            <option value="title_desc">Z-A</option>
                            <option value="balance_desc">Balance High-Low</option>
                            <option value="balance_asc">Balance Low-High</option>
                        </select>
                    </div>
                </div>
                <?php echo $__env->make('frontend.company.jobs.components.job-filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="ajaxJobList">
                    <?php echo $__env->make('frontend.company.jobs.components.job-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="job-posts not-found <?php echo e(!empty($jobListData) ? 'd-none' : ''); ?>">
                    <div class="job-post-data"><?php echo e(config('message.frontendMessages.recordNotFound')); ?></div>
                </div>

                <div class="joblist-loadmore text-center">
                    <input type="hidden" name="page_no" id="page_no" value="1">
                    <button class="border-btn clickLoadMore  mb-5">Load More</button>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('frontend.company.jobs.modals.close-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.company.jobs.modals.change-status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.company.jobs.modals.change-job-description', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            //$('.tab-link').not(this).removeClass('active');
            var status = document.getElementById('status').value;
            if (status == 1) {
                $('.tab-link').removeClass('active');
                $('#open').addClass('active');
            } else if (status == 2) {
                $('.tab-link').removeClass('active');
                $('#draft').addClass('active');
            } else if (status == 3) {
                $('.tab-link').removeClass('active');
                $('#paused').addClass('active');
            } else if (status == 4) {
                $('.tab-link').removeClass('active');
                $('#closed').addClass('active');
            } else {
                $('.tab-link').removeClass('active');
                $('#all').addClass('active');
            }


            // $(".ckeditor").each(function(_, ckeditor) {
            //     CKEDITOR.replace(ckeditor);
            // });
            CKEDITOR.replace('jobDescrEditorCked');
        });
        //$('.job-close').on('click', function (e) {
        $(document).on('click', '.job-close', function(e) {
            var jobId = $(this).data("id");
            $.ajax({
                url: "<?php echo e(url('/company-jobs-list')); ?>",
                type: 'get',
                dataType: "json",
                data: {
                    jobId: jobId,
                },
                success: function(result) {
                    console.log(result);
                    $('#toJobId').empty();
                    jobTitle = result.jobTitle;
                    balance = result.balance;
                    if (result.jobList.length <= 0) {
                        $('.input-groups').hide();
                        $('#closeReq').hide();
                        $("#show-error").removeClass("d-none");
                    }
                    $.each(result.jobList, function(index, value) {
                        $('#toJobId').append('<option value="' + value.jobId + '">' + value
                            .jobTitle + '</option>');
                    });
                    $('.fromJob').html(jobTitle);
                    $('.balanceVal').html('$' + balance);
                    $('#balance').val(balance);
                    $('#fromJobId').val(jobId);
                    // $('#closeJob').modal('show');
                },
                error: function(result) {
                    // $('.input-groups').hide();
                    // $('#closeReq').hide();
                    // $("#show-error").removeClass("d-none");
                    console.log('error in getting bank details');
                }

            });
            //e.stopImmediatePropagation();
            // var recruiterName = $("#recruiter option:selected").text();
            // $('#RecruiterPaymentHeaderLabel').text('Payout to ' + recruiterName);
        });

        // To Payment
        $("#balanceRequestFromPopup").validate({
            ignore: [],
            rules: {
                toJobId: {
                    required: true,
                },

            },

            submitHandler: function(form) {
                $('.loader-bg').removeClass('d-none');
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.statusCode == '200') {
                            $('.loader-bg').addClass('d-none');
                            toastr.clear();
                            toastr.options.closeButton = true;
                            toastr.error(response.message);
                            $("#closeJob .close").click();
                            document.getElementById('balanceRequestFromPopup').reset();
                            setTimeout(function() {
                                toastr.clear();
                                window.location.reload();
                            }, 3000);
                        } else {
                            $('.loader-bg').addClass('d-none');
                            toastr.clear();
                            toastr.options.closeButton = true;
                            toastr.error(response.component.error);
                        }
                    }
                });
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("mobile-number")) {
                    error.insertAfter(element.parent().append());
                } else {
                    error.insertAfter(element);
                }

            },
        });
        $('.job-change-status').on('click', function(e) {
            var id = $(this).data('id');
            var status = $(this).data('status');
            $("#ChageStatusModel #changeStatusConfirmed input#id").val(id);
            $("#ChageStatusModel #changeStatusConfirmed input#status").val(status);
            //$("#ChageStatusModel").modal('show');
        });
        //for read unread
        $(document).on("click", "#change-status-confirm", function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo e(url('/company-job-change-status')); ?>",
                type: "POST",
                data: $("#changeStatusConfirmed").serialize(),
                success: function(response) {
                    $("#ChageStatusModel").modal("hide");
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                },
            });
        });
        $(document).on('change', '.job-sort', function() {
            $('.loader-bg').removeClass('d-none');
            sortSearchFilterAjax();
        })
        $(document).on('click', '.searchJob', function() {
            $('.loader-bg').removeClass('d-none');
            sortSearchFilterAjax();
        })
        $(document).on('click', '.filterJob', function() {
            $('.loader-bg').removeClass('d-none');
            $('.web-filter').trigger('click');
            sortSearchFilterAjax();
            $('.clickLoadMore').show();
        })

        $(document).on('change keydown', '.search_text', function(e) {
            if (e.keyCode === 13) {
                sortSearchFilterAjax();
            }
        });



        $('input[type="checkbox"]').on('change', function() {
            if ($(this).hasClass('checkAllOption')) {
                if ($(this).prop('checked')) {
                    $(this).closest('.input-groups').find('input[type="checkbox"]:checked').not('.checkAllOption').prop(
                        "checked", false).trigger('change');
                }
            } else {
                if ($(this).prop('checked')) {
                    $(this).closest('.input-groups').find('input.checkAllOption').prop("checked", false).trigger('change');
                }
            }
        });
        
        $(document).on('click', '.clearFilterJob', function() {
            $('.loader-bg').removeClass('d-none');
            $('.web-filter').trigger('click');
            $('.input-groups.filterDropDown').each(function(){
              $(this).find('input[type="checkbox"]').not(':first').each(function(){
                if ($(this).prop('checked')) {
                  $(this).prop('checked', false).trigger('change');
                }
              });
              if ($(this).find('input[type="checkbox"]:first').prop('checked')==false) {
                $(this).find('input[type="checkbox"]:first').prop('checked',true).trigger('change');
              }
            });
            sortSearchFilterAjax();
        })
        
        function sortSearchFilterAjax(page = "1", append = 0) {
            var search = $('.search_text').val();
            var sort = $('.job-sort').val();
            var status = <?php echo e($status ? $status : 0); ?>;
            var companyId = <?php echo e($companyId); ?>;
            var parentCat = $('input[name="parent_cat[]"]:checked').map(function(_, el) {
                return ($(el).val()!='on')?$(el).val():'';
            }).get();
            var childCat = $('input[name="child_cat[]"]:checked').map(function(_, el) {
                return ($(el).val()!='on')?$(el).val():'';
            }).get();
            var statusArr = $('input[name="jobstatus[]"]:checked').map(function(_, el) {
                return ($(el).val()!='on')?$(el).val():'';
            }).get();
            var joblocation = $('input[name="joblocation[]"]:checked').map(function(_, el) {
                return ($(el).val()!='on')?$(el).val():'';
            }).get();
            var empType = $('input[name="emp_type[]"]:checked').map(function(_, el) {
                return ($(el).val()!='on')?$(el).val():'';
            }).get();
            var conType = $('input[name="con_type[]"]:checked').map(function(_, el) {
                return ($(el).val()!='on')?$(el).val():'';
            }).get();
            $.ajax({
                url: "<?php echo e(route('ajaxJobList')); ?>",
                method: 'post',
                data: 'search=' + search + '&page=' + page + '&status=' + status + '&companyId=' + companyId +
                    '&sort=' + sort + '&filter[parentCat]=' + parentCat + '&filter[childCat]=' + childCat +
                    '&filter[statusArr]=' + statusArr + '&filter[joblocation]=' + joblocation +
                    '&filter[empType]=' + empType + '&filter[conType]=' + conType + '&_token=<?php echo e(csrf_token()); ?>',
                success: function(response) {
                    $('.loader-bg').addClass('d-none');
                    if (append) {
                        if (response.statusCode == '300') {
                            $('.clickLoadMore').hide();
                        } else {
                            $('.ajaxJobList').append(response);
                        }
                    } else {
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
            pageNo = parseInt(pageNo) + 1;
            sortSearchFilterAjax(pageNo, 1)
        })

        $(document).on('click', '.edit-job-description', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo e(route('getJobDescription')); ?>",
                method: 'post',
                data: 'id=' + id + '&_token=<?php echo e(csrf_token()); ?>',
                success: function(response) {
                    // $('.job-description').html(response);
                    $("#ChangeDescModel").modal('show');
                    $("#ChangeDescModel #id").val(id);
                    $('#ChangeDescModel #jobDescrEditorCked').val(response);
                    // CKEDITOR.replace('#jobDescrEditorCked');
                    CKEDITOR.instances.jobDescrEditorCked.setData(response);
                    CKEDITOR.instances.jobDescrEditorCked.updateElement();
                }
            });
        })
        $(document).on('click', '#change-description-confirm', function(e) {
            e.preventDefault();
            var id = $('#ChangeDescModel #id').val();
            var description = CKEDITOR.instances.jobDescrEditorCked.getData();
            $.ajax({
                url: "<?php echo e(route('changeJobDescription')); ?>",
                method: 'post',
                dataType: 'json',
                data: 'id=' + id + '&description=' + description + '&_token=<?php echo e(csrf_token()); ?>',
                success: function(response) {
                    $("#ChangeDescModel").modal('hide');
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.message);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/index.blade.php ENDPATH**/ ?>