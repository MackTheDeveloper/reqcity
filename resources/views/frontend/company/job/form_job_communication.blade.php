@section('title', 'Job Communication')
@extends('frontend.layouts.master')
@section('content')
@php
$countFaqs = !empty($model) ? count($model) : 0;
$countFaqs = $countFaqs == 0 ? 1 : $countFaqs;
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
                <div class="numbers"><a href="{{ route('jobDetailsShow') }}" style="text-decoration: none; color:white;">1</a></div>
                <p class="tm">Job Details</p>
            </div>
            <div class="info-progress done">
                <div class="numbers"><a href="{{ route('jobQuestionnaireShow') }}" style="text-decoration: none; color:white;">2</a></div>
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
            <h5>Communication</h5>
            <form id="companyJobForm" method="POST" action="{{route('jobCommunicationAddUpdate')}}">
                @csrf
                <div class="job-questionnaire job-communication">
                    @if ($faqTemplates->toArray())
                    <div class="que-select-header">
                        <p class="tl">Select communication template</p>
                    </div>
                    <div class="input-groups post-selection">
                        <span>Communication Template</span>
                        <select name="companyJob[job_communication_template_id]" id="job_communication_template_id">
                            <option value="">Select</option>
                            @foreach ($faqTemplates as $key => $value)
                            <option value="{{ $key }}" {{ $key == $modelCompanyJob->job_communication_template_id ? 'selected' : '' }}>
                                {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="communication_template">
                        @if (!empty($companyFaqsTemplates->companyFaqs->toArray()))
                        <div class="que-select-header mb-0">
                            <p class="tl">Frequently asked questions</p>
                            <label class="ck">Select All
                                <input class="all-checks" type="checkbox" />
                                <span class="ck-checkmark"></span>
                            </label>
                        </div>
                        @endif
                        <div id="accordion" class="req-accordian">

                            @if (!empty($companyFaqsTemplates->companyFaqs->toArray()))
                            @php($i = 1)
                            @foreach ($companyFaqsTemplates->companyFaqs as $keyCompanyFaqs => $rowCompanyFaqs)
                            <input type="hidden" name="CompanyJobCommunications[faq][{{$i}}][id]" value="{{in_array($rowCompanyFaqs->id,$selectedQuestions) ? app('App\Models\CompanyJobCommunications')->getPkFromFaqId($rowCompanyFaqs->id) : ''}}">
                            <div class="card">
                                <div class="card-header">
                                    <label class="only-ck">
                                        <input class="single-checks" type="checkbox" {{in_array($rowCompanyFaqs->id,$selectedQuestions) ? 'checked' : ''}} name="CompanyJobCommunications[faq][{{$i}}][company_faq_id]" value="{{$rowCompanyFaqs->id}}" />
                                        <span class="only-ck-checkmark"></span>
                                    </label>
                                    <a class="card-link collapsed tm" data-toggle="collapse" href="#A-{{$i}}">
                                        {{ $rowCompanyFaqs->question }}
                                    </a>
                                    <a class="plus-minus collapsed" data-toggle="collapse" href="#A-{{$i}}">
                                        <div class="minus-line"></div>
                                        <div class="plus-line"></div>
                                    </a>
                                </div>
                                <div id="A-{{$i}}" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p class="bm">{{ $rowCompanyFaqs->answer }}</p>
                                    </div>
                                </div>
                            </div>
                            @php($i++)
                            @endforeach
                            @endif
                        </div>
                    </div>


                    <div class="cmp_templates">
                        @if (!empty($model->toArray()))
                        @php($j = 1)
                        @foreach ($model as $keyCompanyJobCom => $rowCompanyJobCom)
                        <div id="add-que_{{$keyCompanyJobCom}}" class="section_templates">
                            <input type="hidden" name="CompanyJobCommunications[faqCustom][{{$keyCompanyJobCom}}][id]" value="{{$rowCompanyJobCom->id}}">
                            <a href="javascript:void(0)" class="close-section" data-id="{{ $keyCompanyJobCom }}">
                                <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                            </a>
                            <div class="input-textarea">
                                <div class="input-groups">
                                    <span>Enter question</span>
                                    <input type="text" name="CompanyJobCommunications[faqCustom][{{$keyCompanyJobCom}}][question]" value="{{ $rowCompanyJobCom->question }}" />
                                </div>
                                <div class="input-groups">
                                    <span>Enter answer</span>
                                    <textarea name="CompanyJobCommunications[faqCustom][{{$keyCompanyJobCom}}][answer]">{{ $rowCompanyJobCom->answer }}</textarea>
                                </div>
                            </div>
                        </div>
                        @php($j++)
                        @endforeach
                        @endif
                    </div>

                    <div class="text-right">
                        <button type="button" class="blue-btn add-templates">
                            <img src="{{asset('public/assets/frontend/img/blue-plus.svg')}}" alt="" />Add question
                        </button>
                    </div>
                    @else
                    <span>Please add at least one template from your profile. <a href="{{route('companyCommunicationManagment')}}">Click here</a>.</span>
                    @endif
                    <div class="JQ-btn-block">
                        <a href="{{route('jobQuestionnaireShow')}}" class="border-btn">Back</a>
                        <button type="submit" name="submit_type" value="1" class="border-btn">Save as a Draft</button>
                        @if ($showPayment)
                            <button type="submit" name="submit_type" value="2" class="fill-btn">Continue</button>
                        @else
                            <button type="submit" name="submit_type" value="1" class="fill-btn">Update</button>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<script type="text/javascript">
    $(document).ready(function() {
        checkDefault();
        var countFaqs = '{{ $countFaqs }}';
        $('.add-templates').click(function() {
            $.ajax({
                url: "{{ url('company-job-add-faqs') }}",
                type: 'post',
                data: 'countFaqs=' + countFaqs + '&_token={{ csrf_token() }}',
                success: function(response) {
                    $('.cmp_templates').append(response);
                    countFaqs++;
                    validateForm();
                }
            });
        })
        validateForm();
    });

    $(document).delegate('.close-section', 'click', function() {
        var id = $(this).data('id');
        $('#add-que_' + id).remove();
    })

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

    $(document).on('change', 'select[name="companyJob[job_communication_template_id]"]', function() {
        var templateId = $(this).val();
        getTemplateDetails(templateId)
    })

    function getTemplateDetails(templateId) {
        var url = "{{route('getCommunicationTemplateData')}}";
        $.ajax({
            url: url,
            type: 'post',
            data: {
                templateId: templateId,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
                $('.communication_template').html(response);
                checkDefault();
            }
        })
    }

    $("#companyJobForm").validate({
        ignore: [],
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
        var companyFaqs = $('input[name^="CompanyJobCommunications[faqCustom]"]');
        var companyFaqsTextarea = $('textarea[name^="CompanyJobCommunications[faqCustom]"]');

        companyFaqs.filter('input[name$="[question]"]').each(function() {
            $(this).rules("add", {
                required: true,
            });
        });

        companyFaqsTextarea.filter('textarea[name$="[answer]"]').each(function() {
            $(this).rules("add", {
                required: true,
            });
        });
    }
</script>
@endsection