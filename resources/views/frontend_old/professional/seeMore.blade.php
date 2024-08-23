@extends('frontend.layouts.master')
@section('title','Product and Professional Search')
@section('metaTitle','Product and Professional Search')
@section('metaKeywords','Product and Professional Search')
@section('metaDescription','Product and Professional Search')
@section('metaImage','')
@section('content')
<!--Professionals Listing-->
<section class="only-product">
	<div class="container">
		<h2 data-aos="fade-up" class="aos-init aos-animate">Professional & Company</h2>
		@if(!empty($viewData['verticalSliderComponentData']->list))
		<div class="row append-ajax">
			@include('frontend.professional.professional-item',['list'=>$viewData['verticalSliderComponentData']->list])
		</div>
		<div class="text-center">
			<input type="hidden" name="pageNum" value="1">
			<button id="loadMoreProfessional" class="border-btn">LOAD MORE</button>
		</div>
		@else
		<div class="text-center">
			<p>No more professionals found.</p>
		</div>
		@endif
	</div>
</section>
@endsection
@section('footscript')
<script type="text/javascript">
	$(document).on('click','#loadMoreProfessional',function(){
		var token = @json(csrf_token());
		var page = $('input[name="pageNum"]').val();
		page = parseInt(page)+1;
		// var formData = $('.sort_filter').serialize()+ '&_token=' + token+ '&page=' + page+'&viewType=ajax';
		var formData = '&page=' + page+'&viewType=ajax';
		var cageory = "{{Request::route('id')}}"
		$.blockUI();
		$.ajax({
			url:"{{ route('professional.seeMore') }}",
            method:'get',
            data:formData,
            success:function(response){
            	if(response){
            		$('input[name="pageNum"]').val(page);
            		$('.append-ajax').append(response);
            	}else{
            		$('#loadMoreProfessional').hide()
            	}
	            $.unblockUI();

            }
		});
	});
</script>
@endsection