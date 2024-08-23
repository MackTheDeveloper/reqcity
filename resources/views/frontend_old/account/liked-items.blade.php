<?php 
$data = $content->productListComponentData->list;
//print_r($data);die;
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
                <div class="my-enquiries">
                    <h2 data-aos="fade-up" class="myaccount-entitle">
                        Liked Items
                        <div class="form-inline float-right" style="font-family: 'PR';">
                            <div class="form-group mb-2 mr-2">
                                <input type="text" class="form-control" id="searchLikedText" placeholdder="search" value="{{ request('search') }}">
                            </div>
                            <button type="button" id="searchBtn" class="btn btn-primary mb-2">Search</button>
                        </div>
                    </h2>
                    <div class="liked-item">
                        <div class="row" id="childItemsContent">
                            @include('frontend.account.liked-items-child',['data'=>$data])
                        </div>
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
@section('footscript')

<script>
    $(document).on("click","#searchBtn",function(){
        $.blockUI();
        var search = $("#searchLikedText").val();
        $.ajax({
            url:'{{ route("likedItems") }}',
            data:"search="+search+"&viewType=ajax",
            success:function(e){
                $("#childItemsContent").html(e);
            }
        }).always(function() {
            $.unblockUI();
        });
    })
</script>
@endsection