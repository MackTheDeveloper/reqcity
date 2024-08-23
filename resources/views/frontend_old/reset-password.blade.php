@section('title','Reset Password')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->

<section class="mw-352">
    <div class="signin forgot-psw">

        <h2 data-aos="fade-right">Reset Password</h2>

        <span data-aos="fade-up">Enter new password below to set new password.</span>
        <form method="POST" id="forgotPassForm" action="{{ route('postResetPassword') }}">
            @csrf
            @if(!Auth::check())
                <input type="hidden" name="input" value="{{(isset($input)?$input:'')}}">
            @endif
            <input type="password" class="input" placeholder="Enter Password*" name="password" id="password" data-aos="fade-up">
            @if($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
            <input type="password" class="input" placeholder="Enter Confirm Password*" name="password_confirmation" id="password_confirmation" data-aos="fade-up">
            @if($errors->has('password_confirmation'))
                <div class="error">{{ $errors->first('password_confirmation') }}</div>
            @endif
            <button type="submit" class="fill-btn" data-aos="fade-up">Continue</button>
        </form>

    </div>
</section>

<!--------------------------
        SIGN IN END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
    $("#forgotPassForm").validate( {
        ignore: [],
        rules: {
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
            password: {
                required:"Password is required"
            },
            password_confirmation: {
                required:"Confirm Password is required"
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