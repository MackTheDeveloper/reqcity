<!-- Modal Header -->
<div class="modal-header">
    <h6 class="modal-title">Candidate Info</h6>
    <button type="button" class="close" data-bs-dismiss="modal">
        <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
    </button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="contry-city">
        <div class="contry-value">
            <p class="tm blur-color">Country</p>
            <p class="bm">{{ $candidate->countryData->name }}</p>
        </div>
        <div class="city-value">
            <p class="tm blur-color">City</p>
            <p class="bm">{{ $candidate->city }}</p>
        </div>
    </div>
    <hr class="hr">
    @if ($latestExp)
        <div class="candidate-experience">
            <p class="tl">Candidate experience</p>
            <div class="dev-details">
                <div class="post-status"></div>
                <div class="post-details">
                    <p class="ll">{{$latestExp['job_title']}}</p>
                    <span class="ll blur-color">{{$latestExp['company']}}</span>
                    {{-- {{$latestExp['job_title']}} --}}
                    <label class="ll">{{$latestExp['start_year']}} - {{$latestExp['is_current_working']?"Present":$latestExp['end_year']}}</label>
                    {{-- <label class="ll">{{getMonth($latestExp['start_month'])." ". $latestExp['start_year']}} - {{$latestExp['is_current_working']?"Present":getMonth($latestExp['end_month'])." ". $latestExp['end_year']}}</label> --}}
                    <p class="bm blur-color">{{$latestExp['job_responsibilities']}}</p>
                </div>
            </div>
        </div>
    @endif
    @if($questionnaire)
    <hr class="hr">
    <div class="questionnaire-sec">
        <p class="tl">Questionnaire</p>
        @foreach ($questionnaire as $value)    
            <div class="this-que-ans">
                <p class="tm blur-color">{{$value['question']}}</p>
                <span class="bm">{{$value['answer']}}</span>
            </div>
        @endforeach
    </div>
    @endif
</div>
