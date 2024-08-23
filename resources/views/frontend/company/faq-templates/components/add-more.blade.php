<div class="section_templates" id="section_templates_{{ $countFaqs }}">
    <a href="javascript:void(0)" class="close-section" data-id="{{ $countFaqs }}">
        <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
    </a>
    <div class="collapse show" id="add-que-{{ $countFaqs }}">
        <div class="que-add-question">
            <div class="que-ans-type">
                <div class="input-groups first">
                    <span>Enter question</span>
                    <input type="text" name="companyFaqs[{{ $countFaqs }}][question]" id="company-faqs-city-{{ $countFaqs }}" value="" />
                </div>
                <div class="input-groups second">
                    <span>Sort Order</span>
                    <input type="text" name="companyFaqs[{{ $countFaqs }}][sort_order]" id="company-faqs-sort_order-{{ $countFaqs }}" value="" />
                </div>
            </div>
            <div>
                <div class="input-groups mb-24">
                    <span>Enter Answer</span>
                    <textarea name="companyFaqs[{{ $countFaqs }}][answer]" id="company-faqs-answer-{{ $countFaqs }}"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>