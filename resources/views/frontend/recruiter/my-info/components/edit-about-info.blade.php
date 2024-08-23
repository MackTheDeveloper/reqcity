<div class="accounts-boxlayouts d-none" id="about-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>About</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="{{ url('/recruiter-myinfo') }}"><img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo2" method="POST" action="{{url('/recruiter-myinfo-update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                        <div class="input-groups">
                            <span>website</span>
                            <input type="text" name="Recruiter[website]" value="{{$data->website}}">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                                <span>Country</span>
                                <select name="Recruiter[country]" id="country">
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
                            <span>Address line 1</span>
                            <input type="text" value="{{$data->address_1}}" name="Recruiter[address_1]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Address line 2</span>
                            <input type="text" value="{{$data->address_2}}" name="Recruiter[address_2]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>City</span>
                            <input type="text" value="{{$data->city}}" name="Recruiter[city]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Zip code</span>
                            <input type="text" value="{{$data->postcode}}" name="Recruiter[postcode]">
                        </div>
                </div>
        </form>
        <div class="col-md-6">
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