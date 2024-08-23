<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Reqcity | Sign Up 2</title>
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
	<div class="company-signup-2">
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
          <p class="tl">Account info</p>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>Your name</span>
                <input type="text" />
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
                <span>Company name</span>
                <input type="text" />
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="number-groups">
                <span>Phone Number</span>
                <div class="number-fields">
                  <input type="text" id="phoneField1" name="phoneField1" class="phone-field"/>
                  <input type="number" class="mobile-number">
                </div>
              </div>
            </div>
          </div>

          <div class="company-info-sec">
            <p class="tl">Company info</p>
            <div class="drop-wrappers">
              <div class="drop-zone">
                <span class="drop-zone__prompt">Attach or <br> drop logo <br> here</span>
                <input type="file" name="myFile" class="drop-zone__input">
              </div>
              <div class="drop-content">
                <p class="bl">Set the company profile image.</p>
                <span class="bl blur-color">250x250 Min size/ 5 MB Max</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>Website</span>
                <input type="text" />
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>Company size</span>
                <select>
                  <option>1 - 49</option>
                </select>
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
                <span>Zip code</span>
                <input type="text" />
              </div>
            </div>
          </div>

          <div class="notes-and-btn">
            <p class="bs">*Note: You can also add branch from your profile later.</p>
            <button class="blue-btn"><img src="assets/img/blue-plus.svg" alt="" />Add branch</button>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="input-groups mb-28">
                <span>About company</span>
                <textarea></textarea>
                <div class="max-note">
                  <span class="bs">Must be at least 250 characters.</span>
                  <span class="bs">0/1000</span>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="input-groups mb-24">
                <span>Why work here?</span>
                <textarea></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 text-right">
              <a href="" class="fill-btn" disabled>Continue</a>
            </div>
          </div>

        </div>

        {# <p class="bs note">Dev note: Logo | Why work here are optional fields.</p> #}

      </div>
    </div>
  </div>
	<footer include-html="footer.html"></footer>
	<div class="copy-right" include-html="copy-right.html"></div>
</body>
	<script src="assets/js/jquery-3.5.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap-4.5.min.js"></script>
	<script src="assets/js/bootstrap-5.1.bundle.min.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/owl.carousel.js"></script>
	<script src='assets/js/jquery-ui-1.12-1.min.js'></script>
  <script src="assets/js/jquery.ccpicker.js"></script>
	<script src="assets/js/script.js"></script>
  <script>
    $("#phoneField1").CcPicker();


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
      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
    }

    dropZoneElement.classList.remove("drop-zone--over");
  });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
  let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

  // First time - remove the prompt
  if (dropZoneElement.querySelector(".drop-zone__prompt")) {
    dropZoneElement.querySelector(".drop-zone__prompt").remove();
  }

  // First time - there is no thumbnail element, so lets create it
  if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    dropZoneElement.appendChild(thumbnailElement);
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
  </script>

</html>