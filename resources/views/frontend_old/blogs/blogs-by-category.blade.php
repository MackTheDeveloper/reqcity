@foreach ($blogs as $blogs)
<div class="col-md-6 blog-listing-item" data-aos="fade-up">
	<a href="{{route('getBlogDetail',[$blogs->id])}}"><img src="{{url('public/assets/images/blog_image/'. $blogs->image)}}" class="img-fluid" style="height: 280px"></a>
		<h5 class="s1"><a href="{{route('getBlogDetail',[$blogs->id])}}">{!!$blogs->short_description!!}</a></h5>
		<span>{!!strip_tags($blogs->long_description)!!}</span>
</div>
@endforeach