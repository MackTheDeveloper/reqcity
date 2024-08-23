<?php $__env->startSection('title','Company Addresses'); ?>

<?php $__env->startSection('content'); ?>
<section class="profiles-pages compnay-profile-pages">
        <div class="container">
            <div class="row">
                <?php echo $__env->make('frontend.company.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="right-sides-items">
                        <div class="user-management-page">
                            <!-- Start Box Item Layout reusable -->
                            <div class="accounts-boxlayouts" id="Divs1">
                                <div class="ac-boclayout-header">
                                    <div class="boxheader-title">
                                        <h6>Address Management</h6>
                                        <!-- <span>R01532</span> -->
                                    </div>
                                    <div class="boxlayouts-edit">
                                        <?php if(whoCanCheckFront('company_address_post')): ?>
                                        <div class="trans-date-update">
                                            <a href="javascript:void(0)" class="fill-btn" id="addAddress">Add Address</a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                                <span class="full-hr-ac"></span>
                                <div class=" ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Section -->
                                            <div class="div-table-wrapper">
                                                <div class="div-table-wrapper">
                                                    <div class="div-table" id="magTable">
                                                        <div class="div-row">
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Address</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">City</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">State</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Country</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Zip Code</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Default</p>
                                                            </div>
                                                            <?php if($shoAction): ?>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Action</p>
                                                            </div>
                                                            <?php endif; ?>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ends Box Item Layout reusable -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php echo $__env->make('frontend.company.components.modals.company-address-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.components.delete-confirm',['title'=>'Delete Address','message'=>'Are you sure you want to delete address ?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
    <script src="<?php echo e(asset('/public/assets/frontend/js/magTable.js')); ?>"></script>
    <script type="text/javascript">
        $('#magTable').magTable({
            ajax: {
                "url": "<?php echo e(route('companyAddressList')); ?>",
                "type": "GET"
                // "data": {"set":"test"}
            },
            columns: [
                {
                    data: 'address_1', name: 'address_1',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                },
                {
                    data: 'city', name: 'city',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';aaya
                    },
                },
                {
                    data: 'country', name: 'country',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                },
                {
                    data: 'postcode', name: 'postcode',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                },
                {
                    data: 'def_address', name: 'def_address',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                }
            ]
        })
        $(document).on('click', '#addAddress', function() {
        $.ajax({
            url: "<?php echo e(route('companyAddressAdd')); ?>",
            type: "GET",
            dataType: "html",
            success: function(response) {
                $('#reqAddAddress .modal-content').html(response);
                $('#reqAddAddress').modal('show');
                initModal();
            }
        });        
    });
    //for edit model
    $(document).on('click', '#edit-btn-address', function() { 
            var id = $(this).data().id;
            var url = '<?php echo e(route("companyAddressEdit", ":id")); ?>';
            url = url.replace(':id', id);
            $.ajax({
                url: url,                
                type: "GET",
                dataType: "html",
                success: function(response) {
                    $('#reqAddAddress .modal-content').html(response);
                    $('#reqAddAddress').modal('show');
                    initModal();
                }
            });
        });
        function initModal() {        
        validateUserForm();        
        }
        function validateUserForm() { 
        $("#addressAdd").validate({
            ignore: [],
            rules: {
                country: "required",
                address_1: "required",
                address_2: "required",
                city: "required",
                postcode: "required",
                postcode: "required",                
            },
            messages: {

            },            
            submitHandler: function(form, ev) {
                $('.loader-bg').removeClass('d-none');
                var buttonId = $('#addressAdd').find('.formSubmitBtn').attr('id');
                form.submit();
                /* if (buttonId == 'updateButton') {
                    form.submit();
                } else {
                    ev.preventDefault();
                    $.ajax({
                        url: "<?php echo e(route('companyUserStore')); ?>",
                        method: 'post',
                        data: $('#userCreate').serialize(),
                        success: function(response) {
                            companyUserlList();
                            $('.loader-bg').addClass('d-none');
                            var userId = response.user_id;
                            userDropdownInit(userId);
                            $('#reqAddUser').modal('hide');
                            $('.nav a[href="#pills-profile"]').tab('show');
                            toastr.clear();
                            toastr.success(response.msg);
                            // $('#user-list option[value="'+userId+'"]').attr("selected", "selected");
                            // $('select[name=user]').val(userId).change();
                        }
                    });
                } */
            }
        });
    }
        
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/addresses/index.blade.php ENDPATH**/ ?>