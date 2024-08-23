<?php 
use App\Models\UserProfilePhoto

?>
@section('title','My Enquiries')
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
                <div class="myenq-content">
                    <h2 class="myaccount-entitle" data-aos="fade-up">My Enquiries</h2>
                    @foreach($content as $key=>$row)
                    <div class="myenq-inner" data-aos="fade-up">
                        <p class="cap">{{$row->enquirieCode}}</p>
                        <p class="s2">{{$row->productName}}</p>
                        <span>{{$row->message}}</span>
                        <div class="review-status">
                            <div class="reviewstatus-btn">
                                <span class="dot dot-pending {{($row->status==1)?'dot-approve':(($row->status==2)?'dot-pending':'dot-rejected')}}"></span>
                                <span>{{($row->status==1)?'Closed':(($row->status==2)?'In Progress':'Pending')}}</span>
                            </div>
                        </div> 
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!--------------------------
        SECTION 1 END
--------------------------->
@endsection