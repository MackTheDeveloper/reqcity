@extends('admin.layouts.master')
<title>Candidate Submit 3</title>
@section('content')
<link rel="stylesheet" href="{{asset('public/assets/frontend/css/jquery.ccpicker.css')}}">
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
              <div class="success-page new-to-old">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">   
                          <img src="assets/img/Sucess-badge.svg" alt="payment success" />
                          <h6>Thank you for your submittal!</h6>
                          <hr class="hr">
                          <p class="bl blur-color">The candidate is submitted successfully and company will review soon.</p>
                          <div class="success-btn-block">
                            <a href="" class=" btn btn-primary">New Submittal</a>
                          </div>
                        </div>
                    </div>
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
