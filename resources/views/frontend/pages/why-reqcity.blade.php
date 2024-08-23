@extends('frontend.layouts.master')
@section('title',$cms->seo_title)
@section('metaTitle',$cms->seo_title)
@section('metaKeywords',$cms->seo_meta_keyword)
@section('metaDescription',$cms->seo_description)
@section('content')
<!--------------------------
        ABOUT US START
--------------------------->

<div class="aboutus-page">
    <div class="container">
      <div class="aboutus-pagein">
        <h2>Why ReqCity</h2>
        <div class="aboutpage-banner">
          <img src="{{ asset('public/assets/frontend/img/aboutus.png') }}" alt="aboutbanner">
        </div>
        <div class="aboutpage-content">
          {!! $cms->content !!}
        </div>
      </div>
    </div>
</div>

<!--------------------------
        ABOUT US END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
</script>
@endsection
