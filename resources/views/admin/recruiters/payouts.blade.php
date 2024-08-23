@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Recruiter Payouts </title>

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
                                <span class="d-inline-block">Recruiter Payouts</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Recruiter Payouts</a>
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
                @if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_payout_export') === true)
                <a id="exportBtn" class="mb-2 mr-2 btn-icon btn-square btn btn-danger btn-sm" tabindex="0" href="#"><i class="fas fa-file-excel"></i>&nbsp&nbsp Export</a>
                @endif
                <a href="javascript:void(0);" class="expand_collapse_filter">
                    <button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm">
                        <i aria-hidden="true" class="fa fa-filter"></i> Filter
                    </button>
                </a>
                {{ Form::open(array('url' => route('exportRecruiterPayout'),'class'=>'exportSub','id'=>'exportRecruiterPayout','autocomplete'=>'off')) }}
                <input type="hidden" name="search" id="search">
                <input type="hidden" name="startDate" id="startDate">
                <input type="hidden" name="endDate" id="endDate">
                <input type="hidden" name="fil_recruiter" id="fil_recruiter">
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
                        <label for="recruiter" class="mr-sm-2">Recruiter</label>
                        <select name="recruiter" id="recruiter" class="multiselect-dropdown form-control" style="width: 200px;">
                            <option value="">Select Recruiter</option>
                            @foreach ($recruiters as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <label for="daterange" class="mr-sm-2">Paid Between Date</label>
                        <input type="text" class="form-control" name="daterange" id="daterange" />
                    </div>
                    <button type="button" id="search_recruiter_transaction" class="btn btn-primary">Search</button>
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
                        <th>Recruiter</th>
                        <th>Amount</th>
                        <th>Payment ID</th>
                        <th>Bank</th>
                        <th>Bank Details</th>
                        <th>Paid On</th>
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
<script src="{{asset('public/assets/js/recruiters/recruiter-payouts.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })
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
        $('#exportRecruiterPayout').submit();
    })
</script>
@endpush
