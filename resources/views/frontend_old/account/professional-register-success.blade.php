<?php 
use App\Models\UserProfilePhoto

?>
@section('title','Request Submitted Successfully!')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SECTION 1 START
--------------------------->

<section class="RAAP-Successfully text-center">
    <div class="container">
        <img src="{{asset('public/assets/frontend/img/Sucessbadge.svg')}}" data-aos="zoom-in">
        <h2 data-aos="fade-up">Request Submitted Successfully!</h2>
        {{-- <span>Registration ID: DRP4512589657</span> --}}
        <div class="small-divider" data-aos="fade-up"></div>
        <span data-aos="fade-up">Your request to "Register as a Professional" has been submitted successfully. You will receive an email regarding the confirmation from the Admin team shortly.</span>
        {{-- <span>Your order is currently being processed. You will receive an order confirmation email shortly.</span> --}}
        <button onclick="continueBrowsing()" class="fill-btn" data-aos="fade-up">Continue Browsing</button>
    </div>
</section>

<!--------------------------
        SECTION 1 END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
    function continueBrowsing() {
        window.location = '{{ url('/') }}';
    }
</script>
@endsection