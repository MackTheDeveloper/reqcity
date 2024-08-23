<div id="add-que_{{ $countFaqs }}" class="section_templates">
    <a href="javascript:void(0)" class="close-section" data-id="{{ $countFaqs }}">
        <img  src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
    </a>
    <div class="input-textarea">
        <div class="input-groups">
            <span>Enter question</span>
            <input type="text" name="CompanyJobCommunications[faqCustom][{{ $countFaqs }}][question]" value="" />
        </div>
        <div class="input-groups">
            <span>Enter answer</span>
            <textarea name="CompanyJobCommunications[faqCustom][{{ $countFaqs }}][answer]"></textarea>
        </div>
    </div>
</div>