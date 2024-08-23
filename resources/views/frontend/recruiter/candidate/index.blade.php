@section('title', 'Candidates')
@extends('frontend.layouts.master')
@section('content')
<div class="recruiter-candidates">
    <div class="container">
        <div class="rc-header">
            <h5>Candidates</h5>
            <button class="fill-btn" data-title="Add Candidate" data-toggle="modal" value="{{route('createRecruiterCandidates')}}" id="btnAddRecruiterCandidate">Add Candidate</button>
        </div>
        <div class="rc-data-wrapper">
            <div class="job-header">
                <div class="searchbar-btn">
                    <input type="text" class="input" placeholder="Search for candidate" id="search" />
                    <button class="search-btn"><img src="{{asset('public/assets/frontend/img/white-search.svg')}}" alt="" id="search-btn" /></button>
                </div>

                <div class="sort-by-sec">
                    <p class="bm">Sort by</p>
                    <select class="select" id="posted">
                        <option value="recently">Recently Added</option>
                        <option value="old">Old Candidates</option>
                        <option value="title_asc">A-Z</option>
                        <option value="title_desc">Z-A</option>
                    </select>
                </div>
            </div>


            <div class="div-table-wrapper">
                <div class="div-table" id="magTable">
                    <div class="div-row">
                        <div class="div-column">
                            <p class="ll blur-color">Candidate</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">Phone Number</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">Email</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">City</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">State</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">Country</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">Resume</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">LinkedIn</p>
                        </div>
                        <div class="div-column">
                            <p class="ll blur-color">Action</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.recruiter.candidate.components.add-edit')
@include('frontend.components.delete-confirm',['title'=>'Remove Candidate','message'=>'Are you sure you want to remove the candidate?'])
@endsection
@section('footscript')
<script type="text/javascript" src=""></script>
<script src="{{ asset('/public/assets/frontend/js/magTable.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader-bg').removeClass('d-none');
        var posted = $('#posted').val();
        candidateList('', posted);
    });

    $(document).on('click', '#search-btn', function() {
        var search = $('#search').val();
        var posted = $('#posted').val();
        $('.loader-bg').removeClass('d-none');
        candidateList(search, posted);
    });

    $(document).on('change keydown', '#search', function(e) {
        var search = $('#search').val();
        var posted = $('#posted').val();
        if (e.keyCode === 13) {
            $('.loader-bg').removeClass('d-none');
            candidateList(search, posted);
        }
    });

    $(document).on('change', '#posted', function() {
        var search = $('#search').val();
        var posted = this.value;
        candidateList(search, posted);
    });

    function candidateList(search = '', posted = '') {
        $('#magTable').magTable({
            ajax: {
                "url": "{{ route('recruiterCandidatesList') }}",
                "type": "GET",
                "data": {
                    "search": search,
                    "posted": posted,
                }
            },
            columns: [{
                    data: 'name',
                    name: 'name',
                    render: function(data) {
                        if (data["diverse"] == 1)
                            return '<div class="tag-box"><span class="bm name">' + data['name'] + '</span>' + '<div class="diversity">Diversity</div></div>';
                        else
                            return '<span class="bm name">' + data['name'] + '</span>';
                    },
                },
                {
                    data: 'number',
                    name: 'number',
                    render: function(data) {
                        return '<span class="bm number">' + data + '</span>';
                    },
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data) {
                        return '<span class="bm email">' + data + '</span>';
                    },
                },
                {
                    data: 'city',
                    name: 'city',
                    render: function(data) {
                        return '<span class="bm city">' + data + '</span>';
                    },
                },
                {
                    data: 'state',
                    name: 'state',
                    render: function(data) {
                        return '<span class="bm state">' + data + '</span>';
                    },
                },
                {
                    data: 'country',
                    name: 'country',
                    render: function(data) {
                        return '<span class="bm country">' + data + '</span>';
                    },
                },

            ]
        });
        $('.loader-bg').addClass('d-none');
    }
</script>
@endsection