@extends('admin.layouts.master')
<title><?php echo $model->id ? 'Edit Subscription Plan | ' . config('app.name_show') : 'Add Subscription Plan | ' . config('app.name_show'); ?></title>
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
                                <span class="d-inline-block">Subscription Plans</span>
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
                                            <a href="javascript:void(0);" style="color: grey">Subscription Plans</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{url(config('app.adminPrefix').'/subscription-plan/index')}}" style="color: grey">
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
                    <h5 class="card-title">SUBSCRIPTION PLAN INFORMATION</h5>
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
                        $actionUrl = url(config('app.adminPrefix') . '/subscription-plan/update', $model->id);
                    else
                        $actionUrl = url(config('app.adminPrefix') . '/subscription-plan/store');
                    ?>
                    <form id="addSubscriptionPlanForm" enctype="multipart/form-data" class="" method="post" action="{{$actionUrl}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscription_name" class="font-weight-bold">Name</label>
                                    <span class="text-danger">*</span>
                                    <div>
                                        <input type="text" class="form-control" id="subscription_name" name="subscription_name" placeholder="Enter Name" value="{{$model->subscription_name}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="font-weight-bold">Type</label>
                                    <span class="text-danger">*</span>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="type" name="type" class="custom-control-input" value="company" <?php if ($model->type) echo $model->type == 'company' ? 'checked' : '';
                                                                                                                                        else echo 'checked'; ?>>
                                                <label class="custom-control-label" for="type">Company</label>
                                            </div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="type2" name="type" class="custom-control-input" value="recruiter" <?php echo $model->type == 'recruiter' ? 'checked' : ''; ?>>
                                                <label class="custom-control-label" for="type2">Recruiter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="font-weight-bold">Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div>
                                        <textarea name="description" id="description" type="text" class="form-control ckeditor">{!! $model->description !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tag_line" class="font-weight-bold">Tag Line
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div>
                                        <input type="hidden" id="planId" value="{{$model->id}}">
                                        <input type="text" class="form-control" id="tag_line" name="tag_line" placeholder="Enter Tag Line" value="{{$model->tag_line}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_type" class="font-weight-bold">Plan Type</label>
                                    <span class="text-danger">*</span>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="plan_type" name="plan_type" class="custom-control-input" value="monthly" <?php if ($model->plan_type) echo $model->plan_type == 'monthly' ? 'checked' : '';
                                                                                                                                                    else echo 'checked'; ?>>
                                                <label class="custom-control-label" for="plan_type">Monthly</label>
                                            </div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="plan_type2" name="plan_type" class="custom-control-input" value="yearly" <?php echo $model->plan_type == 'yearly' ? 'checked' : ''; ?>>
                                                <label class="custom-control-label" for="plan_type2">Yearly</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">Price($)</label>
                                    <span class="text-danger">*</span>
                                    <div>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" value="{{$model->price}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="flag_recommended" class="font-weight-bold">Flag Recommended</label>
                                    <span class="text-danger">*</span>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="flag_recommended" name="flag_recommended" class="custom-control-input" value="yes" <?php if ($model->flag_recommended) echo $model->flag_recommended == 'yes' ? 'checked' : '';
                                                                                                                                                            else echo 'checked'; ?>>
                                                <label class="custom-control-label" for="flag_recommended">Yes</label>
                                            </div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="flag_recommended2" name="flag_recommended" class="custom-control-input" value="no" <?php echo $model->flag_recommended    == 'no' ? 'checked' : ''; ?>>
                                                <label class="custom-control-label" for="flag_recommended2">No</label>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="trial_period" class="font-weight-bold">Trial Period(in days)</label>
                                    <div>
                                        <input type="text" class="form-control" id="trial_period" name="trial_period" placeholder="Enter Trial Period" value="{{$model->trial_period}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="font-weight-bold">Icon
                                        <span class="text-danger">*</span></label>
                                    <div>
                                        <input name="icon" id="icon" type="file" class="form-control-file" value="{{old('icon')}}">
                                        <small class="form-text text-muted">Image size should be {{config('app.SubscriptionPlanIconDimension.width')}} X {{config('app.SubscriptionPlanIconDimension.height')}} px.</small>
                                    </div>
                                    <?php if (isset($model->icon)) { ?>
                                        <div style="float: left"><a href="javascript:void(0);" onclick="openImageModal('{{$baseUrl}}/public/assets/images/subscription-plan/{{$model->icon }}')"><img src="{{$baseUrl}}/public/assets/images/subscription-plan/{{$model->icon }}" width="50" height="50" alt="" /></a></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="add_pkg_btn"><?php echo $model->id ? 'Update' : 'Add'; ?></button>
                            <a href="{{ url(config('app.adminPrefix').'/subscription-plan/index') }}">
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

<!-- Modal for Alert template -->
<div class="modal fade" id="SubscriptionPlanAlertModel" tabindex="-1" role="dialog" aria-labelledby="SubscriptionPlanAlertModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SubscriptionPlanAlertModelLabel">Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <p class="mb-0" id="message_alert"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('public/assets/js/subscription_plan/subscription_plan.js')}}"></script>
<script>
    $(document).on('click','#add_pkg_btn', function(e){
    var type = $('input[type=radio][name=type]:checked').val();
    var planType = $('input[type=radio][name=plan_type]:checked').val();
    var planId = $('#planId').val();
    $.ajax({
        async: false,
        url: "{{ route('checkSubscriptionPlan')}}",
        method: 'get',
        data: {
            type: type,
            planType: planType,
            planId:planId,
        },
        dataType: 'json',
        success: function(response) {
            if(response.message){
                e.preventDefault(); 
                $('#SubscriptionPlanAlertModel').on('show.bs.modal', function(e){
                    $('#message_alert').text(response.message);
                });
                $('#SubscriptionPlanAlertModel').modal('show');
            }
        }
    });
});
</script>
@endpush