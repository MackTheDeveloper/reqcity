@section('title', 'Company Signup')
@extends('frontend.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/jquery.ccpicker.css') }}">
@endsection
@section('content')
    <!--------------------------
                        SIGN UP START
                --------------------------->

                <div class="container">
                    <div class="layout-352 form-page signup-recruiter">
                        <h5>Sign up as a company</h5>
                        <div class="or">
                            <p class="bm blur-color">or <a href="{{ url('login') }}" class="a">log in to your account</a>
                            </p>
                        </div>
                        <form id="companySignupForm" method="POST" action="{{ $model->id?url('/company-signup-update'):url('/company-signup') }}">
                            @csrf
                            <input type="hidden" id="model_id" name="model_id" value="{{ $model->id }}">
                            <input type="hidden" id="company_id" name="company_id" value="{{ $companyId }}">
                            <input type="hidden" id="company_email" name="company_email" value="{{ $email }}">
                            <input type="hidden" id="company_user_id" name="company_user_id" value="{{ $companyUserId }}">
                            <input name="role_id" type="hidden" value="3">
                            <div>
                                <div class="input-groups">
                                    <span>Company name</span>
                                    <input type="text" name="firstname" value="{{ $model ? $model->firstname : '' }}" />
                                </div>
                                <div class="input-groups">
                                    <span>Email Address</span>
                                    <input type="email" name="email" id="email" value="{{ $model ? $model->email : '' }}" />
                                    <span class="error" id="unique-email" style="color: #F94C43; font-size 12px;"></span>
                                </div>
                                <div class="input-groups">
                                    <span>Password</span>
                                    <div class="password-field-wrapper">
                                        <input type="password" id="password" name="password" />
                                        <div class="password-icon"></div>
                                    </div>
                                </div>
                                <div class="input-groups">
                                    <span>Confirm Password</span>
                                    <div class="password-field-wrapper">
                                        <input type="password" id="conform-password" name="conform-password" />
                                        <div class="password-icon"></div>
                                    </div>
                                </div>
                                <div class="input-groups">
                                    <span>Country</span>
                                    <select name="country" id="country">
                                        @if ($model->country)
                                            @foreach ($countries as $key => $row)
                                                <option value="{{ $row['key'] }}" {{ $row['key'] == $model->country ? 'selected' : '' }}>
                                                    {{ $row['value'] }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($countries as $key => $row)
                                                <option value="{{ $row['key'] }}"
                                                    {{ $row['value'] == 'United States' ? 'selected' : '' }}>{{ $row['value'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>                            
                            <div class="terms-links">
                                <p class="bm blur-color">By continuing, you have read and agree to the <a target="_blank"
                                        href="{{ route('termsOfService') }}" class="a">Terms of Service.</a></p>
                            </div>
                            <button type="submit" class="fill-btn g-recaptcha" data-sitekey="{{ Config::get('app.googleReCaptchaKeys')['siteKey'] }}"
                                    data-callback='submitForm' id="create">{{$model->id?"Update Details":"Create Account"}}</button>
                        </form>  
                    </div>
                </div>
    <!--------------------------
                        SIGN UP END
                --------------------------->
@endsection
@section('footscript')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script type="text/javascript">
        $("#companySignupForm").validate({
            ignore: [],
            rules: {
                firstname: "required",
                country: "required",
                //email: "required",
                email: {
                    companyUniqueEmail: true,
                    required: true,
                },
                password: {
                    required: function(ele){
                        return $('#model_id').val()==""
                    },
                    minlength: 8,
                },
                "conform-password": {
                    required: function(ele){
                        return $('#model_id').val()==""
                    },
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
            $("#companySignupForm").submit();
            return true;
        }

        // function updateForm() {
        //     $("#updateSignupForm").submit();
        //     return true;
        // }

        $.validator.addMethod('companyUniqueEmail', function(value, element) {

            var email = $('#email').val();
            var company_id = $('#company_id').val();
            //var result = false;
            $.ajax({
                async: false,
                url: "{{ route('companyUniqueEmail') }}",
                method: 'post',
                data: {
                    email: email,
                    company_id: company_id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(response) {
                    result = (response.data == true) ? true : false;
                }
            });
            return result;
        }, "This email is already exists");
    </script>
@endsection
