<!-- Modal Header -->
<div class="modal-header">
    <h6 class="modal-title">{{$title}}</h6>
    <button type="button" class="close" data-bs-dismiss="modal">
        <img src="{{asset('public/assets/frontend/img/close.svg')}}" alt="" />
    </button>
</div>
<form method="POST" action="{{route('approveCandidate')}}">
    @csrf
    <!-- Modal body -->
    <input type="hidden" name="id" id="id" value="{{$id}}">
    <div class="modal-body">
        <p class="bm" id="message_delete">{{$message}}</p>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="border-btn" data-bs-dismiss="modal">Cancel</button>
        @if($id)
        <button type="submit" class="fill-btn" >Yes, I confirm</button>
        @else
        <button type="button" class="fill-btn" data-bs-dismiss="modal">Yes, I confirm</button>
        @endif
    </div>
</form>