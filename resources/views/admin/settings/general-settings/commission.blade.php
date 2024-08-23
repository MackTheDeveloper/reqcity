<?php

use App\Models\GlobalSettings;
?>
<div class="tab-pane " id="commission" role="tabpanel">
    <form id="updateFooterDetailsForm" class="" method="post" action="{{ url(config('app.adminPrefix').'/settings') }}">
        @csrf
        <div class="row">
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="sms_api_key" class="font-weight-bold">Recruiter's Bank Details Link</label>
                    <div>
                        <input type="text" class="form-control" id="recruiterBankDetailLink" name="settings[recruiterBankDetailLink]" placeholder="Enter Bank Details Link" value="{{ GlobalSettings::getSingleSettingVal('recruiterBankDetailLink')}}" />
                    </div>
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sms_api_key" class="font-weight-bold">Job Approval Amount ($)</label>
                    <div>
                        <input type="number" class="form-control" id="job_post_amount" name="settings[job_post_amount]" placeholder="Enter Job Approval Amount" value="{{ GlobalSettings::getSingleSettingVal('job_post_amount')}}" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="otp_validity_min" class="font-weight-bold">Recruiter Commission ($)</label>
                    <div>
                        <input type="number" class="form-control" id="job_recruiter_commission" name="settings[job_recruiter_commission]" placeholder="Enter Recruiter Commission" value="{{ GlobalSettings::getSingleSettingVal('job_recruiter_commission')}}" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="otp_validity_min" class="font-weight-bold">ReqCity Commission ($)</label>
                    <div>
                        <input type="number" class="form-control" id="job_admin_comission" name="settings[job_admin_comission]" placeholder="Enter ReqCity Commission" value="{{ GlobalSettings::getSingleSettingVal('job_admin_comission')}}" />
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="addFooterDetails">Update</button>
        </div>
    </form>
</div>
