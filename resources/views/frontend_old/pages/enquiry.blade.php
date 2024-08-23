<?php
$user = auth()->user();
$request = Request::all();
?>
@extends('frontend.layouts.master')
@section('title','Product Enquiry')
@section('content')
<!--------------------------
        Enquiry Form
--------------------------->
<section class="mw-352">
    <div class="registration">

        <h2>Enquiry Form</h2>
        <form method="POST" action="{{route('enquiry.store')}}" id="enquiryForm">
            @csrf
            <input type="text" name="first_name" value="{{ $user->firstname }}" class="input" placeholder="First Name*" >
            @if($errors->has('first_name'))
                <div class="error" style="color: red;">{{ $errors->first('first_name') }}</div>
            @endif
            <input type="text" name="last_name" value="{{ $user->lastname }}" class="input" placeholder="Last Name*" >
             @if($errors->has('last_name'))
                <div class="error" style="color: red;">{{ $errors->first('last_name') }}</div>
            @endif
            <input type="email" name="email" value="{{ $user->email }}" class="input" placeholder="Email Address*">
            @if($errors->has('email'))
                <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
            @endif
            @if(isset($request['id']))
                <input type="hidden" name="product_id" value="{{$request['id']}}">
                <input type="hidden" name="type" value="professional">
            @else
                <select name="product_id" id="product_id" class="input">
                    <option value="">Select Product</option>
                </select>
            @endif
            @if($errors->has('product_id'))
                <div class="error" style="color: red;">{{ $errors->first('product_id') }}</div>
            @endif
            <textarea class="textarea" placeholder="Message" name="message">{{ old('message') }}</textarea>
            @if($errors->has('message'))
                <div class="error" style="color: red;">{{ $errors->first('message') }}</div>
            @endif
            <div class="checkbox-div">
                <div class="row">
                    <div class="col-6 mb8">
                        <label class="ck-box">All Day
                          <input type="checkbox" name="contact_time[]" value="All Day" checked="checked">
                          <span class="checkmarks"></span>
                        </label>
                    </div>
                    <div class="col-6 mb8">
                        <label class="ck-box">Morning
                          <input type="checkbox" name="contact_time[]" value="Morning">
                          <span class="checkmarks"></span>
                        </label>
                    </div>
                    <div class="col-6 mb8">
                        <label class="ck-box">Afternoon
                          <input type="checkbox" name="contact_time[]" value="Afternoon">
                          <span class="checkmarks"></span>
                        </label>
                    </div>
                    <div class="col-6 mb8">
                        <label class="ck-box">Evening
                          <input type="checkbox" name="contact_time[]" value="Evening">
                          <span class="checkmarks"></span>
                        </label>
                    </div>
                </div>
            </div>
             <div class="mt-3">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
            
                @if ($errors->has('g-recaptcha-response'))
                    <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
                @endif
            </div>
            <button type="submit" class="fill-btn">SUBMIT</button>
        </form>
    </div>
</section>
<!--------------------------
        Enquiry Form
--------------------------->

@endsection
@section('footscript')
<script>
    
$(document).ready(function(){

        // var category_id = $(this).val();
    var id = @json(request()->id?:'');
    var selectedProductId = @json(request()->product_id?:'');
    getProducts(id);
    function getProducts(id){
        $.ajax({
            url:"{{ url('api/'.config('app.api_version').'/product/list') }}",
            method:'get',
            data:'userId='+id,
            success:function(e){
                if(e.statusCode == "200"){
                    var products = e.component[1].productListComponentData.list;
                    var options = '<option value="">Select Product</option>';
                    for(var i=0;i<products.length;i++){
                        options += '<option value="'+products[i].id+'" '+(selectedProductId == products[i].id ? 'selected' : '')+'>'+products[i].title+'</option>';

                    }
                    $("#product_id").html(options);
                }
            }
        })
    }
    $("#enquiryForm").validate( {
            ignore: [],
            rules: {
                first_name: "required",
                last_name: "required",            
                email: {
                    required:true,
                    email:true
                },            
                message: "required",            
                "g-recaptcha-response": "required",            
            },
            errorPlacement: function ( error, element ) {
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.next( "label" ) );
                } else {
                    error.insertAfter( element );
                }
            },
        });
});
</script>
@endsection