@extends('admin.layouts.master')
<title>{{ config('app.name_show') }} | Company Portal</title>

@section('content')
@include('admin.include.header')
<div class="app-main">
    @include('admin.include.sidebar')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper justify-content-between">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{route('adminDashboard')}}">
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0);">Company Portal</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-switch d-none">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Card View</label>
                    </div>
                </div>
            </div>
            <div class="search-with-button">
                <input type="text" class="input search_text" id="search_text" name="search_text" placeholder="Search for company" />
                <button class="search-btn searchComapny"><img src="{{ asset('public/assets/frontend/img/white-search.svg') }}" alt="" /></button>
                <select class="ml-2 form-control sortBy" name="sortBy">
                    <option selected value="date_desc">Recently Added</option>
                    <option value="date_asc">Oldest</option>
                    <option value="name_asc">A-Z</option>
                    <option value="name_desc">Z-A</option>
                </select>
            </div>

            <div class="company-portal-card new-to-old">
                <div class="a-z-links">
                    <a class="charSearch selectedChar" data-char='' href="javascript:void(0)">#</a>
                    @foreach (range('A', 'Z') as $char)
                    <a href="javascript:void(0)" class="charSearch" data-char='{{ $char }}'>{{ $char }}</a>
                    @endforeach
                </div>
                <div class="ajaxComapnyList">
                    @include('admin.company-details.list.components.company-list')
                </div>
            </div>

            <div class="job-posts not-found {{ !empty($companies['companies']) ? 'd-none' : '' }}">
                <div class="job-post-data">{{ config('message.frontendMessages.recordNotFound') }}</div>
            </div>

            <div class="joblist-loadmore text-center {{ empty($companies['companies']) ? 'd-none' : '' }}">
                <input type="hidden" name="page_no" id="page_no" value="1">
                <button class="border-btn clickLoadMore  mb-5">Load More</button>
            </div>
        </div>
        @include('admin.include.footer')
    </div>
</div>

<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModelLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="module_id" id="module_id">
                <p class="mb-0" id="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="deleteCompany">Yes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modals-content')
@include('admin.company-details.list.components.assign-manager')
@endsection
@push('scripts')
<script>
    let token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('public/assets/js/companies/companies.js') }}"></script>
@endpush