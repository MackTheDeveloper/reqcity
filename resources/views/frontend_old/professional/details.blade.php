<?php
$imageData = $viewData['profileImageData'];
$profileData = $viewData['profileDetailsComponentData'];
$reviewData = $viewData['reviewData'];
$productData = $viewData['productListComponentData'];
// dd($viewData);
?>
@extends('frontend.layouts.master')
@section('title',$profileData->companyName)
@section('metaTitle',$profileData->about)
@section('metaKeywords',$profileData->about)
@section('metaDescription',$profileData->about)
@section('metaImage',$imageData->image?:'')
@section('content')
<!-----------------------------
    PROFILE TOP BANNER START
------------------------------>
<input type="hidden" id="user_id" value="{{ $profileData->profileId }}">
<section class="profile-banner">
	@if($imageData->image)
	<img src="{{ $imageData->image }}" alt="professional banner">
	@endif
	<div class="container">
		<div class="upper-layer">
			<div class="profile-banner-img">
				<!-- <img src="img/SQP.svg"> -->
				@if($imageData->profileImg)
				<img src="{{ $imageData->profileImg }}" alt="profile image">
				@endif
			</div>
			<div class="inner-layer">
				<div class="profile-banner-name">
					<h2>
						{{ $profileData->companyName }}&nbsp;
						@if($profileData->isSubscribed)
						<img src="{{asset('public/assets/frontend/img/Sucess-badge.svg')}}" />
						@endif
					</h2>
					<ul class="share-btns-detail">
						<li>
							<a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer.php?u={{ url()->current() }}" title="Share this post on Facebook">
								<img src="{{ url('public/assets/frontend/img/harsh/fb.svg') }}" alt="facebook" class="img-fluid">
							</a>
						</li>
						<li>
							<a href="https://twitter.com/share?url={{url()->current()}}&text={{ $profileData->companyName }}" target="_blank">
								<img src="{{ url('public/assets/frontend/img/harsh/twitter.svg') }}" alt="twitter" class="img-fluid">
							</a>

						</li>
						<li>
							<a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/link/?url={{url()->current()}}&media={{$imageData->image}}&description={{ $profileData->about  }}" title="{{ $profileData->companyName }}">
								<img src="{{ url('public/assets/frontend/img/harsh/pinterest.svg') }}" class="img-fluid">
							</a>
						</li>
						<li>
							<a rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url={{url()->current()}}&title={{$profileData->companyName}}&summary={{$profileData->about}}&source={{ $profileData->companyName }}">
								<img src="{{ url('public/assets/frontend/img/harsh/lin.svg') }}" class="img-fluid">
							</a>
						</li>
					</ul>
					<!-- <a href=""><img src="img/PShare.svg"></a> -->
				</div>
				<div class="inner-content-btn">
					<div class="left-content">
						<span>{{ $profileData->about }}</span>
					</div>
					<div class="right-btn">
						<a href="{{ route('enquiry').'?id='.$profileData->profileId }}" onclick="return isUserLoggedIn();" class="fill-btn">Enquiry</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!----------------------------
    PROFILE TOP BANNER END
----------------------------->
@if(!empty($profileData->categorylist))
<section class="category">
	<div class="container">
		<h3>Category</h3>
		<ul>
			@foreach($profileData->categorylist as $list)
			<li><span>{{ $list->leftText }}</span></li>
			@endforeach
		</ul>
	</div>
</section>
@endif

@if(!empty($profileData->designsImagelist) || $profileData->portfolio)
<section class="design-sec">
	<div class="container">
		{{-- <h2>Designs</h2> --}}
		<h2>Designs @if($profileData->portfolio)<small><a target="_blank" href="{{$profileData->portfolio}}"><i class="fa fa-file-pdf"></i></a></small>@endif</h2>
		@if(!empty($profileData->designsImagelist))
		<div class="row">
			@foreach($profileData->designsImagelist as $list)
			<div class="col-6 col-sm-4 col-md-3 col-lg-2">
				<a href="javascript:void(0)" onclick="openImageModal('{{ $list->image }}','Design Image')">
					<img src="{{ $list->image }}" alt="professional designs">
				</a>
			</div>
			@endforeach
		</div>
		@endif
	</div>
