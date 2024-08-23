@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Book a Demo Requests </title>

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
                                <span class="d-inline-block">Book a Demo Requests</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Book a Demo Requests</a>
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
                                <select name="is_active" id="is_active" class="multiselect-dropdown form-control" style="width: 150px;">
                                    <option value="">Select Status</option>
                                    <option value=" ">All</option>
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                <label for="company" class="mr-sm-2">Type</label>
                                <select name="type" id="type" class="multiselect-dropdown form-control" style="width: 250px;">
                                    <option value="all" selected>All</option>
                                    <option value="1">Company</option>
                                    <option value="2">Recruiter</option>
                                </select>
                            </div>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                <label for="daterange" class="mr-sm-2">Enquired Between Date</label>
                                <input type="text" class="form-control" name="daterange" id="daterange" />
                            </div>
                            <button type="button" id="search_details" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="display: none">ID</th>
                                <th>Action</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone </th>
                                <th>Requirement</th>
                                <th>Enquired On</th>
                                <th>Status</th>
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
<!-- Modal for viewing details -->
<div class="modal fade" id="viewDetailsModel" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fanIsActiveModelLabel">Book a Demo Request Details </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <span><b>Type:</b></span>
                    <span id="demo-type"></span>
                </div>
                <br>
                <div>
                    <span><b>Name:</b></span>
                    <span id="name"></span>
                </div>
                <br>
                <div>
                    <span><b>Email:</b></span>
                    <span id="email"></span>
                </div>
                <br>
                <div>
                    <span><b>Phone:</b></span>
                    <span id="phone"></span>
                </div>
                <br>
                <div>
                    <span><b>Requirement:</b></span>
                    <span id="requirement"></span>
                </div>
                <br>
                <div>
                    <span><b>Enquired On:</b></span>
                    <span id="created_at"></span>
                </div>
                <br>
                <div>
                    <span><b>Status:</b></span>
                    <span id="demo-status"></span>
                </div>
                <br> 
            </div>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="fanIsActive">Mark as Completed</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal for mark completed -->
<div class="modal fade" id="demoCompletedModel" tabindex="-1" role="dialog" aria-labelledby="JobBalanceApproveModelLabel" aria-hidden="true">
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
                <input type="hidden" name="demo-id" id="demo-req-id">
                <p class="mb-0" id="message_approve"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="markAsCompleted">Yes</button>
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
<script src="{{ asset('public/assets/js/book-demo-requests/book_demo_requests.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })
</script>
@endpush