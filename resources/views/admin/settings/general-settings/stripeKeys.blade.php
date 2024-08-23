<?php

use App\Models\GlobalSettings;
?>
<div class="tab-pane " id="stripe_keys" role="tabpanel">
    <form id="updateFooterDetailsForm" class="" method="post" action="{{ url(config('app.adminPrefix').'/settings') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sms_api_key" class="font-weight-bold">Public Key</label>
                    <div>
                        <input type="text" class="form-control" id="STRIPE_KEY" name="settings[STRIPE_KEY]" placeholder="Enter Public Key" value="{{ GlobalSettings::getSingleSettingVal('STRIPE_KEY')}}" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="otp_validity_min" class="font-weight-bold">Secret Key</label>
                    <div>
                        <input type="text" class="form-control" id="STRIPE_SECRET" name="settings[STRIPE_SECRET]" placeholder="Enter Secret Key" value="{{ GlobalSettings::getSingleSettingVal('STRIPE_SECRET')}}" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="otp_validity_min" class="font-weight-bold">Webhook Secret Key</label>
                    <div>
                        <input type="text" class="form-control" id="STRIPE_ENDPOINT_SECRET" name="settings[STRIPE_ENDPOINT_SECRET]" placeholder="Enter Secret Key" value="{{ GlobalSettings::getSingleSettingVal('STRIPE_ENDPOINT_SECRET')}}" />
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="addFooterDetails">Update</button>
        </div>
    </form>
</div>