</section>
@endif


<section class="work--technical-experience">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="work-experience">
					<h2>Work Experience</h2>
					<span>{{($profileData->workExp)?:' - '}}</span>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-8 col-lg-6">
				<div class="technical-experience">
					<h2>Technical Skills</h2>
					<ul>
					@foreach($profileData->technicalSkillsList as $key => $skill)
						<li><span>{{ $skill->text }}</span></li>
					@endforeach
					</ul>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-8 col-lg-3">
				<div class="technical-experience">
					<h2>Team Members</h2>
					<span>{{$profileData->team_members?:'-'}}</span>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="review--ratings">
	<div class="container">
		<div class="b-bottom">
			<div class="row">
				<div class="col-12 col-sm-6">
					<h2>Reviews & Ratings</h2>
					<div class="star-with-value">
						<div class="big-star show-star">
							@for($i=1;$i<=5;$i++) <div class="{{ ($reviewData->rating >= $i)?'fill-star':'blank-star' }}">
						</div>
						@endfor
						<!-- <div class="fill-star"></div>
							<div class="fill-star"></div>
							<div class="fill-star"></div>
							<div class="blank-star"></div> -->
					</div>
					<p class="s1">{{ number_format($reviewData->rating,1) }}</p>
				</div>
			</div>
			<div class="col-12 col-sm-6 text-left text-sm-right align-self-end">
				<a href="javascript:void(0)" class="fill-btn" id="addReviewBtn">ADD REVIEW</a>
			</div>
		</div>
	</div>
	</div>
</section>

