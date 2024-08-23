@extends('frontend.layouts.master')
@section('title',$cms->seo_title)
@section('metaTitle',$cms->seo_title)
@section('metaKeywords',$cms->seo_meta_keyword)
@section('metaDescription',$cms->seo_description)
@section('content')
<!--------------------------
        PRIVACY POLICY START
--------------------------->

<div class="terms-condition">
  <div class="container">    
    {!! $cms->content !!}
  </div>
</div>

<!--------------------------
        PRIVACY POLICY END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
</script>
@endsection
