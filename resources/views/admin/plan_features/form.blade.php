@extends('admin.layouts.master')
<title><?php echo $model->id ? 'Edit Plan Features | '.config('app.name_show') : 'Add Plan Features | '.config('app.name_show'); ?></title>
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
                                    <span class="d-inline-block">Plan Features</span>
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
                                                <a href="javascript:void(0);" style="color: grey">Plan Features</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{url(config('app.adminPrefix').'/plan-features/index')}}" style="color: grey">List</a>
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
                        <h5 class="card-title">Plan Features INFORMATION</h5>
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
                            $actionUrl = url(config('app.adminPrefix').'/plan-features/update', $model->id);
                        else
                            $actionUrl = url(config('app.adminPrefix').'/plan-features/store');
                        ?>
                        {{ Form::open(array('url' => $actionUrl,'class'=>'','id'=>'addPlanFeaturesForm','autocomplete'=>'off','enctype'=>"multipart/form-data")) }}
                        @csrf
                        <?php if ($model->id) { ?>
                            <input type="hidden" name="id" value="<?php echo $model->id; ?>" />
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo Form::label('type', 'Type', ['class' => 'font-weight-bold']); ?>
                                    <span class="text-danger">*</span>
                                    <div class="position-relative form-group">
                                            <div>
                                                <div class="custom-radio custom-control custom-control-inline">
                                                    <input type="radio" id="type" name="type" class="custom-control-input" value="Company" <?php if($model->type) echo $model->type == 'Company' ? 'checked' : ''; else echo 'checked';?>>
                                                    <label class="custom-control-label" for="type">Company</label>
                                                </div>
                                                <div class="custom-radio custom-control custom-control-inline">
                                                    <input type="radio" id="type2" name="type" class="custom-control-input" value="Recruiter" <?php echo $model->type == 'Recruiter' ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="type2">Recruiter</label>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo Form::label('title', 'Title', ['class' => 'font-weight-bold']); ?>
                                    <span class="text-danger">*</span>
                                    <div>
                                        <?php echo Form::text('title', $model->title, ['class' => 'form-control']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="font-weight-bold">Icon
                                    <span class="text-danger">*</span></label>
                                    <div>
                                        <input name="icon" id="icon" type="file" class="form-control-file" value="{{old('icon')}}">
                                        <small class="form-text text-muted">Image size should be {{config('app.PlanFeatureIconDimension.width')}} X {{config('app.PlanFeatureIconDimension.height')}} px.</small>
                                    </div>
                                    <?php if ($model->id && isset($model->icon)) { ?>
                                    <div style="float: left"><a href="javascript:void(0);" onclick="openImageModal('{{$baseUrl}}/public/assets/images/plan_feature_image/{{$model->icon }}')"><img src="{{$model->icon }}" width="50" height="50" alt="" /></a></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                         <br> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo Form::label('description', 'Description', ['class' => 'font-weight-bold']); ?>
                                        <span class="text-danger">*</span>
                                    <div>
                                        <?php echo Form::textarea('description', $model->description, ['class' => 'form-control','id'=>'ckeditorBody']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                           
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo Form::label('sort_order', 'Sort Order', ['class' => 'font-weight-bold']); ?>
                                    {{-- <span class="text-danger">*</span> --}}
                                    <div>
                                        <?php echo Form::number('sort_order', $model->sort_order, ['class' => 'form-control']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="font-weight-bold">Status
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div>
                                        <select name="status" id="is_active" class="form-control">
                                            <option value="1" <?php echo $model->status == '1' ? 'selected' : ''; ?>>Active</option>
                                            <option value="0" <?php echo $model->status == '0' ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="addPlan"><?php echo $model->id ? 'Update' : 'Add'; ?>
                                </button>
                            <a href="{{ url(config('app.adminPrefix').'/plan-features/index') }}">
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
<script src="{{asset('public/assets/js/plan_features/plan_features.js')}}"></script>
@endpush
