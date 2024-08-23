@section('title','Recruiter Signup')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN UP START
--------------------------->
<div class="recruiter-signup-6">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">   
                <img src="{{ asset('public/assets/frontend/img/Sucess-badge.svg') }}" alt="payment success" />
                <h6>Payment successful!</h6>
                <p class="bl blur-color">Subscription ID: {{$subscriptionNumber}}</p>
                <hr class="hr">
                <p class="bl blur-color">Your payment is successful now you can submit candidates.</p>
                <div class="success-btn-block">
                <a href="{{route('showRecruiterDashboard')}}" class="border-btn">Go to Dashboard</a>
                <a href="{{route('recruiteryJobs')}}" class="fill-btn">Submit Candidate</a> 
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------------------
        SIGN UP END
--------------------------->
@endsection
@section('footscript')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
    $("#recruiterSignupForm").validate({
        ignore: [],
        rules: {
            firstname: "required",
            lastname: "required",
            country: "required",
            email: "required",
            password: {
                required: true,
                minlength: 8,
            },
            "conform-password": {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            "conform-password": {
                equalTo: "Please enter same as Password"
            }
        },
        errorPlacement: function(error, element) {
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            if (grecaptcha.getResponse()) {
                // 2) finally sending form data
                form.submit();
            } else {
                // 1) Before sending we must validate captcha
                grecaptcha.reset();
                grecaptcha.execute();
            }
        }
    });

    function submitForm() {
        var email = $('#email').val();
        $.ajax({
            url: "{{ route('recruiterUniqueEmail') }}",
            method: 'post',
            data: {
                email:email,
                _token:"{{csrf_token()}}",
            },
            dataType: 'json',
            success: function(response) {
                if(response.data == false){
                    $('#unique-email').text('This email is already exists')
                }else{
                    $("#recruiterSignupForm").submit();             
                }
            }
        });
    }

    $("#updateSignupForm").validate({
        ignore: [],
        rules: {
            firstname: "required",
            lastname: "required",
            country: "required",
            email: "required",
        },
        messages: {
            "conform-password": {
                equalTo: "Please enter same as Password"
            }
        },
        errorPlacement: function(error, element) {
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            if (grecaptcha.getResponse()) {
                // 2) finally sending form data
                form.submit();
            } else {
                // 1) Before sending we must validate captcha
                grecaptcha.reset();
                grecaptcha.execute();
            }
        }
    });

    function updateForm() {  
        var email = $('#email').val();
        var rec_id = $('#rec_id').val(); 
        $.ajax({
            url: "{{ route('recruiterUniqueEmail') }}",
            method: 'post',
            data: {
                email:email,
                rec_id:rec_id,
                _token:"{{csrf_token()}}",
            },
            dataType: 'json',
            success: function(response) {
                if(response.data == false){
                    $('#unique-email').text('This email is already exists');
                }else{
                    $("#updateSignupForm").submit();             
                }
            }
        });      
    }
</script>
@endsection