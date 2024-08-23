<div class="getting-started-dash">
    <h6>Getting started</h6>
    <div class="percentage-done-bar">
        <div class="meter" style="width: 288px;">
            <span style="width: {{$percentage}}%;"></span>
        </div>
        <p class="percent-done-number bs">{{$percentage}}% done</p>
    </div>
    <div class="verify-mail-dash">
        <div class="verify-maindash-item">
            <img src="{{ asset('public/assets/frontend/img/at-sign.svg') }}" />
            <p class="ts">Verify Email</p>
        </div>
        <div class="verify-maindash-item">
            <img src="{{ asset('public/assets/frontend/img/Upload-Resume.svg') }}" />
            <p class="ts">Upload Resume</p>
        </div>
        <div class="verify-maindash-item">
            <img src="{{ asset('public/assets/frontend/img/Update-Address-Details.svg') }}" />
            <p class="ts">Update Address Details</p>
        </div>
        <div class="verify-maindash-item">
            <img src="{{ asset('public/assets/frontend/img/Create-first-job-post.svg') }}" />
            <p class="ts">Apply your first job</p>
        </div>
    </div>
    <div class="copm-taskdesc">
        <p class="ts">Completed tasks</p>
        @if($hasVerifiedEmail!=0)
        <span class="bs">Email verified</span>
        @endif
        @if(!empty($hasUploadedResume))
        <span class="bs psjob-span">Resume uploaded</span>
        @endif
        @if(!empty($hasUpdatedAddressDetails) )
        <span class="bs psjob-span">Address details updated</span>
        @endif
        @if(!empty($hasAppliedForFirstJob) )
        <span class="bs psjob-span">Applided for the first job</span>
        @endif
    </div>
</div>
