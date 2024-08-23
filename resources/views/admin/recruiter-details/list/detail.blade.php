@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Recruiter Details</title>

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
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{route('adminDashboard')}}">
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{route('recruiters')}}" style="color: grey">Recruiter Portal</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">{{$recruiters['recruiterName']}}</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="new-to-old">
                <div class="dashboards-main">
                    <div class="row">
                        <div class="col-md-12">

                            {{-- <div class="recruiter-candidate-dashbox">
                                <div class="reqstudent-dash-head">
                                    <h5>{{$recruiters['recruiterName']}}</h5>
                                    <span>{{$recruiters['recruiterUniqueId']}}</span>
                                </div>
                                <p>{{$recruiters['phoneExt'].' '.$recruiters['phone']}}</p>
                                <p>{{$recruiters['recruiterEmail']}}</p>
                                <p>
                                    @php($address=[])
                                    @php($address[]=$recruiters['recruiterAddress1'])
                                    @php($address[]=$recruiters['recruiterAddress2'])
                                    @php($address[]=$recruiters['recruiterCity'])
                                    @php($address[]=$recruiters['recruiterState'])
                                    @php($address[]=$recruiters['recruiterCountry'])
                                    @php($address = array_filter($address))
                                    {{implode(', ',$address)}}
                                </p>
                            </div> --}}

                            @include('admin.recruiter-details.list.components.account-info')
                            @include('admin.recruiter-details.list.components.about-info')
                            @include('admin.recruiter-details.list.components.banking-info')
                            @include('admin.recruiter-details.list.components.recruiter-performance')

                            
                            @include('admin.recruiter-details.list.components.jobs-with-submittals')
                            

                            @include('admin.recruiter-details.list.components.recruiter-candidates')

                            
                        </div>
                    </div>
                </div>

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
                <form action="{{route('recruiterCancelSubscription',$model->id)}}">
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
    @include('admin.recruiter-details.list.components.edit-info-content')
@endsection
@push('scripts')

    <script type="text/javascript">
        $(document).on('click','.cancel_subscription',function() {
            $('#cancelSubscription').modal('show');            
        });
        $(document).on('click','.openModalEditInfo',function() {
            var dataId = $(this).data('id');
            $('#editInfoModal').find('.'+dataId+'-change').removeClass('d-none').siblings().addClass('d-none');
            $('#editInfoModal').modal('show');            
        });
    </script>
@endpush