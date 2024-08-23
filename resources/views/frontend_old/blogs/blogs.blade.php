@extends('frontend.layouts.master')
@section('title', 'Blog')
@section('content')

<section data-aos="zoom-in" class="blog-banners" style="background-image: url('public/assets/frontend/img/harsh/blogs.jpg');">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Blogs</h1>
			</div>
		</div>
	</div>
</section>

<section class="blog-toplinks">
	<div class="container">
		<div class="toplinks-inner">
			<div class="dropdowns-toplinks" id="">
				All
			</div>
			<ul class="dropdwn-togle-toplinks">
				<li data-aos="zoom-in" class="active"><a data-category_id='' href="javascript:void(0)">All</a></li>
				@foreach ($blogCategories as $blogCategories)
				<li><a data-category_id="{{$blogCategories->id}}" href="javascript:void(0)">{{$blogCategories->name}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</section>

<section class="blog-listing-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-8">
				<div class="blog-listing-main">
					<div class="row blogsContainer">

						@foreach ($blogs as $blogs)
						<div class="col-md-6 blog-listing-item" data-aos="fade-up">
							<a href="{{route('getBlogDetail',[$blogs->id])}}"><img src="{{url('public/assets/images/blog_image/'. $blogs->image)}}" class="img-fluid"></a>
							<h5 class="s1"><a href="{{route('getBlogDetail',[$blogs->id])}}">{!!$blogs->short_description!!}</a></h5>
							<span>{!!strip_tags($blogs->long_description)!!}</span>
						</div>
						@endforeach


					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-4">
				<div class="recent-blogs pl-lg-24">
					<h2>Recent Blogs</h2>
					<div class="row">

						@foreach ($recentBlogs as $recentBlogs)
						<div class="col-12 recentblog-items" data-aos="fade-up">
							<img onclick="location.href ='{{route('getBlogDetail',[$recentBlogs->id])}}'" src="{{url('public/assets/images/blog_image/'. $recentBlogs->image)}}" class="img-fluid">
							<div class="recentblog-title">
								<h5><a href="{{route('getBlogDetail',[$recentBlogs->id])}}">{{$recentBlogs->title}}</a></h5>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('footscript')
<script>
	let csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{asset('public/assets/js/frontend/blogs/blogs.js')}}"></script>
@endsection