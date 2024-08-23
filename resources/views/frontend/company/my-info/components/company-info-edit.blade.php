@if($data->is_owner)
<div class="accounts-boxlayouts d-none" id="company-info-edit">
    <form id="updateMyInfo2" method="POST" action="{{url('/company-myinfo-update')}}" enctype="multipart/form-data">
        @csrf
        <div class="ac-boclayout-header">
            <div class="boxheader-title">
                <h6>Company info</h6>
                <!-- <span>R01532</span> -->
            </div>
            <div class="boxlayouts-edit">
                <a href="{{ url('/company-myinfo') }}"><img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" /></a>
            </div>

        </div>
        <span class="full-hr-ac"></span>
        <div class="ac-boxlayouts-desc group-margin">
            <div class="row">
                <div class="col-md-12">
                    <div class="myinfo-compnaylogo">
                        <div class="avatar-upload">
                            <div class="avatar-edit drop-zone">
                                <input type="file" name="myFile" class="drop-zone__input image">
                                <input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
                                <label></label>
                            </div>
                            <div class="avatar-preview">
                                <img class="open-icon-select {{ $logo && $logo ? '' : 'd-none' }}" src="{{ $logo ? $logo : '' }}" alt="" />
                                @if (!$logo || empty($logo))
                                <span class="drop-zone__prompt">Attach or <br> drop logo <br> here</span>
                                @endif
                            </div>
                            <label id="myFile-error" class="error" for="myFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Website</span>
                            <input type="hidden" value="{{$data->companyId}}" id="company_id">
                            <input type="text" value="{{$data->website}}" name="company[website]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Company size</span>
                            <select name="company[strength]" id="company_stregth">
                                @if ($data)
                                @foreach ($companySize as $key => $row)
                                <option value="{{ $row['key'] }}" {{ $row['value'] == $data->strength ? 'selected' : '' }}>
                                    {{ $row['value'] }}
                                </option>
                                @endforeach
                                @else
                                @foreach ($companySize as $key => $row)
                                <option value="{{ $row['key'] }}">
                                    {{ $row['value'] }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Email</span>
                            <input type="text" id="email_company" name="company[email]" value="{{$data->companyEmail}}">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Country</span>
                            <select name="companyAddress[country]" id="country">
                                @if($data->countryId)
                                @foreach($countries as $key=>$row)
                                <option value="{{$row['key']}}" {{ $row['key'] == $data->countryId ? "selected" : "" }}>{{$row['value']}}</option>
                                @endforeach
                                @else
                                @foreach($countries as $key=>$row)
                                <option value="{{$row['key']}}" {{ $row['value'] == "United States" ? "selected" : "" }}>{{$row['value']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>City</span>
                            <input type="text" name="companyAddress[city]" value="{{$data->city}}">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                        <span>State</span>
                        <input type="text" value="{{$data->state}}" name="companyAddress[state]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Zip code</span>
                            <input type="text" name="companyAddress[postcode]" value="{{$data->postcode}}">
                        </div>
                </div>
                <div class="col-md-12">
                    <div class="input-groups">
                            <span>About company</span>
                            <textarea value="{{$data->about}}" name="company[about]">{{$data->about}}</textarea>
                        </div>
                        <div class="input-groups">
                            <span>Why work here?</span>
                            <textarea value="{{$data->why_work_here}}" name="company[why_work_here]">{{$data->why_work_here}}</textarea>
                        </div>
                </div>
    </form>
    <div class="col-md-12">
        <div class="save-cancel-edit mt-24">
            <button class="fill-btn" type="submit" value="Save">Save</button>
            <a href="{{ url('/company-myinfo') }}">
                <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
            </a>
        </div>
    </div>
</div>
</div>
</div>
@endif