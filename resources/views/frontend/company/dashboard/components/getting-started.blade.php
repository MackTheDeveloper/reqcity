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
            <img src="{{ asset('public/assets/frontend/img/Create-Questionnaire.svg') }}" />
            <p class="ts">Create Questionnaire</p>
        </div>
        <div class="verify-maindash-item">
            <img src="{{ asset('public/assets/frontend/img/Create-Communication.svg') }}" />
            <p class="ts">Create Communication</p>
        </div>
        <div class="verify-maindash-item">
            <img src="{{ asset('public/assets/frontend/img/Create-first-job-post.svg') }}" />
            <p class="ts">Create first job post</p>
        </div>
    </div>
    <div class="copm-taskdesc">
        <p class="ts">Completed tasks</p>
        @if($hasVerifiedEmail!=0)
        <span class="bs">Email verified</span>
        @endif
        @if($questionnaireTemplatesCount!=0)
        <span class="bs psjob-span">Questionnaire created</span>
        @endif
        @if($faqTemplateCount!=0)
        <span class="bs psjob-span">Communication created</span>
        @endif
        @if($firstJobCount!=0)
        <span class="bs psjob-span">First job posted</span>
        @endif
    </div>
</div>
