<div class="job-descripation">
  <div class="jd-header">
      <p class="tl">Job Description</p>
      <a class="pull-right editJobDetail" data-toggle="modal" data-target="#jobDescriptionChange" href="javascript:void(0)"><i class="fa fa-edit"></i></a>
  </div>
  <div>{!!$jobDetails->job_description!!}</div>
  


  <table class="table-content-data table">
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
  @include('admin.company-details.jobs.components.job-faqs')
  @endif
</div>