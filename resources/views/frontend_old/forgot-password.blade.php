@section('title','Reset Password')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->

<section class="mw-352">
    <div class="signin forgot-psw">

        <h2 data-aos="fade-right">Forgot Password</h2>

        <span data-aos="fade-up">Enter the mobile number or email address associated with your Decorato account.</span>
        <form method="POST" id="forgotPassForm" action="{{ route('verifyOTP') }}">
            @csrf
            <input data-aos="fade-up" type="text" class="input" placeholder="Mobile number or email*" name="input" id="input">
            @if($errors->has('phone'))
                <div class="error">{{ $errors->first('phone') }}</div>
            @endif
            <button type="submit" data-aos="fade-up" class="fill-btn">Continue</button>
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
            input: {
                required:true
                // minlength:10,
                // maxlength:10
            }
        },
        messages:{
            input: {
                required:"Email or Phone Number is required"
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