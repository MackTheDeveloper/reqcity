@foreach($companies['companies'] as $k => $v)
<div class="cpc-card">
  <img src="{{$v['companyLogo']}}" alt="" />
  <div class="this-content">
    <div class="company-list-header">
      <a href="{{whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_view')?route('companyViewDetails',$v['companyId']):'javascript:void(0)'}}"><p class="tl">{{$v['companyName']}}</p></a>
      <div class="button-options pull-right dropdown">
        <button class="btn-icon btn-square btn btn-primary btn-sm getLoginLink" data-id="{{$v['companyId']}}">Login</button>
        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="threedot-toggle">
            <img src="{{asset('public/assets/frontend/img/more-vertical.svg')}}" class="c-icon">
        </button>
        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
            <ul class="nav flex-column">
              <li class="nav-item"><a data-id="{{$v['companyId']}}" class="assignManager nav-link" href="javascript:void(0)">Assign Account Manager</a></li>
              <li class="nav-item"><a data-id="{{$v['companyId']}}" class="delete-company nav-link" href="javascript:void(0)">Delete</a></li>
            </ul>
        </div>
      </div>
    </div>
    <span class="ts blur-color">{{$v['companyCity']}}{{ $v['companyState'] ?', '.$v['companyState'] :'' }}{{ $v['companyCountry'] ?', '.$v['companyCountry'] :'' }}</span>
    <span class="bm ">{{$v['aboutCompany']}}</span>
    <div class="last-data">
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll">{{$v['activeJobsCount']}}</label>
          <span class="bs blur-color">Active Jobs</span>
        </div>
      </div>
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll">{{ucfirst($v['currentSubscription'])}}</label>
          <span class="bs blur-color">Subscription</span>
        </div>
      </div>
      <div class="job-table-data">
        <div class="jtd-wrapper">
          <label class="ll">{{$v['activeJobsBalance']}}</label>
          <span class="bs blur-color">Balance</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach