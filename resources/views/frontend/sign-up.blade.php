@section('title','Sign Up')
@extends('frontend.layouts.master')
@section('content')
    <!--------------------------
        Content START
    --------------------------->
    <div class="container">
      <div class="layout-352 form-page signup">
        <h5>Sign Up</h5>
        <div class="or">
          <p class="bm blur-color">or <a href="{{url('/login')}}" class="a">log in to your account</a></p>
        </div>
        <div>
          <div class="signup-box">
            <label class="rd">I’m a candidate.
              <input type="radio" name="signup" checked="checked" value="candidate-signup">
              <span class="rd-checkmark"></span>
            </label>
          </div>
          <div class="signup-box">
            <label class="rd">I’m a company.
              <input type="radio" name="signup"  value="company-signup">
              <span class="rd-checkmark"></span>
            </label>
          </div>
          <div class="signup-box">
            <label class="rd">I’m a recruiter.
              <input type="radio" name="signup" value="recruiter-signup">
              <span class="rd-checkmark"></span>
            </label>
          </div>
        </div>
        <a href="javascript:void(0);" id="go-to-signup" class="fill-btn ">Create Account</a>
      </div>
    </div>
    <!--------------------------
        Content END
    --------------------------->
@endsection

@section('footscript')
    <script type="text/javascript">
        $(document).ready(function() {
          $(document).on('click','#go-to-signup',function(){
             var value=$('input[name="signup"]:checked').val();
            //  var value = $(this).val();
              var signUpUrl = '{{ url("/:param1") }}';
              signUpUrl = signUpUrl.replace(':param1', value);
              window.location.href = signUpUrl;
              //document.getElementById("go-to-signup").href = signUpUrl;
          });

        });
    </script>
@endsection
