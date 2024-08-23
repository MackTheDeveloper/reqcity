<?php
$imageData = $viewData['productImageData'];  
$product = $viewData['productDetailsComponentData'];  
$reviewData = $viewData['reviewData'];  
$productData = $viewData['productListComponentData'];  
?>
@extends('frontend.layouts.master')
@section('title',$product->productName)
@section('metaTitle',$product->productName)
@section('metaKeywords',$product->productName)
@section('metaDescription',$product->productName)
@section('metaImage','')
@section('content')
<!--------------------------
    Product Details START
--------------------------->
<section class="product-detailpage">
	<div class="container">
		<div class="row">
			@if(!empty($imageData->list))
			<div class="col-md-6 offset-lg-1 col-lg-5">
				<div class="prodetail-gallery">
					<img src="{{ $imageData->list[0]->image }}" id="largeImage">
				</div>
				<div class="prothumb-gallery">
					<div id="thumbnails" class="owl-carousel gallery-carousel">
						@foreach($imageData->list as $img)
						<div class=" gallerythumb-item">
							<img src="{{$img->image}}" alt="Product Image">
						</div>
						@endforeach
							
					</div>
				</div>
			</div>
			@endif
			<div class="col-md-6 col-lg-5">
				<div class="productdetail-content">
					<div class="product-details-main">
						<div class="prodetail-title">
							<h2>{{ $product->productName }}</h2>
							<div class="products-share">
								@if(auth()->check())
								<div class="bookmark-img productLike {{ $product->isLiked==1?'active':'' }}" data-product-id="{{ $product->productId }}"></div>
								@endif
								
							</div>
						</div>
						<ul class="share-btns-detail float-right">
									<li>
										<a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer.php?u={{ url()->current() }}" title="Share this post on Facebook">
											<img src="{{ url('public/assets/frontend/img/harsh/fb.svg') }}" alt="facebook" class="img-fluid">
										</a>
									</li>
									<li>
										<a href="https://twitter.com/share?url={{url()->current()}}&text={{ $product->productName }}" target="_blank">
											<img src="{{ url('public/assets/frontend/img/harsh/twitter.svg') }}" alt="twitter" class="img-fluid">
										</a>

									</li>
									<li>
										<a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/link/?url={{url()->current()}}&description={{$product->subTitleText}}" title="Share this post on Pinterest">
											<img src="{{ url('public/assets/frontend/img/harsh/pinterest.svg') }}" class="img-fluid">
										</a>
									</li>
									<li>
										<a rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url={{url()->current()}}&title={{ $product->productName }}&summary={{ $product->subTitleText }}&source={{ $product->productName }}">
											<img src="{{ url('public/assets/frontend/img/harsh/lin.svg') }}" class="img-fluid">
										</a>
									</li>
								</ul>
						@php($product->price = str_replace(",","",$product->price))
						<p class="s1">₹ {{ number_format($product->price,2) }}</p>
						{!! $product->subTitleText !!}
					</div>
					<div class="productcat-content">
						<h2>Category</h2>
						<ul>
						@foreach($product->categorylist as $cat)
							<li>{{ $cat->leftText }}</li>
						@endforeach
						</ul>
					</div>
					<div class="enquiry-pdetail">
						<a href="{{ route('enquiry').'?product_id='.$product->productId }}" onclick="return isUserLoggedIn();" class="fill-btn">Enquiry</a>
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 offset-lg-1 col-lg-10">
				<section class="review--ratings">
					<div class="b-bottom">
						<div class="row">
							<div class="col-12 col-sm-6">
								<h2>Reviews & Ratings</h2>
								<div class="star-with-value">
									<div class="big-star show-star">
										@for($i=1;$i<=5;$i++)
											<div class="{{ ($reviewData->rating >= $i)?'fill-star':'blank-star' }}"></div>
										@endfor
									</div>
									<p class="s1">{{ number_format($reviewData->rating,1) }}</p>
								</div>
							</div>
							<div class="col-12 col-sm-6 text-left text-sm-right align-self-end">
								<a href="javascript:void(0)" class="fill-btn" id="addReviewBtn">ADD REVIEW</a>
							</div>
						</div>
					</div>
				</section>
				<section class="add-review-sec" id="addReviewSection" style="display: none;" >
					<div>
						<div class="a-b-bottom">
						<h2>Add Reviews</h2>
						<form action="{{ route('professional.addReview') }}" id="reviewForm" enctype="multipart/form-data" method="post">
							@csrf
							<input type="hidden" name="product_id" id="product_id" value="{{ $product->productId }}">
							<div class="mw-728">
								<div class="row">
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
					@foreach($reviewData->list as $key => $list)
					@if($key<2)
					<div class="myreviews-item">
						<div class='rating-stars'>
							<div class="show-star">
								@for($i=1;$i<=5;$i++)
									<div class="{{ ($list->rating >= $i)?'fill-star':'blank-star' }}"></div>
								@endfor
							</div>
							<span>{{ $list->reviewDate }}</span>
						</div>
						<div class="review-description">
							{{ $list->reviewDetail }}
						</div>
						@foreach($list->productReviewImages as $image)
							<a href="javascript:void(0);" onclick="openImageModal('{{$image->mediaData}}','Review Image')"><img src="{{ $image->mediaData }}" class="img-reviews" alt="Product review image">
							</a>
						@endforeach
						<br>
						<span>{{ $list->reviewFromText }}</span>
					</div>
					@endif
					@endforeach

					<div class="text-center">
						<a href="{{ route('product.reviews',$product->productId) }}" class="border-btn">ALL REVIEWS</a>
					</div>
				</section>
				@endif
			</div>
		</div>

		<div class="related-products">
			<div class="row">
				<div class="col-md-12 offset-lg-1 col-lg-10">
					<h2>Related Products</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-6 col-sm-6 col-md-6 col-lg-1 d-not-991"></div>
				@forelse($productData->list as $item)
				<div class="col-6 col-sm-6 col-md-4 col-lg-2">
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
				@empty
				<div class="col-12 text-center">No related products.</div>
				@endforelse
			</div>
		</div>
	</div>
</section>
<!--------------------------
    Product Details Ends
--------------------------->
@endsection
@section('footscript')
<script>
	
	$(document).ready(function(){
		$("body").on("click","#addReviewBtn",function(){
			if(isUserLoggedIn()){
				$("#addReviewSection").fadeIn();
			}
		})
		$("#reviewForm").validate( {
	        ignore: [],
	        rules: {
	            // category_id: "required",
	            product_id: "required",            
	            message: "required",            
	            reviews: "required",    
                "g-recaptcha-response":"required"
        
	        },
	        errorPlacement: function ( error, element ) {
	            if ( element.prop( "type" ) === "checkbox" ) {
                	error.insertAfter( element.next( "label" ) );
	            } else {
	                error.insertAfter( element );
	            }
	        },
	    });
	})
</script>
@endsection