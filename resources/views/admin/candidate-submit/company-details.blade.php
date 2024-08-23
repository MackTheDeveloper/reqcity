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
                                            <a href="javascript:void(0);" style="color: grey">Company Portal</a>
                                          </li>
                                          <li class="active breadcrumb-item" aria-current="page">
                                              <a style="color: slategray">Nutrify Foods, Inc.</a>
                                          </li>
                                            
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                              
               
                <div class="company-details new-to-old">
                  <div class="cpc-card">
                    <img src="public/assets/frontend/img/dashlogo.png" alt="" />
                    <div class="this-content">
                      <p class="tl">Nutrify Foods, Inc.</p>
                      <span class="ts blur-color">San Francisco, CA</span>
                      <span class="bm ">Nutrify is America’s leading superapp. We provide everyday services such as deliveries, mobility, financial services, enterprise services and others to millions of users across the region. Powered by technology and driven by heart.</span>
                    </div>
                  </div>


                  <div class="copm-performance-dash">
                    <div class="copm-perform-head">
                        <h6>Company Performance</h6>
                        <!-- <a href="">View All</a> -->
                    </div>
                    <span class="full-hr"></span>
                    <div class="comp-performance-detailed">
                        <div class="copm-perfromance-graph">
                            <div class="req-cspanel">
                                <ul class="nav " id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="tab-link active" id="pills-home-tab" data-toggle="pill"
                                            href="#pills-home" role="tab" aria-controls="pills-home"
                                            aria-selected="true">Monthly</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="tab-link" id="pills-profile-tab" data-toggle="pill"
                                            href="#pills-profile" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">Yearly</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="tab-link" id="pills-profile-tab" data-toggle="pill"
                                            href="#pills-profile" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">Lifetime</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">---</div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">--</div>
                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                        aria-labelledby="pills-contact-tab">--</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                  <div class="actjobs-boxstatus">
                    <div class="row">
                        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
                            <div class="actjob-status-item">
                                <h5>24</h5>
                                <span>Active jobs</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
                            <div class="actjob-status-item">
                                <h5>12</h5>
                                <span>Closed jobs</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
                            <div class="actjob-status-item">
                                <h5>03</h5>
                                <span>Paused jobs</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
                            <div class="actjob-status-item">
                                <h5>02</h5>
                                <span>Unpublished Jobs</span>
                            </div>
                        </div>
                    </div>
                </div>



                  <div class="active-jobs-dash">
                    <div class="active-job-head">
                        <h6>Active Jobs</h6>
                        <a href="">View All</a>
                    </div>
                    <div class="activejobs-detailed">
                        <div class="activejob-titlehead">
                            <div class="active-jobtitle">
                                <p class="tm">Javascript Developer</p>
                                <span>San Francisco, CA</span>
                            </div>
                           
                        </div>
                        <span class="actjob-address">Sed in velit ipsum. Maecenas molestie tellus eu
                            egestas vestibulum. Phasellus ullamcorper orci risus, id rhoncus lacus
                            mollis tempus.</span>
                        <div class="active-jobnumeric">
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
                    </div>
                    <div class="activejobs-detailed">
                      <div class="activejob-titlehead">
                          <div class="active-jobtitle">
                              <p class="tm">Javascript Developer</p>
                              <span>San Francisco, CA</span>
                          </div>
                         
                      </div>
                      <span class="actjob-address">Sed in velit ipsum. Maecenas molestie tellus eu
                          egestas vestibulum. Phasellus ullamcorper orci risus, id rhoncus lacus
                          mollis tempus.</span>
                      <div class="active-jobnumeric">
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
<script>
    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })
</script>
@endpush
