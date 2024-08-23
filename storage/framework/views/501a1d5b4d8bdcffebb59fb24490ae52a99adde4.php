<?php $__env->startSection('title','My Info'); ?>

<?php $__env->startSection('content'); ?>
<section class="profiles-pages candidates-profile-pages">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('frontend.candidate.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="myinfo-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="show-account-info">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Account Info</h6>
                                    <span><?php echo e($candidate->user->unique_id?:'-'); ?></span>
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
                                            <p><?php echo e($candidate->user->firstname?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Last name</span>
                                            <p><?php echo e($candidate->user->lastname?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Email</span>
                                            <p><?php echo e($candidate->user->email?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Phone number</span>
                                            <p><?php echo e($candidate->phone_ext?:'-'); ?>-<?php echo e($candidate->phone?:'-'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <?php echo $__env->make('frontend.candidate.my-info.components.edit-account-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                    <div class="col-md-12">
                                        <div class="myinfo-candidate-profile">
                                            <img src="<?php echo e($image); ?>" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Job title</span>
                                            <p><?php echo e($candidate->job_title?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Country</span>
                                            <p><?php echo e($candidate->Country->name ? :'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Address line 1</span>
                                            <p><?php echo e($candidate->address_1?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Address line 2</span>
                                            <p><?php echo e($candidate->address_2?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>City</span>
                                            <p><?php echo e($candidate->city?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Zip code</span>
                                            <p><?php echo e($candidate->postcode?:'-'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Resume</span>
                                            <div class="static-resumeinfo">
                                                <?php if($resumeLink): ?>
                                                <a href="<?php echo e($resumeLink); ?>" download><img src="<?php echo e(asset('public/assets/frontend/img/pdf-orange.svg')); ?>" /></a>
                                                <p>Download Resume</p>
                                                <?php else: ?>
                                                <p>-</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>LinkedIn</span>
                                            <p><?php echo e($candidate->linkedin_profile_link?:'-'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        <?php echo $__env->make('frontend.candidate.my-info.components.edit-about-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-structure close-job-popup" id="modal-crop-image">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Crop</h6>
                    <button type="button" class="close cancelCrop" data-bs-dismiss="modal">
                        <img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" />
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="img-container">
                        <div class="crop-img-wrapper">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            <div class="preview d-none"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="border-btn cancelCrop" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="fill-btn" data-dismiss="modal" id="crop">Crop</button>
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
        var validateIcon = $('#updateMyInfo2').validate().element(':input[name="resume"]');
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

    $("#updateMyInfo1").validate({
        ignore: [],
        rules: {
            "User[firstname]": "required",
            "User[lastname]": "required",
            "User[email]": {
                candidateUniqueEmail: true,
                required: true,
            },
            "phone": "required",
            "myFile" : {
                extension: "png|jpg"
            },
            "resume" : {
                extension: "pdf|docx"
            }
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
    $.validator.addMethod('candidateUniqueEmail', function(value, element) {

        var email = $('#email').val();
        var can_id = $('#candidate_id').val();
        //var result = false;
        $.ajax({
            async: false,
            url: "<?php echo e(route('candidateUniqueEmail')); ?>",
            method: 'post',
            data: {
                email: email,
                can_id: can_id,
                _token: "<?php echo e(csrf_token()); ?>",
            },
            dataType: 'json',
            success: function(response) {
                result = (response.data == true) ? true : false;
            }
        });
        return result;
    }, "This email is already exists");

    $("#updateMyInfo2").validate({
        ignore: [],
        rules: {
            "myFile" : {
                extension: "png|jpg"
            },
            "resume" : {
                extension: "pdf|docx|doc|rtf|txt"
            }
        },
        messages: {
            myFile:"Please upload image in .png or .jpg format",
            resume:"Please upload resume in .pdf,.docx,.doc,.rtf or .txt format",
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
    // $("#updateMyInfo3").validate({
    //     ignore: [],
    //     rules: {
    //         "RecruiterBank[currency_code]": "required",
    //         "RecruiterBank[bank_name]": "required",
    //         "RecruiterBank[swift_code]": "required",
    //         "RecruiterBank[bank_address]": "required",
    //         "RecruiterBank[bank_city]": "required",
    //     },
    //     messages: {

    //     },
    //     errorPlacement: function(error, element) {
    //         if (element.hasClass("mobile-number")) {
    //             error.insertAfter(element.parent().append());
    //         } else {
    //             error.insertAfter(element);
    //         }

    //     },
    //     submitHandler: function(form) {
    //         form.submit();
    //     }
    // });

    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        dropZoneElement.addEventListener("drop", (e) => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                // updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                $('.image').trigger('change');
            }

            dropZoneElement.classList.remove("drop-zone--over");
        });
    });


    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // First time - remove the prompt
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").hide();
        }

        // First time - there is no thumbnail element, so lets create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            // dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Show thumbnail for image files
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }

    var $modal = $('#modal-crop-image');
    var image = document.getElementById('image');
    var cropper;

    $("body").on("click", ".image", function(e) {
        $('input[type="file"]').val('');
    });

    $("body").on("change", ".image", function(e) {
        var validateIcon = $('#updateMyInfo2').validate().element(':input[name="myFile"]');
        if (!validateIcon)
            return false;
        var ext = $(this).val().substring($(this).val().lastIndexOf('.') + 1).toLowerCase();
        /*  if (ext != 'png' && ext != 'jpg' && ext != 'jpeg') {
             $(this).val('');
             alert('Please select valid file (png,jpg,jpeg)');
             return false;
         } */

        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            //autoCropArea: 0,
            responsive: true,
            dragMode: 'none',
            strict: true,
            guides: false,
            rounded: true,
            highlight: true,
            viewMode: 3,
            preview: '.preview',
            movable: false,
            resizable: false,
            cropBoxResizable: true,
            data: {
                width: 250,
                height: 250,
            },
            dragCrop: false,
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            /* width: 1000,
            height: 1000, */
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                //$('.drop-zone__thumb').css('display', 'block');
                //$('.drop-zone__thumb').css('background-image', 'url(' + base64data + ')');
                $('.open-icon-select').attr('src', base64data).removeClass('d-none');
                $('.drop-zone__prompt').addClass('d-none');
                $('.hiddenPreviewImg').val(base64data);
                //console.log(base64data);
                $modal.modal('hide');
            }
        });
    })

    $(".cancelCrop").on("click", function() {
        $('input[type="file"]').val('');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/my-info/myinfo.blade.php ENDPATH**/ ?>