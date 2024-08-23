<?php 
use App\Models\UserProfilePhoto;

$dpVal = Auth::user()->design_preferences;
$dpVal = explode(',', $dpVal);
?>
@section('title','Edit Profile')
@extends('frontend.layouts.master')
@section('content')
<!--------------------------
        SIGN IN START
--------------------------->
<style type="text/css">
.cropper-view-box,
.cropper-face {
  border-radius: 50%;
}
</style>
<section class="my-profile">
    <div class="container">
        <div class="row">
            @include('frontend.include.account-sidebar')
            <div class="col-sm-12 col-md-7 col-lg-8">
                <div class="edit-profile">
                    <a href="" class="back-arrow" data-aos="fade-up"></a>
                    <h2 class="myaccount-entitle" data-aos="fade-up">Edit Profile</h2>
                    
                    <form class="edit-profile-inputs" id="updateProfileForm" enctype="multipart/form-data" method="post" action="{{url('account/edit-profile')}}">
                        @csrf
                        <input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
                        <div class="inner-edit-profile" data-aos="fade-up">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" class="image" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" class="previewImg" style="background-image: url({{UserProfilePhoto::getProfilePhoto(Auth::user()->id)}});">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>First Name*</label>
                                    <input type="text" value="{{Auth::user()->firstname}}" name="firstname" id="firstname">
                                </div>
                                @if($errors->has('firstname'))
                                    <div class="error">{{ $errors->first('firstname') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Last Name*</label>
                                    <input type="text" value="{{Auth::user()->lastname}}" name="lastname" id="lastname">
                                </div>
                                @if($errors->has('lastname'))
                                    <div class="error">{{ $errors->first('lastname') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Mobile Number*</label>
                                    <input type="text" value="{{Auth::user()->phone}}" name="phone" id="phone">
                                </div>
                                @if($errors->has('phone'))
                                    <div class="error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Handle</label>
                                    <input type="text" value="{{Auth::user()->handle}}" name="handle" id="handle">
                                </div>
                                @if($errors->has('handle'))
                                    <div class="error">{{ $errors->first('handle') }}</div>
                                @endif
                            </div>
                            {{-- <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="select-group" data-aos="fade-up">
                                    <label>Design Preferences (1)</label>
                                    <select name="design_preferences_1" id="design_preferences_1">
                                        <option value="" @if(!isset($dpVal[0])) selected="" @endif disabled="disabled">Select Design Preference</option>
                                        @foreach($designPreference as $key=>$row)
                                        <option @if(isset($dpVal[0]) && $dpVal[0]==$row->id) selected="selected" @endif value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="select-group" data-aos="fade-up">
                                    <label>Design Preferences (2)</label>
                                    <select name="design_preferences_2" id="design_preferences_2">
                                        <option value="" @if(!isset($dpVal[1])) selected="" @endif selected="selected" disabled="disabled">Select Design Preference</option>
                                        @foreach($designPreference as $key=>$row)
                                        <option @if(isset($dpVal[1]) && $dpVal[1]==$row->id) selected="selected" @endif value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Design Preferences</label>
                                    <div class="row"> 
                                        @foreach($designPreference as $key=>$row)
                                            <div class="col-3 mb8">
                                                <label class="ck-box">{{$row->name}}
                                                  <input type="checkbox" value="{{$row->id}}" name="design_preferences[]" @if(isset($dpVal) && in_array($row->id, $dpVal)) checked="checked" @endif>
                                                  <span class="checkmarks"></span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-12 checkbox_error"></div>
                                    </div>
                                </div>
                                @if($errors->has('design_preferences'))
                                    <div class="error">{{ $errors->first('design_preferences') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Area</label>
                                    <input type="text" value="{{Auth::user()->area}}" name="area" id="area">
                                </div>
                                @if($errors->has('area'))
                                    <div class="error">{{ $errors->first('area') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>City</label>
                                    <input type="text" value="{{Auth::user()->city}}" name="city" id="city">
                                </div>
                                @if($errors->has('city'))
                                    <div class="error">{{ $errors->first('city') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Current Home</label>
                                    <textarea name="current_home" class="textarea" id="current_home">{{Auth::user()->current_home}}</textarea>
                                    {{-- <input type="text" value="{{Auth::user()->current_home}}" name="current_home"> --}}
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                <div class="input-label" data-aos="fade-up">
                                    <label>Future Stay</label>
                                    {{-- <input type="text" value="{{Auth::user()->future_stay}}" name="future_stay"> --}}
                                    <textarea name="future_stay" class="textarea" id="future_stay">{{Auth::user()->future_stay}}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="fill-btn" data-aos="fade-up">SAVE</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

<!--------------------------
        SIGN IN END
--------------------------->
@endsection
@section('footscript')
<script src="{{asset('public/assets/js/frontend/account/edit-profile.js')}}"></script>
@endsection