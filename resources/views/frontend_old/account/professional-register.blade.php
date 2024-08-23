<?php 
use App\Models\UserProfilePhoto

?>
@section('title','Register as a Professional')
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
<section class="">
    <div class="RAP" style="padding-top:0px">
        <form method="post" id="registerProfessional" action="{{url('account/professional-register')}}">
            @csrf
            <h2 data-aos="fade-up">Register as a Professional</h2>

            <h3 data-aos="fade-up">Personal Details</h3>

            <input type="text" class="input" placeholder="First Name*" name="firstname" id="firstname" value="{{Auth::user()->firstname}}" data-aos="fade-up">
            <input type="text" class="input" placeholder="Last Name*" name="lastname" id="lastname" value="{{Auth::user()->lastname}}" data-aos="fade-up">
            <input type="email" disabled="disabled" class="input" placeholder="Email Address*" name="email" id="email" value="{{Auth::user()->email}}" data-aos="fade-up">
            <input type="number" disabled="disabled" class="input" placeholder="Mobile Number*" name="phone" id="phone" value="{{Auth::user()->phone}}" data-aos="fade-up">
            <textarea class="textarea" placeholder="Address*" name="address" id="address" data-aos="fade-up"></textarea>
            

            <h3 class="mt40">Company Details</h3>

            <input type="text" class="input" placeholder="Company Name*" name="company_name" id="company_name" data-aos="fade-up">
            <input type="number" class="input" placeholder="Phone Number*" name="phone_number" id="phone_number" data-aos="fade-up">
            <div class="select-group" data-aos="fade-up">
                <label>Select Categories*</label>
                <select name="categories" id="categories">
                    <option>Select Category</option>
                    @foreach($categories as $key=>$val)
                        <option value="{{$val['id']}}">{{$val['title']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-group" data-aos="fade-up">
                <label>Select Professional Categories*</label>
                <select name="professional_categories" id="professional_categories">
                    <option>Select Professional Category</option>
                    @foreach($profCategories as $key=>$val)
                        <option value="{{$val['id']}}">{{$val['title']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row RAP-row">
                <div class="col-6">
                    <input type="text" class="input" placeholder="Skill 1" name="skills[]" data-aos="fade-up">
                </div>
                <div class="col-6">
                    <input type="text" class="input" placeholder="Skill 2" name="skills[]" data-aos="fade-up">
                </div>
                <div class="col-6">
                    <input type="text" class="input" placeholder="Skill 3" name="skills[]" data-aos="fade-up">
                </div>
                <div class="col-6">
                    <input type="text" class="input" placeholder="Skill 4" name="skills[]" data-aos="fade-up">
                </div>
            </div>

            <button type="submit" data-aos="fade-up" class="fill-btn">REGISTER</button>

        </form>

    </div>
</section>
</div>
        </div>
    </div>
</section>
<!--------------------------
        SECTION 1 END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
    $("#registerProfessional").validate( {
        ignore: [],
        rules: {
            firstname: "required",
            lastname: "required",
            email: "required",
            phone: "required",
            address: "required",
            company_name: "required",
            phone_number: "required",
            categories: "required",
            professional_categories: "required",
        },
        messages:{
            firstname: "Firstname is required",
            lastname: "Lastname is required",
            email: "Email is required",
            phone: "Phone Number is required",
            address: "Address is required",
            company_name: "Company Name is required",
            phone_number: "Phone Number is required",
            categories: "Please select Categories",
            professional_categories: "Please select Professional Categories",
        },
        errorPlacement: function ( error, element ) {
            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
    });
</script>
@endsection