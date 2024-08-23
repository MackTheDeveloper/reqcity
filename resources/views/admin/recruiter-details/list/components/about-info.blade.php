<div class="detail-role-card mb-3 card">
    <div class="card-body">
        <div class="card-body-header">
            <h5>About</h5>
            @if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_edit'))
            <a class="openModalEditInfo" data-id="about" href="javascript:void(0)" ><i class="fa fa-edit"></i></a>
            @endif
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Website</label>
                    <p>{{$model->website? :'N/A'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Country</label>
                    <p>{{$model->Country && $model->Country->name  ? $model->Country->name :'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Address line 1</label>
                    <p>{{$model->address_1?:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Address line 2</label>
                    <p>{{$model->address_2?:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">City</label>
                    <p>{{$model->city?:'-'}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Zip code</label>
                    <p>{{$model->postcode?:'-'}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
