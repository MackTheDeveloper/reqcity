@foreach ($discover as $discover)
<div class="col-sm-6 col-md-6 col-lg-4">
	<div class="discover-title">
		<img src="{{isset($discover->profilePic) ? $discover->profilePic : url('public/assets/frontend/img/harsh/SQP.svg')}}" class="profile-discover img-fluid">
		<p class="s2">{{$discover->title}}</p>
		@if($discover->isVerify == 1)<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">@endif
	</div>

	<div class="discover-content">
		<div class="discover-bookmark">
			<?php if (strpos($discover->image, '.mp4')  !== false) { ?>
				<video controls class="img-fluid">
					<source src="{{$discover->image}}" type="video/mp4">
				</video>
			<?php } else { ?>
				<img src="{{$discover->image}}" class="img-fluid">
			<?php } ?>
			@if(auth()->check())
				<div class="bookmark-img postLike {{$discover->isWishlist?'active':''}}" data-post-id="{{$discover->id}}" ></div>
			@endif
		</div>
		<span>{{$discover->post}}</span>
	</div>

</div>
@endforeach