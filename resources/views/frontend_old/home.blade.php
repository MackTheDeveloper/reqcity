@section('title',$cms?$cms->name:'Home page')
@section('metaKeywords',$cms?$cms->seo_meta_keyword:'')
@section('metaDescription',$cms?$cms->seo_description:'')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
    HOME START
--------------------------->

<!--WEB VIEW HOME PART START -->
<div class="web-home-part mt-5">
	<div class="container">
		<div class="row">
			@foreach ($homePageComponentProductCategories as $key=>$row)
			<div class="col-2 col-md-3 col-lg-2">
				<a href="{{ route('professional.list',$row->id) }}" class="img-center-text" data-aos="zoom-in">
					<img src="{{$row->image}}">
					<div class="s2 ucase">{{$row->title}}</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>
<!--WEB VIEW HOME PART START -->

<!--MOBILE VIEW HOME PART START -->
<div class="mobile-home-part">
	<div class="left-container">
		<div class="owl-carousel owl-theme home-part-carousel">
			@foreach ($homePageComponentProductCategories as $key=>$row)
			<div class="item">
				<a href="{{ route('professional.list',$row->id) }}" class="img-center-text">
					<img src="{{$row->image}}"> 
					<div class="s2">{{$row->title}}</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>
<!--MOBILE VIEW HOME PART END -->

<section class="profe--company">
	<div class="container">
		<h2 data-aos="fade-right">Professional & Company</h2>
			<div class="row append-ajax">
				@foreach ($professionalAndCompanyData as $pc1)
				@if($pc1->componentId == 'profileComponent')
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 for-more" style="display: block;">
					<div class="p-with-success" data-aos="zoom-in">
						<img src="{{$pc1->profileComponentData->list[0]->profilePic}}">
						<a href="{{route('professional.details',[$pc1->profileComponentData->list[0]->id])}}">
							<p class="s1">{{$pc1->profileComponentData->list[0]->title}}</p>
						</a>
						@if($pc1->profileComponentData->list[0]->isVerify == 1)<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">@endif
					</div>
					<a href="{{route('professional.details',[$pc1->profileComponentData->list[0]->id])}}" class="img-bottom-content" data-aos="zoom-in-up">
						<img src="{{$pc1->profileComponentData->list[0]->image}}">
						<span>{{$pc1->profileComponentData->list[0]->subTitle}}</span>
					</a>
				</div>
				@endif

				@if($pc1->componentId == 'verticalSliderComponent')
				@foreach ($pc1->verticalSliderComponentData->list as $professionalAndCompanyDataLocation)
				<div class="col-12 col-sm-6 col-md-6 col-lg-3 for-more" style="display: block;">
					<div class="p-with-success" data-aos="zoom-in">
						<img src="{{$professionalAndCompanyDataLocation->profilePic}}">
						<a href="{{route('professional.details',[$professionalAndCompanyDataLocation->id])}}">
							<p class="s1">{{$professionalAndCompanyDataLocation->title}}</p>
						</a>
						@if($professionalAndCompanyDataLocation->isVerify == 1)<img src="{{url('public/assets/frontend/img/harsh/Sucess-badge.png')}}" class="profile-verified img-fluid">@endif
					</div>
					<a href="{{route('professional.details',[$professionalAndCompanyDataLocation->id])}}" class="img-bottom-content" data-aos="zoom-in-up">
						<img src="{{$professionalAndCompanyDataLocation->image}}">
						<span>{{$professionalAndCompanyDataLocation->subTitle}}</span>
					</a>
				</div>
				@endforeach
				@endif
				@endforeach
			</div>
		</div>
		<div class="text-center">
			<input type="hidden" name="pageNum" value="1">
			<button id="loadMoreProfessional" class="border-btn">LOAD MORE</button>
			<a href="{{ route('professional.seeMore') }}" id="seeMoreProfessional" class="border-btn" style="display: none;">SEE ALL</a>
		</div>
	</div>
</section>


