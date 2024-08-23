@section('title','Reset Password')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        FORGOT PASSWORD START
--------------------------->
    <div class="container">
        <form id="forgotPassword" method="POST" action="{{ route('forgotPassword') }}">
            @csrf
            <div class="layout-352 form-page login">
                <h5>Forgot Password</h5>
                <div class="or">
                    <p class="bm">Keep calm, we’ve got you covered.  Just enter your email address below to reset your password</p>
                </div>
                <div>
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="text" class="email" name="email" id="email"
                            pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
                    </div>
                </div>
                <button type="submit" class="fill-btn">Submit</button>
            </div>
        </form>
    </div>
<!--------------------------
        FORGOT PASSWORD END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
    $("#forgotPassword").validate( {
        ignore: [],
        rules: {
            email: {
                required:true
            }
        },
    });
</script>
@endsection
