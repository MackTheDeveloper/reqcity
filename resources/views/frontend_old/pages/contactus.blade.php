@extends('frontend.layouts.master')
@section('title',$cms->name)
@section('metaTitle',$cms->seo_title)
@section('metaKeywords',$cms->seo_meta_keyword)
@section('metaDescription',$cms->seo_description)
@section('content')
<!--------------------------
        CONTACT US START
--------------------------->
<section class="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 contact">
                <h2>Contact Us</h2>
                <div class="dividers"></div>
                {!! $cms->content !!}
                <a href="mailto:info@decorato.com" class="email-address"><img src="{{ url('public/assets/frontend/img/email.svg') }}">info@decorato.com</a><br>
                <a href="tel:+9731234567890" class="phone-number"><img src="{{ url('public/assets/frontend/img/phone.svg') }}">+973 12345 67890</a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 offset-xl-1 col-xl-5 write-us">
                <h2>Write Us</h2>
                <form method="POST" action="{{route('contactus.store')}}" id="contactUsForm">
                    @csrf
                    <input type="text" class="input" placeholder="First Name*" name="first_name">
                    @if($errors->has('first_name'))
                        <div class="error" style="color: red;">{{ $errors->first('first_name') }}</div>
                    @endif
                    <input type="text" class="input" placeholder="Last Name*" name="last_name">
                    @if($errors->has('last_name'))
                        <div class="error" style="color: red;">{{ $errors->first('last_name') }}</div>
                    @endif
                    <input type="email" class="input" placeholder="Email Address*" name="email">
                    @if($errors->has('email'))
                        <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                    @endif
                    <input type="number" class="input" placeholder="Phone Number*" name="phone">
                    @if($errors->has('phone'))
                        <div class="error" style="color: red;">{{ $errors->first('phone') }}</div>
                    @endif
                    <textarea class="input" name="message" placeholder="Message*" rows="5" style="height: auto;"></textarea>  
                    @if($errors->has('message'))
                        <div class="error" style="color: red;">{{ $errors->first('message') }}</div>
                    @endif
                    <br>
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
            
                    @if ($errors->has('g-recaptcha-response'))
                        <div class="error">{{ $errors->first('g-recaptcha-response') }}</div>
                    @endif
                    <button type="submit" class="fill-btn  mt-5">SUBMIT</button>
                </form>
            </div>          
        </div>
    </div>
</section>
<!--------------------------
        CONTACT US END
--------------------------->
@endsection
@section('footscript')
<script type="text/javascript">
    $("#contactUsForm").validate( {
            ignore: [],
            rules: {
                first_name: "required",
                last_name: "required",            
                email: {
                    required:true,
                    email:true
                },            
                phone: "required",            
                message: "required",     
                "g-recaptcha-response":"required"
       
            },
            errorPlacement: function ( error, element ) {
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.next( "label" ) );
                } else {
                    error.insertAfter( element );
                }
            },
        });
</script>
@endsection