<div class="modal-header">
    <h6 class="modal-title">{{$model->id?'Edit Address':'Add Address'}}</h6>
    <button type="button" class="close" data-bs-dismiss="modal">
        <img src="{{asset('public/assets/frontend/img/close.svg')}}" alt="" />
    </button>
</div>

<!-- Modal body -->
<form id="addressAdd" method="POST" action="{{$model->id ? route('companyAddressUpdate',$model->id) : route('companyAddressStore') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="company_id" id="comapany_id" value="{{$companyId}}">
        <input type="hidden" name="address_id" id="address_id" value="{{$model->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input-groups">
                <span>Country</span>
                <select name="country" id="country">
                     @foreach ($countries as $key => $row)
                     <option value="{{ $row['key'] }}"
                    {{ $row['key'] == $model->country ? 'selected' : '' }}>
                     {{ $row['value'] }}</option>
                     @endforeach
                </select>
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>City</span>
                    <input type="text" id="city" name="city" value="{{$model->city}}" />
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>State</span>
                    <input type="text" id="state" name="state" value="{{$model->state}}" />
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Address line 1</span> 
                    <input type="text" id="address_1" name="address_1" value="{{$model->address_1}}"/>  
                </div>
            </div>
            <div class="col-12 d-none">
                <div class="input-groups">
                    <span>Address line 2</span>
                    <input type="text" id="address_2" name="address_2" value="{{$model->address_2}}"/>                    
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Zip Code</span>
                    <input type="text" id="postcode" name="postcode" value="{{$model->postcode}}" />                    
                </div>
            </div>
            <div class="col-12 radio-groups">                
                <div class="input-groups">
                    <label class="ck">Is Default?
                        <input type="checkbox" class="notification" name="def_address" id="def_address" value="1" {{($model->def_address==1)?'checked':''}}/>
                        <span class="ck-checkmark"></span>
                    </label>
                </div>
            </div>
        </div>
           
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="border-btn" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" id="{{$model->id ? 'updateButton':'submitButton'}}" class="fill-btn formSubmitBtn">{{$model->id ? 'Update Address':'Add Address'}}</button>
    </div>
</form>