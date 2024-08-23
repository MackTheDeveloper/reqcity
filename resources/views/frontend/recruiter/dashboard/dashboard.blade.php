@section('title','Recruiter Dashboard')
@extends('frontend.layouts.master')
@section('content')
<div class="container">
  <div class="dashboard-compnay dash-reqruiter">
      <div class="dash-heads">
          <div class="dash-headrow">
              <div class="dash-titlelogo">
                  <!-- <div class="dash-compnaylogo">
                      <img src="assets/img/dashlogo.png" />
                  </div>
                  <div class="dash-compnaytitle">
                      <h5>Nutrify, Inc.</h5>
                  </div> -->
              </div>
              <div class="dash-postjob">
                  <a href="{{url('/recruiter-jobs/all')}}" class="fill-btn w-auto">Submit Candidate</a>
              </div>
          </div>
      </div>
      <div class="dashboards-main">
          <div class="row">
              <div class="col-md-12 col-lg-8 col-xl-9">

                  <div class="recruiter-candidate-dashbox">
                      <div class="reqstudent-dash-head">
                          <h5>{{$recruiterData['recruiterName']}}</h5>
                          <span>{{$recruiterData['recruiterCode']}}</span>
                      </div>
                      <span>{{$recruiterData['recruiterPhone']}}</span>
                      <span>{{$recruiterData['recruiterEmail']}}</span>
                      <span>{{$recruiterData['recruiterAddress']}}</span>
                  </div>

                  @include('frontend.recruiter.dashboard.components.recruiter-performance')

                  <div class="active-jobs-dash">
                      <div class="active-job-head">
                          <h6>Favorites</h6>
                          <a href="{{url('/recruiter-jobs/favorites')}}">View All</a>
                      </div>
                      <span class="full-hr"></span>
                      @include('frontend.recruiter.dashboard.components.favorite-jobs')

                  </div>
                  <div class="active-jobs-dash">
                      <div class="active-job-head">
                          <h6>Similar Jobs</h6>
                          <a href="{{url('/recruiter-jobs/similar')}}">View All</a>
                      </div>
                      <span class="full-hr"></span>
                      @include('frontend.recruiter.dashboard.components.similar-jobs')

                  </div>
              </div>
              <div class="col-md-12 col-lg-4 col-xl-3">
                  <div class="dashboard-sidebar">
                    @include('frontend.recruiter.dashboard.components.getting-started')
                    @include('frontend.recruiter.dashboard.components.updates')
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
