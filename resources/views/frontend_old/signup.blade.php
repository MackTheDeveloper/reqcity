@section('title','Create Account')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->

<section class="mw-352">
    <div class="registration">

        <h2 data-aos="fade-right">Create Account</h2>
        <form method="POST" id="signupForm" action="{{url('/signup')}}">
            @csrf
            <input type="text" class="input" placeholder="First Name*" name="firstname" id="firstname" value="{{ old('firstname') }}" data-aos="fade-up">
            @if($errors->has('firstname'))
                <div class="error">{{ $errors->first('firstname') }}</div>
            @endif
            <input type="text" class="input" placeholder="Last Name*" name="lastname" id="lastname" value="{{ old('lastname') }}" data-aos="fade-up">
            @if($errors->has('lastname'))
                <div class="error">{{ $errors->first('lastname') }}</div>
            @endif
            <input type="email" class="input" placeholder="Email Address*" name="email" id="email" value="{{ old('email') }}" data-aos="fade-up">
            @if($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
            <input type="number" class="input" placeholder="Mobile Number*" name="phone" id="phone" value="{{ old('phone') }}" data-aos="fade-up">
            @if($errors->has('phone'))
                <div class="error">{{ $errors->first('phone') }}</div>
            @endif
            <input type="password" class="input" placeholder="Password*" name="password" id="password" data-aos="fade-up">
            @if($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
            <input type="password" class="input" placeholder="Repeat Password*" name="conform-password" id="conform-password" data-aos="fade-up">
            @if($errors->has('conform-password'))
                <div class="error">{{ $errors->first('conform-password') }}</div>
            @endif
            <div class="mt-3">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
            
                @if ($errors->has('g-recaptcha-response'))
                    <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
                @endif
            </div>

            
            <span data-aos="fade-up">By creating an account, you agree to our <a href="{{  route('cms',['slug'=>'privacy-policy'])  }}"> Privacy Policy</a> and <a href="{{  route('cms',['slug'=>'terms-conditions'])  }}"> Terms & Conditions.</a></span>
            

            <button type="submit" class="fill-btn" data-aos="fade-up">CREATE ACCOUNT</button>
        </form>

        <div class="text-center" data-aos="fade-up">
            <span>Already have an account? <a href="{{url('login')}}">Sign in</a></span>
        </div>

        <div class="or" data-aos="fade-up">OR</div>

        <div class="text-center" data-aos="fade-up">
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
    $("#signupForm").validate( {
        ignore: [],
        rules: {
            firstname: "required",
            lastname: "required",            
            email: "required",            
            phone: {
                required:true,
                minlength:10,
                maxlength:10
            },
            password: {
                required:true,
                minlength:8,
            },
            "conform-password": {
                required:true,
                minlength:8,
                equalTo : "#password"
            },
            "g-recaptcha-response":"required"
        },
        messages:{
            firstname: "First Name is required",
            lastname: "Last Name is required",            
            email: "Email is required",
            phone: {
                required:"Phone Number is required"
            },
            password: {
                required:"Password is required"
            },
            "conform-password": {
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