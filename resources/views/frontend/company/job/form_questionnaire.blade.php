@section('title', 'Job Questionnaire')
@extends('frontend.layouts.master')
@section('content')
@php
$showPayment = 1;
$jobId = Session::get('company_job.id');
if ($jobId) {
    $showPayment = getPaymentStatusByJobId($jobId);
}
@endphp
    <div class="company-job-post-21">
        <div class="container">
            <div class="process-progress width-672">
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('jobDetailsShow') }}"
                            style="text-decoration: none; color:white;">1</a></div>
                    <p class="tm">Job Details</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">2</div>
                    <p class="tm">Questionnaire</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">3</div>
                    <p class="tm">Communication</p>
                </div>
                @if ($showPayment)
                <div class="info-progress">
                    <div class="numbers">4</div>
                    <p class="tm">Review & Payment</p>
                </div>
                @endif
            </div>
            <div class="layout-824-wrapper">
                <form id="companyJobQuestionnaire" method="POST" action="{{ route('jobQuestionnairePost') }}">
                    @csrf
                    <input type="hidden" value="{{ empty($model->toArray()) ? '0' : '1' }}" name="hasExtraQuestion">
                    <h5>Questionnaire</h5>
                    <div class="job-questionnaire">
                        @if ($questionnaireTemplate->toArray())
                            <div class="que-select-header">
                                <p class="tl">Select questionnaire template</p>
                            </div>
                            <div class="input-groups post-selection">
                                <span>Questionnaire template</span>
                                <select name="questionnaire_template_id">
                                    @foreach ($questionnaireTemplate as $item)
                                        <option {{ $companyJobTemplate == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="questionnaire_template">

                            </div>
                            <div class="addque-managment">
                                <div id="add-que" class="collapse {{ !empty($model->toArray()) ? 'show' : '' }}">
                                    @if (!empty($model->toArray()))
                                        @foreach ($model as $key => $item2)
                                            <div class="que-add-question close-section-wrapper"
                                                counter="{{ $key }}">
                                                <a href="javascript:void(0)" class="close-section">
                                                    <img src="{{ asset('public/assets/frontend/img/close.svg') }}"
                                                        alt="" />
                                                </a>
                                                <div class="que-ans-type">
                                                    <div class="input-groups first">
                                                        <span>Enter question</span>
                                                        <input type="hidden" name="question[{{ $key }}][id]"
                                                            value="{{ $item2->id }}">
                                                        <input name="question[{{ $key }}][question]" type="text"
                                                            value="{{ $item2->question }}" />
                                                    </div>
                                                    <div class="input-groups second">
                                                        <span>Answer type</span>
                                                        <select class="changeQueType"
                                                            name="question[{{ $key }}][question_type]">
                                                            <option value="">Select Type</option>
                                                            @foreach ($types as $key2 => $item)
                                                                <option
                                                                    {{ !empty($item2->question_type) && $item2->question_type == $key2 ? 'selected' : '' }}
                                                                    data-choice="{{ $item['has_choice'] }}"
                                                                    value="{{ $key2 }}">{{ $item['type'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @php($class = in_array($item2->question_type, $typeChoices) ? '' : ' d-none')
                                                <div class="padleft-24 ans-choices{{ $class }}">
                                                    @php($options = json_decode($item2->options_JSON))
                                                    @if (!empty($options))
                                                        @foreach ($options as $key3 => $item3)
                                                            <div class="ans-choice-box column" counter="{{ $key3 }}">
                                                                <div>
                                                                    <input type="hidden"
                                                                        name="option[{{ $key }}][{{ $key3 }}][sort_order]"
                                                                        value="{{ $item3->sort_order }}">
                                                                    <input
                                                                        name="option[{{ $key }}][{{ $key3 }}][option_value]"
                                                                        type="text" class="input"
                                                                        placeholder="Enter an answer choice"
                                                                        value="{{ $item3->option_value }}" />
                                                                    <a href="javascript:void(0)" class="minus-btn">
                                                                        <img src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}"
                                                                            alt="" />
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="plus-btn">
                                                                        <img src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}"
                                                                            alt="" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="ans-choice-box column" counter="0">
                                                            <div>
                                                                <input name="option[{{ $key }}][0][option_value]"
                                                                    type="text" class="input"
                                                                    placeholder="Enter an answer choice" />
                                                                <a href="javascript:void(0)" class="minus-btn">
                                                                    <img src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}"
                                                                        alt="" />
                                                                </a>
                                                                <a href="javascript:void(0)" class="plus-btn">
                                                                    <img src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}"
                                                                        alt="" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="QA-btn-block text-right d-none">
                                                    <button class="border-btn">Cancel</button>
                                                    <button class="fill-btn" disabled>Save</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="que-add-question close-section-wrapper" counter="0">
                                            <a href="javascript:void(0)" class="close-section">
                                                <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                            </a>
                                            <div class="que-ans-type">
                                                <div class="input-groups first">
                                                    <span>Enter question</span>
                                                    <input name="question[0][question]" type="text" />
                                                </div>
                                                <div class="input-groups second">
                                                    <span>Answer type</span>
                                                    <select class="changeQueType" name="question[0][question_type]">
                                                        <option value="">Select Type</option>
                                                        @foreach ($types as $key => $item)
                                                            <option data-choice="{{ $item['has_choice'] }}"
                                                                value="{{ $key }}">{{ $item['type'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="padleft-24 ans-choices d-none">
                                                <div class="ans-choice-box" counter="0">
                                                    <input name="option[0][0][option_value]" type="text"
                                                        class="input" placeholder="Enter an answer choice" />
                                                    <a href="javascript:void(0)" class="minus-btn">
                                                        <img src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}"
                                                            alt="" />
                                                    </a>
                                                    <a href="javascript:void(0)" class="plus-btn">
                                                        <img src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}"
                                                            alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="QA-btn-block text-right d-none">
                                                <button class="border-btn">Cancel</button>
                                                <button class="fill-btn" disabled>Save</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <button type="button" class="add-question blue-btn">
                                        <img src="{{ asset('public/assets/frontend/img/blue-plus.svg') }}" alt="" />Add
                                        question
                                    </button>
                                </div>
                            </div>
                            <div class="JQ-btn-block">
                                <a href="{{ route('jobDetailsShow') }}" class="border-btn">Back</a>
                                <button name="submit_type" value="1" class="border-btn">Save as a Draft</button>
                                <button name="submit_type" value="2" class="fill-btn">Continue</button>
                            </div>
                        @else
                            <span>Please add at least one template from your profile. <a
                                    href="{{ route('companyQuestionnaireManagment') }}">Click here</a>.</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footscript')
    <script>
        $(document).on('change', 'select[name="questionnaire_template_id"]', function() {
            var templateId = $(this).val();
            getTemplateDetails(templateId)
        })

        function getTemplateDetails(templateId) {
            var url = "{{ route('getQuestionnaireData') }}";
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    templateId: templateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.questionnaire_template').html(response);
                    checkDefault();
                }
            })
        }

        $(document).on('change', '.all-checks', function() {
            $('.single-checks').prop('checked', $(this).prop('checked'))
        }).on('change', '.single-checks', function() {
            checkDefault();
        })

        function checkDefault() {
            var checkboxes = $('.single-checks').length;
            var checkedboxes = $('.single-checks:checked').length;
            if (checkboxes == checkedboxes) {
                $('.all-checks').prop('checked', true);
            } else {
                $('.all-checks').prop('checked', false);
            }
        }

        $(document).ready(function() {
            validateForm();
            // checkDefault();
            var companyJobTemplate = '{{ $companyJobTemplate }}';
            if (!companyJobTemplate) {
                $('select[name="questionnaire_template_id"] option:first').prop('selected', true);
            }
            $('select[name="questionnaire_template_id"]').trigger('change');
        })
        $("#companyJobQuestionnaire").validate({
            // ignore: [],
            ignore: ":hidden",
            rules: {
                "template[title]": "required",
            },
            messages: {},
            errorPlacement: function(error, element) {
                if (element.hasClass("mobile-number")) {
                    error.insertAfter(element.parent().append());
                } else if (element.parent().parent().hasClass("ans-choice-box column")) {
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
            var QuestionInput = $('input[name^="question"]');
            var QuestionSelct = $('select[name^="question"]');
            var QuestionOption = $('input[name^="option"]');

            QuestionInput.filter('input[name$="[question]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            QuestionSelct.filter('select[name$="[question_type]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });
            // if (QuestionOption.length) {    
            QuestionOption.filter('input[name$="[option_value]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });
            // }
        }
        $(document).on('change', '.changeQueType', function() {
            var hasChoice = $(this).find('option:selected').data('choice');
            if (hasChoice) {
                $(this).closest('.que-add-question').find('.ans-choices').removeClass('d-none');
            } else {
                $(this).closest('.que-add-question').find('.ans-choices').addClass('d-none');
            }
        })

        $(document).on('click', '.plus-btn', function(e) {
            var clonned = $(this).closest('.ans-choice-box').clone();
            var old = clonned.attr('counter');
            var parentCounter = $(this).closest('.que-add-question').attr('counter');;
            var ids = parseInt(old) + 1;
            // replaces
            clonned.attr('counter', ids);
            // text.replace(/B/g, match => ++t === 2 ? 'Z' : match)
            var oldVal = '[' + parentCounter + '][' + old + ']';
            var newVal = '[' + parentCounter + '][' + ids + ']';
            clonned.find('input[type="hidden"]').remove()
            clonned.find('input[type="text"]').each(function() {
                $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('')
            })
            $(this).closest('.ans-choices').append(clonned);
            validateForm();
        }).on('click', '.minus-btn', function(e) {
            // console.log($(this).closest('.ans-choice-box').siblings().length);
            if ($(this).closest('.ans-choice-box').siblings().length) {
                $(this).closest('.ans-choice-box').remove();
            }
        })
        $(document).on('click', '.add-question', function(e) {
            if ($('#add-que.collapse').hasClass('show')) {
                var clonned = $('.que-add-question:last').clone();
                var old = clonned.attr('counter');
                var ids = parseInt(old) + 1;
                // replaces
                clonned.attr('counter', ids);
                // text.replace(/B/g, match => ++t === 2 ? 'Z' : match)
                var oldVal = '[' + old + ']';
                var newVal = '[' + ids + ']';
                clonned.find('.que-ans-type input[type="text"]').each(function() {
                    $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('')
                })
                clonned.find('.que-ans-type select').each(function() {
                    $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('')
                })

                var oldVal = '[' + old + '][0]';
                var newVal = '[' + ids + '][0]';
                clonned.find('.ans-choices input[type="text"]').each(function() {
                    $(this).attr('name', $(this).attr('name').replace(oldVal, newVal)).val('')
                })
                clonned.find('.ans-choices .ans-choice-box').not(':first').remove()
                clonned.find('input[type="hidden"]').remove()
                clonned.find('.ans-choices').addClass('d-none')
                $('#add-que').append(clonned);
                validateForm();
            } else {
                $('#add-que.collapse').addClass('show');
                $('input[name="hasExtraQuestion"]').val(1);
            }
        }).on('click', '.close-section', function(e) {
            if ($(this).closest('.que-add-question').siblings().length) {
                $(this).closest('.que-add-question').remove();
            } else {
                $('#add-que.collapse').removeClass('show');
                $('input[name="hasExtraQuestion"]').val(0);
            }
        })
    </script>

@endsection
