@section('title','My Info')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages recruiter-profile-pages">
    <div class="container">
        <div class="row">
        @include('frontend.company.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="notification-setting-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts d-none">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Messages</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a><img src="/assets/img/pencil.svg" /></a>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="notification-for-website">
                                    <p class="noti-email-title">Website</p>
                                    <div class="show-noitification-for">
                                        <div class="input-groups">
                                            <span>Show notifications for:</span>
                                            <select>
                                                <option>All activity</option>
                                                <option>All activity2</option>
                                                <option>All activity3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="notification-for-email">
                                <div class="email-sending-title">
                                    <p class="noti-email-title">Email</p>
                                    <span>(sending to r*******r@domain.com)</span>
                                </div>
                                <div class="show-noitification-for">
                                    <div class="input-groups">
                                        <span>Show notifications for:</span>
                                        <select>
                                            <option>Important activities only</option>
                                            <option>All activity2</option>
                                            <option>All activity3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>ReqCity Email Updates</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a class="d-none"><img src="/assets/img/pencil.svg" /></a>
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="email-updates-request">
                                    <p>Send email notification to {{$email}} when...</p>
                                    <div class="emailupdates-checknow">
                                        @foreach($notifications as $notification)
                                        <div class="input-groups">
                                            <label class="ck">{{$notification['label']}}
                                                <input type="checkbox" class="notification" {{ in_array($notification['id'],$userNotification ) ? ' checked' : '' }} data-permId="{{ $notification['id'] }}" id="{{$notification['id']}}" />
                                                <span class="ck-checkmark"></span>
                                            </label>
                                        </div>
                                        @endforeach
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
@section('footscript')
<script>
    $(document).on('change', '.notification', function() {
        toastr.clear();
        toastr.success('Notification Settings Updated Sucessfully');
        var notificationId = $(this).attr('data-permId');
        // var userId = $('#user_id').val();
        $.ajax({
            url: "{{ route('updateNotificationSettingCompany') }}",
            type: "GET",
            data: {
                'notificationId': notificationId
            },
            dataType: "json",
            success: function(response) {}
        });
    });
</script>
@endsection
