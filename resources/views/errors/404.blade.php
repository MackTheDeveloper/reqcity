@section('title','404')
@extends('errors.layout')
@section('content')

<header class="top-shadow">
	<div class="container">
		<nav class="navbar navbar-expand">
			<a class="navbar-brand header-only-logo" href="#">
				<img src="{{asset('public/assets/frontend/img/Logo.svg')}}" alt="" />
			</a>
		</nav>
	</div>
</header>

<div class="page-404">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 order-2 order-md-1 offset-lg-1 col-md-6 col-lg-5">
				<div class="error-content">
					<h2>404:<br>Page not found</h2>
					<p class="bl">The link you clicked may be broken or the page may have been removed.</p>
					<a href="{{ url('/') }}" class="fill-btn">Go Home</a>
				</div>
			</div>
			<div class="col-12 col-sm-12 order-1 order-md-2 col-md-6 col-lg-4">
				<div class="error-img">
					<img src="{{asset('public/assets/frontend/img/404.svg')}}" alt="" />
				</div>
			</div>
		</div>
	</div>
</div>
@endsection