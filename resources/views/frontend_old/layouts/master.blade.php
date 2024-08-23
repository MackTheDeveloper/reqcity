<!DOCTYPE html>
<html>
	@include('frontend.include.head')
	<body>
	<!--------------------------
	    HEADER START
	--------------------------->
	@include('frontend.include.header')

	<!--------------------------
	    HEADER END
	--------------------------->

	@if (session('success'))
	    <div class="alert alert-success">
	        {{ session('success') }}
	    </div>
	@endif
	@if (session('error'))
	    <div class="alert alert-danger">
	        {{ session('error') }}
	    </div>
	@endif
	<div class="ajax-alert">
		
	</div>


	<!--------------------------
	    	CONTENT START
	--------------------------->
	@yield('content')
	<!--------------------------
	    	CONTENT END
	--------------------------->



	<!--------------------------
	    	FOOTER START
	--------------------------->
	@include('frontend.include.footer')
	<!--------------------------
	    	FOOTER END
	--------------------------->
	</body>
	@include('frontend.include.bottom')

</html>