<div class="detail-role-card mb-3 card">
    <div class="card-body">
        <h5>Company Information</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group text-center">
                    <img src="{{ $company->logo }}" alt="" style="width: 160px;border-radius:50%;" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Website</label>
                    <p>{{ $company->website }}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Company size</label>
                    <p>{{ $company->JobFieldOptions ? $company->JobFieldOptions->option : '-' }}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Email</label>
                    <p>{{ $company->email }}</p>
                </div>
            </div>
            @if($company->address)
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Country</label>
                    <p>{{ $company->address->countries->name }}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">City</label>
                    <p>{{ $company->address->city }}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Zip code</label>
                    <p>{{ $company->address->postcode }}</p>
                </div>
            </div>
            @endif
            <div class="col-12">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">About company</label>
                    <p>{{ $company->about }}</p>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="tm" for="exampleFormControlInput1">Why work here?</label>
                    <p>{{ $company->why_work_here }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
