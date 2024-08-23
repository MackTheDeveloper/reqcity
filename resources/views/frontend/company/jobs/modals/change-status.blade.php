<!-- Modal for delete template -->
<div class="modal fade modal-structure change-status-popup delete-popup" id="ChageStatusModel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Change Status</h6>

                <button type="button" class="close" data-dismiss="modal">
                    <img src="{{asset('public/assets/frontend/img/close.svg')}}" alt="" />
                </button>
            </div>
            <form id="changeStatusConfirmed" method="POST" action="{{ url('/company-job-change-status') }}">
                @csrf
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="status" id="status">
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="bm" id="message_delete">Are you sure ?</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="border-btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="fill-btn" id="change-status-confirm">Yes, I confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
