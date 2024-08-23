<div class="modal fade modal-structure delete-popup" id="applyJob">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <h6 class="modal-title">Confirm</h6>
              <input type="hidden" name="id" id="id">
              <button type="button" class="close" data-bs-dismiss="modal">
                  <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="">
              </button>
          </div>
          <form id="applyConfirmed" method="POST" action="{{route('candidateAppliedJob')}}">
                @csrf             <!-- Modal body -->
              <div class="modal-body">
                  <p class="bm" id="message_delete">Are you sure ?</p>
              </div>
              <input type="hidden" name="jobId" id="jobId" value=""/>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="button" class="border-btn" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="fill-btn" id="apply-confirm">Yes, I confirm</button>
              </div>
          </form>
      </div>
</div>

  </div>
