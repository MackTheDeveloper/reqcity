<div class="action-block">
    @if ($isDeletable)
    <a href="javascript:void(0)" class="delete-module-item" id="delete-btn" data-id="{{$id}}" data-module="{{$module}}">
        <img src="{{ asset('public/assets/frontend/img/delete.svg') }}" alt="" />
    </a>
    @endif
    @if ($isEditable)
        @if($isRead==1)
        <a href="javascript:void(0)" class="readunread-module-item" id="readunread-btn" data-id="{{$id}}" data-module="{{$module}}">
            <img src="{{ asset('public/assets/frontend/img/read.svg') }}" alt="" />
        </a>
        @else
        <a href="javascript:void(0)" class="readunread-module-item" id="readunread-btn" data-id="{{$id}}" data-module="{{$module}}">
            <img src="{{ asset('public/assets/frontend/img/unread.svg') }}" alt="" />
        </a>
        @endif
    @endif
</div>
