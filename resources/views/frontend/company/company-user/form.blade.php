<div class="modal-header">
    <h6 class="modal-title">{{$model->id?'Edit User':'Add User'}}</h6>
    <button type="button" class="close" data-bs-dismiss="modal">
        <img src="{{asset('public/assets/frontend/img/close.svg')}}" alt="" />
    </button>
</div>

<!-- Modal body -->
<form id="userCreate" method="POST" action="{{$model->id ? route('companyUserUpdate') : route('companyUserStore') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" id="user-id" value="{{$model->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input-groups">
                    <span>Your name</span>
                    <input type="hidden" name="company_id" id="company_id" value="{{$companyId}}">
                    <input type="text" name="name" value="{{$model->name}}" />
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Email</span>
                    <input type="email" id="email" name="email" value="{{$model->email}}" />
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Password</span>
                    <div class="password-field-wrapper">
                        <input type="password" id="password" name="password" />
                        <div class="password-icon"></div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Confirm Password</span>
                    <div class="password-field-wrapper">
                        <input type="password" id="conform-password" name="conform-password" />
                        <div class="password-icon"></div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="number-groups">
                    <span>Phone Number</span>
                    <div class="number-fields">
                        <input type="text" id="phoneField1" name="phone_ext" class="phone-field" value="{{$model->phone_ext}}" />
                        <input type="number" class="mobile-number" name="phone" value="{{$model->phone}}">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Designation</span>
                    {{--<select>
                                        <option>Select...</option>
                                        <option>Web Developer...</option>
                                    </select> --}}
                    <input type="text" name="designation" value="{{$model->designation}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input-groups">
                    <span>Is admin</span>
                    <select name="is_owner">
                        <option value="1" {{$model->is_owner == 1 ? 'selected':''}}>Yes</option>
                        <option value="0" {{$model->is_owner == 0 ? 'selected':''}}>No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="border-btn" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" id="{{$model->id ? 'updateButton':'submitButton'}}" class="fill-btn formSubmitBtn">{{$model->id ? 'Update User':'Add User'}}</button>
    </div>
</form>