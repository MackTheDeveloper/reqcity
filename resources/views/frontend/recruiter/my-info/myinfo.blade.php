@php
use App\Models\GlobalSettings;
@endphp
@section('title','My Info')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages recruiter-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.recruiter.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="myinfo-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="show-account-info">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Account Info</h6>
                                    <span>{{$data->user->unique_id}}</span>
                                </div>
                                <div class="boxlayouts-edit">
                                    <a><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" id="edit-account" /></a>
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>First name</span>
                                            <p>{{$data->user->firstname}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Last name</span>
                                            <p>{{$data->user->lastname}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Email</span>
                                            <p>{{$data->user->email}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Phone number</span>
                                            <p>{{$data->phone_ext}}-{{$data->phone}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        @include('frontend.recruiter.my-info.components.edit-account-info')
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="about-show-form">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>About</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" id="about-edit" /></a>
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Website</span>
                                            <p>{{$data->website? :'N/A'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Country</span>
                                            <p>{{$data->Country->name ? :'-'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Address line 1</span>
                                            <p>{{$data->address_1?:'-'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Address line 2</span>
                                            <p>{{$data->address_2?:'-'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>City</span>
                                            <p>{{$data->city?:'-'}}</p>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>State</span>
                                            <p>{{$data->state?:'-'}}</p>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Zip code</span>
                                            <p>{{$data->postcode?:'-'}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        @include('frontend.recruiter.my-info.components.edit-about-info')
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="bank-show-form">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Banking Info</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                {{-- <div class="boxlayouts-edit">
                                    <a><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" id="bank-edit" /></a>
                                </div> --}}
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                {{-- @if(GlobalSettings::getSingleSettingVal('recruiterBankDetailLink'))
                                <p><a target="_blank" href="{{GlobalSettings::getSingleSettingVal('recruiterBankDetailLink')}}">Click here</a> to add or update your banking info.</p>
                                @endif --}}
                                <p>Thank you for signing up for ReqCity.  You will receive an email with instructions for completing HR/Payroll platform on Paycom within the next 48 hours. If you have any questions, please contact us at <a href="mailto:recruiting@reqcity.com">recruiting@reqcity.com</a></p>

                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Account number</span>
                                            <p>{{(isset($data->recruiterBankDetail->account_number))?$data->recruiterBankDetail->account_number :'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Bank location</span>
                                            <p>{{(isset($data->recruiterBankDetail->Country->name))?$data->recruiterBankDetail->Country->name :'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Payment Currency</span>
                                            <p>{{(isset($data->recruiterBankDetail->currency_code))?$data->recruiterBankDetail->currency_code:'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Bank Name</span>
                                            <p>{{(isset($data->recruiterBankDetail->bank_name))?$data->recruiterBankDetail->bank_name:'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>SWIFT code</span>
                                            <p>{{(isset($data->recruiterBankDetail->swift_code))?$data->recruiterBankDetail->swift_code:'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Bank address</span>
                                            <p>{{(isset($data->recruiterBankDetail->bank_address))?$data->recruiterBankDetail->bank_address:'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>City</span>
                                            <p>{{(isset($data->recruiterBankDetail->bank_city))?$data->recruiterBankDetail->bank_city:'-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>W-9</span>
                                            <div class="resume-uploded-label">
                                                <a href="{{$w9FormLink}}" download>
                                                    <img src="{{asset('public/assets/frontend/img/pdf-orange.svg')}}" alt="pdf">
                                                </a>
                                                <p>W-9 Form</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        @include('frontend.recruiter.my-info.components.edit-bank-info')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footscript')
<script type="text/javascript">
    const uploadFormFile = document.getElementById("upload-form-file");
    const uploadFormImg = document.getElementById("upload-form-img");
    const uploadFormText = document.getElementById("upload-form-text");

    uploadFormImg.addEventListener("click", function() {
        uploadFormFile.click();
    });

    uploadFormFile.addEventListener("change", function() {
        if (uploadFormFile.value) {
            uploadFormText.innerHTML = uploadFormFile.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];
        } else {
            uploadFormText.innerHTML = "No file chosen, yet.";
        }
        var validateIcon = $('#updateMyInfo3').validate().element(':input[name="w9File"]');
        if (!validateIcon)
        return false;
    });

    $('#edit-account').click(function() {
        $('#show-account-info').addClass("d-none");
        $('#account-edit-form').removeClass("d-none");
    });

    $('#about-edit').click(function() {
        $('#about-show-form').addClass("d-none");
        $('#about-edit-form').removeClass("d-none");
    });

    $('#bank-edit').click(function() {
        $('#bank-show-form').addClass("d-none");
        $('#bank-edit-form').removeClass("d-none");
    });


    $("#updateMyInfo1").validate({
        ignore: [],
        rules: {
            "User[firstname]": "required",
            "User[lastname]": "required",
            "User[email]": {
                recruiterUniqueEmail: true,
                required: true,
            },
            "Recruiter[phone]": "required",
        },
        messages: {

        },
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#updateMyInfo3").validate({
        ignore: [],
        rules: {
            "RecruiterBank[currency_code]": "required",
            "RecruiterBank[bank_name]": "required",
            "RecruiterBank[swift_code]": "required",
            "RecruiterBank[bank_address]": "required",
            "RecruiterBank[bank_city]": "required",
            "w9File" : {
                extension: "pdf|docx|doc|rtf|txt"
            }
        },
        messages: {
            w9File:"Please upload W9File in .pdf,.docx,.doc,.rtf or .txt format",
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element);
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $.validator.addMethod('recruiterUniqueEmail', function(value, element) {

        var email = $('#email').val();
        var rec_id = $('#rec_id').val();
        //var result = false;
        $.ajax({
            async: false,
            url: "{{ route('recruiterUniqueEmail') }}",
            method: 'post',
            data: {
                email: email,
                rec_id: rec_id,
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