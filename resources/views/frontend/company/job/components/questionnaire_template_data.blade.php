<div class="que-select-header mb-0">
    <p class="tl">Select questions</p>
    <label class="ck">Select All
        <input class="all-checks" type="checkbox" />
        <span class="ck-checkmark"></span>
    </label>
</div>
<div id="accordion" class="req-accordian">
    @foreach ($data as $key=>$item)    
        <div class="card">
            <div class="card-header">
                <label class="only-ck">
                    <input class="single-checks" type="checkbox" {{($selected && in_array($item->id,$selected))?"checked":""}} name="company_questionnaire_id[]" value="{{$item->id}}" />
                    <span class="only-ck-checkmark"></span>
                </label>
                <a class="card-link tm" data-toggle="collapse" href="#A-{{$key}}">{{$item->question}}</a>
                @if (isset($types[$item->question_type]))
                <a class="plus-minus {{$key?'collapsed':''}}" data-toggle="collapse" href="#A-{{$key}}">
                    <div class="minus-line"></div>
                    <div class="plus-line"></div>
                </a>
                @endif

            </div>
            @if (isset($types[$item->question_type]))
            <div id="A-{{$key}}" class="collapse {{$key?'':'show'}}" data-parent="#accordion">
                <div class="card-body">
                    @if (!empty($item->Options->toArray()))
                        @if ($types[$item->question_type]['type']=='dropdown')
                            <div class="input-groups">
                                <select readonly>
                                    @foreach ($item->Options as $option)
                                        <option>{{$option->option_value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($types[$item->question_type]['type']=='checkbox')
                            <div class="ck-and-radio">
                            @foreach ($item->Options as $option)
                                <label class="ck">
                                    {{$option->option_value}}
                                    <input type="checkbox" disabled />
                                    <span class="ck-checkmark"></span>
                                </label>
                            @endforeach
                            </div>
                        @elseif ($types[$item->question_type]['type']=='radiobutton')
                            <div class="ck-and-radio">
                            @foreach ($item->Options as $option)
                                <label class="rd">
                                    <input type="radio" disabled />
                                    <span class="rd-checkmark"></span>
                                    {{$option->option_value}}
                                </label>
                            @endforeach
                            </div>
                        @elseif ($types[$item->question_type]['type']=='ratings')
                            @foreach ($item->Options as $option)
                                <label class="rd">
                                    <input type="radio" disabled />
                                    <span class="rd-checkmark"></span>
                                    {{$option->option_value}}
                                </label>
                            @endforeach
                        @endif
                    @else
                        @if ($types[$item->question_type]['type']=='textbox')
                            <div class="input-groups">
                                <input type="text" readonly>
                            </div>
                        @elseif ($types[$item->question_type]['type']=='textarea')
                            <div class="input-groups">
                                <textarea class="textarea" readonly></textarea>
                            </div>
                        @elseif ($types[$item->question_type]['type']=='date')
                            <div class="input-groups">
                                <input type="text" placeholder="dd/mm/yyyy" readonly>
                            </div>
                        @elseif ($types[$item->question_type]['type']=='datetime')
                            <div class="input-groups">
                                <input type="text" placeholder="dd/mm/yyyy hh:ii:ss" readonly>
                            </div>
                        @elseif ($types[$item->question_type]['type']=='upload document')
                            <input type="file"  readonly>
                        @elseif ($types[$item->question_type]['type']=='upload image')
                            <input type="file"  readonly>
                        @endif
                    @endif
                </div>
            </div>
            @endif
        </div>
    @endforeach
</div>
