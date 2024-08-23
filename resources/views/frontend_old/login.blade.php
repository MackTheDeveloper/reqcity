@section('title','Sign In')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->
<style type="text/css">
    .input-group .prefix{
        position: absolute;
        bottom: 10px;
        z-index:1;
        border-right: 1px solid #CCCCCC;
        display: none;
        padding-right: 5px;
    }
    .hasNumber.input-group .prefix{
        display: block;
    }
    .hasNumber.input-group .input{
        padding-left: 40px;
    }

    .fill-btn-o{
        border: 1px solid #11B0B7;
        color: #11B0B7;
        background: #FFFFFF;
    }
    .fill-btn-o:hover{
        color: #0E959B;
        border: 1px solid #0E959B;
        background-color: #FFFFFF;
    }
</style>
<section class="mw-352">
    <div class="signin">

        <h2 data-aos="fade-right">Sign In</h2>
        <form id="loginForm" method="POST" action="{{url('/login')}}">
            @csrf
            <div class="input-group hasEmailPhone">
                <span class="prefix" data-aos="fade-up">+91</span>
                <input type="text" class="input" placeholder="Email/Phone*" name="email" id="email" data-aos="fade-up">
                @if($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <input type="password" class="input" placeholder="Password*" name="password" id="password" data-aos="fade-up">
            @if($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif

            <div class="text-right" data-aos="fade-up">
                <a href="{{ route('showForgotPassForm') }}" class="cap">Forgot Password?</a>
            </div>

            <button type="submit" class="fill-btn" data-aos="fade-up">SIGN IN</button>
        </form>
        <div data-aos="fade-up" class="or">OR</div>
        <form id="otploginForm" method="POST" action="{{url('/otp-login')}}">
            @csrf
            <input type="hidden" name="input" class="username_input">
            <button type="submit" class="fill-btn fill-btn-o" data-aos="fade-up">REQUEST OTP</button>
        </form>
        <span data-aos="fade-up">New here? <a href="{{ route('signup') }}">Create an Account</a></span>

        <div data-aos="fade-up" class="text-center mt-4">
            <div class="d-flex">
                <a href="{{ url('oauth/facebook') }}" class="facebook-btn"><img src="{{asset('public/assets/frontend/img/F.svg')}}"> Facebook</a>
                <a href="{{ url('oauth/google') }}" class="google-btn"><img src="{{asset('public/assets/frontend/img/G.svg')}}"> Google</a>
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
    $("#loginForm").validate( {
        ignore: [],
        rules: {
            email: "required",
            password: "required",
        },
        messages:{
            email: "Email/Phone is required",
            password:"Password is required"
        },
        errorPlacement: function ( error, element ) {
            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
    });

    $("#otploginForm").validate( {
        ignore: [],
        rules: {
            input: "required",
        },
        messages:{
            input: "Email/Phone is required",
        },
        errorPlacement: function ( error, element ) {
            if(!$('#input-error').length && !$('#email-error').length){
                error.insertAfter( $('input[name="email"]') );
                $('input[name="email"]').focus()
            }else{
                $('#input-error').show();
                $('input[name="email"]').focus()
            }
            // if ( element.prop( "type" ) === "checkbox" ) {
            //     error.insertAfter( element.next( "label" ) );
            // } else {
            //     error.insertAfter( element );
            // }
        },
    });
    $(document).on('change keyup keydown','input[name="email"]',function(){
        $('input[name="input"]').val($(this).val())
        var valueInt = $.isNumeric($(this).val());
        if(valueInt){
            if(!$('.hasEmailPhone').hasClass('hasNumber')){
                $('.hasEmailPhone').addClass('hasNumber');
            }
        }else{
            $('.hasEmailPhone').removeClass('hasNumber');
        }
    })
</script>
@endsection