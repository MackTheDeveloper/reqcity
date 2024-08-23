@section('title','Candidate Dashboard')
@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <div class="dashboard-compnay dash-candidate">
        <div class="dashboards-main">
            <div class="row">
                <div class="col-md-12 col-lg-8 col-xl-9">

                    <div class="recruiter-candidate-dashbox">
                        <div class="reqstudent-dash-head">
                            <h5>{{$candidateData['candidateName']}}</h5>
                        </div>
                        <span>{{$candidateData['candidatePhone']}}</span>
                        <span>{{$candidateData['candidateEmail']}}</span>
                        <span>{{$candidateData['candidateAddress']}}</span>
                    </div>


                    <div class="active-jobs-dash">
                        <div class="active-job-head">
                            <h6>Applied Jobs</h6>
                            <a href="{{route('candidateJobs','applied')}}">View All</a>
                        </div>
                        <span class="full-hr"></span>
                        <div class="appliedjobs-detailed">
                            <div class="div-table-wrapper">
                                <div class="div-table">
                                    <div class="div-row">
                                        <div class="div-column">
                                            <p class="ll blur-color">Job Title</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">Company</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">City</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">Salary($)</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="ll blur-color">Status</p>
                                        </div>

                                    </div>

                                    @if(!empty($appliedJobs->toArray()))
                                    @foreach($appliedJobs as $k => $v)
                                    <div class="div-row">
                                        <div class="div-column">
                                            <p class="tm">{{$v->companyJob->title}}</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="bm">{{$v->companyJob->Company->name}}</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="bm">{{ $v->companyJob->Company->address->city }},
                                                {{ $v->companyJob->Company->address->countries->name }}</p>
                                        </div>
                                        <div class="div-column">
                                            <p class="bm">{{ getFormatedAmount($v->companyJob->from_salary,2) . ($v->companyJob->compensation_type == 'r' ? ' - '.getFormatedAmount($v->companyJob->to_salary,2) : '') . ' a '. $v->companyJob->salary_type}}</p>
                                        </div>
                                        <div class="div-column">
                                            @if($v->status == 0)
                                            <p class="ll blur-color" style="color: #e0ce09 !important;">Pending</p>
                                            @elseif($v->status == 1)
                                            <p class="ll blur-color" style="color: #4C65FF !important;">Recruiter Assigned</p>
                                            @elseif($v->status == 2)
                                            <p class="ll blur-color" style="color: #0ba360 !important;">Submitted</p>
                                            @elseif($v->status == 3)
                                            <p class="ll blur-color" style="color: #3ac47d !important;">Accepted</p>
                                            @elseif($v->status == 4)
                                            <p class="ll blur-color" style="color: red !important;">Rejected</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="active-jobs-dash">
                        <div class="active-job-head">
                            <h6>Similar Jobs</h6>
                            <a href="{{route('candidateJobs','similar')}}">View All</a>
                        </div>
                        <span class="full-hr"></span>
                        @include('frontend.candidate.dashboard.components.similar-jobs')
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-3">
                    <div class="dashboard-sidebar">
                        @include('frontend.candidate.dashboard.components.getting-started')
                        @include('frontend.candidate.dashboard.components.updates')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.components.delete-confirm',['title'=>'Confirm','message'=>'Are you sure?'])
@endsection
@section('footscript')
<script type="text/javascript">
    $(document).on("click", ".makeFavourite", function(e) {
        var jobId = $(this).attr('data-job-id');
        $.ajax({
            url: "{{ url('/candidate-jobs/make-favorite') }}",
            type: "POST",
            data: {
                jobId: jobId,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.message);
            },
        });
    });

    $(document).on('submit', '.applyNowCandidate', function(e) {
        e.preventDefault();
        var formAcion = $(this).attr('action')
        var title = "confirm";
        var message = "Are you sure?";
        $("#ConfirmModel #deleteConfirmed").attr("action", formAcion);
        $("#ConfirmModel").modal('show');
    })
</script>
@endsection