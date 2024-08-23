@extends('admin.layouts.master')
<title>Candidate Submit 1</title>
@section('content')
    <style type="text/css">
        .cloneAppend .can_clone:not(:last-child)>div:last-child {
            border-bottom: 1px solid #cccccc;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .cloneAppend .can_clone:only-child .close-section {
            display: none;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/jquery.ccpicker.css') }}">
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
                                        <i class="fa pe-7s-portfolio"></i>
                                    </span>
                                    <span class="d-inline-block">Categories</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{route('adminDashboard')}}">
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page" style="color: slategray">
                                                Candidate Submit
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="process-progress">
                    <div class="info-progress done">
                        <div class="numbers">1</div>
                        <p class="tm">Candidate Details</p>
                    </div>
                    <div class="info-progress done">
                        <div class="numbers">2</div>
                        <p class="tm">Questionnaire</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">3</div>
                        <p class="tm">Review Submittal</p>
                    </div>
                </div>


                <div class="parent-header">
                    <h4 class="form-title-text">Review Submittal</h4>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title-wrapper">
                            <h5 class="card-title">Contact information</h5>
                            <button type="submit" class="btn btn-primary plr-16 view-job"
                                data-job-id="{{ $companyJob->id }}">View Details</button>
                        </div>
                        <form action="{{ route('postCandidateSubmitReview') }}" method="POST" enctype="multipart/form-data"
                            id="candidateSubmitStepOne">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">First name</label>
                                        <div>
                                            <span>{{ $model->first_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Last name</label>
                                        <div>
                                            <span>{{ $model->last_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Phone Number</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <span>{{ $model->phone_ext . ' ' . $model->phone }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <span>{{ $model->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <p>Contact information will be hidden from company until they pay for qualified
                                            applicants.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Country</label>
                                        <div>
                                            <span>{{ $model->countrydata->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">City</label>
                                        <div>
                                            <span>{{ $model->city }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if ($model->is_diverse_candidate)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="diversity-labels">
                                                <span>Diversity</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- @php(pre($modelCv->toArray())) --}}
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Resume</label>
                                        @if($modelCv)
                                        <div class="uploaded-resume">
                                            <a href="{{ $modelCv->resume }}" target="_blank" class="a-img-wrapper">
                                                <img src="{{ asset('public/assets/frontend/img/pdf-orange.svg') }}"
                                                    alt="" />
                                            </a>
                                            <p>CV Version {{ $modelCv->version_num }}</p>
                                        </div>
                                        @else
                                        <div class="uploaded-resume">
                                            No resume uploaded
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">LinkedIn</label>
                                        <div>
                                            <span><a href="{{ $model->linkedin_profile_link }}"
                                                    target="_blank">{{ $model->linkedin_profile_link ? $model->linkedin_profile_link : '-' }}</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h5 class="card-title mb-4">Employer questions</h5>
                            <div class="row">
                                @foreach ($templateQuestions as $key => $value)
                                    @php($val = !empty($questionnaire['templateQuestions'][$value->id]) ? $questionnaire['templateQuestions'][$value->id] : '')
                                    @php($val = gettype($val) == 'array' ? implode(',',$val) : $val)
                                    @if($val)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ $value->question }}</label>
                                            <div>
                                                @if (in_array($types[$value->question_type]['type'], ['upload document', 'upload image']))
                                                    <span><a href="{{ $val }}">Click Here</a> to download or
                                                        view.</span>
                                                @else
                                                    <span>{{ $val }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @foreach ($extraQuestions as $key => $value)
                                    @php($val = !empty($questionnaire['extraQuestions'][$value->id]) ? $questionnaire['extraQuestions'][$value->id] : '')
                                    @php($val = gettype($val) == 'array' ? implode(',',$val) : $val)
                                    @if($val)
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ $value->question }}</label>
                                            <div>
                                                @if (in_array($types[$value->question_type]['type'], ['upload document', 'upload image']))
                                                    <span><a href="{{ $val }}">Click Here</a> to download or
                                                        view.</span>
                                                @else
                                                    <span>{{ $val }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <a href="{{route('getJobQuestionnaire')}}">
                                            <button type="button" class="btn btn-light" name="cancel"
                                                value="Cancel">Back</button>
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="add_pkg_btn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            @include('admin.include.footer')
        </div>
    </div>
@endsection
@section('modals-content')
    @include('admin.components.modal-layout',['modalId'=>'viewDetailModal','modalClass'=>'view-detail-modal'])
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on('click', '.view-job', function() {
            // $('#jobDescription').modal('show');
            var jobId = $(this).data('job-id');
            var url = "{{ url('securerccontrol/candidate-jobs/job-detail/') }}/" + jobId
            $.get(url, function(data, status) {
                $('#viewDetailModal .modal-content').html(data);
                $('#viewDetailModal').modal('show');
            });
        });
    </script>
@endpush