<section class="add-review-sec" id="addReviewSection" style="display: none;">
	<div class="container">
		<div class="a-b-bottom">
			<h2>Add Reviews</h2>
			<form action="{{ route('professional.addReview') }}" id="reviewForm" enctype="multipart/form-data" method="post">
				@csrf
				<div class="mw-728">
					<div class="row">
						<div class="col-12 col-sm-6">
							<div class="select-group">
								<?php $categories = !empty($profileData->categorylist) ? $profileData->categorylist : []; ?>
								<label>Select Catogery*</label>
								<select name="category_id" id="category_id">
									<option value="">Select...</option>
									@foreach($categories as $cat)
									<option value="{{ $cat->id }}">{{ $cat->leftText }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="select-group">
								<label>Select Product*</label>
								<select name="product_id" id="product_id">
									<option value="">Select...</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-sm-12">
							<div class="image-preview">
								<output id="Filelist"></output>
								<label class="fileinput-button">
									<input type="file" name="uploads[]" id="files" multiple="" accept="image/jpeg, image/png, image/gif," class="file-hj">
									<img src="{{ url('public/images/paperclip.svg') }} " alt="Attach" class="attach-img">
									<span class="file-custom">Attach image</span>
								</label>
							</div>
						</div>
						<div class="col-12 col-sm-12 mt-3">
							<form class="add-ratting-star">
								<ul id="stars">
									<li class="star red-star" title="Poor" data-value="1"></li>
									<li class="star green-star" title="Fair" data-value="2"></li>
									<li class="star green-star" title="Good" data-value="3"></li>
									<li class="star yellow-star" title="Excellent" data-value="4">
									</li>
									<li class="star yellow-star" title="WOW!!!" data-value="5"></li>
								</ul>
								<input type="hidden" name="reviews" id="star_value">
							</form>
						</div>
						<div class="col-12 col-sm-12">
							<textarea placeholder="Message" name="message" class="textarea"></textarea>
						</div>
						<div class="col-12 col-sm-12 mt-3">
							{!! NoCaptcha::renderJs() !!}
		                    {!! NoCaptcha::display() !!}
		            
		                    @if ($errors->has('g-recaptcha-response'))
		                        <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
		                    @endif
						</div>
						<div class="col-12 col-sm-12">
							<button type="submit" class="fill-btn">Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@if(!empty($reviewData->list))
<section class="profile-review">
	<div class="container">
		@foreach($reviewData->list as $key => $list)
		@if($key<2)
		<div class="myreviews-item">
			<div class='rating-stars'>
				<div class="show-star">
					@for($i=1;$i<=5;$i++) <div class="{{ ($list->rating >= $i)?'fill-star':'blank-star' }}">
				</div>
				@endfor
			</div>
			<span>{{ $list->reviewDate }}</span>
		</div>
		<div class="review-description">
			<span>{{ $list->reviewDetail }}</span>
		</div>
		@foreach($list->productReviewImages as $image)
		<a href="javascript:void(0);" onclick="openImageModal('{{$image->mediaData}}','Review Image')"><img src="{{ $image->mediaData }}" class="img-reviews" alt="Product review image">
		</a>
		@endforeach
		<br>
		<!-- <span class="des--line">{{ $list->reviewFromText }}</span> -->
		<span>{{ $list->reviewFromText }}</span>
	</div>
	@endif
	@endforeach
	<div class="text-center">
		<a href="{{ route('professional.reviews',$profileData->profileId) }}" class="border-btn">MORE REVIEWS</a>
	</div>
	</div>
</section>
@endif


<section class="only-product">
	<div class="container">
		<h2>Products</h2>
		<div class="row">
			@foreach($productData->list as $item)
			<div class="col-6 col-sm-6 col-md-3 col-lg-2">
				<div class="bookmark">
					@if(auth()->check())
					<div class="bookmark-img productLike {{ $item->isLiked==1?'active':'' }}" data-product-id="{{ $item->id }}"></div>
					@endif
					<div class="inner-bookmark">
						@if($item->mediaType == 2)
						<video id="sample_video" poster="img/" src="{{ $item->image }}">
						</video>
						<img src="{{ url('public/assets/frontend/img/play-circle.svg') }}" onclick="playVideo(event)" class="start">
						<img src="{{ url('public/assets/frontend/img/pause-circle.svg') }}" onclick="pauseVideo(event)" class="stop">
						@else
						<a href="{{ route('product.details',$item->id) }}">
						<img src="{{ $item->image }}" alt="Product image">
						</a>
						@endif
					</div>
					<span><a href="{{ route('product.details',$item->id) }}">{{ $item->title }}</a></span>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>

@endsection
@section('footscript')
<script>
	$(document).ready(function() {
		$("body").on("click", "#addReviewBtn", function() {
			if (isUserLoggedIn()) {
				$("#addReviewSection").fadeIn();
			}
		})
		$("body").on("change", "#category_id", function() {
			var category_id = $(this).val();
			var user_id = $("#user_id").val();
			$.ajax({
				url: "{{ url('api/'.config('app.api_version').'/product/list') }}",
				method: 'get',
				data: 'categoryId=' + category_id + '&userId=' + user_id,
				success: function(e) {
					if (e.statusCode == "200") {
						var products = e.component[1].productListComponentData.list;
						var options = '';
						for (var i = 0; i < products.length; i++) {
							options += '<option value="' + products[i].id + '">' + products[i].title + '</option>';

						}
						$("#product_id").html(options);
					}
				}
			})
		});
		$("#reviewForm").validate({
			ignore: [],
			rules: {
				category_id: "required",
				product_id: "required",
				message: "required",
				reviews: "required",
				"g-recaptcha-response": "required",
			},
			errorPlacement: function(error, element) {
				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.next("label"));
				} else {
					error.insertAfter(element);
				}
			},
		});
	})
</script>
@endsection