@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Recruiter Portal</title>

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
                                            <a href="{{route('recruiters')}}" style="color: grey">Recruiter Portal</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{route('recruiterViewDetails',$recruiters['recruiterId'])}}" style="color: grey">{{$recruiters['recruiterName']}}</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">Jobs with Submittals</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="company-jobs-wrapper new-to-old ">
                <div class="company-jobs mt-0">
                    <div class="job-data-wrapper">
                        <div class="job-header">
                            <div class="searchbar-btn">
                                <input type="text" class="input search_text" id="search_text" name="search_text" placeholder="Search for job" />
                                <button class="search-btn searchJob"><img src="{{ asset('public/assets/frontend/img/white-search.svg') }}" alt="" /></button>
                            </div>
                            <button class="border-btn filter-btn web-filter">
                                <img src="{{ asset('public/assets/frontend/img/bell.svg') }}" alt="" />Filter
                            </button>

                            <div class="sort-by-sec">
                                <p class="bm">Sort by</p>
                                <select class="select form-control job-sort" id="job_sort" name="job_sort">
                                    <option value="latest">Recently Posted</option>
                                    <option value="old">Old Jobs</option>
                                    <option value="title_asc">A-Z</option>
                                    <option value="title_desc">Z-A</option>
                                </select>
                            </div>
                        </div>

                        @include('admin.recruiter-details.job.components.job-filters')

                        @if(!empty($jobListData))
                        <div class="ajaxJobList">
                            @include('admin.recruiter-details.job.components.job-list')
                        </div>
                        @endif

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
<script>
    let token = '{{ csrf_token() }}';
    let status = '{{ $status }}';
    let recruiterId = "{{ $recruiters['recruiterId'] }}";

</script>
<script src="{{asset('public/assets/js/recruiter/jobs.js')}}"></script>
@endpush