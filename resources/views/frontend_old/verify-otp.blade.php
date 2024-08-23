@extends('frontend.layouts.master')
@section('title','Verify OTP')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->

<section class="authentication-page mw-352">
    <div class="authenti-con">
        <h2 data-aos="fade-right">Verify OTP</h2>
        @if(isset($inputType) && $inputType=='email')
            <span data-aos="fade-up">Enter the 4 digit verification code we sent to your email.</span>
        @else
            <span data-aos="fade-up">Enter the 4 digit verification code we sent to your mobile number.</span>
        @endif
    </div>
    @if(isset($type) && $type=='login')
        <form method="post" id="verifyUserForm" action="{{ route('postLoginWithOTP') }}">
    @else
        <form method="post" id="verifyUserForm" action="{{ route('resetPassword') }}">
    @endif
        @csrf
        @if(!Auth::check())
            <input type="hidden" name="input" id="input" value="{{(isset($input)?$input:'')}}">
        @else
            <input type="hidden" name="input" id="input" value="{{(isset($inputType) && $inputType=='email')?Auth::user()->email:Auth::user()->phone}}">
        @endif
        <div class="otpInput" data-aos="fade-up">
            <input type="text" name="otp[]" id='ist' maxlength="1" onkeyup="clickEvent(this,'sec')">
            <input type="text" name="otp[]" id="sec" maxlength="1" onkeyup="clickEvent(this,'third')">
            <input type="text" name="otp[]" id="third" maxlength="1" onkeyup="clickEvent(this,'fourth')">
            <input type="text" name="otp[]" id="fourth" maxlength="1" onkeyup="clickEvent(this,'fifth')">
        </div>
        <div>
            <input type="hidden"  name="otp_full" id="otp_full" value="">
        </div>
        <div class="resend-otp" data-aos="fade-up">
            <a href="javascript:void(0)" class="resendOtp">Resend Code</a>
        </div>
        <button type="submit" id="fifth" class="verify-btn fill-btn" data-aos="fade-up">VERIFY</button>
    </form>
</section>

<!--------------------------
        SIGN IN END
--------------------------->
@endsection

@section('footscript')
<script type="text/javascript">
    function clickEvent(first,last){
        if(first.value.length){
            document.getElementById(last).focus();
        }
    }

    $("#verifyUserForm").validate( {
        ignore: [],
        rules: {
            otp_full: {
                required:true,
                minlength:4,
                maxlength:4,
            },
        },
        messages:{
            otp_full: {
                required:"Please Enter OTP"
            },
        },
        errorPlacement: function ( error, element ) {
            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
    });

    $(document).on('click','.verify-btn',function(e){
        e.preventDefault();
        e.returnValue = false;
        $.ajax({
            url:'{{ route('checkOTP') }}',
            method:'POST',
            data:$('#verifyUserForm').serialize(),
            success:function(response){
                if(response.success==1){
                    $('#verifyUserForm').submit();
                }else if(response.success==3){
                    $('.ajax-alert').html('<div class="alert alert-danger">OTP has been expired. Please regenerate OTP.</div>');
                    setTimeout(function(){
                        $('.ajax-alert .alert').fadeOut();
                    }, 5000);
                }else{
                    $('.ajax-alert').html('<div class="alert alert-danger">Verification Code is invalid</div>');
                    setTimeout(function(){
                        $('.ajax-alert .alert').fadeOut();
                    }, 5000);
                }
            }
        })
    });

    $(document).on('keyup blur','input[name="otp[]"]',function(){
        var otp = ''
        $('input[name="otp[]"]').each(function(){
            otp = otp+$(this).val();
        })
        $('input[name="otp_full"]').val(otp);
    })

    $(document).on('click','.resendOtp',function(){
        var input = $('#input').val();
        var token = @json(csrf_token());
        $.blockUI();
        $.ajax({
            url:"{{ route('resendOTP') }}",
            method:'post',
            data:{input:input,_token:token},
            success:function(response){
                $.unblockUI();
            }
        });
    });
</script>
@endsection