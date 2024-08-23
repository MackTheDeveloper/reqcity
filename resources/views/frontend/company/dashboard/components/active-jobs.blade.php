<div class="active-jobs-dash">
    <div class="active-job-head">
        <h6>Active Jobs</h6>
        <a href="{{url('/company-jobs/open')}}">View All</a>
    </div>
    <span class="full-hr"></span>
    @if(!empty($activeJobs) && count($activeJobs)>0)
    @foreach($activeJobs as $jobs)
    <div class="activejobs-detailed">
        <div class="activejob-titlehead">
            <div class="active-jobtitle">
              <a href="{{route('showCompanyJobDetails',$jobs['jobSlug'])}}">   <p class="tm">{{ $jobs['jobTitle']}}</p></a>
                {{-- <span>{{ $jobs['companyCity'] }} {{ $jobs['companyState'] ? ','.$jobs['companyState'] :'' }}</span> --}}
                <span class="ll blur-color">
                    @if (isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote')
                        {{$jobs['jobRemoteWork']}} - {{$jobs['companyCountry']}}
                    @else
                        {{ $jobs['companyCity'] }}{{ $jobs['companyState'] ? ',' . $jobs['companyState'] : '' }}
                    @endif
                </span>
            </div>
            <div class="mores-dots">
                <div class="dropdown c-dropdown my-playlist-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ asset('public/assets/frontend/img/more-vertical.svg') }}" class="c-icon" />
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{route('showCompanyJobDetails',$jobs['jobSlug'])}}">
                        <!-- <img src="{{ asset('public/assets/frontend/img/Hovered-heart.svg') }}" alt="" /> -->
                        <span>View Detail</span>
                      </a>
                      <!-- <a class="dropdown-item">
                        <img src="{{ asset('public/assets/frontend/img/Hovered-heart.svg') }}" alt="" />
                        <span>Download</span>
                      </a> -->
                    </div>
                </div>
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
                            <label class="ll"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="ll">{{ $jobs['jobPending'] }}</label>
                            <span class="bs blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="bs blur-color">Pending</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="ll">{{ $jobs['jobApproved'] }}</a></label>
                            <span class="bs blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="bs blur-color">Approved</a></span>
                        </div>
                    </div>
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="ll">{{ $jobs['jobRejected'] }}</a></label>
                            <span class="bs blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="bs blur-color">Rejected</a></span>
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
    @endif
</div>
