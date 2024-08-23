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
                                          <li class="active breadcrumb-item" aria-current="page">
                                              <a style="color: slategray">Cara Bedford
                                              </a>
                                          </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                              
               
                <div class="new-to-old">
                  <!-- <div class="cpc-card withot-img without-last-data">
                    <div class="this-content">
                      <p class="tl">Cara Bedford</p>
                      <div class="number-email-add d-block">
                        <p>+1 234 567 8901</p>
                        <p>recruiter@domain.com</p>
                        <p>2327 16th Ave, Hillside, IL 60142, United States</p>
                      </div>
                    </div>
                    <p class="blur-color tk">RC1532</p>
                  </div> -->

                  <div class="dashboards-main">
                    <div class="row">
                        <div class="col-md-12">
    
                            <div class="recruiter-candidate-dashbox">
                                <div class="reqstudent-dash-head">
                                    <h5>Cara Bedford</h5>
                                    <span>RC1532</span>
                                </div>
                                <p>+1 234 567 8901</p>
                                <p>recruiter@domain.com</p>
                                <p>2327 16th Ave, Hillside, IL 60142, United States</p>
                            </div>
    
                            <div class="job-perfromance-payout-dashmain">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-xl-6">
                                        <div class="job-pp-item">
                                            <div class="pp-dash-head">
                                                <h6>Job Performance</h6>
                                            </div>
                                            <div class="pp-dash-detailed">
                                                <div class="performance-dash-graphdata">
                                                    <div class="perfo-graph">
                                                        <img src="assets/img/recruiter-perfornce-graph.png" alt="" />
                                                    </div>
                                                    <div class="perfo-status">
                                                        <div class="jd-progress-data">
                                                            <div class="jd-preogress-color yellow"></div>
                                                            <span class="bs">Candidates</span>
                                                        </div>
                                                        <div class="jd-progress-data">
                                                            <div class="jd-preogress-color green"></div>
                                                            <span class="bs">Approved</span>
                                                        </div>
                                                        <div class="jd-progress-data">
                                                            <div class="jd-preogress-color red"></div>
                                                            <span class="bs">Rejected</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-6">
                                        <div class="job-pp-item">
                                            <div class="pp-dash-head">
                                                <h6>Total Payout</h6>
                                            </div>
                                            <div class="pp-dash-detailed payout-dash-detail">
                                                <div class="payout-graphed-data">
                                                    <div class="payout-graphed-item">
                                                        <p>Balance ($)</p>
                                                        <div class="progress-line-wrapper">
                                                            <div class="progress-line" style="background: #4C65FF;width: 20%;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="payout-graphed-item">
                                                        <p>Payout ($)</p>
                                                        <div class="progress-line-wrapper">
                                                            <div class="progress-line" style="background: #47C1BF;width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="active-jobs-dash">
                                <div class="active-job-head">
                                    <h6>Jobs with Submittals</h6>
                                    <a href="">View All</a>
                                </div>
                                <div class="activejobs-detailed">
                                    <div class="activejob-titlehead">
                                        <div class="active-jobtitle">
                                            <p class="tm">Javascript Developer</p>
                                            <span>Nutrify, Inc.</span>
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
                                                    <span class="bs blur-color">Open Reqs</span>
                                                </div>
                                            </div>
                                            <div class="job-table-data">
                                                <div class="jtd-wrapper">
                                                    <label class="ll">5</label>
                                                    <span class="bs blur-color">Reviewed</span>
                                                </div>
                                            </div>
                                            <div class="job-table-data">
                                                <div class="jtd-wrapper">
                                                    <label class="ll">9</label>
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
                                          <span>Nutrify, Inc.</span>
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
                                                  <span class="bs blur-color">Open Reqs</span>
                                              </div>
                                          </div>
                                          <div class="job-table-data">
                                              <div class="jtd-wrapper">
                                                  <label class="ll">5</label>
                                                  <span class="bs blur-color">Reviewed</span>
                                              </div>
                                          </div>
                                          <div class="job-table-data">
                                              <div class="jtd-wrapper">
                                                  <label class="ll">9</label>
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
                                        <span>Nutrify, Inc.</span>
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
                                                <span class="bs blur-color">Open Reqs</span>
                                            </div>
                                        </div>
                                        <div class="job-table-data">
                                            <div class="jtd-wrapper">
                                                <label class="ll">5</label>
                                                <span class="bs blur-color">Reviewed</span>
                                            </div>
                                        </div>
                                        <div class="job-table-data">
                                            <div class="jtd-wrapper">
                                                <label class="ll">9</label>
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
                            <div class="active-jobs-dash">
                                <div class="active-job-head">
                                    <h6>Candidates</h6>
                                    <a href="">View All</a>
                                </div>
                                <div class="table-responsive">
                                  <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                      <tr>
                                        <th>Candidate</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>Country</th>
                                        <th>Resume</th>
                                        <th>LinkedIn</th>
                                      </tr>
                                    </thead>
                                    <tbody>                                   
                                      <tr class="odd gradeX">
                                        <td>Anika Vetrovs</td>
                                        <td>+1 123 456 7890</td>
                                        <td>candidate@domain.com</td>
                                        <td>New York</td>
                                        <td>United States</td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/pdf.svg" alt="" />
                                          </a>
                                        </td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/Linkedin-btn.svg" alt="" />
                                          </a>
                                        </td>
                                      </tr>
                                      <tr class="odd gradeX">
                                        <td>Anika Vetrovs</td>
                                        <td>+1 123 456 7890</td>
                                        <td>candidate@domain.com</td>
                                        <td>New York</td>
                                        <td>United States</td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/pdf.svg" alt="" />
                                          </a>
                                        </td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/Linkedin-btn.svg" alt="" />
                                          </a>
                                        </td>
                                      </tr>
                                      <tr class="odd gradeX">
                                        <td>Anika Vetrovs</td>
                                        <td>+1 123 456 7890</td>
                                        <td>candidate@domain.com</td>
                                        <td>New York</td>
                                        <td>United States</td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/pdf.svg" alt="" />
                                          </a>
                                        </td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/Linkedin-btn.svg" alt="" />
                                          </a>
                                        </td>
                                      </tr>
                                      <tr class="odd gradeX">
                                        <td>Anika Vetrovs</td>
                                        <td>+1 123 456 7890</td>
                                        <td>candidate@domain.com</td>
                                        <td>New York</td>
                                        <td>United States</td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/pdf.svg" alt="" />
                                          </a>
                                        </td>
                                        <td>
                                          <a href="" class="link-on-img">
                                            <img src="../../../../public/assets/frontend/img/Linkedin-btn.svg" alt="" />
                                          </a>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
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

@endpush
