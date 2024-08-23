<?php $__env->startSection('title', 'Job Details'); ?>

<?php $__env->startSection('content'); ?>
<?php
$showPayment = 1;
$jobId = Session::get('company_job.id');
if ($jobId) {
    $showPayment = getPaymentStatusByJobId($jobId);
}
?>
    <div class="company-job-post-1">
        <div class="container">
            <div class="process-progress width-672">
                <div class="info-progress">
                    <div class="numbers">1</div>
                    <p class="tm">Job Details</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">2</div>
                    <p class="tm">Questionnaire</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">3</div>
                    <p class="tm">Communication</p>
                </div>
                <?php if($showPayment): ?>
                <div class="info-progress">
                    <div class="numbers">4</div>
                    <p class="tm">Review & Payment</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="JDF-wrapper">
                <h5>Job details</h5>
                <form id="companyJobForm" method="POST"
                    action="<?php echo e($model->id ? route('jobDetailsUpdate', $model->id) : route('jobDetailsAdd')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="JDF-box">
                        <div class="basic-info">
                            <p class="tl">Basic info</p>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Job title</span>
                                        <input type="text" name="title" id="title" value="<?php echo e($model->title); ?>" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Job location</span>
                                        <select name="company_address_id" id="company_address_id">
                                            <?php $__currentLoopData = $jobLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>"
                                                    <?php echo e($key == $model->company_address_id ? 'selected' : ''); ?>>
                                                    <?php echo e($value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 showHideAddr <?php echo e($model->company_address_id ? 'd-none' : ''); ?>">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="input-groups">
                                                <span>City</span>
                                                <input type="text" name="address[city]" id="address_city" value="" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="input-groups">
                                                <span>State</span>
                                                <input type="text" name="address[state]" id="address_state" value="" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="input-groups">
                                                <span>Country</span>
                                                <select name="address[country]" id="address_country">
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php echo e($row['key']=='231'?"selected":""); ?> value="<?php echo e($row['key']); ?>"><?php echo e($row['value']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="input-groups">
                                                <span>Zipcode</span>
                                                <input type="text" name="address[postcode]" id="address_postcode"
                                                    value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>What category does this job fall under?</span>
                                        <select name="job_category_id" id="job_category_id">
                                            <option value="">Select</option>
                                            <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>"
                                                    <?php echo e($key == $model->job_category_id ? 'selected' : ''); ?>>
                                                    <?php echo e($value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>What sub-category does this job fall under?</span>
                                        <select name="job_subcategory_id" id="job_subcategory_id">
                                            <option value="">Select</option>
                                            <?php $__currentLoopData = $childCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->id); ?>"
                                                    <?php echo e($value->id == $model->job_subcategory_id ? 'selected' : ''); ?>>
                                                    <?php echo e($value->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>What type of employment is it?</span>
                                        <select name="job_employment_type_id" id="job_employment_type_id">
                                            <option value="">Select</option>
                                            <?php $__currentLoopData = $employmentType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row['key']); ?>"
                                                    <?php echo e($row['key'] == $model->job_employment_type_id ? 'selected' : ''); ?>>
                                                    <?php echo e($row['value']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>What is the schedule for this job?</span>
                                        <div class="multi-select-dropdown">
                                            <label class="multi-dropdown-label"></label>
                                            <div class="multi-dropdown-list">
                                                <?php $__currentLoopData = $jobSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="ck"><?php echo e($row['value']); ?>

                                                        <input name="job_schedule_ids[]" type="checkbox"
                                                            class="ck check" value="<?php echo e($row['key']); ?>"
                                                            <?php echo e(in_array($row['key'], $model->job_schedule_ids) ? 'checked' : ''); ?>>
                                                        <span class="ck-checkmark" values="<?php echo e($row['value']); ?>"></span>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <label id="schedule-error-container" class="error"
                                            for="job_schedule_ids[]"></label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>What contract type is it?</span>
                                        <select name="job_contract_id" id="job_contract_id">
                                            <option value="">Select</option>
                                            <?php $__currentLoopData = $contractType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row['key']); ?>"
                                                    <?php echo e($row['key'] == $model->job_contract_id ? 'selected' : ''); ?>>
                                                    <?php echo e($row['value']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>How long is the contract?</span>
                                        <div class="input-select">
                                            <input type="text" name="contract_duration" id="contract_duration"
                                                value="<?php echo e($model->contract_duration); ?>" />
                                            <select class="width-136" name="contract_duration_type"
                                                id="contract_duration_type">
                                                <option <?php echo e($model->contract_duration_type == '1' ? 'selected' : ''); ?>

                                                    value="1">Month(s)</option>
                                                <option <?php echo e($model->contract_duration_type == '2' ? 'selected' : ''); ?>

                                                    value="2">Year(s)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Relocation available?</span>
                                        <select name="relocation_available" id="relocation_available">
                                            <option <?php echo e($model->relocation_available == 'yes' ? 'selected' : ''); ?>

                                                value="yes">Yes</option>
                                            <option <?php echo e($model->relocation_available == 'no' ? 'selected' : ''); ?>

                                                value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Sponsorship available?</span>
                                        <select name="sponsorship_available" id="sponsorship_available">
                                            <option <?php echo e($model->sponsorship_available == 'yes' ? 'selected' : ''); ?>

                                                value="yes">Yes</option>
                                            <option <?php echo e($model->sponsorship_available == 'no' ? 'selected' : ''); ?>

                                                value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Does this position require travel?</span>
                                        <select name="required_travelling" id="required_travelling">
                                            <option <?php echo e($model->required_travelling == 'yes' ? 'selected' : ''); ?>

                                                value="yes">Yes</option>
                                            <option <?php echo e($model->required_travelling == 'no' ? 'selected' : ''); ?>

                                                value="no">
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Work Location</span>
                                        
                                        <select name="job_remote_work_id" id="job_remote_work_id">
                                            
                                            <?php $__currentLoopData = $remoteWork; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row['key']); ?>"
                                                    <?php echo e($row['key'] == $model->job_remote_work_id ? 'selected' : ''); ?>>
                                                    <?php echo e($row['value']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Open position(s)</span>
                                        <div class="number-counter">
                                            <input type="number"
                                                value="<?php echo e(!empty($model->vaccancy) ? $model->vaccancy : 1); ?>"
                                                name="vaccancy" id="vaccancy" class="vaccancy" />
                                            <button class="minus">
                                                <img src="<?php echo e(asset('public/assets/frontend/img/counter-minus.svg')); ?>" />
                                            </button>
                                            <button class="plus">
                                                <img src="<?php echo e(asset('public/assets/frontend/img/counter-plus.svg')); ?>" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="salary-benefits">
                            <p class="tl">Salary & benefits</p>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Pay</span>
                                        <select name="salary_type" id="salary_type">
                                            <option <?php echo e($model->salary_type == 'hour' ? 'selected' : ''); ?> value="hour">
                                                Hourly</option>
                                            <option <?php echo e($model->salary_type == 'week' ? 'selected' : ''); ?> value="week">
                                                Weekly</option>
                                            <option <?php echo e($model->salary_type == 'month' ? 'selected' : ''); ?> value="month">
                                                Monthly</option>
                                            <option <?php echo e($model->salary_type == 'year' ? 'selected' : ''); ?> value="year">
                                                Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Compensation</span>
                                        <select name="compensation_type" id="compensation_type">
                                            <option <?php echo e($model->compensation_type == 'r' ? 'selected' : ''); ?> value="r">
                                                Range</option>
                                            <option <?php echo e($model->compensation_type == 'f' ? 'selected' : ''); ?> value="f">
                                                Fixed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-4">
                                    <div class="input-groups">
                                        <span>Compensation From ($):</span>
                                        <input type="number" name="from_salary" id="from_salary"
                                            value="<?php echo e($model->from_salary); ?>" />
                                    </div>
                                </div>

                                <div
                                    class="col-6 col-sm-6 col-md-4 compensation-to <?php echo e($model->compensation_type == '' || $model->compensation_type == 'r' ? '' : 'd-none'); ?>">
                                    <div class="input-groups">
                                        <span>Compensation To ($):</span>
                                        <input type="number" name="to_salary" id="to_salary"
                                            value="<?php echo e($model->to_salary); ?>" />
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="input-groups prevent-selection">
                                        <span>Duration</span>
                                        <select name="pay_duration" id="pay_duration">
                                            <option <?php echo e($model->pay_duration == 'per hour' ? 'selected' : ''); ?>

                                                value="per hour">per hour</option>
                                            <option <?php echo e($model->pay_duration == 'per week' ? 'selected' : ''); ?>

                                                value="per week">per week</option>
                                            <option <?php echo e($model->pay_duration == 'per month' ? 'selected' : ''); ?>

                                                value="per month">per month</option>
                                            <option <?php echo e($model->pay_duration == 'per year' ? 'selected' : ''); ?>

                                                value="per year">per year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 comp-checkbox">
                                    <label class="ck">Hide compensation details to candidates
                                        <input type="checkbox" name="hide_compensation_details_to_candidates"
                                            <?php echo e($model->hide_compensation_details_to_candidates == 'yes' ? 'checked' : ''); ?>>
                                        <span class="ck-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Are there any forms of supplemental pay offered?</span>

                                        <div class="multi-select-dropdown">
                                            <label class="multi-dropdown-label"></label>
                                            <div class="multi-dropdown-list">
                                                <?php $__currentLoopData = $payOffered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="ck"><?php echo e($row['value']); ?>

                                                        <input name="supplemental_pay_offered_ids[]" type="checkbox"
                                                            class="ck check" value="<?php echo e($row['key']); ?>"
                                                            <?php echo e(in_array($row['key'], $model->supplemental_pay_offered_ids) ? 'checked' : ''); ?>>
                                                        <span class="ck-checkmark" values="<?php echo e($row['value']); ?>"></span>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>

                                        <!--  <select name="supplemental_pay_offered_ids[]" id="supplemental_pay_offered_ids" multiple>
                                                <?php $__currentLoopData = $payOffered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($row['key']); ?>" <?php echo e(in_array($row['key'], $model->supplemental_pay_offered_ids) ? 'selected' : ''); ?>>
                                                    <?php echo e($row['value']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select> -->
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Are any of the following benefits offered?</span>

                                        <div class="multi-select-dropdown">
                                            <label class="multi-dropdown-label"></label>
                                            <div class="multi-dropdown-list">
                                                <?php $__currentLoopData = $benifitsOffered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="ck"><?php echo e($row['value']); ?>

                                                        <input name="benefits_offered_ids[]" type="checkbox"
                                                            class="ck check" value="<?php echo e($row['key']); ?>"
                                                            <?php echo e(in_array($row['key'], $model->benefits_offered_ids) ? 'checked' : ''); ?>>
                                                        <span class="ck-checkmark"
                                                            values="<?php echo e($row['value']); ?>"></span>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>

                                        <!-- <select name="benefits_offered_ids[]" id="benefits_offered_ids" multiple>
                                                <?php $__currentLoopData = $benifitsOffered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($row['key']); ?>" <?php echo e(in_array($row['key'], $model->benefits_offered_ids) ? 'selected' : ''); ?>>
                                                    <?php echo e($row['value']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select> -->
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="input-groups">
                                        <span>Additional benefits to employee</span>
                                        <input type="text" name="additional_benefits" id="additional_benefits"
                                            value="<?php echo e($model->additional_benefits); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="job-description">
                            <p class="tl">Job description</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-groups">
                                        <span>Describe what you are looking for</span>
                                        <input type="text" name="job_short_description" id="job_short_description"
                                            value="<?php echo e($model->job_short_description); ?>" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-groups custome-ck-editor">
                                        <span>Describe the roles and responsibilities of this job</span>
                                        <textarea class="" id="editor1" name="job_description"><?php echo e($model->job_description); ?></textarea>
                                        <div class="max-note">
                                            <span class="bs blur-color">Must be at least 250 characters.</span>
                                            <span class="bs blur-color"><span id="charCount">0</span>/1000</span>
                                        </div>
                                        <label id="editor1-error" class="error" for="editor1"></label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-groups">
                                        <span>Are you taking any additional COVID-19 precautions?</span>
                                        <textarea name="covid_precautions"><?php echo e($model->covid_precautions); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-footer text-right">
                            <button type="submit" name="submit_type" value="1" class="border-btn">Save as a
                                Draft</button>
                            <button type="submit" name="submit_type" value="2" class="fill-btn">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".ckeditor").each(function(_, ckeditor) {
                CKEDITOR.replace(ckeditor);
            });

            var editor = CKEDITOR.replace('editor1', {
                allowedContent: true,
            });

            $("#charCount").html(CKEDITOR.instances.editor1.getData().length);
            let charCount = document.getElementById('charCount');
            CKEDITOR.instances.editor1.on('key', function() {
                //charCount.innerHTML = CKEDITOR.instances.editor1.getData().replace(/<[^>]*>|\s/g, '').length + 1;
                checkCounts(1);
                //var le = editor.getData().length + 1;
                //charCount.innerHTML = le;
                setTimeout(function() {
                    checkCounts();
                }, 100);
            });
            CKEDITOR.instances.editor1.on("afterPaste", function() {
                checkCounts();
            });
            CKEDITOR.instances.editor1.on("blur", function() {
                checkCounts();
            });

            function checkCounts(plus = 0) {
                charCount.innerHTML = CKEDITOR.instances.editor1.getData().replace(/<("[^"]*"|'[^']*'|[^'">])*>/gi,
                    '').replace(/^\s+|\s+$/g, '').replace(new RegExp('&nbsp;', 'g'), ' ').length + plus;
            }

            $(document).on('change', '#salary_type', function() {
                var value = $(this).val();
                // alert('per ' + value)
                $('#pay_duration').val('per ' + value);
            });

            $(document).on('change', '#compensation_type', function() {
                var value = $(this).val();
                if (value == 'r') {
                    $('.compensation-to').removeClass('d-none');
                } else {
                    $('.compensation-to').addClass('d-none');
                }
            });


            $('#job_category_id').change(function() {
                var categoryId = $(this).val();
                $.ajax({
                    url: "<?php echo e(url('company-job/get-subcat')); ?>",
                    type: 'post',
                    dataType: "json",
                    //data: 'id=' + id + '&_token=<?php echo e(csrf_token()); ?>',
                    data: {
                        categoryId: categoryId,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(result) {
                        $('#job_subcategory_id').html('<option value="">Select</option>');
                        $.each(result.subCategories, function(key, value) {
                            $("#job_subcategory_id").append('<option value="' + value
                                .id + '">' + value.title + '</option>');
                        });
                        // $('#job_subcategory_id').html(html);
                    }
                });
            })
        });

        $("#companyJobForm").validate({
            ignore: [],
            rules: {
                "title": "required",
                "company_address_id": "required",
                "job_category_id": "required",
                "job_industry_id": "required",
                "job_employment_type_id": "required",
                "job_schedule_ids[]": "required",
                // address_country: "required",
                "address[country]": {
                    required: function(element) {
                        return $('#company_address_id').val() == '0';
                    }
                },
                // address_state: "required",
                "address[state]": {
                    required: function(element) {
                        return $('#company_address_id').val() == '0';
                    }
                },
                // address_city: "required",
                "address[city]": {
                    required: function(element) {
                        return $('#company_address_id').val() == '0'; 
                    }
                },
                // address_postcode: "required",
                "address[postcode]": {
                    required: function(element) {
                        return $('#company_address_id').val() == '0'; 
                    }
                },
                // job_contract_id: "required",
                "vaccancy": "required",
                "job_short_description": {
                    required: true,
                    maxlength: 250
                },
                "job_description": {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                        //var editorcontent = textarea.value.replace(/<[^>]*>|\s/g, ''); // strip tags
                        var editorcontent = textarea.value.replace(/<("[^"]*"|'[^']*'|[^'">])*>/gi, '').replace(
                            /^\s+|\s+$/g, '').replace(new RegExp('&nbsp;', 'g'), ' '); // strip tags
                        return editorcontent.length === 0;
                    },
                    minlength: 250
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("vaccancy")) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        jQuery.validator.addMethod("minlength", function(value, element, param) {
            var editorcontent = value.replace(/<("[^"]*"|'[^']*'|[^'">])*>/gi, '').replace(/^\s+|\s+$/g, '')
                .replace(new RegExp('&nbsp;', 'g'), ' '); // strip tags
            return editorcontent.length >= param;
        }, $.validator.format("Please enter min {0} characters."));

        $(document).on('change',"#company_address_id",function () {
            var value = $(this).val();
            if (value!="0") {
                $('.showHideAddr').addClass('d-none');
            } else {
                $('.showHideAddr').removeClass('d-none');
            }
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/job/form_job_details.blade.php ENDPATH**/ ?>