@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Categories </title>

@section('content')
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <script type="text/javascript">
            var catId = <?php if(isset($catId)) echo json_encode($catId);else echo '';?>;
            var baseUrl = <?php echo json_encode($baseUrl);?>;
        </script>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa pe-7s-music"></i>
                                    </span>
                                    <span class="d-inline-block">Categories</span>
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
                                              @if(!empty($catTitle))
                                                  <a href="{{url(config('app.adminPrefix').'/category/index/')}}">Category</a>
                                              @else
                                                  <span>Category</span>
                                              @endif
                                            </li>
                                            @if(!empty($catTitle))
                                            <li class="active breadcrumb-item" aria-current="page">
                                                @foreach(array_reverse($catTitle) as $title)
                                                    @if(!$loop->last)
                                                        <a href="{{ url(config('app.adminPrefix').'/category/index?catId='.$title->category_id) }}">{{ $title->title }}</a>
                                                        <span>/</span>
                                                    @else
                                                        <span>{{ $title->title }}</span>
                                                    @endif
                                                @endforeach
                                            </li>
                                            @endif
                                            <li class="active breadcrumb-item" aria-current="page">
                                               <a style="color: slategray">List</a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="page-title-actions">
                          @if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_add') === true)
                            <div class="d-inline-block dropdown">
                              <input type="hidden" name="catId" value="{{ $catId }}">
                              @if(!empty($catId))
                              <a href="{{url(config('app.adminPrefix').'/category/add?catId='.$catId)}}"><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-plus btn-icon-wrapper"> </i>Add Category</button></a>
                              @else
                              <a href="{{url(config('app.adminPrefix').'/category/add')}}"><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-plus btn-icon-wrapper"> </i>Add Category</button></a>
                              @endif
                            </div>
                          @endif
                          @if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_import') === true)
                            <div class="d-inline-block dropdown">
                              @if(!empty($catId))
                              <a href="{{url(config('app.adminPrefix').'/category/import?catId='.$catId)}}"><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-upload btn-icon-wrapper"></i>Import</button></a>
                              @else
                              <a href="{{url(config('app.adminPrefix').'/category/import')}}"><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-upload btn-icon-wrapper"></i>Import</button></a>
                              @endif
                            </div>
                          @endif
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
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Icon</th>
                                    <th>Is Active</th>
                                    <th>Sort Order</th>
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
<!-- Modal for activating deactivating template -->
    <div class="modal fade" id="CategoriesIsActiveModel" tabindex="-1" role="dialog" aria-labelledby="CategoriesIsActiveModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CategoriesIsActiveModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="categories_id" id="categories_id">
                    <input type="hidden" name="status" id="status">
                    <p class="mb-0" id="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="CategoriesIsActive">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for delete template -->
    <div class="modal fade" id="CategoriesDeleteModel" tabindex="-1" role="dialog" aria-labelledby="CategoriesDeleteModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CategoriesDeleteModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="categories_id" id="categories_id">
                    <p class="mb-0" id="message_delete"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="deleteCategories">Yes</button>
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
<script src="{{asset('public/assets/js/job_management/categories.js')}}"></script>
@endpush
