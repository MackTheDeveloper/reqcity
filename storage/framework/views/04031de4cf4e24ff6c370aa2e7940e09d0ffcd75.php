<!-- Modal for delete template -->
<div class="modal fade modal-structure description-popup" id="ChangeDescModel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Update Description</h6>

                <button type="button" class="close" data-bs-dismiss="modal">
                    <img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" />
                </button>
            </div>
            <form id="changeStatusConfirmed" method="POST" action="<?php echo e(url('/company-job-change-description')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="id">
                <!-- Modal body -->
                <div class="modal-body">
                    <textarea class="" id="jobDescrEditorCked"></textarea>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="border-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="fill-btn" id="change-description-confirm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/modals/change-job-description.blade.php ENDPATH**/ ?>