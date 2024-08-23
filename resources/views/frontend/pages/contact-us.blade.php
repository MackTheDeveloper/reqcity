@extends('frontend.layouts.master')
@section('title',$cms->seo_title)
@section('metaTitle',$cms->seo_title)
@section('metaKeywords',$cms->seo_meta_keyword)
@section('metaDescription',$cms->seo_description)
@section('content')
<!--------------------------
        CONTACT US START
--------------------------->
<div class="container">
    <div class="layout-352 form-page signup-compnay">
      <h5>Write Us</h5>
      <div class="or">
        <p class="bm blur-color">Send us any query or feedbacks</a></p>
      </div>
      <form method="POST" action="{{url('contact-us')}}" id="contactUsForm">
        @csrf
        {!! app('captcha')->render(); !!}
      <div>
        <div class="input-groups">
          <span>Your Name</span>
          <input type="text" name="first_name" value="{{$userData->firstname}}">  
        </div>
        {{--<div class="input-groups">
          <span>Last Name</span>
          <input type="text" name="first_name" value="{{$userData->firstname}}">  
        </div> --}}
        <div class="input-groups">
          <span>Email Address</span>
          <input type="email" name="email" value="{{$userData->email}}">
        </div>
        <div class="input-groups">
          <span>Message</span>
          <textarea name="message" placeholder="Write your message here"></textarea>
        </div>
      </div>
      <br>
      <button type="submit" class="fill-btn g-recaptcha" data-sitekey="{{ Config::get('app.googleReCaptchaKeys')['siteKey'] }}" data-callback='submitForm'>Submit</button>
    </div>
    </form>
  </div>

<!--------------------------
        CONTACT US END
--------------------------->
@endsection
@section('footscript')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
    $("#contactUsForm").validate({
        ignore: [],
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true,
                regex: /\S+@\S+\.\S+/,
            },
            message: "required",
        },
        errorPlacement: function(error, element) {
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            if (grecaptcha.getResponse()) {
                    // 2) finally sending form data
                    form.submit();
            }else{
                    // 1) Before sending we must validate captcha
                grecaptcha.reset();
                grecaptcha.execute();
            }           
        }
    });

    function submitForm() {
        $("#contactUsForm").submit();
        return true;
    }

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please enter a valid email address."
    );
</script>
@endsection