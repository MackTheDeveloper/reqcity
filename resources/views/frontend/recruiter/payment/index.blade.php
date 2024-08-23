@section('title','Payments')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages recruiter-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.recruiter.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="ac-payment-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Account Balance</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <!-- <a><img src="/assets/img/pencil.svg" /></a> -->
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="boxlayout-infoitem">
                                            <p>Your balance to be paid out on next payroll 15th and last day of
                                                month is ${{$total}}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Transaction History</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <div class="trans-date-update">
                                        <form id="form" method="" action="#">
                                            <div class="from-to-ranges">
                                                <input type="text" class="datepicker" id="date" name="from-date" placeholder="dd/mm/yyyy" />
                                                <span class="date-range-to">to</span>
                                                <input type="text" class="datepicker" id="date1" name="to-date" placeholder="dd/mm/yyyy" />
                                            </div>
                                            <div class="from-torange-btn">
                                                <button type="button" class="border-btn" id="update-btn">Update</button>
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
                                            <ul class="nav " id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="tab-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Subscriptions</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="tab-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Payout</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content acpayment-tabcontent" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                    <div class="div-table-wrapper">
                                                        <div class="div-table" id="magTable">
                                                            <div class="div-row">
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Date</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Description</p>
                                                                </div>
                                                                <div class="div-column text-right">
                                                                    <p class="ll blur-color">Amount (USD)</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Receipt</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                    <div class="div-table-wrapper">
                                                        <div class="div-table" id="magTable-payout">
                                                            <div class="div-row">
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Date</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Description</p>
                                                                </div>
                                                                <div class="div-column text-right">
                                                                    <p class="ll blur-color">Amount (USD)</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Receipt</p>
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
<script type="text/javascript" src=""></script>
<script src="{{ asset('/public/assets/frontend/js/magTable.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        recruiterPaymentList();
        recruiterPayoutList();
    });

    $(document).on('click', '#update-btn', function() {
        var startDate = $('#date').val();
        var endDate = $('#date1').val();

        startDate = getFormatedDate(startDate);
        endDate = getFormatedDate(endDate);
        recruiterPaymentList(startDate, endDate);
        recruiterPayoutList(startDate, endDate);
    });

    function recruiterPaymentList(startDate = '', endDate = '') {
        $('#magTable').magTable({
            ajax: {
                "url": "{{ route('recruiterPaymentList') }}",
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
                {
                    data: 'description',
                    name: 'description',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'amount',
                    name: 'amount',
                    colClass: "text-right",
                    render: function(data) {
                        return '<p class="bm"> $' + data + '</p>';
                    },
                }
                // {
                //     data: 'invoice', name: 'invoice',
                //     render: function(data){
                //         return '<a href="#" class="a bm">'+data+'</a>';
                //     },
                // }
            ]
        })
    }

    function recruiterPayoutList(startDate = '', endDate = '') {
        $('#magTable-payout').magTable({
            ajax: {
                "url": "{{ route('recruiterPayoutList') }}",
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
                {
                    data: 'description',
                    name: 'description',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'amount',
                    name: 'amount',
                    colClass: "text-right",
                    render: function(data) {
                        return '<p class="bm"> $' + data + '</p>';
                    },
                }
                // {
                //     data: 'invoice', name: 'invoice',
                //     render: function(data){
                //         return '<a href="#" class="a bm">'+data+'</a>';
                //     },
                // }
            ]
        })
    }


</script>
@endsection