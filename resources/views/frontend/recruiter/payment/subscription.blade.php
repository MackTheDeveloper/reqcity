@section('title', 'My Subscription')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.recruiter.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="mysubscription-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Subscription Plan</h6>
                                </div>
                                {{-- <div class="boxlayouts-edit">
                                    <a href="javascript:void(0)"><img src="{{asset('/public/assets/frontend/img/pencil.svg')}}" /></a>
                                </div> --}}
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="boxlayout-subscriptions">
                                            <span>Current subscription</span>
                                            @if($currentSubscription)
                                            <div class="current-subplan-price">
                                                <h4>${{$currentSubscription->amount}}</h4> <span>/{{$currentSubscription->plan_type}}</span>
                                            </div>
                                            <div class="subscription-validuntil">
                                                <span>Subscription valid until:</span>
                                                <p>{{getFormatedDate($subscriptionExpireAt)}}</p>
                                            </div>
                                            @else
                                                <p>No subscription found</p>
                                            @endif


                                            @if ($upcoming)
                                                @if ($upcoming['activated']!='2')
                                                    <hr>
                                                    <span>Upcoming subscription</span>
                                                    <div class="current-subplan-price">
                                                        <h4>${{$upcoming['amount']}}</h4> <span>/{{$upcoming['type']}}</span>
                                                    </div>
                                                    <div class="subscription-validuntil">
                                                        <span>Subscription Starts On:</span>
                                                        <p>{{getFormatedDate($upcoming['scheduled_date'])}}</p>
                                                    </div>
                                                    <form class="submitPageForm" data-type="cancel-scheduled" method="POST" action="{{route('RecruiterSubscriptionPlanCancelSchedule')}}">
                                                        @csrf
                                                        <button class="border-btn">Cancel Subscription</button>
                                                    </form>
                                                @endif
                                            @else
                                                @if(!Auth::user()->is_subscription_cancelled && $currentSubscription)
                                                <form class="submitPageForm" data-type="cancel-current" method="POST" action="{{route('RecruiterSubscriptionPlanCancel')}}">
                                                    @csrf
                                                    <button class="border-btn">Cancel Subscription</button>
                                                </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        @if((!$upcoming || $upcoming['activated']=='1') && !Auth::user()->is_subscription_cancelled)
                        <div class="upgrade-subscription-box">
                            @if ($chooseSubscription['plan_type']=='yearly')
                                <p class="upgrade-plan-title">Would you like to upgrade your plan?</p>
                            @else
                                <p class="upgrade-plan-title">Would you like to downgrade your plan?</p>
                            @endif
                            <div class="subscription-quterly">
                                <p>{{ucfirst($chooseSubscription['plan_type'])}}</p>
                                @if ($chooseSubscription['flag_recommended']!='no')
                                    <span>(Recommended)</span>
                                @endif
                            </div>
                            <div class="current-subplan-price">
                                <h4>${{$chooseSubscription['price']}}</h4>
                                <p>/{{substr($chooseSubscription['plan_type'], 0, -2)}}</p>
                            </div>
                            @if($chooseSubscription['saving'])
                            <span class="savingsof-txt">Savings of ${{$chooseSubscription['saving']}}</span>
                            @endif
                            <form class="submitPageForm" data-type="{{$chooseSubscription['plan_type']=='yearly' ? 'upgrade' : 'downgrade'}}" method="POST" action="{{route('RecruiterSubscriptionPlanUpgrade')}}">
                                @csrf
                                <button class="fill-btn">Choose {{ucfirst($chooseSubscription['plan_type'])}}</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.components.delete-confirm',['title'=>'Confirm','message'=>'Are you sure?'])
@endsection
@section('footscript')
    <script type="text/javascript">
        $(document).on('submit','.submitPageForm',function (e) {
            e.preventDefault();
            var formAcion = $(this).attr('action')
            var type = $(this).attr('data-type')
            var title = "confirm";
            var message = "Are you sure?";
            $("#ConfirmModel #deleteConfirmed").attr("action", formAcion);
            $("#ConfirmModel #deleteConfirmed input#id").val('1');
            if (type=='cancel-scheduled') {
                title = "Confirm";
                message = "Are you sure you want to cancel this upgraded subscription?";
            }else if (type=='cancel-current') {
                title = "Confirm";
                message = "Are you sure you want to cancel this subscription?";
            }else if (type=='upgrade') {
                title = "Confirm";
                message = "Are you sure you want to upgrade subscription plan?";
            }else if (type=='downgrade') {
                title = "Confirm";
                message = "Are you sure you want to downgrade subscription plan?";
            }

            $("#ConfirmModel .modal-title").text(title);
            $("#ConfirmModel #message_delete").text(message);

            $("#ConfirmModel").modal('show');
        })
    </script>
@endsection