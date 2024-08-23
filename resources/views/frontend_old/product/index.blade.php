@extends('frontend.layouts.master')
@section('title','Product List')
@section('metaTitle','Product List')
@section('metaKeywords','Product List')
@section('metaDescription','Product List')
@section('metaImage','')
@section('content')

<!-- WEB FILTER BY AND SORT BY START -->
<form class="sort_filter" id="sort_filter">
	<input type="hidden" name="sortBy" value="{{(isset($request['sortBy']))?$request['sortBy']:0}}">
	<input type="hidden" name="categoryId" value="{{(isset($request['categoryId']))?$request['categoryId']:""}}">
	<input type="hidden" name="filter[verified]" value="{{(isset($request['filter']['verified']))?$request['filter']['verified']:""}}">
	<input type="hidden" name="pageNum" value="{{(isset($viewData['productListComponentData']->pageNum))?$viewData['productListComponentData']->pageNum:""}}">
</form>
<div class="f_s d-not-767">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center b-one">
			<div class="filterBy" data-aos="fade-right">
				<p class="s1">Filter By</p>
				<span class="filter-links" onclick="openFilter(event, 'designer')"><a>Professional Status</a></span>
				{{-- <span class="filter-links" onclick="openFilter(event, 'ratting')"><a>Ratings</a></span>
				<span class="filter-links" onclick="openFilter(event, 'costRange')"><a>Cost Range</a></span> --}}
			</div>
			<div class="sortBy" data-aos="fade-up">
				<span>Sort By</span>
				<select class="select changeAndSubmit" name="sortBy" data-name="sortBy">
					<option value="">All</option>
					<option {{(isset($request['sortBy']) && $request['sortBy']=='0_0')?'selected="selected"':""}} value="0_0">A to Z</option>
					<option {{(isset($request['sortBy']) && $request['sortBy']=='0_1')?'selected="selected"':""}}  value="0_1">Z to A</option>
					<option {{(isset($request['sortBy']) && $request['sortBy']=='1_1')?'selected="selected"':""}}  value="1_1">Highest Ratings</option>
					<option {{(isset($request['sortBy']) && $request['sortBy']=='1_0')?'selected="selected"':""}}  value="1_0">Lowest Ratings</option>
					<option {{(isset($request['sortBy']) && $request['sortBy']=='2_1')?'selected="selected"':""}}  value="2_1">Highest Cost</option>
					<option {{(isset($request['sortBy']) && $request['sortBy']=='2_0')?'selected="selected"':""}}  value="2_0">Lowest Cost</option>
				</select>
			</div>
		</div>
		<div id="designer" class="filter-content">
			<div class="filter-value-btn">
				@if(isset($request['filter']['verified']))
					@if($request['filter']['verified']=='1')
					<div class="filter-values">
					  	<span class="cap">Now Filter by: Verified
					  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
					  	</span>
					</div>
					@else
					<div class="filter-values">
					  	<span class="cap">Now Filter by: Unverified
					  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
					  	</span>
					</div>
					@endif
					<a href="javascript:void(0)" class="cap clear-all clearVerified">Clear All</a>
				@endif
				
			</div>
			<div class="filter-select">
				<div class="designer-value verifiedUl">
					<p data-value="1" class="s2 {{(isset($request['filter']['verified']) && $request['filter']['verified']=='1')?'selected':''}}">Verified</p>
					<p data-value="0" class="s2 {{(isset($request['filter']['verified']) && $request['filter']['verified']=='0')?'selected':''}}">Unverified</p>
				</div>
			</div>
		</div>
		<div id="ratting" class="filter-content">
			<div class="filter-value-btn">
				<div class="filter-values">
				  	<span class="cap">Now Filter by: 4 Star
				  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
				  	</span>
				</div>
				<a href="" class="cap clear-all">Clear All</a>
			</div>
			<div class="filter-select">
				<form class="add-ratting-star">
					<ul id='stars2'>
						<li class='star red-star' title='Poor' data-value='1'></li>
						<li class='star green-star' title='Fair' data-value='2'></li>
						<li class='star green-star' title='Good' data-value='3'></li>
						<li class='star yellow-star' title='Excellent' data-value='4'>
						</li>
						<li class='star yellow-star' title='WOW!!!' data-value='5'></li>
					</ul>
				</form>
			</div>
		</div>
		<div id="costRange" class="filter-content">
			<div class="filter-value-btn">
				<div class="filter-values">
				  	<span class="cap">Now Filter by: Verified
				  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
				  	</span>
				</div>
				<div class="filter-values">
				  	<span class="cap">Now Filter by: Verified
				  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
				  	</span>
				</div>
				<a href="" class="cap clear-all">Clear All</a>
			</div>
			<div class="filter-select">
				{{-- <div class="designer-value">
					<p class="s2 selected">Verified</p>
					<p class="s2">Unverified</p>
				</div> --}}
			</div>
		</div>
	</div>
