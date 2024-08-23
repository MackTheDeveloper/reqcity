@section('title', 'Recruiter Jobs')
@extends('frontend.layouts.master')
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
<div class="req-submit-candidate">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 col-md-12">
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
            </div>
        </div>
        <div class="row margins-62 flex-reverse-mobo">
            <div class="col-md-8">
                <div class="candidate-submital-main">
                    <h5>Candidate Submittal</h5>
                    <div class="candidate-submital-in">
                        <p class="tl">Candidate info</p>
                        <form method="POST" action="{{ route('postRecruiterCandidateSubmit') }}" enctype="multipart/form-data" id="recruiterCandidateForm">
                            @csrf
                            <input type="hidden" name="candidate[id]" value="{{ $model->id }}" />
                            <!-- Developer Note :- below First DIV contain unique class for all 4 submital candidate pages -->
                            <div class="submittal-candidate-form">
                                <form class="">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>First name</span>
                                                <input type="text" class="suggest-candidate" value="{{ $model->first_name }}" name="candidate[first_name]" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Last name</span>
                                                <input type="text" value="{{ $model->last_name }}" name="candidate[last_name]" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                            <div class="number-groups">
                                                <span>Phone Number</span>
                                                <div class="number-fields">
                                                    <input type="text" id="phoneField1" class="phone-field" value="{{ $model->phone_ext }}" />
                                                    <input type="number" class="mobile-number" name="candidate[phone]" value="{{ $model->phone }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Email</span>
                                                <input type="email" name="candidate[email]" value="{{ $model->email }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Country</span>
                                                <select name="candidate[country]">
                                                    @foreach ($countries as $items)
                                                    <option {{ !empty($model->id) && $model->country == $items['key'] ? 'selected="selected"' : '' }} value="{{ $items['key'] }}">{{ $items['value'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>State</span>
                                                <input type="text" name="candidate[state]" value="{{ $model->state }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>City</span>
                                                <input type="text" name="candidate[city]" value="{{ $model->city }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Zip code</span>
                                                <input type="text" name="candidate[postcode]" value="{{ $model->postcode }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="input-groups">
                                                <div class="diversity-selectcs">
                                                    <label class="ck">Diversity
                                                        <input type="checkbox" name="candidate[is_diverse_candidate]" value="1" {{ $model->is_diverse_candidate ? 'checked' : '' }} />
                                                        <span class="ck-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="candidate-submittal-resume">
                                                <span class="tm">Upload resume for {{$companyJob->title}}</span>
                                                <div class="upload-form-btn2">
                                                    <img src="{{ asset('public/assets/frontend/img/upload-icon.svg') }}" id="upload-form-img" alt="" />
                                                    <div>
                                                        <p class="tm" id="upload-form-text">Upload resume
                                                        </p>
                                                        <span class="bs blur-color">Use a pdf, docx, doc</span>
                                                    </div>
                                                    <input type="file" id="upload-form-file" hidden="hidden" name="candidate_cv[cv]" />
                                                </div>
                                                <label id="" class="error" for="upload-form-file"></label>
                                                @php($requiredCv = 1)
                                                @if ($modelCv && $modelCv->cv)
                                                @php($requiredCv = 0)
                                                <p><a target="_blank" href="{{$modelCv->cv}}">Download CV Version {{$modelCv->version_num}}</a></p>
                                                @endif
                                                <input type="hidden" class="hidden_cv" value="{{ $requiredCv }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="input-groups">
                                                <p class="linkedin-input">LinkedIn</p>
                                                <span>LinkedIn profile link</span>
                                                <input type="url" pattern="https://.*" name="candidate[linkedin_profile]" value="{{ $model->linkedin_profile }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="yr-exp-candidate-submt">
                                                <span class="tm">Candidate experience</span>
                                            </div>
                                        </div>
                                        <div class="cloneAppend col-12">
                                            @if (!empty($candidateExp))
                                            @foreach ($candidateExp as $key=>$item)
                                            <div class="can_clone row close-section-wrapper" counter="{{$key}}">
                                                <a href="javascript:void(0)" class="close-section ">
                                                    <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                                </a>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Job Title</span>
                                                        <input type="text" name="candidate_exp[{{$key}}][job_title]" value="{{$item['job_title']}}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Company</span>
                                                        <input type="text" name="candidate_exp[{{$key}}][company]" value="{{$item['job_title']}}" />
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="input-groups">
                                                        <input type="hidden" name="candidate_exp[{{$key}}][start_month]" value="{{!empty($item['start_month'])?$item['start_month']:1}}" />
                                                        <span>Start year</span>
                                                        <select name="candidate_exp[{{$key}}][start_year]" class="exp_date start_year">
                                                            <option value="">Select Year</option>
                                                            @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                            <option {{ (!empty($item['start_year']) && $item['start_year'] == $i) ? 'selected="selected"' : '' }} value="{{ $i }}">
                                                                {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                    <div class="input-groups">
                                                        <span>Start month</span>
                                                        <select name="candidate_exp[{{$key}}][start_month]" class="exp_date start_month">
                                                            <option value="">Select Month</option>
                                                            @foreach ($month as $keys => $items)
                                                            <option {{ (!empty($item['start_month']) && $item['start_month'] == $keys) ? 'selected="selected"' : '' }} value="{{ $keys }}">
                                                                {{ $items }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="input-groups">
                                                        <input type="hidden" name="candidate_exp[{{$key}}][end_month]" value="{{!empty($item['end_month'])?$item['end_month']:1}}" />
                                                        <span>End year</span>
                                                        <select name="candidate_exp[{{$key}}][end_year]" class="exp_date end_year" {{(isset($item['is_current_working']) && $item['is_current_working'] == '1')?'disabled':''}}>
                                                            <option value="">Select Year</option>
                                                            @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                            <option {{ (!empty($item['end_year']) && $item['end_year'] == $i) ? 'selected="selected"' : '' }} value="{{ $i }}">
                                                                {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                    <div class="input-groups">
                                                        <span>End month</span>
                                                        <select name="candidate_exp[{{$key}}][end_month]" class="exp_date end_month" {{(isset($item['is_current_working']) && $item['is_current_working'] == '1')?'disabled':''}}>
                                                            <option value="">Select Month</option>
                                                            @foreach ($month as $keys => $items)
                                                            <option {{ (!empty($item['end_month']) && $item['end_month'] == $keys) ? 'selected="selected"' : '' }} value="{{ $keys }}">
                                                                {{ $items }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <div class="input-groups">
                                                        <span>Job Responsibilities</span>
                                                        <textarea name="candidate_exp[{{$key}}][job_responsibilities]">{{!empty($item['job_responsibilities'])?$item['job_responsibilities']:''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <label class="ck">I am currently working in this
                                                        role
                                                        <input class="is_current_working" type="checkbox" value="1" {{(isset($item['is_current_working']) && $item['is_current_working'])?"checked":""}} name="candidate_exp[{{$key}}][is_current_working]" />
                                                        <span class="ck-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div class="can_clone row close-section-wrapper" counter="0">
                                                <a href="javascript:void(0)" class="close-section ">
                                                    <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                                </a>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Job Title</span>
                                                        <input type="text" name="candidate_exp[0][job_title]" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Company</span>
                                                        <input type="text" name="candidate_exp[0][company]" />
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="input-groups">
                                                        <input type="hidden" name="candidate_exp[0][start_month]" value="1" />
                                                        <span>Start year</span>
                                                        <select name="candidate_exp[0][start_year]" class="exp_date start_year">
                                                            <option value="">Select Year</option>
                                                            @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                            <option {{ $year['end'] == $i ? 'selected="selected"' : '' }} value="{{ $i }}">
                                                                {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                    <div class="input-groups">
                                                        <span>Start month</span>
                                                        <select name="candidate_exp[0][start_month]" class="exp_date start_month">
                                                            <option value="">Select Month</option>
                                                            @foreach ($month as $key => $item)
                                                            <option value="{{ $key }}">
                                                                {{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="input-groups">
                                                        <input type="hidden" name="candidate_exp[0][end_month]" value="1" />
                                                        <span>End year</span>
                                                        <select name="candidate_exp[0][end_year]" class="exp_date end_year">
                                                            <option value="">Select Year</option>
                                                            @for ($i = $year['end']; $i >= $year['start']; $i--)
                                                            <option {{ $year['end'] == $i ? 'selected="selected"' : '' }} value="{{ $i }}">
                                                                {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                    <div class="input-groups">
                                                        <span>End month</span>
                                                        <select name="candidate_exp[0][end_month]" class="exp_date end_month">
                                                            <option value="">Select Month</option>
                                                            @foreach ($month as $key => $item)
                                                            <option value="{{ $key }}">
                                                                {{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <div class="input-groups">
                                                        <span>Job Responsibilities</span>
                                                        <textarea name="candidate_exp[0][job_responsibilities]"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <label class="ck">I am currently working in this
                                                        role
                                                        <input type="checkbox" value="1" class="is_current_working" name="candidate_exp[0][is_current_working]" />
                                                        <span class="ck-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="addbranch-candi-submit">
                                                <button type="button" class="blue-btn add-experience">
                                                    <img src="{{ asset('public/assets/frontend/img/blue-plus.svg') }}" alt="" />Add experience
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="reqsubmit-candidate-btns text-right">
                                            {{--  <a href="" class="border-btn">Back</a> --}}
                                                <button type="submit" value="1" class="fill-btn">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('frontend.recruiter.job-application.job-desc-sidebar',['companyJob'=>$companyJob])
            </div>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<script type="text/javascript">
    $(document).ready(function() {
        checkEachStartEnd();
        validateForm();
    });
    $("#phoneField1").CcPicker({
        dialCodeFieldName: "candidate[phone_ext]"
    });
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
        var validateIcon = $('#recruiterCandidateForm').validate().element(':input[name="candidate_cv[cv]"]');
        if (!validateIcon)
            return false;
    });

    $("input.suggest-candidate").autocomplete({
        source: function(request, response) {
            var url = "{{ route('candidateSearch') }}";
            $.post(url, {
                query: request.term,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                response(data);
            });
        },
        focus: function(event, ui) {
            $("input.suggest-candidate").val(ui.item.label);
            return false;
        },
        minLength: 3,
        select: function(event, ui) {
            // ui.item.value
            $("input.suggest-candidate").val(ui.item.label);
            window.location = "{{ route('recruiterCandidateSubmit') }}/" + ui.item.value;
            return false;
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>").append("<div>" + item.label + "<br><small>" + item.desc + "</small></div>").appendTo(ul);
    };

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


    // add-experience
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

    // $('#recruiterCandidateForm').vald
    $("#recruiterCandidateForm").validate({
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
            // "candidate[linkedin_profile]": "required",
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
                    var clonnedDiv = $('.can_clone[counter="' + counter + '"]').find('input.is_current_working').prop('checked');
                    return !clonnedDiv
                },
            });
        });

        selectArr.filter('select[name$="[end_month]"]').each(function() {
            $(this).rules("add", {
                required: function(element) {
                    var counter = element.closest('.can_clone').attributes['counter'].value;
                    var clonnedDiv = $('.can_clone[counter="' + counter + '"]').find('input.is_current_working').prop('checked');
                    return !clonnedDiv
                },
            });
        });
    }

    $(document).on('click','.is_current_working',function(){
        var thiz = $(this);
        var counter = thiz.closest('.can_clone').attr('counter');

        $('.can_clone[counter="' + counter + '"]').find('select.end_year').prop('disabled', thiz.is(':checked'));
        $('.can_clone[counter="' + counter + '"]').find('select.end_month').prop('disabled', thiz.is(':checked'));
    })

    $.validator.addMethod('companyUniqueEmail', function(value, element) {
        var result = false;
        $.ajax({
            async: false,
            url: "{{ route('candidateSubmitUniqueEmail') }}",
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
</script>
@endsection