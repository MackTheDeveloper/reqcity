@if (!empty($jobListData) && count($jobListData) > 0)
    @foreach ($jobListData as $jobs)
        <div class="job-posts">
            <div class="job-post-data w-100 p-0">
                <p class="tm">{{ $jobs['jobTitle'] }} ({{$jobs['companyName']}})</p>
                <p class="ll blur-color">
                    @if (isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote')
                        {{$jobs['jobRemoteWork']}} - {{$jobs['companyCountry']}}
                    @else
                        {{ $jobs['companyCity'] }}{{ $jobs['companyState'] ? ', ' . $jobs['companyState'] : '' }}{{ $jobs['companyCountry'] ? ', ' . $jobs['companyCountry'] : '' }}
                    @endif

                </p>
                <p class="bm blur-color">{!! str_replace(['<p>', '</p>'], '', $jobs['jobShortDescription']) !!}</p>
                <div class="job-table">
                    <div class="first-data">
                        <label class="ll">{{ $jobs['salaryText'] }} a {{ $jobs['salaryType'] }}</label>
                        <span class="bs blur-color">{{ $jobs['postedOn'] }}</span>
                    </div>
                    <div class="last-data m-0">
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobOpenings'] }}</label>
                                <span class="bs blur-color">Openings</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobApproved'] }}</label>
                                <span class="bs blur-color">Approved</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobRemainingApprovals'] }}</label>
                                <span class="bs blur-color">Remaining Approvals</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobMyApproved'] }}</label>
                                <span class="bs blur-color">My Approved</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobMyRejected'] }}</label>
                                <span class="bs blur-color">My Rejected</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobMyPending'] }}</label>
                                <span class="bs blur-color">My Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
