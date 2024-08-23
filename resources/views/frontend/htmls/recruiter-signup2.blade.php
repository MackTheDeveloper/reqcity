<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Reqcity | Recruiter Sign Up 2</title>
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
  <header include-html="header.html"></header>
  <div class="recruiter-signup-2">
    <div class="container">
      <div class="process-progress">
        <div class="info-progress done">
          <div class="numbers">1</div>
          <p class="tm">Sign Up</p>
        </div>
        <div class="info-progress">
          <div class="numbers">2</div>
          <p class="tm">Information</p>
        </div>
        <div class="info-progress">
          <div class="numbers">3</div>
          <p class="tm">Pricing</p>
        </div>
        <div class="info-progress">
          <div class="numbers">4</div>
          <p class="tm">Payment</p>
        </div>
      </div>
      <div class="started-form-wrapper">
        <h5>Let's get started</h5>
        <div class="started-form">
          <div class="account-info">
            <p class="tl">Account info</p>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="number-groups">
                  <span>Phone Number</span>
                  <div class="number-fields">
                    <input type="text" id="phoneField1" name="phoneField1" class="phone-field" />
                    <input type="number" class="mobile-number">
                  </div>
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
                  <span>Address line 1</span>
                  <input type="text" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Address line 2</span>
                  <input type="text" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>City</span>
                  <input type="text" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Zip code</span>
                  <input type="text" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>Areas of expertise</span>
                  <select>
                    <option>Human Resources, HR Consulting</option>
                  </select>
                </div>
              </div>    
            </div>
          </div>
          <div class="w-9">
            <p class="tl">W-9</p>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                  <span>W-9 on file?</span>
                  <select>
                    <option>Yes</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-sm-12 col-md-12">
                <p class="bs">Please note you will not get paid unless we have a W-9 form from you.</p>
              </div>
              <div class="col-12 col-sm-12 col-md-12">
                <div class="upload-form-btn">
                  <input type="file" id="upload-form-file" hidden="hidden" />
                  <img src="assets/img/upload-icon.svg" id="upload-form-img" alt="" />
                  <p class="tm" id="upload-form-text">Upload form W-9</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-right">
              <a href="" class="fill-btn" disabled>Continue</a>
            </div>
          </div>

        </div>
      </div>
    </div>
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
<script>

  $("#phoneField1").CcPicker();



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
  });

</script>

</html>