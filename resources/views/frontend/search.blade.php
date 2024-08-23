@section('title', 'Search Results')
@extends('frontend.layouts.master')
@section('content')
    @if (Auth::check())
        @php($authenticateClass = '')
    @else
        @php($authenticateClass = 'loginBeforeGo')
    @endif
    <!--------------------------
        HOME START
    --------------------------->
    <div class="company-jobs recruiter-jobs candidate-jobs search-result-page">
        <div class="container">
            <div class="job-data-wrapper">
                <div class="job-header">
                    <!-- <div class="searchbar">
              <input placeholder="Job title" class="input" />
              <button><img src="assets/img/search.svg" alt="" /></button>
            </div> -->
                    <div class="searchbar">
                        <input type="text" value="{{ $searchTitle ? $searchTitle : '' }}" class="input search_text"
                            id="search_text" name="search_text" placeholder="Job title" />
                        <button class="search-btn searchJob"><img
                                src="{{ asset('public/assets/frontend/img/search.svg') }}" alt="" /></button>
                    </div>
                    <button class="fill-btn searchJob">Search</button>
                    <button class="border-btn filter-btn web-filter">
                        <img src="{{ asset('public/assets/frontend/img/bell.svg') }}" alt="" />Filter
                    </button>
                    <button class="border-btn filter-btn mobile-filter">
                        <img src="{{ asset('public/assets/frontend/img/bell.svg') }}" alt="" />Filter
                    </button>
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
                @include('frontend.company.jobs.components.job-filters')
                @if (!empty($jobListData))
                    <div class="ajaxJobList">
                        @include('frontend.components.search-list')
                    </div>
                @endif
                <div class="job-posts not-found {{ !empty($jobListData) ? 'd-none' : '' }}">
                    <div class="job-post-data">{{ config('message.frontendMessages.recordNotFound') }}</div>
                </div>
                <div class="joblist-loadmore text-center {{ empty($jobListData) ? 'd-none' : '' }}">
                    <input type="hidden" name="page_no" id="page_no" value="1">
                    <button class="border-btn clickLoadMore  mb-5">Load More</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------
        HOME END
    --------------------------->
@endsection

