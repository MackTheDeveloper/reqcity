<div class="accounts-boxlayouts d-none" id="account-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>Account Info</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="{{ url('/recruiter-myinfo') }}"><img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo1" method="POST" action="{{url('/recruiter-myinfo-update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>First name</span>
                        <input type="hidden" id="rec_id" value="{{$data->id}}">
                        <input type="text" name="User[firstname]" value="{{$data->user->firstname}}">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>Last name</span>
                        <input type="text" name="User[lastname]" value="{{$data->user->lastname}}">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="text" value="{{$data->user->email}}" id="email" name="User[email]">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="number-groups">
                        <span>Phone number</span>
                        <div class="number-fields">
                            <input type="text" id="phoneField1" name="Recruiter[phone_ext]" class="phone-field" value="{{$data->phone_ext}}" />
                            <input type="number" class="mobile-number" value="{{$data->phone}}" name="Recruiter[phone]">
                        </div>
                    </div>
                </div>
        </form>
        <div class="col-md-12 col-lg-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="{{ url('/recruiter-myinfo') }}">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div>