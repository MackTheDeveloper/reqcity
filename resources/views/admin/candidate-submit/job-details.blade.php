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
                                        <li class="breadcrumb-item">
                                          <a href="javascript:void(0);" style="color: grey">Nutrify Foods, Inc.</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">Jobs</a>
                                        </li>
                                          
                                      </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                              
               
                <div class="job-detail-wrapper new-to-old">
                  

                    <div class="company-job-details">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="job-detail-data">
                                    <a href="" class="back-to-link bm"><img src="assets/img/arrow-left.svg" alt="" />Back to all
                                        jobs</a>

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
                                  
                                              
                                            </div>
                                  
                                          </div>   
                                    <div class="jdc-wrapper">
                                        <p class="tl">Job Performance</p>
                                        <div class="job-detail-chart">
                                            <div class="jd-chart">
                                                <img src="assets/img/Job-Performance.png" alt="" />
                                            </div>
                                            <div class="jd-data">
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
                                    <hr class="hr mtb-35">
                                    <div class="candidates">
                                        <p class="tl">Candidates</p>
                                        <div class="row">
                                            <div class="col-6 col-sm-3 col-md-3">
                                                <div class="candidates-box">
                                                    <h5>24</h5>
                                                    <p class="tm blur-color">Openings</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-3">
                                                <div class="candidates-box">
                                                    <h5>7</h5>
                                                    <p class="tm blur-color">Pending</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-3">
                                                <div class="candidates-box">
                                                    <h5>5</h5>
                                                    <p class="tm blur-color">Approved</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-3">
                                                <div class="candidates-box">
                                                    <h5>9</h5>
                                                    <p class="tm blur-color">Rejected</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr candi-hr">
                                    <div class="job-descripation">
                                        <div class="jd-header">
                                            <p class="tl">Job Description</p>
                                            <p class="bm">Nutrify, Inc. is looking for JavaScript developers to join its technical
                                                team’s expansion. The ideal candidate will be based in San Francisco, CA.</p>
                                        </div>
            
                                        <div class="question-item">
                                            <p class="tm">What we are looking for?</p>
                                            <ul>
                                                <li>At least 1 year experience in working as a Javascript developer.</li>
                                                <li>Knowledge of client-side technologies (HTML/CSS/Javascript)</li>
                                                <li>Experience in working with jQuery library</li>
                                                <li>Basic understanding of Git version control</li>
                                                <li>Basic understanding of the usage of REST APIs</li>
                                                <li>Fast learner (and willing to learn a lot)</li>
                                                <li>You love web development</li>
                                                <li>Programming experience (any language)</li>
                                                <li>You are proactive team player with good written and spoken English skills</li>
                                                <li>You are curious and like to understand how things work</li>
                                                <li>Relevant university degree or training in computer science or software
                                                    development</li>
                                            </ul>
                                        </div>
            
                                        <div class="question-item">
                                            <p class="tm">Job functions</p>
                                            <ul>
                                                <li>Optimize applications for maximum speed and scalability.</li>
                                                <li>Collaborate with other team members and stakeholders.</li>
                                                <li>Contribute to team development and initiatives.</li>
                                                <li>Occasionally assist the UI Developer with enhanced Javascript functionality as
                                                    needed.</li>
                                            </ul>
                                        </div>
            
                                        <div class="question-item">
                                            <p class="tm">Job requirements</p>
                                            <ul>
                                                <li>Strong English language skills.</li>
                                                <li>Excellent communication skills, including verbal, written, and presentation.
                                                </li>
                                            </ul>
                                        </div>
            
                                        <table class="table-content-data">
                                            <tr>
                                                <td>Employment type</td>
                                                <td>Full-time</td>
                                            </tr>
                                            <tr>
                                                <td>Schedule</td>
                                                <td>Monday to Friday, Day shift</td>
                                            </tr>
                                            <tr>
                                                <td>Contract type</td>
                                                <td>Internship</td>
                                            </tr>
                                            <tr>
                                                <td>Contract duration</td>
                                                <td>6 months</td>
                                            </tr>
                                            <tr>
                                                <td>Remote work</td>
                                                <td>Temporarily due to COVID-19</td>
                                            </tr>
                                        </table>
            
                                        <div class="frequent-question">
                                            <p class="tl">Frequently asked questions</p>
                                            <div class="que-ans">
                                                <p class="tm">How do I know my application was viewed?</p>
                                                <span class="bm">Integer aliquam lacus libero, id suscipit ex fringilla vel.
                                                    Maecenas rhoncus ligula vel orci rutrum pharetra. Ut feugiat mi commodo rhoncus
                                                    tincidunt. Nunc eros arcu, facilisis sit amet eleifend non, sagittis ut
                                                    augue.</span>
                                            </div>
                                            <div class="que-ans">
                                                <p class="tm">In how many days application will be reviewed?</p>
                                                <span class="bm">Aenean nec odio eget sapien placerat feugiat ac ac tortor. Mauris
                                                    ut blandit tortor. Nullam pharetra dolor ligula, a convallis est vehicula
                                                    dictum. Nunc imperdiet turpis elementum augue dictum.</span>
                                            </div>
                                            <div class="que-ans">
                                                <p class="tm">Why do I need to enter my Employment Information?</p>
                                                <span class="bm">Praesent auctor sapien lectus, semper interdum diam luctus ut.
                                                    Proin in metus at sapien ultrices molestie. Interdum et malesuada fames ac ante
                                                    ipsum primis in faucibus.</span>
                                            </div>
                                            <div class="que-ans">
                                                <p class="tm">How Can I enter multiple education qualifications?</p>
                                                <span class="bm">Etiam id eleifend orci. Etiam eget scelerisque metus, at posuere
                                                    lectus. Sed pharetra tortor quis dui lacinia pulvinar. Aenean pellentesque nulla
                                                    ut lacus auctor mattis a quis quam.</span>
                                            </div>
                                            <div class="que-ans">
                                                <p class="tm">How do I enter my Location/City Preference?</p>
                                                <span class="bm">Vestibulum molestie gravida ante scelerisque tincidunt. Nullam sit
                                                    amet facilisis nulla. Maecenas et enim in risus ornare imperdiet.</span>
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-12 order-1 order-lg-2 col-lg-4 col-xl-3">
                                <div class="job-post-box">
                                    <p class="tl">Javascript Developer</p>
                                    <p class="bm blur-color">San Francisco, CA</p>
                                    <p class="ll">$62,339 - $81,338 a year</p>
                                    <div class="dropdown status_dropdown" data-color="open">
                                        <button
                                            class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn"
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
                                                <a class="dropdown-item" data-class="closed" href="javascript:void(0)"
                                                    data-toggle="modal" data-target="#closeJob">
                                                    <div class="status-round"></div>Closed
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <table class="table-content-data last-blur">
                                        <tr>
                                            <td>Total Cost</td>
                                            <td>$63.00</td>
                                        </tr>
                                        <tr>
                                            <td>Balance</td>
                                            <td>$21.00</td>
                                        </tr>
                                    </table>
                                </div>
                            </div> --}}
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
