<div class="accounts-boxlayouts d-none" id="account-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>Account Info</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="{{ url('/company-myinfo') }}"><img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo1" method="POST" action="{{url('/company-myinfo-update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 col-lg-6">
                        <div class="input-groups">
                            <span>Your name</span>
                            <input type="text" name="companyUser[yourName]" value="{{$data->companyUserName}} {{$data->lastname}}">
                        </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    
                            <div class="input-groups">
                                <span>Email</span>
                                <input type="hidden" value="{{$data->companyUserId}}" id="company_user_id" >
                                <input type="email" id="email" name="companyUser[email]" value="{{$data->userEmail}}">
                            </div>
                        
                </div>
                <div class="col-md-12 col-lg-6">
                    
                        <div class="input-groups">
                            <span>Company name</span>
                            @if($data->is_owner)
                            <input type="text" value="{{$data->companyName}}" name="company[name]">
                            @else
                            <label for="companyName">{{$data->companyName}}</label>
                            @endif
                        </div>
                   
                </div>
                <div class="col-md-12 col-lg-6">
                    
                        <div class="number-groups">
                            <span>Phone number</span>
                            <div class="number-fields">
                                <input type="text" id="phoneField1" name="companyUser[phoneField1]" class="phone-field" value="{{$data->companyUserPhoneExt}}" />
                                <input type="number" class="mobile-number" value="{{$data->companyUserPhone}}" name="companyUser[phoneNumber]">
                            </div>
                        </div>
                    
                </div>
        </form>
        <div class="col-md-12 col-lg-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="{{ url('/company-myinfo') }}">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div>