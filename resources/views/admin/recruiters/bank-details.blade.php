@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Recruiter Bank Details</title>

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
                                <span class="d-inline-block"> Recruiter Bank Details</span>
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
                                            <a href="javascript:void(0);" style="color: grey"> Recruiter Bank Details</a>
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
                        <a id="exportBtn" class="mb-2 mr-2 btn-icon btn-square btn btn-danger btn-sm" tabindex="0" href="#"><i class="fas fa-file-excel"></i>&nbsp&nbsp Export</a>
                        {{ Form::open(array('url' => route('exportBankDetails'),'class'=>'exportSub','id'=>'exportBankDetails','autocomplete'=>'off')) }}
                        <input type="hidden" name="search" id="search">
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>Recruiter</th>
                                <th>Currency Code</th>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                                <th>Swiftcode</th>
                                <th>Bank Address</th>
                                <th>Bank City</th>
                                <th>Bank Country</th>
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

    .text-wrap {
        white-space: normal;
    }

    .width-200 {
        width: 200px;
    }
</style>

@push('scripts')
<script src="{{asset('public/assets/js/recruiters/recruiter-bank-details.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })
    $(document).on('click', '#exportBtn', function() {
        $('#exportBankDetails').submit();
    })
</script>
@endpush