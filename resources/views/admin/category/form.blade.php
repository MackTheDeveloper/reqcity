@extends('admin.layouts.master')
<title><?php echo $model->id ? 'Edit Category | '.config('app.name_show') : 'Add Category | '.config('app.name_show'); ?></title>
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
                                        <i class="fa pe-7s-portfolio"></i>
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
                                                <a href="{{url(config('app.adminPrefix').'/category/index/')}}">Category</a>
                                              @endif
                                            </li>
                                            @if(!empty($catTitle))
                                            <li class="active breadcrumb-item" aria-current="page">
                                                @foreach(array_reverse($catTitle) as $title)
                                                    <a href="{{ url(config('app.adminPrefix').'/category/index?catId='.$title['category_id']) }}">{{$title['title'] }}</a>
                                                    @if(!$loop->last)
                                                        <span>/</span>
                                                    @endif
                                                @endforeach
                                            </li>
                                            @endif

                                            <li class="active breadcrumb-item" aria-current="page" style="color: slategray">
                                                <?php echo $model->id ? 'Edit' : 'Add'; ?>
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
                        <h5 class="card-title">Category INFORMATION</h5>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <?php
                        if ($model->id)
                            $actionUrl = url(config('app.adminPrefix').'/category/update', $model->id);
                        else
                            $actionUrl = url(config('app.adminPrefix').'/category/store');
                        ?>
                        <form id="addCategoryForm" enctype="multipart/form-data" class="" method="post" action="{{$actionUrl}}">
                            @csrf
                            <input type="hidden" name="catId" value="{{ $catId }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">Title</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                          <?php if($model->id){?>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{$model->title}}" />
                                          <?php }else { ?>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{$model->title}}" onInput="generateSlug();"/>
                                          <?php }?>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slug" class="font-weight-bold">Slug</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug" value="{{$model->slug}}" />
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content" class="font-weight-bold">Description
                                        </label>
                                        <div>
                                            <textarea name="description" id="description" type="text" class="form-control ckeditor">{{$model->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sort_order" class="font-weight-bold">Sort Order</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="sort_order" name="sort_order" placeholder="Enter Sort Order" value="{{$model->sort_order}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_active" class="font-weight-bold">Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="font-weight-bold">Icon</label>
                                        <div>
                                            <input name="icon" id="icon" type="file" class="form-control-file" value="{{old('icon')}}">
                                            <small class="form-text text-muted">Image size should be {{config('app.CategoryIconDimension.width')}} X {{config('app.CategoryIconDimension.height')}} px.</small>
                                        </div>
                                        <?php if (isset($model->icon)) { ?>
                                        <div style="float: left"><a href="javascript:void(0);" onclick="openImageModal('{{$icon }}')"><img src="{{$icon }}" width="50" height="50" alt="" /></a></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="add_pkg_btn"><?php echo $model->id ? 'Update' : 'Add'; ?></button>
                                <a href="{{ url(config('app.adminPrefix').'/category/index') }}">
                                    <button type="button" class="btn btn-light" name="cancel" value="Cancel">Cancel</button>
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('public/assets/js/job_management/categories.js')}}"></script>
@endpush
