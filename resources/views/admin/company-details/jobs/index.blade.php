@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Company Jobs</title>

@section('content')
@include('admin.include.header')
<div class="app-main">
    @include('admin.include.sidebar')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a>
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{route('companies')}}" style="color: grey">Company Portal</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{route('companyViewDetails',$company->id)}}" style="color: grey">{{$company->name}}</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">Jobs</a>
                                        </li>

                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="company-jobs-wrapper new-to-old">
                @include('admin.company-details.jobs.components.job-tabs')

                <div class="company-jobs">

                    <div class="job-data-wrapper">
                        <div class="job-header">
                            <div class="searchbar-btn">
                                <input type="text" class="input search_text" name="search_text" id="search_text" placeholder="Search for job" />
                                <button class="search-btn searchJob"><img src="{{ asset('public/assets/frontend/img/white-search.svg') }}" alt="" /></button>
                            </div>
                            <button class="border-btn filter-btn web-filter">
                                <img src="{{ asset('public/assets/frontend/img/bell.svg') }}" alt="" />Filter
                            </button>

                            <div class="sort-by-sec">
                                <p class="bm">Sort by</p>
                                <select class="form-control select job-sort" id="job_sort" name="job_sort">
                                    <option value="latest">Recently Posted</option>
                                    <option value="old">Old Jobs</option>
                                    <option value="title_asc">A-Z</option>
                                    <option value="title_desc">Z-A</option>
                                    <option value="balance_desc">Balance High-Low</option>
                                    <option value="balance_asc">Balance Low-High</option>
                                </select>
                            </div>
                        </div>
                        @include('admin.company-details.jobs.components.job-filters')
                        
                        <div class="ajaxJobList">
                            @include('admin.company-details.jobs.components.job-list')
                        </div>
                        
                        <div class="job-posts not-found {{!empty($jobListData) ? 'd-none' : ''}}">
                            <div class="job-post-data">{{config('message.frontendMessages.recordNotFound')}}</div>
                        </div>
                        <div class="joblist-loadmore text-center {{empty($jobListData) ? 'd-none' : ''}}">
                            <input type="hidden" name="page_no" id="page_no" value="1">
                            <button class="border-btn clickLoadMore  mb-5">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.include.footer')
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var $this = $('.ck-collapse');

        // If more than 2 Education items, hide the remaining
        $('.ck-collapse').each(function() {
            $(this).find('.ck').slice(0, 5).addClass('shown')
            $(this).find('.ck').not('.shown').hide();
            if ($(this).find('.ck').length > 5) {
                $(this).append('<div><a href="javascript:;" class="show-more"></a></div>');
            }
        });
        // $('.ck-collapse .ck').slice(0,4).addClass('shown');
        // $('.ck-collapse .ck').not('.shown').hide();
        $('.ck-collapse .show-more').on('click', function() {
            $(this).closest('.ck-collapse').find('.ck').not('.shown').toggle(300);
            $(this).toggleClass('show-less');
        });

        $(document).on('click', '.filter-section .filter-column .tm', function() {
            $(this).closest('.filter-column').find('.ck-collapse-wrapper').toggleClass("show", 300);
            $(this).toggleClass('arrow-toggle')
        })

        $(".web-filter").on("click", function() {
            $(".filter-section-wrapper").toggleClass("active", 300);
        });
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
    $(document).on('click', '.filterJob', function() {
        $('.loader-bg').removeClass('d-none');
        $('.web-filter').trigger('click');
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

    var parentCat = [];
    var childCat = [];
    var statusArr = [];
    var joblocation = [];
    var empType = [];
    var conType = [];

    $('.checkallparentCat').on('change', function() {
        if ($(this).is(':checked')) {
            $('.parent_cat').prop('checked', false);
            $('.parent_cat').attr('disabled', 'disabled');
            parentCat = [];
        } else {
            $('.parent_cat').attr('disabled', false);
        }
    });

    $('.checkallchildCat').on('change', function() {
        if ($(this).is(':checked')) {
            $('.child_cat').prop('checked', false);
            $('.child_cat').attr('disabled', 'disabled');
            childCat = [];
        } else {
            $('.child_cat').attr('disabled', false);
        }
    });

    $('.checkallStatus').on('change', function() {
        if ($(this).is(':checked')) {
            $('.jobstatus').prop('checked', false);
            $('.jobstatus').attr('disabled', 'disabled');
            statusArr = [];
        } else {
            $('.jobstatus').attr('disabled', false);
        }
    });

    $('.checkallJobLocation').on('change', function() {
        if ($(this).is(':checked')) {
            $('.joblocation').prop('checked', false);
            $('.joblocation').attr('disabled', 'disabled');
            joblocation = [];
        } else {
            $('.joblocation').attr('disabled', false);
        }
    });

    $('.checkallEmpType').on('change', function() {
        if ($(this).is(':checked')) {
            $('.emp_type').prop('checked', false);
            $('.emp_type').attr('disabled', 'disabled');
            empType = [];
        } else {
            $('.emp_type').attr('disabled', false);
        }
    });

    $('.checkallConType').on('change', function() {
        if ($(this).is(':checked')) {
            $('.con_type').prop('checked', false);
            $('.con_type').attr('disabled', 'disabled');
            conType = [];
        } else {
            $('.con_type').attr('disabled', false);
        }
    });

    $(document).on('click', '.clearFilterJob', function() {
        $('.loader-bg').removeClass('d-none');
        $('.web-filter').trigger('click');
        document.querySelectorAll('input[type="checkbox"]')
            .forEach(el => el.checked = false);
        parentCat = [];
        childCat = [];
        statusArr = [];
        joblocation = [];
        empType = [];
        conType = [];
        $('.parent_cat').attr('disabled', false);
        $('.child_cat').attr('disabled', false);
        $('.jobstatus').attr('disabled', false);
        $('.joblocation').attr('disabled', false);
        $('.emp_type').attr('disabled', false);
        $('.con_type').attr('disabled', false);
        sortSearchFilterAjax();
    })

    $('.parent_cat').on('change', function() {
        parentCat = [];
        var val = '';
        $("input:checkbox[class=parent_cat]:checked").each(function() {
            var val = this.value;
            parentCat.push(val);
        });
    });

    $('.child_cat').on('change', function() {
        childCat = [];
        var val = '';
        $("input:checkbox[class=child_cat]:checked").each(function() {
            var val = this.value;
            childCat.push(val);
        });
    });

    $('.jobstatus').on('change', function() {
        statusArr = [];
        var val = '';
        $("input:checkbox[class=jobstatus]:checked").each(function() {
            var val = this.value;
            statusArr.push(val);
        });
    });

    $('.joblocation').on('change', function() {
        joblocation = [];
        var val = '';
        $("input:checkbox[class=joblocation]:checked").each(function() {
            var val = this.value;
            joblocation.push(val);
        });
    });

    $('.emp_type').on('change', function() {
        empType = [];
        var val = '';
        $("input:checkbox[class=emp_type]:checked").each(function() {
            var val = this.value;
            empType.push(val);
        });
    });

    $('.con_type').on('change', function() {
        conType = [];
        var val = '';
        $("input:checkbox[class=con_type]:checked").each(function() {
            var val = this.value;
            conType.push(val);
        });
    });

    function sortSearchFilterAjax(page = "1", append = 0) {
        var search = $('.search_text').val();
        var sort = $('.job-sort').val();
        var status = '{{$status ? $status : 0}}';
        var companyId = '{{$companyId}}';
        $.ajax({
            url: "{{ route('ajaxJobListByStatus') }}",
            method: 'post',
            data: 'search=' + search + '&page=' + page + '&status=' + status + '&companyId=' + companyId + '&sort=' + sort + '&filter[parentCat]=' + parentCat + '&filter[childCat]=' + childCat + '&filter[statusArr]=' + statusArr + '&filter[joblocation]=' + joblocation + '&filter[empType]=' + empType + '&filter[conType]=' + conType + '&_token={{ csrf_token() }}',
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
        $('.loader-bg').removeClass('d-none');
        var pageNo = $('input[name="page_no"]').val();
        // pageNo+=1;
        pageNo = parseInt(pageNo) + 1;
        sortSearchFilterAjax(pageNo, 1);
    })
</script>
@endpush