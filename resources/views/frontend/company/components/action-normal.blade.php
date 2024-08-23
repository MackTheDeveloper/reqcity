<div class="action-block">
    @if ($isEditable)
        <a href="{{$editUrl}}" id="edit-btn">
            <img src="{{ asset('public/assets/frontend/img/pencil.svg') }}" alt="" />
        </a>
    @endif
    @if ($isDeletable)
    <a href="javascript:void(0)" class="delete-module-item" id="delete-btn" data-id="{{$id}}" data-module="{{$module}}">
        <img src="{{ asset('public/assets/frontend/img/delete.svg') }}" alt="" />
    </a>
    @endif  
</div>
<div class="mobile-action show-991">
    <div class="dropdown c-dropdown my-playlist-dropdown">
        <button class="dropdown-toggle" data-bs-toggle="dropdown">
            <img src="{{asset('public/assets/frontend/img/more-vertical.svg')}}" class="c-icon" />
        </button>
        <div class="dropdown-menu">
            @if ($isEditable)
            <a class="dropdown-item" id="edit-btn" href="{{$editUrl}}">
                <img src="{{ asset('public/assets/frontend/img/pencil.svg') }}"
                    alt="" />
                <span>Edit</span>
            </a>
            @endif
            @if ($isDeletable)
            <a class="dropdown-item delete-module-item" id="delete-btn" data-id="{{$id}}" href="javascript:void(0)" data-module="{{$module}}">
                <img src="{{ asset('public/assets/frontend/img/delete.svg') }}" alt="" />
                <span>Delete</span>
            </a>
            @endif            
        </div>
    </div>
</div>