</div>

<!-- WEB FILTER BY AND SORT BY END -->



<!-- MOBILE FILTER BY AND SORT BY HEADER START -->

<div class="filter-header d-flex justify-content-center align-item-center">
	<div class="d-flex drop-down-items sort-by-items justify-content-center align-item-center">
		<img src="{{asset('public/assets/frontend/img/Sort.svg')}}" class="sort-img">
		<span class="sort-names">Sort</span>
	</div>
	<div class="by-toggle sort-by-menus">
		<ul class="sortByUl">
			<li data-value="0"><a href="javascript:vodi(0)">Default</a></li>
			<li data-value="0_0" class="{{(isset($request['sortBy']) && $request['sortBy']=='0_0')?'active':''}}" ><a href="javascript:vodi(0)">A to Z</a></li>
			<li data-value="0_1" class="{{(isset($request['sortBy']) && $request['sortBy']=='0_1')?'active':''}}"><a href="javascript:vodi(0)">Z to A</a></li>
			<li data-value="1_1" class="{{(isset($request['sortBy']) && $request['sortBy']=='1_1')?'active':''}}"><a href="javascript:vodi(0)">Highest Ratings</a></li>
			<li data-value="1_0" class="{{(isset($request['sortBy']) && $request['sortBy']=='1_0')?'active':''}}"><a href="javascript:vodi(0)">Lowest Ratings</a></li>
			<li data-value="2_1" class="{{(isset($request['sortBy']) && $request['sortBy']=='2_1')?'active':''}}"><a href="javascript:vodi(0)">Highest Cost</a></li>
			<li data-value="2_0" class="{{(isset($request['sortBy']) && $request['sortBy']=='2_0')?'active':''}}"><a href="javascript:vodi(0)">Lowest Cost</a></li>
		</ul>
	</div>


	<div class="d-flex drop-down-items filter-by-items justify-content-center align-item-center">
		<img src="{{asset('public/assets/frontend/img/Filter.svg')}}" class="sort-img">
		<span class="sort-names">Filter</span>
	</div>
	<div class="by-toggle filter-by-menus">
		<div class="filterBy">
			<p class="s1">Filter By :</p>
			<span class="filter-links" onclick="openFilter(event, 'mobile-designer')"><a>Status</a></span>
			{{-- <span class="filter-links" onclick="openFilter(event, 'mobile-ratting')"><a>Ratings</a></span>
			<span class="filter-links" onclick="openFilter(event, 'mobile-costRange')"><a>Cost Range</a></span> --}}
		</div>
		<div id="mobile-designer" class="filter-content">
			<div class="filter-value-btn">
				@if(isset($request['filter']['verified']))
					@if($request['filter']['verified']=='1')
					<div class="filter-values">
					  	<span class="cap">Now Filter by: Verified
					  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
					  	</span>
					</div>
					@else
					<div class="filter-values">
					  	<span class="cap">Now Filter by: Unverified
					  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
					  	</span>
					</div>
					@endif
					<a href="javascript:void(0)" class="cap clear-all clearVerified">Clear All</a>
				@endif
			</div>
			<div class="filter-select">
				<div class="designer-value verifiedUl">
					<p data-value="1" class="s2 {{(isset($request['filter']['verified']) && $request['filter']['verified']=='1')?'selected':''}}">Verified</p>
					<p data-value="0" class="s2 {{(isset($request['filter']['verified']) && $request['filter']['verified']=='0')?'selected':''}}">Unverified</p>
				</div>
			</div>
		</div>
		<div id="mobile-ratting" class="filter-content">
			<div class="filter-value-btn">
				<div class="filter-values">
				  	<span class="cap">Now Filter by: 4 Star
				  		<img src="{{asset('public/assets/frontend/img/Close.png')}}">
				  	</span>
				</div>
				<a href="" class="cap clear-all">Clear All</a>
			</div>
			<div class="filter-select">
				<form class="add-ratting-star">
					<ul id='stars2'>
						<li class='star red-star' title='Poor' data-value='1'></li>
						<li class='star green-star' title='Fair' data-value='2'></li>
						<li class='star green-star' title='Good' data-value='3'></li>
						<li class='star yellow-star' title='Excellent' data-value='4'></li>
						<li class='star yellow-star' title='WOW!!!' data-value='5'></li>
					</ul>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="filter-space"></div>

