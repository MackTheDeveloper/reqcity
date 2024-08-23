@if(!empty($similarJobs) && count($similarJobs)>0)
@foreach($similarJobs as $jobs)
<div class="activejobs-detaile">
    <div class="job-posts">
        <div class="job-post-data">
            <p class="tm">{{$jobs['jobTitle']}}</p>
            <p class="ll blur-color">{{ $jobs['companyName'] }}</p>
            <p class="ll blur-color">{{$jobs['companyCity']}}{{ $jobs['companyState'] ?', '.$jobs['companyState'] :'' }}{{ $jobs['companyCountry'] ?', '.$jobs['companyCountry'] :'' }}</p>
            <p class="bm blur-color">{{ $jobs['jobShortDescription'] }}</p>
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

                </div>
            </div>
        </div>
        <div class="job-post-status">
            <form class="applyNowCandidate" data-type="downgrade" method="POST" action="{{route('candidateApplyJob',$jobs['jobId'])}}">
                @csrf
                <button class="fill-btn">Apply Now</button>
            </form>
            <label class="bk">
                <input data-job-id="{{ $jobs['jobId'] }}" class="makeFavourite" type="checkbox" {{$jobs['isFavorite'] == 1 ? 'checked' : ''}} />
                <span class="bk-checkmark"></span>
            </label>

        </div>

    </div>
</div>
@endforeach
@else
<div class="activejobs-detaile">
    <div class="job-posts">
        {{config('message.frontendMessages.recordNotFound')}}
    </div>
</div>
@endif