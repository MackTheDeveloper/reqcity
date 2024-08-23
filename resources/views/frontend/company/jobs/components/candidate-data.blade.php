<div class="candidates">
  <p class="tl">Candidates</p>
  <div class="row">
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5>{{$companyJobOpenings}}</h5>
        <p class="tm blur-color">Openings</p>
      </div>
    </div>
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><a href="{{route('showCompanyCandidate',['jobid'=>$jobDetails->id])}}">{{$companyJobPending}}</a></h5>
        <p class="tm blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobDetails->id])}}" class="tm blur-color">Pending</a></p>
      </div>
    </div>
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><a href="{{route('showCompanyCandidate',['jobid'=>$jobDetails->id])}}">{{$companyJobApproved}}</a></h5>
        <p class="tm blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobDetails->id])}}" class="tm blur-color">Approved</a></p>
      </div>
    </div>
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><a href="{{route('showCompanyCandidate',['jobid'=>$jobDetails->id])}}">{{$companyJobRejected}}</a></h5>
        <p class="tm blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobDetails->id])}}" class="tm blur-color">Rejected</a></p>
      </div>
    </div>
  </div>
</div>
