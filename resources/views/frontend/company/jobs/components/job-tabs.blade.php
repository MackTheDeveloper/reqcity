<div class="tab-wrapper">
  <div class="container">
    <div class="tab-section" id="navbar-example2">
      <ul>
        <input type="hidden" value="{{$status}}" name="status" id="status"/>
        <li><a href="{{url('/company-jobs/')}}" id="all" class="tab-link active">All</a></li>
        <li><a href="{{url('/company-jobs/open')}}" id="open" class="tab-link">Open</a></li>
        <li><a href="{{url('/company-jobs/paused')}}" id="paused" class="tab-link">Paused</a></li>
        <li><a href="{{url('/company-jobs/closed')}}" id="closed" class="tab-link">Closed</a></li>
        <li><a href="{{url('/company-jobs/draft')}}" id="draft" class="tab-link">Draft</a></li>
      </ul>
    </div>
  </div>
</div>
