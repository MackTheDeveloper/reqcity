@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Import Category</title>

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar closed-sidebar">
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
                                        <i class="lnr-users opacity-6"></i>
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
                                            <li class="active breadcrumb-item">
                                                <a href="{{url(config('app.adminPrefix').'/category/index')}}">Categories</a>
                                            </li>
                                            @if(!empty($catTitle))
                                            <li class="active breadcrumb-item" aria-current="page">
                                                @foreach(array_reverse($catTitle) as $title)
                                                    @if(!$loop->last)
                                                        <a href="{{ url(config('app.adminPrefix').'/category/index?catId='.$title->category_id) }}">{{ $title->title }}</a>
                                                        <span>/</span>
                                                    @else
                                                        <a href="{{ url(config('app.adminPrefix').'/category/index?catId='.$title->category_id) }}">{{ $title->title }}</a>
                                                    @endif
                                                @endforeach
                                            </li>
                                            @endif
                                            <li class="breadcrumb-item" aria-current="page">Import Category</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="page-title-actions">
                            <div class="d-inline-block dropdown">
                                <!-- <a href="{{asset('/excel-sample/user-sample-file.xls')}}" download><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-fw" aria-hidden="true"></i> Download Sample File</button></a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Category Information</h5>
                        <form id="importCategory" class="col-md-6" method="post" action="{{url(config('app.adminPrefix').'/category/import')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative form-group">
                                <label for="exampleFile" class="">File<span style="color:red">*</span></label>
                                <input type="hidden" name="catId" value="{{ $catId }}">
                                <input name="import_category_file" id="import_category_file" type="file" class="form-control-file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <small class="form-text text-muted"><i class="fa fa-fw" aria-hidden="true" title="Copy to use warning"></i> File must be 'csv','xls' or 'xlsx' formated.</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="import" value="import">Import</button>
                                <a href="{{asset('public/excel-sample/reqcity-category-sample-file.xls')}}" download><button type="button" class="btn btn-primary"><i class="fa fa-fw" aria-hidden="true"></i> Download Sample File</button></a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Error Section -->
                <div class="main-card mb-3 card ScrollStyle">
                    <div class="card-body">
                        <h5 class="card-title">Logs</h5>
                        <nav class="" aria-label="breadcrumb">
                                <?php
                                    $errors = Session::get('msg');
                                    if(isset($errors) && !empty($errors)){
                                ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php
                                    foreach($errors as $error)
                                    {
                                ?>
                                    <i class="fa fa-times"></i> <?php echo $error ?><br/>
                                    <?php
                                    }
                                ?>
                                </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    $uploaded = Session::get('success');
                                    if(isset($uploaded) && !empty($uploaded))
                                    {
                                ?>
                                    <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php if(count($uploaded) >= 1)
                                        {
                                          $cFaile=0;
                                          if(isset($faile) && !empty($faile))
                                          $cFaile=count($faile);
                                        ?>
                                            <i class="fa fa-times"></i> <?php echo count($uploaded) .' Rows' ; ?> uploaded successfully.<br/>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    $faile = Session::get('faile');
                                    if(isset($faile) && !empty($faile))
                                    {
                                ?>
                                    <div class="alert alert-secondary alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php if(count($faile) >= 1)
                                        {
                                        ?>
                                            <i class="fa fa-times"></i> <?php echo (count($faile) == 1) ? count($faile).'Row' : count($faile).'Rows' ; ?> failed to upload.<br/>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                    }
                                ?>
                        </nav>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
</div>
@endsection
<div class="app-drawer-overlay d-none animated fadeIn"></div>
@push('scripts')

<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/metismenu"></script> -->
<script>
/** add  music cateogry form validation */
$("#importCategory").validate({
    ignore: [], // ignore NOTHING
    rules: {
        "import_category_file": {
            required: true,
        },

    },
    messages: {
        "import_category_file": {
            required: "Please upload a file."
        },

    },
    errorPlacement: function (error, element)
    {
        error.insertAfter(element)
    },
    submitHandler: function(form)
    {
        form.submit();
    }
});

$(document).ready(function(){

})
</script>
@endpush
