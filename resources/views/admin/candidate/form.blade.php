@extends('admin.layouts.master')
<title>{{ config('app.name_show') }} | Candidates </title>

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
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="active_icon metismenu-icon pe-7s-cash"></i>
                                    </span>
                                    <span class="d-inline-block">Candidates</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('adminDashboard') }}">
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="javascript:void(0);" style="color: grey">Candidates</a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page">
                                                <a style="color: slategray">Edit</a>
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
                        <h5 class="card-title">Candidate Information</h5>
                        @if (Session::has('msg'))
                            <div class="alert {{ Session::get('alert-class') == true ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show"
                                role="alert">
                                {{ Session::get('msg') }}
                                <button type="button" class="close session_error" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form id="addNewUser" method="post" action="{{ route('candidateUpdate',$candidate->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <div>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                placeholder="Enter first name" value="{{ $candidate->first_name }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <div>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                placeholder="Enter Last name" value="{{ $candidate->last_name }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Enter Email" disabled value="{{ $candidate->email }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <div class="row">
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="phone_ext" name="phone_ext"
                                                    placeholder="+1" value="{{ $candidate->phone_ext }}" />
                                            </div>
                                            <div class="col-10">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    placeholder="Enter phone" value="{{ $candidate->phone }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_title">Job Title</label>
                                        <div>
                                            <input type="text" class="form-control" id="job_title" name="job_title"
                                                placeholder="Enter Job Title" value="{{ $candidate->job_title }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <div>
                                            <select class="form-control" id="country" name="country">
                                                <option value="0">Please Select...</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country['key'] }}"
                                                        {{ $candidate->country == $country['key'] ? 'selected' : '' }}>
                                                        {{ $country['value'] }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" class="form-control" id="country" name="country" placeholder="Enter Last name" value="{{$candidate->country}}"/> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_1">Address Line 1</label>
                                        <div>
                                            <input type="text" class="form-control" id="address_1" name="address_1"
                                                placeholder="Enter Address Line 1" value="{{ $candidate->address_1 }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_2">Address Line 2</label>
                                        <div>
                                            <input type="text" class="form-control" id="address_2" name="address_2"
                                                placeholder="Enter Address Line 2" value="{{ $candidate->address_2 }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <div>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Enter City" value="{{ $candidate->city }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postcode">Zipcode</label>
                                        <div>
                                            <input type="text" class="form-control" id="postcode" name="postcode"
                                                placeholder="Enter Zipcode" value="{{ $candidate->postcode }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linkedin_profile_link">LinkedIn</label>
                                        <div>
                                            <input type="text" class="form-control" id="linkedin_profile_link"
                                                name="linkedin_profile_link" placeholder="Enter Linkedin Profile Link"
                                                value="{{ $candidate->linkedin_profile_link }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="resume">Resume</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="file" id="resume" name="resume" />
                                            </div>
                                            @if ($resume)
                                                <div class="col-6">
                                                    <a href="{{ $resume->resume }}" target="_blank"><img src="{{asset('public/assets/frontend/img/pdf-orange.svg')}}" /></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Profile Photo</label>
                                        <div>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Enter Email" value="{{ $candidate->email }}" />
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('candidateListing') }}"><button type="button" class="btn btn-light"
                                        name="cancel" value="Cancel">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>

    </div>
@endsection
@section('modals-content')
@endsection
<style>
    .hide_column {
        display: none;
    }

</style>

@push('scripts')
    <script src="{{ asset('public/assets/js/candidate/candidate.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.expand_collapse_filter').on('click', function() {
                $(".expand_filter").toggle();
            })
        })
        $(document).on('click', '#exportBtn', function() {
            /* // var startDate = $('#daterange').data('daterangepicker').startDate;
             // var endDate = $('#daterange').data('daterangepicker').endDate;
             // var status = $('#is_active').val();
             // var search = $('.dataTables_filter input[type="search"]').val();
             // startDate = startDate.format('YYYY-MM-DD');
             // endDate = endDate.format('YYYY-MM-DD');
             // $('#exportSub #startDate').val(startDate);
             // $('#exportSub #endDate').val(endDate);
             // $('#exportSub #status').val(status);
             // $('#exportSub #search').val(search);*/
            $('#exportCandidateListing').submit();
        })
    </script>
@endpush
