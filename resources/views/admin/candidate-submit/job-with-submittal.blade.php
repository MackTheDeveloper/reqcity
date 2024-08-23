@extends('admin.layouts.master')
@section('title','Users')
@section('content')
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa fa-users opacity-6"></i>
                                    </span>
                                    <span class="d-inline-block" >Users</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                          <li class="breadcrumb-item">
                                            <a href="javascript:void(0);" style="color: grey">Recruiter Portal</a>
                                          </li>
                                          <li class="breadcrumb-item">
                                            <a href="javascript:void(0);" style="color: grey">Cara Bedford</a>
                                          </li>
                                          <li class="active breadcrumb-item" aria-current="page">
                                              <a style="color: slategray">Jobs with Submittals</a>
                                          </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                              
               
                <div class="company-jobs-wrapper new-to-old ">
                    

                    <div class="company-jobs mt-0">
                      
                      <div class="job-data-wrapper">
                        <div class="job-header">
                          <div class="searchbar-btn">
                            <input type="text" class="input" placeholder="Search for job" />
                            <button class="search-btn"><img src="assets/img/white-search.svg" alt="" /></button>
                          </div>
                          <button class="border-btn filter-btn web-filter">
                            <img src="assets/img/bell.svg" alt="" />Filter
                          </button>
                          
                          <div class="sort-by-sec">
                            <p class="bm">Sort by</p>
                            <select class="form-control select">
                              <option>Recently Posted</option>
                            </select>
                          </div>
                        </div>
                        <div class="filter-section-wrapper">
                          <div class="filter-section">
                            <!-- <div class="filter-sec-header">
                              <div class="filter-name-close">
                                <p class="tl">Filter</p>
                                <img src="assets/img/x.svg" class="close-filter" alt="" />
                              </div>
                              <div class="clear-apply">
                                <button class="border-btn">Clear All</button>
                                <button class="fill-btn">Apply</button>
                              </div>
                            </div> -->
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
                                  <button class="btn btn-light">Clear All</button>
                                  <button class=" btn btn-primary">Apply</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="job-posts">
                          <div class="job-post-data w-100 p-0">
                            <p class="tm">Javascript Developer</p>
                            <p class="ll blur-color">San Francisco, CA</p>
                            <p class="bm blur-color">Sed in velit ipsum. Maecenas molestie tellus eu egestas vestibulum. Phasellus
                              ullamcorper orci risus, id rhoncus lacus mollis tempus.</p>
                            <div class="job-table">
                              <div class="first-data">
                                <label class="ll">$62,339 - $81,338 a year</label>
                                <span class="bs blur-color">3 days ago</span>
                              </div>
                              <div class="last-data m-0">
                                <div class="job-table-data">
                                  <div class="jtd-wrapper">
                                    <label class="ll">21</label>
                                    <span class="bs blur-color">Openings</span>
                                  </div>
                                </div>
                                <div class="job-table-data">
                                  <div class="jtd-wrapper">
                                    <label class="ll">14</label>
                                    <span class="bs blur-color">Approved</span>
                                  </div>
                                </div>
                                <div class="job-table-data">
                                  <div class="jtd-wrapper">
                                    <label class="ll">5</label>
                                    <span class="bs blur-color">Remaining Approvals</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="job-posts">
                          <div class="job-post-data w-100 p-0">
                            <p class="tm">Javascript Developer</p>
                            <p class="ll blur-color">San Francisco, CA</p>
                            <p class="bm blur-color">Sed in velit ipsum. Maecenas molestie tellus eu egestas vestibulum. Phasellus
                              ullamcorper orci risus, id rhoncus lacus mollis tempus.</p>
                            <div class="job-table">
                              <div class="first-data">
                                <label class="ll">$62,339 - $81,338 a year</label>
                                <span class="bs blur-color">3 days ago</span>
                              </div>
                              <div class="last-data m-0">
                                <div class="job-table-data">
                                  <div class="jtd-wrapper">
                                    <label class="ll">21</label>
                                    <span class="bs blur-color">Openings</span>
                                  </div>
                                </div>
                                <div class="job-table-data">
                                  <div class="jtd-wrapper">
                                    <label class="ll">14</label>
                                    <span class="bs blur-color">Approved</span>
                                  </div>
                                </div>
                                <div class="job-table-data">
                                  <div class="jtd-wrapper">
                                    <label class="ll">5</label>
                                    <span class="bs blur-color">Remaining Approvals</span>
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
            @include('admin.include.footer')
        </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
@endsection

@push('scripts')
<script src="{{asset('public/assets/custom/datatables/user/user-list-datatable.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(".status_change .dropdown-item").click(function(){
        var getStatusText = $(this).text();
        $(this).closest(".status_dropdown").find(".status__btn").text(getStatusText);
        var generateStatusClass = $(this).attr('data-class');
        $(this).closest(".status_dropdown").attr("data-color", `${generateStatusClass}`);
    })
</script>
<script>
    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })

    $(document).ready(function () {
    $(".web-filter").on("click", function () {
      $(".filter-section-wrapper").toggleClass("active" ,300);
    });
    $(".mobile-filter").on("click", function () {
      $(".filter-section-wrapper").addClass("active");
      $("body").addClass("scroll-stop");
      $(".backBg").addClass("show");
    });
    $(".close-filter").on("click", function () {
      $(".filter-section-wrapper").removeClass("active");
      $("body").removeClass("scroll-stop");
      $(".backBg").removeClass("show");
    });
    $(".backBg").on("click", function () {
      $(".filter-section-wrapper").removeClass("active");
      $("body").removeClass("scroll-stop");
      $(".backBg").removeClass("show");
    });
  });

  jQuery(document).ready(function(){

var $this = $('.ck-collapse');

// If more than 2 Education items, hide the remaining
$('.ck-collapse').each(function() {
  $(this).find('.ck').slice(0,5).addClass('shown')
  $(this).find('.ck').not('.shown').hide();
  if ($(this).find('.ck').length > 5) {
    $(this).append('<div><a href="javascript:;" class="show-more a"></a></div>');
}
});
// $('.ck-collapse .ck').slice(0,4).addClass('shown');
// $('.ck-collapse .ck').not('.shown').hide();
$('.ck-collapse .show-more').on('click',function(){
  $(this).closest('.ck-collapse').find('.ck').not('.shown').toggle(300);
  $(this).toggleClass('show-less');
});

});
</script>
@endpush
