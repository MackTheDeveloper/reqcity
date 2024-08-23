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

            <form id="reject-form" method="post" action="<?php echo e(route('rejectCandidate')); ?>">
                <?php echo csrf_field(); ?>
                <!-- Modal body -->
                <div class="modal-body">
                    
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
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/candidate/components/reject-modal.blade.php ENDPATH**/ ?>