<div class="tab-section" id="navbar-example2">
  <ul>
    <input type="hidden" value="{{$status}}" name="status" id="status" />
    <li><a href="{{route('companyJobsByStatus',[$company->id])}}" id="all" class="tab-link active">All</a></li>
    <li><a href="{{route('companyJobsByStatus',[$company->id,'open'])}}" id="open" class="tab-link">Open</a></li>
    <li><a href="{{route('companyJobsByStatus',[$company->id,'paused'])}}" id="paused" class="tab-link">Paused</a></li>
    <li><a href="{{route('companyJobsByStatus',[$company->id,'closed'])}}" id="closed" class="tab-link">Closed</a></li>
    <li><a href="{{route('companyJobsByStatus',[$company->id,'draft'])}}" id="draft" class="tab-link">Draft</a></li>
  </ul>
</div>