<?php 
use App\Models\UserProfilePhoto;
use App\Models\DesignPreferences;


$desingPreferences = DesignPreferences::getListById(Auth::user()->design_preferences);
//dd($desingPreferences);
?>
@section('title','My Profile')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->

<section class="my-profile">
    <div class="container">
        <div class="row">
            @include('frontend.include.account-sidebar')
            <div class="col-sm-12 col-md-7 col-lg-8">
                <div class="myprofile-content">
                    <a href="" class="back-arrow" data-aos="fade-up"></a>
                    <h2 class="myaccount-entitle" data-aos="fade-up">My Profile</h2>
                    <div class="profile-images" data-aos="fade-up">
                        <img src="{{UserProfilePhoto::getProfilePhoto(Auth::user()->id)}}">
                    </div>

                    <form class="edit-profile-inputs">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">First Name</p>
                                <span>{{Auth::user()->firstname}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Last Name</p>
                                <span>{{Auth::user()->lastname}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Email Address</p>
                                <span>{{Auth::user()->email}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Mobile Number</p>
                                <span>{{Auth::user()->phone}}</span>
                            </div>
                            
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Handle</p>
                                <span>{{Auth::user()->handle?:'-'}}</span>
                            </div>
                            
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Design Preferences</p>
                                <span>{{($desingPreferences)?:'-'}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Area</p>
                                <span>{{Auth::user()->area?:'-'}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">City</p>
                                <span>{{Auth::user()->city?:'-'}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Current Home</p>
                                <span>{{Auth::user()->current_home?:'-'}}</span>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6 user-detail-item" data-aos="fade-up">
                                <p class="cap">Future Stay</p>
                                <span>{{Auth::user()->future_stay?:'-'}}</span>
                            </div>
                            
                        </div>
                        <!-- <button class="fill-btn">SAVE</button> -->
                        <a href="{{ route('editMyProfile') }}" data-aos="fade-up" class="border-btn">EDIT PROFILE</a>
                    </form>



                    <!-- <a href="edit-profile.html" class="border-btn edit-profile">EDIT PROFILE</a> -->
                    <div class="changepassword-tagline" data-aos="fade-up">
                        <a href="{{ route('viewChangePassword') }}"><p>Change Password</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------------------------
        SIGN IN END
--------------------------->
@endsection