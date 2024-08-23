<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Reqcity | Company Candidates</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap4.min.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css'>
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/style2.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <link rel="stylesheet" href="assets/css/responsive2.css">
</head>

<body>
  <header class="top-shadow" include-html="header-after-login.html"></header>

  <div class="company-candidates">
    <div class="container">
      <div class="job-title-section">
        <div class="input-groups">
          <span>Job title</span>
          <select>
            <option>Javascript Developer</option>
          </select>
        </div>
      </div>
    </div>
    <div class="tab-wrapper">
      <div class="container">
        <div class="tab-section" id="navbar-example2">
          <ul>
            <li><a href="" class="tab-link">Pending</a></li>
            <li><a data="" class="tab-link">Approved</a></li>
            <li><a data="" class="tab-link">Rejected</a></li>
            <li><a data="" class="tab-link active">All</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="candidate-wrapper">
        <div class="job-header">
          <div class="searchbar-btn">
            <input type="text" class="input" placeholder="Search for job" />
            <button class="search-btn"><img src="assets/img/white-search.svg" alt="" /></button>
          </div>
          <div class="sort-by-sec">
            <p class="bm">Sort by</p>
            <select class="select">
              <option>Recently Posted</option>
            </select>
          </div>
        </div>
        <div class="rac-table-wrapper">
          <div class="rac-table">
            <div class="rac-row">
              <div class="rac-column">
                <p class="ll blur-color">Name</p>
              </div>
              <div class="rac-column">
                <p class="ll blur-color">Status</p>
              </div>
              <div class="rac-column">
                <p class="ll blur-color">Recent Experience</p>
              </div>
              <div class="rac-column">
                <p class="ll blur-color">Contact Information</p>
              </div>
              <div class="rac-column">
                <p class="ll blur-color">Resume</p>
              </div>
              <div class="rac-column">
                <p class="ll blur-color action-header">Action <img src="assets/img/info-circle.svg" alt="" class="info-icon"/></p>
              </div>
            </div>
            <div class="rac-row">
              <div class="rac-column">
                <p class="tm">Harper Lee</p>
                <span class="ts blur-color">San Francisco, CA</span>
              </div>
              <div class="rac-column">
                <p class="bm">Pending</p>
                <span class="bs blur-color">Applied 12 Nov</span>
              </div>
              <div class="rac-column">
                <p class="bm">Javascript Developer</p>
                <span class="bs blur-color">Inforus  |  July 2019 - Present</span>
              </div>
              <div class="rac-column">
                <label class="bm">candidate@domain.com</label>
                <span class="bm">+1 123 456 7890</span>
              </div>
              <div class="rac-column">
                <a href="ticket.PDF" class="pdf-link" target="_blank">
                  <img src="assets/img/pdf.svg" alt="" />
                </a>
              </div>
              <div class="rac-column">
                <div class="view-icon-block">
                  <a href="" class="icon-btns" >
                    <img src="assets/img/view-icon.svg" alt="" />
                  </a>
                  <a href="" class="icon-btns" >
                    <img src="assets/img/yes-sign.svg" alt="" />
                  </a>
                  <a href="javascript:void(0)" class="icon-btns"  data-toggle="modal" data-target="#rejectCandidate">
                    <img src="assets/img/not-sign.svg" alt="" />
                  </a>
                </div>
              </div>
            </div>
            <div class="rac-row">
              <div class="rac-column">
                <p class="tm">Tatiana Madsen</p>
                <span class="ts blur-color">San Francisco, CA</span>
              </div>
              <div class="rac-column">
                <p class="bm">Rejected</p>
                <span class="bs blur-color">Applied 12 Nov</span>
              </div>
              <div class="rac-column">
                <p class="bm">Javascript Developer</p>
                <span class="bs blur-color">Inforus  |  July 2019 - Present</span>
              </div>
              <div class="rac-column">
                <label class="bm">candidate@domain.com</label>
                <span class="bm">+1 123 456 7890</span>
              </div>
              <div class="rac-column">
                <a href="ticket.PDF" class="pdf-link" target="_blank">
                  <img src="assets/img/pdf.svg" alt="" />
                </a>
              </div>
              <div class="rac-column">
                <div class="view-icon-block">
                  <a href="" class="icon-btns" >
                    <img src="assets/img/view-icon.svg" alt="" />
                  </a>
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



  <div class="modal fade modal-structure reject-candidate-popup" id="rejectCandidate">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h6 class="modal-title">Reject Candidate</h6>
          <button type="button" class="close" data-dismiss="modal">
            <img src="assets/img/close.svg" alt="" />
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="tm">Harper Lee</p>
          <p class="ts blur-color">San Francisco, CA</p>
          <div class="input-groups">
            <span>Reason for rejection</span>
            <textarea></textarea>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="border-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="fill-btn" data-dismiss="modal">Submit</button>
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
<script src="assets/js/script.js"></script>

</html>