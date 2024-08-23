@foreach($data as $key=>$row)
	@if($row->componentId == 'profileComponent')
		@foreach($row->profileComponentData->list as $key2=>$row2)
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb24">
			<div class="p-with-success" data-aos="fade-up">
				<img src="{{$row2->profilePic}}">
				<a href="{{ route('professional.details',$row2->id) }}"><p class="s1">{{$row2->title}}</p></a>
				@if($row2->isVerify)
					<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">
				@endif
			</div>
			<a href="{{ route('professional.details',$row2->id) }}" class="img-bottom-content" data-aos="fade-up">
				<img src="{{$row2->image}}">
				<span>{{$row2->subTitle}}</span>
			</a>
		</div>
		@endforeach
	@endif

	@if($row->componentId == 'verticalSliderComponent')
		@foreach($row->verticalSliderComponentData->list as $key2=>$row2)
		<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb24">
			<div class="p-with-success" data-aos="fade-up">
				<img src="{{$row2->profilePic}}">
				<a href="{{ route('professional.details',$row2->id) }}"><p class="s1">{{$row2->title}}</p></a>
				@if($row2->isVerify)
					<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">
				@endif
			</div>
			<a href="{{ route('professional.details',$row2->id) }}" class="img-bottom-content" data-aos="fade-up">
				<img src="{{$row2->image}}">
				<span>{{$row2->subTitle}}</span>
			</a>
		</div>
		@endforeach
	@endif
@endforeach