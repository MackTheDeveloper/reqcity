@extends('admin.layouts.master')
<title>Candidate Submit 1</title>
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
                                                Candidate Submit 1
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="process-progress">
                    <div class="info-progress ">
                        <div class="numbers">1</div>
                        <p class="tm">Candidate Details</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">2</div>
                        <p class="tm">Questionnaire</p>
                    </div>
                    <div class="info-progress ">
                        <div class="numbers">3</div>
                        <p class="tm">Review Submittal</p>
                    </div>
                </div>
                

                <h4 class="form-title-text">Candidate Submittal</h4>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title-wrapper">
                            <h5 class="card-title">Candidate info</h5>
                            <button type="submit" class="btn btn-primary plr-16" data-toggle="modal" data-target="#viewDetailModal">View Details</button>
                        </div>
                        <form>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">First name</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter First Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Last name</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter Last name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Phone Number</label>
                                        <span class="text-danger">*</span>
                                        <div class="phone-field-wrapper">
                                            <input type="text" id="phoneField1" name="phoneField1" class="phone-field form-control" placeholder="Enter Phone Number"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Country
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <select name="country" class="form-control">
                                                <option value="1" selected="">United States</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">City</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter City">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 ck-section">
                                    <label class="ck">Diversity
                                        <input type="checkbox" checked="checked" id="remember">
                                        <span class="ck-mark"></span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label class="font-weight-bold color-blur">Upload resume for Nutrify, Inc.</label>
                                    <div class="upload-form-btn2">
                                        <input type="file" id="upload-form-file" hidden="hidden" />
                                        <img src="../../../public/assets/frontend/img/upload-icon.svg" id="upload-form-img" alt="" />
                                        <div>
                                            <p class="tm" id="upload-form-text">Upload resume</p>
                                            <span class="bs blur-color">Use a pdf, docx, doc, rtf and
                                                txt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="font-weight-bold color-blur">LinkedIn</label>
                                    <div class="form-group">
                                        <label class="font-weight-bold">LinkedIn profile link</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="url" pattern="https://.*" class="form-control" placeholder="Enter LinkedIn profile link">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <label class="font-weight-bold color-blur mb-16">Candidate experience</label>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Job Title</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter Job Title">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Company</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" placeholder="Enter Company">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start year
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <select name="country" class="form-control">
                                                        <option value="1" selected="">Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start month
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <select name="country" class="form-control">
                                                        <option value="1" selected="">Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End year
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <select name="country" class="form-control">
                                                        <option value="1" selected="">Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End month
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <select name="country" class="form-control">
                                                        <option value="1" selected="">Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Job Responsibilities
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div>
                                            <textarea class="form-control" placeholder="Enter Job Title"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 ck-section">
                                    <label class="ck">I am currently working in this role
                                        <input type="checkbox" checked="checked" id="remember">
                                        <span class="ck-mark"></span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-12 text-right">
                                    <button class="blue-btn"><img src="assets/img/blue-plus.svg" alt="">Add experience</button>
                                </div>
                                <div class="col-sm-12 add-pad-top">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="add_pkg_btn">Update</button>
                                        <a href="http://localhost/reqcity/securerccontrol/job-fields/index">
                                            <button type="button" class="btn btn-light" name="cancel" value="Cancel">Cancel</button>
                                        </a>
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
