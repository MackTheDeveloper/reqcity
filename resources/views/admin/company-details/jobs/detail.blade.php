@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Company Job Details</title>

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
                                            <a href="{{route('companyViewDetails',$companyId)}}" style="color: grey">{{$company->name}}</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a href="{{route('companyJobsByStatus',$companyId)}}" style="color: slategray">Jobs</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">{{$jobDetails->title}}</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="job-detail-wrapper new-to-old">
                <div class="company-job-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="job-detail-data">
                                <a href="{{route('companyJobsByStatus',$companyId)}}" class="back-to-link bm"><img src="{{asset('public/assets/frontend/img/arrow-left.svg')}}" alt="" />Back to all
                                    jobs</a>

                                <div class="job-posts">
                                    <div class="job-post-data">
                                        <p class="tm">{{$jobDetails->title}}</p>
                                        <p class="ll blur-color">{{$companyAddress->city}} {{ $companyAddress->state ? ','.$companyAddress->state :''}}</p>
                                        <p class="bm blur-color">{{$jobDetails->job_short_description}}</p>
                                        <div class="job-table">
                                            <div class="first-data">
                                                <label class="ll">{{$salary}}a {{$jobDetails->salary_type}}</label>
                                                <span class="bs blur-color">{{getFormatedDateForWeb($jobDetails->created_at)}}</span>
                                            </div>
                                            <div class="last-data">
                                                <div class="job-table-data">
                                                    <div class="jtd-wrapper">
                                                        <label class="ll">{{$companyJobOpenings}}</label>
                                                        <span class="bs blur-color">Openings</span>
                                                    </div>
                                                </div>
                                                <div class="job-table-data">
                                                    <div class="jtd-wrapper">
                                                        <label class="ll">{{$companyJobPending}}</label>
                                                        <span class="bs blur-color">Pending</span>
                                                    </div>
                                                </div>
                                                <div class="job-table-data">
                                                    <div class="jtd-wrapper">
                                                        <label class="ll">{{$companyJobApproved}}</label>
                                                        <span class="bs blur-color">Approved</span>
                                                    </div>
                                                </div>
                                                <div class="job-table-data">
                                                    <div class="jtd-wrapper">
                                                        <label class="ll">{{$companyJobRejected}}</label>
                                                        <span class="bs blur-color">Rejected</span>
                                                    </div>
                                                </div>
                                                <div class="job-table-data">
                                                    <div class="jtd-wrapper">
                                                        <label class="ll">{{$totalCost}}</label>
                                                        <span class="bs blur-color">Total Cost</span>
                                                    </div>
                                                </div>
                                                <div class="job-table-data">
                                                    <div class="jtd-wrapper">
                                                        <label class="ll">{{$balance}}</label>
                                                        <span class="bs blur-color">Balance</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="job-post-status">
                                        <div class="dropdown status_dropdown" data-color="{{ $statusColor ? $statusColor : '' }}">
                                            <button class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,12">
                                                {{$statusText}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @include('admin.company-details.jobs.components.job-performance')
                                <hr class="hr mtb-35">
                                @include('admin.company-details.jobs.components.candidate-data')
                                <hr class="hr candi-hr">
                                @include('admin.company-details.jobs.components.job-description')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        @include('admin.include.footer')
    </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
@endsection
@section('modals-content')
    @include('admin.company-details.jobs.components.job-description-modal')
    <!-- Modal for approve balance -->
@endsection

@push('scripts')
<script>
    let jobDetailId = '{{$jobDetails->id}}'; 
</script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/index.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/xy.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/themes/Animated.js') }}"></script>
<script src="{{ asset('public/assets/js/companies/job-details.js') }}"></script>
@endpush