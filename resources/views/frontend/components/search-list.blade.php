@if (Auth::check())
    @php($authenticateClass = '')
@else
    @php($authenticateClass = 'loginBeforeGo')
@endif
@if(!empty($jobListData) && count($jobListData)>0)
@foreach($jobListData as $jobs)
<div class="job-posts-row">
  <div class="job-post-data">
    <a href="{{route('showJobDetails',$jobs['jobSlug'])}}"> <p class="tm">{{ $jobs['jobTitle'] }} ({{$jobs['companyName']}})</p></a>
    {{-- <p class="ll blur-color">{{$jobs['companyName']}}</p> --}}
    <p class="ll blur-color">
      @if (isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote')
        {{$jobs['jobRemoteWork']}} - {{$jobs['companyCountry']}}
      @else
        {{$jobs['companyCity']}}{{ $jobs['companyState'] ?','.$jobs['companyState'] :'' }}
      @endif
    </p>
    <p class="bm blur-color">{{$jobs['jobShortDescription']}}</p>
    <div class="job-table">
      <div class="first-data">
        @if(empty($jobs['isHidecompensationDetails']) || $jobs['isHidecompensationDetails']=='no')
        <label class="ll">{{$jobs['salaryText']}} a {{$jobs['salaryType']}}</label>
        @endif
        <span class="bs blur-color">{{ $jobs['postedOn'] }}</span>
      </div>
      <div class="last-data">
        <div class="job-table-data">
          <div class="jtd-wrapper">
            <label class="ll">{{ $jobs['jobOpenings'] }}</label>
            <span class="bs blur-color">Openings</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(!Auth::check() || Auth::user()->role_id == 5)
  <div class="job-post-status">
    @if($jobs['isApplied']!=1)
  <form data-job-id="{{ $jobs['jobId'] }}" class="applyNowCandidate {{ $authenticateClass }}" data-type="applyJob" >
        @csrf
        <button class="fill-btn">Apply Now</button>
    </form>
    @else
    <button class="fill-btn" disabled>Applied</button>
    @endif
    <label class="bk">
        <input data-job-id="{{ $jobs['jobId'] }}" data-type="favJob" class="makeFavourite {{$authenticateClass}}" type="checkbox" {{$jobs['isFavorite'] == 1 ? 'checked' : ''}} />
      <span class="bk-checkmark"></span>
    </label>
  </div>
  @endif

</div>
@include('frontend.components.delete-confirm',['title'=>'Confirm','message'=>'Are you sure?'])
@include('frontend.candidate.jobs.components.apply-modal')
@endforeach
@endif
