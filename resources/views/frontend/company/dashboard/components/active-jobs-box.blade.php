<div class="actjobs-boxstatus">
    <div class="row">
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="{{url('/company-jobs/open')}}"><h5>{{$activeJobsCount}}</h5></a>
                <span>Active jobs</span>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="{{url('/company-jobs/closed')}}"><h5>{{$closedJobsCount}}</h5></a>
                <span>Closed jobs</span>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="{{url('/company-jobs/paused')}}"><h5>{{$pausedJobsCount}}</h5></a>
                <span>Paused jobs</span>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="{{url('/company-jobs/draft')}}"><h5>{{$unpublishedJobsCount}}</h5></a>
                <span>Unpublished Jobs</span>
            </div>
        </div>
    </div>
</div>
