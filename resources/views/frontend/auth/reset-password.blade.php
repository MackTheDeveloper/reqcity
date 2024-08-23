@section('title','Reset Password')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        RESET PASSWORD START
--------------------------->
<div class="container">
    <form id="resetPassword" method="POST" action="{{ route('resetPassword') }}">
        @csrf
        <div class="layout-352 form-page login">
            <h5>Reset Password</h5>
            <p class="bm ">Please enter a new password</p>
            <br>
            <div>
                <input name="input" type="hidden" value="{{$email}}">

                <div class="input-groups">
                    <span>New Password</span>
                    <input type="password" name="password" id="password">
                </div>
                <div class="input-groups">
                    <span>Confirm Password</span>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>
            </div>
            <button type="submit" class="fill-btn">Reset</button>
        </div>
    </form>
</div>
<!--------------------------
        RESET PASSWORD END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
    $("#resetPassword").validate({
        ignore: [],
        rules: {
            password: {
                required: true,
                minlength: 8,
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: "Password is required"
            },
            password_confirmation: {
                required: "Confirm Password is required"
            }
        },
        errorPlacement: function(error, element) {
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
    });
</script>
@endsection