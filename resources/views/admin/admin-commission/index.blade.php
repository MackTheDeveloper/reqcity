@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Admin Commission </title>

@section('content')
@include('admin.include.header')
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
                                <span class="d-inline-block">Admin Commission</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Admin Commission</a>
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
                @if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_commission_export') === true)
                <a id="exportBtn" class="mb-2 mr-2 btn-icon btn-square btn btn-danger btn-sm" tabindex="0" href="#"><i class="fas fa-file-excel"></i>&nbsp&nbsp Export</a>
                @endif
                <a href="javascript:void(0);" class="expand_collapse_filter">
                    <button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm">
                        <i aria-hidden="true" class="fa fa-filter"></i> Filter
                    </button>
                </a>
                {{ Form::open(array('url' => route('exportAdminCommission'),'class'=>'exportSub','id'=>'exportAdminCommission','autocomplete'=>'off')) }}
                <input type="hidden" name="startDate" id="startDate">
                <input type="hidden" name="endDate" id="endDate">
                <input type="hidden" name="search" id="search">
                <input type="hidden" name="company_name" id="company_name">
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
                        <label for="daterange" class="mr-sm-2">Approved Between Date</label>
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
                    <button type="button" id="search_admin_commission" class="btn btn-primary" style="float: right;">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <span class="TotalCls"><h6>Total: <span id="total"></span></h6></span>
                    <tr class="text-center">
                        <th class="hide_column">Id</th>
                        <th>Company Name</th>
                        <th>Job Title</th>
                        <th>Job Posted on</th>
                        <th>Amount</th>
                        <th>Approved On</th>
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

<style>
    .hide_column {
        display: none;
    }
</style>

@push('scripts')
<script src="{{asset('public/assets/js/admin_commission/admin_commission.js')}}"></script>

<script>
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
        $('#daterange').daterangepicker({ startDate: firstDay, endDate: lastDay });
        $("#search_admin_commission").trigger( "click" );
    })
    
    $("#recruiter").change(function() {
        var head = document.getElementsByClassName("check");
        var input = document.getElementsByClassName("check-input");
        console.log(head.classList);
        // head.classList.remove("hide_column");
        // input.classList.remove("hide_column");

    });

    $('#all').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });
    
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
        $('#exportAdminCommission').submit();
    })
</script>
@endpush
