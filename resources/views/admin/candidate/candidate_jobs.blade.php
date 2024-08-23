@extends('admin.layouts.master')
<title>{{ config('app.name_show') }} | Cnadidate Jobs </title>

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
                                    <span class="d-inline-block">Candidate Jobs</span>
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
                                                <a href="javascript:void(0);" style="color: grey">Candidate Jobs</a>
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
                                        <option value="all">All</option>
                                        <option value="0" selected>Pending</option>
                                        <option value="1">Assigned</option>
                                        <option value="2">Submitted</option>
                                        <option value="3">Accepted</option>
                                        <option value="4">Rejected</option>
                                    </select>
                                </div>
                                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <label for="company" class="mr-sm-2">Select Candiate Specialist</label>
                                    <select name="candiate_specialist" id="candiate_specialist"
                                        class="multiselect-dropdown form-control" style="width: 250px;">
                                        <option value="">Select Candiate Specialist</option>
                                        @foreach ($candidates as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <label for="daterange" class="mr-sm-2">Applied Between Dates</label>
                                    <input type="text" class="form-control" name="daterange" id="daterange" />
                                </div>
                                <button type="button" id="search_candidate" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th class="hide_column">Id</th>
                                    <th>Action </th>
                                    <th>Candidate</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Resume</th>
                                    <th>Candidate Specialist</th>
                                    <th>Status</th>
                                    <th>Reject Reason</th>
                                    <th>Applied On</th>
                                    <th>Last Updated On</th>
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
    <div class="modal fade" id="assignSpecialistModel" tabindex="-1" role="dialog"
        aria-labelledby="assignSpecialistModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignSpecialistModelLabel">Assign Candidate Specialist</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="application_id" id="application_id">
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <label for="specialist_user_id" class="mr-sm-2">Select Candidate Specialist</label>
                        <select name="specialist_user_id" id="specialist_user_id" class="multiselect-dropdown form-control"
                            style="width: 250px;">
                            <option value="">Select Candiate Specialist</option>
                            @foreach ($candidates as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mb-0" id="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="assignSpecialist" data-dismiss="modal">Assign</button>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.modal-layout',['modalId'=>'jobDescription','modalClass'=>'view-detail-modal'])
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/js/candidate/candidate-jobs.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.expand_collapse_filter').on('click', function() {
                $(".expand_filter").toggle();
            })
        })
        $(document).on('click', '.view-job', function() {
            // $('#jobDescription').modal('show');
            var jobId = $(this).data('job-id');
            var url = "{{ url('securerccontrol/candidate-jobs/job-detail/') }}/" + jobId
            $.get(url, function(data, status) {
                $('#jobDescription .modal-content').html(data);
                $('#jobDescription').modal('show');
            });
        });
    </script>
@endpush
