@foreach($recruiters['recruiters'] as $k => $v)
<div class="cpc-card withot-img">
  <div class="this-content">
    <a href="{{whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_view')?route('recruiterViewDetails',$v['recruiterId']):'javascript:void(0)'}}"><p class="tl">{{$v['recruiterName']}}</p></a>
    <div class="number-email-add">
      <p>{{$v['phoneExt'].' '.$v['phone']}}</p>
      <p>{{$v['recruiterEmail']}}</p>
      <p>
        @php($address=[])
        @php($address[]=$v['recruiterAddress1'])
        @php($address[]=$v['recruiterAddress2'])
        @php($address[]=$v['recruiterCity'])
        @php($address[]=$v['recruiterState'])
        @php($address[]=$v['recruiterCountry'])
        @php($address = array_filter($address))
        {{implode(', ',$address)}}
      </p>
      <!-- <p>2327 16th Ave, Hillside, IL 60142, United States</p> -->
    </div>
    <div class="last-data">
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll">{{'$'.$v['totalPayout']}}</label>
          <span class="bs blur-color">Total Payout</span>
        </div>
      </div>
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll">{{'$'.$v['amountDue']}}</label>
          <span class="bs blur-color">Amount Due</span>
        </div>
      </div>
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll">{{$v['approvedCandidates']}}</label>
          <span class="bs blur-color">Approved <br> Candidates</span>
        </div>
      </div>
    </div>
  </div>
  <p class="blur-color tk">{{$v['recruiterUniqueId']}}</p>
  <div class="button-options pull-right dropdown">
        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="threedot-toggle">
            <img src="{{asset('public/assets/frontend/img/more-vertical.svg')}}" class="c-icon">
        </button>
        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
            <ul class="nav flex-column">
              <li class="nav-item"><a data-id="{{$v['recruiterId']}}" class="delete-recruiter nav-link" href="javascript:void(0)">Delete</a></li>
            </ul>
        </div>
      </div>
</div>
@endforeach