@if (!empty($favoriteJobs) && count($favoriteJobs) > 0)
    @foreach ($favoriteJobs as $jobs)
        <div class="activejobs-detailed">
            <div class="activejob-titlehead">
                <div class="active-jobtitle">
                    <a href="{{ route('recruiterJobsDetail', $jobs['jobSlug']) }}">
                        <p class="tm">{{ $jobs['jobTitle'] }}</p>
                    </a>
                    <span>{{ $jobs['companyName'] }}</span>
                    {{-- <span>{{ $jobs['companyCity'] }} {{ $jobs['companyState'] ? ','.$jobs['companyState'] :'' }}</span> --}}
                    <span>
                        @if (isset($jobs['jobRemoteWork']) && $jobs['jobRemoteWork'] == 'Remote')
                            {{ $jobs['jobRemoteWork'] }} - {{ $jobs['companyCountry'] }}
                        @else
                            {{ $jobs['companyCity'] }}{{ $jobs['companyState'] ? ', ' . $jobs['companyState'] : '' }}{{ $jobs['companyCountry'] ? ', ' . $jobs['companyCountry'] : '' }}
                        @endif
                    </span>
                </div>
                <div class="mores-dots">
                    <div class="dropdown c-dropdown my-playlist-dropdown">
                        <button class="dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ asset('public/assets/frontend/img/more-vertical.svg') }}"
                                class="c-icon" />
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('recruiterJobsDetail', $jobs['jobSlug']) }}">
                                <!-- <img src="{{ asset('public/assets/frontend/img/Hovered-heart.svg') }}" alt="" /> -->
                                <span>View Detail</span>
                            </a>
                            <!-- <a class="dropdown-item">
                        <img src="{{ asset('public/assets/frontend/img/Hovered-heart.svg') }}" alt="" />
                        <span>share</span>
                    </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <span class="actjob-address">{{ $jobs['jobShortDescription'] }}</span>
            <div class="active-jobnumeric">
                <div class="job-table">
                    <div class="first-data">
                        <label class="ll">{{ $jobs['salaryText'] }} a {{ $jobs['salaryType'] }}</label>
                        <span class="bs blur-color">{{ $jobs['postedOn'] }} </span>
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
                                <label class="ll">{{ $jobs['jobMyApproved'] }}</label>
                                <span class="bs blur-color">Approved</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobMyRejected'] }}</label>
                                <span class="bs blur-color">Rejected</span>
                            </div>
                        </div>
                        <div class="job-table-data">
                            <div class="jtd-wrapper">
                                <label class="ll">{{ $jobs['jobPayout'] }}</label>
                                <span class="bs blur-color">Payout</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
@endif