@section('footscript')
    <script type="text/javascript">
        $(document).ready(function() {

        });

        $(document).on("click", ".makeFavourite", function(e) {
            var jobId = $(this).attr('data-job-id');
            $.ajax({
                url: "{{ url('/candidate-jobs/make-favorite') }}",
                type: "POST",
                data: {
                    jobId: jobId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.message);
                },
            });
        });

        $(document).on('submit', '.applyNowCandidate', function(e) {
            e.preventDefault();
            var jobId = $(this).attr('data-job-id');
            $("#applyJob #applyConfirmed input#jobId").val(jobId);
            $("#applyJob").modal('show');
        });

        $(document).on('change', '.job-sort', function() {
            $('.loader-bg').removeClass('d-none');
            sortSearchFilterAjax();
            $('.clickLoadMore').show();
        })

        $(document).on('click', '.searchJob', function() {
            $('.loader-bg').removeClass('d-none');
            sortSearchFilterAjax();
            $('.clickLoadMore').show();
        })

        $(document).on('change keydown', '.search_text', function(e) {
            if (e.keyCode === 13) {
                $('.loader-bg').removeClass('d-none');
                sortSearchFilterAjax();
                $('.clickLoadMore').show();
            }
        });

        $(document).on('click', '.filterJob', function() {
            $('.loader-bg').removeClass('d-none');
            $('.web-filter').trigger('click');
            sortSearchFilterAjax();
            $('.clickLoadMore').show();
        })

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
            $('.input-groups.filterDropDown').each(function() {
                $(this).find('input[type="checkbox"]').not(':first').each(function() {
                    if ($(this).prop('checked')) {
                        $(this).prop('checked', false).trigger('change');
                    }
                });
                if ($(this).find('input[type="checkbox"]:first').prop('checked') == false) {
                    $(this).find('input[type="checkbox"]:first').prop('checked', true).trigger('change');
                }
            });
            sortSearchFilterAjax();
        })

        // var parentCat = [{{ $catID }}];
        // var childCat = [];
        // var joblocation = [];
        // var empType = [];
        // var conType = [];

        // $('.checkallparentCat').on('change', function() {
        //   if ($(this).is(':checked')) {
        //     $('.parent_cat').prop('checked', false);
        //     $('.parent_cat').attr('disabled', 'disabled');
        //     parentCat = [];
        //   } else {
        //     $('.parent_cat').attr('disabled', false);
        //   }
        // });
        // $('.checkallchildCat').on('change', function() {
        //   if ($(this).is(':checked')) {
        //     $('.child_cat').prop('checked', false);
        //     $('.child_cat').attr('disabled', 'disabled');
        //     childCat = [];
        //   } else {
        //     $('.child_cat').attr('disabled', false);
        //   }
        // });
        // $('.checkallJobLocation').on('change', function() {
        //   if ($(this).is(':checked')) {
        //     $('.joblocation').prop('checked', false);
        //     $('.joblocation').attr('disabled', 'disabled');
        //     joblocation = [];
        //   } else {
        //     $('.joblocation').attr('disabled', false);
        //   }
        // });
        // $('.checkallEmpType').on('change', function() {
        //   if ($(this).is(':checked')) {
        //     $('.emp_type').prop('checked', false);
        //     $('.emp_type').attr('disabled', 'disabled');
        //     empType = [];
        //   } else {
        //     $('.emp_type').attr('disabled', false);
        //   }
        // });
        // $('.checkallConType').on('change', function() {
        //   if ($(this).is(':checked')) {
        //     $('.con_type').prop('checked', false);
        //     $('.con_type').attr('disabled', 'disabled');
        //     conType = [];
        //   } else {
        //     $('.con_type').attr('disabled', false);
        //   }
        // });

        // $(document).on('click', '.clearFilterJob', function() {
        //   $('.loader-bg').removeClass('d-none');
        //   $('.web-filter').trigger('click');
        //   document.querySelectorAll('input[type="checkbox"]')
        //     .forEach(el => el.checked = false);
        //   parentCat = [];
        //   childCat = [];
        //   joblocation = [];
        //   empType = [];
        //   conType = [];
        //   $('.parent_cat').attr('disabled', false);
        //   $('.child_cat').attr('disabled', false);
        //   $('.joblocation').attr('disabled', false);
        //   $('.emp_type').attr('disabled', false);
        //   $('.con_type').attr('disabled', false);
        //   sortSearchFilterAjax();
        // })


        // $('.parent_cat').on('change', function() {
        //   parentCat = [];
        //   var val = '';
        //   $("input:checkbox[class=parent_cat]:checked").each(function() {
        //     var val = this.value;
        //     parentCat.push(val);
        //   });
        // });

        // $('.child_cat').on('change', function() {
        //   childCat = [];
        //   var val = '';
        //   $("input:checkbox[class=child_cat]:checked").each(function() {
        //     var val = this.value;
        //     childCat.push(val);
        //   });
        // });

        // $('.joblocation').on('change', function() {
        //   joblocation = [];
        //   var val = '';
        //   $("input:checkbox[class=joblocation]:checked").each(function() {
        //     var val = this.value;
        //     joblocation.push(val);
        //   });
        // });

        // $('.emp_type').on('change', function() {
        //   empType = [];
        //   var val = '';
        //   $("input:checkbox[class=emp_type]:checked").each(function() {
        //     var val = this.value;
        //     empType.push(val);
        //   });
        // });

        // $('.con_type').on('change', function() {
        //   conType = [];
        //   var val = '';
        //   $("input:checkbox[class=con_type]:checked").each(function() {
        //     var val = this.value;
        //     conType.push(val);
        //   });
        // });

        function sortSearchFilterAjax(page = "1", append = 0) {
            var search = $('.search_text').val();
            var sort = $('.job-sort').val();
            var parentCat = $('input[name="parent_cat[]"]:checked').map(function(_, el) {
                return ($(el).val() != 'on') ? $(el).val() : '';
            }).get();
            var childCat = $('input[name="child_cat[]"]:checked').map(function(_, el) {
                return ($(el).val() != 'on') ? $(el).val() : '';
            }).get();
            var joblocation = $('input[name="joblocation[]"]:checked').map(function(_, el) {
                return ($(el).val() != 'on') ? $(el).val() : '';
            }).get();
            var empType = $('input[name="emp_type[]"]:checked').map(function(_, el) {
                return ($(el).val() != 'on') ? $(el).val() : '';
            }).get();
            var conType = $('input[name="con_type[]"]:checked').map(function(_, el) {
                return ($(el).val() != 'on') ? $(el).val() : '';
            }).get();
            $.ajax({
                url: "{{ route('ajaxsearchFront') }}",
                method: 'post',
                data: 'search=' + search + '&page=' + page + '&sort=' + sort + '&filter[parentCat]=' + parentCat +
                    '&filter[childCat]=' + childCat + '&filter[joblocation]=' + joblocation + '&filter[empType]=' +
                    empType + '&filter[conType]=' + conType + '&_token={{ csrf_token() }}',
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
            sortSearchFilterAjax(pageNo, 1);
            $('.loader-bg').removeClass('d-none');
        })
    </script>
@endsection
