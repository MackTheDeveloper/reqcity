<div class="active-jobs-dash">
  <div class="active-job-head">
    <h6>Candidates</h6>
    <a href="{{route('recruiterCandidatesInPortal',$recruiters['recruiterId'])}}">View All</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>Candidate</th>
          <th>Phone Number</th>
          <th>Email</th>
          <th>City</th>
          <th>Country</th>
          <th>Resume</th>
          <th>LinkedIn</th>
        </tr>
      </thead>
      <tbody>
        @if($recruiterCandidates)
        @foreach($recruiterCandidates as $recruiterCandidate)
        <tr>
          <td>{{$recruiterCandidate['name']}}</td>
          <td>{{$recruiterCandidate['number']}}</td>
          <td>{{$recruiterCandidate['email']}}</td>
          <td>{{$recruiterCandidate['city']}}</td>
          <td>{{$recruiterCandidate['country']}}</td>
          <td>{!! $recruiterCandidate['resumeCv'] !!}</td>
          <td>{!! $recruiterCandidate['linkedIn'] !!}</td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="7">No records found</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>

</div>