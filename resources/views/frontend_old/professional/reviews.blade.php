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


<section class="review--ratings add-top-pad">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-md-1 col-md-10">
				<div class="b-bottom">
					<div class="row">
						<div class="col-12">
							<a class="back-arrow" href="{{ route('professional.details',$profileData->profileId) }}">
								
							</a>
						</div>
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
		</div>
	</div>
</section>

<section class="add-review-sec" id="addReviewSection" style="display: none;">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-md-1 col-md-10">
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
		</div>
	</div>
</section>

@if(!empty($reviewData->list))
<section class="profile-review add-bottom-pad">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-md-1 col-md-10">
				@foreach($reviewData->list as $key => $list)
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
			@endforeach
			</div>
		</div>
	</div>
</section>
@endif

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
		$("body").on("click", ".productLike", function() {
			var token = @json(csrf_token());
			var id = $(this).attr('data-productId');
			$.ajax({
				url: "{{ route('professional.toggleLike') }}",
				method: 'post',
				data: 'product_id=' + id + '&_token=' + token,
				success: function(e) {
					// 		if(e.statusCode == "200"){
					// // 			var products = e.component[1].productListComponentData.list;
					// // 			var options = '';
					// // 			for(var i=0;i<products.length;i++){
					// // 				options += '<option value="'+products[i].id+'">'+products[i].title+'</option>';

					// // 			}
					// // 			$("#product_id").html(options);
					// 		}
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