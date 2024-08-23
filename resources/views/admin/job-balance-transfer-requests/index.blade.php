@extends('admin.layouts.master')
<title>{{ config('app.name_show') }} | Job Balanace Transfer Requests </title>

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
                                    <span class="d-inline-block">Job Balanace Transfer Requests</span>
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
                                                <a href="javascript:void(0);" style="color: grey">Job Balanace Transfer
                                                    Requests</a>
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
                            <a href="javascript:void(0);" class="expand_collapse_filter">
                                <button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm">
                                    <i aria-hidden="true" class="fa fa-filter"></i> Filter
                                </button>
                            </a>
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
                                    <label for="is_active" class="mr-sm-2">Status</label>
                                    <select name="is_active" id="is_active" class="multiselect-dropdown form-control"
                                        style="width: 150px;">
                                        <option value="">Select Status</option>
                                        <option value=" ">All</option>
                                        <option value="1" selected>Pending</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Rejected</option>
                                    </select>
                                </div>
                                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <label for="company" class="mr-sm-2">Company</label>
                                    <select name="company" id="company" class="multiselect-dropdown form-control"
                                        style="width: 250px;">
                                        <option value="">Select Company</option>
                                        @foreach ($company as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <label for="daterange" class="mr-sm-2">Requested Between Date</label>
                                    <input type="text" class="form-control" name="daterange" id="daterange" />
                                </div>
                                <button type="button" id="search_job_balance_request"
                                    class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <span class="TotalCls">
                                    <h6>Total: <span id="total"></span></h6>
                                </span>
                                <tr class="text-center">
                                    <th>Action</th>
                                    <th>Company</th>
                                    <th>From Job</th>
                                    <th>To Job</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Reject Reason</th>
                                    <th>Requested On</th>
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
    <!-- Modal for approve balance -->
    <div class="modal fade" id="JobBalanceApproveModel" tabindex="-1" role="dialog"
        aria-labelledby="JobBalanceApproveModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="JobBalanceApproveModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="job_balance_id" id="job_balance_id">
                    <p class="mb-0" id="message_approve"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="approveJobBalance">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for reject balance -->
    <div class="modal fade" id="JobBalanceRejectModel" tabindex="-1" role="dialog"
        aria-labelledby="JobBalanceRejectModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="JobBalanceRejectModelLabel">Reject Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="job_balance_id" id="job_balance_id">
                    <div>
                        <label for="paymentId"><b> Reject Reason:</b></label>
                        <span class="text-danger">*</span>
                        <textarea required id="reject_reason" class="form-control"></textarea>
                        <span class="text-danger" id="required-reject_reason"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="rejectJobBalance">Reject</button>
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
    <script src="{{ asset('public/assets/js/job-balance-transfer-requests/job-balance-transfer-requests.js') }}?r=24022022"  data-base-url="{{url('/')}}"></script>
    <script>
        $(document).ready(function() {
            $('.expand_collapse_filter').on('click', function() {
                $(".expand_filter").toggle();
            })
        })
    </script>
@endpush
