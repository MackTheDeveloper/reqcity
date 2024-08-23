@extends('admin.layouts.master')
@section('title','Users')
@section('content')
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper justify-content-between">
                        <div class="page-title-heading">
                            <div>
                                <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa fa-users opacity-6"></i>
                                    </span>
                                    <span class="d-inline-block" >Users</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="javascript:void(0);">Recruiter Portal</a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitch1">
                          <label class="custom-control-label" for="customSwitch1">Card View</label>
                        </div>
                    </div>
                </div>
                                              
               
                <div class="company-portal-card new-to-old">
                  <div class="a-z-links">
                    <a href="">#</a>
                    <a href="">A</a>
                    <a href="">B</a>
                    <a href="">C</a>
                    <a href="">D</a>
                    <a href="">E</a>
                    <a href="">F</a>
                    <a href="">G</a>
                    <a href="">H</a>
                    <a href="">I</a>
                    <a href="">J</a>
                    <a href="">K</a>
                    <a href="">L</a>
                    <a href="">M</a>
                    <a href="">N</a>
                    <a href="">O</a>
                    <a href="">P</a>
                    <a href="">Q</a>
                    <a href="">R</a>
                    <a href="">S</a>
                    <a href="">T</a>
                    <a href="">U</a>
                    <a href="">V</a>
                    <a href="">W</a>
                    <a href="">X</a>
                    <a href="">Y</a>
                    <a href="">Z</a>
                  </div>
                  <div class="cpc-card withot-img">
                    <div class="this-content">
                      <p class="tl">Cara Bedford</p>
                      <div class="number-email-add">
                        <p>+1 234 567 8901</p>
                        <p>recruiter@domain.com</p>
                        <p>2327 16th Ave, Hillside, IL 60142, United States</p>
                      </div>
                      <div class="last-data">
                        <div class="job-table-data">
                          <div class="jtd-wrapper">
                            <label class="ll">$468.00</label>
                            <span class="bs blur-color">Total Payout</span>
                          </div>
                        </div>
                        <div class="job-table-data">
                          <div class="jtd-wrapper">
                            <label class="ll">$63.00</label>
                            <span class="bs blur-color">Amount Due</span>
                          </div>
                        </div>
                        <div class="job-table-data">
                          <div class="jtd-wrapper">
                            <label class="ll">17</label>
                            <span class="bs blur-color">Approved <br> Candidates</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="blur-color tk">RC1532</p>
                  </div>
                  <div class="cpc-card withot-img">
                    <div class="this-content">
                      <p class="tl">Cara Bedford</p>
                      <div class="number-email-add">
                        <p>+1 234 567 8901</p>
                        <p>recruiter@domain.com</p>
                        <p>2327 16th Ave, Hillside, IL 60142, United States</p>
                      </div>
                      <div class="last-data">
                        <div class="job-table-data">
                          <div class="jtd-wrapper">
                            <label class="ll">$468.00</label>
                            <span class="bs blur-color">Total Payout</span>
                          </div>
                        </div>
                        <div class="job-table-data">
                          <div class="jtd-wrapper">
                            <label class="ll">$63.00</label>
                            <span class="bs blur-color">Amount Due</span>
                          </div>
                        </div>
                        <div class="job-table-data">
                          <div class="jtd-wrapper">
                            <label class="ll">17</label>
                            <span class="bs blur-color">Approved <br> Candidates</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="blur-color tk">RC1532</p>
                  </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
@endsection

@push('scripts')
<script src="{{asset('public/assets/custom/datatables/user/user-list-datatable.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.expand_collapse_filter').on('click', function() {
            $(".expand_filter").toggle();
        })
    })
</script>
@endpush
