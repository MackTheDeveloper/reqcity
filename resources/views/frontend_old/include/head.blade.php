<head>
	@include('frontend.include.meta_header')

	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/bootstrap.min.css')}}">
	<link rel="icon" type="image/x-icon" href="{{asset('public/assets/frontend/img/Decorato-Fevicon.png')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/responsive.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/developer.css')}}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/aos.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/fontawesome/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets/frontend/css/cropper.css')}}">
	@yield('styles')
</head>