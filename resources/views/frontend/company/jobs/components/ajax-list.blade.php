@if(!empty($jobListData) && count($jobListData)>0)
@foreach($jobListData as $jobs)
<div class="job-posts">
  <div class="job-post-data">
    <a href="{{url('/company-job-details/')}}/{{$jobs['jobSlug']}}">  <p class="tm">{{$jobs['jobTitle']}}</p></a>
    <p class="ll blur-color">{{$jobs['companyCity']}}{{ $jobs['companyState'] ?','.$jobs['companyState'] :'' }}</p>
    <p class="bm blur-color">{{$jobs['jobShortDescription']}}</p>
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
            <label class="ll"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="ll">{{$jobs['jobPending']}}</a></label>
            <span class="bs blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="bs blur-color">Pending</a></span>
          </div>
        </div>
        <div class="job-table-data">
          <div class="jtd-wrapper">
            <label class="ll"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="ll">{{$jobs['jobApproved']}}</a></label>
            <span class="bs blur-color"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="bs blur-color">Approved</a></span>
          </div>
        </div>
        <div class="job-table-data">
          <div class="jtd-wrapper">
            <label class="ll"><a href="{{route('showCompanyCandidate',['jobid'=>$jobs['jobId']])}}" class="ll">{{$jobs['jobRejected']}}</a></label>
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
  <div class="job-post-status">
    <div class="dropdown status_dropdown" data-color="{{ $jobs['statusColor'] ? $jobs['statusColor'] : '' }}">
      <button class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn"
        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
        data-bs-offset="0,12">
        {{ $jobs['statusText'] ? $jobs['statusText'] : '' }}
      </button>
      <ul class="dropdown-menu status_change" aria-labelledby="dropdownMenuButton1">
        @if($jobs['companyStatus'] === 3 || $jobs['companyStatus'] === 2)
        <li>
          <a class="dropdown-item job-change-status" data-class="open" data-status="1" data-id="{{$jobs['jobId']}}" href="javascript:void(0)" data-toggle="modal" data-target="#ChageStatusModel">
            <div class="status-round"></div>Open
          </a>
        </li>
        @endif
        @if($jobs['companyStatus'] === 1 )
        <li>
          <a class="dropdown-item job-change-status" data-class="paused" data-status="3" data-id="{{$jobs['jobId']}}" href="javascript:void(0)" data-toggle="modal" data-target="#ChageStatusModel">
            <div class="status-round"></div>Paused
          </a>
        </li>
        @endif
        @if($jobs['companyStatus'] === 1)
        <li>
          <a class="dropdown-item job-close" data-class="closed" data-id="{{$jobs['jobId']}}" href="javascript:void(0)" data-toggle="modal"
              data-target="#closeJob">
              <div class="status-round"></div>Closed
          </a>
        </li>
        @endif
        @if($jobs['companyStatus'] === 1 || $jobs['companyStatus'] === 3)
        <li>
          <a class="dropdown-item job-change-status" data-class="drafted" data-status="2" data-id="{{$jobs['jobId']}}" href="javascript:void(0)" data-toggle="modal" data-target="#ChageStatusModel">
              <div class="status-round"></div>Drafted
          </a>
        </li>
        @endif
      </ul>
    </div>

    <div class="dropdown c-dropdown my-playlist-dropdown">
      <button class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="{{ asset('public/assets/frontend/img/more-vertical.svg') }}" class="c-icon" />
      </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{route('showCompanyJobDetails',$jobs['jobSlug'])}}">
          <!-- <img src="{{ asset('public/assets/frontend/img/Hovered-heart.svg') }}" alt="" /> -->
          @if($jobs['status']==2)
            <span>Edit & Publish Job</span>
          @else
            <span>View Detail</span>
          @endif
        </a>
        <!-- <a class="dropdown-item">
          <img src="{{ asset('public/assets/frontend/img/Hovered-heart.svg') }}" alt="" />
          <span>Download</span>
        </a> -->
      </div>
    </div>
  </div>
</div>
@endforeach
@endif
