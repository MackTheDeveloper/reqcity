@extends('admin.layouts.master')
@section('title','Users')
@section('content')
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper justify-content-between">
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
                                                <a href="javascript:void(0);">Recruiter Portal</a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitch1">
                          <label class="custom-control-label" for="customSwitch1">Card View</label>
                        </div>
                    </div>
                </div>
                                              
               
                <div class="candidates-request-card new-to-old">
                  
                  <div class="crc-box">
                    <div class="crc-one">
                      <p class="tl">Anika Vetrovs</p>
                      <span class="bm blur-color">+1 234 567 8901</span>
                      <span class="bm blur-color">candidatedomain.com</span>
                      <span class="bm blur-color">2327 16th Ave, Hillside, IL 60142, United States</span>
                      <div class="d-flex justify-content-start">
                        <div class="linkdin-box">
                          <label class="ll">Resume</label>
                          <a href="">
                            <img src="../../../../public/assets/frontend/img/pdf.svg" alt="" />
                          </a>
                        </div>
                        <div class="resume-box">
                          <label class="ll">LinkedIn</label>
                          <a href="">
                            <img src="../../../../public/assets/frontend/img/Linkedin-btn.svg" alt="" />
                          </a>
                        </div>
                      </div>
                      <button class="btn btn-primary">Submit Candidate</button>
                    </div>
                    <div class="crc-two">
                      <p class="tl">Javascript Developer</p>
                      <label class="ts blur-color">Nutrify, Inc.</label>
                      <label class="ts blur-color">San Francisco, CA</label>
                      <span class="bm blur-color">Sed in velit ipsum. Maecenas molestie tellus eu egestas vestibulum. Phasellus ullamcorper orci risus, id rhoncus lacus mollis.</span>
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

                  <div class="crc-box">
                    <div class="crc-one">
                      <p class="tl">Anika Vetrovs</p>
                      <span class="bm blur-color">+1 234 567 8901</span>
                      <span class="bm blur-color">candidatedomain.com</span>
                      <span class="bm blur-color">2327 16th Ave, Hillside, IL 60142, United States</span>
                      <div class="d-flex justify-content-start">
                        <div class="linkdin-box">
                          <label class="ll">Resume</label>
                          <a href="">
                            <img src="../../../../public/assets/frontend/img/pdf.svg" alt="" />
                          </a>
                        </div>
                        <div class="resume-box">
                          <label class="ll">LinkedIn</label>
                          <a href="">
                            <img src="../../../../public/assets/frontend/img/Linkedin-btn.svg" alt="" />
                          </a>
                        </div>
                      </div>
                      <button class="btn btn-primary">Submit Candidate</button>
                    </div>
                    <div class="crc-two">
                      <p class="tl">Javascript Developer</p>
                      <label class="ts blur-color">Nutrify, Inc.</label>
                      <label class="ts blur-color">San Francisco, CA</label>
                      <span class="bm blur-color">Sed in velit ipsum. Maecenas molestie tellus eu egestas vestibulum. Phasellus ullamcorper orci risus, id rhoncus lacus mollis.</span>
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
