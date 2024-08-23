@section('title','Company Candidates')
@extends('frontend.layouts.master')
@section('content')
<div class="company-candidates">
    <div class="container">
        <div class="job-title-section">
            <div class="input-groups">
                <span>Job title</span>
                <select id="job-id">
                    @foreach($jobs as $job)
                    <option value="{{$job->id}}">{{$job->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="tab-wrapper">
        <div class="container">
            <div class="tab-section" id="navbar-example2">
                <ul>
                    <li><a data="" class="tab-link" id="pending-tab">Pending</a></li>
                    <li><a data="" class="tab-link" id="approved-tab">Approved</a></li>
                    <li><a data="" class="tab-link" id="reject-tab">Rejected</a></li>
                    <li><a data="" class="tab-link" id="all-tab">All</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="candidate-wrapper">
            <div class="job-header">
                <div class="searchbar-btn">
                    <input type="text" class="input" id="search" placeholder="Search for Candidates" />
                    <button class="search-btn"><img src="{{asset('public/assets/frontend/img/white-search.svg')}}" alt="" id="search-btn" /></button>
                </div>
                <div class="sort-by-sec">
                    <p class="bm">Sort by</p>
                    <select class="select" id="posted">
                        <option value="recently">Recently Posted</option>
                        <option value="old">Old Posted</option>
                    </select>
                </div>
            </div>

            <div class="rac-table-wrapper">
                <div class="rac-table" id="magTable">
                    <div class="rac-row">
                        <div class="rac-column">
                            <p class="ll blur-color">Name</p>
                        </div>
                        <div class="rac-column">
                            <p class="ll blur-color">Status</p>
                        </div>
                        <div class="rac-column">
                            <p class="ll blur-color">Recent Experience</p>
                        </div>
                        <div class="rac-column">
                            <p class="ll blur-color">Contact Information</p>
                        </div>
                        <div class="rac-column">
                            <p class="ll blur-color">Resume</p>
                        </div>
                        <div class="rac-column">
                            <p class="ll blur-color action-header">Action <img src="{{asset('public/assets/frontend/img/info-circle.svg')}}" alt="" class="info-icon" /></p>
                        </div>
                    </div>
                    {{--<div class="rac-row">
                        <div class="rac-column">
                            <div class="tag-box">
                                <p class="tm">Harper Lee</p>
                                <div class="diversity">Diversity</div>
                            </div>
                            <span class="ts blur-color">San Francisco, CA</span>
                        </div>
                        <div class="rac-column">
                            <p class="bm">Pending</p>
                            <span class="bs blur-color">Applied 12 Nov</span>
                        </div>
                        <div class="rac-column">
                            <p class="bm">Javascript Developer</p>
                            <span class="bs blur-color">Inforus | July 2019 - Present</span>
                        </div>
                        <div class="rac-column">
                            <label class="bm">candidate@domain.com</label>
                            <span class="bm">+1 123 456 7890</span>
                        </div>
                        <div class="rac-column">
                            <a href="home-page.PDF" class="pdf-link" target="_blank">
                                <img src="assets/img/pdf.svg" alt="" />
                            </a>
                        </div>
                        <div class="rac-column">
                            <div class="flex-apply">
                                <div class="view-icon-block">
                                    <a href="javascript:void(0)" class="icon-btns" data-toggle="modal" data-target="#candidateInfo">
                                        <img src="assets/img/view-icon.svg" alt="" />
                                    </a>
                                    <a href="" class="icon-btns">
                                        <img src="assets/img/yes-sign.svg" alt="" />
                                    </a>
                                    <a href="javascript:void(0)" class="icon-btns" data-toggle="modal" data-target="#rejectCandidate">
                                        <img src="assets/img/not-sign.svg" alt="" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rac-row">
                        <div class="rac-column">
                            <div class="tag-box">
                                <div class="diversity">Diversity</div>
                            </div>

                            <span class="ts blur-color">San Francisco, CA</span>
                        </div>
                        <div class="rac-column">
                            <p class="bm">Rejected</p>
                            <span class="bs blur-color">Applied 12 Nov</span>
                        </div>
                        <div class="rac-column">
                            <p class="bm">Javascript Developer</p>
                            <span class="bs blur-color">Inforus | July 2019 - Present</span>
                        </div>
                        <div class="rac-column">
                            <label class="bm">candidate@domain.com</label>
                            <span class="bm">+1 123 456 7890</span>
                        </div>
                        <div class="rac-column">
                            <a href="home-page.PDF" class="pdf-link" target="_blank">
                                <img src="assets/img/pdf.svg" alt="" />
                            </a>
                        </div>
                        <div class="rac-column">
                            <div class="flex-apply">
                                <div class="view-icon-block">
                                    <a href="" class="icon-btns">
                                        <img src="assets/img/view-icon.svg" alt="" />
                                    </a>
                                </div>
                                <a href="" class="linkdin-btns">
                                    <img src="assets/img/Linkedin-btn.svg" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.company.candidate.components.reject-modal')
@include('frontend.company.candidate.components.view-modal')
@include('frontend.company.candidate.components.alert-modal')
@endsection
@section('footscript')
<script type="text/javascript" src=""></script>
<script src="{{ asset('/public/assets/frontend/js/magTable.js') }}"></script>
<script type="text/javascript">
    var status = "";
    $(document).ready(function() {
        const params = new URLSearchParams(window.location.search);
        var jobId = $('#job-id').val();
        if(params.has('jobid')){
            jobId = params.get('jobid');
            $('#job-id').val(jobId);
        }
        var posted = $('#posted').val();
        $("#all-tab").addClass("active");
        candidateList(jobId,posted);
    });
    $(document).on('click','#all-tab',function(){
        $('.tab-link').removeClass('active');
        $("#all-tab").addClass("active");
        var search = $('#search').val();
        var jobId = $('#job-id').val();
        var posted = $('#posted').val();
        candidateList(jobId,posted,search,status="");
        status = "";
    });
    $(document).on('click','#reject-tab',function(){
        $('.tab-link').removeClass('active');
        $("#reject-tab").addClass("active");
        var search = $('#search').val();
        var jobId = $('#job-id').val();
        var posted = $('#posted').val();
        candidateList(jobId,posted,search,status=4);
        status = 4;
    });
    $(document).on('click','#approved-tab',function(){
        $('.tab-link').removeClass('active');
        $("#approved-tab").addClass("active");
        var search = $('#search').val();
        var jobId = $('#job-id').val();
        var posted = $('#posted').val();
        candidateList(jobId,posted,search,status=3);
        status = 3;
    });
    $(document).on('click','#pending-tab',function(){
        $('.tab-link').removeClass('active');
        $("#pending-tab").addClass("active");
        var search = $('#search').val();
        var jobId = $('#job-id').val();
        var posted = $('#posted').val();
        candidateList(jobId,posted,search,status=1);
        status = 1;
    });
    $(document).on('change','#job-id',function(){
        var search = $('#search').val();
        var jobId = this.value;
        var posted = $('#posted').val();
        candidateList(jobId,posted,search,status);
    });
    $(document).on('change','#posted',function(){
        var jobId = $('#job-id').val();
        var search = $('#search').val();
        var posted = this.value;
        candidateList(jobId,posted,search,status);
    });
    $(document).on('click','#search-btn',function(){
        var jobId = $('#job-id').val();
        var posted = $('#posted').val();
        var search = $('#search').val();
        candidateList(jobId,posted,search,status);
    });
    
    $(document).on('change keydown', '#search', function(e) {
        if(e.keyCode === 13) {
            var jobId = $('#job-id').val();
            var posted = $('#posted').val();
            var search = $('#search').val();
            candidateList(jobId,posted,search,status);
        }
    });
    
    function candidateList(jobId = '', posted = '' ,search = '' ,status = '') {
        $('#magTable').magTable({
            ajax: {
                "url": "{{ route('showCompanyCandidateList') }}",
                "type": "GET",
                "data": {
                    "jobId": jobId,
                    "posted": posted,
                    "search": search,
                    "status": status,
                }
            },
            columns: [{
                    data: 'name',
                    name: 'name',
                    render: function(data) {
                        if (data["diverse"] == 1) {
                            return '<div class="tag-box">' +
                                '<p class="tm">' + data["name"] + '</p>' +
                                '<div class="diversity">Diversity</div>' +
                                '</div>' +
                                '<span class="ts blur-color">' + data["city"] + ',' + data["state"] + '</span>';
                        } else {
                            return '<div class="tag-box">' +
                                '<p class="tm">' + data["name"] + '</p>' +
                                '</div>' +
                                '<span class="ts blur-color">' + data["city"] + ',' + data["state"] + '</span>';
                        }
                    },
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        return '<p class="bm">' + data["status"] + '</p>' +
                            '<span class="bs blur-color">' + data["created_at"] + '</span>';
                    },
                },
                {
                    data: 'experience',
                    name: 'experience',
                    render: function(data) {
                        if(data["reason"]){
                            return '<p class="bm">' + data["title"] + '</p>' +
                            '<span class="bs blur-color">' + data["reason"]+ '</span>';
                        }else{
                            if(data["title"]){
                                return '<p class="bm">' + data["title"] + '</p>' +
                                '<span class="bs blur-color">' + data["company"] + '|' + data['exp'] + '</span>';
                            }else{
                                return "-";
                            }
                        }
                    },
                },
                {
                    data: 'contactInfo',
                    name: 'contactInfo',
                    render: function(data) {
                        return '<p class="bm">' + data["email"] + '</p>' +
                            '<span class="bs blur-color">' + data["phone"] + '</span>';
                    },
                },
                {
                    data: 'resume',
                    name: 'resume',
                    render: function(data) {
                        if (data["resume"] != "") {
                            return '<a href="' + data["resume"] + '" class="pdf-link" download>' +
                                '<img src="{{asset("public/assets/frontend/img/pdf.svg")}}" alt="" />' +
                                '</a>';
                        } else {
                            return "";
                        }
                    },
                },
                {
                    data: 'action',
                    name: 'action',
                    render: function(data) {
                        return data["action"];
                    },
                },
            ]
        })
    }

    $(document).on('click', '#reject-candidate', function() {
        var id = $(this).data('id');
        $('#application-id').val(id);
    });

    $("#reject-form").validate({
        ignore: [],
        rules: {
            reason: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
    });
    
    $(document).on('click', '#view-candidate', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('viewCandidate') }}",
            type: "GET",
            data: {
                'id': id,
            },
            dataType: "html",
            success: function(response) {
                $('#candidateInfo .modal-content').html(response);
                $('#candidateInfo').modal('show');
                initModal();
            }
        });
    });

    $(document).on('click', '#approve-candidate', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('checkJobBalance') }}",
            type: "GET",
            data: {
                'id': id,
            },
            dataType: "html",
            success: function(response) {
                $('#ConfirmModel .modal-content').html(response);
                $('#ConfirmModel').modal('show');
                // initModal();
            }
        });
    });
</script>
@endsection