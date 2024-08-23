@section('title', 'Recruiter Jobs')
@extends('frontend.layouts.master')
@section('content')
    <div class="req-submit-candidate">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 col-md-12">
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
                </div>
            </div>
            <div class="row margins-62 flex-reverse-mobo">
                <div class="col-md-8">
                    <div class="candidate-submital-main ">
                        <h5>Questionnaire</h5>
                        <div class="candidate-submital-in">

                            <!-- Developer Note :- below First DIV contain unique class for all 4 submital candidate pages -->
                            <div class="submittal-candidate-form questionnaire-candt-form">
                                <form method="POST" action="{{ route('postRecruiterCandidateQuestionnaire') }}" enctype="multipart/form-data" id="recruiterCandidateForm">
                                    @csrf
                                    <div class="row">
                                        @foreach ($templateQuestions as $key=>$value)
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <div class="input-groups">
                                                    <span>{{$value->question}}</span>
                                                    @php($val = !empty($questionnaire['templateQuestions'][$value->id])?$questionnaire['templateQuestions'][$value->id]:'')
                                                    @php($hasOptions = 0)
                                                    @if (!empty($value->Options->toArray()))
                                                        @php($hasOptions = 1)
                                                    @endif
                                                    @if ($types[$value->question_type]['type']=='dropdown' && $hasOptions)
                                                        <select name="templateQuestions[{{$value->id}}]">
                                                            @foreach ($value->Options as $option)
                                                                <option {{$option->option_value==$val?"selected":""}} value="{{$option->option_value}}">{{$option->option_value}}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif ($types[$value->question_type]['type']=='checkbox' && $hasOptions)
                                                        @foreach ($value->Options as $option)
                                                            <label class="ck">
                                                                <input value="{{$option->option_value}}" {{ (!empty($val) && in_array($option->option_value,$val))?"checked":""}} name="templateQuestions[{{$value->id}}][]" type="checkbox" />
                                                                <span class="ck-checkmark"></span>
                                                                {{$option->option_value}}
                                                            </label>
                                                        @endforeach
                                                    @elseif ($types[$value->question_type]['type']=='radiobutton' && $hasOptions)
                                                        @foreach ($value->Options as $option)
                                                            <label class="rd">
                                                                <input value="{{$option->option_value}}" {{$option->option_value==$val?"checked":""}} name="templateQuestions[{{$value->id}}]" type="radio" />
                                                                <span class="rd-checkmark"></span>
                                                                {{$option->option_value}}
                                                            </label>
                                                        @endforeach
                                                    @elseif ($types[$value->question_type]['type']=='ratings' && $hasOptions)
                                                        @foreach ($value->Options as $option)
                                                            <label class="rd">
                                                                <input value="{{$option->option_value}}" {{$option->option_value==$val?"checked":""}} name="templateQuestions[{{$value->id}}]" type="radio" />
                                                                <span class="rd-checkmark"></span>
                                                                {{$option->option_value}}
                                                            </label>
                                                        @endforeach
                                                    @elseif ($types[$value->question_type]['type']=='textbox')
                                                        <input name="templateQuestions[{{$value->id}}]" type="text" value="{{$val}}">
                                                    @elseif ($types[$value->question_type]['type']=='textarea')
                                                        <textarea name="templateQuestions[{{$value->id}}]" class="textarea">{{$val}}</textarea>
                                                    @elseif ($types[$value->question_type]['type']=='date')
                                                        <input name="templateQuestions[{{$value->id}}]" type="text" placeholder="dd/mm/yyyy" value="{{$val}}">
                                                    @elseif ($types[$value->question_type]['type']=='datetime')
                                                        <input name="templateQuestions[{{$value->id}}]" type="text" placeholder="dd/mm/yyyy hh:mm:ss" value="{{$val}}">
                                                    @elseif ($types[$value->question_type]['type']=='upload document')
                                                        <input name="templateQuestions[{{$value->id}}]" type="file" extension="docx|doc|pdf" isRequired="{{$val?'false':'true'}}">
                                                        <p class="ll blur-color">(Note: Valid Extentions are docx|doc|pdf.)</p>
                                                        @if ($val)
                                                            <input type="hidden" value="{{$val}}" name="templateQuestions[{{$value->id}}]" isRequired="false">
                                                            <a target="_blank" href="{{$val}}">Click here</a> to see your upload
                                                        @endif
                                                    @elseif ($types[$value->question_type]['type']=='upload image')
                                                        <input name="templateQuestions[{{$value->id}}]" type="file" extension="jpg|jpeg|png" isRequired="{{$val?'false':'true'}}">
                                                        <p class="ll blur-color">(Note: Valid Extentions are jpg|jpeg|png.)</p>
                                                        @if ($val)
                                                            <input type="hidden" value="{{$val}}" name="templateQuestions[{{$value->id}}]" isRequired="false">
                                                            <a target="_blank" href="{{$val}}">Click here</a> to see your upload
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>    
                                        @endforeach

                                        @foreach ($extraQuestions as $key=>$value)
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <div class="input-groups">
                                                    <span>{{$value->question}}</span>
                                                    {{-- <textarea></textarea> --}}
                                                    @php($val = !empty($questionnaire['extraQuestions'][$value->id])?$questionnaire['extraQuestions'][$value->id]:'')
                                                    @php($options = json_decode($value->options_JSON,true))
                                                    @if ($types[$value->question_type]['type']=='dropdown' && !empty($options))
                                                        <select name="extraQuestions[{{$value->id}}]">
                                                            @foreach ($options as $option)
                                                                <option {{$option->option_value==$val?"selected":""}} value="{{$option->option_value}}">{{$option->option_value}}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif ($types[$value->question_type]['type']=='checkbox' && !empty($options))
                                                        @foreach ($options as $option)
                                                            <label class="ck">
                                                                <input {{(!empty($val) && in_array($option->option_value,$val))?"checked":""}} name="extraQuestions[{{$value->id}}]" type="checkbox" value="{{$option->option_value}}" />
                                                                <span class="ck-checkmark">{{$option->option_value}}</span>
                                                            </label>
                                                        @endforeach
                                                    @elseif ($types[$value->question_type]['type']=='radiobutton' && !empty($options))
                                                        @foreach ($options as $option)
                                                            <label class="rd">
                                                                <input {{$option->option_value==$val?"checked":""}} name="extraQuestions[{{$value->id}}]" type="radio" value="{{$option->option_value}}" />
                                                                <span class="rd-checkmark"></span>
                                                                {{$option->option_value}}
                                                            </label>
                                                        @endforeach
                                                    @elseif ($types[$value->question_type]['type']=='ratings' && !empty($options))
                                                        @foreach ($options as $option)
                                                            <label class="rd">
                                                                <input {{$option->option_value==$val?"checked":""}} name="extraQuestions[{{$value->id}}]" type="radio" value="{{$option->option_value}}" />
                                                                <span class="rd-checkmark"></span>
                                                                {{$option->option_value}}
                                                            </label>
                                                        @endforeach
                                                    @elseif ($types[$value->question_type]['type']=='textbox')
                                                        <input name="extraQuestions[{{$value->id}}]" type="text" value="{{$val}}">
                                                    @elseif ($types[$value->question_type]['type']=='textarea')
                                                        <textarea name="extraQuestions[{{$value->id}}]" class="textarea">{{$val}}</textarea>
                                                    @elseif ($types[$value->question_type]['type']=='date')
                                                        <input name="extraQuestions[{{$value->id}}]" type="text" placeholder="dd/mm/yyyy" value="{{$val}}" class="datepicker" >
                                                    @elseif ($types[$value->question_type]['type']=='datetime')
                                                        <input name="extraQuestions[{{$value->id}}]" type="text" placeholder="dd/mm/yyyy hh:ii A" value="{{$val}}" class="datetimepicker" >
                                                    @elseif ($types[$value->question_type]['type']=='upload document')
                                                        <input name="extraQuestions[{{$value->id}}]" type="file" extension="docx|doc|pdf" isRequired="{{$val?'false':'true'}}">
                                                        <p class="ll blur-color">(Note: Valid Extentions are docx|doc|pdf.)</p>
                                                        @if ($val)
                                                            <input type="hidden" value="{{$val}}" name="extraQuestions[{{$value->id}}]" isRequired="false">
                                                            <a target="_blank" href="{{$val}}">Click here</a> to see your upload
                                                        @endif
                                                    @elseif ($types[$value->question_type]['type']=='upload image')
                                                        <input name="extraQuestions[{{$value->id}}]" type="file" extension="jpg|jpeg|png" isRequired="{{$val?'false':'true'}}">
                                                        <p class="ll blur-color">(Note: Valid Extentions are jpg|jpeg|png.)</p>
                                                        @if ($val)
                                                            <input type="hidden" value="{{$val}}" name="extraQuestions[{{$value->id}}]" isRequired="false">
                                                            <a target="_blank" href="{{$val}}">Click here</a> to see your upload
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>    
                                        @endforeach
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="reqsubmit-candidate-btns">
                                                <a href="{{route('recruiterCandidateSubmit')}}" class="border-btn">Back</a>
                                                <button class="fill-btn">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
        validateForm();
    });
    $("#recruiterCandidateForm").validate({
        ignore: ":hidden",
        rules: {},
        messages: {},
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element.parent().append());
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
            if (!isRequired || isRequired=='true') {
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
    $(document).on('change','input[type="file"]',function(){
        $(this).closest('.input-groups').find('input[type="hidden"]').prop('disabled',true);
    });
</script>
@endsection