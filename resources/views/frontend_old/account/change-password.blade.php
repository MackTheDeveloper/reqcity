<?php 
use App\Models\UserProfilePhoto

?>
@section('title','Change Password')
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
                <div class="change-passwords">
                    <a href="" class="back-arrow" data-aos="fade-up"></a>
                    <h2 class="myaccount-entitle" data-aos="fade-up">Change Password</h2>
                    <div class="change-passinner">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" id="changePasswordForm" action="{{url('account/change-password')}}">
                                    @csrf
                                    <div class="form-group" data-aos="fade-up">
                                        <input type="password" class="input" placeholder="Enter password" id="old_password" autocomplete="off" name="old_password">
                                        @if($errors->has('old_password'))
                                            <div class="error" style="color: red;">{{ $errors->first('old_password') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group" data-aos="fade-up">
                                        <input type="password" class="input" autocomplete="off" placeholder="New Password*" id="password" name="password">
                                        @if($errors->has('password'))
                                            <div class="error" style="color: red;">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group" data-aos="fade-up">
                                        <input type="password" class="input" autocomplete="off" placeholder="Repeat New Password*" id="password_confirmation" name="password_confirmation">
                                        @if($errors->has('password_confirmation'))
                                            <div class="error" style="color: red;">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                    <button type="submit" class="fill-btn" data-aos="fade-up">Submit</button>
                                </form>
                            </div>
                        </div>
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
@section('footscript')
<script type="text/javascript">
    $("#changePasswordForm").validate( {
        ignore: [],
        rules: {
            old_password:'required',
            password: {
                required:true,
                minlength:8,
            },
            password_confirmation: {
                required:true,
                minlength:8,
                equalTo : "#password"
            }
        },
        messages:{
            old_password:"Old Password is required",
            password: {
                required:"Password is required"
            },
            password_confirmation: {
                required:"Confirm Password is required",
                equalTo:"Please enter same as Password"
            }
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