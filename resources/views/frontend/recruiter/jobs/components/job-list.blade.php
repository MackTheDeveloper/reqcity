@if (!empty($jobListData) && count($jobListData) > 0)
    @foreach ($jobListData as $jobs)
        <div class="job-posts">
            <div class="job-post-data">
                <a href="{{ route('recruiterJobsDetail', $jobs['jobSlug']) }}">
                    <p class="tm">{{ $jobs['jobTitle'] }} ({{$jobs['companyName']}})</p>
                </a>
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
                    <div class="last-data">
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
                                @if (!empty($jobs['jobMyApprovedList']))
                                    <div class="hoverd-data-wrapper">
                                        <div class="hoverd-data-outer">
                                            <div class="hoverd-data-inner">
                                                <ul>
                                                    @foreach ($jobs['jobMyApprovedList'] as $k => $v)
                                                        <li>
                                                            <a href="">
                                                                <span
                                                                    class="bm">{{ $v['full_name'] }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobMyRejected'] }}</label>
                                <span class="bs blur-color">My Rejected</span>
                                @if (!empty($jobs['jobMyRejectedList']))
                                    <div class="hoverd-data-wrapper">
                                        <div class="hoverd-data-outer">
                                            <div class="hoverd-data-inner">
                                                <ul>
                                                    @foreach ($jobs['jobMyRejectedList'] as $k => $v)
                                                        <li>
                                                            <a href="">
                                                                <span
                                                                    class="bm">{{ $v['full_name'] }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobMyPending'] }}</label>
                                <span class="bs blur-color">My Pending</span>
                                @if (!empty($jobs['jobMyPendingList']))
                                    <div class="hoverd-data-wrapper">
                                        <div class="hoverd-data-outer">
                                            <div class="hoverd-data-inner">
                                                <ul>
                                                    @foreach ($jobs['jobMyPendingList'] as $k => $v)
                                                        <li>
                                                            <a href="">
                                                                <span
                                                                    class="bm">{{ $v['full_name'] }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-post-status">
                <a href="{{ route('recruiterCandidateSubmitStart', $jobs['jobSlug']) }}" class="fill-btn">Submit
                    Candidate</a>
                <label class="bk">
                    <input type="checkbox" data-job-id="{{ $jobs['jobId'] }}" class="makeFavourite"
                        {{ $jobs['isFavorite'] == 1 ? 'checked' : '' }} />
                    <span class="bk-checkmark"></span>
                </label>
            </div>
        </div>
    @endforeach
@endif
