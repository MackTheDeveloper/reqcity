<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Reqcity | Recruiter Candidates</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/css/bootstrap4.min.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css'>
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
	<div class="recruiter-candidates">
    <div class="container">
      <div class="rc-header">
        <h5>Candidates</h5>
        <button class="fill-btn" data-toggle="modal"
        data-target="#reqAddCandidate">Add Candidate</button>
      </div>
      <div class="rc-data-wrapper">
        <div class="job-header">
          <div class="searchbar-btn">
            <input type="text" class="input" placeholder="Search for job" />
            <button class="search-btn"><img src="assets/img/white-search.svg" alt="" /></button>
          </div>
          <button class="border-btn filter-btn web-filter">
            <img src="assets/img/bell.svg" alt="" />Filter
          </button>
          <button class="border-btn filter-btn mobile-filter">
            <img src="assets/img/bell.svg" alt="" />Filter
          </button>
          <div class="sort-by-sec">
            <p class="bm">Sort by</p>
            <select class="select">
              <option>Recently Posted</option>
            </select>
          </div>
        </div>
        <div class="filter-section-wrapper">
          <div class="filter-section">
            <div class="filter-sec-header">
              <div class="filter-name-close">
                <p class="tl">Filter</p>
                <img src="assets/img/x.svg" class="close-filter" alt="" />
              </div>
              <div class="clear-apply">
                  <button class="border-btn">Clear All</button>
                  <button class="fill-btn">Apply</button>
              </div>
            </div>
            <div class="filter-data-wrapper">
              <div class="row">
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="filter-column">
                    <p class="tm">Category</p>
                    <div class="ck-collapse-wrapper">
                      <div class="ck-collapse">
                        <label class="ck">All
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Technology
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Research
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Engineering
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">System Admin
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">System Admin
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="filter-column">
                    <p class="tm">Sub-Category</p>
                    <div class="ck-collapse-wrapper">
                      <div class="ck-collapse">
                        <label class="ck">All
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Web Developer
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Android Developer
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">iOS Developer
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Back End Developer
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                      </div>
                    </div> 
                  </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="filter-column">
                    <p class="tm">Status</p>
                    <div class="ck-collapse-wrapper">
                      <div class="ck-collapse">
                        <label class="ck">All
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Open
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Paused
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Closed
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Draft
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="filter-column">
                    <p class="tm">Job Locations</p>
                    <div class="ck-collapse-wrapper">
                      <div class="ck-collapse">
                        <label class="ck">All
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">San Francisco, CA
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">New York, NY
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Washington, DC
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Remote
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="filter-column">
                    <p class="tm">Job Type</p>
                    <div class="ck-collapse-wrapper">
                      <div class="ck-collapse">
                        <label class="ck">All
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Full-Time
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Part-Time
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="filter-column">
                    <p class="tm">Contract Type</p>
                    <div class="ck-collapse-wrapper">
                      <div class="ck-collapse">
                        <label class="ck">All
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Temporary
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Contract
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                        <label class="ck">Internship
                          <input type="checkbox" />
                          <span class="ck-checkmark"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 text-right job-filter-btn">
                  <button class="border-btn">Clear All</button>
                  <button class="fill-btn">Apply</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="div-table-wrapper">
          <div class="div-table">
            <div class="div-row">
              <div class="div-column">
                <label class="only-ck">
                  <input type="checkbox" />
                  <span class="only-ck-checkmark"></span>
                </label>
              </div>
              <div class="div-column">
                <p class="ll blur-color">Candidate</p>
              </div>
              <div class="div-column">
                <p class="ll blur-color">Phone Number</p>
              </div>
              <div class="div-column">
                <p class="ll blur-color">Email</p>
              </div>
              <div class="div-column">
                <p class="ll blur-color">City</p>
              </div>
              <div class="div-column">
                <p class="ll blur-color">Country</p>
              </div>
              <div class="div-column">
                <p class="ll blur-color">Resume</p>
              </div>
              <div class="div-column">
                <p class="ll blur-color">Action</p>
              </div>
            </div>
            <div class="div-row">
              <div class="div-column">
                <label class="only-ck">
                  <input type="checkbox" />
                  <span class="only-ck-checkmark"></span>
                </label>
              </div>
              <div class="div-column">
                <span class="bm name">Anika Vetrovs</span>
              </div>
              <div class="div-column">
                <span class="bm number">+1 123 456 7890</span>
              </div>
              <div class="div-column">
                <span class="bm email">candidate@domain.com</span>
              </div>
              <div class="div-column">
                <span class="bm city">New York</span>
              </div>
              <div class="div-column">
                <span class="bm country">United States</span>
              </div>
              <div class="div-column">
                <a href="ticket.PDF" class="pdf-link" target="_blank">
                  <img src="assets/img/pdf.svg" alt="" />
                </a>
              </div>
              <div class="div-column">
                <div class="action-block">
                  <a data-toggle="modal" data-target="#reqEditCandidate">
                    <img src="assets/img/pencil.svg" alt="" />
                  </a>
                  <a href=""><img src="assets/img/delete.svg" alt="" /></a>
                </div>
                <div class="mobile-action show-991">
                  <div class="dropdown c-dropdown my-playlist-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                      <img src="assets/img/more-vertical.svg" class="c-icon" />
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" data-toggle="modal" data-target="#reqEditCandidate">
                        <img src="assets/img/pencil.svg" alt="" />
                        <span>Edit</span>
                      </a>
                      <a class="dropdown-item">
                        <img src="assets/img/delete.svg" alt="" />
                        <span>Delete</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="div-row">
              <div class="div-column">
                <label class="only-ck">
                  <input type="checkbox" />
                  <span class="only-ck-checkmark"></span>
                </label>
              </div>
              <div class="div-column">
                <span class="bm name">Desirae Botosh</span>
              </div>
              <div class="div-column">
                <span class="bm number">+1 123 456 7890</span>
              </div>
              <div class="div-column">
                <span class="bm email">candidate@domain.com</span>
              </div>
              <div class="div-column">
                <span class="bm city">New York</span>
              </div>
              <div class="div-column">
                <span class="bm country">United States</span>
              </div>
              <div class="div-column">
                <a href="ticket.PDF" class="pdf-link" target="_blank">
                  <img src="assets/img/pdf.svg" alt="" />
                </a>
              </div>
              <div class="div-column">
                <div class="action-block">
                  <a data-toggle="modal" data-target="#reqEditCandidate">
                    <img src="assets/img/pencil.svg" alt="" />
                  </a>
                  <a href=""><img src="assets/img/delete.svg" alt="" /></a>
                </div>
                <div class="mobile-action show-991">
                  <div class="dropdown c-dropdown my-playlist-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                      <img src="assets/img/more-vertical.svg" class="c-icon" />
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" data-toggle="modal" data-target="#reqEditCandidate">
                        <img src="assets/img/pencil.svg" alt="" />
                        <span>Edit</span>
                      </a>
                      <a class="dropdown-item">
                        <img src="assets/img/delete.svg" alt="" />
                        <span>Delete</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="div-row">
              <div class="div-column">
                <label class="only-ck">
                  <input type="checkbox" />
                  <span class="only-ck-checkmark"></span>
                </label>
              </div>
              <div class="div-column">
                <span class="bm name">Marcus Bergson</span>
              </div>
              <div class="div-column">
                <span class="bm number">+1 123 456 7890</span>
              </div>
              <div class="div-column">
                <span class="bm email">candidate@domain.com</span>
              </div>
              <div class="div-column">
                <span class="bm city">New York</span>
              </div>
              <div class="div-column">
                <span class="bm country">United States</span>
              </div>
              <div class="div-column">
                <a href="ticket.PDF" class="pdf-link" target="_blank">
                  <img src="assets/img/pdf.svg" alt="" />
                </a>
              </div>
              <div class="div-column">
                <div class="action-block">
                  <a data-toggle="modal" data-target="#reqEditCandidate">
                    <img src="assets/img/pencil.svg" alt="" />
                  </a>
                  <a href=""><img src="assets/img/delete.svg" alt="" /></a>
                </div>
                <div class="mobile-action show-991">
                  <div class="dropdown c-dropdown my-playlist-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                      <img src="assets/img/more-vertical.svg" class="c-icon" />
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" data-toggle="modal" data-target="#reqEditCandidate">
                        <img src="assets/img/pencil.svg" alt="" />
                        <span>Edit</span>
                      </a>
                      <a class="dropdown-item">
                        <img src="assets/img/delete.svg" alt="" />
                        <span>Delete</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
	<footer include-html="footer.html"></footer>
	<div class="copy-right" include-html="copy-right.html"></div>


  <div class="modal fade modal-structure req-add-candidate" id="reqAddCandidate">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h6 class="modal-title">Add Candidate</h6>
          <button type="button" class="close" data-dismiss="modal">
            <img src="assets/img/close.svg" alt="" />
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
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
                <span>Email</span>
                <input type="text" />
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>Country</span>
                <select>
                  <option>Select...</option>
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
              <div class="upload-resume">
                <p class="tm">Upload resume</p>
                <div class="upload-form-btn2">
                  <input type="file" id="upload-form-file" hidden="hidden" />
                  <img src="assets/img/upload-icon.svg" id="upload-form-img" alt="" />
                  <div>
                    <p class="tm" id="upload-form-text">Upload resume</p>
                    <span class="bs blur-color">Use a pdf, docx, doc, rtf and txt</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="fill-btn" data-dismiss="modal">Add Candidate</button>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade modal-structure req-add-candidate" id="reqEditCandidate">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h6 class="modal-title">Edit Candidate</h6>
          <button type="button" class="close" data-dismiss="modal">
            <img src="assets/img/close.svg" alt="" />
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>First name</span>
                <input type="text" value="Anika"/>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>Last name</span>
                <input type="text" value="Vetrovs"/>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="number-groups">
                <span>Phone Number</span>
                <div class="number-fields">
                  <input type="text" id="phoneField2" name="phoneField2" class="phone-field" />
                  <input type="text" class="mobile-number" value="123 456 7890">
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="input-groups">
                <span>Email</span>
                <input type="email" value="candidate@domain.com" />
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
                <input type="text" value="New York"/>
              </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
              <div class="upload-resume">
                <p class="tm">Upload resume</p>
                <div class="upload-form-btn2">
                  <input type="file" id="upload-form-file" hidden="hidden" />
                  <img src="assets/img/upload-icon.svg" id="upload-form-img" alt="" />
                  <div>
                    <p class="tm" id="upload-form-text">Resume.pdf</p>
                    <span class="bs blur-color">1.5mb</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="fill-btn" data-dismiss="modal">Save Candidate</button>
        </div>

      </div>
    </div>
  </div>

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
    $("#phoneField2").CcPicker();
  </script>
</html>