<div class="home-page">
		<div class="home-page-head">
				<div class="container">
						<div class="row">
								<div class="col-12 col-sm-12 col-md-7">
										<div class="head-page-content h-100">
												<h1>{{$bannerData['Header']}}<br>
													{{$bannerData['Title']}}</h1>
												<p class="bl">{{$bannerData['SubTitle']}}</p>
												<!-- <div class="head-btn-block">
														<a href="{{url('/company-signup')}}" class="border-btn">Company</a>
														<a href="{{url('/recruiter-signup')}}" class="border-btn">Recruiter</a>
														<a href="{{url('/candidate-signup')}}" class="border-btn">Candidate</a>
												</div> -->
												<div class="get-start-btn">
													@if (Auth::check())
												    @if(Auth::user()->role_id=='3')
												    	<a class="fill-btn" href="{{url('/company-dashboard')}}">Go to dashboard!</a>
												    @elseif(Auth::user()->role_id=='4')
												    	<a class="fill-btn" href="{{url('recruiter-dashboard')}}">Go to dashboard!</a>
														@elseif(Auth::user()->role_id=='5')
															<a class="fill-btn" href="{{url('candidate-dashboard')}}">Go to dashboard!</a>
												    @endif
											    @else
											    	<a class="fill-btn" href="{{url('/signup')}}">Sign up now!</a>
											    @endif

												</div>
												<div class="layout-636">
													@if(!empty($bannerData['CompanyLine']))
													<p class="ll">{!! $bannerData['CompanyLine'] !!}</p>
													@endif
													@if(!empty($bannerData['RecruiterLine']))
													<p class="ll">{!! $bannerData['RecruiterLine'] !!}</p>
													@endif
													@if(!empty($bannerData['CandidateLine']))
													<p class="ll">{!! $bannerData['CandidateLine'] !!}</p>
													@endif
												</div>
										</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
										<div class="head-page-img pl-24">
												<img src="{{ $bannerData['MainBanner'] }}" alt="" />
										</div>
								</div>
						</div>
				</div>
		</div>
