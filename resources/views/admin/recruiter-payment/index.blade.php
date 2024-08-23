@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Recruiter Payment </title>

@section('content')
@include('admin.include.header')
<link rel="stylesheet" href="{{asset('public/assets/custom/css/bank-copy-icon.css')}}">
<div class="app-main">
    @include('admin.include.sidebar')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-head center-elem">
                                <span class="d-inline-block pr-2">
                                    <i class="active_icon metismenu-icon pe-7s-cash"></i>
                                </span>
                                <span class="d-inline-block">Recruiter Payment</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Recruiter Payment</a>
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
                        @if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_payment_export') === true)
                        <a id="exportBtn" class="mb-2 mr-2 btn-icon btn-square btn btn-danger btn-sm" tabindex="0" href="#"><i class="fas fa-file-excel"></i>&nbsp&nbsp Export</a>
                        @endif
                        <a href="javascript:void(0);" class="expand_collapse_filter">
                            <button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm">
                                <i aria-hidden="true" class="fa fa-filter"></i> Filter
                            </button>
                        </a>
                        {{ Form::open(array('url' => route('exportRecruiterPayment'),'class'=>'exportSub','id'=>'exportRecruiterPayment','autocomplete'=>'off')) }}
                        <input type="hidden" name="status" id="status">
                        <input type="hidden" name="startDate" id="startDate">
                        <input type="hidden" name="endDate" id="endDate">
                        <input type="hidden" name="search" id="search">
                        <input type="hidden" name="company_name" id="company_name">
                        <input type="hidden" name="recruiter" id="recruiter_name">
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card expand_filter" style="display:none;">
                <div class="card-body">
                    <h5 class="card-title"><i aria-hidden="true" class="fa fa-filter"></i> Filter</h5>
                    <div>
                        <form method="post" class="form-inline">
                            @csrf

                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                <label for="daterange" class="mr-sm-2">Posted Between Date</label>
                                <input type="text" class="form-control" name="daterange" id="daterange" />
                            </div>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                <label for="company" class="mr-sm-2">Company</label>
                                <select name="company" id="company" class="multiselect-dropdown form-control" style="width: 230px;">
                                    <option value="">Select Company</option>
                                    @foreach ($company as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                <label for="recruiter" class="mr-sm-2">Recruiter</label>
                                <select name="recruiter" id="recruiter" class="multiselect-dropdown form-control" style="width: 230px;">
                                    <option value="">Select Recruiter</option>
                                    @foreach ($recruiter as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="search_recruiter_payment" class="btn btn-primary" style="float: right;">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                            <span class="TotalCls">
                                <h6>Total: <span id="total"></span></h6>
                            </span>
                            <button type="button" id="recruiter_payment" class="btn btn-primary" style="float: right;">Pay Now</button>
                            <tr class="text-center">
                                <th class="hide_column">Id</th>
                                <th id="hide_column"><input name="selectAll" value="" id="selectAll" type="checkbox"></th>
                                <th>Recruiter Name</th>
                                <th>Company Name</th>
                                <th>Job Title</th>
                                <th>Job Posted on</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        @section('modals-content')
        <!-- Modal for Payment -->
        <div class="modal fade" id="RecruiterPaymentModel" tabindex="-1" role="dialog" aria-labelledby="recruiterPaymentModel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RecruiterPaymentHeaderLabel" value=""></h5>
                        <button type="button" class="close" style="display:none;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4 style="font-weight: bold;">Bank Details</h4>
                        </center>
                        <br>
                        <div class="bank-name">
                            <span for="bankName"><b> Bank Name:</b></span>
                            <span id="bankName"></span>
                            <a href="#" onclick="copyToClipboard('bankName')"><i class="fas fa-copy"></i></a>
                        </div>
                        <br>
                        <div class="account-number">
                            <span for="accountNumber"> <b> Account Number:</b></span>
                            <span id="accountNumber"></span>
                            <a href="#" onclick="copyToClipboard('accountNumber')"><i class="fas fa-copy"></i></a>
                        </div>
                        <br>
                        <div class="swift-code">
                            <span for="swiftCode"> <b> Swift Code:</b></span>
                            <span id="swiftCode"></span>
                            <a href="#" onclick="copyToClipboard('swiftCode')"><i class="fas fa-copy"></i></a>
                        </div>
                        <br>
                        <div class="bank-address">
                            <span for="address"><b> Address:</b>
                                <span id="address"></span>
                                <a href="#" onclick="copyToClipboard('address')"><i class="fas fa-copy"></i></a> </span>
                        </div>
                        <br>
                        <div class="bank-city">
                            <span for="city"><b> City:</b></span>
                            <span id="city"></span>
                            <a href="#" onclick="copyToClipboard('city')"><i class="fas fa-copy"></i></a>
                        </div>
                        <br>
                        <div class="bank-country">
                            <span for="country"><b>Country:</b></span>
                            <span id="country"></span>
                            <a href="#" onclick="copyToClipboard('country')"><i class="fas fa-copy"></i></a>
                        </div>
                        <br>
                        <div>
                            <label for="amount"><b> Amount($): </b></label>
                            <span class="text-danger">*</span>
                            <input type="number" required id="amount" class="form-control">
                            <span class="text-danger" id="required-amount"></span>
                        </div>
                        <div>
                            <label for="paymentId"><b> Payment ID:</b></label>
                            <span class="text-danger">*</span>
                            <input type="text" required id="paymentId" class="form-control">
                            <span class="text-danger" id="required-paymentId"></span>
                        </div>

                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="recruiter_id" id="rec_id">
                        <input type="hidden" name="checked" id="checked">
                        <input type="hidden" name="checkedIds" id="checkedIds">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal" onClick="window.location.reload()">Cancel</button>
                        <button type="button" class="btn btn-primary" id="paynow">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Show message-->
        <div class="modal fade" id="showMessageModel" tabindex="-1" role="dialog" aria-labelledby="showMessageModel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showMessageHeaderLabel" value="">Alert</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="message"> </p>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal" onClick="window.location.reload()">Cancel</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @include('admin.include.footer')
    </div>

</div>
@endsection

<style>
    .hide_column {
        display: none;
    }
</style>

@push('scripts')
<script src="{{asset('public/assets/js/recruiter_payment/recruiter_payment.js')}}"></script>

<script>
    //Copy to clipboard
    function copyToClipboard(element) {
        var Text = document.getElementById(element);
        /* Copy text into clipboard */
        navigator.clipboard.writeText(Text.innerHTML);
    }

    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })
    //defult select first date of current month and current date as last date for daterange
    $(document).ready(function() {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date();
        $('#daterange').daterangepicker({
            startDate: firstDay,
            endDate: lastDay
        });
        $("#search_recruiter_payment").trigger("click");
    });

    $('#selectAll').change(function() {
        if (this.checked) {
            $('#checked').val('selectAll');
            console.log($('#checked').val());
        } else {
            $('#checked').val('');
            var checkedValues = [];
            $('#Tdatatable').find('input[type="checkbox"]:checked').each(function() {
                if (this.checked) {
                    checkedValues.push(this.value);
                    $('#checked').val(checkedValues);
                }
            });
            console.log($('#checked').val());
        }
    });

    //show and hide column based on recruiter id change
    // $(document).ready(function(){
    //     var recr = "";
    //     $("#recruiter").change(function(){
    //         recr = $(this).val();
    //         if(recr != ""){
    //             var tbl = $('#Tdatatable');
    //             tbl.DataTable().column(1).visible(true);
    //         }else{
    //             var tbl = $('#Tdatatable');
    //             tbl.DataTable().column(1).visible(false);
    //         } 
    //     });
    //     if(recr == ""){
    //         var tbl = $('#Tdatatable');
    //         tbl.DataTable().column(1).visible(false);
    //     }
    // });


    $(document).on('click', '#exportBtn', function() {
        /* // var startDate = $('#daterange').data('daterangepicker').startDate;
         // var endDate = $('#daterange').data('daterangepicker').endDate;
         // var status = $('#is_active').val();
         // var search = $('.dataTables_filter input[type="search"]').val();
         // startDate = startDate.format('YYYY-MM-DD');
         // endDate = endDate.format('YYYY-MM-DD');
         // $('#exportSub #startDate').val(startDate);
         // $('#exportSub #endDate').val(endDate);
         // $('#exportSub #status').val(status);
         // $('#exportSub #search').val(search);*/
        $('#exportRecruiterPayment').submit();
    })
</script>
@endpush