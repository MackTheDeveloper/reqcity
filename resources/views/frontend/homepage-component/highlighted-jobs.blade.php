<div class="job-box-column">
		<a href="{{route('showJobDetails',$highlightedJobsData['jobSlug'])}}" class="job-boxes">
				<p class="tl">{{ (strlen($highlightedJobsData['jobTitle'])>25)? substr($highlightedJobsData['jobTitle'], 0, 25).'...' : $highlightedJobsData['jobTitle']}}</p>
				<span class="tm blur-color">{{ $highlightedJobsData['companyName'] }}</span>
				<span class="tm blur-color">{{ $highlightedJobsData['companyCity'] }}, {{ $highlightedJobsData['companyState'] }}</span>
				<p class="tm">{{ $highlightedJobsData['salaryText'] }} a {{ $highlightedJobsData['salaryType'] }}</p>
				<span class="bm blur-color">{{ $highlightedJobsData['jobDescription'] }}</span>
				<label class="bs blur-color">{{ $highlightedJobsData['postedOn'] }}</label>
		</a>
</div>
