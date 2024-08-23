<a class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-2 browse-box" href="{{route('searchFront',$cat['slug'])}}" data-toggle="tooltip" data-placement="top" title="{{$categoryData['name']}}">
	<img src="{{ $categoryData['icon'] }}" alt="" />
	<div>
			<p class="tm">{{ (strlen($categoryData['name'])>12)? substr($categoryData['name'], 0, 12).'...' : $categoryData['name']}}</p>
				<span class="tm blur-color">{{ $categoryData['jobCount'] }} Jobs</span>
		</div>
</a>
