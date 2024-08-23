@extends('frontend.layouts.master')
@section('title', 'Blog Detail')
@section('content')

<section class="blog-detail-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-8">
				<div class="blogdetail-main">
					<h2 data-aos="fade-right">{{$blogDetails->title}}
					</h2>
					<div class="detail-share-date">
						<span data-aos="fade-right">{{date('M, dS Y',strtotime($blogDetails->created_at))}}</span>
						<ul class="share-btns-detail" data-aos="fade-up">
							<li>
								<a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer.php?u={{Request::url()}};t={!!$blogDetails->title!!}" title="Share this post on Facebook">
									<img src="{{url('public/assets/frontend/img/harsh/fb.svg')}}" alt="facebook" class="img-fluid">
								</a>
							</li>
							<li>
								<a href="https://twitter.com/share?url={{Request::url()}};text={!!$blogDetails->title!!}" target="_blank">
									<img src="{{url('public/assets/frontend/img/harsh/twitter.svg')}}" alt="twitter" class="img-fluid">
								</a>

							</li>
							<li>
								<a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/link/?url={{Request::url()}};media=https://patiopavers.co.uk/news/wp-content/uploads/2020/01/james-website-article-320x320.png&amp;description={!!$blogDetails->short_description!!}" title="Share this post on Pinterest">
									<img src="{{url('public/assets/frontend/img/harsh/pinterest.svg')}}" class="img-fluid">
								</a>
							</li>
							<li>
								<a rel="nofollow" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{Request::url()}};title={!!$blogDetails->title!!};summary={!!strip_tags($blogDetails->short_description)!!};source=Global Stone Paving">
									<img src="{{url('public/assets/frontend/img/harsh/lin.svg')}}" class="img-fluid">
								</a>
							</li>
						</ul>
					</div>
					<div class="blog-detail-featured" data-aos="zoom-in">
						<img src="{{url('public/assets/images/blog_cover_image/'. $blogDetails->cover_image)}}">
					</div>
					<div class="row blogdetail-content">
						<div class="col-md-12">
							<div class="blog-inner-details">
								<p data-aos="fade-up">{!!$blogDetails->short_description!!}</p>
								<img src="{{url('public/assets/images/blog_image/'. $blogDetails->image)}}">
								<p data-aos="fade-up">{!!strip_tags($blogDetails->long_description)!!}</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="leave-reply">
								<h2 data-aos="fade-right">Leave A Reply</h2>
								<span data-aos="fade-up">Your email address will not be published.</span>
								<?php if (Auth::check()) {
									/* $actionUrl = url('addCommentToBlog'); ?>
									{{ Form::open(array('url' => $actionUrl,'class'=>'','id'=>'addCommentToBlog','autocomplete'=>'off')) }}
									@csrf
									<input type="hidden" name="blog_id" value="{{$blogId}}" />
									<div class="row">
										<div class="col-12 col-sm-6">
											<?php echo Form::text('name', '', ['class' => 'input', 'placeholder' => 'Your Name*']); ?>
										</div>
										<div class="col-12 col-sm-6">
											<?php echo Form::email('email', '', ['class' => 'input', 'placeholder' => 'Your Email*']); ?>
										</div>
										<div class="col-12 cols-m-12">
											<?php echo Form::textarea('comment', '', ['class' => 'textarea', 'rows' => '3', 'placeholder' => 'Your Comment*']); ?>
										</div>
									</div>
									<div class="submit-reply">
										<button type="submit" class="fill-btn">SUBMIT</button>
									</div>
									{{ Form::close() }} */ ?>
									<form method="POST" action="{{url('/addCommentToBlog')}}">
										@csrf
										<div class="row">
											<input type="hidden" name="blog_id" value="{{$blogId}}" />
											<div class="col-12 col-sm-6">
												<input data-aos="fade-up" type="text" class="input" name="name" placeholder="Your Name*">
												@if($errors->has('name'))
												<div class="error" style="color: red;">{{ $errors->first('name') }}</div>
												@endif
											</div>
											<div class="col-12 col-sm-6">
												<input data-aos="fade-up" type="email" class="input" name="email" placeholder="Your Email*">
												@if($errors->has('email'))
												<div class="error" style="color: red;">{{ $errors->first('email') }}</div>
												@endif
											</div>
											<div class="col-12 cols-m-12">
												<textarea data-aos="fade-up" class="textarea" id="" name="comment" rows="3" placeholder="Your Comment*"></textarea>
												@if($errors->has('comment'))
												<div class="error" style="color: red;">{{ $errors->first('comment') }}</div>
												@endif
											</div>
										</div>
										<div class="submit-reply">
											<button data-aos="fade-up" type="submit" class="fill-btn">SUBMIT</button>
										</div>
									</form>
								<?php } else { ?>
									<a class="fill-btn" href="{{url('login')}}">Login</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-4">
				<div class="recent-blogs pl-lg-24">
					<h2 data-aos="fade-up">Recent Blogs</h2>
					<div class="row">
						@foreach ($recentBlogs as $recentBlogs)
						<div class="col-12 recentblog-items" data-aos="fade-up">
							<img onclick="location.href='{{route('getBlogDetail',[$recentBlogs->id])}}'" src="{{url('public/assets/images/blog_image/'. $recentBlogs->image)}}" class="img-fluid">
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
<script src="{{asset('public/assets/js/frontend/blogs/blog-detail.js')}}"></script>
@endsection