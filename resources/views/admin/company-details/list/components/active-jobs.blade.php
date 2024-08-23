<div class="active-jobs-dash">
    <div class="active-job-head">
        <h6>Active Jobs</h6>
        <a href="{{route('companyJobsByStatus',[$company->id,'open'])}}">View All</a>
    </div>
    <span class="full-hr"></span>
    @if(!empty($activeJobs) && count($activeJobs)>0)
    @foreach($activeJobs as $jobs)
    <div class="activejobs-detailed">
        <div class="activejob-titlehead">
            <div class="active-jobtitle">
                <a href="{{route('companyJobDetails',$jobs['jobSlug'])}}">
                    <p class="tm">{{ $jobs['jobTitle']}}</p>
                </a>
                <span>{{ $jobs['companyCity'] }} {{ $jobs['companyState'] ? ','.$jobs['companyState'] :'' }}</span>
            </div>
        </div>
        <span class="actjob-address">{{$jobs['jobShortDescription']}}</span>
        <div class="active-jobnumeric">
            <div class="job-table">
                <div class="first-data">
                    <label class="ll">{{ $jobs['salaryText'] }} a {{ $jobs['salaryType'] }}</label>
                    <span class="bs blur-color">{{ $jobs['postedOn'] }}</span>
                </div>
                <div class="last-data">
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll">{{ $jobs['jobOpenings'] }}</label>
                            <span class="bs blur-color">Openings</span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="javascript:void(0)" class="ll">{{ $jobs['jobPending'] }}</label>
                            <span class="bs blur-color"><a href="javascript:void(0)" class="bs blur-color">Pending</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="javascript:void(0)" class="ll">{{ $jobs['jobApproved'] }}</a></label>
                            <span class="bs blur-color"><a href="javascript:void(0)" class="bs blur-color">Approved</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="javascript:void(0)" class="ll">{{ $jobs['jobRejected'] }}</a></label>
                            <span class="bs blur-color"><a href="javascript:void(0)" class="bs blur-color">Rejected</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll">{{$jobs['amountRequired']}}</label>
                            <span class="bs blur-color">Total Cost</span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll">{{$jobs['blanace']}}</label>
                            <span class="bs blur-color">Balance</span>
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
        <p>No Active Jobs Found</p>
        </div>
    </div>  
    @endif
</div>