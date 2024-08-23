<!-- Modal Header -->
<div class="modal-header">
    <h6 class="modal-title">Candidate Info</h6>
    <button type="button" class="close" data-bs-dismiss="modal">
        <img src="{{asset('public/assets/frontend/img/close.svg')}}" alt="" />
    </button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="contry-city">
        @if($data['name'] != "")
        <div class="contry-value">
            <p class="tm blur-color">Contact Details</p>
            <p class="bm">Name: {{$data['name']}}</p>
            <p class="bm">Email: {{$data['email'] ? :""}}</p>
            <p class="bm">Phone:{{$data['phone']}}</p>
        </div>
        @endif
        <div class="contry-value">
            <p class="tm blur-color">Country</p>
            <p class="bm">{{$data['country']}}</p>
        </div>
        <div class="city-value">
            <p class="tm blur-color">City</p>
            <p class="bm">{{$data['city']}}</p>
        </div>
    </div>
    <hr class="hr">
    <div class="candidate-experience">
        <p class="tl">Candidate experience</p>
        @foreach($data['experience'] as $exp)
        <div class="dev-details">
            <div class="post-status"></div>
            <div class="post-details">
                <p class="ll">{{$exp['jobTitle']}}</p>
                <span class="ll blur-color">{{$exp['company']}}</span>
                <label class="ll">{{$exp['expStart']}} - {{$exp['expEnd']}}</label>
                <p class="bm blur-color">{{$exp['responsibilities']}}</p>
            </div>
        </div>
        @endforeach
    </div>
    <hr class="hr">
    <div class="questionnaire-sec">
        <p class="tl">Questionnaire</p>
        @foreach($data['question'] as $que)
        <div class="this-que-ans">
        @if (in_array($que['type'],[8,10]))
            <span><a target="_blank" href="{{$que['value']}}">Click Here</a> to download or view.</span>
        @else
            <p class="tm blur-color">{{$que['key']}}</p>
            <span class="bm">{{$que['value']}}</span>
        @endif
        </div>
        @endforeach
    </div>
</div>