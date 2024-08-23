<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Reqcity | Jobs</title>
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
  <header class="top-shadow" include-html="header.html"></header>

  <div class="tab-wrapper">
    <div class="container">
      <div class="tab-section" id="navbar-example2">
        <ul>
          <li><a href="" class="tab-link active">All</a></li>
          <li><a data="" class="tab-link">Open</a></li>
          <li><a data="" class="tab-link">Paused</a></li>
          <li><a data="" class="tab-link">Closed</a></li>
          <li><a data="" class="tab-link">Draft</a></li>
        </ul>
      </div>
    </div>
  </div>


  <div class="company-jobs">
    <div class="container">
      <div class="job-data-wrapper">
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
        <div class="job-posts">
          <div class="job-post-data">
            <p class="tm">Javascript Developer</p>
            <p class="ll blur-color">San Francisco, CA</p>
            <p class="bm blur-color">Sed in velit ipsum. Maecenas molestie tellus eu egestas vestibulum. Phasellus
              ullamcorper orci risus, id rhoncus lacus mollis tempus.</p>
            <div class="job-table">
              <div class="first-data">
                <label class="ll">$62,339 - $81,338 a year</label>
                <span class="bs blur-color">3 days ago</span>
              </div>
              <div class="last-data">
                <div class="job-table-data">
                  <div class="jtd-wrapper">
                    <label class="ll">21</label>
                    <span class="bs blur-color">Openings</span>
                  </div>
                </div>
                <div class="job-table-data">
                  <div class="jtd-wrapper">
                    <label class="ll">14</label>
                    <span class="bs blur-color">Pending</span>
                  </div>
                </div>
                <div class="job-table-data">
                  <div class="jtd-wrapper">
                    <label class="ll">5</label>
                    <span class="bs blur-color">Approved</span>
                  </div>
                </div>
                <div class="job-table-data">
                  <div class="jtd-wrapper">
                    <label class="ll">9</label>
                    <span class="bs blur-color">Rejected</span>
                  </div>
                </div>
                <div class="job-table-data">
                  <div class="jtd-wrapper">
                    <label class="ll">$63.00</label>
                    <span class="bs blur-color">Total Cost</span>
                  </div>
                </div>
                <div class="job-table-data">
                  <div class="jtd-wrapper">
                    <label class="ll">$21.00</label>
                    <span class="bs blur-color">Balance</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="job-post-status">
            <div class="dropdown status_dropdown" data-color="open">
              <button class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn"
                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                data-bs-offset="0,12">
                Open
              </button>
              <ul class="dropdown-menu status_change" aria-labelledby="dropdownMenuButton1">
                <li>
                  <a class="dropdown-item" data-class="open" href="javascript:void(0)">
                    <div class="status-round"></div>Open
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" data-class="paused" href="javascript:void(0)">
                    <div class="status-round"></div>Paused
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" data-class="closed" href="javascript:void(0)" data-toggle="modal"
                      data-target="#closeJob">
                      <div class="status-round"></div>Closed
                  </a>
                </li>
              </ul>
            </div>

            <div class="dropdown c-dropdown my-playlist-dropdown">
              <button class="dropdown-toggle" data-bs-toggle="dropdown">
                <img src="assets/img/more-vertical.svg" class="c-icon" />
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" data-toggle="modal" data-target="#addToPlaylistModal">
                  <img src="assets/img/Hovered-heart.svg" alt="" />
                  <span>Add to Playlist</span>
                </a>
                <a class="dropdown-item">
                  <img src="assets/img/Hovered-heart.svg" alt="" />
                  <span>Download</span>
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <footer include-html="footer.html"></footer>
  <div class="copy-right" include-html="copy-right.html"></div>



  <div class="modal fade modal-structure close-job-popup" id="closeJob">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h6 class="modal-title">Close Job</h6>
          <button type="button" class="close" data-dismiss="modal">
            <img src="assets/img/close.svg" alt="" />
          </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <p class="tl">Fund Transfer</p>
          <p class="bm blur-color">You can transfer this fund to any of your open jobs.</p>
          <div class="from-sec">
            <span class="bm blur-color">From</span>
            <p class="tm">Javascript Developer</p>
          </div>
          <div class="balance">
            <span class="bm blur-color">Balance</span>
            <p class="tl">$84.00</p>
          </div>
          <div class="input-groups">
            <span>Select job to transfer fund</span>
            <select>
              <option>Web Developer</option>
            </select>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="border-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="fill-btn" data-dismiss="modal">Request</button>
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