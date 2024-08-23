<?php $__env->startSection('title','Candidate Signup 2'); ?>

<?php $__env->startSection('content'); ?>
<div class="recruiter-signup-2 candidate-signup-2">
    <div class="container">
        <div class="started-form-wrapper">
            <h5>Let's get started</h5>
            <div class="started-form">
                <div class="account-info">
                    <p class="tl">Account info</p>
                    <form id="candidateSignupFormTwo" method="POST" action="<?php echo e(url('/candidate-signup-2')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="rec_id" name="candidate_id" value="<?php echo e($candidateId); ?>">
                        <input type="hidden" id="rec_email" name="candidate_email" value="<?php echo e($email); ?>">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="number-groups">
                                    <span>Phone Number</span>
                                    <div class="number-fields">
                                        <input type="text" id="phoneField1" name="phoneField1" class="phone-field" value="<?php echo e(($candidate) ? $candidate->phone_ext:''); ?>" />
                                        <input type="number" class="mobile-number" name="phone" value="<?php echo e(($candidate) ? $candidate->phone:''); ?>">
                                    </div>
                                    <label id="phone-error" class="error" for="phone"></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Country</span>
                                    <select name="country" id="country">
                                        <?php if($candidate): ?>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row['key']); ?>" <?php echo e($row['key'] == $candidate->country ? "selected" : ""); ?>><?php echo e($row['value']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row['key']); ?>" <?php echo e($row['value'] == "United States" ? "selected" : ""); ?>><?php echo e($row['value']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Address line 1</span>
                                    <input type="text" name="address_1" value="<?php echo e(($candidate) ? $candidate->address_1:''); ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Address line 2</span>
                                    <input type="text" name="address_2" value="<?php echo e(($candidate) ? $candidate->address_2:''); ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>City</span>
                                    <input type="text" name="city" value="<?php echo e(($candidate) ? $candidate->city:''); ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Zip code</span>
                                    <input type="text" name="postcode" value="<?php echo e(($candidate) ? $candidate->postcode:''); ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Job title</span>
                                    <input type="text" name="job_title" value="<?php echo e(($candidate) ? $candidate->job_title:''); ?>" />
                                </div>
                            </div>
                        </div>
                </div>
                <div class="upload-resume-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="upload-resume">
                                <p class="tm">Upload resume</p>
                                <div class="upload-form-btn2">
                                    <img src="<?php echo e(asset('public/assets/frontend/img/upload-icon.svg')); ?>" id="upload-form-img" alt="" />
                                    <div>
                                        <p class="tm" id="upload-form-text">Upload resume</p>
                                        <span class="bs blur-color">Use a pdf, docx, doc, rtf and txt</span>
                                    
                                    <input type="file" id="upload-form-file" name="resume" accept="application/pdf, .docx, .doc, .rtf, text/plain" hidden="hidden" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 linkdin-sec">
                            <p class="tm">LinkedIn</p>
                            <div class="input-groups">
                                <span>LinkedIn profile link</span>
                                <input type="url" pattern="https://.*" name="linkedin_profile_link" value="<?php echo e(($candidate) ? $candidate->linkedin_profile_link:''); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="general-btn-togethers">
                            <a href="<?php echo e(route('showCandidateSignup')); ?>" style="text-decoration: none; color:white;"><button class="fill-btn" style="background-color: #919299;" id="create">Back</button></a>
                            <button type="submit" class="fill-btn g-recaptcha" data-sitekey="<?php echo e(Config::get('app.googleReCaptchaKeys')['siteKey']); ?>" data-callback='submitForm' id="create">Submit</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
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
        var validateIcon = $('#candidateSignupFormTwo').validate().element(':input[name="resume"]');
        if (!validateIcon)
            return false;            
    });

    $("#candidateSignupFormTwo").validate({
        ignore: [],
        rules: {
            // phoneField1: "required",
            phone: "required",
            country: "required",
            resume : {
                extension: "pdf|docx|doc|rtf|txt"
            }
        },
        messages: {
            resume:"Please upload resume in .pdf,.docx,.doc,.rtf or .txt format",
        },
        errorPlacement: function(error, element) {
            /* if (element.attr("name") == "phone") {
                error.appendTo("#phone-err");
            }            
            else {
            }   */
                error.insertAfter(element);
                      
        },
        /* errorElement: 'div',
        errorLabelContainer: '.errorTxt', */
        submitHandler: function(form) {
            if (grecaptcha.getResponse()) {
                // 2) finally sending form data
                form.submit();
            } else {
                // 1) Before sending we must validate captcha
                grecaptcha.reset();
                grecaptcha.execute();
            }
        }
    });

    function submitForm() {
        $("#candidateSignupFormTwo").submit();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/auth/candidate/signupTwo.blade.php ENDPATH**/ ?>