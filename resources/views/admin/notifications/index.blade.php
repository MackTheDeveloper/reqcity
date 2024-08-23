@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Notifications </title>

@section('content')
    @include('admin.include.header')
    <div class="app-main">
      <script type="text/javascript">
          var baseUrl = <?php echo json_encode($baseUrl);?>;
      </script>
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa pe-7s-music"></i>
                                    </span>
                                    <span class="d-inline-block">Notifications</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{route('adminDashboard')}}">
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="javascript:void(0);" style="color: grey">Notifications</a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page">
                                               <a style="color: slategray">List</a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="page-title-actions">
                          <div class="d-inline-block dropdown show_status_btn">
                            <button id="show_status" data-show_status="1" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification_filter_btn">Show Unread</button>
                          </div>
                            <div class="d-inline-block dropdown">
                              <button id="notification_read" data-status="2" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification-read-unread">Mark as Read</button>
                            </div>
                            <div class="d-inline-block dropdown">
                              <button id="notification_unread" data-status="1" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification-read-unread">Mark as Unread</button>
                            </div>
                            <div class="d-inline-block dropdown">
                              <button id="notification_unread" data-status="3" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification-read-unread">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                              <tr class="text-center">
                                    <th style="display: none">ID</th>
                                    <th><input name="selectAll" value="" id="selectAll" type="checkbox"></th>
                                    <th>Message Type</th>
                                    <th>Message</th>
                                    <th>Notified On</th>
                                    <th style="display: none">ID</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>

</div>
@endsection
@section('modals-content')

    <!-- Modal for notification read unread template -->
    <div class="modal fade" id="NotificationModel" tabindex="-1" role="dialog" aria-labelledby="NotificationModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="NotificationModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="notification_status" id="notification_status" value="">
                    <p class="mb-0" id="message_notification"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="readUnreadNotification">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="NotificationAlertModel" tabindex="-1" role="dialog" aria-labelledby="NotificationModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="NotificationModelLabel">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="message_notification_alert"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" >Yes</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

<style>
    .hide_column {
        display: none;
    }
</style>

@push('scripts')
<script src="{{asset('public/assets/js/notifications/notifications.js')}}"></script>
@endpush
