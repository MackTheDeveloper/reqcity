@section('title','Find Jobs')
@extends('frontend.layouts.master')
@section('content')
<div class="candidate-fint-job">
  <div class="find-career-header">
    <div class="container">
      <h5>Find a career you'll love</h5>
      <p class="bm">Explore which careers have the highest job satisfaction, best salaries, and more</p>
      <div class="find-box-wrapper">
        <div class="input-searchbar">
          <span>What</span>
          <div class="searchbar">
            <input type="text" placeholder="Job title" class="input search_txt" id="search_txt" name="search_txt" value="{{$searchTitle ? $searchTitle : ''}}"/>
            <button><img src="{{ asset('public/assets/frontend/img/search.svg') }}" alt="" /></button>
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
              @if(!empty($parentCategories) && count($parentCategories)>0)
              @foreach($parentCategories as $cat)
                <option <?php if(!empty($searchCat) && $searchCat==$cat['id']) echo 'selected'; ?> value="{{$cat['id']}}">{{$cat['name']}}</option>
              @endforeach
              @endif
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
      @if(!empty($jobListData))
      <div class="ajaxJobList">
       @include('frontend.candidate.jobs.components.job-list')
      </div>
      @endif
      <div class="job-posts-row not-found {{!empty($jobListData) ? 'd-none' : ''}}">
        <div class="job-post-data">{{config('message.frontendMessages.recordNotFound')}}</div>
      </div>
      <div class="joblist-loadmore text-center {{empty($jobListData) ? 'd-none' : ''}}">
           <input type="hidden" name="page_no" id="page_no" value="1">
           <button class="border-btn clickLoadMore  mb-5">Load More</button>
       </div>
    </div>
  </div>
</div>
@endsection

@section('footscript')
    <script type="text/javascript">
    $(document).on("click", ".makeFavourite", function(e) {
        var jobId = $(this).attr('data-job-id');
        $.ajax({
            url: "{{ url('/candidate-jobs/make-favorite') }}",
            type: "POST",
            data: {
                jobId: jobId,
                _token: '{{csrf_token()}}'
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
                url: "{{ route('ajaxFindJobList') }}",
                method: 'post',
                data: 'search=' + search + '&searchLoc=' + searchLoc + '&page=' + page +  '&sort=' + sort + '&filter=' + filter +  '&_token={{ csrf_token() }}',
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
@endsection
