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
                    <div class="info-progress ">
                        <div class="numbers">1</div>
                        <p class="tm">Candidate Details</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">2</div>
                        <p class="tm">Questionnaire</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">3</div>
                        <p class="tm">Review Submittal</p>
                    </div>
                </div>


                <h4 class="form-title-text">Candidate Submittal</h4>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title-wrapper">
                            <h5 class="card-title">Candidate info</h5>
                            <button type="submit" class="btn btn-primary plr-16 view-job"
                                data-job-id="{{ $assignedJob->company_job_id }}">View Details</button>
                        </div>
                        <form action="{{ route('postCandidateSubmit') }}" method="POST" enctype="multipart/form-data"
                            id="candidateSubmitStepOne">
                            @csrf
                            <input type="hidden" name="candidate[id]" value="{{ $model->id }}" />
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">First name</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter First Name"
                                                value="{{ $model->first_name }}" name="candidate[first_name]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Last name</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter Last name"
                                                value="{{ $model->last_name }}" name="candidate[last_name]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Phone Number</label>
                                        <span class="text-danger">*</span>
                                        <div class="phone-field-wrapper">
                                            <input type="hidden" id="phoneField1" class="phone-field"
                                                value="{{ $model->phone_ext }}" />
                                            {{-- <input type="text" id="phoneField1" name="phoneField1"
                                                class="phone-field form-control" placeholder="Enter Phone Number" /> --}}
                                            <input type="number" class="phone-field form-control" name="candidate[phone]"
                                                value="{{ $model->phone }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter Email"
                                                name="candidate[email]" value="{{ $model->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Country
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <select name="candidate[country]" class="form-control">
                                                @foreach ($countries as $items)
                                                    <option
                                                        {{ !empty($model->id) && $model->country == $items['key'] ? 'selected="selected"' : '' }}
                                                        value="{{ $items['key'] }}">{{ $items['value'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">City</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter City"
                                                name="candidate[city]" value="{{ $model->city }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 ck-section">
                                    <label class="ck">Diversity
                                        <input type="checkbox" id="remember"
                                            name="candidate[is_diverse_candidate]" value="1"
                                            {{ $model->is_diverse_candidate ? 'checked' : '' }}>
                                        <span class="ck-mark"></span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label class="font-weight-bold color-blur">Upload resume</label>
                                    <div class="upload-form-btn2">
                                        <input type="file" id="upload-form-file" hidden="hidden" name="candidate_cv[cv]" />
                                        <img src="{{ asset('public/assets/frontend/img/upload-icon.svg') }}"
                                            id="upload-form-img" alt="" />
                                        <div>
                                            <p class="tm" id="upload-form-text">Upload resume</p>
                                            <span class="bs blur-color">Use a pdf, docx, doc, rtf and
                                                txt</span>
                                            @php($requiredCv = 1)
                                            @if ($modelCv && $modelCv->resume)
                                            @php($requiredCv = 0)
                                                <p><a target="_blank" href="{{ $modelCv->resume }}">Download CV Version
                                                        {{ $modelCv->version_num }}</a></p>
                                            @endif
                                            <input type="hidden" class="hidden_cv" value="{{ $requiredCv }}" />
                                        </div>
                                    </div>
                                    <label id="" class="error" for="upload-form-file"></label>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="font-weight-bold color-blur">LinkedIn</label>
                                    <div class="form-group">
                                        <label class="font-weight-bold">LinkedIn profile link</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="url" pattern="https://.*" class="form-control"
                                                placeholder="Enter LinkedIn profile link"
                                                name="candidate[linkedin_profile_link]"
                                                value="{{ $model->linkedin_profile_link }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <label class="font-weight-bold color-blur mb-16">Candidate experience</label>
                                </div>

                                <div class="cloneAppend col-12">
                                    @if (!empty($candidateExp))
                                        @foreach ($candidateExp as $key => $item)
                                            <div class="can_clone row" counter="{{ $key }}">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)" class="close-section pull-right">
                                                        <img src="{{ asset('public/assets/frontend/img/close.svg') }}"
                                                            alt="" />
                                                    </a>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Job Title</label>
                                                        <span class="text-danger">*</span>
                                                        <div>
                                                            <input type="text" class="form-control"
                                                                placeholder="Enter Job Title"
                                                                name="candidate_exp[{{ $key }}][job_title]"
                                                                value="{{ $item['job_title'] }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Company</label>
                                                        <span class="text-danger">*</span>
                                                        <div>
                                                            <input type="text" class="form-control"
                                                                placeholder="Enter Company"
                                                                name="candidate_exp[{{ $key }}][company]"
                                                                value="{{ $item['company'] }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">Start year
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div>
                                                                    <input type="hidden" value="{{ (!empty($item['start_month']))?$item['start_month']:'1'}}" name="candidate_exp[0][start_month]">
                                                                    <select
                                                                        name="candidate_exp[{{ $key }}][start_year]"
                                                                        class="exp_date start_year form-control">
                                                                        <option value="">Select Year</option>
                                                                        @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                                            <option
                                                                                {{ $item['start_year'] == $i ? 'selected="selected"' : '' }}
                                                                                value="{{ $i }}">
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">Start month
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div>
                                                                    <select
                                                                        name="candidate_exp[{{ $key }}][start_month]"
                                                                        class="exp_date start_month form-control">
                                                                        <option value="">Select Month</option>
                                                                        @foreach ($month as $keys => $items)
                                                                            <option
                                                                                {{ $item['start_month'] == $keys ? 'selected="selected"' : '' }}
                                                                                value="{{ $keys }}">
                                                                                {{ $items }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">End year
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div>
                                                                    <input type="hidden" value="{{ (!empty($item['end_month']))?$item['end_month']:'1'}}" name="candidate_exp[0][end_month]">
                                                                    <select
                                                                        name="candidate_exp[{{ $key }}][end_year]"
                                                                        class="exp_date end_year form-control" {{(isset($item['is_current_working']) && $item['is_current_working'] == '1')?'disabled':''}}>
                                                                        <option value="">Select Year</option>
                                                                        @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                                            <option
                                                                                {{ (!empty($item['end_year']) && $item['end_year'] == $i) ? 'selected="selected"' : '' }}
                                                                                value="{{ $i }}">
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">End month
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div>
                                                                    <select
                                                                        name="candidate_exp[{{ $key }}][end_month]"
                                                                        class="exp_date end_month form-control" {{(isset($item['is_current_working']) && $item['is_current_working'] == '1')?'disabled':''}}>
                                                                        <option value="">Select Month</option>
                                                                        @foreach ($month as $keys => $items)
                                                                            <option
                                                                                {{ (!empty($item['end_month']) && $item['end_month'] == $keys) ? 'selected="selected"' : '' }}
                                                                                value="{{ $keys }}">
                                                                                {{ $items }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Job Responsibilities
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div>
                                                            <textarea
                                                                name="candidate_exp[{{ $key }}][job_responsibilities]"
                                                                class="form-control"
                                                                placeholder="Enter Job Title">{{ $item['job_responsibilities'] }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12 ck-section">
                                                    <label class="ck">I am currently working in this role
                                                        <input type="checkbox" checked="checked" value="1"
                                                            class="is_current_working"
                                                            {{(isset($item['is_current_working']) && $item['is_current_working'])?"checked":""}}
                                                            name="candidate_exp[{{ $key }}][is_current_working]">
                                                        <span class="ck-mark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="can_clone row" counter="0">
                                            <div class="col-sm-12">
                                                <a href="javascript:void(0)" class="close-section pull-right">
                                                    <img src="{{ asset('public/assets/frontend/img/close.svg') }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Job Title</label>
                                                    <span class="text-danger">*</span>
                                                    <div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Job Title"
                                                            name="candidate_exp[0][job_title]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Company</label>
                                                    <span class="text-danger">*</span>
                                                    <div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Company" name="candidate_exp[0][company]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Start year
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div>
                                                                <input type="hidden" value="1" name="candidate_exp[0][start_month]">
                                                                <select name="candidate_exp[0][start_year]"
                                                                    class="exp_date start_year form-control">
                                                                    <option value="">Select Year</option>
                                                                    @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Start month
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div>
                                                                <select name="candidate_exp[0][start_month]"
                                                                    class="exp_date start_month form-control">
                                                                    <option value="">Select Month</option>
                                                                    @foreach ($month as $keys => $items)
                                                                        <option value="{{ $keys }}">
                                                                            {{ $items }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">End year
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div>
                                                                <input type="hidden" value="1" name="candidate_exp[0][end_month]">
                                                                <select name="candidate_exp[0][end_year]"
                                                                    class="exp_date end_year form-control">
                                                                    <option value="">Select Year</option>
                                                                    @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">End month
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div>
                                                                <select name="candidate_exp[0][end_month]"
                                                                    class="exp_date end_month form-control">
                                                                    <option value="">Select Month</option>
                                                                    @foreach ($month as $keys => $items)
                                                                        <option value="{{ $keys }}">
                                                                            {{ $items }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Job Responsibilities
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div>
                                                        <textarea name="candidate_exp[0][job_responsibilities]"
                                                            class="form-control"
                                                            placeholder="Enter Job Title"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-12 ck-section">
                                                <label class="ck">I am currently working in this role
                                                    <input type="checkbox" value="1"
                                                        class="is_current_working"
                                                        name="candidate_exp[0][is_current_working]">
                                                    <span class="ck-mark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-12 text-right">
                                    <button type="button" class="blue-btn add-experience"><img
                                            src="{{ asset('public/assets/frontend/img/blue-plus.svg') }}" alt="">Add
                                        experience</button>
                                </div>
                                <div class="col-sm-12 add-pad-top">
                                    <div class="form-group">
                                        <a href="{{ route('assignedJobListing') }}">
                                            <button type="button" class="btn btn-light" name="cancel"
                                                value="Cancel">Back</button>
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="add_pkg_btn">Continue</button>
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
    @include('admin.components.modal-layout', [
        'modalId' => 'viewDetailModal',
        'modalClass' => 'view-detail-modal',
    ])
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/frontend/js/jquery.ccpicker.js') }}"
        data-json-path="{{ asset('public/assets/frontend/data.json') }}"></script>
    <script>
        $("#phoneField1").CcPicker();
        if ($('#phoneField1').val() != '') {
            $("#phoneField1").CcPicker("setCountryByPhoneCode", $('#phoneField1').val());
        }


        const uploadFormFile = document.getElementById("upload-form-file");
        const uploadFormImg = document.getElementById("upload-form-img");
        const uploadFormText = document.getElementById("upload-form-text");

        uploadFormImg.addEventListener("click", function() {
            uploadFormFile.click();
        });

        uploadFormFile.addEventListener("change", function() {
            if (uploadFormFile.value) {
                uploadFormText.innerHTML = uploadFormFile.value.match(
                    /[\/\\]([\w\d\s\.\-\(\)]+)$/
                )[1];
            } else {
                uploadFormText.innerHTML = "No file chosen, yet.";
            }
            var validateIcon = $('#candidateSubmitStepOne').validate().element(':input[name="candidate_cv[cv]"]');
            if (!validateIcon)
                return false;
        });
        $(document).on('click', '.view-job', function() {
            // $('#jobDescription').modal('show');
            var jobId = $(this).data('job-id');
            var url = "{{ url('securerccontrol/candidate-jobs/job-detail/') }}/" + jobId
            $.get(url, function(data, status) {
                $('#viewDetailModal .modal-content').html(data);
                $('#viewDetailModal').modal('show');
            });
        });

        $(document).on('click', '.add-experience', function() {
            var clonned = $('.can_clone:last').clone();
            var old = clonned.attr('counter');
            var ids = parseInt(old) + 1;
            // replaces
            clonned.attr('counter', ids);
            // text.replace(/B/g, match => ++t === 2 ? 'Z' : match)
            var oldVal = '[' + old + ']';
            var newVal = '[' + ids + ']';
            clonned.find('input[type="text"]').each(function() {
                $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('');
            })
            clonned.find('select').each(function() {
                $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('');
            })
            clonned.find('textarea').each(function() {
                $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('');
            })
            clonned.find('input[type="checkbox"]').each(function() {
                $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).prop('selected', false);
            })
            clonned.find('.exp_date option').prop('disabled', false);
            $('.cloneAppend').append(clonned);
            validateForm();
        }).on('click', '.close-section', function(e) {
            if ($(this).closest('.can_clone').siblings().length) {
                $(this).closest('.can_clone').remove();
            }
        });

        $(document).on('change', '.exp_date', function() {
            var counter = $(this).closest('.can_clone').attr('counter');
            setFromToExp(counter);
        });

        function checkEachStartEnd() {
            $('.can_clone').each(function() {
                var counter = $(this).attr('counter');
                setFromToExp(counter);
            })
        }

        function setFromToExp(counter) {
            var clonnedDiv = $('.can_clone[counter="' + counter + '"]');
            var startYear = clonnedDiv.find('.start_year');
            var startMonth = clonnedDiv.find('.start_month');
            var endYear = clonnedDiv.find('.end_year');
            var endMonth = clonnedDiv.find('.end_month');
            endYear.find('option').prop('disabled', false);
            endMonth.find('option').prop('disabled', false);
            startMonth.find('option').prop('disabled', false);

            year = startYear.val()
            if (year) {
                endYear.find('option').filter(function() {
                    return $(this).val() < year;
                }).prop('disabled', true);
            }

            let currentYear = new Date().getFullYear();
            let currentMonth = parseInt(new Date().getMonth()) + 1;
            month = startMonth.val()
            if (year == currentYear) {
                console.log('start is today')
                startMonth.find('option').filter(function() {
                    return parseInt($(this).val()) > currentMonth;
                }).prop('disabled', true);

            }
            if (endYear.val() == currentYear) {
                console.log('end is today')
                // currentMonth = (start_Month.val() < currentMonth)?start_Month.val():currentMonth;
                endMonth.find('option').filter(function() {
                    return parseInt($(this).val()) > currentMonth;
                }).prop('disabled', true);
            }
            if (endYear.val() == year) {
                console.log('end is start')
                // currentMonth = (startMonth.val() > currentMonth)?startMonth.val():currentMonth;
                currentMonth = startMonth.val();
                endMonth.find('option').filter(function() {
                    return parseInt($(this).val()) < currentMonth;
                }).prop('disabled', true);
                if (endMonth.val() < startMonth.val()) {
                    endMonth.val('')
                }
            }
            if (endYear.val() < year) {
                endYear.val('')
            }
        }

        $("#candidateSubmitStepOne").validate({
            ignore: [],
            //ignore: ":hidden",
            rules: {
                "candidate[first_name]": "required",
                "candidate[last_name]": "required",
                "candidate[phone]": "required",
                "candidate[email]": {
                    companyUniqueEmail: true,
                    required: true,
                },
                 "candidate_cv[cv]": {
                    extension: "pdf|docx|doc",
                    //'required': true,
                    'required': function(element) {
                        if ($('.hidden_cv').val() == '1') {
                            return true;
                        }
                        return false;
                    }
                },
                "candidate[country]": "required",
                "candidate[city]": "required",
                "candidate[linkedin_profile]": "required",
            },
            messages: {},
            errorPlacement: function(error, element) {
                if (element.hasClass("mobile-number")) {
                    error.insertAfter(element.parent().append());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        function validateForm() {
            var inputArr = $('input[name^="candidate_exp"]');
            var textareaArr = $('textarea[name^="candidate_exp"]');
            var selectArr = $('select[name^="candidate_exp"]');

            inputArr.filter('input[name$="[job_title]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            inputArr.filter('input[name$="[company]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            textareaArr.filter('textarea[name$="[job_responsibilities]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            selectArr.filter('select[name$="[start_year]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            selectArr.filter('select[name$="[start_month]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            selectArr.filter('select[name$="[end_year]"]').each(function() {
                $(this).rules("add", {
                    required: function(element) {
                        var counter = element.closest('.can_clone').attributes['counter'].value;
                        var clonnedDiv = $('.can_clone[counter="' + counter + '"]').find(
                            'input.is_current_working').prop('checked');
                        return !clonnedDiv
                    },
                });
            });

            selectArr.filter('select[name$="[end_month]"]').each(function() {
                $(this).rules("add", {
                    required: function(element) {
                        var counter = element.closest('.can_clone').attributes['counter'].value;
                        var clonnedDiv = $('.can_clone[counter="' + counter + '"]').find(
                            'input.is_current_working').prop('checked');
                        return !clonnedDiv
                    },
                });
            });
        }

        $.validator.addMethod('companyUniqueEmail', function(value, element) {
            var result = false;
            $.ajax({
                async: false,
                url: "{{ route('candidateSubmitUniqueEmailAdmin') }}",
                method: 'post',
                data: {
                    email: value,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(response) {
                    result = (response.data == true) ? true : false;
                }
            });
            return result;
        }, "This email is already exists");

        $(document).ready(function() {
            validateForm();
            checkEachStartEnd();
        })
        $(document).on('click', '.is_current_working', function() {
            var thiz = $(this);
            var counter = thiz.closest('.can_clone').attr('counter');

            $('.can_clone[counter="' + counter + '"]').find('select.end_year').prop('disabled', thiz.is(
            ':checked'));
            $('.can_clone[counter="' + counter + '"]').find('select.end_month').prop('disabled', thiz.is(
                ':checked'));
        })
    </script>
@endpush
