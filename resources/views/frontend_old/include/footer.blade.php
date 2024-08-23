<?php 
use App\Models\GlobalSettings
?>
<!--------------------------
      FOOTER END
--------------------------->
<footer>
  <div class="container">
    <ul class="footer-menu">
      <li>
        <a href="{{ route('cms',['slug'=>'about-us']) }}">ABOUT US</a>
      </li>
      <li>
        <a href="{{route('professional.list')}}">PROFESSIONAL</a>
      </li>
      <li>
        <a href="{{route('product.list')}}">PRODUCTS</a>
      </li>
      <li>
        <a href="{{route('getDiscoverListing')}}">DISCOVER</a>
      </li>
      <li>
        <a href="{{ route('contactus') }}">CONTACT US</a>
      </li>
    </ul>

    <div class="row inner-footer">
      <div class="col-sm-12 col-md-6">
        <div class="footer-left">
          <img src="{{asset('public/assets/frontend/img/Logo-1.svg')}}" class="footer-logo" alt="logo">
          <div class="android-ios">
            <img src="{{asset('public/assets/frontend/img/footer/apple.svg')}}">
            <img src="{{asset('public/assets/frontend/img/footer/google.svg')}}">
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 align-self-center">
        <div class="footer-right text-left text-md-right">
          @if(GlobalSettings::getSingleSettingVal('support_email'))
          <p class="s2"><a class="only-white" href="mailto:{{GlobalSettings::getSingleSettingVal('support_email')}}">{{GlobalSettings::getSingleSettingVal('support_email')}}</a></p>
          @endif
          <div class="social-img">
            <a href="{{GlobalSettings::getSingleSettingVal('fb_link')}}"><img src="{{asset('public/assets/frontend/img/footer/fb.svg')}}"></a>
            <a href="{{GlobalSettings::getSingleSettingVal('insta_link')}}"><img src="{{asset('public/assets/frontend/img/footer/Insta.svg')}}"></a>
            <a href="{{GlobalSettings::getSingleSettingVal('twitter_link')}}"><img src="{{asset('public/assets/frontend/img/footer/Twitter.svg')}}"></a>
            <a href="{{GlobalSettings::getSingleSettingVal('youtube_link')}}"><img src="{{asset('public/assets/frontend/img/footer/YT.svg')}}"></a>
          </div>
        </div>
      </div>
    </div>

    <div class="copy-right">
      <span class="cap">Copyright © {{date('Y')}} Decorato   |   Made by<a href="https://magnetoitsolutions.com" target="_blank"> Magneto IT Solutions</a></span>
    </div>
  </div>
</footer>
<!--------------------------
      FOOTER END
--------------------------->