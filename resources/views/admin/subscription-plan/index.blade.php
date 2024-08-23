@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Subscription Plans </title>

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
                                        <i class="fa pe-7s-music"></i>
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
                                            <li class="active breadcrumb-item" aria-current="page">
                                               <a style="color: slategray">List</a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        @if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_subscription_plan_add') === true)
                        <div class="page-title-actions">
                            <div class="d-inline-block dropdown">
                              <a href="{{url(config('app.adminPrefix').'/subscription-plan/add')}}"><button class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm"><i class="fa fa-plus btn-icon-wrapper"> </i>Add Subscription Plan</button></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                            <thead>
                              <!-- <span class="TotalCls"><h6>Total: <span id="total"></span></h6></span> -->
                                <tr class="text-center">
                                    <th style="display: none">ID</th>
                                    <th>Action</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Plan Type</th>
                                    <th>Price</th>
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
<!-- Modal for activating deactivating template -->
    <div class="modal fade" id="SubscriptionPlanIsActiveModel" tabindex="-1" role="dialog" aria-labelledby="SubscriptionPlanIsActiveModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubscriptionPlanIsActiveModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="subscription_plan_id" id="subscription_plan_id">
                    <input type="hidden" name="status" id="status">
                    <p class="mb-0" id="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="SubscriptionPlanIsActive">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for delete template -->
    <div class="modal fade" id="SubscriptionPlanDeleteModel" tabindex="-1" role="dialog" aria-labelledby="SubscriptionPlanDeleteModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubscriptionPlanDeleteModelLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="subscription_plan_id" id="subscription_plan_id">
                    <p class="mb-0" id="message_delete"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="deleteSubscriptionPlan">Yes</button>
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
<script src="{{asset('public/assets/js/subscription_plan/subscription_plan.js')}}"></script>
@endpush
