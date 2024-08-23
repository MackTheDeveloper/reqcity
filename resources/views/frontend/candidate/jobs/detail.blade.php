@section('title', 'Recruiter Jobs')
@extends('frontend.layouts.master')
@section('content')
    <div class="recruiter-job-details">
        <div class="container">
            <div class="row">
                <div class="order-2 order-xl-1 col-lg-12 col-xl-9">
                    <div class="req-job-header">
                        <a href="{{ route('recruiteryJobs', 'all') }}" class="back-to-link bm"><img
                                src="{{ asset('public/assets/frontend/img/arrow-left.svg') }}" alt="" />Back to all
                            jobs</a>
                        <p class="tl">{{ $model->title }}</p>
                        <p class="ts blur-color">{{ $model->company->name }}</p>
                        <p class="ts blur-color">{{ $model->company->address->city }},
                            {{ $model->company->address->countries->name }}</p>
                        @if ($model->to_salary)
                            <p class="ll">${{ $model->from_salary }} - ${{ $model->to_salary }} a year</p>
                        @else
                            <p class="ll">${{ $model->from_salary }} a year</p>
                        @endif
                        {{-- <p class="ll">$62,339 - $81,338 a year</p> --}}
                        <span class="bs blur-color">{{ getFormatedDateForWeb($model->created_at) }}</span>

                        <hr class="hr">

                        <div class="candidates">
                            <p class="tl">Candidates</p>
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                    <div class="candidates-box">
                                        <h5>{{ $modelCounts['total'] }}</h5>
                                        <p class="tm blur-color">Total candidates</p>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                    <div class="candidates-box">
                                        <h5>{{ $modelCounts['approved'] }}</h5>
                                        <p class="tm blur-color">Approved</p>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                    <div class="candidates-box">
                                        <h5>{{ $modelCounts['rejected'] }} of {{ $modelCounts['total'] }}</h5>
                                        <p class="tm blur-color">Rejected</p>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                    <div class="candidates-box">
                                        <h5>${{ number_format($modelPayout, 2) }}</h5>
                                        <p class="tm blur-color">Payout</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="req-applied-candidate">
                        <div class="rac-header">
                            <p class="tl">Applied Candidates</p>
                        </div>
                        <div class="rac-table-wrapper">
                            <div class="rac-table">
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
                                        <p class="ll blur-color">Action</p>
                                    </div>
                                </div>
                                @foreach ($modelCandidates as $key => $value)
                                    <div class="rac-row">
                                        <div class="rac-column">
                                            <div class="tag-box">
                                                <p class="tm">{{ $value['name'] }}</p>
                                                @if ($value['is_diverse_candidate'])
                                                    <div class="diversity">Diversity</div>
                                                @endif
                                            </div>
                                            <span class="ts blur-color">{{ $value['address'] }}</span>
                                        </div>
                                        <div class="rac-column">
                                            <p class="bm">{{ $value['status'] }}</p>
                                            <span class="bs blur-color">Applied
                                                {{ getFormatedDateForWeb($value['created_at']) }}</span>
                                        </div>
                                        <div class="rac-column">
                                            <p class="bm">{{ $value['experience_title'] }}</p>
                                            <span class="bs blur-color">{{ $value['experience'] }}</span>
                                        </div>
                                        <div class="rac-column">
                                            <label class="bm">{{ $value['email'] }}</label>
                                            <span class="bm">{{ $value['phone'] }}</span>
                                        </div>
                                        <div class="rac-column">
                                            @if ($value['latest_cv'])
                                                <a href="{{ $value['latest_cv'] }}" class="pdf-link"
                                                    target="_blank">
                                                    <img src="{{ asset('public/assets/frontend/img/pdf.svg') }}"
                                                        alt="" />
                                                </a>
                                            @endif
                                        </div>
                                        <div class="rac-column">
                                            <div class="flex-apply">
                                                <div class="view-icon-block">
                                                    <a href="javascript:void(0)" class="icon-btns view_candidate"
                                                        data-id="{{ $value['id'] }}">
                                                        <img src="{{ asset('public/assets/frontend/img/view-icon.svg') }}"
                                                            alt="" />
                                                    </a>
                                                </div>
                                                <a href="{{ $value['linkedin_profile'] }}" class="linkdin-btns"
                                                    target="_blank">
                                                    <img src="{{ asset('public/assets/frontend/img/Linkedin-btn.svg') }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="req-job-descripation">
                        <div class="jd-header">
                            <p class="tl">Job Description</p>
                            <p class="bm">{!! $model->job_short_description !!}</p>
                            {{-- <p class="bm">Nutrify, Inc. is looking for JavaScript developers to join its technical team’s expansion. The ideal candidate will be based in San Francisco, CA.</p> --}}
                        </div>
                        {!! $model->job_description !!}
                        {{-- <div class="question-item">
                            <p class="tm">What we are looking for?</p>
                            <ul>
                                <li>At least 1 year experience in working as a Javascript developer.</li>
                                <li>Knowledge of client-side technologies (HTML/CSS/Javascript)</li>
                                <li>Experience in working with jQuery library</li>
                                <li>Basic understanding of Git version control</li>
                                <li>Basic understanding of the usage of REST APIs</li>
                                <li>Fast learner (and willing to learn a lot)</li>
                                <li>You love web development</li>
                                <li>Programming experience (any language)</li>
                                <li>You are proactive team player with good written and spoken English skills</li>
                                <li>You are curious and like to understand how things work</li>
                                <li>Relevant university degree or training in computer science or software development</li>
                            </ul>
                        </div>

                        <div class="question-item">
                            <p class="tm">Job functions</p>
                            <ul>
                                <li>Optimize applications for maximum speed and scalability.</li>
                                <li>Collaborate with other team members and stakeholders.</li>
                                <li>Contribute to team development and initiatives.</li>
                                <li>Occasionally assist the UI Developer with enhanced Javascript functionality as needed.
                                </li>
                            </ul>
                        </div>

                        <div class="question-item">
                            <p class="tm">Job requirements</p>
                            <ul>
                                <li>Strong English language skills.</li>
                                <li>Excellent communication skills, including verbal, written, and presentation.</li>
                            </ul>
                        </div> --}}

                        <table class="table-content-data">
                            <tr>
                                <td>Employment type</td>
                                <td>{{ $extra['employmentType'] }}</td>
                            </tr>
                            <tr>
                                <td>Schedule</td>
                                <td>{{ $extra['schedule'] }}</td>
                            </tr>
                            <tr>
                                <td>Contract type</td>
                                <td>{{ $extra['contractType'] }}</td>
                            </tr>
                            <tr>
                                <td>Contract duration</td>
                                <td>{{ $model->contract_duration . ' ' . ($model->contract_duration_type == 1 ? 'months' : 'years') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Remote work</td>
                                <td>{{ $extra['remoteWork'] }}</td>
                            </tr>
                        </table>
                        @if (!empty($faq))
                            <div class="frequent-question">
                                <p class="tl">Frequently asked questions</p>
                                @foreach ($faq as $key => $value)
                                    <div class="que-ans">
                                        <p class="tm">{{ $value['question'] }}</p>
                                        <span class="bm">{{ $value['answer'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </div>
                <div class="order-1 order-xl-2 col-lg-12 col-xl-3">
                    <div class="req-job-post-box">
                        <div class="job-post-status">
                            <a href="{{ route('recruiterCandidateSubmitStart', $model->slug) }}"
                                class="fill-btn">Submit Candidate</a>
                            <label class="bk">
                                <input type="checkbox" class="makeFavourite"
                                    {{ $extra['isFavourite'] ? 'checked' : '' }} />
                                <span class="bk-checkmark"></span>
                            </label>
                        </div>
                        <hr class="hr">
                        <table class="table-content-data last-blur">
                            <tr>
                                <td>Applicants</td>
                                <td>{{ $modelCounts['total'] }}</td>
                            </tr>
                            <tr>
                                <td>Approved</td>
                                <td>{{ $modelCounts['approved'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-structure candidate-info-popup" id="candidateInfo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection
@section('footscript')
    <script type="text/javascript">
        $(document).on("change", ".makeFavourite", function(e) {
            var jobId = '{{ $model->id }}';
            $.ajax({
                url: "{{ url('/recruiter-jobs/make-favorite') }}",
                type: "POST",
                data: {
                    jobId: jobId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.message);
                },
            });
        });
        $(document).on("click", ".view_candidate", function(e) {
            var candidateId = $(this).data('id');
            var jobId = '{{ $model->id }}';
            $('#candidateInfo').modal('show');
            var url = "{{url('recruiter-candidate-application-detail/')}}/"+candidateId+'/'+jobId
            $.get(url, function(data, status) {
                // alert("Data: " + data + "\nStatus: " + status);
                $('#candidateInfo .modal-content').html(data);
                $('#candidateInfo').modal('show');
            });
        });
    </script>
@endsection
