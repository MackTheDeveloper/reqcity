<div class="detail-role-card mb-3 card">
    <div class="card-body">
        <div class="card-body-header">
            <h5>Account Information</h5>
            @if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_edit'))
                <a class="openModalEditInfo" data-id="account" href="javascript:void(0)"><i
                        class="fa fa-edit"></i></a>
            @endif
        </div>

        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm" for="exampleFormControlInput1">First Name</label>
                            <p>{{ $model->first_name }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm" for="exampleFormControlInput1">Last Name</label>
                            <p>{{ $model->last_name }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm" for="exampleFormControlInput1">Email</label>
                            <p>{{ $model->email }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="tm" for="exampleFormControlInput1">Phone</label>
                            <p>{{ $model->phone_ext }}-{{ $model->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if ($model->currentSubscription())
                <div class="col-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="tm">Current subscription</label>
                                @if (!$model->user->is_subscription_cancelled && whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_cancel_subscription'))
                                    <button class="btn btn-primary btn-sm pull-right btn-square cancel_subscription"
                                        type="button">Cancel</button>
                                @endif
                                <p>${{ $model->currentSubscription()->amount }}/{{ ucfirst($model->currentSubscription()->plan_type) }}
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="tm">Subscription valid until</label>
                                <p>{{ getFormatedDate($model->user->subscription_expire_at) }}</p>
                            </div>
                        </div>
                        @if ($model->user->is_subscription_cancelled)
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="tm">Reason for Cancelled</label>
                                    <p>{{ $model->user->cancel_reason }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
