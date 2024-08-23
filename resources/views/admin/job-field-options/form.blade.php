@extends('admin.layouts.master')
<title><?php echo $model->id ? 'Job Field Option | '.config('app.name_show') : 'Add Job Field Option | '.config('app.name_show'); ?></title>
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
                                    <span class="d-inline-block">Job Field Option</span>
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
                                                <a href="javascript:void(0);" style="color: grey">Job Field Option</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{url(config('app.adminPrefix').'/job-field-options/index')}}" style="color: grey">
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
                        <h5 class="card-title">JOB FIELD OPTION INFORMATION</h5>
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
                            $actionUrl = url(config('app.adminPrefix').'/job-field-options/update', $model->id);
                        else
                            $actionUrl = url(config('app.adminPrefix').'/job-field-options/store');
                        ?>
                        <form id="addJobFieldOptionForm" enctype="multipart/form-data" class="" method="post" action="{{$actionUrl}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="option" class="font-weight-bold">Option</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="option" name="option" placeholder="Enter Option" value="{{$model->option}}" />
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="font-weight-bold">Job Field</label>
                                          <span class="text-danger">*</span>
                                            <select name="job_field_id" id="job_field_id" class="multiselect-dropdown form-control" >
                                                <option value="">Select Job Fields</option>
                                                @if(isset($JobFields))
                                                @foreach($JobFields as $val)
                                                <option value="{{$val->id}}" <?php echo $model->job_field_id == $val->id ? 'selected' : ''; ?>>{{$val->field_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
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
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="add_pkg_btn"><?php echo $model->id ? 'Update' : 'Add'; ?></button>
                                <a href="{{ url(config('app.adminPrefix').'/job-field-options/index') }}">
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
<script src="{{asset('public/assets/js/job_management/job_field_option.js')}}"></script>
@endpush
