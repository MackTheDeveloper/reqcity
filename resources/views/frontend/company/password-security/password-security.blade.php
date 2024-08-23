@section('title','Compnay Password & Security')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.company.include.sidebar')
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
                                    <a href="{{ route('showPasswordSecurityFormCompany')}}"><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" /></a>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="boxlayout-infoitem">
                                            {{--<span>Password has been set</span>--}}
                                            <p>Choose a strong, unique password that’s at least 8 characters long.
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection