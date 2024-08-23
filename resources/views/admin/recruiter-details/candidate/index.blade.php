@extends('admin.layouts.master')
<title>{{config('app.name_show')}} | Recruiter Candidates</title>

@section('content')
@include('admin.include.header')
<div class="app-main">
    @include('admin.include.sidebar')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title app-page-title-simple">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div>
                            <div class="page-title-subheading opacity-10">
                                <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{route('recruiters')}}" style="color: grey">Recruiter Portal</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{route('recruiterViewDetails',$recruiters['recruiterId'])}}" style="color: grey">{{$recruiters['recruiterName']}}</a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a style="color: slategray">Candidates
                                            </a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table id="Tdatatable" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>Candidate</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Resume</th>
                                <th>LinkedIn</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        @include('admin.include.footer')
    </div>
</div>
@endsection

@push('scripts')
<script>
    let token = '{{ csrf_token() }}';
    let userIdofRecruiter = '{{$userIdofRecruiter}}';
</script>
<script src="{{asset('public/assets/js/recruiter/recruiter-candidates.js')}}"></script>
@endpush