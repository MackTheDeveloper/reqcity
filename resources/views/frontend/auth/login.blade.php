@section('title', 'Sign In')
@extends('frontend.layouts.master')
@section('content')
    <!--------------------------
                SIGN IN START
        --------------------------->

    <div class="container">
        <form id="loginForm" method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="layout-352 form-page login">
                <h5>Log in to ReqCity</h5>
                <div class="or">
                    <p class="bm blur-color">or <a href="{{url('signup')}}" class="a">create an account</a></p>
                </div>
                <div>
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="text" class="email" name="email" id="email"
                            pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
                    </div>
                    <div class="input-groups">
                        <span>Password</span>
                        <input type="password" name="password" id="password">
                    </div>
                </div>
                <div class="forgot-link">
                    <a href="{{ route('showForgotPassword') }}" class="a"><span>Forgot Password?</span></a>
                </div>
                <div class="terms-links">
                    <p class="bm blur-color">By continuing, you have read and agree to the <a href="{{route('termsOfService')}}"
                            class="a">Terms of Service.</a></p>
                </div>
                <button type="submit" class="fill-btn">Log In</button>
            </div>
        </form>
    </div>

    <!--------------------------
                SIGN IN END
        --------------------------->
@endsection
@section('footscript')
    <script type="text/javascript">
        $("#loginForm").validate({
            ignore: [],
            rules: {
                email: "required",
                password: "required",
            },
        });
    </script>
@endsection
