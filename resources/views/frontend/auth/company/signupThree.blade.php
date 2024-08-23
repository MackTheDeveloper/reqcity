@section('title', 'Company Signup 3')
@extends('frontend.layouts.master')
@section('content')
    <div class="company-signup-3">
        <div class="container">
            <div class="process-progress">
                <div class="info-progress done">
                    <div class="numbers" id="step1"><a href="{{ route('showCompanySignup') }}"
                            style="text-decoration: none; color:white;">1</a></div>
                    <p class="tm">Sign Up</p>
                </div>
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('showSecondCompanySignup') }}"
                            style="text-decoration: none; color:white;">2</a></div>
                    <p class="tm">Information</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">3</div>
                    <p class="tm">Pricing</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">4</div>
                    <p class="tm">Payment</p>
                </div>
            </div>
            <div class="compnay-signup-pricing">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copnay-pricing-flex">
                            <div class="pricing-chos-left">
                                <div class="pricing-choose-panels">
                                    <div class="pricing-chos-head">
                                        <h5>{{ getPricingMessage('company', 'title1') }}</h5>
                                        <p class="bm">{{ getPricingMessage('company', 'description1') }}</p>
                                    </div>
                                    <div class="pricing-chos-panel">
                                        <ul class="nav nav-pills pricing-main-pills" id="pills-tab" role="tablist">
                                            <li class="pricing-nav-item" role="presentation">
                                                <a class="pricing-nav-link {{ empty($getCurrentSubscription) || ($getCurrentSubscription && $getCurrentSubscription->plan_type == 'yearly') ? 'active' : '' }}"
                                                    id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                                    aria-controls="pills-home" aria-selected="true"
                                                    data-subscription-id={{ $subscriptionPlanYearly->id }}>Yearly<span>{{ getPricingMessage('company', 'saveings') }}</span></a>
                                                <a class="pricing-nav-link {{ $getCurrentSubscription && $getCurrentSubscription->plan_type == 'monthly' ? 'active' : '' }}"
                                                    id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                                    role="tab" aria-controls="pills-profile" aria-selected="false"
                                                    data-subscription-id={{ $subscriptionPlanMonthly->id }}>Monthly</a>
                                            </li>
                                        </ul>
                                        <form id="companySignupFormThree" method="POST"
                                            action="{{ url('/company-signup-3') }}">
                                            @csrf
                                            <input type="hidden" id="current_subscription" name="current_subscription"
                                                value="{{ $getCurrentSubscription ? $getCurrentSubscription->id : $subscriptionPlanYearly->id }}">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade {{ empty($getCurrentSubscription) || ($getCurrentSubscription && $getCurrentSubscription->plan_type == 'yearly') ? 'show active' : '' }}"
                                                    id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                    <div class="pricing-cho-tab">
                                                        <div class="pricibg-chos-tabin">
                                                            <div class="pricing-cho-head">
                                                                <p class="tm">
                                                                    Yearly<span>{{ $subscriptionPlanYearly && $subscriptionPlanYearly->flag_recommended == 'yes' ? '(Recommended)' : '' }}</span>
                                                                </p>
                                                            </div>
                                                            <div class="pricing-chos-budget">
                                                                <div class="pricing-budgettitle">
                                                                    <h4>${{ $subscriptionPlanYearly && $subscriptionPlanYearly->price ? $subscriptionPlanYearly->price : '0.00' }}
                                                                    </h4><span>/year</span>
                                                                </div>
                                                                <p class="bm">
                                                                    {{ $subscriptionPlanYearly && $subscriptionPlanYearly->tag_line ? $subscriptionPlanYearly->tag_line : '' }}
                                                                </p>
                                                            </div>
                                                            <button type="submit" class="fill-btn">Choose
                                                                Yearly</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade {{ $getCurrentSubscription && $getCurrentSubscription->plan_type == 'monthly' ? 'show active' : '' }}"
                                                    id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                    <div class="pricing-cho-tab">
                                                        <div class="pricibg-chos-tabin">
                                                            <div class="pricing-cho-head">
                                                                <p class="tm">
                                                                    Monthly<span>{{ $subscriptionPlanMonthly && $subscriptionPlanMonthly->flag_recommended == 'yes' ? '(Recommended)' : '' }}</span>
                                                                </p>
                                                            </div>
                                                            <div class="pricing-chos-budget">
                                                                <div class="pricing-budgettitle">
                                                                    <h4>${{ $subscriptionPlanMonthly && $subscriptionPlanMonthly->price ? $subscriptionPlanMonthly->price : '0.00' }}
                                                                    </h4><span>/month</span>
                                                                </div>
                                                                <p class="bm">
                                                                    {{ $subscriptionPlanMonthly && $subscriptionPlanMonthly->tag_line ? $subscriptionPlanMonthly->tag_line : '' }}
                                                                </p>
                                                            </div>
                                                            <button type="submit" class="fill-btn">Choose
                                                                Monthly</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="pricing-chos-right">
                                <div class="hiring-efforts">
                                    <div class="hiring-efort-head">
                                        <h5>{{ getPricingMessage('company', 'title2') }}</h5>
                                        <p>{{ getPricingMessage('company', 'description2') }}</p>
                                    </div>
                                    @foreach ($subscriptionPlanFeatures as $item)
                                        <div class="effort-features-item">
                                            <div class="effort-featimg">
                                                <img src="{{ $item->icon }}" alt="" />
                                            </div>
                                            <div class="effort-feat-title">
                                                <p class="tm">{{ $item->title }}</p>
                                                <span>{!! $item->description !!}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('footscript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.pricing-nav-link').click(function() {
                $('#current_subscription').val($(this).data('subscription-id'));
            })
        });
    </script>
@endsection
