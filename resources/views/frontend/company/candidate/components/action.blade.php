<div class="flex-apply">
    @if($actionStatus == 3)
    <div class="view-icon-block">
        <a href="javascript:void(0)" id="view-candidate" class="icon-btns" data-target="#candidateInfo" data-id={{$id}}>
            <img src="{{asset('public/assets/frontend/img/view-icon.svg')}}" alt="" />
        </a>
        {{--<a href="" class="icon-btns">
            <img src="{{asset('public/assets/frontend/img/yes-sign.svg')}}" alt="" />
        </a>
        <a href="javascript:void(0)" class="icon-btns" data-toggle="modal" data-target="#rejectCandidate">
            <img src="{{asset('public/assets/frontend/img/not-sign.svg')}}" alt="" />
        </a> --}}
        @if($linkedin)
        <a href="{{$linkedin}}" target="_blank" class="icon-btns">
            <img src="{{asset('public/assets/frontend/img/Linkedin-btn.svg')}}" alt="" />
        </a>
        @endif
    </div>
    @elseif($actionStatus == 4)
    <div class="view-icon-block">
        <a href="javascript:void(0)" id="view-candidate" class="icon-btns" data-target="#candidateInfo" data-id={{$id}}>
            <img src="{{asset('public/assets/frontend/img/view-icon.svg')}}" alt="" />
        </a>
        <a href="javascript:void(0)" id="approve-candidate" class="icon-btns" data-id="{{$id}}">
            <img src="{{asset('public/assets/frontend/img/yes-sign.svg')}}" alt="" />
        </a>
    </div>
    @else
    <div class="view-icon-block">
        <a href="javascript:void(0)" id="view-candidate" class="icon-btns" data-target="#candidateInfo" data-id={{$id}}>
            <img src="{{asset('public/assets/frontend/img/view-icon.svg')}}" alt="" />
        </a>
        <a href="javascript:void(0)" id="approve-candidate" class="icon-btns" data-id="{{$id}}">
            <img src="{{asset('public/assets/frontend/img/yes-sign.svg')}}" alt="" />
        </a>
        <a href="javascript:void(0)" id="reject-candidate" class="icon-btns" data-toggle="modal" data-target="#rejectCandidate" data-id={{$id}}>
            <img src="{{asset('public/assets/frontend/img/not-sign.svg')}}" alt="" />
        </a>
    </div>
    @endif
</div>