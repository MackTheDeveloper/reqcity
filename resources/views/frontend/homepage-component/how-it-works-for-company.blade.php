<h2>{{ $howItWorksCompanyData['title']}}</h2>
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="pr-24">
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCompanyData['feature_1'])? $howItWorksCompanyData['feature_1']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCompanyData['description_1'])? $howItWorksCompanyData['description_1']:''}}</span>
			</div>
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCompanyData['feature_2'])? $howItWorksCompanyData['feature_2']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCompanyData['description_2'])? $howItWorksCompanyData['description_2']:''}}</span>
			</div>
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCompanyData['feature_3'])? $howItWorksCompanyData['feature_3']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCompanyData['description_3'])? $howItWorksCompanyData['description_3']:''}}</span>
			</div>
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCompanyData['feature_4'])? $howItWorksCompanyData['feature_4']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCompanyData['description_4'])? $howItWorksCompanyData['description_4']:''}}</span>
			</div>
			@if (!Auth::check())
				<a href="{{url('/company-signup')}}" class="fill-btn">Post a Job</a>
			@endif
		</div>
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-6 hide-991">
		<img src="{{$howItWorksCompanyData['Image']}}" alt="" />
	</div>
</div>
