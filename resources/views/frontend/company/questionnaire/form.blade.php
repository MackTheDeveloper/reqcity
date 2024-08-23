@section('title', 'My Info')
@extends('frontend.layouts.master')
@section('content')
    <style type="text/css">
        .ans-choices>.ans-choice-box:only-child .minus-btn,
        .add-que>.que-add-question:only-child .close-section {
            display: none;
        }

    </style>
    <section class="profiles-pages compnay-profile-pages">
        <div class="container">
            <div class="row">
                @include('frontend.company.include.sidebar')
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="right-sides-items">
                        <div class="questionnarire-management-page">
                            <div class="accounts-boxlayouts" id="Divs2">
                                <div class="ac-boclayout-header">
                                    <div class="boxheader-title">
                                        <h6>{{ $model->id ? 'Edit' : 'Create' }} Questionnaire Template </h6>
                                    </div>
                                </div>
                                <span class="full-hr-ac"></span>
                                <div class=" ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Section -->
                                            <form id="questionnaiteMgmt" method="POST"
                                                action="{{ $model->id? route('companyQuestionnaireManagmentUpdate', $model->id): route('companyQuestionnaireManagmentStore') }}">
                                                @csrf
                                                <div class="questionarie-mangement-create">
                                                    <div class="select-template-ques">
                                                        <div class="input-groups">
                                                            <span>Template name</span>
                                                            <input name="template[title]" type="text"
                                                                value="{{ $model->title }}" />
                                                        </div>
                                                    </div>
                                                    <span class="full-hr-ac"></span>
                                                    <div class="addque-managment">
                                                        <div id="add-que" class="add-que">
                                                            @if (!empty($model->Questions->toArray()))
                                                                @foreach ($model->Questions as $key => $item2)
                                                                    <div class="que-add-question close-section-wrapper"
                                                                        counter="{{ $key }}">
                                                                        <a href="javascript:void(0)" class="close-section">
                                                                            <img src="{{ asset('public/assets/frontend/img/close.svg') }}"
                                                                                alt="" />
                                                                        </a>
                                                                        <div class="que-ans-type">
                                                                            <div class="input-groups first">
                                                                                <span>Enter question</span>
                                                                                <input type="hidden"
                                                                                    name="question[{{ $key }}][id]"
                                                                                    value="{{ $item2->id }}">
                                                                                <input
                                                                                    name="question[{{ $key }}][question]"
                                                                                    type="text"
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
                                                                                            value="{{ $key2 }}">
                                                                                            {{ $item['type'] }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        @php($class = in_array($item2->question_type, $typeChoices) ? '' : ' d-none')
                                                                        <div
                                                                            class="padleft-24 ans-choices{{ $class }}">
                                                                            @if (!empty($item2->Options->toArray()))
                                                                                @foreach ($item2->Options as $key3 => $item3)
                                                                                    <div class="ans-choice-box column"
                                                                                        counter="{{ $key3 }}">
                                                                                        {{-- <label class="rd">
                                                                                    <input type="radio" />
                                                                                    <span class="rd-checkmark"></span>
                                                                                </label> --}}
                                                                                        <div>
                                                                                            <input type="hidden"
                                                                                                name="option[{{ $key }}][{{ $key3 }}][id]"
                                                                                                value="{{ $item3->id }}">
                                                                                            <input type="hidden"
                                                                                                name="option[{{ $key }}][{{ $key3 }}][sort_order]"
                                                                                                value="{{ $item3->sort_order }}">
                                                                                            <input
                                                                                                name="option[{{ $key }}][{{ $key3 }}][option_value]"
                                                                                                type="text"
                                                                                                class="input"
                                                                                                placeholder="Enter an answer choice"
                                                                                                value="{{ $item3->option_value }}" />
                                                                                            <a href="javascript:void(0)"
                                                                                                class="minus-btn">
                                                                                                <img src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}"
                                                                                                    alt="" />
                                                                                            </a>
                                                                                            <a href="javascript:void(0)"
                                                                                                class="plus-btn">
                                                                                                <img src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}"
                                                                                                    alt="" />
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @else
                                                                                <div class="ans-choice-box column" counter="0">
                                                                                    {{-- <label class="rd">
                                                                                <input type="radio" />
                                                                                <span class="rd-checkmark"></span>
                                                                            </label> --}}
                                                                                    <div>
                                                                                        <input
                                                                                            name="option[{{ $key }}][0][option_value]"
                                                                                            type="text"
                                                                                            class="input"
                                                                                            placeholder="Enter an answer choice" />
                                                                                        <a href="javascript:void(0)"
                                                                                            class="minus-btn">
                                                                                            <img src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}"
                                                                                                alt="" />
                                                                                        </a>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="plus-btn">
                                                                                            <img src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}"
                                                                                                alt="" />
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="QA-btn-block text-right d-none">
                                                                            <button class="border-btn">Cancel</button>
                                                                            <button class="fill-btn"
                                                                                disabled>Save</button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="que-add-question close-section-wrapper"
                                                                    counter="0">
                                                                    <a href="javascript:void(0)" class="close-section">
                                                                        <img src="{{ asset('public/assets/frontend/img/close.svg') }}"
                                                                            alt="" />
                                                                    </a>
                                                                    <div class="que-ans-type">
                                                                        <div class="input-groups first">
                                                                            <span>Enter question</span>
                                                                            <input name="question[0][question]"
                                                                                type="text" />
                                                                        </div>
                                                                        <div class="input-groups second">
                                                                            <span>Answer type</span>
                                                                            <select class="changeQueType"
                                                                                name="question[0][question_type]">
                                                                                <option value="">Select Type</option>
                                                                                @foreach ($types as $key => $item)
                                                                                    <option
                                                                                        data-choice="{{ $item['has_choice'] }}"
                                                                                        value="{{ $key }}">
                                                                                        {{ $item['type'] }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="padleft-24 ans-choices d-none">
                                                                        <div class="ans-choice-box" counter="0">
                                                                            {{-- <label class="rd">
                                                                            <input type="radio" />
                                                                            <span class="rd-checkmark"></span>
                                                                        </label> --}}
                                                                            <input name="option[0][0][option_value]"
                                                                                type="text" class="input"
                                                                                placeholder="Enter an answer choice" />
                                                                            <a href="javascript:void(0)"
                                                                                class="minus-btn">
                                                                                <img src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}"
                                                                                    alt="" />
                                                                            </a>
                                                                            <a href="javascript:void(0)"
                                                                                class="plus-btn">
                                                                                <img src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}"
                                                                                    alt="" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="QA-btn-block text-right d-none">
                                                                        <button class="border-btn">Cancel</button>
                                                                        <button class="fill-btn"
                                                                            disabled>Save</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="text-right add-ques-btns">
                                                            <a href="javascript:void(0)" type="button"
                                                                class="blue-btn add-question">
                                                                <img src="{{ asset('public/assets/frontend/img/blue-plus.svg') }}"
                                                                    alt="" />Add question
                                                            </a>
                                                        </div>
                                                        <div class="">
                                                            <div class="JQ-btn-block">
                                                                <a href="{{ route('companyQuestionnaireManagment') }}"
                                                                    class="border-btn">Cancel</a>
                                                                <button type="submit"
                                                                    class="fill-btn">{{ $model->id ? 'Update' : 'Create' }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('footscript')
    <script type="text/javascript">
        $(document).ready(function() {
            validateForm();
        })
        $("#questionnaiteMgmt").validate({
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
            $('.add-que').append(clonned);
            validateForm();
        }).on('click', '.close-section', function(e) {
            if ($(this).closest('.que-add-question').siblings().length) {
                $(this).closest('.que-add-question').remove();
            }
        })
    </script>
@endsection
