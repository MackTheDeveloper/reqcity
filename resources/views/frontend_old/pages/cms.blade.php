@extends('frontend.layouts.master')
@section('title',$data->seo_title)
@section('metaTitle',$data->seo_title)
@section('metaKeywords',$data->seo_meta_keyword)
@section('metaDescription',$data->seo_description)
@section('content')
<section>
	<div class="container">
		
	    <div class="registration">
	        <h2>{{ $data->name }}</h2>
	        {!! $data->content !!}
	    </div>
	</div>
</section>
@endsection