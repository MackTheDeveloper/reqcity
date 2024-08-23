<div class="active-jobs-dash">
  <div class="active-job-head">
    <h6>Jobs with Submittals</h6>
    <a href="{{route('recruiterJobListInPortal',[$recruiters['recruiterId'],'submitted'])}}">View All</a>
  </div>
  @if(!empty($jobListData) && count($jobListData)>0)
  @foreach($jobListData as $jobs)
  <div class="activejobs-detailed">
    <div class="activejob-titlehead">
      <div class="active-jobtitle">
        <p class="tm">{{$jobs['jobTitle']}}</p>
        <span>{{$jobs['companyName']}}</span>
        <span>{{$jobs['companyCity']}}{{ $jobs['companyState'] ?', '.$jobs['companyState'] :'' }}{{ $jobs['companyCountry'] ?', '.$jobs['companyCountry'] :'' }}</span>
      </div>
    </div>
    <span class="actjob-address">{!!str_replace(['<p>', '</p>'], '',$jobs['jobShortDescription'])!!}</span>
    <div class="active-jobnumeric">
      <div class="job-table">
        <div class="first-data">
          <label class="ll">{{$jobs['salaryText']}} a {{$jobs['salaryType']}}</label>
          <span class="bs blur-color">{{$jobs['postedOn']}}</span>
        </div>
        <div class="last-data">
          <div class="job-table-data">
            <div class="jtd-wrapper">
              <label class="ll">{{$jobs['jobOpenings']}}</label>
              <span class="bs blur-color">Openings</span>
            </div>
          </div>
          <div class="job-table-data">
            <div class="jtd-wrapper">
              <label class="ll">{{$jobs['jobApproved']}}</label>
              <span class="bs blur-color">Approved</span>
            </div>
          </div>
          <div class="job-table-data">
            <div class="jtd-wrapper">
              <label class="ll">{{$jobs['jobRemainingApprovals']}}</label>
              <span class="bs blur-color">Remaining Approvals</span>
            </div>
          </div>
          <div class="job-table-data">
            <div class="jtd-wrapper">
              <label class="ll">{{$jobs['jobMyApproved']}}</label>
              <span class="bs blur-color">My Approved</span>
            </div>
          </div>
          <div class="job-table-data">
            <div class="jtd-wrapper">
              <label class="ll">{{$jobs['jobMyRejected']}}</label>
              <span class="bs blur-color">My Rejected</span>
            </div>
          </div>
          <div class="job-table-data">
            <div class="jtd-wrapper">
              <label class="ll">{{$jobs['jobMyPending']}}</label>
              <span class="bs blur-color">My Pending</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  @endforeach
  @else
  <div class="activejobs-detailed">
    <div class="activejob-titlehead">
    <p>No Jobs Found</p>
  </div>
  </div>
  @endif
</div>