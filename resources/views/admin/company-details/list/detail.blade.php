@extends('admin.layouts.master')
<title>{{ config('app.name_show') }} | Company Details</title>

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
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa fa-users opacity-6"></i>
                                    </span>
                                    <span class="d-inline-block">Users</span>
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
                                                <a href="{{ route('companies') }}">Company Portal</a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page">
                                                <a style="color: slategray">{{ $company->name }}</a>
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

                <div class="company-details new-to-old">
                    {{-- <div class="cpc-card">
                    <img src="{{$company->logo}}" alt="" />
                    <div class="this-content">
                        <p class="tl">{{$company->name}}</p>
                        <span class="ts blur-color">{{$company->Address->city. ', ' .$company->Address->state. ', '. $company->Address->countries->name}}</span>
                        <span class="bm ">{{$company->about}}</span>
                    </div>
                </div> --}}
                    @include('admin.company-details.list.components.account-info')
                    @include('admin.company-details.list.components.company-info')


                    <div class="copm-performance-dash">
                        <div class="copm-perform-head">
                            <h6>Company Performance</h6>
                            <!-- <a href="">View All</a> -->
                        </div>
                        <span class="full-hr"></span>
                        @include('admin.company-details.list.components.company-performance')
                    </div>

                    @include('admin.company-details.list.components.active-jobs-box')
                    @include('admin.company-details.list.components.active-jobs')

                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
@endsection
@section('modals-content')
    <!-- Modal for reject balance -->
    <div class="modal fade" id="cancelSubscription" tabindex="-1" role="dialog"
        aria-labelledby="cancelSubscriptionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelSubscriptionLabel">Cancel Subscription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('companyCancelSubscription',$company->id)}}">
                    <div class="modal-body">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div>
                            <label for="paymentId"><b> Reason for cancellation:</b></label>
                            <span class="text-danger">*</span>
                            <textarea required name="cancel_reason" id="cancel_reason" class="form-control"></textarea>
                            <span class="text-danger" id="required-cancel_reason"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="rejectJobBalance">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on('click','.cancel_subscription',function() {
            $('#cancelSubscription').modal('show');            
        });
    </script>
@endpush