<section class="product-home">
	<div class="container">
		<div class="header-see-all">
			<h2 data-aos="fade-right">Products</h2>
			<a data-aos="fade-up" href="{{route('product.list')}}">SEE ALL</a>
		</div>
		<div class="row">
			@foreach ($professionalAndCompanyData as $pc2)
			@if($pc2->componentId == 'productComponent')
			@foreach ($pc2->productComponentData->list as $pc3)
			<div class="col-6 col-sm-6 col-md-3 col-lg-2">
				<div class="bookmark" data-aos="zoom-in">
					@if(auth()->check())
					<div class="bookmark-img productLike {{$pc3->isLiked?'active':''}}" data-product-id="{{ $pc3->id }}"></div>
					@endif
					<div class="inner-bookmark">
						@if($pc3->mediaType=='1')
						<a href="{{ route('product.details',$pc3->id) }}"><img src="{{$pc3->image}}" alt="product image"></a>
						@else
						<video id="sample_video" poster="img/" src="{{$pc3->image}}" type="video/mp4">
						</video>
						<img src="{{asset('public/assets/frontend/img/play-circle.svg')}}" onclick="playVideo(event)" class="start">
						<img src="{{asset('public/assets/frontend/img/pause-circle.svg')}}" onclick="playVideo(event)" class="stop">
						@endif
					</div>
					<span><a href="{{ route('product.details',$pc3->id) }}">{{$pc3->title}}</a></span>
				</div>
			</div>
			@endforeach
			@endif
			@endforeach
		</div>
	</div>
</section>


<section class="container">
	<div class="register-home-banner" data-aos="fade-up">
		<img src="{{url('public/assets/images/homepage_register_banner/'. $homepageRegistrationBannerData['homepageRegistrationBanner'])}}">
		<div class="overlay">
			<h2>Register as a Professional</h2>
			<span>{{$homepageRegistrationBannerData['homepageRegistrationBannerText']}}</span>
			<a onclick="return isUserLoggedIn('Please login to register as professional');" href="{{route('ProfessionalRegister')}}" class="fill-btn">REGISTER NOW</a>
		</div>
	</div>
</section>


<section class="home-blog">
	<div class="container">
		<div class="header-see-all">
			<h2 data-aos="fade-right">Blogs</h2>
			<a data-aos="fade-up" href="{{route('getBlogListing')}}">SEE ALL</a>
		</div>
		<div class="row">
			@foreach ($recentBlogs as $key=>$b)
			<div class="col-sm-12 col-md-6 col-lg-4" @if($key>0) data-aos="fade-up" data-aos-delay="{{$key*100}}" @endif>
				<div class="blog-listing-item" data-aos="fade-up">
					<a href="{{route('getBlogDetail',[$b->id])}}">
					<img src="{{url('public/assets/images/blog_image/'. $b->image)}}">
						<h5 class="s1">{!!$b->title!!}</h5>
					</a>
					<span>{!!strip_tags($b->short_description)!!}</span>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>

<!--------------------------
    	  HOME END
--------------------------->
@endsection

@section('footscript')
<script type="text/javascript">
	$(document).on('click','#loadMoreProfessional',function(){
		var token = @json(csrf_token());
		var page = $('input[name="pageNum"]').val();
		page = parseInt(page)+1;
		// var formData = $('.sort_filter').serializeArray();
		var formData = $('.sort_filter').serialize()+ '&_token=' + token+ '&page=' + page+'&viewType=ajax';
		var cageory = "{{Request::route('id')}}"
		$.blockUI();
		$.ajax({
			url:"{{ route('professional.list') }}",
            method:'post',
            data:formData,
            success:function(response){
            	if(response){
            		$('input[name="pageNum"]').val(page);
            		$('.append-ajax').append(response);
            	}else{
            		$('#loadMoreProfessional').hide()
            		$('#seeMoreProfessional').show()
            	}
	            $.unblockUI();

            }
		});
	});
</script>
@endsection