<div class="detail-role-card mb-3 card">
    <div class="card-body">
        <h5>Account Information</h5>
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm">Your name</label>
                            <p>{{ $company->companyUser->name }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm">Email</label>
                            <p>{{ $company->companyUser->email }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm">Company name</label>
                            <p>{{ $company->name }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm">Phone number</label>
                            <p>{{ $company->companyUser->phone_ext }}-{{ $company->companyUser->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if ($company->companyUser->currentSubscription())
                <div class="col-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="tm">Current subscription</label>
                                @if (!$company->companyUser->user->is_subscription_cancelled && whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_cancel_subscription'))
                                    <button class="btn btn-primary btn-sm pull-right btn-square cancel_subscription"
                                        type="button">Cancel</button>
                                @endif
                                <p>${{ $company->companyUser->currentSubscription()->amount }}/{{ ucfirst($company->companyUser->currentSubscription()->plan_type) }}
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="tm">Subscription valid until</label>
                                <p>{{ getFormatedDate($company->companyUser->user->subscription_expire_at) }}</p>
                            </div>
                        </div>
                        @if ($company->companyUser->user->is_subscription_cancelled)
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="tm">Reason for Cancelled</label>
                                    <p>{{ $company->companyUser->user->cancel_reason }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
