@extends('frontend.layouts.master')
@section('title','Professional List')
@section('metaTitle','Professional List')
@section('metaKeywords','Professional List')
@section('metaDescription','Professional List')
@section('metaImage','')
@section('content')

<!--WEB VIEW HOME PART START -->
<div class="web-home-part mt-5">
	<div class="container">
		<div class="row">
			@foreach($data[0]->categoryData->list as $key=>$row)
			<div class="col-2 col-md-3 col-lg-2">
				<a onclick="categoryClick(event)" href="{{ route('professional.list',$row->id) }}" class="img-center-text {{(Request::route('id')==$row->id)?'active':''}}" data-aos="zoom-in">
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
			@foreach($data[0]->categoryData->list as $key=>$row)
            <div class="item">
              	<a href="{{ route('professional.list',$row->id) }}" class="img-center-text {{(Request::route('id')==$row->id)?'active':''}}">
					<img src="{{$row->image}}">
					<div class="s2 ucase">{{$row->title}}</div>
				</a>
            </div>
            @endforeach
        </div>
	</div>
</div>

<!--MOBILE VIEW HOME PART END -->


<!--------------------------------
   PROFESSIONAL & COMPANY START
--------------------------------->
<section class="profe--company pb72">
	<div class="container">
		<h2>Professional & Company</h2>
		<div class="row append-ajax">
			@include('frontend.professional.professionals',['data'=>$data])
		</div>
		@if(count($data)>1)
		<div class="text-center" data-aos="fade-up">
			<input type="hidden" name="pageNum" value="1">
			<button id="loadMoreProfessional" class="border-btn">LOAD MORE</button>
			<a href="{{ route('professional.seeMore') }}" id="seeMoreProfessional" class="border-btn" style="display: none;" >SEE ALL</a>
		</div>
		@else
			<div class="col-12 text-center my-4">No Professional found.</div>
		@endif
	</div>
</section>

<!------------------------------
   PROFESSIONAL & COMPANY END
------------------------------->

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
		$.ajax({
			url:"{{ route('professional.list') }}"+(cageory?'/'+cageory:''),
            method:'post',
            data:formData,
            success:function(response){
            	if(response){
            		$('input[name="pageNum"]').val(page);
            		$('.append-ajax').append(response);
            	}else{
            		$('#loadMoreProfessional').hide();
            		$('#seeMoreProfessional').show();
            	}
            }
		});
	});

	// $(document).on('click','.categoryClick',function(e)){
	// 	e.preventDefault();
	// 	alert(window.location.href);
	// }
	function categoryClick(event) {
	  	event.preventDefault();
	  	var href = event.currentTarget.getAttribute('href')
	  	if(window.location.href == href){
	  		window.location='{{ route('professional.list') }}';	  		
	  	}else{
	  		window.location=href;
	  	}
	  	
	}
</script>
@endsection