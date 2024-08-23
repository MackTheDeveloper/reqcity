@section('title','Password & Security')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.candidate.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="password-security-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Password & Security</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a ><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" /></a>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <form id="changePassword" method="POST" action="{{ route('changeCandidatePassword') }}">
                                @csrf
                                <div class="reset-password-security">
                                    <div class="RPS-box">
                                    <div class="input-groups">
                                        <span>Old Password</span>
                                        <input type="password" name="old_password" />
                                    </div>
                                    <div class="input-groups">
                                        <span>New Password</span>
                                        <input type="password" name="password" id="password"/>
                                    </div>
                                    <div class="input-groups">
                                        <span>Confirm Password</span>
                                        <input type="password" name="password_confirmation" />
                                    </div>
                                    <div class="this-btn-block">
                                        <button class="fill-btn">Save</button>
                                        <a href="{{route('showPasswordSecurityCandidate')}}" class="border-btn">Cancel</a>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footscript')
<script type="text/javascript">
    $("#changePassword").validate({
        ignore: [],
        rules: {
            old_password: {
                required: true,
                minlength: 8,
            },
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
            password_confirmation: {
                equalTo: "Please enter same as password"
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