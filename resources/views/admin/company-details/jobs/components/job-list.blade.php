@if (!empty($jobListData) && count($jobListData) > 0)
    @foreach ($jobListData as $jobs)
        <div class="job-posts first-last-handle">
            <div class="job-post-data">
                <a href="{{ route('companyJobDetails', $jobs['jobSlug']) }}">
                    <p class="tm">{{ $jobs['jobTitle'] }}</p>
                </a>
                <p class="ll blur-color">
                    @if (isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote')
                        {{$jobs['jobRemoteWork']}} - {{$jobs['companyCountry']}}
                    @else
                        {{ $jobs['companyCity'] }}{{ $jobs['companyState'] ? ',' . $jobs['companyState'] : '' }}
                    @endif                    
                </p>
                <p class="bm blur-color">{{ $jobs['jobShortDescription'] }}</p>
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
                                <label class="ll">{{ $jobs['jobPending'] }}</label>
                                <span class="bs blur-color">Pending</span>
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
                                <label class="ll">{{ $jobs['jobRejected'] }}</label>
                                <span class="bs blur-color">Rejected</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['amountRequired'] }}</label>
                                <span class="bs blur-color">Total Cost</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['blanace'] }}</label>
                                <span class="bs blur-color">Balance</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-post-status">
                <div class="dropdown status_dropdown"
                    data-color="{{ $jobs['statusColor'] ? $jobs['statusColor'] : '' }}">
                    <button
                        class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn"
                        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                        data-bs-offset="0,12">
                        {{ $jobs['statusText'] ? $jobs['statusText'] : '' }}
                    </button>
                    <ul class="dropdown-menu status_change" aria-labelledby="dropdownMenuButton1">
                        @if ($jobs['companyStatus'] === 3 || $jobs['companyStatus'] === 2)
                            <li>
                                <a class="dropdown-item job-change-status" data-class="open" data-status="1"
                                    data-id="{{ $jobs['jobId'] }}" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Open
                                </a>
                            </li>
                        @endif
                        @if ($jobs['companyStatus'] === 1)
                            <li>
                                <a class="dropdown-item job-change-status" data-class="paused" data-status="3"
                                    data-id="{{ $jobs['jobId'] }}" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Paused
                                </a>
                            </li>
                        @endif
                        @if ($jobs['companyStatus'] === 1)
                            <li>
                                <a class="dropdown-item job-close" data-class="closed"
                                    data-id="{{ $jobs['jobId'] }}" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#closeJob">
                                    <div class="status-round"></div>Closed
                                </a>
                            </li>
                        @endif
                        @if ($jobs['companyStatus'] === 1 || $jobs['companyStatus'] === 3)
                            <li>
                                <a class="dropdown-item job-change-status" data-class="drafted" data-status="2"
                                    data-id="{{ $jobs['jobId'] }}" href="javascript:void(0)" data-toggle="modal"
                                    data-target="#ChageStatusModel">
                                    <div class="status-round"></div>Drafted
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
@endif
