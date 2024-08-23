<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reqcity | Recruiter Submit Candidate 1</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.ccpicker.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/responsive2.css">
</head>

<body>
    <header class="top-shadow" include-html="header.html"></header>
    <div class="req-submit-candidate">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 col-md-12">
                    <div class="process-progress">
                        <div class="info-progress ">
                            <div class="numbers">1</div>
                            <p class="tm">Candidate Details</p>
                        </div>
                        <div class="info-progress ">
                            <div class="numbers">2</div>
                            <p class="tm">Questionnaire</p>
                        </div>
                        <div class="info-progress ">
                            <div class="numbers">3</div>
                            <p class="tm">Review Submittal</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margins-62 flex-reverse-mobo">
                <div class="col-md-8">
                    <div class="candidate-submital-main">
                        <h5>Candidate Submittal</h5>
                        <div class="candidate-submital-in">
                            <p class="tl">Candidate info</p>

                            <!-- Developer Note :- below First DIV contain unique class for all 4 submital candidate pages -->
                            <div class="submittal-candidate-form">
                                <form class="">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>First name</span>
                                                <input type="text" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Last name</span>
                                                <input type="text" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                            <div class="number-groups">
                                                <span>Phone Number</span>
                                                <div class="number-fields">
                                                    <input type="text" id="phoneField1" name="phoneField1"
                                                        class="phone-field" />
                                                    <input type="number" class="mobile-number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Email</span>
                                                <input type="email" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Country</span>
                                                <select>
                                                    <option>United States</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>City</span>
                                                <input type="text" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="candidate-submittal-resume">
                                                <span class="tm">Upload resume for Nutrify, Inc.</span>
                                                <div class="upload-form-btn2">
                                                    <input type="file" id="upload-form-file" hidden="hidden" />
                                                    <img src="assets/img/upload-icon.svg" id="upload-form-img" alt="" />
                                                    <div>
                                                        <p class="tm" id="upload-form-text">Upload resume</p>
                                                        <span class="bs blur-color">Use a pdf, docx, doc, rtf and
                                                            txt</span>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="yr-exp-candidate-submt">
                                                <span class="tm">Your experience</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Job Title</span>
                                                <input type="text" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="input-groups">
                                                <span>Company</span>
                                                <input type="text" />
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="input-groups">
                                                <span>Start year</span>
                                                <select>
                                                    <option>Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="input-groups">
                                                <span>Start month</span>
                                                <select>
                                                    <option>Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="input-groups">
                                                <span>End year</span>
                                                <select>
                                                    <option>Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="input-groups">
                                                <span>End month</span>
                                                <select>
                                                    <option>Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="input-groups">
                                                <span>Job Responsibilities</span>
                                                <textarea></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <label class="ck">I am currently working in this role
                                                <input type="checkbox" />
                                                <span class="ck-checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="addbranch-candi-submit">
                                                <button class="blue-btn"><img src="assets/img/blue-plus.svg"
                                                        alt="" />Add experience</button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="reqsubmit-candidate-btns">
                                                <a href="" class="border-btn">Back</a>
                                                <a href="" class="fill-btn" disabled>Continue</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="candidate-submittal-sidebar">
                        <div class="job-posdetails-first">
                            <p class="tm">Javascript Developer</p>
                            <span class="grey-span-sidebar">Nutrify, Inc.</span>
                            <span class="grey-span-sidebar">San Francisco, CA</span>
                            <div class="jobpost-budgeted-salary">
                                <p class="ll">$62,339 - $81,338 a year</p>
                                <span>3 days ago</span>
                            </div>
                        </div>
                        <div class="job-postdesc-sec">
                            <p class="job-postdesc-p">We are looking for a Developers with experience using native
                                JavaScript, HTML5, and CSS
                                to join its development team. The ideal candidate will have a desire to work for a
                                global company working on cutting-edge techniques for an online shopping application
                                that is growing rapidly. We are looking for energetic people and willing to provide a
                                relocation opportunity and permanent role for those that set themselves apart and
                                establish themselves as rising stars.</p>
                            <div class="what-welook-side">
                                <p class="tm">What We Are Looking For:</p>
                                <ul>
                                    <li>At least 1 year experience in working as a Javascript developer.</li>
                                    <li>Knowledge of client-side technologies (HTML/CSS/Javascript)</li>
                                    <li>Experience in working with jQuery library</li>
                                    <li>Basic understanding of Git version control</li>
                                    <li>Basic understanding of the usage of REST APIs</li>
                                    <li>Fast learner (and willing to learn a lot)</li>
                                    <li>You love web development</li>
                                    <li>Programming experience (any language)</li>
                                    <li>You are proactive team player with good</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">

    </div>
    <div class="col-md-4">

    </div>
    <div class="copy-right" include-html="copy-right.html"></div>
</body>
<script src="assets/js/jquery-3.5.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap-4.5.min.js"></script>
<script src="assets/js/bootstrap-5.1.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src='assets/js/jquery-ui-1.12-1.min.js'></script>
<script src="assets/js/jquery.ccpicker.js" type="text/javascript"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/script2.js"></script>
<script>

    $("#phoneField1").CcPicker();



    const uploadFormFile = document.getElementById("upload-form-file");
    const uploadFormImg = document.getElementById("upload-form-img");
    const uploadFormText = document.getElementById("upload-form-text");

    uploadFormImg.addEventListener("click", function () {
        uploadFormFile.click();
    });

    uploadFormFile.addEventListener("change", function () {
        if (uploadFormFile.value) {
            uploadFormText.innerHTML = uploadFormFile.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];
        } else {
            uploadFormText.innerHTML = "No file chosen, yet.";
        }
    });

</script>

</html>