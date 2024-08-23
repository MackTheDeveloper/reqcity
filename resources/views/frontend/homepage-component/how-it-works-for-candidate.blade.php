<h2>{{ $howItWorksCandidateData['title']}}</h2>
<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-6">
		<div class="pr-24">
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCandidateData['feature_1'])? $howItWorksCandidateData['feature_1']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCandidateData['description_1'])? $howItWorksCandidateData['description_1']:''}}</span>
			</div>
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCandidateData['feature_2'])? $howItWorksCandidateData['feature_2']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCandidateData['description_2'])? $howItWorksCandidateData['description_2']:''}}</span>
			</div>
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCandidateData['feature_3'])? $howItWorksCandidateData['feature_3']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCandidateData['description_3'])? $howItWorksCandidateData['description_3']:''}}</span>
			</div>
			<div class="title-value">
				<p class="tm">{{ ($howItWorksCandidateData['feature_4'])? $howItWorksCandidateData['feature_4']:''}}</p>
				<span class="bl blur-color">{{ ($howItWorksCandidateData['description_4'])? $howItWorksCandidateData['description_4']:''}}</span>
			</div>
			@if (!Auth::check())
				<a href="{{url('/candidate-signup')}}" class="fill-btn">Apply to a Job</a>
			@endif
		</div>
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-6 hide-991">
		<img src="{{$howItWorksCandidateData['Image']}}" alt="" />
	</div>
</div>
