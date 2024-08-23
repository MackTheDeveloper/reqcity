@foreach($list as $professional)
<div class="col-12 col-sm-6 col-md-6 col-lg-3 without-more">
	<div class="p-with-success aos-init aos-animate">
		<img src="{{ $professional->profilePic }}">
		<a href="{{ route('professional.details',$professional->id) }}"><p class="s1">{{ $professional->title }}</p></a>
		@if($professional->isVerify)
			<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">
		@endif
	</div>
	<a href="{{ route('professional.details',$professional->id) }}"  class="img-bottom-content aos-init aos-animate">
		<img src="{{ $professional->image }}">
		<span>{{ $professional->subTitle }}</span>
	</a>
</div>
@endforeach