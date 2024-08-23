@extends('admin.layouts.master')
<title>Candidate Submit 3</title>
@section('content')
<link rel="stylesheet" href="{{asset('public/assets/frontend/css/jquery.ccpicker.css')}}">
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
                                        <i class="fa pe-7s-portfolio"></i>
                                    </span>
                                    <span class="d-inline-block">Categories</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{route('adminDashboard')}}">
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page" style="color: slategray">
                                              Candidate Submit 3
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="process-progress">
                    <div class="info-progress done">
                        <div class="numbers">1</div>
                        <p class="tm">Candidate Details</p>
                    </div>
                    <div class="info-progress done">
                        <div class="numbers">2</div>
                        <p class="tm">Questionnaire</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">3</div>
                        <p class="tm">Review Submittal</p>
                    </div>
                </div>
                

                <div class="parent-header">
                  <h4 class="form-title-text">Review Submittal</h4>
                  <a href="" class="edit-link">Edit Submittal</a>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title-wrapper">
                            <h5 class="card-title">Contact information</h5>
                            <button type="submit" class="btn btn-primary plr-16" data-toggle="modal" data-target="#viewDetailModal">View Details</button>
                        </div>
                        <form>
                            <div class="row">
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">First name</label>
                                    <div>
                                        <span>Justin</span>
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label class="font-weight-bold">Last name</label>
                                      <div>
                                        <span>Dias</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label class="font-weight-bold">Phone Number</label>
                                      <span class="text-danger">*</span>
                                      <div>
                                        <span>+1 123 456 7890</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label class="font-weight-bold">Email</label>
                                      <span class="text-danger">*</span>
                                      <div>
                                          <span>candidate@domain.com</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <p>Contact information will be hidden from company until they pay for qualified applicants.
                                    </p>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Country</label>
                                    <div>
                                        <span>United States</span>
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label class="font-weight-bold">City</label>
                                      <div>
                                        <span>New York</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <div class="diversity-labels">
                                    <span>Diversity</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Resume</label>
                                    <div class="uploaded-resume">
                                      <a href="" class="a-img-wrapper">
                                        <img src="../../../../public/assets/frontend/img/pdf-orange.svg" alt="" />
                                      </a>
                                      <p>Justin Dias</p>
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">LinkedIn</label>
                                    <div>
                                      <span>https://www.linkedin.com/us/jastin-dias-6a65254</span>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <hr />
                            <h5 class="card-title mb-4">Employer questions</h5>
                            <div class="row">
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <label class="font-weight-bold">Tell us about yourself</label>
                                  <div>
                                      <span>I started working as a developer back in 2014 as a Junior developer. After that, I worked in that company for 2 years and changed Job in the new company as a Senior developer. And I am working as a Sr. Javascript Developer for the last 4 years.</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <label class="font-weight-bold">What is it about your current position that you don't like that you are looking for in your next opportunity?</label>
                                  <div>
                                      <span>MS Excel, MS Word</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <label class="font-weight-bold">When are you available to start your next opportunity?</label>
                                  <div>
                                      <span>In 1 Month</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <label class="font-weight-bold">Citizen/Work status?</label>
                                  <div>
                                      <span>Indian</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <label class="font-weight-bold">Travel Requirements?</label>
                                  <div>
                                      <span>Yes</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <label class="font-weight-bold">Are you aware of the COVID situation and precautions to be taken?</label>
                                  <div>
                                      <span>Yes</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <hr />
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <a href="http://localhost/reqcity/securerccontrol/job-fields/index">
                                    <button type="button" class="btn btn-light" name="cancel" value="Cancel">Back</button>
                                  </a>
                                  <button type="submit" class="btn btn-primary" id="add_pkg_btn">Submit</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            
            </div>
            @include('admin.include.footer')
        </div>
    </div>
@endsection

<div class="modal view-detail-modal" id="viewDetailModal">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <div class="job-posdetails-first">
                <h5>Javascript Developer</h5>
                <span class="grey-span-sidebar">Nutrify, Inc.</span>
                <span class="grey-span-sidebar">San Francisco, CA</span>
                <div class="jobpost-budgeted-salary">
                    <p class="ll">$62,339 - $81,338 a year</p>
                    <span>3 days ago</span>
                </div>
            </div>
            <div class="job-postdesc-sec">
                <p class="job-postdesc-p">We are looking for a Developers with experience using native
                    JavaScript, HTML5, and CSS
                    to join its development team. The ideal candidate will have a desire to work for a
                    global company working on cutting-edge techniques for an online shopping application
                    that is growing rapidly. We are looking for energetic people and willing to provide a
                    relocation opportunity and permanent role for those that set themselves apart and
                    establish themselves as rising stars.</p>
                <div class="what-welook-side">
                    <p class="tm">What We Are Looking For:</p>
                    <ul>
                        <li>At least 1 year experience in working as a Javascript developer.</li>
                        <li>Knowledge of client-side technologies (HTML/CSS/Javascript)</li>
                        <li>Experience in working with jQuery library</li>
                        <li>Basic understanding of Git version control</li>
                        <li>Basic understanding of the usage of REST APIs</li>
                        <li>Fast learner (and willing to learn a lot)</li>
                        <li>You love web development</li>
                        <li>Programming experience (any language)</li>
                        <li>You are proactive team player with good</li>
                    </ul>
                </div>
            </div>
        </div>

        
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
  
      </div>
    </div>
  </div>


@push('scripts')
<script src="{{ asset('public/assets/frontend/js/jquery.ccpicker.js') }}"
data-json-path="{{ asset('public/assets/frontend/data.json') }}"></script>
<script>

$("#phoneField1").CcPicker();


const uploadFormFile = document.getElementById("upload-form-file");
    const uploadFormImg = document.getElementById("upload-form-img");
    const uploadFormText = document.getElementById("upload-form-text");

    uploadFormImg.addEventListener("click", function () {
        uploadFormFile.click();
    });

    uploadFormFile.addEventListener("change", function () {
        if (uploadFormFile.value) {
            uploadFormText.innerHTML = uploadFormFile.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];
        } else {
            uploadFormText.innerHTML = "No file chosen, yet.";
        }
    });

</script>
@endpush
