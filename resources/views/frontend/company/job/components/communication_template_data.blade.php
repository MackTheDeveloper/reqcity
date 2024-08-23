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