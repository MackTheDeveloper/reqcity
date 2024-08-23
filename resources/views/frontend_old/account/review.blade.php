<?php 
use App\Models\UserProfilePhoto

?>
@section('title','My Reviews')
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
                <div class="myreviews-content">
                    <h2 class="myaccount-entitle" data-aos="fade-up">My Reviews</h2>
                    @foreach($content->myReviewsData as $key=>$row)
                    <div class="myreviews-item" data-aos="fade-up">
                        <div class='rating-stars'>
                            <div class="show-star">
                                @for($i=0;$i<5;$i++)
                                    @if($i<$row->rating)
                                        <div class="fill-star"></div>
                                    @else
                                        <div class="blank-star"></div>
                                    @endif
                                @endfor
                            </div>

                            <span>{{$row->reviewDate}}</span>
                        </div>
                        <div class="review-description">
                            <span>{{$row->reviewDetail}}</span>
                        </div>
                        @foreach($row->productReviewImages as $keyImg=>$rowImg)
                        <img src="{{$rowImg->mediaData}}" class="img-reviews">
                        @endforeach
                        <div class="review-status">
                            <div class="reviewstatus-btn">
                                <span class="dot dot-pending {{($row->reviewStatus==1)?'dot-approve':(($row->reviewStatus==2)?'dot-reject':'dot-pending')}}"></span>
                                <span>{{($row->reviewStatus==1)?'Approved':(($row->reviewStatus==2)?'Rejected':'Pending')}}</span>
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