@section('title', 'Recruiter Jobs')
@extends('frontend.layouts.master')
@section('content')
    <div class="recruiter-submit-candidate-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{asset('public/assets/frontend/img/Sucess-badge.svg')}}" alt="payment success" />
                    <h6>Thank you for your submittal!</h6>
                    <hr class="hr">
                    <p class="bl blur-color">The candidate is submitted successfully and company will review soon.</p>
                    <div class="success-btn-block">
                        <a href="{{route('showRecruiterDashboard')}}" class="border-btn">Go to Dashboard</a>
                        <a href="{{route('recruiterCandidateSubmitStart',$slug)}}" class="fill-btn">New Submittal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
