<div class="accounts-boxlayouts d-none" id="bank-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>Banking Info</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="{{ url('/recruiter-myinfo') }}"><img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo3" method="POST" action="{{url('/recruiter-myinfo-update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Account number</span>
                            <input type="text" value="{{ (isset($data->recruiterBankDetail->account_number)) ? $data->recruiterBankDetail->account_number : '-'}}" name="RecruiterBank[account_number]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                                <span>Bank location</span>
                                <select name="RecruiterBank[bank_country]" id="country">
                                    @if($data->country)
                                    @foreach($countries as $key=>$row)
                                    <option value="{{$row['key']}}" {{ $row['key'] == $data->country ? "selected" : "" }}>{{$row['value']}}</option>
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
                            <span>Payment Currency</span>
                            <input type="text" value="{{ (isset($data->recruiterBankDetail->currency_code)) ? $data->recruiterBankDetail->currency_code : '-'}}" name="RecruiterBank[currency_code]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Bank Name</span>
                            <input type="text" value="{{(isset($data->recruiterBankDetail->bank_name)) ? $data->recruiterBankDetail->bank_name:'-'}}" name="RecruiterBank[bank_name]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>SWIFT code</span>
                            <input type="text" value="{{(isset($data->recruiterBankDetail->swift_code))?$data->recruiterBankDetail->swift_code:'-' }}" name="RecruiterBank[swift_code]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Bank address</span>
                            <input type="text" value="{{(isset($data->recruiterBankDetail->bank_address))?$data->recruiterBankDetail->bank_address:'-'}}" name="RecruiterBank[bank_address]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>City</span>
                            <input type="text" value="{{(isset($data->recruiterBankDetail->bank_city))?$data->recruiterBankDetail->bank_city:'-' }}" name="RecruiterBank[bank_city]">
                        </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12" id="upload">
                    <div class="upload-form-btn">
                        <img src="{{ asset('public/assets/frontend/img/upload-icon.svg') }}" id="upload-form-img" alt="" />
                        <p class="tm" id="upload-form-text">Upload form W-9</p>
                        <input type="file" id="upload-form-file" name="w9File" hidden="hidden" />
                    </div>
                    @if($w9FormLink)
                    <div class="upload-form-btn">
                        <a href="{{$w9FormLink}}" download>
                            <img src="{{ asset('public/assets/frontend/img/pdf.svg') }}" alt="" />
                        </a>
                        <p class="tm" id="upload-form-text">Download form W-9</p>
                    </div>
                    @endif
                </div>
        </form>
        <div class="col-md-6">
            <div class="save-cancel-edit mt-24">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="{{ url('/recruiter-myinfo') }}">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div>