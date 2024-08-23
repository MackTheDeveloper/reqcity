<div class="detail-role-card mb-3 card">
    <div class="card-body">
        <h5>Banking Info</h5>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Bank location</label>
                    <p>{{ isset($model->recruiterBankDetail->Country->name) ? $model->recruiterBankDetail->Country->name : '-' }}
                    </p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Payment Currency</label>
                    <p>{{ isset($model->recruiterBankDetail->currency_code) ? $model->recruiterBankDetail->currency_code : '-' }}
                    </p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Bank Name</label>
                    <p>{{ isset($model->recruiterBankDetail->bank_name) ? $model->recruiterBankDetail->bank_name : '-' }}
                    </p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">SWIFT code</label>
                    <p>{{ isset($model->recruiterBankDetail->swift_code) ? $model->recruiterBankDetail->swift_code : '-' }}
                    </p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Bank address</label>
                    <p>{{ isset($model->recruiterBankDetail->bank_address) ? $model->recruiterBankDetail->bank_address : '-' }}
                    </p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">City</label>
                    <p>{{ isset($model->recruiterBankDetail->bank_city) ? $model->recruiterBankDetail->bank_city : '-' }}
                    </p>
                </div>
            </div>
            @if($w9FormLink)
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">W-9</label>
                    <div class="resume-uploded-label">
                        <a href="{{ $w9FormLink }}" download>
                            <img src="{{ asset('public/assets/frontend/img/pdf-orange.svg') }}" alt="pdf">
                        </a>
                        <p>W-9 Form</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
