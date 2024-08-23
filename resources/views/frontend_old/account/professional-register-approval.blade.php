<?php 
use App\Models\UserProfilePhoto

?>
@section('title','Request Submitted Successfully!')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SECTION 1 START
--------------------------->

<section class="my-profile">
    <div class="container">
        <div class="row">
            @include('frontend.include.account-sidebar')
            <div class="col-sm-12 col-md-7 col-lg-8">
                <div class="myprofile-content">
                    <!-- <a href="" class="back-arrow"></a> -->
                    <h2 class="myaccount-entitle" data-aos="fade-up">Register as a Professional</h2>
                    <div class="registerProf-id">
                        {{-- <p class="s2">Registration ID: DRP4512589657</p> --}}
                        <span data-aos="fade-up">Your Profile is under review, if it takes more then 72hrs than you can contact on <a href="mailto:support@decorato.in">support@decorato.in</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------------------------
        SECTION 1 END
--------------------------->
@endsection