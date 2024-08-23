@foreach($products as $key => $row)
<div class="col-6 col-sm-6 col-md-3 col-lg-2">
	<div class="bookmark" data-aos="zoom-in">
		@if(auth()->check())
		<div class="bookmark-img productLike {{$row->isLiked?'active':''}}" data-product-id="{{$row->id}}"></div>
		@endif
		<div class="inner-bookmark">
			@if($row->mediaType=='1')
			<a href="{{ route('product.details',$row->id) }}">
				<img src="{{$row->image}}">
			</a>
			@else
			<video id="sample_video" poster="img/" src= "{{$row->image}}" type="video/mp4">
			</video>
			<img src="{{asset('public/assets/frontend/img/play-circle.svg')}}" onclick="playVideo(event)" class="start">
			<img src="{{asset('public/assets/frontend/img/pause-circle.svg')}}" onclick="playVideo(event)" class="stop">
			@endif
		</div>
		<span><a href="{{ route('product.details',$row->id) }}">{{$row->title}}</a></span>
	</div>
</div>
@endforeach
