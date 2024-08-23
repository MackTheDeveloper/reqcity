@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Highlighted Jobs </title>

@section('content')
@include('admin.include.header')
<link rel="stylesheet" href="{{asset('public/assets/custom/css/add-job-datepicker.css')}}">  
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
                                <span class="d-inline-block">Highlighted Jobs</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Highlighted Jobs</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray" href="{{ url('securerccontrol/highlighted-jobs/index') }}">List</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">Add</a>
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
                                <label for="company" class="mr-sm-2">Company</label>
                                <select name="company" id="company" class="multiselect-dropdown form-control" style="width: 250px;">
                                    <option value="all" selected>All</option>
                                    @foreach ($company as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="search_company" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                            <button type="button" id="add_highlated_job" class="btn btn-primary" style="float: right;">Add </button>
                            <br><br>
                            <tr class="text-center">
                                <th class="hide_column">Id</th>
                                <th><input name="selectAll" value="" id="selectAll" type="checkbox"></th>
                                <th>Company</th>
                                <th>Job Category</th>
                                <th>Job Title</th>
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
<!-- Modal for get Dates -->
<div class="modal fade" id="highlatedJobAddModel" tabindex="-1" role="dialog" aria-labelledby="highlatedJobAddModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RecruiterPaymentHeaderLabel" value="">Highlighted Jobs</h5>
                <button type="button" class="close" style="display:none;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <h4 style="font-weight: bold;"></h4>
                </center>
                <br>
                <div>
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <label for="startDatepicker" class="mr-sm-2">Start Date</label>
                        <input type="text" class="form-control datepicker"  placeholder="Select Start Date" name="startDatepicker" id="startDatepicker" />
                        <span class="text-danger" id="required-startDate"></span>
                    </div>
                    <br>
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <label for="endDatepicker" class="mr-sm-2">End Date</label>
                        <input type="text" class="form-control datepicker" placeholder="Select End Date" name="endDatepicker" id="endDatepicker" />
                        <span class="text-danger" id="required-endDate"></span>
                    </div>
                </div>
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="recruiter_id" id="rec_id">
                <input type="hidden" name="checked" id="checked">
                <input type="hidden" name="checkedIds" id="checkedIds">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal" onClick="window.location.reload()">Cancel</button>
                <button type="button" class="btn btn-primary" id="addnow">Add Now</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for alert message-->
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
    
    
    @push('scripts')
    <script src="{{asset('public/assets/js/highlighted-jobs/highlighted-jobs-add.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.expand_collapse_filter').on('click', function() {
                $(".expand_filter").toggle();
            })
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
    
    </script>
    @endpush