@section('title', ($model->id ? 'Edit' : 'Create') . ' Communication Template')
@extends('frontend.layouts.master')
@section('content')
@php($countFaqs = !empty($model->companyFaqs) ? count($model->companyFaqs) : 0)
@if ($countFaqs == 0)
@php($countFaqs = 1)
@endif
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
                                    <h6>{{($model->id ? 'Edit' : 'Create')}} Communication Template</h6>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class=" ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="companyComTemplate" method="POST" action="{{$model->id?route('updateCompanyCommunicationManagment',$model->id):route('storeCompanyCommunicationManagment')}}">
                                            @csrf
                                            <div class="questionarie-mangement-create">
                                                <div class="select-template-ques">
                                                    <div class="input-groups">
                                                        <span>Title</span>
                                                        <input type="text" name="companyFaqsTemplates[title]" id="company_faqs_templates_title" value="{{$model->title}}" />
                                                    </div>
                                                </div>
                                                <span class="full-hr-ac"></span>
                                                <div class="addque-managment">
                                                    <div class="cmp_templates">
                                                        @if (!empty($model->companyFaqs->toArray()))
                                                        @php($i = 1)
                                                        @foreach ($model->companyFaqs as $keyCompanyFaqs => $rowCompanyFaqs)
                                                        <div class="section_templates" id="section_templates_{{ $keyCompanyFaqs }}">
                                                            <input type="hidden" name="companyFaqs[{{$keyCompanyFaqs}}][id]" value="{{$rowCompanyFaqs->id}}">
                                                            <a href="javascript:void(0)" class="close-section" data-id="{{ $keyCompanyFaqs }}">
                                                                <img class="{{$i == 1 ? 'd-none' : ''}}" src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                                            </a>
                                                            <div id="add-que-{{ $keyCompanyFaqs }}" class="collapse show">
                                                                <div class="que-add-question">
                                                                    <div class="que-ans-type">
                                                                        <div class="input-groups first">
                                                                            <span>Enter question</span>
                                                                            <input type="text" name="companyFaqs[{{ $keyCompanyFaqs }}][question]" id="company-faqs-city-{{ $keyCompanyFaqs }}" value="{{ $rowCompanyFaqs->question }}" />
                                                                        </div>
                                                                        <div class="input-groups second">
                                                                            <span>Sort Order</span>
                                                                            <input type="text" name="companyFaqs[{{ $keyCompanyFaqs }}][sort_order]" id="company-faqs-sort_order-{{ $keyCompanyFaqs }}" value="{{ $rowCompanyFaqs->sort_order }}" />
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="input-groups mb-24">
                                                                            <span>Enter Answer</span>
                                                                            <textarea name="companyFaqs[{{ $keyCompanyFaqs }}][answer]" id="company-faqs-answer-{{ $keyCompanyFaqs }}">{{ $rowCompanyFaqs->answer }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php($i++)
                                                        @endforeach
                                                        @else
                                                        <div class="section_templates" id="">
                                                            <a href="javascript:void(0)" class="close-section">
                                                                <img class="d-none" src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                                            </a>
                                                            <div id="add-que-0" class="collapse show">
                                                                <div class="que-add-question">
                                                                    <div class="que-ans-type">
                                                                        <div class="input-groups first">
                                                                            <span>Enter question</span>
                                                                            <input type="text" name="companyFaqs[0][question]" id="company-faqs-city-0" value="" />
                                                                        </div>
                                                                        <div class="input-groups second">
                                                                            <span>Sort Order</span>
                                                                            <input type="text" name="companyFaqs[0][sort_order]" id="company-faqs-sort_order-0" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="input-groups mb-24">
                                                                            <span>Enter Answer</span>
                                                                            <textarea name="companyFaqs[0][answer]" id="company-faqs-answer-0"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="text-right add-ques-btns">
                                                        <button class="blue-btn add-templates" type="button">
                                                            <img src="{{asset('public/assets/frontend/img/blue-plus.svg')}}" alt="" />Add question
                                                        </button>
                                                    </div>
                                                    <div class="">
                                                        <div class="JQ-btn-block">
                                                            <a href="{{route('companyCommunicationManagment')}}" class="border-btn">Cancel</a>
                                                            <button type="submit" class="fill-btn">{{ $model->id ? 'Update' : 'Create'}}</a>
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
        var countFaqs = '{{ $countFaqs }}';
        $('.add-templates').click(function() {
            $.ajax({
                url: "{{ url('company-add-faqs') }}",
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
        $('#section_templates_' + id).remove();
    })

    $("#companyComTemplate").validate({
        ignore: [],
        rules: {
            "companyFaqsTemplates[title]": "required",
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
        var companyFaqs = $('input[name^="companyFaqs"]');
        var companyFaqsTextarea = $('textarea[name^="companyFaqs"]');

        companyFaqs.filter('input[name$="[question]"]').each(function() {
            $(this).rules("add", {
                required: true,
            });
        });

        companyFaqs.filter('input[name$="[sort_order]"]').each(function() {
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