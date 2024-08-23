@section('title','Job Categories')
@extends('frontend.layouts.master')
@section('content')
<!-- Browse job categories  Page starts here -->
<div class="browse-job browse-job-page">
  <div class="container">
    <h2>Browse job categories</h2>
    <div class="row">
      @if(!empty($categoryList) && count($categoryList))
      @foreach($categoryList as $cat)
      <a class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-2 browse-box" href="{{route('searchFront',$cat['slug'])}}" data-toggle="tooltip" data-placement="top" title="{{$cat['name']}}">
        <img src="{{ $cat['icon'] }}" alt="" />
        <div>
          <p class="tm" >{{ (strlen($cat['name'])>12)? substr($cat['name'], 0, 12).'...' : $cat['name']}}</p>
          <span class="tm blur-color">{{ $cat['jobCount'] }} Jobs</span>
        </div>
      </a>
      @endforeach
      @endif
    </div>
  </div>
</div>
@endsection
@section('footscript')
<script type="text/javascript">
    $(document).on('click','ul.faq-sec-pill li.faqsec-btn a',function(){
        $(this).addClass('active').parent().siblings().find('a').removeClass('active');
        var value = $(this).data('tag');
        // alert(value);
        if(value){
            $('.accordian-item').each(function(){
                var tags = $(this).attr('tags')
                var tags = tags.split(',');
                if(tags.indexOf(value.toString()) !== -1){
                    $(this).show()
                }else{
                    $(this).hide();
                }
            })
        }else{
           $('.accordian-item').show();
        }
    });
</script>
@endsection
