<?php $__env->startSection('title','User Management'); ?>

<?php $__env->startSection('content'); ?>
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('frontend.company.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="user-management-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>User Management</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <?php if(whoCanCheckFront('company_user_management_post')): ?>
                                    <div class="trans-date-update">
                                        <a href="javascript:void(0)" class="fill-btn" id="addUser">Add User</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class=" ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="user-management-tabs">
                                            <ul class="nav " id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="tab-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">List</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="tab-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Permissions</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content usermanagement-tabcontent" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                    <!-- Section -->
                                                    <div class="div-table-wrapper">
                                                        <div class="div-table" id="magTable">
                                                            <div class="div-row">
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Name</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Email</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Phone Number</p>
                                                                </div>
                                                                <div class="div-column">
                                                                    <p class="ll blur-color">Designation</p>
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
                                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                    <!-- User Permission Section -->
                                                    <?php echo $__env->make('frontend.company.components.user-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<!-- ADD USER Modal -->
<!-- Edit USER Modal -->
<?php echo $__env->make('frontend.company.components.modals.company-user-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- confirm Modal -->
<?php echo $__env->make('frontend.components.delete-confirm',['title'=>'Remove User','message'=>'Are you sure you want to remove the user?'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
<script src="<?php echo e(asset('/public/assets/frontend/js/magTable.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('.nav a[href="#pills-profile"]').tab('show');
        // $('select[name=user]').val(1).change();
        // $("#pills-tab").tabs({ active: #pills-profile });
        companyUserlList();
        userDropdownInit();
    });


    function companyUserlList(startDate = '', endDate = '') {
        $('#magTable').magTable({
            ajax: {
                "url": "<?php echo e(route('companyUserList')); ?>",
                "type": "GET",
                "data": {
                    "startDate": startDate,
                    "endDate": endDate
                }
            },
            columns: [{
                    data: 'name',
                    name: 'name',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'phone',
                    name: 'phone',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'designation',
                    name: 'designation',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                }
                // {
                //     data: 'action',
                //     name: 'action',
                //     render: function(data) {
                //         return '<div class="action-block">' + data + '</div>';
                //     },
                // }
            ]
        })
    }

    $(document).on('click', '#addUser', function() {
        $.ajax({
            url: "<?php echo e(route('companyUserCreate')); ?>",
            type: "GET",
            dataType: "html",
            success: function(response) {
                $('#reqAddUser .modal-content').html(response);
                $('#reqAddUser').modal('show');
                initModal();
            }
        });
    });

    //for edit model
    $(document).on('click', '#edit-btn', function() {
        var id = $(this).data().id;
        $.ajax({
            url: "<?php echo e(route('companyUserEdit')); ?>",
            data: {
                "id": id
            },
            type: "GET",
            dataType: "html",
            success: function(response) {
                $('#reqAddUser .modal-content').html(response);
                $('#reqAddUser').modal('show');
                initModal();
            }
        });
    });

    function initModal() {
        $("#phoneField1").CcPicker();
        validateUserForm();
        setCountryFlagCcPicker();
    }

    function validateUserForm() {
        $("#userCreate").validate({
            ignore: [],
            rules: {
                name: "required",
                phone: "required",
                email: {
                    companyUniqueEmail: true,
                    required: true,
                    email: true,
                    regex: /\S+@\S+\.\S+/,
                },
                password: {
                    required: function(ele) {
                        return $('#user-id').val() == ""
                    },
                    minlength: 8,
                },
                "conform-password": {
                    required: function(ele) {
                        return $('#user-id').val() == ""
                    },
                    minlength: 8,
                    equalTo: "#password"
                },
                designation: "required",
            },
            messages: {

            },
            errorPlacement: function(error, element) {
                if (element.hasClass("mobile-number")) {
                    error.insertAfter(element.parent().append());
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form, ev) {
                $('.loader-bg').removeClass('d-none');
                var buttonId = $('#userCreate').find('.formSubmitBtn').attr('id');
                if (buttonId == 'updateButton') {
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
                }
            }
        });
    }

    $.validator.addMethod('companyUniqueEmail', function(value, element) {

        var email = $('#email').val();
        var user_id = $('#user-id').val();
        //var result = false;
        $.ajax({
            async: false,
            url: "<?php echo e(route('companyUserUniqueEmail')); ?>",
            method: 'post',
            data: {
                email: email,
                user_id: user_id,
                _token: "<?php echo e(csrf_token()); ?>",
            },
            dataType: 'json',
            success: function(response) {
                result = (response.data == true) ? true : false;
            }
        });
        return result;
    }, "This email is already exists");

    $(document).on('change', '#user-list', function() {
        var id = $(this).val();
        $.ajax({
            url: "<?php echo e(route('companyUserPermission')); ?>",
            type: "GET",
            data: {
                'id': id
            },
            dataType: "html",
            success: function(response) {
                $('.user-permisions-detailed').html(response);
                // $('#reqAddUser').modal('show');
                initModal();
            }
        });
    });

    $(document).on('change', '.permission', function() {
        toastr.clear();
        toastr.success('Permission Updated Sucessfully');
        var permissionId = $(this).attr('data-permId');
        var userId = $('#user_id').val();
        $.ajax({
            url: "<?php echo e(route('companyUserChangePermission')); ?>",
            type: "GET",
            data: {
                'userId': userId,
                'permissionId': permissionId
            },
            dataType: "json",
            success: function(response) {}
        });
    });

    function userDropdownInit(id = "") {
        $.ajax({
            url: "<?php echo e(route('companyUserDropdown')); ?>",
            type: "GET",
            dataType: "html",
            success: function(response) {
                $('#pills-profile').html(response);
                if (id != "") {
                    $('select[name=user]').val(id).change();
                }
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/company-user/index.blade.php ENDPATH**/ ?>