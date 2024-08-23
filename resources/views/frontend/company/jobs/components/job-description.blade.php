<div class="job-descripation">
  <div class="jd-header">
    <p class="tl">Job Description</p>
    <!-- <p class="bm">{!!$jobDetails->job_description!!}</p> -->
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
  @if(!empty($companyJobFaq) && count($companyJobFaq)>0)
    @include('frontend.company.jobs.components.job-faqs')
  @endif
</div>
