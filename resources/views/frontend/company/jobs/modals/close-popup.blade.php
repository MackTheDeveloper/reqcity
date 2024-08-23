<div class="modal fade modal-structure close-job-popup" id="closeJob">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="balanceRequestFromPopup" method="POST" action="{{ url('/balance-transfer-request') }}">
          @csrf
      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Close Job</h6>
        <button type="button" class="close" data-dismiss="modal">
          <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="tl">Fund Transfer</p>
        <p class="bm blur-color">You can transfer this fund to any of your open jobs.</p>
        <div class="from-sec">
          <span class="bm blur-color">From</span>
          <input type="hidden" name="fromJobId" id="fromJobId" value=""/>
          <p class="tm fromJob">Javascript Developer</p>
        </div>
        <div class="balance">
          <span class="bm blur-color">Balance</span>
          <input type="hidden" name="balance" id="balance" value=""/>
          <p class="tl balanceVal">$84.00</p>
        </div>
        <div class="input-groups">
          <span>Select job to transfer fund</span>
          <select name="toJobId" id="toJobId">

          </select>
        </div>
        <div class="d-none" id="show-error">
          <label for="" class="error"> You have atleast one another job to close the current job.</label>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="border-btn" data-dismiss="modal">Cancel</button>
        <button type="submit" class="fill-btn" id="closeReq">Request</button>
      </div>
  </form>
    </div>
  </div>
</div>
