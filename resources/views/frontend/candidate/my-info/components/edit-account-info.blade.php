<div class="accounts-boxlayouts d-none" id="account-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>Account Info</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="{{ url('/candidate-myinfo') }}"><img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo1" method="POST" action="{{url('/candidate-myinfo-update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>First name</span>
                        <input type="hidden" value="{{$candidate->id}}" id="candidate_id">
                        <input type="text" name="User[firstname]" value="{{$candidate->user->firstname}}">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>Last name</span>
                        <input type="text" name="User[lastname]" value="{{$candidate->user->lastname}}">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="text" value="{{$candidate->user->email}}" name="User[email]" id="email">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="number-groups">
                        <span>Phone number</span>
                        <div class="number-fields">
                            <input type="text" id="phoneField1" name="phone_ext" class="phone-field" value="{{$candidate->phone_ext}}" />
                            <input type="number" class="mobile-number" value="{{$candidate->phone}}" name="phone">
                        </div>
                    </div>
                </div>
        </form>
        <div class="col-md-12 col-lg-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="{{ url('/candidate-myinfo') }}">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div>