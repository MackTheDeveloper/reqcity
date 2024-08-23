<div class="modal fade modal-structure reject-candidate-popup" id="rejectCandidate">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Reject Candidate</h6>
                <button type="button" class="close" data-dismiss="modal">
                    <img src="assets/img/close.svg" alt="" />
                </button>
            </div>

            <form id="reject-form" method="post" action="{{route('rejectCandidate')}}">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    {{-- <p class="tm">Harper Lee</p>
          <p class="ts blur-color">San Francisco, CA</p> --}}
                    <div class="input-groups">
                        <span>Reason for rejection</span>
                        <input type="hidden" name="id" id="application-id">
                        <textarea name="reason" id="reason"></textarea>
                        <label for="reason" id="reason-err" class="error"></label>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="border-btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="fill-btn" id="reject">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>