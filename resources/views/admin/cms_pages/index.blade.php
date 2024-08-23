@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | CMS Pages</title>

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
                                    <i class="fa pe-7s-global"></i>
                                </span>
                                <span class="d-inline-block">CMS Pages</span>
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
                                            <a href="javascript:void(0);">CMS Pages</a>
                                        </li>

                                        <li class="active breadcrumb-item" aria-current="page">
                                            List
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <div class="d-inline-block dropdown">
                            @if((whoCanCheck(config('app.arrWhoCanCheck'), 'admin_cms_page_add') === true))
                            <a href="{{url(config('app.adminPrefix').'/cms-page/create')}}">
                                <button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm">
                                    <i class="fa fa-plus btn-icon-wrapper"> </i>Add CMS Page
                                </button>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="cms_page_listing" class="nowrap table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>Action</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Is Active</th>
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
<!-- Modal for delete FAQ -->
<div class="modal fade" id="cmsPageIsActiveModel" tabindex="-1" role="dialog" aria-labelledby="cmsPageIsActiveModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cmsPageIsActiveModelLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="cms_page_id" id="cms_page_id">
                <input type="hidden" name="is_active" id="is_active">
                <p class="mb-0" id="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="cmsPageIsActive">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for delete event -->
<div class="modal fade" id="cmsPageDeleteModel" tabindex="-1" role="dialog" aria-labelledby="cmsPageDeleteModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cmsPageDeleteModelLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="cms_page_id" id="cms_page_id">
                <p class="mb-0" id="message_delete"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="deleteCmsPage">Yes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let dashboardSearch = '{{$search}}';
    $('#showDropdown').val(dashboardSearch);
    $('#searchableFormListing').attr('action', base_url + '/securefcbcontrol/cms-page/list');
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script src="{{asset('public/assets/js/cms-page/cms-page.js')}}"></script>
@endpush