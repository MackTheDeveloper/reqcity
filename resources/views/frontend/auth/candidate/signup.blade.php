@section('title', 'Candidate Signup')
@extends('frontend.layouts.master')
@section('content')
    <div class="container">
        <div class="layout-352 form-page signup-recruiter">
            <h5>Sign up as a candidate</h5>
            <div class="or">
                <p class="bm blur-color">or <a href="{{ url('login') }}" class="a">log in to your account</a>
                </p>
            </div>
            <form id="candidateSignupForm" method="POST"
                action="{{ $model->id ? url('/candidate-signup-update') : url('/candidate-signup') }}">
                @csrf
                <input type="hidden" id="model_id" name="model_id" value="{{ $model->id }}">
                <input type="hidden" id="can_id" name="candidate_id" value="{{ $candidateId }}">
                <input type="hidden" id="can_email" name="candidate_email" value="{{ $email }}">
                <input name="role_id" type="hidden" value="5">
                <div>
                    <div class="input-groups">
                        <span>First Name</span>
                        <input type="text" name="firstname" value="{{ $model ? $model->firstname : '' }}" />
                    </div>
                    <div class="input-groups">
                        <span>Last Name</span>
                        <input type="text" name="lastname" value="{{ $model ? $model->lastname : '' }}" />
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
                                    <option value="{{ $row['key'] }}"
                                        {{ $row['key'] == $model->country ? 'selected' : '' }}>
                                        {{ $row['value'] }}</option>
                                @endforeach
                            @else
                                @foreach ($countries as $key => $row)
                                    <option value="{{ $row['key'] }}"
                                        {{ $row['value'] == 'United States' ? 'selected' : '' }}>{{ $row['value'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="terms-links">
                    <p class="bm blur-color">By continuing, you have read and agree to the <a target="_blank"
                            href="{{ route('termsOfService') }}" class="a">Terms of Service.</a></p>
                </div>
                <button type="submit" class="fill-btn g-recaptcha"
                    data-sitekey="{{ Config::get('app.googleReCaptchaKeys')['siteKey'] }}" data-callback='submitForm'
                    id="create">{{ $model->id ? 'Update Details' : 'Create Account' }}</button>
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
        $("#candidateSignupForm").validate({
            ignore: [],
            rules: {
                firstname: "required",
                lastname: "required",
                country: "required",
                email: {
                    candidateUniqueEmail: true,
                    required: true,
                },
                password: {
                    required: function(ele) {
                        return $('#model_id').val() == ""
                    },
                    minlength: 8,
                },
                "conform-password": {
                    required: function(ele) {
                        return $('#model_id').val() == ""
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
            $("#candidateSignupForm").submit();
            return true;
        }

        $.validator.addMethod('candidateUniqueEmail', function(value, element) {

            var email = $('#email').val();
            var can_id = $('#can_id').val();
            //var result = false;
            $.ajax({
                async: false,
                url: "{{ route('candidateUniqueEmail') }}",
                method: 'post',
                data: {
                    email: email,
                    can_id: can_id,
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
