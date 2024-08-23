<div class="modal fade" id="editInfoModal" tabindex="-1" role="dialog" aria-labelledby="editInfoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="account-change d-none hideable">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInfoModalLabel">Update Account Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('recruiterEditInfo', $model->id) }}">
                    <div class="modal-body">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div>
                            <div class="form-group">
                                <label for="last_name">First Name</label>
                                <div>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="Enter First name" value="{{ $model->first_name }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <div>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Enter last name" value="{{ $model->last_name }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Email</label>
                                <div>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter Email" disabled value="{{ $model->email }}" />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="last_name">Phone</label>
                                <div class="field-group col-12">
                                    <div class=" row">
                                        <input type="text" class="form-control col-2" id="phone_ext" name="phone_ext"
                                            placeholder="+1" value="{{ $model->phone_ext ?: '+1' }}" />
                                        <input type="text" class="form-control col-10" id="phone" name="phone"
                                            placeholder="Enter Phone" value="{{ $model->phone }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <div class="about-change d-none hideable">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInfoModalLabel">Update About Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('recruiterEditInfo', $model->id) }}">
                    <div class="modal-body">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div>
                            <div class="form-group">
                                <label for="last_name">Website</label>
                                <div>
                                    <input type="text" class="form-control" id="website" name="website"
                                        placeholder="Enter Website" value="{{ $model->website }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Country</label>
                                <div>
                                    <select class="form-control" id="country" name="country">
                                        <option value="0">Please Select...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country['key'] }}"
                                                {{ $model->country == $country['key'] ? 'selected' : '' }}>
                                                {{ $country['value'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Address line 1 </label>
                                <div>
                                    <input type="text" class="form-control" id="address_1" name="address_1"
                                        placeholder="Enter Address line 1" value="{{ $model->address_1 }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Address line 2 </label>
                                <div>
                                    <input type="text" class="form-control" id="address_2" name="address_2"
                                        placeholder="Enter Address line 2" value="{{ $model->address_2 }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">City</label>
                                <div>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Enter City" value="{{ $model->city }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Zipcode</label>
                                <div>
                                    <input type="text" class="form-control" id="postcode" name="postcode"
                                        placeholder="Enter Zipcode" value="{{ $model->postcode }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="rejectJobBalance">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
