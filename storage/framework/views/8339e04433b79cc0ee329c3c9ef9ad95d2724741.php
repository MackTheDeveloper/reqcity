<div class="modal fade" id="assignManagerModel" tabindex="-1" role="dialog" aria-labelledby="assignManagerModelLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignManagerModelLabel">Assign Account Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo e(route('setSelectedManagerList')); ?>" id="setSelectedManagerList">
                <div class="modal-body">
                    <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="company_id" id="company_id">
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <label for="account_managers" class="mr-sm-2">Select Account Manager</label>
                        <select name="account_managers[]" id="account_managers" multiple
                            class="multiselect-dropdown form-control"></select>
                    </div>
                    <p class="mb-0" id="message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="sumit" class="btn btn-primary" id="assignSpecialist">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/admin/company-details/list/components/assign-manager.blade.php ENDPATH**/ ?>