@section('title','Recruiter Signup 2')
@extends('frontend.layouts.master')
@section('content')
<div class="recruiter-signup-2">
  <div class="container">
    <div class="process-progress">
      <div class="info-progress done">
        <div class="numbers" id="step1"><a href="{{ route('showRecruiterSignup')}}" style="text-decoration: none; color:white;">1</a></div>
        <p class="tm">Sign Up</p>
      </div>
      <div class="info-progress">
        <div class="numbers" id="2">2</div>
        <p class="tm">Information</p>
      </div>
      <div class="info-progress">
        <div class="numbers">3</div>
        <p class="tm">Pricing</p>
      </div>
      <div class="info-progress">
        <div class="numbers">4</div>
        <p class="tm">Payment</p>
      </div>
    </div>
    <div class="started-form-wrapper">
      <h5>Let's get started</h5>
      <div class="started-form">
      <form id="recruiterSignupFormTwo" method="POST" action="{{url('/recruiter-signup-2')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="rec_id" name="recruiter_id" value="{{$recruiterId}}">
            <input type="hidden" id="rec_email" name="recruiter_email" value="{{$email}}">
        <div class="account-info">
          <p class="tl">Account info</p>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="number-groups">
                  <span>Phone Number</span>
                  <div class="number-fields">
                    <input type="text" id="phoneField1" name="phoneCode" class="phone-field" value="{{($recruiter) ? $recruiter->phone_ext:''}}" />
                    <input type="number" class="mobile-number" name="phone" id="phone" value="{{($recruiter) ? $recruiter->phone:''}}">
                  </div>
                  <div id="phone-err"></div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Address</span>
                  <input type="text" name="address_1" id="address_1" value="{{($recruiter) ? $recruiter->address_1:''}}" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>City</span>
                  <input type="text" name="city" id="city" value="{{($recruiter) ? $recruiter->city:''}}" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>State</span>
                  <input type="text" name="address_2" id="address_2" value="{{($recruiter) ? $recruiter->address_2:''}}" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Zip code</span>
                  <input type="text" name="postcode" id="postcode" value="{{($recruiter) ? $recruiter->postcode:''}}" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Country</span>
                  <select name="country" id="country">
                    @if($recruiter)
                    @foreach($countries as $key=>$row)
                    <option value="{{$row['key']}}" {{ $row['key'] == $recruiter->country ? "selected" : "" }}>{{$row['value']}}</option>
                    @endforeach
                    @else
                    @foreach($countries as $key=>$row)
                    <option value="{{$row['key']}}" {{ $row['value'] == "United States" ? "selected" : "" }}>{{$row['value']}}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Areas of expertise</span>
                  <div class="multi-select-dropdown">
                    <label class="multi-dropdown-label"></label>
                    <div class="multi-dropdown-list">
                    @foreach($areaOfExpertise as $row)
                      <label class="ck">{{$row['value']}}
                          @if(is_array($selectedExpertise))
                          <input type="checkbox" class="ck check" value="{{$row['key']}}" name="expertise[]" {{  in_array($row['key'],$selectedExpertise) ? ' checked' : '' }} >
                          @else
                          <input type="checkbox" class="ck check" value="{{$row['key']}}" name="expertise[]">
                          @endif
                          <span class="ck-checkmark" values="{{$row['value']}}"></span>
                      </label>
                    @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        {{-- <div class="w-9">
          <p class="tl">W-9</p>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>W-9 on file?</span>
                <select name="w9_file" id="w9">
                  <option value="1" {{ "1" == $recruiter->w9_file ? "selected" : "" }}>Yes</option>
                  <option value="0" {{ "0" == $recruiter->w9_file ? "selected" : "" }}>No</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
              <p class="bs">Please note you will not get paid unless we have a W-9 form from you.</p>
            </div>
            <div class="col-12 col-sm-12 col-md-12" id="upload">
              <div class="upload-form-btn">
                <img src="{{ asset('public/assets/frontend/img/upload-icon.svg') }}" id="upload-form-img" alt="" />
                <p class="tm" id="upload-form-text">Upload form W-9</p>
                <input type="file" id="upload-form-file" name="w9File" hidden="hidden" />
              </div>
              @if($w9FormLink)
              <div class="upload-form-btn">
                <a href="{{$w9FormLink}}" download>
                  <img src="{{ asset('public/assets/frontend/img/pdf.svg') }}" alt="" />
                </a>
                <p class="tm" id="upload-form-text">Download form W-9</p>
              </div>
              @endif
            </div>
          </div>
        </div> --}}
        </form>
        <div class="row">
          <div class="col-12 text-right">
            <button type="submit" class="fill-btn g-recaptcha" data-sitekey="{{ Config::get('app.googleReCaptchaKeys')['siteKey'] }}" data-callback='submitForm' id="create">Submit</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
@section('footscript')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
  const uploadFormFile = document.getElementById("upload-form-file");
  const uploadFormImg = document.getElementById("upload-form-img");
  const uploadFormText = document.getElementById("upload-form-text");

  uploadFormImg.addEventListener("click", function() {
    uploadFormFile.click();
  });

  uploadFormFile.addEventListener("change", function() {
    if (uploadFormFile.value) {
      uploadFormText.innerHTML = uploadFormFile.value.match(
        /[\/\\]([\w\d\s\.\-\(\)]+)$/
      )[1];
    } else {
      uploadFormText.innerHTML = "No file chosen, yet.";
    }
    var validateIcon = $('#recruiterSignupFormTwo').validate().element(':input[name="w9File"]');
    if (!validateIcon)
      return false;
  });

  $("#recruiterSignupFormTwo").validate({
    ignore: [],
    rules: {
      "phoneField1": "required",
      "phone": "required",
      "address_1": "required",
      "country": "required",
      "address_2": "required",
      "city": "required",
      "postcode": "required",
      // "w_9_flag": "required",
      "w9File" : {
          extension: "pdf|docx|doc|rtf|txt"
      },
    },
    messages: {
      "w9File":"Please upload W9File in .pdf,.docx,.doc,.rtf or .txt format",
      "conform-password": {
        equalTo: "Please enter same as Password"
      },
    },
    errorPlacement: function(error, element) {
      if (element.attr("name") == "phone") {
        error.appendTo("#phone-err");
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      if (grecaptcha.getResponse()) {
        // 2) finally sending form data
        form.submit();
      } else {
        // 1) Before sending we must validate captcha
        grecaptcha.reset();
        grecaptcha.execute();
      }
    }
  });

  $("#w9").change(function() {
    var val = $(this).val();
    if (val == 0) {
      $('#upload').hide();
    }
    if (val == 1) {
      $('#upload').show();
    }
  });
  // defult first 2 options checked in expertise
  $(document).ready(function(){
    var recId  = "{{($selectedExpertise)?implode(',',$selectedExpertise) :''}}"
    if(recId == ""){
      $('.multi-dropdown-label').text("Please Select");
    }
    var val = $("#w9").val();
    if (val == 0) {
      $('#upload').hide();
    }
    if (val == 1) {
      $('#upload').show();
    }
  });
  function submitForm() {
    $("#recruiterSignupFormTwo").submit();
  }
</script>
@endsection