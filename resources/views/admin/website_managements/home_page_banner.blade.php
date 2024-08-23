@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Home Page Banner </title>

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
                                <span class="d-inline-block">Home Page Banner</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Home Page Banner</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">List</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th class="hide_column">Id</th>
                        <th>Action</th>
                        <th>Title</th>
                        <th>Sub Title</th>
                        <th>Banner</th>
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
@endsection

<style>
    .hide_column {
        display: none;
    }
</style>

@push('scripts')
<script src="{{asset('public/assets/js/website_management/home_page_banner.js')}}"></script>
@endpush
