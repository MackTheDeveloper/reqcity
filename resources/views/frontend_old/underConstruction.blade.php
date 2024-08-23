@extends('admin.layouts.master')
@section('title','Home')
@section('content')
<style>
.container 
{
  display: flex;
  justify-content: center;
  background: darkslategray;
}
</style>
<div class="container">
    <div class="child">
        <img src="public/admin/images/under_construction.jpg" />
    </div>
  </div>
  <div class="text-center text-primary opacity-8 mt-3">Copyright © {{config('app.name_show')}}. All rights reserved.</div>
@endsection

