@section('title','Sign In')
@extends('frontend.layouts.master')
@section('styles')
<link rel="stylesheet" href="{{asset('public/assets/frontend/css/jquery.ccpicker.css')}}">
@endsection
@section('content')
<!--------------------------
        SIGN UP START
--------------------------->
<div class="create-account">
  <h4>Create Account</h4>
  <p>Join our community of music fans now and start to build your Fanclub collection</p>
  <form id="signupForm" method="POST" action="{{url('/signup')}}">
      @csrf
      <input name="role_id" type="hidden" value="3">
    <div>
      <div class="label-select pt-16">
        <span>Register as*</span>
        <select name="role_id" id="role">
          <option>Select...</option>
          <option value="3" selected>Fan</option>
          <option value="2">Artist</option>
        </select>
        <!-- <label class="error">Error</label> -->
      </div>
      <div class="artist-introduce d-none artist-role">
        <span>Did a Fanclub artist introduce you?</span>
        <div class="radio-group">
          <label class="rd">Yes
            <input type="radio" checked="checked" name="artist_introduce">
            <span class="rd-checkmark"></span>
          </label>
          <label class="rd">No
            <input type="radio" name="artist_introduce">
            <span class="rd-checkmark"></span>
          </label>
        </div>
      </div>
      <div class="inputs-group">
          <input type="text" name="firstname">
          <span>Your Name*</span>
          <!-- <label class="error">Error</label> -->
      </div>
      {{-- <div class="inputs-group">
          <input type="text" name="lastname">
          <span>Last Name*</span>
          <!-- <label class="error">Error</label> -->
      </div> --}}
      <div class="inputs-group">
          <input type="email" name="email">
          <span>Email Address*</span>
          <!-- <label class="error">Error</label> -->
          @if($errors->has('email'))
          <div class="error">{{ $errors->first('email') }}</div>
          @endif
      </div>
      <div class="number-wrapper">
        <div class="input">
          <input type="text" id="phoneField1" name="phoneCode" class="phone-field"/>
        </div>
        <div class="number-group">
          <input type="number" name="phone">
          <span>Phone Number</span>
          <!-- <label class="error">Error</label> -->
        </div>
      </div>
      <div class="inputs-group label-select">
          <select class="select select_country" name="country" id="country">
              <option value="">Country Of Residence*</option>
              @foreach($countries as $key=>$row)
                  <option value="{{$row['key']}}">{{$row['value']}}</option>
              @endforeach
          </select>
          {{-- {!! Form::select('country', $countries->prepend('Country Of Residence*', ''), '', array("class" => "select select_country")) !!} --}}
          <!-- <label class="error">Error</label> -->
      </div>
      {{-- <div class="label-select selectDiv">
        <select class="select select_state" name="state" id="state">
          <option>Select...</option>
        </select>
        <!-- <label class="error">Error</label> -->
      </div> --}}
      <div class="d-none select-with-label show_states_select">
        <span>State*</span>
        <select class="select select_state" name="state" id="state">
          <option>Select...</option>
        </select>
      </div>
      <div class="inputs-group show_states_input">
          <input type="text" name="state" value="">
          <span>State*</span>
          <!-- <label class="error">Error</label> -->
      </div>
      <div class="inputs-group">
          <input type="password" id="password" name="password">
          <span>Password*</span>
          <!-- <label class="error">Error</label> -->
      </div>
      <div class="inputs-group">
          <input type="password" name="conform-password">
          <span>Confirm Password*</span>
          <!-- <label class="error">Error</label> -->
      </div>
    </div>
    <div class="social-handler d-none artist-role">
      <h6>Social Media Handles</h6>
      <div class="social-user-box">
        <div class="social-name-img">
          <img src="{{asset('public/assets/frontend/img/s-insta.png')}}" class="insta-img" alt=""/>
          <span>Instagram</span>
        </div>
        <input placeholder="@username" name="instagram" id="instagram" value=""/>
      </div>
      <div class="social-user-box">
        <div class="social-name-img">
          <img src="{{asset('public/assets/frontend/img/s-fb.png')}}" class="fb-img" alt="" />
          <span>Facebook</span>
        </div>
        <input placeholder="@username" name="facebook" id="facebook" value=""/>
      </div>
      <div class="social-user-box">
        <div class="social-name-img">
          <img src="{{asset('public/assets/frontend/img/s-tw.png')}}"  class="tw-img" alt="" />
          <span>Twitter</span>
        </div>
        <input placeholder="@username" name="twitter" id="twitter" value=""/>
      </div>
    </div>
    <div class="agree-to">
        <span>By proceeding you agree to Fanclub's <a target="_blank" href="{{url('terms-conditions')}}"> Terms & Conditions </a> and <a target="_blank" href="{{url('privacy-policy')}}"> Privacy Policy </a></span>
    </div>
    <button type="submit" class="fill-btn g-recaptcha" data-sitekey="{{ env('INVISIBLE_RECAPTCHA_SITEKEY') }}" data-callback='submitForm'>Submit</button>
    <div class="login-link">
        <span>Have an Account?<a href="{{url('login')}}">Sign In</a></span>
    </div>
  </form>
</div>

<!--------------------------
        SIGN UP END
--------------------------->
@endsection
@section('footscript')
<script src="{{ asset('public/assets/frontend/js/jquery.ccpicker.js') }}" data-json-path="{{ asset('public/assets/frontend/data.json') }}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
    $('#phoneField1').CcPicker();
    $("#signupForm").validate({
        ignore: [],
        rules: {
            firstname: "required",
            lastname: "required",
            country: "required",
            email: "required",
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 8,
            },
            "conform-password": {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        messages: {
            firstname: "First Name is required",
            lastname: "Last Name is required",
            email: "Email is required",
            phone: {
                required: "Phone Number is required"
            },
            password: {
                required: "Password is required"
            },
            "conform-password": {
                required: "Confirm Password is required",
                equalTo: "Please enter same as Password"
            }
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
    $(document).on('change','#country',function(){
      stateTextDropdown();
      var value = $(this).val();
      if(value=='United States'){
        $.ajax({
            url:"{{ route('stateList') }}",
            method:'post',
            data:'country="231"&_token={{ csrf_token() }}',
            dataType : 'json',
            success:function(response){
              $('.select_state').empty();
              $.each(response.component.stateListData.countries,function(k,v)
              {
                    $(".select_state").append('<option value="'+v.key+'">'+v.key+'</option>');
              });
            }
          });
        }
    });
    $(document).on('change','#role',function(){
      var value = $(this).val();
      if(value=='3'){
        $('.artist-role').addClass('d-none');
      }else{
        $('.artist-role').removeClass('d-none');
      }
    });
    // $(document).on('change','select.select_country',function(){
      
    // })
    function stateTextDropdown() {
      if ($('select.select_country').val()=='United States') {
        $('.show_states_select').removeClass('d-none').find('select').removeAttr('disabled');
        $('.show_states_input').addClass('d-none').find('input').attr('disabled', 'disabled');
      }else{
        $('.show_states_select').addClass('d-none').find('select').attr('disabled', 'disabled');
        $('.show_states_input').removeClass('d-none').find('input').removeAttr('disabled');
      }
    }

    // $(document).on('change','#role',function(){
    //   var value = $(this).val();
    //   if(value=='3'){
    //     window.location.assign('{{ route('showSignup') }}');
    //   }
    //   else{
    //     window.location.assign('{{ route('showArtistSignup') }}');
    //   }

    // });

    function submitForm() {
        $("#signupForm").submit();
        return true;
    }
</script>
@endsection
