@extends('frontend.layouts.master')
@section('title',$cms->seo_title)
@section('metaTitle',$cms->seo_title)
@section('metaKeywords',$cms->seo_meta_keyword)
@section('metaDescription',$cms->seo_description)
@section('content')
<!--------------------------
        TERMS CONDITIONS START
--------------------------->

<div class="terms-condition">
  <div class="container">    
    {!! $cms->content !!}
  </div>
</div>


<!--------------------------
        TERMS CONDITIONS END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
</script>
@endsection
