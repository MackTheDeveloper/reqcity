<?php
use App\Models\GlobalSettings;
?>
<?php $__env->startSection('title','My Info'); ?>

<?php $__env->startSection('content'); ?>
<section class="profiles-pages recruiter-profile-pages">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('frontend.recruiter.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="myinfo-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="show-account-info">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Account Info</h6>
                                    <span><?php echo e($data->user->unique_id); ?></span>
                                </div>
                                <div class="boxlayouts-edit">
                                    <a><img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>" id="edit-account" /></a>
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>First name</span>
                                            <p><?php echo e($data->user->firstname); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Last name</span>
                                            <p><?php echo e($data->user->lastname); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Email</span>
                                            <p><?php echo e($data->user->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Phone number</span>
                                            <p><?php echo e($data->phone_ext); ?>-<?php echo e($data->phone); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <?php echo $__env->make('frontend.recruiter.my-info.components.edit-account-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="about-show-form">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>About</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a><img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>" id="about-edit" /></a>
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Website</span>
                                            <p><?php echo e($data->website? :'N/A'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Country</span>
                                            <p><?php echo e($data->Country->name ? :'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Address line 1</span>
                                            <p><?php echo e($data->address_1?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Address line 2</span>
                                            <p><?php echo e($data->address_2?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>City</span>
                                            <p><?php echo e($data->city?:'-'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Zip code</span>
                                            <p><?php echo e($data->postcode?:'-'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <?php echo $__env->make('frontend.recruiter.my-info.components.edit-about-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="bank-show-form">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Banking Info</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                
                                <p>Thank you for signing up for ReqCity.  You will receive an email with instructions for completing HR/Payroll platform on Paycom within the next 48 hours. If you have any questions, please contact us at <a href="mailto:recruiting@reqcity.com">recruiting@reqcity.com</a></p>

                                
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <?php echo $__env->make('frontend.recruiter.my-info.components.edit-bank-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
<script type="text/javascript">
    const uploadFormFile = document.getElementById("upload-form-file");
    const uploadFormImg = document.getElementById("upload-form-img");
    const uploadFormText = document.getElementById("upload-form-text");

    uploadFormImg.addEventListener("click", function() {
        uploadFormFile.click();
    });

    uploadFormFile.addEventListener("change", function() {
        if (uploadFormFile.value) {
            uploadFormText.innerHTML = uploadFormFile.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];
        } else {
            uploadFormText.innerHTML = "No file chosen, yet.";
        }
        var validateIcon = $('#updateMyInfo3').validate().element(':input[name="w9File"]');
        if (!validateIcon)
        return false;
    });

    $('#edit-account').click(function() {
        $('#show-account-info').addClass("d-none");
        $('#account-edit-form').removeClass("d-none");
    });

    $('#about-edit').click(function() {
        $('#about-show-form').addClass("d-none");
        $('#about-edit-form').removeClass("d-none");
    });

    $('#bank-edit').click(function() {
        $('#bank-show-form').addClass("d-none");
        $('#bank-edit-form').removeClass("d-none");
    });


    $("#updateMyInfo1").validate({
        ignore: [],
        rules: {
            "User[firstname]": "required",
            "User[lastname]": "required",
            "User[email]": {
                recruiterUniqueEmail: true,
                required: true,
            },
            "Recruiter[phone]": "required",
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
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#updateMyInfo3").validate({
        ignore: [],
        rules: {
            "RecruiterBank[currency_code]": "required",
            "RecruiterBank[bank_name]": "required",
            "RecruiterBank[swift_code]": "required",
            "RecruiterBank[bank_address]": "required",
            "RecruiterBank[bank_city]": "required",
            "w9File" : {
                extension: "pdf|docx|doc|rtf|txt"
            }
        },
        messages: {
            w9File:"Please upload W9File in .pdf,.docx,.doc,.rtf or .txt format",
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element);
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $.validator.addMethod('recruiterUniqueEmail', function(value, element) {

        var email = $('#email').val();
        var rec_id = $('#rec_id').val();
        //var result = false;
        $.ajax({
            async: false,
            url: "<?php echo e(route('recruiterUniqueEmail')); ?>",
            method: 'post',
            data: {
                email: email,
                rec_id: rec_id,
                _token: "<?php echo e(csrf_token()); ?>",
            },
            dataType: 'json',
            success: function(response) {
                result = (response.data == true) ? true : false;
            }
        });
        return result;
    }, "This email is already exists");
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/my-info/myinfo.blade.php ENDPATH**/ ?>