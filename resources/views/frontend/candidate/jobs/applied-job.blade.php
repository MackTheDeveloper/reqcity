@section('title', 'Recruiter Jobs')
@extends('frontend.layouts.master')
@section('content')
<div class="candidate-applied">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
              <img src="{{ asset('public/assets/frontend/img/Sucess-badge.svg') }}" alt="payment success" />
              <h6>Congratulations!</h6>
              <hr class="hr"/>
              <p class="bl blur-color">You have successfully applied to <span>{{$jobTitle}}</span>.<br> You will hear from us real soon.</p>
              <div class="success-btn-block">
                <a href="{{route('showCandidateDashboard')}}" class="border-btn">Go to Dashboard</a>
                <a href="{{route('searchFront')}}" class="fill-btn">Search New Job</a>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
