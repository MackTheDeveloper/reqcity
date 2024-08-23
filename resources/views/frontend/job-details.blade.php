@section('title','Job Details')
@extends('frontend.layouts.master')
@section('content')
@if (Auth::check())
    @php($authenticateClass = ' applyNowCandidate')
@else
    @php($authenticateClass = ' loginBeforeGo')
@endif
<div class="recruiter-job-details candidate-job-details">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-xl-9 order-2 order-lg-1">
        <div class="req-job-header">
          <a href="{{route('searchFront')}}" class="back-to-link bm">
            <img src="{{ asset('public/assets/frontend/img/arrow-left.svg') }}" alt="" />Back to all jobs
          </a>
          <div class="candidate-img-content">
            <img src="{{ $companyDetails->logo }}" alt="" />
            <div>
              <p class="tm">{{$companyDetails->name}}</p>
              @if($jobData->CompanyAddress)
              <span class="ts">{{$jobData->CompanyAddress->city}}{{ $jobData->CompanyAddress->state ? ', '.$jobData->CompanyAddress->state :''}}{{ $jobData->CompanyAddress->countries->name ? ', '.$jobData->CompanyAddress->countries->name :''}}</span>
              @endif
            </div>
          </div>
          <h6>{{$jobDetails->title}}</h6>
          @if($jobDetails->hide_compensation_details_to_candidates=='no')
          <p class="ll">{{$salary}} a {{$jobDetails->salary_type}}</p>
          @endif
          <span class="bs blur-color">{{$postedOn}}</span>

          <hr class="hr">

          <div class="req-job-descripation">
            <div class="jd-header">
              <p class="tl">Job Description</p>
              {!!$jobDetails->job_description!!}
            </div>
              <table class="table-content-data">
                <tr>
                  <td>Employment type</td>
                  <td>@if(!empty($employmentType)){{$employmentType->option ? $employmentType->option :''}}@endif</td>
                </tr>
                <tr>
                  <td>Schedule</td>
                  <td>{{$scheduleData ? $scheduleData :''}}</td>
                </tr>
                <tr>
                  <td>Contract type</td>
                  <td>@if(!empty($contractType)){{$contractType->option ? $contractType->option :''}}@endif</td>
                </tr>
                <tr>
                  <td>Contract duration</td>
                  <td>{{$jobDetails->contract_duration ? $jobDetails->contract_duration :''}} {{($jobDetails->contract_duration_type == '1') ? 'Months' : 'Years'}}</td>
                </tr>
                @if(!empty($remoteWork))
                <tr>
                  <td>Remote work</td>
                  <td>{{$remoteWork->option ? $remoteWork->option:''}}</td>
                </tr>
                @endif
              </table>

              <div class="frequent-question">
                <p class="tl">Frequently asked questions</p>
                @foreach($companyJobFaq as $faqs)
                <div class="que-ans">
                  <p class="tm">{{$faqs['question']}}</p>
                  <span class="bm">{{$faqs['answer']}}</span>
                </div>
                @endforeach
              </div>

          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-4 col-xl-3 order-1 order-lg-2">
        <div class="req-job-post-box">
          @if(!Auth::check() || Auth::user()->role_id == 5)
          <div class="job-post-status">
            @if($isApplied!=1)

                <a data-job-id="{{ $jobDetails->id }}" class="fill-btn  {{ $authenticateClass }}" data-type="applyJob" >Apply Now</a>

            @else
            <button class="fill-btn" disabled>Applied</button>
            @endif
            <label class="bk">
                <input data-job-id="{{ $jobDetails->id }}" data-type="favJob" class="makeFavourite" type="checkbox" {{$isFavorite == 1 ? 'checked' : ''}} />
              <span class="bk-checkmark"></span>
            </label>
          </div>
            <hr class="hr">
          @endif
          <!-- <div class="job-post-status">
            <button class="fill-btn">Apply Now</button>
            <label class="bk">
              <input type="checkbox" />
              <span class="bk-checkmark"></span>
            </label>
          </div> -->

          <table class="table-content-data last-blur">
            <tr>
              <td>Opening</td>
              <td>{{$companyJobOpenings}}</td>
            </tr>
          </table>
        </div>
        @if(!empty($companyDetails->why_work_here) || !empty($companyDetails->about))
        <div class="why-about hide-991">
          @if(!empty($companyDetails->why_work_here))
          <div class="this-key-value">
            <p class="tl">Why work here</p>
            <span class="bm">{{$companyDetails->why_work_here	}}</span>
          </div>
          @endif
          @if(!empty($companyDetails->about))
          <div class="this-key-value">
            <p class="tl">About Us</p>
            <span class="bm">{{$companyDetails->about	}}</span>
          </div>
          @endif
        </div>
        @endif
      </div>
      <div class="col-12 show-991 order-3">
        <div class="why-about">
          <div class="this-key-value">
            <p class="tl">Why work here</p>
            <span class="bm">{{$companyDetails->why_work_here	}}</span>
          </div>
          <div class="this-key-value">
            <p class="tl">About Us</p>
            <span class="bm">{{$companyDetails->about	}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('frontend.candidate.jobs.components.apply-modal')
@section('footscript')
<script type="text/javascript">

  $(document).on("click", ".makeFavourite", function(e) {
      var jobId = $(this).attr('data-job-id');
      $.ajax({
          url: "{{ url('/candidate-jobs/make-favorite') }}",
          type: "POST",
          data: {
              jobId: jobId,
              _token: '{{csrf_token()}}'
          },
          success: function(response) {
              toastr.clear();
              toastr.options.closeButton = true;
              toastr.success(response.message);
          },
      });
  });

  $(document).on('click','.applyNowCandidate',function (e) {
          e.preventDefault();
          var jobId = $(this).attr('data-job-id');
          $("#applyJob #applyConfirmed input#jobId").val(jobId);
          $("#applyJob").modal('show');
  });
</script>
@endsection