<!-- MOBILE FILTER BY AND SORT BY HEADER END --> 



<!-- SORT BY SIDEBAR START -->

<div class="sortMenu">
  	<p class="s1">Sort By</p>
  	<img src="{{asset('public/assets/frontend/img/Close.svg')}}" class="closeIcons2 fixed-right" alt="close">
  
  	<div class="sortbar-navigation">
	  	<ul>
	  	  	<li><a href="#">All</a></li>
	      	<li class="active"><a href="#">Most Recent</a></li>
	      	<li><a href="#">On Sale</a></li>
	      	<li><a href="#">Price: Low to High</a></li>
	      	<li><a href="#">Price: High to Low</a></li>
	  	</ul>
	</div>
</div>

<!-- SORT BY SIDEBAR END -->




<!-- FILTER BY SIDEBAR START -->

<div class="filterMenu">
  	<p class="s1">Filter By:</p>
  	<img src="{{asset('public/assets/frontend/img/Close.svg')}}" class="closeIcons3 fixed-right" alt="close">
  
  	<div class="filterbar-navigation">
	  	<ul>
	  	  	<li><a href="#">Category</a></li>
	      	<li><a href="#">Professional</a></li>
	      	<li class="active"><a href="#">Product</a></li>
	  	</ul>
	</div>
</div>

<!-- FILTER BY SIDEBAR END -->







<!--WEB VIEW HOME PART START -->

<div class="web-home-part">
	<div class="container">
		<div class="row">
			@foreach($viewData['categoryData']->list as $key => $row)
			<div class="col-2 col-md-3 col-lg-2">
				<a href="javascript:void(0)" data-value="{{$row->id}}" class="img-center-text changeCategory {{(isset($request['categoryId']) && $request['categoryId']==$row->id)?"active":""}}" data-aos="zoom-in">
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
			@foreach($viewData['categoryData']->list as $key => $row)
			<div class="item">
              	<a href="javascript:void(0)" data-value="{{$row->id}}" class="img-center-text changeCategory {{(isset($request['categoryId']) && $request['categoryId']==$row->id)?"active":""}}">
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


<section class="only-product pt-0">
	<div class="container">
		<h2 data-aos="fade-up">Products</h2>
		<div class="row append-ajax">
			@include('frontend.product.products',['products'=>$viewData['productListComponentData']->list])
		</div>
		@if(count($viewData['productListComponentData']->list))
		<div class="text-center" data-aos="fade-up">
			<button id="loadMoreProduct" class="border-btn">LOAD MORE</button>
		</div>
		@else
			<div class="col-12 text-center my-4">No products found.</div>
		@endif
	</div>
</section>


<!------------------------------
   PROFESSIONAL & COMPANY END
------------------------------->


@endsection
@section('footscript')
<script>
	
	function addValAndSubmit(name,value){
		$('.sort_filter').find('input[name="'+name+'"]').val(value);
		$('.sort_filter').submit();
	}

	$(document).on('change','.changeAndSubmit',function(){
		var value = $(this).val();
		var name = $(this).data('name');
		addValAndSubmit(name,value)
	});

	$(document).on('click','.changeCategory',function(){
		var value = $(this).data('value');
		var existing = $('input[name="categoryId"]').val()
		if(existing == value){
			value = '';
		}
		addValAndSubmit('categoryId',value)
	});

	$(document).on('click','.sortByUl li',function(){
		var value = $(this).data('value');
		addValAndSubmit('sortBy',value)
	});

	$(document).on('click','.verifiedUl p.s2',function(){
		var value = $(this).data('value');
		addValAndSubmit("filter[verified]",value)
	});

	$(document).on('click','.clearVerified',function(){
		addValAndSubmit("filter[verified]",'')
	});

	$(document).on('click','#loadMoreProduct',function(){
		var token = @json(csrf_token());
		var page = $('.sort_filter').find('input[name="pageNum"]').val();
		page = parseInt(page)+1;
		// var formData = $('.sort_filter').serializeArray();
		var formData = $('.sort_filter').serialize()+ '&_token=' + token+ '&page=' + page+'&viewType=ajax';
		$.ajax({
			url:"{{ route('product.list') }}",
            method:'post',
            data:formData,
            success:function(response){
            	if(response){
            		$('.sort_filter').find('input[name="pageNum"]').val(page);
            		$('.append-ajax').append(response);
            		AOS.init({
					  once: true,
					  duration: 700
					});
            	}else{
            		$('#loadMoreProduct').hide()
            	}
            }
		});
	});
</script>
@endsection