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
			<div class="col-12 offset-md-1 col-md-10">
				<section class="review--ratings add-top-pad">
					<div class="b-bottom">
						<div class="row">
							<div class="col-12 col-sm-6">
								<a href="{{ route('product.details',$product->productId) }}" class="back-arrow"></a>
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
							<input type="hidden" name="category_id" id="category_id" value="1">
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
				<section class="profile-review add-bottom-pad">
					@foreach($reviewData->list as $key => $list)
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
					@endforeach
				</section>
				@endif
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
	            category_id: "required",
	            product_id: "required",            
	            message: "required",            
	            reviews: "required",            
	            "g-recaptcha-response": "required",            
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