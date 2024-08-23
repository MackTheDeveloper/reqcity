<div class="action-block">
    @if ($editInPopup == 1)
    <a href="javascript:void(0)" data-title="Edit Candidate" data-id="{{$id}}" value="{{route('editRecruiterCandidates',$id)}}" id="btnAddRecruiterCandidate">
        <img src="{{ asset('public/assets/frontend/img/pencil.svg') }}" alt="" />
    </a>
    @endif

    <a href="javascript:void(0)" id="delete-btn" class="delete-module-item" data-id="{{$id}}" data-module="{{$module}}"><img src="{{ asset('public/assets/frontend/img/delete.svg') }}" alt="" /></a>

</div>
<div class="mobile-action show-991">
    <div class="dropdown c-dropdown my-playlist-dropdown">
        <button class="dropdown-toggle" data-bs-toggle="dropdown">
            <img src="{{asset('public/assets/frontend/img/more-vertical.svg')}}" class="c-icon" />
        </button>
        <div class="dropdown-menu">
            @if ($editInPopup == 1)
            <a class="dropdown-item" id="edit-btn" data-target="#reqEidtUser" data-id="{{$id}}" href="javascript:void(0)">
                <img src="{{ asset('public/assets/frontend/img/pencil.svg') }}" alt="" />
                <span>Edit</span>
            </a>
            @endif

            <a class="dropdown-item delete-module-item" id="delete-btn" data-id="{{$id}}" data-module="{{$module}}" href="javascript:void(0)">
                <img src="{{ asset('public/assets/frontend/img/delete.svg') }}" alt="" />
                <span>Delete</span>
            </a>

        </div>
    </div>
</div>