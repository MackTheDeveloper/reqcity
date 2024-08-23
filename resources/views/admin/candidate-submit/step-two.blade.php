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
                    <div class="info-progress ">
                        <div class="numbers">2</div>
                        <p class="tm">Questionnaire</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">3</div>
                        <p class="tm">Review Submittal</p>
                    </div>
                </div>


                <h4 class="form-title-text">Questionnaire</h4>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title-wrapper right-side">
                            <button type="submit" class="btn btn-primary plr-16 view-job"
                                data-job-id="{{ $companyJob->id }}">View Details</button>
                        </div>
                        <form action="{{ route('postJobQuestionnaire') }}" method="POST" enctype="multipart/form-data"
                            id="candidateSubmitStepTwo">
                            @csrf
                            <div class="row">
                                @foreach ($templateQuestions as $key => $value)
                                    @php($extraClass = $types[$value->question_type]['type'] == 'radiobutton' ? 'radio-groups' : '')
                                    <div class="col-sm-12 col-md-12 {{ $extraClass }}">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ $value->question }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            @php($val = !empty($questionnaire['templateQuestions'][$value->id]) ? $questionnaire['templateQuestions'][$value->id] : '')
                                            @php($hasOptions = 0)
                                            @if (!empty($value->Options->toArray()))
                                                @php($hasOptions = 1)
                                            @endif
                                            @if ($types[$value->question_type]['type'] == 'dropdown' && $hasOptions)
                                                <select class="form-control"
                                                    name="templateQuestions[{{ $value->id }}]">
                                                    @foreach ($value->Options as $option)
                                                        <option {{ $option->option_value == $val ? 'selected' : '' }}
                                                            value="{{ $option->option_value }}">
                                                            {{ $option->option_value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif ($types[$value->question_type]['type'] == 'checkbox' && $hasOptions)
                                                @php($i = 1)
                                                @foreach ($value->Options as $option)
                                                    <br>
                                                    <div class="custom-checkbox custom-control custom-control-inline">
                                                        <input type="checkbox"
                                                            id="filterable-{{ $key }}-{{ $i }}"
                                                            class="custom-control-input"
                                                            {{ (!empty($val) && in_array($option->option_value,$val)) ? 'checked' : '' }}
                                                            name="templateQuestions[{{ $value->id }}][]"
                                                            value="{{ $option->option_value }}">
                                                        <label class="custom-control-label"
                                                            for="filterable-{{ $key }}-{{ $i }}">{{ $option->option_value }}</label>

                                                    </div>
                                                    @php($i++)
                                                @endforeach
                                                <label id="" class="error"
                                                    for="templateQuestions[{{ $value->id }}]"></label>
                                            @elseif ($types[$value->question_type]['type'] == 'radiobutton' && $hasOptions)
                                                @php($i = 1)
                                                @foreach ($value->Options as $option)
                                                    <br>
                                                    <div class="custom-radio custom-control custom-control-inline">
                                                        <input type="radio"
                                                            id="filterable-{{ $key }}-{{ $i }}"
                                                            class="custom-control-input"
                                                            {{ $option->option_value == $val ? 'checked' : '' }}
                                                            name="templateQuestions[{{ $value->id }}]"
                                                            value="{{ $option->option_value }}">
                                                        <label class="custom-control-label"
                                                            for="filterable-{{ $key }}-{{ $i }}">{{ $option->option_value }}</label>
                                                    </div>
                                                    @php($i++)
                                                @endforeach
                                                <label id="" class="error"
                                                    for="templateQuestions[{{ $value->id }}]"></label>
                                            @elseif ($types[$value->question_type]['type'] == 'ratings' && $hasOptions)
                                                @php($i = 1)
                                                @foreach ($value->Options as $option)
                                                    <br>
                                                    <div class="custom-radio custom-control custom-control-inline">
                                                        <input type="radio"
                                                            id="filterable-{{ $key }}-{{ $i }}"
                                                            class="custom-control-input"
                                                            {{ $option->option_value == $val ? 'checked' : '' }}
                                                            name="templateQuestions[{{ $value->id }}]"
                                                            value="{{ $option->option_value }}">
                                                        <label class="custom-control-label"
                                                            for="filterable-{{ $key }}-{{ $i }}">{{ $option->option_value }}</label>
                                                    </div>
                                                    <label id="" class="error"
                                                        for="templateQuestions[{{ $value->id }}]"></label>
                                                    @php($i++)
                                                @endforeach
                                            @elseif ($types[$value->question_type]['type'] == 'textbox')
                                                <input class="form-control" name="templateQuestions[{{ $value->id }}]"
                                                    type="text" value="{{ $val }}">
                                            @elseif ($types[$value->question_type]['type'] == 'textarea')
                                                <textarea class="form-control"
                                                    name="templateQuestions[{{ $value->id }}]"
                                                    class="textarea">{{ $val }}</textarea>
                                            @elseif ($types[$value->question_type]['type'] == 'date')
                                                <input class="form-control" name="templateQuestions[{{ $value->id }}]"
                                                    type="text" placeholder="dd/mm/yyyy" value="{{ $val }}">
                                            @elseif ($types[$value->question_type]['type'] == 'datetime')
                                                <input class="form-control" name="templateQuestions[{{ $value->id }}]"
                                                    type="text" placeholder="dd/mm/yyyy hh:ii:ss"
                                                    value="{{ $val }}">
                                            @elseif ($types[$value->question_type]['type'] == 'upload document')
                                                <input class="form-control" name="templateQuestions[{{ $value->id }}]"
                                                    type="file" extension="docx|doc|pdf"
                                                    isRequired="{{ $val ? 'false' : 'true' }}">
                                                <p>(Note: Valid Extentions are docx|doc|pdf.)</p>
                                                @if ($val)
                                                    <input type="hidden" value="{{ $val }}"
                                                        name="templateQuestions[{{ $value->id }}]" isRequired="false">
                                                    <a target="_blank" href="{{ $val }}">Click here</a> to see
                                                    your upload
                                                @endif
                                            @elseif ($types[$value->question_type]['type'] == 'upload image')
                                                <input name="templateQuestions[{{ $value->id }}]" type="file"
                                                    extension="jpg|jpeg|png" isRequired="{{ $val ? 'false' : 'true' }}">
                                                <p>(Note: Valid Extentions are jpg|jpeg|png.)</p>
                                                @if ($val)
                                                    <input type="hidden" value="{{ $val }}"
                                                        name="templateQuestions[{{ $value->id }}]" isRequired="false">
                                                    <a target="_blank" href="{{ $val }}">Click here</a> to see
                                                    your upload
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($extraQuestions as $key => $value)
                                    @php($extraClass = $types[$value->question_type]['type'] == 'radiobutton' ? 'radio-groups' : '')
                                    <div class="col-sm-12 col-md-12 {{ $extraClass }}">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ $value->question }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            @php($val = !empty($questionnaire['templateQuestions'][$value->id]) ? $questionnaire['templateQuestions'][$value->id] : '')
                                            @php($hasOptions = 0)
                                            @if (!empty($value->Options))
                                                @php($hasOptions = 1)
                                            @endif
                                            @if ($types[$value->question_type]['type'] == 'dropdown' && $hasOptions)
                                                <select class="form-control" name="extraQuestions[{{ $value->id }}]">
                                                    @foreach ($value->Options as $option)
                                                        <option {{ $option->option_value == $val ? 'selected' : '' }}
                                                            value="{{ $option->option_value }}">
                                                            {{ $option->option_value }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif ($types[$value->question_type]['type'] == 'checkbox' && $hasOptions)
                                                @php($i = 1)
                                                @foreach ($value->Options as $option)
                                                    <br>
                                                    <div class="custom-checkbox custom-control custom-control-inline">
                                                        <input type="checkbox"
                                                            id="filterable1-{{ $key }}-{{ $i }}"
                                                            class="custom-control-input" value="yes"
                                                            {{ (!empty($val) && in_array($option->option_value,$val)) ? 'checked' : '' }}
                                                            name="extraQuestions[{{ $value->id }}]"
                                                            value="{{ $option->option_value }}">
                                                        <label class="custom-control-label"
                                                            for="filterable1-{{ $key }}-{{ $i }}">{{ $option->option_value }}</label>
                                                    </div>
                                                    @php($i++)
                                                @endforeach
                                                <label id="" class="error"
                                                    for="extraQuestions[{{ $value->id }}]"></label>
                                            @elseif ($types[$value->question_type]['type'] == 'radiobutton' && $hasOptions)
                                                @php($i = 1)
                                                @foreach ($value->Options as $option)
                                                    <br>
                                                    <div class="custom-radio custom-control custom-control-inline">
                                                        <input type="radio"
                                                            id="filterable1-{{ $key }}-{{ $i }}"
                                                            class="custom-control-input" value="yes"
                                                            {{ $option->option_value == $val ? 'checked' : '' }}
                                                            name="extraQuestions[{{ $value->id }}]"
                                                            value="{{ $option->option_value }}">
                                                        <label class="custom-control-label"
                                                            for="filterable1-{{ $key }}-{{ $i }}">{{ $option->option_value }}</label>
                                                    </div>
                                                    @php($i++)
                                                @endforeach
                                                <label id="" class="error"
                                                    for="extraQuestions[{{ $value->id }}]"></label>
                                            @elseif ($types[$value->question_type]['type'] == 'ratings' && $hasOptions)
                                                @php($i = 1)
                                                @foreach ($value->Options as $option)
                                                    <br>
                                                    <div class="custom-radio custom-control custom-control-inline">
                                                        <input type="radio"
                                                            id="filterable1-{{ $key }}-{{ $i }}"
                                                            class="custom-control-input" value="yes"
                                                            {{ $option->option_value == $val ? 'checked' : '' }}
                                                            name="extraQuestions[{{ $value->id }}]"
                                                            value="{{ $option->option_value }}">
                                                        <label class="custom-control-label"
                                                            for="filterable1-{{ $key }}-{{ $i }}">{{ $option->option_value }}</label>
                                                    </div>
                                                    <label id="" class="error"
                                                        for="extraQuestions[{{ $value->id }}]"></label>
                                                    @php($i++)
                                                @endforeach
                                            @elseif ($types[$value->question_type]['type'] == 'textbox')
                                                <input class="form-control" name="extraQuestions[{{ $value->id }}]"
                                                    type="text" value="{{ $val }}">
                                            @elseif ($types[$value->question_type]['type'] == 'textarea')
                                                <textarea class="form-control" name="extraQuestions[{{ $value->id }}]"
                                                    class="textarea">{{ $val }}</textarea>
                                            @elseif ($types[$value->question_type]['type'] == 'date')
                                                <input class="form-control" name="extraQuestions[{{ $value->id }}]"
                                                    type="text" placeholder="dd/mm/yyyy" value="{{ $val }}">
                                            @elseif ($types[$value->question_type]['type'] == 'datetime')
                                                <input class="form-control" name="extraQuestions[{{ $value->id }}]"
                                                    type="text" placeholder="dd/mm/yyyy hh:ii:ss"
                                                    value="{{ $val }}">
                                            @elseif ($types[$value->question_type]['type'] == 'upload document')
                                                <input class="form-control" name="extraQuestions[{{ $value->id }}]"
                                                    type="file" extension="docx|doc|pdf"
                                                    isRequired="{{ $val ? 'false' : 'true' }}">
                                                <p>(Note: Valid Extentions are docx|doc|pdf.)</p>
                                                @if ($val)
                                                    <input type="hidden" value="{{ $val }}"
                                                        name="extraQuestions[{{ $value->id }}]" isRequired="false">
                                                    <a target="_blank" href="{{ $val }}">Click here</a> to see
                                                    your upload
                                                @endif
                                            @elseif ($types[$value->question_type]['type'] == 'upload image')
                                                <input name="extraQuestions[{{ $value->id }}]" type="file"
                                                    extension="jpg|jpeg|png" isRequired="{{ $val ? 'false' : 'true' }}">
                                                <p>(Note: Valid Extentions are jpg|jpeg|png.)</p>
                                                @if ($val)
                                                    <input type="hidden" value="{{ $val }}"
                                                        name="extraQuestions[{{ $value->id }}]" isRequired="false">
                                                    <a target="_blank" href="{{ $val }}">Click here</a> to see
                                                    your upload
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tell us about yourself
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">What is it about your current position that you
                                            don't like that you are looking for in your next opportunity?
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">When are you available to start your next
                                            opportunity?
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <select name="country" class="form-control">
                                                <option value="1" selected="">Select...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">

                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Citizen/Work status?
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <select name="country" class="form-control">
                                                <option value="1" selected="">Select...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 radio-groups">
                                    <label class="font-weight-bold">Travel Requirements?
                                        <span class="text-danger">*</span>
                                    </label>
                                    <br>
                                    <div class="custom-radio custom-control custom-control-inline">
                                        <input type="radio" id="filterable1" name="filterable" class="custom-control-input"
                                            value="yes">
                                        <label class="custom-control-label" for="filterable1">Yes</label>
                                    </div>
                                    <br>
                                    <div class="custom-radio custom-control custom-control-inline">
                                        <input type="radio" id="filterable2" name="filterable" class="custom-control-input"
                                            value="no">
                                        <label class="custom-control-label" for="filterable2">No</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 radio-groups">
                                    <label class="font-weight-bold">Are you aware of the COVID situation and precautions to
                                        be taken?
                                        <span class="text-danger">*</span>
                                    </label>
                                    <br>
                                    <div class="custom-radio custom-control custom-control-inline">
                                        <input type="radio" id="filterable1" name="filterable" class="custom-control-input"
                                            value="yes">
                                        <label class="custom-control-label" for="filterable1">Yes</label>
                                    </div>
                                    <br>
                                    <div class="custom-radio custom-control custom-control-inline">
                                        <input type="radio" id="filterable2" name="filterable" class="custom-control-input"
                                            value="no">
                                        <label class="custom-control-label" for="filterable2">No</label>
                                    </div>
                                </div> --}}
                                <div class="col-sm-12 add-pad-top">
                                    <div class="form-group">

                                        <a href="{{ route('getCandidateSubmit') }}">
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
    <script type="text/javascript">
        $(document).ready(function() {
            validateForm();
        });
        $("#candidateSubmitStepTwo").validate({
            ignore: ":hidden",
            rules: {},
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
            var inputArr = $('input[name^="templateQuestions"]');
            var inputArr2 = $('input[name^="extraQuestions"]');
            var textareaArr = $('textarea[name^="templateQuestions"]');
            var textareaArr2 = $('textarea[name^="extraQuestions"]');
            var selectArr = $('select[name^="templateQuestions"]');
            var selectArr2 = $('select[name^="extraQuestions"]');

            inputArr.each(function() {
                var isRequired = $(this).attr('isRequired');
                if (!isRequired) {
                    $(this).rules("add", {
                        required: true,
                    });
                }
            });
            inputArr2.each(function() {
                var isRequired = $(this).attr('isRequired');
                if (!isRequired || isRequired == 'true') {
                    $(this).rules("add", {
                        required: true,
                    });
                }
            });
            textareaArr.each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });
            textareaArr2.each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });
            selectArr.each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });
            selectArr2.each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            inputArr2.filter('input[type="file"]').each(function() {
                var extentions = $(this).attr('extension');
                if (extentions) {
                    $(this).rules("add", {
                        extension: extentions
                    });
                }
            });

            inputArr.filter('input[type="file"]').each(function() {
                var extentions = $(this).attr('extension');
                if (extentions) {
                    $(this).rules("add", {
                        extension: extentions
                    });
                }
            });
        }
        $(document).on('change', 'input[type="file"]', function() {
            $(this).closest('.input-groups').find('input[type="hidden"]').prop('disabled', true);
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
    </script>
@endpush
