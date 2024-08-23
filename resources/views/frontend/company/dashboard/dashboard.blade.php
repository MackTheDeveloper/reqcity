@section('title','Company Dashboard')
@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <div class="dashboard-compnay">
        <div class="dash-heads">
            <div class="dash-headrow">
                <div class="dash-titlelogo">
                    <div class="dash-compnaylogo">
                        <img src="{{$companyData['logo']}}" />
                    </div>
                    <div class="dash-compnaytitle">
                        <h5>{{$companyData['companyName']}}</h5>
                    </div>
                </div>
                <div class="dash-postjob">
                    @if(whoCanCheckFront('company_job_post'))
                        <a href="{{route('jobDetailsShow')}}" class="fill-btn">Post a Job</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="dashboards-main">
            <div class="row">
                <div class="col-md-12 col-lg-8 col-xl-9">
                @if(whoCanCheckFront('company_job_view'))
                      @include('frontend.company.dashboard.components.active-jobs')
                      @include('frontend.company.dashboard.components.active-jobs-box')
                @endif
                    <div class="copm-performance-dash">
                        <div class="copm-perform-head">
                            <h6>Company Performance</h6>
                            <!-- <a href="">View All</a> -->
                        </div>
                        <span class="full-hr"></span>
                        @include('frontend.company.dashboard.components.company-performance')
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-3">
                    <div class="dashboard-sidebar">
                      @include('frontend.company.dashboard.components.getting-started')
                      @include('frontend.company.dashboard.components.updates')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
