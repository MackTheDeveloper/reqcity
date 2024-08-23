@extends('admin.layouts.master')
<title>Candidate Submit 3</title>
@section('content')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/jquery.ccpicker.css') }}">
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="success-page new-to-old">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="{{ asset('public/assets/frontend/img/Sucess-badge.svg') }}"
                                    alt="payment success" />
                                <h6>Thank you for your submittal!</h6>
                                <hr class="hr">
                                <p class="bl blur-color">The candidate is submitted successfully and company will review
                                    soon.</p>
                                <div class="success-btn-block">
                                    <a href="{{route('assignedJobListing')}}" class=" btn btn-primary">Go to candidate request</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
@endsection
