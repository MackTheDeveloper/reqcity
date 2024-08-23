<!-- Load Application JS -->
<!--SCRIPTS INCLUDES-->

<!--CORE-->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/metismenu"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/app.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/demo.js')); ?>"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>


<!--CHARTS-->

<!--Apex Charts-->


<!--FORMS-->

<!--Clipboard-->


<!--Datepickers-->
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/datepicker.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/daterangepicker.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/moment.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/form-components/datepicker.js')); ?>"></script>

<!--Multiselect-->
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/bootstrap-multiselect.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/form-components/input-select.js')); ?>"></script>

<!--Form Validation-->

<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/form-validation.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/form-components/form-validation.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/custom/form-validation/role-form-validation.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>
<?php echo $__env->make('admin.include.external-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!--Form Wizard-->
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/form-wizard.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/form-components/form-wizard.js')); ?>"></script>

<!--Input Mask-->
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/input-mask.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/form-components/input-mask.js')); ?>"></script>

<!--RangeSlider-->


<!--Textarea Autosize-->
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/textarea-autosize.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/form-components/textarea-autosize.js')); ?>"></script>

<!--Toggle Switch -->
<script src="<?php echo e(asset('/public/assets/js/vendors/form-components/toggle-switch.js')); ?>"></script>


<!--COMPONENTS-->

<!--BlockUI -->
<script src="<?php echo e(asset('/public/assets/js/vendors/blockui.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/blockui.js')); ?>"></script>

<!--Calendar -->


<!--Ladda Loading Buttons -->


<!--Toastr-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/toastr.js')); ?>"></script>

<!--SweetAlert2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="<?php echo e(asset('/public/assets/js/scripts-init/sweet-alerts.js')); ?>"></script>

<!--Tree View -->
<script src="<?php echo e(asset('/public/assets/js/vendors/treeview.js')); ?>"></script>
<!-- <script src="<?php echo e(asset('/public/assets/js/scripts-init/treeview.js')); ?>"></script> -->


<!--TABLES -->
<!--DataTables-->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.10.19/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<!--Bootstrap Tables-->
<script src="<?php echo e(asset('/public/assets/js/vendors/tables.js')); ?>"></script>

<!--Tables Init-->
<script src="<?php echo e(asset('/public/assets/js/scripts-init/tables.js')); ?>"></script>

<!-- Moment Js -->
<script src="<?php echo e(asset('/public/assets/js/moment-js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/moment-js/moment-timezone.min.js')); ?>"></script>
<script src="<?php echo e(asset('/public/assets/js/moment-js/moment-timezone-with-data-1970-2030.js')); ?>"></script>
<script>
  //Global error function for all ajax call
  $(document).ajaxError(function myErrorHandler(event, xhr, ajaxOptions, thrownError) {
    if (xhr.status == 403) {
      toastr.clear();
      toastr.options.closeButton = true;
      toastr.error('Permission forbidden.');
    }
  });
  $("#pop").on("click", function() {});

  function openImageModal(src, title = 'Image') {
    $('#imagepreview').attr('src', src);
    $('#myModalLabel').text(title);
    $('#imagemodal').modal('show');
  }
  //store session for sidebar collapse
  $(document).on("click", ".header__pane button.hamburger", function() {
    $.ajax({
      url: "<?php echo e(url(config('app.adminPrefix').'/toggleSidebar')); ?>",
      method: "get",
      success: function() {

      }
    })
  });
  var base_url = '<?php echo URL::to('/'); ?>';
  var base_token = '<?php echo e(csrf_token()); ?>';
  var searchPlaceHolders = {
    Artists: 'Search by Name, Email...',
    Fans: 'Search by Name, Email...',
    Songs: 'Search by Song Name, Artist Name...',
    Subscriptions: 'Search by Name, Email...',
    Transactions: 'Search by Name, Email...',
    CMS: 'Search by Name, Slug...',
    Forums: 'Search by Topic, Created By...'
  };
  $(document).on('click','.hamburger',function(){
    $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
      $('.select2').css('width', "100%");
  });
</script><?php /**PATH /var/www/html/php/reqcity/resources/views/admin/include/bottom.blade.php ENDPATH**/ ?>