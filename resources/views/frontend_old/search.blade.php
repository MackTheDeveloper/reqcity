@extends('frontend.layouts.master')
@section('title','Product and Professional Search')
@section('metaTitle','Product and Professional Search')
@section('metaKeywords','Product and Professional Search')
@section('metaDescription','Product and Professional Search')
@section('metaImage','')
@section('content')
<section class="only-product">
	<div class="container">
		<h2 data-aos="fade-up">Products</h2>
		<div class="row">
			@if($viewData['productListComponentData']->list)
				@include('frontend.product.products',['products'=>$viewData['productListComponentData']->list])
			@else
				<div class="col-12 text-center my-4"><p>No products found.</p></div>
			@endif
		</div>
	</div>
</section>
<!--Professionals Listing-->
<section class="profe--company">
	<div class="container">
		<h2 data-aos="fade-up" class="aos-init aos-animate">Professional & Company</h2>
		<div class="row">
			@forelse($viewData['profileComponentData']->list as $professional)
			<div class="col-12 col-sm-6 col-md-6 col-lg-3 without-more">
				<div class="p-with-success aos-init aos-animate" data-aos="zoom-in">
					<img src="{{ $professional->profilePic }}">
					<a href="{{ route('professional.details',$professional->id) }}"><p class="s1">{{ $professional->title }}</p></a>
				</div>
				<a href="{{ route('professional.details',$professional->id) }}" data-aos="zoom-in-up" data-aos-once="ture" class="img-bottom-content aos-init aos-animate">
					<img src="{{ $professional->image }}">
					<span>{{ $professional->subTitle }}</span>
				</a>
			</div>
			@empty
			<div class="col-12 text-center my-4"><p>No professionals found.</p></div>
			@endforelse
		</div>
		<!-- <div class="text-center">
			<button id="loadMore" class="border-btn">LOAD MORE</button>
		</div> -->
	</div>
</section>
@endsection