@forelse($data as $key=>$row)
<div class="col-6 col-sm-6 col-md-6 col-lg-3 singleProduct">
    <div class="bookmark">
        <div class="bookmark-img productLike active" data-product-id="{{$row->product_id}}" ></div>
        <div class="inner-bookmark">
            <img src="{{$row->baseUrl.$row->main_image}}">
            <img src="{{asset('public/assets/frontend/img/play-circle.svg')}}" onclick="playVideo(event)" class="start">
            <img src="{{asset('public/assets/frontend/img/pause-circle.svg')}}" onclick="stopVideo(event)" class="stop">
        </div>
        <span><a href="{{ route('product.details',$row->product_id) }}">{{$row->title}}</a></span>
    </div>
</div>
@empty
<div class="col-12 text-center py-3">
	<p>No products found for your search.</p>
</div>
@endforelse
