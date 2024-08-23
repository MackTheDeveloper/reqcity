@section('title', 'My Info')
@extends('frontend.layouts.master')
@section('content')
@php $filename='frontend.'.$roleText.'.include.sidebar';@endphp
    <section class="profiles-pages compnay-profile-pages">
        <div class="container">
            <div class="row">
                @include($filename)
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="right-sides-items">
                        <div class="ac-payment-page">
                            <!-- Start Box Item Layout reusable -->
                            <div class="accounts-boxlayouts">
                                <div class="ac-boclayout-header">
                                    <div class="boxheader-title">
                                        <h6>Notifications</h6>
                                        <!-- <span>R01532</span> -->
                                    </div>
                                    <div class="boxlayouts-edit">
                                        <div class="trans-date-update">
                                            <form id="form" method="" action="#">
                                                <div class="from-to-ranges">
                                                    <input type="text" class="datepicker" id="date" name="from-date"
                                                        placeholder="dd/mm/yyyy" />
                                                    <span class="date-range-to">to</span>
                                                    <input type="text" class="datepicker" id="date1" name="to-date"
                                                        placeholder="dd/mm/yyyy" />
                                                </div>
                                                <div class="from-torange-btn">
                                                  <button id="update-btn" class="border-btn filter-btn web-filter">
                                                    Update
                                                  </button>
                                                  <button id="update-btn" class="border-btn filter-btn mobile-filter">
                                                    Update
                                                  </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <span class="full-hr-ac"></span>
                                <div class=" ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="subscription-approvals-tab">
                                                <div class="tab-content acpayment-tabcontent" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                                        aria-labelledby="pills-home-tab">
                                                        <div class="div-table-wrapper">
                                                            <div class="div-table notification-table" id="magTable">
                                                                <div class="div-row">
                                                                    <div class="div-column">
                                                                        <p class="ll blur-color">Date</p>
                                                                    </div>
                                                                    <!-- <div class="div-column">
                                                                        <p class="ll blur-color">Type</p>
                                                                    </div> -->
                                                                    <div class="div-column">
                                                                        <p class="ll blur-color">Message</p>
                                                                    </div>
                                                                    @if($shoAction)
                                                                    <div class="div-column">
                                                                        <p class="ll blur-color">Action</p>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
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
@include('frontend.components.delete-confirm',['title'=>'Delete Notification','message'=>'Are you sure ?'])
@endsection
@section('footscript')
    <script type="text/javascript" src=""></script>
    <script src="{{ asset('/public/assets/frontend/js/magTable.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            notificationList();
        });

        $(document).on('click', '.web-filter', function(e) {
            e.preventDefault();
            var startDate = $('#date').val();
            var endDate = $('#date1').val();

            startDate = getFormatedDate(startDate);
            endDate = getFormatedDate(endDate);

            notificationList(startDate, endDate);
        });
        $(document).on('click', '.mobile-filter', function() {
            var startDate = $('#date').val();
            var endDate = $('#date1').val();

            startDate = getFormatedDate(startDate);
            endDate = getFormatedDate(endDate);

            notificationList(startDate, endDate);
        });

        function notificationList(startDate = '', endDate = '') {
            $('#magTable').magTable({
                ajax: {
                    "url": "{{ route('notificationsList') }}",
                    "type": "GET",
                    "data": {
                        "startDate": startDate,
                        "endDate": endDate
                    }
                },
                columns: [{
                        data: 'date',
                        name: 'date',
                        render: function(data) {
                            return '<p class="bm">' + data + '</p>';
                        },
                    },
                    // {
                    //     data: 'type',
                    //     name: 'type',
                    //     render: function(data) {
                    //         return '<p class="bm">' + data + '</p>';
                    //     },
                    // },
                    {
                        data: 'message',
                        name: 'message',
                        render: function(data) {
                            return '<p class="bm">' + data + '</p>';
                        },
                    },
                    {
                        data: 'action', name: 'action',
                        render: function(data){
                            return data;
                        },
                    }
                ]
            })
        }
        //for read unread
        $(document).on('click', '#readunread-btn', function() {
            var id = $(this).data().id;
            $.ajax({
                url: "{{ route('notificationReadunread')}}",
                data: {
                    "id": id
                },
                type: "GET",
                success: function (response) {
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                },
            });
        });
    </script>
@endsection
