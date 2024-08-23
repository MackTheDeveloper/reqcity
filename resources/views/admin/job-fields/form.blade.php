@extends('admin.layouts.master')
<title><?php echo $model->id ? 'Edit Job Field | '.config('app.name_show') : 'Add Job Field | '.config('app.name_show'); ?></title>
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
                                        <i class="fa pe-7s-config"></i>
                                    </span>
                                    <span class="d-inline-block">Job Field</span>
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
                                                <a href="javascript:void(0);" style="color: grey">Job Field</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{url(config('app.adminPrefix').'/job-fields/index')}}" style="color: grey">
                                                    List</a>
                                            </li>
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
                        <h5 class="card-title">JOB FIELD INFORMATION</h5>
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
                            $actionUrl = url(config('app.adminPrefix').'/job-fields/update', $model->id);
                        else
                            $actionUrl = url(config('app.adminPrefix').'/job-fields/store');
                        ?>
                        <form id="addJobFieldForm" enctype="multipart/form-data" class="" method="post" action="{{$actionUrl}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="font-weight-bold">Code</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" value="{{$model->code}}" <?php if($model->id) echo 'disabled';?> />
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_name" class="font-weight-bold">Name</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="field_name" name="field_name" placeholder="Enter Field Name" value="{{$model->field_name}}" />
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="filterable" class="font-weight-bold">Filterable</label>
                                      <span class="text-danger">*</span>
                                      <div class="position-relative form-group">
                                          <div>
                                              <div class="custom-radio custom-control custom-control-inline">
                                                  <input type="radio" id="filterable" name="filterable" class="custom-control-input" value="yes" <?php if($model->filterable) echo $model->filterable == 'yes' ? 'checked' : ''; else echo 'checked';?>>
                                                  <label class="custom-control-label" for="filterable">Yes</label>
                                              </div>
                                              <div class="custom-radio custom-control custom-control-inline">
                                                  <input type="radio" id="filterable2" name="filterable" class="custom-control-input" value="no" <?php echo $model->filterable == 'no' ? 'checked' : ''; ?>>
                                                  <label class="custom-control-label" for="filterable2">No</label>
                                              </div>
                                          </div>
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
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="add_pkg_btn"><?php echo $model->id ? 'Update' : 'Add'; ?></button>
                                <a href="{{ url(config('app.adminPrefix').'/job-fields/index') }}">
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
<script src="{{asset('public/assets/js/job_management/job_field.js')}}"></script>
@endpush
