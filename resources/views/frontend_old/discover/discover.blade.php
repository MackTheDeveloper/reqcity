@extends('frontend.layouts.master')
@section('title', 'Discover')
@section('content')
<div class="discover-searchbar">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-4 col-lg-6">
				<h2 data-aos="fade-right">Discover</h2>
			</div>
			<div class="col-md-5 col-lg-4">
				<form class="discover-search" data-aos="zoom-in">
					<input type="text" name="search_discover" class="search_discover" id="search_discover" placeholder="Search">
					<button class="search_discover_btn"><img src="{{url('public/assets/frontend/img/search.svg')}}"></button>
				</form>
			</div>
			<div class="col-md-3 col-lg-2">
				<a data-aos="zoom-in" href="{{route('addDiscoverPost')}}" onclick="return isUserLoggedIn('Please login to add the post');" class="fill-btn disc-uploadbtn"><span class="plus-icon">+</span>UPLOAD</a>
			</div>
		</div>
	</div>
</div>

<section class="discover-grid">
	<div class="container">
		<div class="row discover-container">
			@foreach ($discover as $discover)
			<div class="col-sm-6 col-md-6 col-lg-4">
				<div class="discover-title" data-aos="fade-up">
					<img src="{{isset($discover->profilePic) ? $discover->profilePic : url('public/assets/frontend/img/harsh/SQP.svg')}}" class="profile-discover img-fluid">
					<p class="s2">{{$discover->title}}</p>
					@if($discover->isVerify == 1)<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">@endif
				</div>

				<div class="discover-content" data-aos="fade-up">
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
		</div>

		<div class="row" data-aos="fade-up">
			<div class="col-sm-12 col-md-12" style="text-align: center"><button class="border-btn load-more-discover">LOAD MORE</button></div>
		</div>

	</div>
</section>

@endsection

@section('footscript')
<script>
	let page = 1;
	let csrfToken = "{{ csrf_token() }}";

	$(document).on("click",".postLike",function(){
	    var token = @json(csrf_token());
	    var id = $(this).data('post-id');
	    $.ajax({
	        url:"{{ route('discover.toggleLike') }}",
	        method:'post',
	        data:'post_id='+id+'&_token='+token,
	        success:function(e){
	        }
	    })
	});
</script>
<script src="{{asset('public/assets/js/frontend/discover/discover.js')}}"></script>
@endsection